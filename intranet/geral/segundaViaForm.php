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
	require_once "../../classes/funcoes.php";
	###################################
	
	##### INÍCIO CABEÇALHO DO SISTEMA #####
	print "<link rel='stylesheet' href='../../includes/css/calendar.css.php' media='screen'></LINK>";
	$_SESSION['s_page_admin'] = $_SERVER['PHP_SELF'];
	$cab = new headers;
	
	$diasemana = array('Domingo','Segunda-feira','Terça-feira','Quarta-feira', 'Quinta-feira','Sexta-feira','Sábado');
	
	print "<HTML>";
	print "<head><script language='JavaScript' src=\"../../includes/javascript/calendar.js\"></script></head>";
	print "<BODY bgcolor=".BODY_COLOR.">";
	
	$texto = "OcoMon - Módulo de Intranet";
	print "<TABLE class='header_centro' cellspacing='1' border='0' cellpadding='1' align='center' width='100%'>".//#5E515B
		"<TR>". 
			"<TD nowrap width='80%'><b>".$texto."</b></td>".
				// "<td width='20%' nowrap><p class='parag'><b>".TRANS(date("l")).",&nbsp;".(formatDate(date("Y/m/d H:i"), " %H:%M"))."</b>".$help."</p></TD>";
				"<td width='20%' nowrap><p class='parag'><b>".$diasemana[date('w')].",&nbsp;".date("d/m/Y H:i")."</b>".$help."</p></TD>";
		print "</TR>".
		"</TABLE>";
	print "<BR><B> 2ª via de formulário</B><BR>";
	
	##### INICIALIZA  A CONSULTA AO TIPO DO FORMULÁRIO ####
	$sqlForm = "SELECT * FROM formularios WHERE form_id = '".$_GET['form']."' ";	
	$result = mysql_query($sqlForm);			
	$linha = mysql_fetch_array($result);	
	
	$sqlCateg = "SELECT cat_nome FROM ramal_categ WHERE cat_id = '".$linha['categ_ramal']."' ";	
	$result = mysql_query($sqlCateg);			
	$linhaCateg = mysql_fetch_array($result);
		
	$sqlOco = $QRY["ocorrencias_full_ini"]." WHERE numero = '".$_GET['numero']."' ";	
	$resultOco = mysql_query($sqlOco);			
	$linhaOco = mysql_fetch_array($resultOco);
	
	$sqlEquip = "SELECT * FROM tipo_equip WHERE tipo_cod = '".$linha['tipo_equip']."' ";
	$execEquip = mysql_query($sqlEquip);
	$linhaEquip =  mysql_fetch_array($execEquip);
	$descricao  = strtoupper ($linhaEquip["tipo_nome"]);
	
	$sqlLic = "SELECT * FROM licencas WHERE lic_cod = '".$linha['tipo_licenca']."' ";
	$execLic = mysql_query($sqlLic);
	$linhaLic =  mysql_fetch_array($execLic);
	$descricaoLic  = strtoupper ($linhaLic["lic_desc"]);
		
	if ($linha['centro_custo'] == 0){
		$centroCusto = "Centro de custo não informado.";
	}else{
		$sqlCC = "SELECT * FROM CCUSTO WHERE codigo = '".$linha['centro_custo']."'";
		$execCC = mysql_query($sqlCC);
		$linhaCC =  mysql_fetch_array($execCC);
		$descricao  = strtoupper ($linhaCC["descricao"]);
		$centroCusto = $descricao." - ".$linhaCC['codccusto'];
	}
	
	$varAux = explode("-", $linha['data_prevista']);
	$dataPrevista = $varAux['2']."/".$varAux['1']."/".$varAux['0'];
	

	$data_orig = date("Y-m-d");
	$separa = substr($data_orig,2,1);
	$conf_data = explode("-","$data_orig");
	$ano = $conf_data[0];
	$mes = $conf_data[1];
	$dia = $conf_data[2];

	$data = "$dia/$mes/$ano";

	
	#### FORMULÁRIO DE INSTAL. DE RAMAL ####
	if ($linha['form_tipo'] == "FormSolicitEquip"){
	
		if ($linha['flag_equip'] == 'adicionar'){
			$objetivo = "Adicionar equipamento ao setor";
		}elseif ($linha['flag_equip']  == 'substituir'){
			$objetivo = "Substituir equip. existente no setor";
		}
		
		print "<body>";
		if($linhaOco['status_cod']!=4){
			print "<br><b><a href=\"javascript:window.print()\"><img src='../../includes/icons/printer1.png' style=\"vertical-align:middle;\" height='32' width='32' border='0'> "
				."\n Clique aqui para imprimir o formulário</a></b> || <b><font color=red> Este documento deverá ser entregue a T.I.</b></font> ";
		}
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='53' colspan='3'> <div align='center'><img src='../../includes/icons/Unilasalle.png' width='270' height='65'></div><br></td>";
		print "</tr>";
		print "<tr align='left' valign='middle'>";
		print "<td width='133' height='34'> <div align='left'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Data: ".$data." </font></strong></div></td>";
		print "<td width='404'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_FORM_SOLICIT_EQUIP')."</font></strong></div></td>";
		print "<td width='149'><strong><font size='2' face='Arial, Helvetica, sans-serif'>No.: ".$linha['form_id']." / ".$linhaOco['numero']."</font></strong></td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'> ";
		print "<td height='18' colspan='3'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_RESP_SOLICIT')."</font></strong></div></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='21' colspan='3'>&nbsp;</td>";
		print "</tr>";
		print "<tr>";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TTL_CENTER_CUST').": ".$centroCusto."</font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_SOLICITANTE').":  <b>".$linhaOco['contato']." </b></b></font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_FORM_RAMAL_SOLICIT').": <b>".$linhaOco['telefone']." </b></font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('FIELD_SECTOR').": ".$linhaOco['setor']." </font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_EQUIP_QTD').": <b>".$linha['qtd_equip']." - ".$descricao."</b>&nbsp;&nbsp;&nbsp;&nbsp; "
			."\n &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp Objetivo: <b>".$objetivo."</b></font></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_JUST')."</font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr valign='top'>";
		print "<td height='100'> <blockquote> <font size='2' face='Arial, Helvetica, sans-serif'><br>  ".$linhaOco['descricao']." </font> </blockquote></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='20'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_DATA_PREV').": ".$dataPrevista."</font></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='40'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_ASS_RESP_SECTOR').":</font></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'><div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_PARECER_TI').":</font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'><br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_DEFERIDO')." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_INDEFERIDO')." <br><br> ".TRANS('TXT_JUST').": 
			<br><br>.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br></font></p>";
		print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
		print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>".TRANS('TXT_T.I')."<br><br></font></p></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>"; 
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_PARECER_DIR_ADM')." </font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'> <br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_DEFERIDO')." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_INDEFERIDO')." <br><br> ".TRANS('TXT_JUST').": 
			<br><br>.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br></font></p>";
		print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
		print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>".TRANS('TXT_DIR_ADM')."<br><br></font></p></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr> ";
		print "<td height='5'><p>&nbsp;</p></td>";
		print "</tr>";
		print "</tr>";
		print "</table>";
		print "</body>";
		print "</body>";
		
	}
	#### FORMULÁRIO DE INSTAL. DE RAMAL ####
	if ($linha['form_tipo'] == "FormInstRamal"){
		print "<body>";
		if($linhaOco['status_cod']!=4){
			print "<br><b><a href=\"javascript:window.print()\"><img src='../../includes/icons/printer1.png' style=\"vertical-align:middle;\" height='32' width='32' border='0'> "
				."\n Clique aqui para imprimir o formulário</a></b> || <b><font color=red> Este documento deverá ser entregue a T.I.</b></font> ";
		}
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='53' colspan='3'> <div align='center'><img src='../../includes/icons/Unilasalle.png' width='270' height='65'></div><br></td>";
		print "</tr>";
		print "<tr align='left' valign='middle'>";
		print "<td width='133' height='34'> <div align='left'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Data: ".$data." </font></strong></div></td>";
		print "<td width='404'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_SOLIC_NEW_RAMAL')."</font></strong></div></td>";
		print "<td width='149'><strong><font size='2' face='Arial, Helvetica, sans-serif'>No.: ".$linhaOco['form_id']." / ".$linhaOco['numero']." </font></strong></td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'> ";
		print "<td height='18' colspan='3'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_RESP_SOLICIT')."</font></strong></div></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='21' colspan='3'>&nbsp;</td>";
		print "</tr>";
		print "<tr>";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TTL_CENTER_CUST').": ".$centroCusto."</font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_SOLICITANTE').": <b>".$linhaOco['contato']." </b></font></td>";
		print "</tr>";
		print "<tr> ";
		//print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_FORM_RAMAL_SOLICIT').": ".$this->ramalSolicit."</font></td>";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_FORM_RAMAL_SOLICIT').": <b> ".$linhaOco['telefone']." </b></font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('FIELD_SECTOR').": ".$linhaOco['setor']." </font></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_JUST')."</font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr valign='top'>";
		print "<td height='80'> <blockquote> <font size='2' face='Arial, Helvetica, sans-serif'><br> ".$linhaOco['descricao']." </font> </blockquote></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='20'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_DATA_PREV').": ".$dataPrevista." </font></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='40'><font size='2' face='Arial, Helvetica, sans-serif'>Assinatura da Diretoria Responsável:</font></td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='5' align='center'><blockquote><font size='2' face='Arial, Helvetica, sans-serif'><b><br>Informamos que para a ativação de um NOVO RAMAL, estima-se um custo de material de <br><br> "
			."\n R$ 300,00 que será debitado do Centro de Custo do solicitante.</b></font></blockquote></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'><div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_PARECER_TI').":</font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'><br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_DEFERIDO')." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_INDEFERIDO')." <br><br> ".TRANS('TXT_JUST').": 
			<br><br>.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br></font></p>";
		print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
		print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>".TRANS('TXT_T.I')."<br><br></font></p></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>"; 
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_PARECER_DIR_ADM')." </font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'> <br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_DEFERIDO')." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_INDEFERIDO')." <br><br> ".TRANS('TXT_JUST').": 
			<br><br>.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br></font></p>";
		print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
		print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>".TRANS('TXT_DIR_ADM')."<br><br></font></p></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr> ";
		print "<td height='5'><p>&nbsp;</p></td>";
		print "</tr>";
		// print "<td height='5'><blockquote><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_OBS_RAMAL')."</font></blockquote></td>";
		// print "</tr>";
		print "</table>";
		print "</body>";
		print "</body>";
		
	}
	#### FORMULÁRIO DE ALTERAÇÃO DE CATEG. DE RAMAL ####
	if ($linha['form_tipo'] == "FormAltRamal"){
		
		print "<body>";
		if($linhaOco['status_cod']!=4){
			print "<br><b><a href=\"javascript:window.print()\"><img src='../../includes/icons/printer1.png' style=\"vertical-align:middle;\" height='32' width='32' border='0'> "
				."\n Clique aqui para imprimir o formulário</a></b> || <b><font color=red> Este documento deverá ser entregue a Diretoria responsável pela área!</b></font>";
		}
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='53' colspan='3'> <div align='center'><img src='../../includes/icons/Unilasalle.png' width='270' height='65'></div><br></td>";
		print "</tr>";
		print "<tr align='left' valign='middle'>";
		print "<td width='133' height='34'> <div align='left'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Data: ".$data." </font></strong></div></td>";
		print "<td width='404'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_FORM_ALT_RAMAL')."</font></strong></div></td>";
		print "<td width='149'><strong><font size='2' face='Arial, Helvetica, sans-serif'>No.:  ".$linhaOco['form_id']." / ".$linhaOco['numero']." </font></strong></td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'> ";
		print "<td height='18' colspan='3'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_RESP_SOLICIT')."</font></strong></div></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='21' colspan='3'>&nbsp;</td>";
		print "</tr>";
		print "<tr>";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TTL_CENTER_CUST').": ".$centroCusto."</font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_SOLICITANTE').": <b>".$linhaOco['contato']."</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "
			."\n ".TRANS('TXT_FORM_RAMAL_SOLICIT').": <b> ".$linhaOco['telefone']."</b></font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_RAMAL_ALT').": ".$linha['ramal_alter']."</font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_CATEG_RAMAL').": <b>".$linhaCateg['cat_nome']."</b></font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('FIELD_SECTOR').": ".$linhaOco['setor']." </font></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_JUST')."</font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr valign='top'>";
		print "<td height='100'> <blockquote> <font size='2' face='Arial, Helvetica, sans-serif'> <br>".$linhaOco['descricao']."  </font> </blockquote></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='20'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_DATA_PREV').": ".$dataPrevista."</font></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='40'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_ASS_RESP_SECTOR').":</font></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'><div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_PARECER_DIR_RESP').":</font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'><br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_DEFERIDO')." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_INDEFERIDO')." <br><br> ".TRANS('TXT_JUST').": 
			<br><br>.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br></font></p>";
		print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
		print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>".TRANS('TXT_DIR_RESP')."<br><br></font></p></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>"; 
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_PARECER_DIR_ADM')." </font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'> <br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_DEFERIDO')." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_INDEFERIDO')." <br><br> ".TRANS('TXT_JUST').": 
			<br><br>.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br></font></p>";
		print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
		print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>".TRANS('TXT_DIR_ADM')."<br><br></font></p></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr> ";
		print "<td height='5'><p>&nbsp;</p></td>";
		print "</tr>";
		//print "<td height='5'><blockquote><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_OBS_RAMAL')."</font></blockquote></td>";
		print "</tr>";
		print "</table>";
		print "</body>";
		print "</body>";
	}
	#### FORMULÁRIO DE SOLICITAÇÃO DE INSTALL SW ####
	if ($linha['form_tipo'] == "FormSolicitSoft"){
		$valorEstimado = number_format($linha['valor_estimado'],2, ',','.');	
		print "<body>";
		if($linhaOco['status_cod']!=4){
			print "<br><b><a href=\"javascript:window.print()\"><img src='../../includes/icons/printer1.png' style=\"vertical-align:middle;\" height='32' width='32' border='0'> "
				."\n Clique aqui para imprimir o formulário</a></b> || <b><font color=red> Este documento deverá ser entregue a Diretoria responsável pela área!</b></font>";
		}
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='53' colspan='3'> <div align='center'><img src='../../includes/icons/Unilasalle.png' width='270' height='65'></div><br></td>";
		print "</tr>";
		print "<tr align='left' valign='middle'>";
		print "<td width='133' height='34'> <div align='left'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Data: ".$data." </font></strong></div></td>";
		print "<td width='404'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_FORM_SOLICIT_SW')."</font></strong></div></td>";
		print "<td width='149'><strong><font size='2' face='Arial, Helvetica, sans-serif'>No.:  ".$linhaOco['form_id']." / ".$linhaOco['numero']." </font></strong></td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'> ";
		print "<td height='18' colspan='3'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_RESP_SOLICIT')."</font></strong></div></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='21' colspan='3'>&nbsp;</td>";
		print "</tr>";
		print "<tr>";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TTL_CENTER_CUST').": ".$centroCusto."</font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_SOLICITANTE').": <b>".$linhaOco['contato']."</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "
			."\n ".TRANS('TXT_FORM_RAMAL_SOLICIT').": <b>".$linhaOco['telefone']."</b></font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('MNL_FABRICANTES').": <b>".$linha['fornecedor']."</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "
			."\n ".TRANS('MNL_SW').": <b>".$linha['software']."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ".TRANS('MNS_MSG_LIC').": <b>".$descricaoLic." </b></font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_VLR_EST').": R$ ".$valorEstimado."</font></td>";
		print "</tr>";
		print "<tr> ";
		print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('FIELD_SECTOR').": ".$linhaOco['setor']." </font></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_JUST')."</font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr valign='top'>";
		print "<td height='100'> <blockquote> <font size='2' face='Arial, Helvetica, sans-serif'> <br>".$linhaOco['descricao']."  </font> </blockquote></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='20'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_DATA_PREV').": ".$dataPrevista."</font></td>";
		print "</tr>";
		print "<tr>";
		print "<td height='40'><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_ASS_RESP_SECTOR').":</font></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'><div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Parecer da Diretoria Responsável:</font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'><br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_DEFERIDO')." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_INDEFERIDO')." <br><br> ".TRANS('TXT_JUST').": 
			<br><br>.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br></font></p>";
		print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
		print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>Diretoria Responsável<br><br></font></p></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr>"; 
		print "<td height='5'>&nbsp;</td>";
		print "<td height='5'>&nbsp;</td>";
		print "</tr>";
		print "<tr bgcolor='#CCCCCC'>";
		print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Parecer da T.I:</font></strong></div></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
		print "<tr>";
		print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'> <br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_DEFERIDO')." &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		(&nbsp;&nbsp;&nbsp;&nbsp;) ".TRANS('TXT_INDEFERIDO')." <br><br> ".TRANS('TXT_JUST').": 
			<br><br>.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br><br>
			.....................................................................................................................................................................<br></font></p>";
		print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
		print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>Tecnologia da Informação<br><br></font></p></td>";
		print "</tr>";
		print "</table>";
		print "<table width='700' border='0' bordercolor='#000000'>";
		print "<tr> ";
		print "<td height='5'><p>&nbsp;</p></td>";
		print "</tr>";
		//print "<td height='5'><blockquote><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_OBS_RAMAL')."</font></blockquote></td>";
		print "</tr>";
		print "</table>";
		print "</body>";
		print "</body>";
	}
		
	//}
?>