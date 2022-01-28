<?php	
	session_start();
	
	require_once "../../classes/session.php";
	require_once "../../classes/package_bd.class";
	require_once "../../classes/html.class";
	require_once "../../classes/getElement.class";
	require_once "../../classes/forms.class";
	require_once "../../includes/include_geral.inc.php";
	require_once "../../includes/include_geral_II.inc.php";
	
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
	print "<BR><B>".TRANS('TTL_CHECK_LIST')."</B><BR>";
	

	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new cadastroCheckList($banco,$_REQUEST);
	$geraHeader->getEndHtml();

	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	

	class cadastroCheckList
	{
		var $tit_checkList;
		var $desc_checkList;
		var $status;
		var $acao;	
		var $controle;
		var $botao;
		var $cod;
		
		function cadastroCheckList(&$DB,&$requests)
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
			$this->tit_checkList  =  "";
			$this->desc_checkList = "";
			$this->status_id 	= "";
			$this->status 	= "";
			$this->acao 		= "";
			$this->cod 		= "";
			$this->controle 	= "";
			$this->botao 		= "";		
		}
		
		function setaPropriedades()
		{
			if (isset($this->REQUESTS['cod'])){$this->cod = $this->REQUESTS['cod'];}		
			if (isset($this->REQUESTS['acao'])){$this->acao = $this->REQUESTS['acao'];}
			if (isset($this->REQUESTS['botao'])){$this->botao = $this->REQUESTS['botao'];}
			if (isset($this->REQUESTS['controle'])){$this->controle  = $this->REQUESTS['controle'];}		
			if (isset($this->REQUESTS['tit_checkList'])){$this->tit_checkList  = $this->REQUESTS['tit_checkList'];}	
			if (isset($this->REQUESTS['desc_checkList'])){$this->desc_checkList  = $this->REQUESTS['desc_checkList'];}	
			if (isset($this->REQUESTS['status_id'])){$this->status_id = str_replace("sta","",$this->REQUESTS['status_id']);}	
			if (isset($this->REQUESTS['status'])){$this->status  = $this->REQUESTS['status'];}	
			
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
				break;
				case "INC_CAD":
					
					$this->formularioCadastro();
				break;				
				case "ALTER":
					
					$this->alterarDados();
				break;
				default:
				//print "teste";
				
				$this->listagemPrincipal();					
				break;
			}		
		}
		
		function formularioCadastro()
		{		
			$bloqueio = false;
			
			print "<B>".TRANS('SUBTTL_CHECK_LIST').":<br><br>";
			print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('COL_CHECK_LIST').":<font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('tit_checkList', $this->tit_checkList, 50, 25,  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('MNL_CHECK_LIST').":<font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getTextArea('desc_checkList',$this->desc_checkList, 55, 5,  $bloqueio)."</TD>";
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
		*formulário Alterar Valores
		*formulário para efetuar alteração nos valores
		*@return void
		*/
		function alterarDados()
		{	
			$bloqueio = false;
			$exec = $this->retornaDadosAlter();
			$rowAlter = mysql_fetch_array($exec);
			
			print $_GET['cod'];
		
			print "<B>".TRANS('SUBTTL_CHECK_LIST').":<br><br>";
			print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<TD >".$this->forms->getHidden( 'cod',$this->cod )."</TD>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('COL_CHECK_LIST').":<font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('tit_checkList', $rowAlter['tit_checkList'], 50, 25,  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('MNL_CHECK_LIST').":<font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getTextArea('desc_checkList',$rowAlter['desc_checkList'], 55, 5,  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."' valign='top'>".TRANS('OCO_STATUS').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('status_id', 'sta'.$rowAlter['status_id'], $this->retornaStatus(), '', "Selecione o status",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gravar'></td>"
				."<input class='button' type='hidden' name='acao' value='ALT_CAD'>";
			print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
			print "</table>";
			print "</form>";
		}
		
		/*
		* listagemPrincipal()
		* Lista as informações da Tabela Tipo de Atendimento
		*/
		function listagemPrincipal()
		{
			print "<td><a href='".$_SERVER['PHP_SELF']."?acao=INC_CAD'>Incluir Cadastro</a></td><br>";
			
			$resultado = $this->buscaCheckList();
			if (mysql_numrows($resultado) == 0){
				echo mensagem(TRANS('TXT_NO_CHECK_LIST'));
			}else{
				$linhas = mysql_numrows($resultado);
				print "<td class='line'>";
				
				print "<BR>".TRANS('THERE_IS_ARE')." <b><font color='red'>".$linhas."</font></b> ".TRANS('TXT_IS_CHECK_LIST')."<br>";
				print "<TABLE border='0' cellpadding='5' cellspacing='0'  width='20%'>";
				print "<TR class='header'><td class='line'>".TRANS('COL_CHECK_LIST')."</TD>"
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
					print "<td class='line'>".$row['tit_checkList']."</TD>";
					print "<td class='line'>".strtoupper($status)."</TD>";
					print "<td class='line'><a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=ALTER&cod=".$row['id_checkList']."')\"><img height='16' width='16' src='".ICONS_PATH."edit.png' title='".TRANS('HNT_EDIT')."'></a></TD>";
					print "</TR>";
				}
				print "</TABLE>";
			}
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
			if ($this->tit_checkList == ""){
				print "<script>mensagem('O campo TÍTULO DA CHECK LIST, deve ser PREENCHIDO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}
			if ($this->desc_checkList == ""){
				print "<script>mensagem('O campo DESCRIÇÃO, deve ser PREENCHIDO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}
			if ($this->status_id == ""){
				print "<script>mensagem('O campo STATUS, deve ser INFORMATO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}
			return $retorno;
		}
		
		/*
		*retornaDadosAlter
		*função para retornar os dados para a alteração dos registros
		*@return void
		*/
		function retornaDadosAlter()
		{
			$qry = "SELECT * FROM checkList WHERE id_checkList = ".$_GET['cod']."";
			$resultado = mysql_query($qry);
			return $resultado;
		}
		
		/*
		* buscaCheckList()
		* Busca as informações da Tabela Tipo de Atendimento
		*/
		function buscaCheckList()
		{
			$sql = " SELECT *
					FROM checkList";
				$resultado = mysql_query($sql);
			return $resultado;
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

		/**
		* armazenaDados
		* Função para armazenar dados
		*
		*/
		function armazenaDados()
		{
			$sql = "INSERT INTO checkList (tit_checkList, desc_checkList, status_id) "
				."\n VALUES ('".$this->tit_checkList."', '".$this->desc_checkList."','".$this->status_id."')";
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
			$sql = "UPDATE  checkList SET tit_checkList = '".$this->tit_checkList."',   desc_checkList = '".$this->desc_checkList."' "
				."\n ,  status_id = '".$this->status_id."' "
				."\n WHERE id_checkList  = '".$this->cod."'";
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