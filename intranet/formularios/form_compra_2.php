<?
	require_once "global.inc";

	$resultado = gl_retornaccusto ( "CCUSTO", $ANOBASE, $CCUSTO, $db2 );
	$arrayresultado = mysql_fetch_row($resultado);
	$numccusto = $arrayresultado[0];
	$descricao = $arrayresultado[1];

	if ($_POST['INDICE'] == 0) $logo = "logo-colegio.gif";
	else $logo = "logo-unilasalle.gif";

	mysql_close($db2);

	$selec[1] = 0;	$selec[1] = 0;
	$texto_erro = "";
	$TIPO = "";
	$FLAG = 0;

	for ($op = 1; $op < 6; $op++) {
		if ( !EMPTY($_POST['COMPRA'][$op]) ) {
			$TEXTO = "Solicita??o de";
			$TIPO .= $_POST['COMPRA'][$op].", ";
			$selec[1] = 1;
			$FLAG = 0;
		}
	}

	for ($op = 1; $op < 3; $op++) {
		if ( !EMPTY($_POST['UPGRADE'][$op]) ) {
			$TEXTO = "Upgrade de";
			$TIPO .= $_POST['UPGRADE'][$op].", ";
			$selec[2] = 1;
			$FLAG = 1;
		}
	}

	if ($_POST['NOME'] == "") {
		$erro = 1;
		$texto_erro .= "O campo solicitante deve ser informado.<br>";
	}

	if (($selec[1] == 0) and ($selec[2] == 0)) {
		$erro = 1;
		$texto_erro .= "Voc? deve selecionar solicita??o ou upgrade.<br>";
	}

	if (($selec[1] == 1) and ($selec[2] == 1)) {
		$erro = 1;
		$texto_erro .= "Voc? deve selecionar solicita??o ou upgrade.<br>";
	}

	if ($_POST['JUSTIFICATIVA'] == "") {
		$erro = 1;
		$texto_erro .= "O campo justificativa deve ser informado.<br>";
	}

	if ($_POST['DATAUSO'] != "") {
		$erro_data = gl_verificadata($_POST['DATAUSO'] );
		if ($erro_data == 0) {
			$erro = 1;
			$texto_erro .= "Data inv?lida.<br>";
		}
		else $DATAUSO = gl_grava_dataformatada($_POST['DATAUSO'] );
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

       	$sql = "INSERT INTO FORMCOMPRA VALUES ( NULL,'$CCUSTO','".$_POST['NOME']."',
				'".$_POST['TIPO']."','".$_POST['JUSTIFICATIVA']."','".$_POST['DATAUSO']."','".$DATASOL."','0','0','".$FLAG."')";

        mysql_query($sql);
		$NUMFORM = mysql_insert_id();

		$DATAUSO = gl_le_dataformatada($_POST['DATAUSO']);

		$msg = "	Solicita??o/Upgrade de Equipamentos de Inform?tica\n\n";
		$msg .= "N?mero: $NUMFORM\n";
		$msg .= "Soliciante: ".$_POST['NOME']."\n";
		$msg .= "Ramal: ".$_POST['TEXTO']." ".$_POST['TIPO']."\n";
		$msg .= "Justificativa: ".$_POST['JUSTIFICATIVA']."\n";
		$msg .= "Data prevista para uso: ".$DATAUSO."\n";

		$mailheaders_sender = "From: redes@unilasalle.edu.br";

		mail("redes@unilasalle.edu.br,suporte@unilasalle.edu.br", "Solicita??o/Upgrade de Equipamentos de Inform?tica", $msg, $mailheaders_sender);

		mysql_close($db);
?>
<html>
<head>
<title>Solicita??o/Upgrade de Equipamentos de Inform?tica</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="53" colspan="4"> <div align="center"><img src="../../img/<? echo $logo; ?>" width="200" height="43"></div></td>
  </tr>
  <tr align="left" valign="middle"> 
    <td width="195" height="34"> <div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">Data: 
        <? echo $data; ?> </font></strong></div></td>
    <td colspan="2"> 
      <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Solicita&ccedil;&atilde;o/Atualiza&ccedil;&atilde;o 
        de <br>
        Equipamentos de Inform&aacute;tica</font></strong></div>
    </td>
    <td width="169"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.: 
      <? echo $NUMFORM; ?></font></strong></td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td height="18" colspan="4"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Solicitante</font></strong></div></td>
  </tr>
  <tr> 
    <td height="20" colspan="4"><font size="2" face="Arial, Helvetica, sans-serif">Centro 
      de Custos: <? echo $_POST['CCUSTO']; ?> </font></td>
  </tr>
  <tr> 
    <td height="34" colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">Solicitante: 
      <? echo $_POST['NOME']; ?></font></td>
    <td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">Assinatura:</font></td>
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
  <tr> 
    <td height="21"><font size="2" face="Arial, Helvetica, sans-serif">Tipo Solicita&ccedil;&atilde;o: 
      <? echo $TEXTO." ".$TIPO; ?> </font></td>
  </tr>
  <tr valign="top"> 
    <td height="50"> 
      <blockquote> <font size="2" face="Arial, Helvetica, sans-serif"> <? echo $_POST['JUSTIFICATIVA']; ?> 
        </font> </blockquote></td>
  </tr>
  <tr> 
    <td height="21"><font size="2" face="Arial, Helvetica, sans-serif">Data prevista 
      para uso: <? echo $_POST['DATAUSO']; ?></font></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="3">&nbsp;</td>
    <td height="3">&nbsp;</td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td height="21" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Pr&oacute;-Reitoria 
        da &Aacute;rea</font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="21"><p><font size="2" face="Arial, Helvetica, sans-serif">Justificativa: 
        ...................................................................................................................................................<br>
        .....................................................................................................................................................................
        </font></p>
      <p><font size="2" face="Arial, Helvetica, sans-serif">Data: ......../......../20.....</font></p>
      <p align="center"><font size="2" face="Arial, Helvetica, sans-serif">______________________________<br>
        Pr&oacute;-Reitor<br>
        <br>
        </font></p></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr bgcolor="#CCCCCC"> 
    <td height="21"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Disponibilidade 
        Financeira </font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="5"> <p><font size="2" face="Arial, Helvetica, sans-serif">(&nbsp;&nbsp;&nbsp;&nbsp;) 
        Sim&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;) N&atilde;o<br>
        Justificativa: ...................................................................................................................................................<br>
        ..................................................................................................................................................................... 
        </font></p>
      <p><font size="2" face="Arial, Helvetica, sans-serif">Data: ......../......../200....</font></p>
      <p align="center"><font size="2" face="Arial, Helvetica, sans-serif">______________________________<br>
        Diretoria Administrativa <br>
        <br>
        </font></p></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr bgcolor="#CCCCCC"> 
    <td height="21"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Parecer 
        da Reitoria</font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="21"><p><font size="2" face="Arial, Helvetica, sans-serif">(&nbsp;&nbsp;&nbsp;&nbsp;) 
        Favor&aacute;vel&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;(&nbsp;&nbsp;&nbsp;&nbsp;) 
        Indeferido<br>
        Justificativa: ...................................................................................................................................................<br>
        .....................................................................................................................................................................
        </font></p>
      <p><font size="2" face="Arial, Helvetica, sans-serif">Data: ......../......../200....</font></p>
      <p align="center"><font size="2" face="Arial, Helvetica, sans-serif">______________________________<br>
        Reitor<br>
        <br>
        </font></p></td>
  </tr>
</table>

</body>
</html>
<? } ?>
