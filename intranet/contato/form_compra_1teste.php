<html>
<head>
<title>Recibos</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="javascript">
function carregaCentroCusto(obj) {
	var form = obj.form;
	var link = 'pesquisa.php?acao=buscaCentroCusto&INDICE='+form.INDICE.value+'&idForm='+form.INDICE.id;
	document.getElementById('pesquisa').src = link;
}
</script>
<link href="/estilos/ls-estilos.css" rel="stylesheet" type="text/css">

</head>
<iframe src="" id="pesquisa" name="pesquisa" style="{width:0%; height:0%" frameborder="0"></iframe>

<body bgcolor="#FFFFFF" text="#000000" background="/imagens/barra.gif">
<blockquote><font face="Arial, Helvetica, sans-serif" size="2"><b>FORMUL&Aacute;RIO 
  DE SOLICITA&Ccedil;&Atilde;O/ATUALIZA&Ccedil;&Atilde;O</b></font><br>
  <font face="Arial, Helvetica, sans-serif" size="2"><b> DE EQUIPAMENTOS DE INFORM&Aacute;TICA</b></font>
  <form name="form1" method="post" action="/cinfo/redes/contato/form_compra_01.php">
    <table width="633" border="0">
      <!--DWLayoutTable-->
      <tr> 
        <td width="179" height="26" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Data:</font></td>
        <td colspan="5" valign="top"><font size="2" face="Arial, Helvetica, sans-serif"><? echo $data; ?></font></td>
      </tr>
      <tr> 
        <td height="24" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Solicitante:</font></td>
        <td colspan="5" valign="top"><input name="NOME" type="text" id="NOME" size="32" maxlength="50"></td>
      </tr>
      <tr>
        <td height="30" valign="middle"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Seleciona sua Reitoria: </font></div></td>
        <td colspan="3" valign="middle"><select name="INDICE" id="INDICE" onChange="carregaCentroCusto(this)">
          <option selected>-</option>
          <option value="01">Reitoria</option>
          <option value="02">Pr&oacute;-Reitoria Acad&ecirc;mica</option>
          <option value="03">Pr&oacute;-Reitoria Comunit&aacute;ria</option>
          <option value="04">Pr&oacute;-Reitoria Administrativa</option>
          <option value="05">Col&eacute;gio</option>
        </select></td> 
        <td width="244">&nbsp;</td>
        <td width="87">&nbsp;</td>
      </tr>
      <tr>
        <td height="19" colspan="6" valign="top"><font size="2" face="Arial, Helvetica, sans-serif">Centro de Custos:</font> 
          <select name="CCUSTO" id="CCUSTO">
        </select></td>
      </tr>
      <tr>
        <td height="19" colspan="6" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr>
        <td height="19" colspan="6" valign="top"><strong><font size="2" face="Arial, Helvetica, sans-serif">Selecione um dos &iacute;tens abaixo para sua solicita&ccedil;&atilde;o:</font></strong></td>
      </tr>
      <tr> 
        <td height="19" colspan="6" valign="top"><strong></strong></td>
      </tr>
      <tr> 
        <td height="26" colspan="2" valign="top"><table width="92%" height="131" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr> 
              <td width="52%" height="123">
                <p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;&nbsp;Solicita&ccedil;&atilde;o 
                  de:<br>
                  </font><br>
                  &nbsp; 
                  <input name="COMPRA[1]" type="checkbox" id="COMPRA[1]" value="Computador">
                  <font size="2" face="Arial, Helvetica, sans-serif">Computador 
                  &nbsp;&nbsp;&nbsp; &nbsp;<br>
 &nbsp; </font><font size="2" face="Arial, Helvetica, sans-serif">
                  <input name="COMPRA[4]" type="checkbox" id="COMPRA[4]2" value="Pertochek">
                  <font size="2" face="Arial, Helvetica, sans-serif">Pertochek</font><br>
&nbsp; 
                  <input name="COMPRA[2]" type="checkbox" id="COMPRA[2]" value="Impressora">
                  Impressora &nbsp;&nbsp; &nbsp;&nbsp;&nbsp;<br>
                  &nbsp; 
                  <input name="COMPRA[5]" type="checkbox" id="COMPRA[5]" value="Projetor Multim&iacute;dia">
                  <font size="2" face="Arial, Helvetica, sans-serif">Projetor 
                  Multim&iacute;dia</font><br>
&nbsp; 
                  <input name="COMPRA[3]" type="checkbox" id="COMPRA[3]" value="Scanner">
                  Scanner <br>
 </font></p>
              </td>
            </tr>
          </table>
          <p>&nbsp;</p></td>
        <td colspan="2" valign="top"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><br>
            <br>
            OU</font></div></td>
        <td colspan="2" valign="top"><table width="54%" height="134" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
            <tr> 
              <td height="123" valign="top"> 
                <p><font size="2" face="Arial, Helvetica, sans-serif">&nbsp;Atualiza&ccedil;&atilde;o 
                  de: </font><br>
                  <br>
                  &nbsp; 
                  <input name="UPGRADE[1]" type="checkbox" id="UPGRADE[1]2" value="Disco">
                  <font size="2" face="Arial, Helvetica, sans-serif">Disco<br>
                  &nbsp; 
                  <input name="UPGRADE[2]" type="checkbox" id="UPGRADE[2]2" value="Mem&oacute;ria">
                  Mem&oacute;ria <br>
                  <br>
                  </font></p></td>
            </tr>
          </table>
          <p>&nbsp;</p></td>
      </tr>
      <tr> 
        <td height="18" colspan="6" valign="top"><blockquote>
          <div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">Justificativa:</font></strong></div>
        </blockquote></td>
      </tr>
      <tr>
        <td height="23" colspan="6" valign="top">
          <div align="left">
            <textarea name="JUSTIFICATIVA" cols="96" rows="5" wrap="VIRTUAL" id="JUSTIFICATIVA"></textarea>
          </div></td>
      </tr>
      <tr> 
        <td height="23" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td colspan="5" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr> 
        <td height="34" valign="top"> <div align="right">Data prevista para uso: </div></td>
        <td colspan="5" valign="top"><input name="DATAUSO" type="text" id="DATAUSO" size="15" maxlength="10"> 
          &nbsp;<font color="#FF0000" size="1" face="Arial, Helvetica, sans-serif">ex.: 
          dd/mm/aaaa </font> </td>
      </tr>
      <tr> 
        <td height="21" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td colspan="5" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
      </tr>
      <tr> 
        <td height="38" colspan="6" valign="top"><div align="center"> 
            <font size="2" face="Arial, Helvetica, sans-serif">Clique no botão para gerar o formulário,<br>
			imprima e veja as autorizações necessárias.</font>
          </div></td>
      </tr>
      <tr> 
        <td height="21" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
        <td colspan="5" valign="top"><!--DWLayoutEmptyCell-->&nbsp;</td>
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
