<?
/*
Script editado e adaptado por Alexsandro Corrêa Figueiró

Data: 27/12/2007

*/

	require_once "global.inc";
?>
<html>
<head>
<title>Recibos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body bgcolor="#FFFFFF" text="#000000" background="/imagens/barra.gif">
<form name="form1" method="post" action="/sistemas/formularios/form_desenvsite_2.php">
	<table width="750" border="0">
		<tr>
			<td colspan="9"><div align="center"><img src="Unilasalle.png"></img></div><br></td>
		</tr>
		<tr>
			<td colspan="9">
				<div align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>FORMUL&Aacute;RIO 
				DE SOLICITA&Ccedil;&Atilde;O DE DESENVOLVIMENTO DE SITE</b></font><br><br>
				</div>
			</td>
		</tr>
      		<tr valign="top">
			<td colspan="2">
				<font size="2" face="Arial, Helvetica, sans-serif"><p>Data:&nbsp;<? echo $data; ?></p></font>
			</td>
		</tr>
		<tr valign="top">
			<td>
				<font size="2" face="Arial, Helvetica, sans-serif">Seleciona sua Reitoria: </font>
			</td>
			<td>
				<select name="INDICE" id="INDICE" onChange="carregaCentroCusto(this)">
				          <option selected>-------------------</option>
				          <option value="01">Reitoria</option>
				          <option value="02">Pr&oacute;-Reitoria Acad&ecirc;mica</option>
				          <option value="03">Pr&oacute;-Reitoria Comunit&aacute;ria</option>
				          <option value="04">Pr&oacute;-Reitoria Administrativa</option>
				          <option value="00">Col&eacute;gio</option>
				</select>
			</td>
	      </tr>
	      <tr valign="middle">
			<td height="22" valign="middle"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Centro de Custo:</font></div></td>
			<td colspan="3" valign="middle">
				<div align="left">
					<input type="text" name="CCUSTO" size="30" maxlength="100">
				</div>
			</td>
		</tr>
		<tr valign="top">
			<td width="21%"><font size="2" face="Arial, Helvetica, sans-serif">Solicitante:</font></td>
			<td width="79%">
				<font size="2" face="Arial, Helvetica, sans-serif">
					<input name="NOME" type="text" id="NOME" size="30" maxlength="50">
				</font>
			</td>
		</tr>
		<tr>
			<td><font size="2" face="Arial, Helvetica, sans-serif">Ramal:&nbsp;</font></td>
			<td>
				<font size="2" face="Arial, Helvetica, sans-serif">
					<input name="RAMAL" type="text" id="NOME" size="4" maxlength="5">
				</font>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="2">
				<font size="2" face="Arial, Helvetica, sans-serif">Descrição:</font><br>
				<textarea name="DESCRICAO" cols="50" rows="5" wrap="VIRTUAL" id="DESCRICAO"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr valign="top">
			<td colspan="2">
				<font size="2" face="Arial, Helvetica, sans-serif">Justificativa:</font><br>
				<textarea name="JUSTIFICATIVA" cols="50" rows="5" wrap="VIRTUAL" id="JUSTIFICATIVA"></textarea>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr valign="top">
			<td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">Data
					prevista para uso:&nbsp;<input name="DATAUSO" type="text" id="DATAUSO" size="15" maxlength="10">&nbsp;<font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">ex.:
					dd/mm/aaaa</font>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr valign="top">
			<td colspan="2"><font size="2" face="Arial, Helvetica, sans-serif">Tecnologias disponíveis:</font></td>
		</tr>
		<tr>
			<td colspan="2" valign="top">
				<table width="100%">
					<tr>
						<td width="33%"><font size="2" face="Arial, Helvetica, sans-serif">
					                Servidor WEB:<br>
							&nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[0]" value="PHP">&nbsp;PHP<br>
					                &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[1]" value="Pear">&nbsp;Pear<br>
					                &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[2]" value="SSL">&nbsp;SSL<br>
					                &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[3]" value="Biblioteca Gráfica (GD)">&nbsp;Biblioteca Gráfica (GD)<br>
					                </font>
						</td>
						<td width="33%"><font size="2" face="Arial, Helvetica, sans-serif">
							Bancos de Dados:<br>
					                &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[4]" value="MySQL">&nbsp;MySQL<br>
					                &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[5]" value="PostgreSQL">&nbsp;PostgreSQL<br>
					                &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[6]" value="Oracle">&nbsp;Oracle<br><br>
					                </font>
						</td>
						<td width="33%"><font size="2" face="Arial, Helvetica, sans-serif">
					                Serviços:<br>
					                &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[7]" value="Exponent (Gerenciador de Site)">&nbsp;Exponent (Gerenciador de Site)<br>
					                &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[8]" value="SAS - Módulo Notícias">&nbsp;SAS - Módulo Notícias<br>
					                &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[9]" value="SAS - Módule Galeria de Fotos">&nbsp;SAS - Módule Galeria de Fotos<br>
					                &nbsp;&nbsp;&nbsp;&nbsp;<INPUT type="checkbox" name="TEC[10]" value="SAS - Módulo Agenda">&nbsp;SAS - Módulo Agenda<br>
					                </font>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr valign="baseline">
			<td colspan="2">
				<div align="center">
					<font size="2" face="Arial, Helvetica, sans-serif">Clique no botão para gerar o formulário,<br>imprima e veja as autorizações necessárias.</font>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>
		<tr valign="top">
			<td colspan="2">
				<div align="center"><input name="GERA" type="submit" id="GERA" value="- Gerar Formul&aacute;rio -"></div>
			</td>
		</tr>
	</table>
</form>
</body>
</html>
