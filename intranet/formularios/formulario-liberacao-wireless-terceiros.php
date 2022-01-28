<?
/*
Script editado e adaptado por Alexsandro Corrêa Figueiró

Data: 26/12/2007

*/
	require_once "global.inc.php";
?>
<html>
<head>
<title>Recibos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body bgcolor="#FFFFFF" text="#000000" background="/imagens/barra.gif">
<form name="form1" method="post" action="/sistemas/formularios/formulario-liberacao-wireless-terceiros.php">
	<table width="750" border="0">
	<tr>
		<td colspan="9"><div align="center"><img src="Unilasalle.png"></img></div><br></td>
	</tr>
	<tr>
		<td colspan="9"><div align="center"> <font face="Arial, Helvetica, sans-serif" size="2"><font face="Arial, Helvetica, sans-serif" size="2"><b>FORMUL&Aacute;RIO 
			DE SOLICITA&Ccedil;&Atilde;O DE LIBERA&Ccedil;&Atilde;O DE ACESSO WIRELESS PARA TERCEIROS</b></font><br>
			<br></font>
		</td>
	</tr>
	<tr>
		<td height="26" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Seleciona sua Reitoria: </font></td>
		<td colspan="3" valign="top">
			<select name="INDICE" id="INDICE" onChange="carregaCentroCusto(this)">
				<option selected>-------------------</option>
				<option value="01">Reitoria</option>
				<option value="02">Pr&oacute;-Reitoria Acad&ecirc;mica</option>
				<option value="03">Pr&oacute;-Reitoria de Desenvolvimento</option>
			</select>
		</td>
        <td valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Data:</font></td>
        <td valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $data; ?></font></td>
      </tr>
        <tr valign="middle">
	</tr>
	<tr> 
		<td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Solicitante responsavel pelos acessos:</font></td>
		<td colspan="5" valign="top"><input name="NOME" type="text" id="NOME" size="30" maxlength="50"></td>
	</tr>
	<tr> 
		<td height="23">&nbsp;</td>
		<td width="48">&nbsp;</td>
		<td width="150">&nbsp;</td>
		<td width="123">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr> 
		<td height="104" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Justificativa:</font></td>
		<td colspan="5" valign="top"><textarea name="JUSTIFICATIVA" cols="50" rows="5" wrap="VIRTUAL" id="JUSTIFICATIVA"></textarea></td>
	</tr>
	<tr> 
		<td height="23" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
	</tr>
	<tr> 
		<td height="34" colspan="1" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Data 
			prevista para uso:</font></td>
        <td colspan="4" valign="top"><input name="DATAUSO" type="text" id="DATAUSO" size="15" maxlength="10"> 
		<font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">ex.: dd/mm/aaaa </font> </td>
      </tr>
      <tr> 
        <td height="21" colspan="2" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td colspan="4" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr> 
        <td height="38" colspan="6" valign="top"><div align="center"> 
            <font size="2" face="Arial, Helvetica, sans-serif">Clique no botão para gerar o formulário,<br>
			imprima e veja as autorizações necessárias.</font>
          </div></td>
      </tr>
      <tr> 
        <td height="21" colspan="2" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td colspan="4" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>      
	  <tr> 
        <td height="38" colspan="6" valign="top"><div align="center"> 
            <input name="GERA" type="submit" id="GERA" value="- Gerar Formul&aacute;rio -">
          </div></td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </form>
</blockquote>
</body>
</html>
