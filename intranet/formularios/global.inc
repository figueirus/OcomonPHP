<?
# Conecta Banco de Dados
	$server = "10.10.1.47";
	$user = "redes";
	$password = "redes";
	$database = "redes";

	$user2 = "planuser";
	$password2 = "plan2022";
	$database2 = "planejamento";

	$db2 = mysql_connect($server,$user2,$password2) or die ("N�o foi poss�vel selecionar o banco de dados");
	mysql_select_db($database2,$db2);

# Data
	
	$data = date("d/m/Y");
	$ano = explode("/", $data);
	$ANOBASE = $ano[2];

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
   
function gl_montacampos ( $TABELA, &$db ) {
    $pesquisa = "SELECT CODIGO, DESCRICAO FROM $TABELA
                 ORDER BY DESCRICAO";

    if ( $resultado = mysql_query($pesquisa ,$db) ) {
       return $resultado;
    }
    else {
       echo "Erro no acesso a descricao do centro de custo.";
       echo mysql_error();
    }
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
                 WHERE CODIGO = '$CODIGO' AND ANO = '$ANO'";

    if ( $resultado = mysql_query($pesquisa ,$db) ) {
       return $resultado;
    }
    else {
       echo "Erro no acesso a descricao do centro de custo.";
       echo mysql_error();
    }
}

function gl_retornainfo ( $TABELA, $CODIGO, $db ) {
    $pesquisa = "SELECT DESCRICAO FROM $TABELA
                 WHERE CODIGO = '$CODIGO'";

    if ( $resultado = mysql_query($pesquisa ,$db) ) {
       return $resultado;
    }
    else {
       echo "Erro no acesso a descricao do centro de custo.";
       echo mysql_error();
    }
}

function gl_verificadata($data) {
	$data_orig = $data;
	$separa = substr($data_orig,2,1);

	$conf_data = explode("$separa","$data_orig");

	$dia = $conf_data[0];
	$mes = $conf_data[1];
	$ano = $conf_data[2];

	$verifica = checkdate ($mes,$dia,$ano);
	return($verifica);
}

function gl_grava_dataformatada($data) {
	$data_orig = $data;
	$separa = substr($data_orig,2,1);

	$conf_data = explode("$separa","$data_orig");

	$dia = $conf_data[0];
	$mes = $conf_data[1];
	$ano = $conf_data[2];

	$data = "$ano-$mes-$dia";
	return($data);
}

function gl_le_dataformatada($data) {
	$data_orig = $data;
	$separa = substr($data_orig,2,1);

	$conf_data = explode("-","$data_orig");

	$ano = $conf_data[0];
	$mes = $conf_data[1];
	$dia = $conf_data[2];

	$data = "$dia/$mes/$ano";
	return($data);
}

function gl_retornaunidade($campo) {
	if ($campo == 1)
	  return "Canoas-40";
	elseif ($campo == 2)
	  return "Canoas-38";
	else
	  return "Canoas-01";
}
?>