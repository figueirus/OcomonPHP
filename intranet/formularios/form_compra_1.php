<?
/*
Script editado e adaptado por Alexsandro Corr?a Figueir?

Data: 26/12/2007

*/
	require_once "global.inc.php";
?>
<html>
<head>
<title>Recibos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="/estilos/ls-estilos.css" rel="stylesheet" type="text/css">
</head>

<body bgcolor="#FFFFFF" text="#000000" background="/imagens/barra.gif">
<form name="form1" method="post" action="form_compra_2.php">
	<table valign="top" width="633" border="0">
		<tr>
			<td colspan="9"><div align="center"><img src="Unilasalle.png"></img></div><br></td>
		</tr>
		<tr>
			<td colspan="9">
				<div align="center"><font face="Arial, Helvetica, sans-serif" size="2"><b>FORMUL&Aacute;RIO 
					DE SOLICITA&Ccedil;&Atilde;O/ATUALIZA&Ccedil;&Atilde;O</b></font><br>
					<font face="Arial, Helvetica, sans-serif" size="2"><b> DE EQUIPAMENTOS DE INFORM&Aacute;TICA</b><br></font>
				</div>
			</td>
		</tr>
		<!--DWLayoutTable-->
		<tr> 
			<td width="179" height="20" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Data:</font></td>
			<td colspan="5" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $data; ?></font></td>
		</tr>
		<tr> 
			<td height="19" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Solicitante:</font></td>
			<td colspan="5" valign="top"><input name="NOME" type="text" id="NOME" size="32" maxlength="50"></td>
		</tr>
		<tr>
			<td height="22" valign="middle"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Seleciona sua Reitoria: </font></div></td>
			<td colspan="3" valign="middle">
				<select name="INDICE" id="INDICE" onChange="carregaCentroCusto(this)">
					<option selected>--------------------</option>
					<option value="01">Reitoria</option>
					<option value="02">Pr&oacute;-Reitoria Acad&ecirc;mica</option>
					<option value="03">Pr&oacute;-Reitoria de Desenvolvimento</option>
				</select>
			</td> 
			<td width="244">&nbsp;</td>
			<td width="87">&nbsp;</td>
		</tr>
		<tr valign="middle">
			<td height="22" valign="middle"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Centro de Custo:</font></div></td>
			<td colspan="3" valign="middle">
				<div align="left">
					<input type="text" name="CCUSTO" size="30" maxlength="100">
				</div>
			</td>
		</tr>
		<tr>
			<td height="15" colspan="6" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
		</tr>
		<tr>
			<td height="19" colspan="6" valign="top">
				<strong class="titulopagina"><font size="2" face="Arial, Helvetica, sans-serif">Selecione um dos &iacute;tens abaixo para sua solicita&ccedil;&atilde;o:</font></strong></td>
		</tr>
		<tr> 
			<td height="145" colspan="2" valign="top">
				<table width="95%" height="134" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
					<tr> 
						<td width="52%" height="123">
							<p>
								<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Solicita&ccedil;&atilde;o de:<br></font><br>
								&nbsp; 
									<input name="COMPRA[1]" type="checkbox" id="COMPRA[1]" value="Computador">
								<font size="2" face="Arial, Helvetica, sans-serif">Computador &nbsp;&nbsp;&nbsp; &nbsp;<br>&nbsp; </font>
								<font size="2" face="Arial, Helvetica, sans-serif">
									<input name="COMPRA[4]" type="checkbox" id="COMPRA[4]2" value="Pertochek">
								<font size="2" face="Arial, Helvetica, sans-serif">Pertochek</font><br>&nbsp; 
									<input name="COMPRA[2]" type="checkbox" id="COMPRA[2]" value="Impressora">Impressora &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<br>&nbsp; 
									<input name="COMPRA[5]" type="checkbox" id="COMPRA[5]" value="Projetor Multim&iacute;dia">
								<font size="2" face="Arial, Helvetica, sans-serif">Projetor Multim&iacute;dia</font><br>&nbsp; 
									<input name="COMPRA[3]" type="checkbox" id="COMPRA[3]" value="Scanner">Scanner <br></font>
							</p>
						</td>
					</tr>
				</table>
			</td>
			<td colspan="2" valign="top">
				<div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><br><br>OU</font></div>
			</td>
			<td colspan="2" valign="top">
				<table width="71%" height="134" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
					<tr> 
						<td height="123" valign="top"> 
							<p>
								<font size="2" face="Arial, Helvetica, sans-serif">&nbsp;Atualiza&ccedil;&atilde;o de: </font><br><br>&nbsp;
									<input name="UPGRADE[1]" type="checkbox" id="UPGRADE[1]2" value="Disco">
								<font size="2" face="Arial, Helvetica, sans-serif">Disco<br>&nbsp; 
									<input name="UPGRADE[2]" type="checkbox" id="UPGRADE[2]2" value="Mem&oacute;ria">Mem&oacute;ria <br><br>
								</font>
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr> 
			<td height="18" colspan="6" valign="top" class="titulopagina">
				<font size="2" face="Arial, Helvetica, sans-serif">Justificativa: </font>
			</td>
		</tr>
		<tr>
			<td height="23" colspan="6" valign="top">
				<div align="left">
					<textarea name="JUSTIFICATIVA" cols="105" rows="5" wrap="VIRTUAL" id="JUSTIFICATIVA"></textarea>
				</div>
			</td>
		</tr>
		<tr> 
			<td height="19" colspan="6" valign="top">
				<div align="left">
					<span class="titulopagina"><font size="2" face="Arial, Helvetica, sans-serif">Data prevista para uso</font></span>: 
					<input name="DATAUSO" type="text" id="DATAUSO" size="15" maxlength="10"> &nbsp;
					<font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">ex.: dd/mm/aaaa </font> 
				</div>
			</td>
		</tr>
		<tr> 
			<td height="21" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
			<td colspan="5" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
		</tr>
		<tr> 
			<td height="38" colspan="6" valign="top">
				<div align="center"> 
					<font size="2" face="Arial, Helvetica, sans-serif">Clique no bot?o para gerar o formul?rio,<br>
						imprima e veja as autoriza??es necess?rias.</font>
				</div>
			</td>
		</tr>
		<tr> 
			<td height="21" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
			<td colspan="5" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
		</tr>      
		<tr> 
			<td height="38" colspan="6" valign="top">
				<div align="center"> 
					<input name="GERA" type="submit" id="GERA" value="- Gerar Formul&aacute;rio -">
				</div>
			</td>
		</tr>
	</table>
    <p>&nbsp;</p>
  </form>
</blockquote>
</body>
</html>
