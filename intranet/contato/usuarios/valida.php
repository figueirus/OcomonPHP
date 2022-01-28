<title>Termo de Identificação e Compromisso</title>
<link rel="shortcut icon" href="favicon.png"/>
<?
	require_once ("./global2.inc.php");
	require_once ("./funcoes2.inc.php");
  
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
//-------------------------------------------------- //cria login (não existente no formulário) padrão
	// Variaveis tratadas com post
	$CCUSTO = $_POST["CCUSTO"];
	$RAMAL = $_POST["RAMAL"];
	$INDICE = $_POST["INDICE"];
	$CARGO = $_POST["CARGO"];
	$NM_NOVO = $_POST["NM_NOVO"];
	$NM_RESP = $_POST["NM_RESP"];
	$PASTAS = $_POST["PASTAS"];
	$LOGIN = $_POST['NM_NOVO'];
	$SENHA = $_POST["SENHA"];
	$SENHA_PERGA = $_POST["SENHA_PERGA"];
	$DT_ANIV = $_POST["DT_ANIV"];
	$SETOR = $_POST["SETOR"];
	// Variavel recebendo a string que não será tratada para futura comparação
	// Variavel recebendo a string já fazendo as substituições
	$LOGIN = ereg_replace("[ÁÀÂÃ]","A",$LOGIN);
	$LOGIN = ereg_replace("[áàâãª]","a",$LOGIN);
	$LOGIN = ereg_replace("[ÉÈÊ]","E",$LOGIN);
	$LOGIN = ereg_replace("[éèê]","e",$LOGIN);
	$LOGIN = ereg_replace("[íìî]","i",$LOGIN);
	$LOGIN = ereg_replace("[ÍÌÎ]","I",$LOGIN);
	$LOGIN = ereg_replace("[ÓÒÔÕ]","O",$LOGIN);
	$LOGIN = ereg_replace("[óòôõº]","o",$LOGIN);
	$LOGIN = ereg_replace("[ÚÙÛ]","U",$LOGIN);
	$LOGIN = ereg_replace("[úùû]","u",$LOGIN);
	$LOGIN = str_replace("Ç","C",$LOGIN);
	$LOGIN = str_replace("ç","c",$LOGIN);
			
		$LOGIN = strtolower ($LOGIN);
		$ax1 = str_word_count($LOGIN)-1; //pega quantas palavras tem a variavel menos 1 pq o vetor string comeca do zero
		$ax2 = str_word_count($LOGIN, 1); //coloca os nomes em um array
		$LOGIN = $ax2[0].".".$ax2[$ax1]; //pega a primeira palavra da variavel e a ultima
		//-------------------------------------------------------
	
	// #############################################################################
	// function LDAP_PROCURA_USER ($NM_NOVO) {
      // global $DS;
      // global $LDAP_DOMAIN;

	  // $FILTRO = 'gecos='.$_POST['NM_NOVO'];
	  
      // $SEARCH = ldap_search($DS,$LDAP_DOMAIN,$FILTRO);
      // $TOTAL = ldap_count_entries($DS,$SEARCH);
	    

      // if ($TOTAL == 0)
         // return 0;
      // else
         // return 1;
   // }
   // #############################################################################
   
   // function FL_VALIDA_INFO ($NM_RESP,$MAIL,$NM_NOVO) {
		
		// $ACHOU = LDAP_PROCURA_USER ($NM_NOVO);
		// if ($ACHOU == 1) {
			// $MSG_ERRO .= "<font face=Arial size=2>- Usuário já existente.</font><br>";
			// $ERRO = 1;
		// }


	// return $MSG_ERRO;
		
	// }
	#############################################################################

    # Busca para verificar se o usuario já existe
	// $VALIDA_RESULT = FL_VALIDA_INFO ($NM_NOVO,$NM_RESP,$MAIL,$DS,$LDAP_DN,$LDAP_PASSWORD,$LDAP_DOMAIN);
 
   	if ($VALIDA_RESULT != "" ) {
		echo "<body bgcolor=#FFFFFF text=#000000 >";
		echo "<blockquote>";
  		echo "<blockquote>";
    	echo "<table width=600 border=0>";
      	echo "<tr>";
     // e cho "<td><img src=../../../imagens/barraredes.gif width=541 height=37></td>";
      	echo "</tr>";
    	echo "</table><br>";
		echo "<strong><font size=2 face=Arial>";
   		echo $VALIDA_RESULT;
		echo "</font></strong>";
	}
   	else {
		$LDAP_DOMAIN = $DOMAIN_LDAP[1];
		// $VALIDA_RESULT = FL_VALIDA_INFO ($NM_NOVO,$NM_RESP,$MAIL,$DS,$LDAP_DN,$LDAP_PASSWORD,$LDAP_DOMAIN);
   		if ($VALIDA_RESULT != "" ) {
			echo "<body bgcolor=#FFFFFF text=#000000 >";
			echo "<blockquote>";
  			echo "<blockquote>";
	    	echo "<table width=600 border=0>";
	      	echo "<tr>";
        	//echo "<td><img src=../../../imagens/barraredes.gif width=541 height=37></td>";
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
   			$msg .= "Data de Nascimento: $DT_ANIV\n";
 			$msg .= "Login: $LOGIN\n";
			$msg .= "Senha: $SENHA\n";
			$msg .= "Senha Pergamun: $SENHA_PERGA\n";
    		$msg .= "Setor: $SETOR\n";
			$msg .= "Ramal: $RAMAL\n";
			$msg .= "Sistemas: ";
			if(isset($_POST["sis"])){
				foreach($_POST["sis"] as $sis){
					$msg .= "" . $sis . "; ";
					}
				}else{
					$msg .= " Nenhum sistema foi selecionado";
					}
			$msg .= "\nAcesso às pastas:";
			if($PASTAS==""||$PASTAS==" "){
				$PASTAS = "Não foi informado acesso";
				$msg .= " \n$PASTAS";
			}
			else{
					$msg .= "\n$PASTAS";
				}
			$msg .= "\n\nAliases: ";
			if(isset($_POST["ALIAS_CAMPO"])){
				foreach($_POST["ALIAS_CAMPO"] as $ALIAS_CAMPO){
					$msg .= "" . $ALIAS_CAMPO . "; ";
					}
				}else{
					$msg .= " Nenhum alias foi informado\n";
					}
			$msg .= "\nNome Responsável: $NM_RESP\n\n";

   			$mailheaders_sender = "From: $MAIL";

   			mail("matheus.camargo@unilasalle.edu.br", "Termo de Identificacao e Compromisso", $msg, $mailheaders_sender);

			$msg = "MENSAGEM ENVIADA AUTOMATICAMENTE\n";
			$msg .= "  Não responda esta mensagem\n\n";
			$msg .= "	Recebemos seu Termo de Identificação e Compromisso.\n";
			$msg .= "	Favor verificar os dados abaixo, caso não tenha solicitado\n";
			$msg .= "este cadastro, entrar em contato pelo ramal 8621.\n\n";
			$msg .= "Categoria: $CARGO\n";
			$msg .= "Nome Completo: $NM_NOVO\n";
  			$msg .= "Data de Nascimento: $DT_ANIV\n";
			$msg .= "Login: $LOGIN\n";
  			$msg .= "Setor: $SETOR Ramal: $RAMAL\n";
			$msg .= "\nNome Responsável: $NM_RESP\n\n\n";
			$msg .= "Atenciosamente\n\n";
			$msg .= "Setor de Redes e Internet\n";
			$msg .= "Centro de Informática\n";
			$msg .= "Centro Universitário La Salle\n";

			$mailheaders_replay = "From: matheus.camargo@unilasalle.edu.br";

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

			$sql = "INSERT INTO funcionarios VALUES (NULL, '".$NM_NOVO."', '".$_POST['SETOR']."','$RAMAL','$DT_ANIV','$descricao')";
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
		<strong>Login:</strong> 
        <? echo $LOGIN;?> <br>
        <strong>Acesso às pastas:</strong>
		<? 	if(($PASTAS!="")&&($PASTAS!=" ")){
				$ACESSOS = explode("\n",$PASTAS);
				echo "<BR>";
				foreach($ACESSOS as $ACESSOS){
				echo "-".$ACESSOS."<BR>";
				}
			}else{
				echo "Não foi informado pastas\n";
				}?> <br>
        </font> </blockquote></td>
	<td height="100"> <blockquote> <br><font size="2" face="Arial, Helvetica, sans-serif">
		<strong>Acesso aos sistemas:</strong>
		<? if(isset($_POST["sis"])){
				echo "<BR>";
				foreach($_POST["sis"] as $sis){
					echo "- " . $sis . "<BR>";
					}
				}else{
					echo " Nenhum sistema foi selecionado\n";
					} ?> <br>
		<strong>Aliases:</strong>
		<?if(isset($_POST["ALIAS_CAMPO"])){
				echo "<BR>";
				foreach($_POST["ALIAS_CAMPO"] as $ALIAS_CAMPO){
					echo "- " . $ALIAS_CAMPO . "<BR>";
					}
				}else{
					echo " Nenhum alias foi informado\n";
					}  ?> <br>
		
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
		Este termo deve ser entrege diretamente na Área de T.I. para que seja efetivada a solicitação.</font></b></div></td>
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
