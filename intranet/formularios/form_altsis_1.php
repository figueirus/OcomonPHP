<?
/*
Script editado e adaptado por Alexsandro Corr�a Figueir�

Data: 28/12/2007

*/

	require_once "global.inc";
?>
<html>
<head>
<title>Recibos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000" background="/img/barra.gif">
<form name="form1" method="post" action="/sistemas/formularios/form_altsis_2.php">
	<table width="750" border="0">
		<tr>
			<td colspan="9"><div align="center"><img src="Unilasalle.png"></img></div><br></td>
		</tr>
		<tr>
			<td colspan="9">
				<div align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>FORMUL&Aacute;RIO 
					DE SOLICITA&Ccedil;&Atilde;O DE SERVI�OS DE SISTEMAS</b></font><br>
					<br>
				</div>
			</td>
		</tr>      
		<tr>
			<td height="26" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Seleciona sua Reitoria: </font></td>
			<td colspan="3" valign="top">
				<select name="INDICE" id="INDICE">
				          <option selected>--------------------</option>
					<option value="01">Reitoria</option>
					<option value="02">Pr&oacute;-Reitoria Acad&ecirc;mica</option>
					<option value="03">Pr&oacute;-Reitoria de Desenvolvimento</option>
					<option value="00">Col&eacute;gio</option>
				</select>
				<font size="2" face="Arial, Helvetica, sans-serif"> &nbsp;&nbsp;&nbsp;Data:&nbsp;<? echo $data; ?></font>
			</td>
		</tr>
		<tr> 
			<td width="156" height="26" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Centro de Custos: </font></td>
			<td colspan="3" valign="middle">
				<div align="left">
					<input type="text" name="CCUSTO" size="30" maxlength="100">
				</div>
			</td>
		<tr>
			<td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Solicitante:</font></td>
			<td colspan="5" valign="top"><input name="NOME" type="text" id="NOME" size="30" maxlength="50"></td>
		</tr>
		<tr>
			<td height="104" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Descri��o:</font></td>
			<td colspan="5" valign="top"><textarea name="DESCRICAO" cols="50" rows="5" wrap="VIRTUAL" id="DESCRICAO"></textarea></td>
		</tr>
		<tr>
			<td height="104" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Justificativa:</font></td>
			<td colspan="5" valign="top"><textarea name="JUSTIFICATIVA" cols="50" rows="5" wrap="VIRTUAL" id="JUSTIFICATIVA"></textarea></td>
		</tr>
		<tr>
			<td height="34" colspan="2" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Data prevista para uso:</font></td>
			<td colspan="4" valign="top"><input name="DATAUSO" type="text" id="DATAUSO" size="15" maxlength="10">
			&nbsp;<font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">ex.: dd/mm/aaaa </font> </td>
		</tr>
		<tr>
			<td height="38" colspan="6" valign="top">
				<div align="center">
					<font size="2" face="Arial, Helvetica, sans-serif">Clique no bot�o para gerar o formul�rio,<br>
						imprima e veja as autoriza��es necess�rias.</font>
				</div>
			</td>
		</tr>
		<tr>
			<td height="38" colspan="6" valign="top">
				<div align="center">
					<input name="GERA" type="submit" id="GERA" value="- Gerar Formul&aacute;rio -">
				</div>
			</td>
		</tr>
	</table>
</form>
</body>
</html>
