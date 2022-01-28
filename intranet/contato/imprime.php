<title>Termo de Identificação e Compromisso</title>
<?
	
	$CCUSTO = $_POST["CCUSTO"];
	$RAMAL = $_POST["RAMAL"];
	$INDICE = $_POST["INDICE"];
	$CARGO = $_POST["CARGO"];
	$NM_NOVO = $_POST["NM_NOVO"];
	$NM_RESP = $_POST["NM_RESP"];
	$PASTAS = $_POST["PASTAS"];
	$LOGIN = $_POST['NM_NOVO'];
	$SENHA = $_POST["SENHA"];
	$SENHA_CONF = $_POST["SENHA_CONF"];
	$MAIL = $_POST["MAIL"];
	$SENHA_PERGA = $_POST["SENHA_PERGA"];
	$DT_ANIV = $_POST["DT_ANIV"];
	$SETOR = $_POST["SETOR"];
	
	require_once ("global.inc.php");
	require_once ("funcoes.inc.php");
  
  ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

	$LDAP_DOMAIN = $DOMAIN_LDAP[0];

	# Conexao com o Servido LDAP
	$DS = ldap_connect($LDAP_HOST);
	$RESULT = @ldap_bind($DS,$LDAP_DN,$LDAP_PASSWORD);

	$resultado = gl_retornaccusto ( "CCUSTO", $ANOBASE, $CCUSTO, $db2 );
	$arrayresultado = mysql_fetch_row($resultado);
	$numccusto = $arrayresultado[0];
	$descricao = $arrayresultado[1];

	if ($INDICE == "0") $logo = "logo-colegio.gif";
	else $logo = "logo-unilasalle.gif";
	
	mysql_close($db2);

    # Busca para verificar se o usuario já existe
    $VALIDA_RESULT = FL_VALIDA_INFO ($NM_NOVO,$LOGIN,$SENHA,$SENHA_CONF,$NM_RESP,$MAIL,$DS,$LDAP_DN,$LDAP_PASSWORD,$LDAP_DOMAIN);
 
   	if ($VALIDA_RESULT != "" ) {
		echo "<body bgcolor=#FFFFFF text=#000000 >";
		echo "<blockquote>";
  		echo "<blockquote>";
    	echo "<table width=600 border=0>";
      	echo "<tr>";
       // echo "<td><img src=../../../imagens/barraredes.gif width=541 height=37></td>";
      	echo "</tr>";
    	echo "</table><br>";
		echo "<strong><font size=2 face=Arial>";
   		echo $VALIDA_RESULT;
		echo "</font></strong>";
	}
   	else {
		$LDAP_DOMAIN = $DOMAIN_LDAP[1];
		$VALIDA_RESULT = FL_VALIDA_INFO ($NM_NOVO,$LOGIN,$SENHA,$SENHA_CONF,$NM_RESP,$MAIL,$DS,$LDAP_DN,$LDAP_PASSWORD,$LDAP_DOMAIN);

   		if ($VALIDA_RESULT != "" ) {
			echo "<body bgcolor=#FFFFFF text=#000000 >";
			echo "<blockquote>";
  			echo "<blockquote>";
	    	echo "<table width=600 border=0>";
	      	echo "<tr>";
        //	echo "<td><img src=../../../imagens/barraredes.gif width=541 height=37></td>";
    	  	echo "</tr>";
	    	echo "</table><br>";
			echo "<strong><font size=2 face=Arial>";
   			echo $VALIDA_RESULT;
			echo "</font></strong>";
		}
		else {

	        ldap_close($DS);

			$msg = "	Termo de Identificação e Compromisso\n\n";
   			$msg .= "Categoria: $CARGO\n";
   			$msg .= "Nome Completo: $NM_NOVO\n";
   			$msg .= "Aniversário: $DT_ANIV\n";
   			$msg .= "Sugestões de login: $LOGIN\n";
			$msg .= "Senha: $SENHA\n";
    			$msg .= "Setor: $SETOR Ramal: $RAMAL\n";
			$msg .= "Acesso aos sistemas abaixo relacionados:";
			for ($n = 1; $n < 8; $n++) {
				if ($SIS[$n] != "") {
					$msg .= "- $SIS[$n]\n";
				}
			}
			$msg .= "\nNome Responsável: $NM_RESP\n\n";

   			$mailheaders_sender = "From: $MAIL";

   			mail("redes@unilasalle.edu.br", "Termo de Identificacao e Compromisso", $msg, $mailheaders_sender);

			$msg = "MENSAGEM ENVIADA AUTOMATICAMENTE\n";
			$msg .= "  Não responda esta mensagem\n\n";
			$msg .= "	Recebemos seu Termo de Identificação e Compromisso.\n";
			$msg .= "	Favor verificar os dados abaixo, caso não tenha solicitado\n";
			$msg .= "este cadastro, entrar em contato pelo ramal 8621.\n\n";
			$msg .= "Categoria: $CARGO\n";
			$msg .= "Nome Completo: $NM_NOVO\n";
  			$msg .= "Aniversário: $DT_ANIV\n";
   			$msg .= "Sugestões de login: $LOGIN\n";
  			$msg .= "Setor: $SETOR Ramal: $RAMAL\n";
			$msg .= "Acesso aos sistemas abaixo relacionados:";
			for ($n = 1; $n < 8; $n++) {
				if ($SIS[$n] != "") {
					$msg .= "- $SIS[$n]\n";
				}
			}
			$msg .= "\nNome Responsável: $NM_RESP\n\n\n";
			$msg .= "Atenciosamente\n\n";
			$msg .= "Setor de Redes e Internet\n";
			$msg .= "Centro de Informática\n";
			$msg .= "Centro Universitário La Salle\n";

			$mailheaders_replay = "From: redes@unilasalle.edu.br";

			//mail("$MAIL@unilasalle.edu.br", "Re: Termo de Identificação e Compromisso", $msg, $mailheaders_replay);

			//CONVERTE DATA
			$data_orig = $DT_ANIV;
			$separa = substr($data_orig,2,1);

			if ("$separa" == "/")
				$conf_data = explode("/","$data_orig");
			else
				$conf_data = explode("-","$data_orig");

			$dia = $conf_data[0];
			$mes = $conf_data[1];
			$ano = "1111";

	 		$DT_ANIV = "$ano-$mes-$dia";

			$db = mysql_connect($server,$user,$password) or die ("Não foi possível selecionar o banco de dados");
			mysql_select_db($database,$db);

			$sql = "INSERT INTO funcionarios VALUES (NULL, '".$NM_NOVO."', '".$_POST['SETOR']."' ,'$LOGIN','$RAMAL','$DT_ANIV','$descricao')";
			mysql_query($sql);

			mysql_close($db);
?>
<html>
<head>
<title>Documento sem t&iacute;tulo</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>

<body>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="53" colspan="2"> <div align="center"><img src="/img/<? echo $logo; ?>" width="200" height="43"></div></td>
  </tr>
  <tr align="left" valign="middle"> 
    <td width="133" height="34"> <div align="left"><strong><font size="2" face="Arial, Helvetica, sans-serif">Data: 
        <? echo $data; ?> </font></strong></div></td>
    <td> <div align="center"><strong><font face="Arial, Helvetica, sans-serif" size="3"><b><font size="2">Termo 
        de Identificação e Compromisso</font></b></font></strong></div></td>
  </tr>
  <tr> 
    <td height="21" colspan="3">&nbsp;</td>
  </tr>
  <tr> 
    <td height="20" colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">Centro 
      de Custos: <? echo "$CCUSTO"; ?> </font></td>
  </tr>
  <tr> 
    <td height="20" colspan="3"><font size="2" face="Arial, Helvetica, sans-serif">Respons&aacute;vel: 
      <? echo $NM_RESP; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Ramal: <? echo $RAMAL; ?>
      </font></td>
  </tr>  
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="5">&nbsp;</td>
    <td height="5">&nbsp;</td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td height="21" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Informa&ccedil;&otilde;es</font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr valign="top"> 
    <td height="100"> <blockquote> <br><font size="2" face="Arial, Helvetica, sans-serif">
		<strong>Categoria:</strong> 
		<? echo $CARGO; ?> <br>
		<strong>Nome:</strong> 
        <? echo $NM_NOVO; ?> <br>
        <strong>Login:</strong> <? echo $LOGIN; ?> <br>
        <br>
        <? 
			$sistemas = "";
			for ($n = 1; $n < 8; $n++) {
				if (!EMPTY($SIS[$n]))
					$sistemas .= "$SIS[$n], ";
			}
			if ($sistemas != "") {
				echo "<strong>Acesso aos sistemas abaixo relacionados:</strong> <br>";
				echo $sistemas;
			}
		?>
        </font> </blockquote></td>
  </tr>
</table>
<table width="700" border="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="5">&nbsp;</td>
    <td height="5">&nbsp;</td>
  </tr>
  <tr bgcolor="#CCCCCC"> 
    <td height="21" colspan="2"> <div align="center"><strong><font size="2" face="Arial, Helvetica, sans-serif">Aprova&ccedil;&atilde;o 
        Coordenador do Centro de Custos</font></strong></div></td>
  </tr>
</table>
<table width="700" border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <!--DWLayoutTable-->
  <tr> 
    <td height="21"><p><font size="2" face="Arial, Helvetica, sans-serif">Justificativa: 
        ...................................................................................................................................................<br>
        .....................................................................................................................................................................<br>
        .....................................................................................................................................................................</font></p>
      <p><font size="2" face="Arial, Helvetica, sans-serif">Data: ......../......../200....</font></p>
      <p align="center"><font size="2" face="Arial, Helvetica, sans-serif">______________________________<br>
        <? echo $NM_RESP; ?><br>
        <br>
        </font></p></td>
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
		Este termo deve ser entrege diretamento no Centro de Informática para que seja efetivada a solicitação.</font></b></div></td>
  </tr>
  <tr>
  	<td height="5">&nbsp;</td>
  	<td height="5">&nbsp;</td>
  </tr>
  <tr> 
    <td height="5" colspan="2"><div align="center"><em><font size="2" face="Arial, Helvetica, sans-serif">&quot;Segundo 
        RESOLU&Ccedil;&Atilde;O DA REITORIA N&deg; 003/2002, DE 29 DE JULHO DE 
        2002, Art. 5&ordm; A solicita&ccedil;&atilde;o de abertura de contas tanto 
        em servidores como em base de dados ou sistemas se d&aacute; pelo preenchimento 
        <br>
        do Termo de identifica&ccedil;&atilde;o e Compromisso, dispon&iacute;vel 
        eletronicamente no sistema de Intranet da Institui&ccedil;&atilde;o, <br>
        indicando neste documento o seu respons&aacute;vel.</font></em></div></td>
  </tr>
</table>
</body>
</html>
<? 		}
	} 
?>
