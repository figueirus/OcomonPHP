
<?php>
require_once ("global.inc.php");
require_once ("funcoes.inc.php");

	$LDAP_DOMAIN = $DOMAIN_LDAP[0];

	# Conexao com o Servido LDAP
	$DS = ldap_connect($LDAP_HOST);
	$RESULT = ldap_bind($DS,$LDAP_DN,$LDAP_PASSWORD);
?>
<html>
<head>
<title>Solicita&ccedil;&atilde;o de Abertura de Conta</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body bgcolor="#FFFFFF" text="#000000" background="../../../imagens/barra.gif">
<blockquote>
  <blockquote> 
    <table width="600" border="0">
      <tr>
        <td><img src="../../../imagens/barraredes.gif" width="541" height="37"></td>
      </tr>
    </table>
    <br>
    <table width="600" border="0">
      <tr> 
        <td colspan="2"> 
          <div align="left"> 
            <p>&nbsp;</p>
            <p><b>
		<?php
        	# Busca para verificar se o usuario j� existe
        	$VALIDA_RESULT = FL_VALIDA_INFO ($NM_NOVO,$LOGIN,$SENHA,$SENHA_CONF,$NM_RESP,$MAIL,$DS,$LDAP_DN,$LDAP_PASSWORD,$LDAP_DOMAIN);

        	if ($VALIDA_RESULT != "" )
           		echo $VALIDA_RESULT;
        	else {
				$LDAP_DOMAIN = $DOMAIN_LDAP[1];				
				$VALIDA_RESULT = FL_VALIDA_INFO ($NM_NOVO,$LOGIN,$SENHA,$SENHA_CONF,$NM_RESP,$MAIL,$DS,$LDAP_DN,$LDAP_PASSWORD,$LDAP_DOMAIN);

        		if ($VALIDA_RESULT != "" )
           			echo $VALIDA_RESULT;

				else {
				
			        ldap_close($DS);
							
				$msg = "	Termo de Identifica��o e Compromisso\n\n";
        			$msg .= "Nome Completo: $NM_NOVO\n";
        			$msg .= "Anivers�rio: $DT_ANIV\n";
        			$msg .= "Sugest�es de login: $LOGIN\n";
					$msg .= "Senha: $SENHA\n";
        			$msg .= "Setor: $SETOR	Ramal: $RAMAL\n";
					$msg .= "Acesso aos sistemas abaixo relacionados:";
					for ($n = 1; $n < 13; $n++) {
						if ($SIS[$n] != "") {
							$msg .= "- $SIS[$n]\n";
						}
					}
					$msg .= "\nNome Respons�vel: $NM_RESP\n\n";
	
        			$mailheaders_sender = "From: $MAIL";
		
        			mail("redes@unilasalle.edu.br", "Termo de Identifica��o e Compromisso", $msg, $mailheaders_sender);

					$msg = "	Recebemos seu Termo de Identifica��o e Compromisso.\n";
					$msg .= "	Favor verificar os dados abaixo, caso n�o tenha solicitado\n";
					$msg .= "este cadastro, entrar em contato pelo ramal 8621.\n\n";
       				$msg .= "Nome Completo: $NM_NOVO\n";
        			$msg .= "Anivers�rio: $DT_ANIV\n";
        			$msg .= "Sugest�es de login: $LOGIN\n";
        			$msg .= "Setor: $SETOR	Ramal: $RAMAL\n";
					$msg .= "Acesso aos sistemas abaixo relacionados:";
					for ($n = 1; $n < 13; $n++) {
						if ($SIS[$n] != "") {
							$msg .= "- $SIS[$n]\n";
						}
					}
					$msg .= "\nNome Respons�vel: $NM_RESP\n\n\n";
					$msg .= "Atenciosamente\n\n";
					$msg .= "Setor de Redes e Internet\n";
					$msg .= "Centro de Inform�tica\n";
					$msg .= "Centro Universit�rio La Salle\n";

					$mailheaders_replay = "From: redes@unilasalle.edu.br";

					mail("$MAIL@unilasalle.edu.br", "Re: Termo de Identifica��o e Compromisso", $msg, $mailheaders_replay);
					
			echo "<font face=\"Arial\" size=\"2\">Sua solicita&ccedil;&atilde;o 
              foi encaminha ao setor de Redes e Internet,<br>
              assim que efetuarmos o cadastro, entraremos em contato.<br><br>
			  Leia a \"<a href=\"/reitoria/pdfs/resolucaoreitoria3.pdf\"> Resolu��o da Reitoria No. 003/2002</a>\" que define pol�ticas,<br>
			  normas e procedimentos que disciplinam a utiliza��o de equipamentos,<br>
			  recursos e servi�os de inform�tica do Unilasalle.</font></b></p>";
            echo "<p>&nbsp;</p>";
          echo "</div>";
        echo "</td>";
      echo "</tr>";
				}					
			}

			?>								
	  <br>
      <tr>
        <td width="293">&nbsp;</td>
        <td width="297"><b><font face="Arial, Helvetica, sans-serif" size="2">Setor 
          de Redes e Internet<br>
          Centro de Inform&aacute;tica</font></b></td>
      </tr>
      <tr> 
        <td width="293"><b><font face="Arial, Helvetica, sans-serif" size="2"><a href="javascript:window.close()"><font color="#0000FF">Fechar</font></a></font></b></td>
        <td width="297">&nbsp;</td>
      </tr>
    </table>
    <p>&nbsp;</p>
  </blockquote>
</blockquote>
</body>
</html>								   
