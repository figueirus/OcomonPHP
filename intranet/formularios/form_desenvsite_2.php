<?
	require_once "global.inc";

	$resultado = gl_retornaccusto ( "CCUSTO", $ANOBASE, $CCUSTO, $db2 );
	$arrayresultado = mysql_fetch_row($resultado);
	$numccusto = $arrayresultado[0];
	$descricao = $arrayresultado[1];

	if ($INDICE == 0) $logo = "logo-colegio.gif";
	else $logo = "logo-unilasalle.gif";

	mysql_close($db2);

	if ($NOME == "") {
		$erro = 1;
		$texto_erro .= "O campo solicitante deve ser informado.<br>";
	}

	if ($DESCRICAO == "") {
		$erro = 1;
		$texto_erro .= "O campo descrição deve ser informado.<br>";
	}


	if ($JUSTIFICATIVA == "") {
		$erro = 1;
		$texto_erro .= "O campo justificativa deve ser informado.<br>";
	}

	if ($DATAUSO != "") {
		$erro_data = gl_verificadata($DATAUSO);
		if ($erro_data == 0) {
			$erro = 1;
			$texto_erro .= "Data inválida.<br>";
		}
		else $DATAUSO = gl_grava_dataformatada($DATAUSO);
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

		$db = mysql_connect($server,$user,$password) or die ("Não foi possível selecionar o banco de dados");
		mysql_select_db($database,$db);

                $TECNOLOGIAS = "";
                foreach ($TEC as $key => $value) {
                  $TECNOLOGIAS .= "$value; ";
                }

       	        $sql = "INSERT INTO FORMWEB VALUES ( NULL,'$CCUSTO','$NOME','$RAMAL',
				'$DESCRICAO','$JUSTIFICATIVA','$TECNOLOGIAS','$DATAUSO','$DATASOL','0','0')";

                mysql_query($sql);
		$NUMFORM = mysql_insert_id();

		$DATAUSO = gl_le_dataformatada($DATAUSO);

		$msg = "	Desenvolvimento de Site\n\n";
		$msg .= "Número: $NUMFORM\n";
		$msg .= "Soliciante: $NOME\n";
		$msg .= "Ramal: $RAMAL\n";
		$msg .= "Descrição: $DESCRICAO\n";
		$msg .= "Justificativa: $JUSTIFICATIVA\n";
		$msg .= "Tecnologias Selecionadas: $TECNOLOGIAS\n";
		$msg .= "Data prevista para uso: $DATAUSO\n";

		$mailheaders_sender = "From: redes@unilasalle.edu.br";

		mail("redes@unilasalle.edu.br", "Desenvolvimento de Site", $msg, $mailheaders_sender);

		mysql_close($db);
?>
<html>
<head>
<title>Formulários :: Solicitação para Desenvolvimento de Site</title>
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
        para Desenvolvimento de Site</font></strong></div></td>
    <td width="149"><strong><font size="2" face="Arial, Helvetica, sans-serif">No.:
      <? echo $NUMFORM; ?></font></strong></td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td height="18" colspan="3"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Responsável</font></strong></div></td>
  </tr>
  <tr>
    <td height="21" colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td height="20" colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">Centro
      de Custos: <? echo "$CCUSTO"; ?> </font></td>
  </tr>
  <tr>
    <td height="20" colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">Solicitante:
      <? echo $NOME; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ramal:&nbsp;<?php echo $RAMAL ?></font></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr>
    <td height="5">&nbsp;</td>
    <td height="5">&nbsp;</td>
  </tr>
  <tr bgcolor="#CCCCCC">
    <td height="21" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Descrição</font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr valign="top">
    <td height="100"> <blockquote> <font size="2" face="Arial, Helvetica, sans-serif">
        <? echo $DESCRICAO; ?> </font> </blockquote></td>
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
        <? echo $JUSTIFICATIVA; ?> </font> </blockquote></td>
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
    <td height="21" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Tecnologias Selecionadas</font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr valign="top">
    <td height="100"> <blockquote> <font size="2" face="Arial, Helvetica, sans-serif">
        <? echo $TECNOLOGIAS; ?> </font> </blockquote></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#FFFFFF">
  <!--DWLayoutTable-->
  <tr> 
    <td height="5">&nbsp;</td>
    <td height="5">&nbsp;</td>
  </tr>
  <tr> 
    <td height="5">&nbsp;</td>
    <td height="5">&nbsp;</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td height="21" colspan="2" align="center"><font size="2" face="Arial, Helvetica, sans-serif">______________________________<br><?php echo $NOME; ?><br></font></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="5">&nbsp;</td>
    <td height="5">&nbsp;</td>
  </tr>
  <tr>
	<td height="5" colspan="2"><div align="center"><b><font size="2" face="Arial, Helvetica, sans-serif">
		Este termo deve ser entrege diretamente a T.I ou <br>
		colocado na pasta do mesmo na Reitoria para que seja efetivada a solicitação.</font></b></div></td>
  </tr>
</table>

</body>
</html>
<? } ?>
