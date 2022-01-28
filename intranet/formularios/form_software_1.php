<?
/*
Script editado e adaptado por Alexsandro Corrêa Figueiró

Data: 28/12/2007

*/
	require_once "global.inc";
?>
<html>
<head>
<title>Formulários</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<!--<iframe src="" id="pesquisa" name="pesquisa" style="{width:0%; height:0%" frameborder="0"></iframe>-->
<body bgcolor="#FFFFFF" text="#000000" background="/imagens/barra.gif">
<form name="form1" method="post" action="/sistemas/formularios/form_software_2.php">
	<table valign="top" width="750" border="0">
		<tr>
			<td colspan="9"><div align="center"><img src="Unilasalle.png"></img></div><br></td>
		</tr>
		<tr>
			<td colspan="9">
				<div align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>FORMUL&Aacute;RIO 
					DE SOLICITA&Ccedil;&Atilde;O PARA INSTALA&Ccedil;&Atilde;O DE SOFTWARE</b></font><br>
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
				<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;&nbsp;Data:&nbsp;<? echo $data; ?></font></td>
		</tr>
		<tr> 
			<td width="156" height="26" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Centro de Custos: </font></td>
			<td colspan="3" valign="middle">
				<div align="left">
					<input type="text" name="CCUSTO" size="30" maxlength="100">
				</div>
		<tr> 
			<td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Solicitante:</font></td>
			<td colspan="5" valign="top"><input name="NOME" type="text" id="NOME" size="30" maxlength="50"></td>
		</tr>
		<tr> 
			<td height="19" colspan="6" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif">Dados do Software:</font></strong></td>
		</tr>
		<tr> 
			<td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Fabricante:</font></td>
			<td colspan="5" valign="top"><input name="frmFabricante" type="text" size="30" maxlength="50"></td>
		</tr>
		<tr> 
			<td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Nome:</font></td>
			<td colspan="5" valign="top"><input name="frmSoftware" type="text" size="30" maxlength="50"></td>
		</tr>
		<tr> 
			<td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Tipo de Licença:</font></td>
			<td colspan="5" valign="top">
				<select name="frmLicenca">
					<option value="-" selected="true">-</option>
					<option value="Adware">Adware</option>
					<option value="Comercial">Comercial</option>
					<option value="Freeware">Freeware</option>
					<option value="OEM">OEM</option>
					<option value="Opensource/Livre">Opensource/Livre</option>
					<option value="Shareware/Demo">Shareware/Demo</option>
				</select>
			</td>
		</tr>
		<tr> 
			<td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Valor estimado:</font></td>
			<td colspan="5" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">R$&nbsp;</font>
				<input name="VALOR" type="text" id="VALOR" size="15" maxlength="20">&nbsp;
				<font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">Informar em caso de aquisição.</font>
			</td>
		</tr>
		<tr> 
			<td height="19" colspan="6" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif">Dados do Computador:</font></strong></td>
		</tr>
		<tr> 
			<td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">N&#176; de Patrimônio:</font></td>
			<td colspan="5" valign="top">
			<select name="frmUnidade">
				<option value="-" selected="true">-</option>
				<option value="1">Canoas 40</option>
				<option value="2">Canoas 38</option>
			</select>&nbsp;          
			<input name="frmPartNumber" type="text" size="10" maxlength="10"></td>
		</tr>
		<tr> 
			<td height="104" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Justificativa:</font></td>
			<td colspan="5" valign="top"><textarea name="JUSTIFICATIVA" cols="50" rows="5" wrap="VIRTUAL" id="JUSTIFICATIVA"></textarea></td>
		</tr>
		<tr> 
			<td height="34" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Data prevista:</font></td>
			<td colspan="5" valign="top"><input name="DATAUSO" type="text" id="DATAUSO" size="15" maxlength="10"> 
			<font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">ex.: dd/mm/aaaa </font></td>
		</tr>
		<tr> 
			<td height="38" colspan="6" valign="top">
				<div align="center"> 
					<font size="2" face="Arial, Helvetica, sans-serif">Clique no botão para gerar o formulário,<br> imprima e veja as autorizações necessárias.</font>
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
