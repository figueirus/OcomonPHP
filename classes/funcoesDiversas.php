<?
//RETORNA O DIA DA SEMANA
function diasemana($data) {
	$ano =  substr("$data", 0, 4);
	$mes =  substr("$data", 5, -3);
	$dia =  substr("$data", 8, 9);

	$diasemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );

	switch($diasemana) {
		case"0": $diasemana = "Domingo";       break;
		case"1": $diasemana = "Segunda-Feira"; break;
		case"2": $diasemana = "Terça-Feira";   break;
		case"3": $diasemana = "Quarta-Feira";  break;
		case"4": $diasemana = "Quinta-Feira";  break;
		case"5": $diasemana = "Sexta-Feira";   break;
		case"6": $diasemana = "Sábado";        break;
	}

	echo "$diasemana";
}

//RETORNA A QTD DE  SEGUNDAS E QUARTAS
function quantSegundaQuarta($arrayDatas, &$quantSegundas, &$quantQuartas) {
	foreach ($arrayDatas as $data){
		$ano =  substr($data, 0, 4);
		$mes =  substr($data, 5, -3);
		$dia =  substr($data, 8, 9);

		$diaSemana = date("w", mktime(0,0,0,$mes,$dia,$ano) );
		if ($diaSemana == 0) {
			$quantSegundas++;
		}elseif ($diaSemana == 3)){
			$quantQuartas++;
		}
        }
    }

?>
