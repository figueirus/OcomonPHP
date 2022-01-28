<?
# Variaveis globais
  global $LDAP_HOST;
  global $DS;
  global $LDAP_DN;
  global $LDAP_PASSWORD;
  global $LDAP_DOMAIN;

# Servidor LDAP
  $LDAP_HOST = "10.10.1.7";
  $DOMAIN_LDAP[0] = "ou=People,dc=unilasalle,dc=edu,dc=br";
  $DOMAIN_LDAP[1] = "ou=People,dc=unilasalle,dc=edu,dc=br";

# Bind para conectar ao servidor
  $LDAP_DN = "cn=admin,dc=unilasalle,dc=edu,dc=br";
  $LDAP_PASSWORD = "secretldap";


# Conecta Banco de Dados
  $server = "10.10.1.47";
  $user = "intra";
  $password = "intra";
  $database = "intra";

  $user2 = "intranet_cms";
  $password2 = "intra2070mod";
  $database2 = "planejamento";

  $db2 = mysql_connect($server,$user2,$password2) or die ("N�o foi poss�vel selecionar o banco de dados");
  mysql_select_db($database2,$db2);


# Inicializando variaveis
  $data = date("d/m/Y");
  $MSG_ERRO = "";
  $ERRO = 0;
  $ANOBASE = "2003";
  
  if ( $INDICE == "0" ) {
     $TITULO = "do Col�gio";
     $FLAG = "COL";
	 $PROREITOR = "Diretor";
  }
  if ( $INDICE == "1" ) {
     $TITULO = "da Reitoria";
     $FLAG = "REIT";
	 $PROREITOR = "Reitor";
  }
  if ( $INDICE == "2" ) {
     $TITULO = "da Pr�-Reitoria Acad�mica";
     $FLAG = "PRAC";
	 $PROREITOR = "Pr�-Reitor Acad�mico";
  }
  if ( $INDICE == "3" ) {
     $TITULO = "da Pr�-Reitoria Comunit�ria";
     $FLAG = "PRCO";
	 $PROREITOR = "Pr�-Reitor Comunit�rio";
  }
  if ( $INDICE == "4" ) {
     $TITULO = "da Pr�-Reitoria Administrativa";
     $FLAG = "PRAD";
	 $PROREITOR = "Pr�-Reitor Administrativo";
  }
  
?>
