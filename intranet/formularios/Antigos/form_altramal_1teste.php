<?
	require_once "global.inc";
?>
<html>
<head>
<title>Recibos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="javascript">
function carregaCentroCusto(obj) {
	var form = obj.form;
	var link = '../../cinfo/redes/contato/pesquisa.php?acao=buscaCentroCusto&INDICE='+form.INDICE.value+'&idForm='+form.INDICE.id;
	document.getElementById('pesquisa').src = link;
}
</script>

</head>

<body bgcolor="#FFFFFF" text="#000000" background="/imagens/barra.gif">
<iframe src="" id="pesquisa" name="pesquisa" style="{width:0%; height:0%" frameborder="0"></iframe>

<blockquote><font face="Arial, Helvetica, sans-serif" size="2"><b>FORMUL&Aacute;RIO 
  DE SOLICITA&Ccedil;&Atilde;O DE ALTERA&Ccedil;&Atilde;O DE ACESSO DE RAMAL</b></font><br>
  <br>
  <form name="form1" method="post" action="/sistemas/formularios/form_altramal_2.php">
    
    <table width="750" border="0">
      <!--DWLayoutTable-->
      <tr>
        <td height="26" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Seleciona sua Reitoria: </font></td>
        <td colspan="3" valign="top"><select name="INDICE" id="INDICE" onChange="carregaCentroCusto(this)">
          <option selected>-</option>
          <option value="01">Reitoria</option>
          <option value="02">Pr&oacute;-Reitoria Acad&ecirc;mica</option>
          <option value="03">Pr&oacute;-Reitoria Comunit&aacute;ria</option>
          <option value="04">Pr&oacute;-Reitoria Administrativa</option>
          <option value="05">Col&eacute;gio</option>
        </select></td>
        <td valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr> 
        <td width="156" height="26" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Centro 
          de Custos: </font></td>
        <td colspan="3" valign="top"><select name="CCUSTO" id="CCUSTO">
        </select></td>
        <td width="42" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Data:</font></td>
        <td width="205" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $data; ?></font></td>
      </tr>
      <tr> 
        <td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Solicitante:</font></td>
        <td colspan="5" valign="top"><input name="NOME" type="text" id="NOME" size="30" maxlength="50"></td>
      </tr>
      <tr> 
        <td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Ramal:</font></td>
        <td colspan="5" valign="top"><input name="RAMAL" type="text" id="RAMAL" size="10" maxlength="10"></td>
      </tr>
      <tr> 
        <td height="23" colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">Selecione 
          abaixo a categoria desejada:</font></td>
        <td width="123">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr><TD colspan="6"><blockquote>
        <p><font size="2" face="Arial, Helvetica, sans-serif">
    01 - Somente liga&ccedil;&atilde;o de ramal para ramal<br>
    03 - Liga&ccedil;&atilde;o local<br>
    20 - Liga&ccedil;&atilde;o local, DDD, celular<br>
21 - Liga&ccedil;&atilde;o local, DDD, celular e siga-me externo &nbsp;&nbsp;&nbsp;      </font></p>
      </blockquote></TD>
      </tr>
      <tr> 
        <td height="23" colspan="6">
<select name="CATEGORIA" id="CATEGORIA">
            <option value="-" selected>-</option>
            <option value="01 - Somente liga??o de ramal para ramal">
            01 - Somente liga??o de ramal para ramal</option>
            <option value="03 - Liga??o local">
            03 - Liga??o local</option>
            <option value="20 - Liga??o local, DDD, celular">
            20 - Liga??o local, DDD, celular</option>
            <option value="21 - Liga??o local, DDD, celular e siga-me externo">
            21 - Liga??o local, DDD, celular e siga-me externo</option>
           
          </select></td>
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
        <td height="104" valign="top"><blockquote><font size="2" face="Arial, Helvetica, sans-serif">Justificativa:</font></blockquote></td>
        <td colspan="5" valign="top"><textarea name="JUSTIFICATIVA" cols="50" rows="5" wrap="VIRTUAL" id="JUSTIFICATIVA"></textarea></td>
      </tr>
      <tr> 
        <td height="23" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td colspan="5" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr> 
        <td height="34" colspan="2" valign="top"><blockquote><font size="2" face="Arial, Helvetica, sans-serif">Data 
            prevista para uso:</font></blockquote></td>
        <td colspan="4" valign="top"><input name="DATAUSO" type="text" id="DATAUSO" size="15" maxlength="10"> 
          &nbsp;<font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">ex.: 
          dd/mm/aaaa </font> </td>
      </tr>
      <tr> 
        <td height="21" colspan="2" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td colspan="4" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr> 
        <td height="38" colspan="6" valign="top"><div align="center"> 
            <font size="2" face="Arial, Helvetica, sans-serif">Clique no bot?o para gerar o formul?rio,<br>
			imprima e veja as autoriza??es necess?rias.</font>
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
