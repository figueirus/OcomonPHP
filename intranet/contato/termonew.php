<html>
<head>
<title>Termo de Identificação e Compromisso</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<script language="javascript">
function carregaCentroCusto(obj) {
	var form = obj.form;
	var link = 'pesquisa.php?acao=buscaCentroCusto&INDICE='+form.INDICE.value+'&idForm='+form.INDICE.id;
	document.getElementById('pesquisa').src = link;
}
</script>

</head>
<iframe src="" id="pesquisa" name="pesquisa" style="{width:0%; height:0%}" frameborder="0"></iframe>
<body bgcolor="#FFFFFF" text="#000000" background="../../../img/barra.gif">
<blockquote>
  <blockquote> 
    <table width="700" border="0">
      <tr>
        <td><img src="../../../img/barraredes.gif" width="541" height="37"></td>
      </tr>
    </table>
	<br>
    <form name="form" method="post" action="imprime.php">
      <table width="541" border="0">
        <tr> 
          <td colspan="9" height="18"> <div align="center"><font face="Arial, Helvetica, sans-serif" size="3"><b><font size="2">Termo 
              de Identificação e Compromisso</font></b></font></div></td>
        </tr>
        <tr>
          <td colspan="9" height="21"><div align="center"><font size="2" face="Arial, Helvetica, sans-serif"><em>&quot;Cadastro de usu&aacute;rios para acesso aos computadores, email, sistemas, <br>
          lista de ramais e anivers&aacute;rios.&quot;</em></font></div></td>
        </tr>
        <tr> 
          <td colspan="9" height="21"> <div align="center"><font size="2" face="Arial, Helvetica, sans-serif"></font></div></td>
        </tr>
        <tr>
          <td height="30" colspan="3" valign="middle"><div align="left"><font size="2" face="Arial, Helvetica, sans-serif">Seleciona sua Reitoria: </font></div></td>
          <td colspan="6" valign="middle"><select name="INDICE" id="INDICE" onChange="carregaCentroCusto(this)">
              <option selected>-</option>
              <option value="01">Reitoria</option>
              <option value="02">Pr&oacute;-Reitoria Acad&ecirc;mica</option>
              <option value="03">Pr&oacute;-Reitoria Comunit&aacute;ria</option>
              <option value="04">Pr&oacute;-Reitoria Administrativa</option>
              <option value="05">Col&eacute;gio</option>
          </select></td>
        </tr>
        <tr>
          <td colspan="8" height="18" valign="top" bgcolor="#0099CC"><div align="center"><font face="Arial, Helvetica, sans-serif" size="2" color="#FFFFFF"><b>Dados Pessoais </b></font></div></td>
          <td width="59"></td>
        </tr>
        <tr>
          <td height="30" colspan="3" valign="middle"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Nome Completo:</font></div></td>
          <td colspan="6" valign="middle"><input type="text" name="NM_NOVO" size="30" maxlength="100">
          </td>
        </tr>
        <tr>
          <td height="30" colspan="3" valign="middle"><div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Anivers&aacute;rio: </font></div></td>
          <td colspan="6" valign="middle"><input type="text" name="DT_ANIV" size="5" maxlength="5">
              <font face="Arial, Helvetica, sans-serif" size="1" color="#FF0000">ex.: dd/mm</font> </td>
        </tr>
        <tr valign="middle"> 
          <td colspan="8" height="18" bgcolor="#0099CC"> <div align="center"><font face="Arial, Helvetica, sans-serif" size="2" color="#FFFFFF"><b>Dados 
              Gerais</b></font></div></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td height="30" colspan="3"> <div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Sugest&otilde;es 
              de Login:</font></div></td>
          <td colspan="6"><font face="Arial, Helvetica, sans-serif" size="2"> 
            <input type="text" name="LOGIN" size="10" maxlength="8">
            <font size="1" color="#FF0000">obs: m&aacute;ximo 8 caracteres</font> 
            </font> </td>
        </tr>
        <tr valign="middle"> 
          <td height="30" colspan="3"> <div align="left"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="2">Senha:</font></font></font></div></td>
          <td colspan="5"><font face="Arial, Helvetica, sans-serif" size="2"> 
            <input type="password" name="SENHA" size="10" maxlength="15">
            <font size="1" color="#FF0000">obs: m&iacute;nima 6 caracteres</font> 
            </font> </td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td height="30" colspan="3"> <div align="left"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="2">Confirma 
              Senha :</font></font></font></div></td>
          <td colspan="5"><font face="Arial, Helvetica, sans-serif" size="2"> 
            <input type="password" name="SENHA_CONF" size="10" maxlength="15">
            </font> </td>
          <td width="59"></td>
        </tr>
		<tr valign="middle"> 
          <td height="30" colspan="3"> <div align="left"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="2">Categoria</font></font></font></div></td>
          <td colspan="5">            <select name="CARGO" id="CARGO">
            <option value="-">-</option>
            <option value="Bolsista">Bolsista</option>
            <option value="Estagiário">Estagiário</option>
            <option value="Funcionário colégio">Funcionário colégio</option>
            <option value="Funcionário unilasalle">Funcionário unilasalle</option>
            <option value="Monitor">Monitor</option>
            <option value="Pesquisador">Pesquisador</option>
            <option value="Professor colégio">Professor colégio</option>
            <option value="Professor unilasalle">Professor unilasalle</option>
            <option value="Empresa Incubada">Empresa Incubada</option>
          </select></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td height="18" colspan="8" bgcolor="#0099CC"> 
            <div align="center"><font color="#FFFFFF" size="2" face="Arial, Helvetica, sans-serif"><strong>Centro 
              de Custos</strong></font></div></td>
          <td>&nbsp;</td>
        </tr>
        <tr valign="middle"> 
          <td height="30" colspan="9"> <div align="left"> 
              <select name="CCUSTO" id="CCUSTO"></select>
            </div></td>
        </tr>
        <tr valign="middle"> 
          <td height="30" colspan="9"> <div align="left"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"></font></font></div>
            <font face="Arial, Helvetica, sans-serif" size="2">Ramal:&nbsp;&nbsp; 
            <input type="text" name="RAMAL" size="4" maxlength="4">
            </font> </td>
        </tr>
        <tr valign="middle"> 
          <td height="18" colspan="8" bgcolor="#0099CC"> 
            <div align="center"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font color="#FFFFFF" size="2"> 
              <b>Permiss&atilde;o de Acesso aos Sistemas</b></font></font></font></div></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle">
          <td height="21" width="24" valign="top"> <div align="left"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif">
              <input type="checkbox" name="SIS[1]" value="COLEGIO">
              </font></font></div></td>
          <td valign="top" colspan="4"><font face="Arial, Helvetica, sans-serif" size="2">Colégio</font></td>
          <td width="24" valign="top">&nbsp;
          </td>
          <td colspan="2" valign="top"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td height="21" valign="top" width="24"> <input type="checkbox" name="SIS[2]" value="SUNIPS">
          </td>
          <td valign="top" colspan="4"><font face="Arial, Helvetica, sans-serif" size="2">Processo de Sele&ccedil;&atilde;o</font></td>
          <td valign="top" width="24">&nbsp;
          </td>
          <td valign="top" colspan="2"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td height="21" valign="top" width="24"> <input type="checkbox" name="SIS[3]" value="SUNIAC">
          </td>
          <td valign="top" colspan="4"><font face="Arial, Helvetica, sans-serif" size="2">Sistema Acad&ecirc;mico</font></td>
          <td valign="top" width="24">&nbsp;
          </td>
          <td valign="top" colspan="2"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td height="21" valign="top" width="24"> <input type="checkbox" name="SIS[4]" value="SUNIFN">
          </td>
          <td valign="top" colspan="4"><font face="Arial, Helvetica, sans-serif" size="2">Sistema Financeiro</font></td>
          <td valign="top" width="24">&nbsp;
          </td>
          <td valign="top" colspan="2"><font face="Arial, Helvetica, sans-serif" size="2">&nbsp;</font></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle">
          <td height="21" valign="top" width="24"> <input type="checkbox" name="SIS[5]" value="SUNIBN">
          </td>
          <td valign="top" colspan="4"><font face="Arial, Helvetica, sans-serif" size="2">Controle de Benef&iacute;cios</font></td>
          <td valign="top" width="24">&nbsp;
          </td>
          <td valign="top" colspan="2">&nbsp;</font></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td height="21" valign="top" width="24"> <input type="checkbox" name="SIS[6]" value="POSGRAD">
          </td>
          <td valign="top" colspan="4"><font face="Arial, Helvetica, sans-serif" size="2">P&oacute;s Gradua&ccedil;&atilde;o</font></td>
          <td valign="top" width="24"> <input type="checkbox" name="SIS[7]" value="EXTENSAO">
          </td>
          <td valign="top" colspan="2"><font face="Arial, Helvetica, sans-serif" size="2">Cursos de Extens&atilde;o</font></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle">
          <td height="0" width="24"></td>
          <td width="20"></td>
          <td width="70"></td>
          <td width="13"></td>
          <td width="72"></td>
          <td width="24"></td>
          <td width="55"></td>
          <td width="171"></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td colspan="8" height="18" bgcolor="#0099CC"> <div align="center"><font face="Arial, Helvetica, sans-serif" size="2" color="#FFFFFF"><b>Dados 
              do Respons&aacute;vel</b></font></div></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td height="30" colspan="3"> <div align="left"><font face="Arial, Helvetica, sans-serif"><font face="Arial, Helvetica, sans-serif"><font size="2">Nome:</font></font></font></div></td>
          <td colspan="6"><font face="Arial, Helvetica, sans-serif" size="2"> 
            <input type="text" name="NM_RESP" size="30" maxlength="50">
            </font> </td>
        </tr>
        <tr valign="middle"> 
          <td height="30" colspan="3"> <div align="left"><font face="Arial, Helvetica, sans-serif" size="2">Email:</font></div></td>
          <td colspan="6"><font face="Arial, Helvetica, sans-serif" size="2"> 
<input type="text" name="MAIL" size="15" maxlength="15">            
@unilasalle.edu.br</font> </td>
        </tr>
        <tr valign="middle"> 
          <td colspan="8" height="21"> <div align="center"><font face="Arial, Helvetica, sans-serif" size="2" color="#FFFFFF"></font></div></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td colspan="8" height="18" bgcolor="#0099CC"> <div align="center"><font face="Arial, Helvetica, sans-serif" size="2" color="#FFFFFF"><b>Muito 
              Obrigado.</b></font></div></td>
          <td width="59"></td>
        </tr>
        <tr valign="middle"> 
          <td height="49" colspan="8"> <div align="center"><font face="Arial, Helvetica, sans-serif" size="2">Clique no botão para gerar o formulário,<br>
		  imprima e veja as autorizações necessárias.</font></div></td>
        </tr>
		<tr valign="middle"> 
          <td height="49" colspan="3"> <div align="center">
          <td colspan="8" valign="bottom"> <div align="left"> 
              <input type="submit" name="Submit" value="Gerar Formulário">
            </div></td>
          <td width="59"> <div align="center"></div></td>
        </tr>
      </table>
    </form>
    <p>&nbsp;</p>
  </blockquote>
</blockquote>
</body>
</html>
