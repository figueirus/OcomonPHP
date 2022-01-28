<?php	
	session_start();
	
	##### NESTE BLOCO � INFORMADO OS INCLUDES (REQUIRE) QUE 
	##### SER�O UTILIZADOS NESTE SCRIPT
	require_once "../../classes/session.php";
	require_once "../../classes/package_bd.class";
	require_once "../../classes/html.class";
	require_once "../../classes/getElement.class";
	require_once "../../classes/forms.class";
	require_once "../../includes/include_geral.inc.php";
	require_once "../../includes/include_geral_II.inc.php";
	###################################
	
	###### INIC�O DA PROGRAMA��O ######
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
	print "<BR><B>".TRANS('TTL_VINC_USER_INST')."</B><BR>";
	
	###### ESTE BLOCO INICIA OS HEADERS (CABE�ALHO) DO SISTEMA ######
	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new vincularUsuarioInstituicao($banco,$_REQUEST);
	$geraHeader->getEndHtml();
	
	#################################################
	
	###### ESTE BLOCO VERIFICA AS PERMISS�ES DO USU�RIO
	###### E INICIALIZA AS PERMISS�ES PARA ACESSO AO BANCO DE DADOS
	
	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	
	############################################################

	
	
	class vincularUsuarioInstituicao
	{
		var $usuario;
		var $instituicao;
		var $flag_gestor;
		var $status;
		var $cod;
		var $acao;	
		var $controle;
		var $botao;
		
		function vincularUsuarioInstituicao(&$DB,&$requests)
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
			$this->instituicao =  "";
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
			if (isset($this->REQUESTS['instituicao'])){$this->instituicao = str_replace("inst","",$this->REQUESTS['instituicao']);}				
			if (isset($this->REQUESTS['flag_gestor'])){$this->flag_gestor  = $this->REQUESTS['flag_gestor'];}	
			if (isset($this->REQUESTS['status'])){$this->status = str_replace("sta","",$this->REQUESTS['status']);}	
			if (isset($this->REQUESTS['cod'])){$this->cod = $this->REQUESTS['cod'];}	
			
		}
		
		
		/*
		*controle()
		*controle():controla as intera��es do programa
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
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro n�o foi efetuado.');redirect('$PHP_SELF')</script>";
						}else{
							print "<script language='javaScript'>alert('Registro salvo com sucesso!');redirect('$PHP_SELF')</script>";
						}
					}	
					$this->limpaPropriedades();	
				break;
				case "ALT_CAD":
					if ($this->validaCampos() === True){
						if ($this->alteraDados() == false){
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro n�o foi efetuado.');redirect('$PHP_SELF')</script>";
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
		* Lista as informa��es da Tabela Tipo de Atendimento
		*/
		function listagemPrincipal()
		{
			print "<td><a href='".$_SERVER['PHP_SELF']."?acao=INC_CAD'>Incluir Cadastro</a></td><br>";
			$resultado = $this->buscoVinculoUsarioInstituicao();
			if (mysql_numrows($resultado) == 0){
				echo mensagem(TRANS('MSG_NOT_VINC_USER_INST'));
			}else{
				$linhas = mysql_numrows($resultado);
				print "<td class='line'>";
				
				print "<BR>".TRANS('THERE_IS_ARE')." <b><font color='red'>".$linhas."</font></b> ".TRANS('TXT_VINC_USER_INST')."<br>";
				print "<TABLE border='0' cellpadding='5' cellspacing='0'  width='50%'>";
				print "<TR class='header'><td class='line'>".TRANS('MNS_USUARIO')."</TD>"
					."\n <td class='line'><b>".TRANS('FIELD_INSTITUTION')."</b><td class='line'><b>".TRANS('MNS_GESTOR')."</b></TD><td class='line'><b>".TRANS('OCO_FIELD_ALTER')."</b></TD>";
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
						$nome = "<b>".$row['nome']." - ".$row['login']."</b>";
						$instituicao = "<b>".$row['inst_nome']."</b>";
					}else{
						$flag = "<font color=red><b>N�o</b></font>";
						$nome = $row['nome']." - ".$row['login']."</b>";
						$instituicao = $row['inst_nome'];
					}

					print "<tr class=".$trClass." id='linhax".$j."' onMouseOver=\"destaca('linhax".$j."','".$_SESSION['s_colorDestaca']."');\" onMouseOut=\"libera('linhax".$j."');\"  onMouseDown=\"marca('linhax".$j."','".$_SESSION['s_colorMarca']."');\">";
					print "<td class='line'>".$nome."</TD>";
					print "<td class='line'>".$instituicao."</TD>";
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
		* Formul�rio de cadastro
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
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('usuario', 'user'.$this->usuario, $this->buscaUsuarios(), '', "Selecione o usu�rio",  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('FIELD_INSTITUTION').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('instituicao', 'inst'.$this->instituicao, $this->buscaInstituicao(), '', "Selecione a institui��o",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('MNS_GESTOR').":  <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'> Sim".$this->forms->getRadio('flag_gestor','sim','', false, $bloqueio)." "
					."\n N�o".$this->forms->getRadio('flag_gestor','n�o','', false, $bloqueio)."</TD>";
			print "</tr>";
		
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gravar'></td>"
				."<input class='button' type='hidden' name='acao' value='GRAVAR'>";
			print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
			print "</table>";
			print "</form>";
			
		}
		
		/*
		* alteraCadastro()
		* Formul�rio para alterar de cadastro
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
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('usuario', 'user'.$rowAlter['user_id'], $this->buscaUsuarios(), '', "Selecione o usu�rio",  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('FIELD_INSTITUTION').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('instituicao', 'inst'.$rowAlter['inst_cod'], $this->buscaInstituicao(), '', "Selecione a institui��o",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('MNS_GESTOR').":</TD>";
			if ($rowAlter['flag_gestor'] == '1'){
					$SIM = $this->forms->getRadio('flag_gestor','sim', '', true, false, $bloqueio);
					$N�O =  $this->forms->getRadio('flag_gestor','n�o','', false, false, $bloqueio);
				}elseif($rowAlter['flag_gestor'] == '0'){
					$SIM = $this->forms->getRadio('flag_gestor','sim','', false, false, $bloqueio);
					$N�O = $this->forms->getRadio('flag_gestor','n�o','',true, false, $bloqueio);
				}
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'> Sim".$SIM." "
					."\n N�o".$N�O."</TD>";
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
		*fun��o para a valida��o dos campos
		*/
		function validaCampos()
		{
			$retorno = true;
			#Valida se todos os campos foram preenchidos
			if ($this->usuario == ""){
				print "<script>mensagem('O campo USU�RIO, deve ser INFORMADO!!!.');redirect('$PHP_SELF?acao=INC_CAD')</script>";
				$retorno = false;
			}
			if ($this->instituicao == ""){
				print "<script>mensagem('O campo CENTRO DE CUSTO, deve ser INFORMADO!!!.');redirect('$PHP_SELF?acao=INC_CAD')</script>";
				$retorno = false;
			}
			if ($this->flag_gestor == ""){
				print "<script>mensagem('O campo REQUER AVALIA��O, deve ser INFORMADO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}
				
			return $retorno;
		}
		
		/*
		*retornaStatus()
		* Fun��o que retorno os status
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
		*fun��o para retornar os dados para a altera��o dos registros
		*@return void
		*/
		function retornaDadosAlter()
		{
			$qry = "SELECT * FROM usuarioXinstituicao WHERE vinc_id = ".$_GET['cod']."";
			$resultado = mysql_query($qry);
			return $resultado;
		}
		
		/*
		*buscaUsuarios
		*fun��o para buscar os nomes dos usuarios
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
		*fun��o para buscar os nomes dos centros de custos
		*@return void
		*/
		function buscaInstituicao()
		{
			$chave = "";
			$instituicao = array();
			$sql = "SELECT *  FROM instituicao ORDER BY inst_nome";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha['inst_nome']);
				$chave = "inst".$linha['inst_cod'];
				$instituicao[$chave] = $descricao;
			}
			return $instituicao;
		}
				
		/*
		* buscoVinculoUsarioCentroCusto()
		* Busca as informa��es da tabela de vinculos de usu�rios
		* aos centros de custo
		*/
		function buscoVinculoUsarioInstituicao()
		{
			$sql = " SELECT user.user_id, user.nome, user.login, inst.*, vinc.flag_gestor, vinc.vinc_id
					FROM usuarios user, usuarioXinstituicao vinc, instituicao inst
					WHERE user.user_id = vinc.user_id
					AND inst.inst_cod = vinc.inst_cod
					AND vinc.status = 1
					ORDER BY inst_nome";
			$resultado = mysql_query($sql);
			return $resultado;
		}
		
		/**
		* armazenaDados
		* Fun��o para armazenar dados
		*
		*/
		function armazenaDados()
		{
			if ($this->flag_gestor == 'sim'){
				$flag = '1';
			}else	{
				$flag = '0';
			}
			$sql = "INSERT INTO usuarioXinstituicao (user_id, inst_cod, flag_gestor, status) "
				."\n VALUES ('".$this->usuario."', '".$this->instituicao."', '".$flag."', '1')";
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
		* Fun��o para alterar dados
		*
		*/
		function alteraDados()
		{
			if ($this->flag_gestor == 'sim'){
				$flag = '1';
			}else	{
				$flag = '0';
			}
			$sql = "UPDATE  usuarioXinstituicao SET user_id = '".$this->usuario."',  inst_cod = '".$this->instituicao."',  flag_gestor = '".$flag."', status = '".$this->status."' "
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