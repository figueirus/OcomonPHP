<?
# Variaveis globais
  global $LDAP_HOST;
  global $DS;
  global $LDAP_DN;
  global $LDAP_PASSWORD;
  global $LDAP_DOMAIN;

# Servidor LDAP
  $LDAP_HOST = "ldap.unilasalle.edu.br";
  $DOMAIN_LDAP[0] = "ou=usuarios,dc=unilasalle,dc=edu,dc=br";
  $DOMAIN_LDAP[1] = "ou=usuarios,dc=unilasalle,dc=edu,dc=br";

# Bind para conectar ao servidor
  $LDAP_DN = "cn=admin,dc=unilasalle,dc=edu,dc=br";
  $LDAP_PASSWORD = "gkw4973ldap";


# Conecta Banco de Dados
  $server = "10.10.1.47";
  $user = "redesadm";
  $password = "redes1622";
  $database = "intra";

  $user2 = "planuser";
  $password2 = "plan2022";
  $database2 = "planejamento";

  $db2 = mysql_connect($server,$user2,$password2) or die ("Não foi possível selecionar o banco de dados");
  mysql_select_db($database2,$db2);


# Inicializando variaveis
  $data = date("d/m/Y");
  $MSG_ERRO = "";
  $ERRO = 0;
  $ANOBASE = "2010";
  
  if ( $INDICE == "0" ) {
     $TITULO = "do Colégio";
     $FLAG = "COL";
	 $PROREITOR = "Diretor";
  }
  if ( $INDICE == "1" ) {
     $TITULO = "da Reitoria";
     $FLAG = "REIT";
	 $PROREITOR = "Reitor";
  }
  if ( $INDICE == "2" ) {
     $TITULO = "da Pró-Reitoria Acadêmica";
     $FLAG = "PRAC";
	 $PROREITOR = "Pró-Reitor Acadêmico";
  }
  if ( $INDICE == "3" ) {
     $TITULO = "da Pró-Reitoria Comunitária";
     $FLAG = "PRCO";
	 $PROREITOR = "Pró-Reitor Comunitário";
  }
  if ( $INDICE == "4" ) {
     $TITULO = "da Pró-Reitoria de Desenvolvimento";
     $FLAG = "PRAD";
	 $PROREITOR = "Pró-Reitor de Desenvolvimento";
  }
  
?>
