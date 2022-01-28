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
	
	$texto = TRANS('MENU_TTL_MOD_OCCO');
	print "<TABLE class='header_centro' cellspacing='1' border='0' cellpadding='1' align='center' width='100%'>".//#5E515B
		"<TR>". 
			"<TD nowrap width='80%'><b>".$texto."</b></td>".
				"<td width='20%' nowrap><p class='parag'><b>".TRANS(date("l")).",&nbsp;".(formatDate(date("Y/m/d H:i"), " %H:%M"))."</b>".$help."</p></TD>";
		print "</TR>".
		"</TABLE>";
	//print "<BR><B>".TRANS('TTL_CHECK_LIST')."</B><BR>";
	

	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new mostraCheckList($banco,$_REQUEST);	
	$geraHeader->getEndHtml();

	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	

	class mostraCheckList
	{
		var $desc_checkList;
		var $acao;	
		var $controle;
		var $botao;
		var $cod;
		
		function mostraCheckList(&$DB,&$requests)
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
			$this->desc_checkList = "";
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
			if (isset($this->REQUESTS['desc_checkList'])){$this->desc_checkList  = $this->REQUESTS['desc_checkList'];}	
			
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
				case "EXIBIR":
					$this->exibeCheckList();
				break;
				default:
					$busca = $this->buscaCheckList();
					if (mysql_numrows($busca) == 1){
						$check = mysql_fetch_array($busca);
						$_GET['cod'] = $check['id_checkList'];
						$this->exibeCheckList();
					}else{
						$this->listagemPrincipal();					
					}
				break;
			}		
		}
		
		/*
		* listagemPrincipal()
		* Lista as informações da Tabela de Check List
		*/
		function listagemPrincipal()
		{
			$resultado = $this->buscaCheckList();
			if (mysql_numrows($resultado) == 0){
				echo mensagem(TRANS('TXT_NO_CHECK_LIST'));
			}else{
				$linhas = mysql_numrows($resultado);
				print "<td class='line'>";
				
				print "<BR>".TRANS('THERE_IS_ARE')." <b><font color='red'>".$linhas."</font></b> ".TRANS('TXT_ACTIVE_CHECK_LIST')."<br>";
				print "<TABLE border='0' cellpadding='5' cellspacing='0'  width='60%'>";
				print "<TR class='header'><td class='line'>".TRANS('COL_CHECK_LIST')."</TD>"
					."\n <td class='line'><b>".TRANS('OCO_STATUS')."</TD> <td class='line'><b>".TRANS('TXT_EXIBIR')."</b></TD>";
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
					print "<td class='line'><a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=EXIBIR&cod=".$row['id_checkList']."')\"><img height='16' width='16' src='".ICONS_PATH."utilities.png' title='".TRANS('HNT_EDIT')."'></a></TD>";
					print "</TR>";
				}
				print "</TABLE>";
			}
		
		}	
		
		/*
		* exibeCheckList()
		* Lista as informações da Check List
		*/
		function exibeCheckList()
		{
			$resultado = $this->buscaDadosCheckList();
			if (mysql_numrows($resultado) == 0){
				echo mensagem(TRANS('TXT_NO_ACT_CHECK_LIST'));
			}else{
				$linhas = mysql_numrows($resultado);
				$row=mysql_fetch_array($resultado);
				print "<td class='line'>";
				print "<TABLE border='0' cellpadding='5' cellspacing='0'  width='100%'>";
				print "<TR class='header'><td class='line'>".TRANS('TXT_ACT_CHECK_LIST').": ".$row['tit_checkList']."</TD></TR>";
				
				print "<tr>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getTextArea('desc_checkList',$row['desc_checkList'], 65,28,  true)."</TD>";
				print "</tr>";
				print "</TR>";
				print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_BACK')."' onclick=\"javascript:history.back()\"></td></tr>";
				print "</TABLE>";
			}
		}
		
		/*
		*buscaDadosCheckList
		*função para retornar os dados para a alteração dos registros
		*@return void
		*/
		function buscaDadosCheckList()
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
			$sql = " SELECT * FROM checkList WHERE status_id = 1";
				$resultado = mysql_query($sql);
			return $resultado;
		}
				
    }
	
	
?>