<?php
require_once ("global.inc.php");
require_once "../phpfuncoes/unilasalle/uniFuncoesBanco.php";

echo "<pre>";
print_r($_REQUEST);
echo "</pre>";

# Seleciona todos os grupos cadastrados
$db = funcConectaBanco($host, $user, $password, $database);
$db2 = funcConectaBanco($host, $user2, $password2, $database2);


if ( $acao == "buscaCentroCusto" ) {
	$INDICE = substr($INDICE, 1);
	include_once "global.inc.php";
	include_once "funcoes.inc.php";
	
	# Montando a tabela de Centro de Custos
	$resultado = gl_montaccusto($ANOBASE,$INDICE,$FLAG,$db2);
	$total = mysql_num_rows($resultado);
	
	echo "<script language=\"javascript\">
		var form = window.parent.document.getElementById('".$idForm."').form;
		var j;
		// limpa o combo de setor
		var comboSetor = form.CCUSTO;
		for (i = comboSetor.options.length; i >= 0; i--) {
			comboSetor.options[i] = null;
		}
				
		j = comboSetor.options.length;
		comboSetor.options[j] = new Option('-');";
	
	for ( $ind = 1; $ind <= $total; $ind++ ) {
		$arrayresultado = mysql_fetch_row($resultado);
		$codigo = $arrayresultado[0];
		$codccusto = $arrayresultado[1];
		$descricao = $arrayresultado[2];
		
		$descr = $codccusto." - ".$descricao;
		
		echo " j = comboSetor.options.length;
			comboSetor.options[j] = new Option('".$descr."', ".$codigo.");";
	}
	
	echo "</script>";
}
?>
