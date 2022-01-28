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
	print "<BR><B>".TRANS('TTL_NOTA_AVAL')."</B><BR>";
	
	###### ESTE BLOCO INICIA OS HEADERS (CABEÇALHO) DO SISTEMA ######
	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new notaAval($banco,$_REQUEST);
	$geraHeader->getEndHtml();
	
	#################################################
	
	###### ESTE BLOCO VERIFICA AS PERMISSÕES DO USUÁRIO
	###### E INICIALIZA AS PERMISSÕES PARA ACESSO AO BANCO DE DADOS
	
	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	
	############################################################
	
		class notaAval
	{
		var $nota_aval;
		var $cod;
		var $status;
		var $acao;	
		var $controle;
		var $botao;
	
	
		function notaAval(&$DB,&$requests)
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
			$this->nota_aval =  "";
			$this->cod 	= 	"";
			$this->status_id 	= "";
			$this->acao =       "";
			$this->controle =   "";
			$this->botao =      "";		
		}
		
		function setaPropriedades()
		{
			if (isset($this->REQUESTS['acao'])){$this->acao = $this->REQUESTS['acao'];}
			if (isset($this->REQUESTS['botao'])){$this->botao = $this->REQUESTS['botao'];}
			if (isset($this->REQUESTS['controle'])){$this->controle  = $this->REQUESTS['controle'];}		
			if (isset($this->REQUESTS['nota_aval'])){$this->nota_aval  = $this->REQUESTS['nota_aval'];}	
			if (isset($this->REQUESTS['cod'])){$this->cod = $this->REQUESTS['cod'];}
			if (isset($this->REQUESTS['status_id'])){$this->status_id = str_replace("sta","",$this->REQUESTS['status_id']);}			
			
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
			print "<td><a href='".$_SERVER['PHP_SELF']."?acao=INC_CAD'>".TRANS('SUBTIT_TYPE_CADASTRO')."</a></td><br>";
			$resultado = $this->buscaNotaAval();
			if (mysql_numrows($resultado) == 0){
				echo mensagem(TRANS('TXT_NO_NOTA'));
			}else{
				$linhas = mysql_numrows($resultado);
				print "<td class='line'>";
				
				print "<BR>".TRANS('THERE_IS_ARE')." <b><font color='red'>".$linhas."</font></b> ".TRANS('TXT_TYPE_NOTAS')."<br>";
				print "<TABLE border='0' cellpadding='5' cellspacing='0'  width='20%'>";
				print "<TR class='header'><td class='line'>".TRANS('OCO_NOTA_AVAL')."</TD>"
					."\n <td class='line'><b>".TRANS('OCO_STATUS')."</TD> <td class='line'><b>".TRANS('OCO_FIELD_ALTER')."</b></TD>";
				$j=2;
				while ($row=mysql_fetch_array($resultado)){
					if ($j % 2){
						$trClass = "lin_par";
					}else{
						$trClass = "lin_impar";
					}
					$j++;
					
					if ($row['status_id'] == 1){
						$status="<font color=green>Ativo</font>";
					}elseif($row['status_id'] == 2){
						$status="<b><font color=red>Inativo</font></b>";
					}	
					
					print "<tr class=".$trClass." id='linhax".$j."' onMouseOver=\"destaca('linhax".$j."','".$_SESSION['s_colorDestaca']."');\" onMouseOut=\"libera('linhax".$j."');\"  onMouseDown=\"marca('linhax".$j."','".$_SESSION['s_colorMarca']."');\">";
					print "<td class='line'>".$row['nota_aval']."</TD>";
					print "<td class='line'>".strtoupper($status)."</TD>";

					print "<td class='line'><a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=ALTER&cod=".$row['nota_aval_id']."')\"><img height='16' width='16' src='".ICONS_PATH."edit.png' title='".TRANS('HNT_EDIT')."'></a></TD>";
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
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TLT_DESC_NOTA').":<font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('nota_aval', $this->nota_aval, 50, 25,  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."' valign='top'>".TRANS('OCO_STATUS').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('status_id', 'sta'.$this->status_id, $this->retornaStatus(), '', "Selecione o status",  $bloqueio)."</TD>";
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
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TLT_DESC_NOTA').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('nota_aval', $rowAlter['nota_aval'], 50, 25,  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."' valign='top'>".TRANS('OCO_STATUS').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('status_id', 'sta'.$rowAlter['status_id'], $this->retornaStatus(), '', "Selecione o status",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gravar'></td>";
				 print $this->forms->getHidden('acao', 'ALT_CAD');
				
			print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
			print "</table>";
			print "</form>";

		}
		
			/*
		*validaCampos()
		*função para a validação dos campos
		*/
		function validaCampos()
		{
			$retorno = true;
			#Valida se todos os campos foram preenchidos
			if ($this->nota_aval == ""){
				print "<script>mensagem('O campo NOTA DE AVALIAÇÃO, deve ser PREENCHIDO!!!.');redirect('$PHP_SELF?acao=INC_CAD')</script>";
				$retorno = false;
			}
			if ($this->status_id == ""){
				print "<script>mensagem('O campo STATUS, deve ser INFORMATO!!!.');redirect('$PHP_SELF')</script>";
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
			$qry = "SELECT * FROM nota_aval WHERE nota_aval_id = ".$_GET['cod']."";
			$resultado = mysql_query($qry);
			return $resultado;
			
		}
		
			/*
		* buscaNotaAval()
		* Busca as informações da Tabela Tipo de Atendimento
		*/
		function buscaNotaAval()
		{
			$sql = " SELECT *
					FROM nota_aval";
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
			
			$sql = "INSERT INTO nota_aval (nota_aval, status_id) "
				."\n VALUES ('".$this->nota_aval."','".$this->status_id."')";
			//dump ($sql);exit;	
			$result = mysql_query($sql);	
			if (!$result) {			
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
			$sql = "UPDATE  nota_aval  SET nota_aval = '".$this->nota_aval."', status_id = '".$this->status_id."' "
				."\n WHERE nota_aval_id = '".$this->cod."'";
				//dump ($sql);exit;	
			$result = mysql_query($sql);	
			if (!$result) {		
				$retorno  = false;
			}
			$retorno = true;
			return $retorno;
			
		}		
	}
 ?>
	
	