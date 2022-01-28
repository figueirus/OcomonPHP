<?php	
	session_start();
	
	##### NESTE BLOCO É INFORMADO OS INCLUDES (REQUIRE) QUE 
	##### SERÃO UTILIZADOS NESTE SCRIPT
	require_once "../../classes/session.php";
	require_once "../../classes/package_bd.class";
	require_once "../../classes/html.class";
	require_once "../../classes/getElement.class";
	require_once "../../classes/forms.class";
	require_once "../../includes/include_geral.inc.php";
	require_once "../../includes/include_geral_II.inc.php";
	###################################
	
	###### INICÍO DA PROGRAMAÇÃO ######
	//TITULO DO SCRIPT
	
	$_SESSION['s_page_admin'] = $_SERVER['PHP_SELF'];
	$cab = new headers;
	print "<HTML>";
	print "<head><script language='JavaScript' src=\"../../includes/javascript/calendar.js\"></script></head>";
	print "<BODY bgcolor=".BODY_COLOR.">";
	
	$texto = TRANS('MENU_TTL_MOD_ADMIN');
	print "<TABLE class='header_centro' cellspacing='1' border='0' cellpadding='1' align='center' width='100%'>".//#5E515B
		"<TR>". 
			"<TD nowrap width='80%'><b>".$texto."</b></td>".
				"<td width='20%' nowrap><p class='parag'><b>".TRANS(date("l")).",&nbsp;".(formatDate(date("Y/m/d H:i"), " %H:%M"))."</b>".$help."</p></TD>";
		print "</TR>".
		"</TABLE>";
	print "<BR><B>".TRANS('TTL_VINC_USER_CC')."</B><BR>";
	
	###### ESTE BLOCO INICIA OS HEADERS (CABEÇALHO) DO SISTEMA ######
	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new vincularUsuarioCentroCusto($banco,$_REQUEST);
	$geraHeader->getEndHtml();
	
	#################################################
	
	###### ESTE BLOCO VERIFICA AS PERMISSÕES DO USUÁRIO
	###### E INICIALIZA AS PERMISSÕES PARA ACESSO AO BANCO DE DADOS
	
	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	
	############################################################

	
	
	class vincularUsuarioCentroCusto
	{
		var $usuario;
		var $centro_custo;
		var $flag_gestor;
		var $status;
		var $cod;
		var $acao;	
		var $controle;
		var $botao;
		
		function vincularUsuarioCentroCusto(&$DB,&$requests)
		{
			$this->REQUESTS = $requests;
			$this->conn = &$DB;
			$this->QRY = new genericQuery($this->conn);			
			$this->forms = new getElement;
			$this->limpaPropriedades();
			$this->setaPropriedades();
			$this->controle();
		}
		
		function limpaPropriedades()
		{
			$this->usuario =  "";
			$this->centro_custo =  "";
			$this->flag_gestor =  "";
			$this->status =  "";
			$this->cod 	= 	"";
			$this->acao =       "";
			$this->controle =   "";
			$this->botao =      "";		
		}
		
		function setaPropriedades()
		{
			if (isset($this->REQUESTS['acao'])){$this->acao = $this->REQUESTS['acao'];}
			if (isset($this->REQUESTS['botao'])){$this->botao = $this->REQUESTS['botao'];}
			if (isset($this->REQUESTS['controle'])){$this->controle  = $this->REQUESTS['controle'];}		
			if (isset($this->REQUESTS['usuario'])){$this->usuario = str_replace("user","",$this->REQUESTS['usuario']);}	
			if (isset($this->REQUESTS['centro_custo'])){$this->centro_custo = str_replace("cc","",$this->REQUESTS['centro_custo']);}				
			if (isset($this->REQUESTS['flag_gestor'])){$this->flag_gestor  = $this->REQUESTS['flag_gestor'];}	
			if (isset($this->REQUESTS['status'])){$this->status = str_replace("sta","",$this->REQUESTS['status']);}	
			if (isset($this->REQUESTS['cod'])){$this->cod = $this->REQUESTS['cod'];}	
			
		}
		
		
		/*
		*controle()
		*controle():controla as interações do programa
		*@return void
		*/
		function controle()
		{			
			GLOBAL $PHP_SELF;
			$PHP_SELF = $_SERVER["SCRIPT_NAME"];				
			switch($this->acao)
			{	
				case "GRAVAR":
					if ($this->validaCampos() === True){
						if ($this->armazenaDados() == false){
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro não foi efetuado.');redirect('$PHP_SELF')</script>";
						}else{
							print "<script language='javaScript'>alert('Registro salvo com sucesso!');redirect('$PHP_SELF')</script>";
						}
					}	
					$this->limpaPropriedades();	
				break;
				case "ALT_CAD":
					if ($this->validaCampos() === True){
						if ($this->alteraDados() == false){
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro não foi efetuado.');redirect('$PHP_SELF')</script>";
						}else{
							print "<script language='javaScript'>alert('Registro salvo com sucesso!');redirect('$PHP_SELF')</script>";
						}
					}	
					$this->limpaPropriedades();
				case "INC_CAD":
					
					$this->formularioCadastro();
				break;
				case "ALTER":
					$this->alteraCadastro();
				
				break;
				default:
				$this->listagemPrincipal();					
				break;
			}		
		}
		
		/*
		* listagemPrincipal()
		* Lista as informações da Tabela Tipo de Atendimento
		*/
		function listagemPrincipal()
		{
			print "<td><a href='".$_SERVER['PHP_SELF']."?acao=INC_CAD'>Incluir Cadastro</a></td><br>";
			$resultado = $this->buscoVinculoUsarioCentroCusto();
			if (mysql_numrows($resultado) == 0){
				echo mensagem(TRANS('MSG_NOT_VINC_USER_CC'));
			}else{
				$linhas = mysql_numrows($resultado);
				print "<td class='line'>";
				
				print "<BR>".TRANS('THERE_IS_ARE')." <b><font color='red'>".$linhas."</font></b> ".TRANS('TXT_VINC_USER_CC')."<br>";
				print "<TABLE border='0' cellpadding='5' cellspacing='0'  width='50%'>";
				print "<TR class='header'><td class='line'>".TRANS('MNS_USUARIO')."</TD>"
					."\n <td class='line'><b>".TRANS('MNL_CC')."</b><td class='line'><b>".TRANS('MNS_GESTOR')."</b></TD><td class='line'><b>".TRANS('OCO_FIELD_ALTER')."</b></TD>";
				$j=2;
				while ($row=mysql_fetch_array($resultado)){
					if ($j % 2){
						$trClass = "lin_par";
					}else{
						$trClass = "lin_impar";
					}
					$j++;
					
					if ($row['flag_gestor'] == '1' ){
						$flag = "<font color=green><b>Sim</b></font>";
						$nome = "<b>".$row['nome']."</b>";
						$centroCusto = "<b>".$row['codccusto']." - ".$row['descricao']."</b>";
					}else{
						$flag = "<font color=red><b>Não</b></font>";
						$nome = $row['nome'];
						$centroCusto = $row['codccusto']." - ".$row['descricao'];
					}

					print "<tr class=".$trClass." id='linhax".$j."' onMouseOver=\"destaca('linhax".$j."','".$_SESSION['s_colorDestaca']."');\" onMouseOut=\"libera('linhax".$j."');\"  onMouseDown=\"marca('linhax".$j."','".$_SESSION['s_colorMarca']."');\">";
					print "<td class='line'>".$nome."</TD>";
					print "<td class='line'>".$centroCusto."</TD>";
					print "<td class='line'>".$flag."</TD>";

					print "<td class='line'><a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=ALTER&cod=".$row['vinc_id']."')\"><img height='16' width='16' src='".ICONS_PATH."edit.png' title='".TRANS('HNT_EDIT')."'></a></TD>";
					//print "<td class='line'><a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=ALTER&cod=".$row['prod_id']."')\"><img height='16' width='16' src='".ICONS_PATH."edit.png' title='".TRANS('HNT_EDIT')."'></a></TD>";
					print "</TR>";
				}
				print "</TABLE>";
			}
		}
		
		/*
		* formularioCadastro()
		* Formulário de cadastro
		*/
		function formularioCadastro()
		{		
			GLOBAL $PHP_SELF;
			GLOBAl $SISCONF;
			$bloqueio = false;
			
			print "<B>".TRANS('SUBTIT_TYPE_CADASTRO').":<br><br>";
			print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('MNS_USUARIO').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('usuario', 'user'.$this->usuario, $this->buscaUsuarios(), '', "Selecione o usuário",  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('MNL_CC').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('centro_custo', 'cc'.$this->centro_custo, $this->buscaCentroCusto(), '', "Selecione o centro de custo",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('MNS_GESTOR').":  <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'> Sim".$this->forms->getRadio('flag_gestor','sim','', false, $bloqueio)." "
					."\n Não".$this->forms->getRadio('flag_gestor','não','', false, $bloqueio)."</TD>";
			print "</tr>";
		
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gravar'></td>"
				."<input class='button' type='hidden' name='acao' value='GRAVAR'>";
			print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
			print "</table>";
			print "</form>";
			
		}
		
		/*
		* alteraCadastro()
		* Formulário para alterar de cadastro
		*/
		function alteraCadastro()
		{		
			$exec = $this->retornaDadosAlter();
			$rowAlter = mysql_fetch_array($exec);
			$bloqueio = false;
			
			print "<B>".TRANS('SUBTIT_TYPE_CADASTRO').":<br><br>";
			print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<TD >".$this->forms->getHidden( 'cod',$_GET['cod'])."</TD>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TLT_DESC_ATEND').":</TD>";
			//print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('usuario', $rowAlter['desc_atend'], 50, 25,  $bloqueio)."</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('usuario', 'user'.$rowAlter['user_id'], $this->buscaUsuarios(), '', "Selecione o usuário",  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('MNL_CC').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('centro_custo', 'cc'.$rowAlter['centro_custo'], $this->buscaCentroCusto(), '', "Selecione o centro de custo",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_FLAG_ATEND').":</TD>";
			if ($rowAlter['flag_gestor'] == '1'){
					$SIM = $this->forms->getRadio('flag_gestor','sim', '', true, false, $bloqueio);
					$NÃO =  $this->forms->getRadio('flag_gestor','não','', false, false, $bloqueio);
				}elseif($rowAlter['flag_gestor'] == '0'){
					$SIM = $this->forms->getRadio('flag_gestor','sim','', false, false, $bloqueio);
					$NÃO = $this->forms->getRadio('flag_gestor','não','',true, false, $bloqueio);
				}
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'> Sim".$SIM." "
					."\n Não".$NÃO."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."' valign='top'>".TRANS('OCO_STATUS').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('status', 'sta'.$rowAlter['status'], $this->retornaStatus(), '', "Selecione o status",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gravar'></td>";
				 print $this->forms->getHidden('acao', 'ALT_CAD');
				
			print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
			print "</table>";
			print "</form>";
			
		}
		
		/*
		*validaCampos()
		*
		*função para a validação dos campos
		*/
		function validaCampos()
		{
			$retorno = true;
			#Valida se todos os campos foram preenchidos
			if ($this->usuario == ""){
				print "<script>mensagem('O campo USUÁRIO, deve ser INFORMADO!!!.');redirect('$PHP_SELF?acao=INC_CAD')</script>";
				$retorno = false;
			}
			if ($this->centro_custo == ""){
				print "<script>mensagem('O campo CENTRO DE CUSTO, deve ser INFORMADO!!!.');redirect('$PHP_SELF?acao=INC_CAD')</script>";
				$retorno = false;
			}
			if ($this->flag_gestor == ""){
				print "<script>mensagem('O campo REQUER AVALIAÇÃO, deve ser INFORMADO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}
				
			return $retorno;
		}
		
		/*
		*retornaStatus()
		* Função que retorno os status
		*@return void
		*/
		function retornaStatus()
		{
			$chave = "";
			$status = array();
			$sql = "SELECT * FROM status_geral";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["status"]);
				$chave = "sta".$linha["status_id"];
				$status[$chave] = $descricao;
			}
			return $status;
		}
		
		/*
		*retornaDadosAlter
		*função para retornar os dados para a alteração dos registros
		*@return void
		*/
		function retornaDadosAlter()
		{
			$qry = "SELECT * FROM usuarioXcentro_custo WHERE vinc_id = ".$_GET['cod']."";
			$resultado = mysql_query($qry);
			return $resultado;
		}
		
		/*
		*buscaUsuarios
		*função para buscar os nomes dos usuarios
		*@return void
		*/
		function buscaUsuarios()
		{
			$chave = "";
			$usuario = array();
			$sql = "SELECT user_id, nome, login  FROM usuarios WHERE nivel in (1,2,3) ORDER BY nome";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["nome"]);
				$chave = "user".$linha["user_id"];
				$usuario[$chave] = $descricao." - ".$linha['login'];
			}
			return $usuario;
		}
		
		/*
		*buscaCentroCusto
		*função para buscar os nomes dos centros de custos
		*@return void
		*/
		function buscaCentroCusto()
		{
			$chave = "";
			$centroCusto = array();
			$sql = "SELECT *  FROM CCUSTO";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["descricao"]);
				$chave = "cc".$linha["codigo"];
				$centroCusto[$chave] = $descricao." - ". $linha['codccusto'];
			}
			return $centroCusto;
		}
				
		/*
		* buscoVinculoUsarioCentroCusto()
		* Busca as informações da tabela de vinculos de usuários
		* aos centros de custo
		*/
		function buscoVinculoUsarioCentroCusto()
		{
			$sql = " SELECT user.user_id, user.nome, cc.*, vinc.flag_gestor, vinc.vinc_id
					FROM usuarios user, usuarioXcentro_custo vinc, CCUSTO cc
					WHERE user.user_id = vinc.user_id
					AND cc.codigo = vinc.centro_custo
					AND vinc.status = 1";
			$resultado = mysql_query($sql);
			return $resultado;
		}
		
		/**
		* armazenaDados
		* Função para armazenar dados
		*
		*/
		function armazenaDados()
		{
			if ($this->flag_gestor == 'sim'){
				$flag = '1';
			}else	{
				$flag = '0';
			}
			$sql = "INSERT INTO usuarioXcentro_custo (user_id, centro_custo, flag_gestor, status) "
				."\n VALUES ('".$this->usuario."', '".$this->centro_custo."', '".$flag."', '1')";
				//dump ($sql);exit;	
			$result = mysql_query($sql);	
			if (!$result) {
				//array_push($this->erro, mysql_error());				
				$retorno  = false;
			}
			$retorno = true;
				
			return $retorno;
		}

		/**
		* alteraDados
		* Função para alterar dados
		*
		*/
		function alteraDados()
		{
			if ($this->flag_gestor == 'sim'){
				$flag = '1';
			}else	{
				$flag = '0';
			}
			$sql = "UPDATE  usuarioXcentro_custo SET user_id = '".$this->usuario."',  centro_custo = '".$this->centro_custo."',  flag_gestor = '".$flag."', status = '".$this->status."' "
				."\n WHERE vinc_id  = '".$this->cod."'";
				//dump ($sql);exit;	
			$result = mysql_query($sql);	
			if (!$result) {
				//array_push($this->erro, mysql_error());				
				$retorno  = false;
			}
			$retorno = true;
			return $retorno;
		}		
    }
	
	
?>