<?
	require_once "global.inc";

	$resultado = gl_retornaccusto ( "CCUSTO", $ANOBASE, $CCUSTO, $db2 );
	$arrayresultado = mysql_fetch_row($resultado);
	$numccusto = $arrayresultado[0];
	$descricao = $arrayresultado[1];

	if ( $_POST['INDICE'] == 0) $logo = "logo-colegio.gif";
	else $logo = "logo-unilasalle.gif";

	mysql_close($db2);

	if ($_POST['NOME'] == "") {
		$erro = 1;
		$texto_erro .= "O campo solicitante deve ser informado.<br>";
	}

	if ($_POST['frmSoftware'] == "") {
		$erro = 1;
		$texto_erro .= "O campo nome do software deve ser informado.<br>";
	}

	if (($_POST['frmUnidade'] == "-") || ($_POST['frmPartNumber'] == "")) {
		$erro = 1;
		$texto_erro .= "O campo No. de Patrim�nio deve ser informado.<br>";
	}

	if ($_POST['DATAUSO'] != "") {
		$erro_data = gl_verificadata($_POST['DATAUSO'] );
		if ($erro_data == 0) {
			$erro = 1;
			$texto_erro .= "Data inv�lida.<br>";
		}
		else $_POST['DATAUSO']  = gl_grava_dataformatada($_POST['DATAUSO'] );
	}
	else $_POST['DATAUSO']  = date("Y-m-d");

	if ( $erro == 1) {
		echo "<title>$ANOPLAN</title>";
		echo "<font face=\"Arial\" size=\"2\" color=\"#000000\" >";
		echo "<br><h1>Problemas no preenchimento dos campos.</h1><br>VERIFIQUE:<br><br>";
		echo $texto_erro;
		echo "</font>";
		echo "</body></html>";
	}
	else {

		$DATASOL = date("Ymd");

		$db = mysql_connect($server,$user,$password) or die ("N�o foi poss�vel selecionar o banco de dados");
		mysql_select_db($database,$db);

       	$sql = "INSERT INTO FORMSOFTWARE VALUES ( NULL, '$CCUSTO', '$NOME', '$frmFabricante', '$frmSoftware', '$frmLicenca', '$VALOR', '$frmUnidade', '$frmPartNumber', '$JUSTIFICATIVA', '$DATAUSO', '$DATASOL', '0', '0')";

        mysql_query($sql);
		$NUMFORM = mysql_insert_id();

		$_POST['DATAUSO'] = gl_le_dataformatada($_POST['DATAUSO'] );
		$_POST['UNIDADE'] = gl_retornaunidade($_POST['frmUnidade']);
		
		$msg = "	Instala��o de Software\n\n";
		$msg .= "N�mero: $NUMFORM\n";
		$msg .= "Soliciante: ".$_POST['NOME']."\n";
		$msg .= "Fabricante: ".$_POST['frmFabricante']."\n";
		$msg .= "Software: ".$_POST['frmSoftware']."\n";
		$msg .= "Licen�a: ".$_POST['frmLicenca']."\n";
		$msg .= "Valor R$: ".$_POST['VALOR']."\n";
		$msg .= "No. Patrim�nio:".$_POST['UNIDADE']." - ".$_POST['frmPartNumber']."\n";
		$msg .= "Justificativa: ".$_POST['JUSTIFICATIVA']."\n";
		$msg .= "Data prevista para uso: ".$_POST['DATAUSO']."\n";

		$mailheaders_sender = "From: redes@unilasalle.edu.br";

		mail("suporte@unilasalle.edu.br", "Instala��o de Software", $msg, $mailheaders_sender);

		mysql_close($db);
?>
<html>
<head>
<title>Este documento deve ser impresso.</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr>
    <td height="53" colspan="3"> <div align="center"><img src="../../img/<? echo $logo; ?>" width="200" height="43"></div></td>
  </tr>
  <tr align="left" valign="middle">
    <td width="133" height="34"> <div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">Data: 
        <? echo $data; ?> </font></strong></div></td>
    <td width="404"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Solicita&ccedil;&atilde;o 
        para Instala��o de Software</font></strong></div></td>
    <td width="149"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.: 
      <? echo $NUMFORM; ?></font></strong></td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td height="18" colspan="3"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Solicitante</font></strong></div></td>
  </tr>
  <tr> 
    <td height="21" colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">Centro 
      de Custos: <? echo $_POST['CCUSTO']; ?> </font></td>
  </tr>
  <tr> 
    <td height="20" colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">Solicitante: 
      <? echo $_POST['NOME']; ?></font></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="5">&nbsp;</td>
    <td height="5">&nbsp;</td>
  </tr>  
  <tr> 
    <td width="694" height="21" valign="top"><blockquote><font size="2" face="Arial, Helvetica, sans-serif"><em>&quot;Segundo 
        RESOLU&Ccedil;&Atilde;O DA REITORIA N&ordm; 003/2002, DE 29 DE JULHO DE 
        2002, Art 9&ordm; item e) o Unilasalle prioriza e incentiva o uso de software 
        livre na &aacute;rea acad&ecirc;mica e administrativa.&quot;</em></font></blockquote></td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td height="21"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Justificativa</font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr>
    <td width="346" height="21" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Fabricante: <? echo $_POST['frmFabricante']; ?> </font></td>
    <td width="346" height="21" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Nome 
      do Software: <? echo $_POST['frmSoftware']; ?> </font></td>
  </tr>
  <tr> 
    <td width="346" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Licen�a:  <? echo $_POST['frmLicenca']; ?></font></td>
    <td width="346" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Valor R$:  <? echo $_POST['VALOR']; ?></font></td>
  </tr>
  <tr>
    <td width="346" height="21" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">N&#186; de Patrim�nio: <? echo $_POST['UNIDADE']." - ".$_POST['frmPartNumber']; ?> </font></td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="top"> 
    <td height="100" colspan="2"> <blockquote> <font size="2" face="Arial, Helvetica, sans-serif"> 
        <? echo $_POST['JUSTIFICATIVA']; ?> </font> </blockquote></td>
  </tr>
  <tr> 
    <td height="21" colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">Data 
      prevista para uso: <? echo $_POST['DATAUSO']; ?></font></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="5">&nbsp;</td>
    <td height="5">&nbsp;</td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td height="21" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Coordenador do Centro de Custos</font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="21"><p><font size="2" face="Arial, Helvetica, sans-serif">Justificativa: 
        ...................................................................................................................................................<br>
        .....................................................................................................................................................................<br>
        .....................................................................................................................................................................</font></p>
      <p><font size="2" face="Arial, Helvetica, sans-serif">Data: ......../......../20.....</font></p>
      <p align="center"><font size="2" face="Arial, Helvetica, sans-serif">______________________________<br>
        Coordenador<br>
        <br>
        </font></p></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="5">&nbsp;</td>
    <td height="5">&nbsp;</td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td height="21" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Disponibilidade 
        Financeira </font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="5">
<p><font size="2" face="Arial, Helvetica, sans-serif">(&nbsp;&nbsp;&nbsp;&nbsp;) 
        Sim<br>
        (&nbsp;&nbsp;&nbsp;&nbsp;) N&atilde;o<br>
        Justificativa: ...................................................................................................................................................<br>
        .....................................................................................................................................................................<br>
        .....................................................................................................................................................................</font></p>
      <p><font size="2" face="Arial, Helvetica, sans-serif">Data: ......../......../200....</font></p>
      <p align="center"><font size="2" face="Arial, Helvetica, sans-serif">______________________________<br>
        Diretoria Administrativa <br>
        <br>
        </font></p></td>
  </tr>
</table>
</body>
</html>
<? } ?>
