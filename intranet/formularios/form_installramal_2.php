<?
	require_once "global.inc";

	$resultado = gl_retornaccusto ( "CCUSTO", $ANOBASE, $CCUSTO, $db2 );
	$arrayresultado = mysql_fetch_row($resultado);
	$numccusto = $arrayresultado[0];
	$descricao = $arrayresultado[1];

	if ($_POST['INDICE'] == 0) $logo = "logo-colegio.gif";
	else $logo = "logo-unilasalle.gif";

	mysql_close($db2);

	if ($_POST['NOME'] == "") {
		$erro = 1;
		$texto_erro .= "O campo solicitante deve ser informado.<br>";
	}

	if ($_POST['JUSTIFICATIVA'] == "") {
		$erro = 1;
		$texto_erro .= "O campo justificativa deve ser informado.<br>";
	}

	if ($_POST['DATAUSO'] != "") {
		$erro_data = gl_verificadata($_POST['DATAUSO']);
		if ($erro_data == 0) {
			$erro = 1;
			$texto_erro .= "Data inv?lida.<br>";
		}
		else $DATAUSO = gl_grava_dataformatada($_POST['DATAUSO']);
	}
	else $DATAUSO = date("Y-m-d");

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

		$db = mysql_connect($server,$user,$password) or die ("N?o foi poss?vel selecionar o banco de dados");
		mysql_select_db($database,$db);

       	$sql = "INSERT INTO FORMNVRAMAL VALUES ( NULL,'".$_POST['CCUSTO']."','".$_POST['NOME']."',
				'".$_POST['JUSTIFICATIVA']."','".$_POST['DATAUSO']."','$DATASOL','0','0')";

        mysql_query($sql);
		$NUMFORM = mysql_insert_id();

		$DATAUSO = gl_le_dataformatada($DATAUSO);

		$msg = "Instala??o de Novo Ramal\n\n";
		$msg .= "N?mero: $NUMFORM\n";
		$msg .= "Soliciante: ".$_POST['NOME']."\n";
		$msg .= "Justificativa: ".$_POST['JUSTIFICATIVA']."\n";
		$msg .= "Data prevista para uso: ".$_POST['DATAUSO']."\n";

		$mailheaders_sender = "From: redes@unilasalle.edu.br";

		mail("redes@unilasalle.edu.br", "Instala??o de Novo Ramal", $msg, $mailheaders_sender);

		mysql_close($db);
?>
<html>
<head>
<title>Solicita&ccedil;&atilde;o de Instala&ccedil;&atilde;o de Novo Ramal</title>
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
        de Instala&ccedil;&atilde;o de Novo Ramal</font></strong></div></td>
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
  <tr bgcolor="#CCCCCC"> 
    <td height="21" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Justificativa</font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr valign="top"> 
    <td height="100"> <blockquote> <font size="2" face="Arial, Helvetica, sans-serif"> 
        <? echo $_POST['JUSTIFICATIVA']; ?> </font> </blockquote></td>
  </tr>
  <tr> 
    <td height="21"><font size="2" face="Arial, Helvetica, sans-serif">Data prevista 
      para uso: <? echo $DATAUSO; ?></font></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="5">&nbsp;</td>
    <td height="5">&nbsp;</td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td height="21" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Coordenador 
        do Centro de Custos</font></strong></div></td>
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
    <td height="5"><p>&nbsp;</p></td>
  </tr>
    <td height="5"><blockquote><font size="2" face="Arial, Helvetica, sans-serif">Obs.: 
        Os custos referentes &agrave;s liga&ccedil;&otilde;es ser&atilde;o associados 
        ao centro de custo solicitante.</font></blockquote></td>
  </tr>
</table>
</body>
</html>
<? } ?>
