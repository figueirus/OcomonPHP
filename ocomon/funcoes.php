<?php
#UTILIZAR SEMPRE PARA GRAVAR NO BANCO
function DataBanco ($data){ //Retorna saída no formado AAAA-MM-DD HH:mm:SS

	if (!empty($data)) {
		$ano = 0;
		$mes = 0;
		$dia = 0;
		$hora = 0;
		$minuto = 0;
		$segundo = 0;
		$Time = "00:00:00";

		$DateParts= explode(" ",$data);
		$Date = $DateParts[0];
		if (isset($DateParts[1]))
			$Time = $DateParts[1];

		//formato brasileiro com hora!!!
		$valor = "@([0-9]{1,2})[/|-]([0-9]{1,2})[/|-]([0-9]{4}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})@i";
		if (preg_match ($valor, $Date." ".$Time, $sep)) {

			$dia = $sep[1];
			$mes = $sep[2];
			$ano = $sep[3];
			$hora = $sep[4];
			$minuto = $sep[5];
			$segundo = $sep[6];
		} else
			//formato americano com hora
			$valor = "@([0-9]{4})[/|-]([0-9]{1,2})[/|-]([0-9]{1,2}) ([0-9]{1,2}):([0-9]{1,2}):([0-9]{1,2})@i";
		if (preg_match ($valor, $Date." ".$Time, $sep)) {
			$dia = $sep[3];
			$mes = $sep[2];
			$ano = $sep[1];
			$hora = $sep[4];
			$minuto = $sep[5];
			$segundo = $sep[6];
		} else
			print "Invalid date format!!";
		//$data = strtotime($ano."-".$mes."-".$dia." ".$hora.":".$minuto.":".$segundo);
		$data = $ano."-".$mes."-".$dia." ".$hora.":".$minuto.":".$segundo;
		return $data;
	} else
		return "0000-00-00 00:00:00";
//...
}
?>