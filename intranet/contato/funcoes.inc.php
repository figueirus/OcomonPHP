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
	$LOGIN = $_POST["LOGIN"];

	
	
ldap_set_option($ds, LDAP_OPT_PROTOCOL_VERSION, 3);

  function LDAP_PROCURA_USER ($LOGIN) {
     global $DS;
     global $LDAP_DOMAIN;

     $SEARCH = ldap_search($DS,$LDAP_DOMAIN,"uid=$LOGIN");
     $TOTAL = ldap_count_entries($DS,$SEARCH);

     if ($TOTAL == 0)
        return 0;
     else
        return 1;
  }

  function VERIFICA_SENHA ($SENHA,$SENHA_CONF) {
     if (strlen($SENHA) < 6) {
        $MSG_ERRO .= "<font face=Arial size=2>- Senha muito pequena.</font><br>";
        $ERRO = 1;
     }
     else if ($SENHA != $SENHA_CONF) {
        $MSG_ERRO .= "<font face=Arial size=2>- Senha não confere.</font><br>";
        $ERRO = 1;
     }

     return $MSG_ERRO;
  }

  function FL_VALIDA_INFO ($NM_NOVO,$LOGIN,$SENHA,$SENHA_CONF,$NM_RESP,$MAIL) {
     if ($NM_NOVO == "") {
        $MSG_ERRO .= "<font face=Arial size=2>- Nome não informado.</font><br>";
        $ERRO = 1;
     }

     if ($LOGIN == "") {
        $MSG_ERRO .= "<font face=Arial size=2>- Login não informado.</font><br>";
        $ERRO = 1;
     }
	else
     {
        if (!eregi("^([a-z]|[A-Z]){3,}[.]([a-z]|[A-Z]){3,}$", $LOGIN)){ //{3,}
		$MSG_ERRO .= "<font face=Arial size=2>O Login deve ser composto pelo <font color='red'>nome e sobrenome</font> separados por um \"ponto\". <br><br>Exemplo: joao.silva</font><br>";
		$ERRO = 1;
        }

        $ACHOU = LDAP_PROCURA_USER ($LOGIN);

        if ($ACHOU == 1) {
           $MSG_ERRO .= "<font face=Arial size=2>- Login já existente.</font><br>";
           $ERRO = 1;
        }
     }

     if (strlen($SENHA) < 6) {
        $MSG_ERRO .= "<font face=Arial size=2>- Senha muito pequena.</font><br>";
        $ERRO = 1;
     }
     else if ($SENHA != $SENHA_CONF) {
        $MSG_ERRO .= "<font face=Arial size=2>- Senha não confere.</font><br>";
        $ERRO = 1;
     }

     if ($NM_RESP == "") {
        $MSG_ERRO .= "<font face=Arial size=2>- Nome do responsável não informado.</font><br>";
        $ERRO = 1;
     }

     if ($MAIL == "") {
        $MSG_ERRO .= "<font face=Arial size=2>- Email do responsável não informado.</font><br>";
        $ERRO = 1;
     }
     else {
        $ACHOU = LDAP_PROCURA_USER ($MAIL);

        if ($ACHOU != 1) {
           $MSG_ERRO .= "<font face=Arial size=2>- E-mail inválido, verifique novamente.</font><br>";
           $ERRO = 1;
        }
     }
     return $MSG_ERRO;
  }

function gl_montaccusto ( $ANO, $CENTRO, $FLAG, &$db ) {

    $pesquisa = "SELECT CODIGO, CODCCUSTO, DESCRICAO, VALOR, SALDO FROM CCUSTO
                 WHERE ANO >= '$ANO' AND CENTRO = '$CENTRO' AND $FLAG = '1' ORDER BY CODCCUSTO";

	echo $pesquisa;

    if ( $resultado = mysql_query($pesquisa , $db) ) {
       return $resultado;
    }
    else {
       echo "Erro no acesso a descricao do centro de custo.";
       echo mysql_error();
    }
}

function gl_retornaccusto ( $TABELA, $ANO, $CODIGO, $db ) {

    $pesquisa = "SELECT CODCCUSTO, DESCRICAO, VALOR, SALDO FROM $TABELA
                 WHERE CODIGO = '$CODIGO' AND ANO >= '$ANO'";

    if ( $resultado = mysql_query($pesquisa ,$db) ) {
       return $resultado;
    }
    else {
       echo "Erro no acesso a descricao do centro de custo.";
       echo mysql_error();
    }
}
?>
