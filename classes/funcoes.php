<?

	function dataBanco($data){ //Retorna saída no formado AAAA-MM-DD
		$partData = explode("/","$data");
		$dia = trim($partData[0]);
		$mes = trim($partData[1]);
		$ano = trim($partData[2]);
		
		$data = "$ano-$mes-$dia";
	    return $data;
	}
	
	function dataView($data) {
		$data_orig = $data;
		$separa = substr($data_orig,2,1);

		$conf_data = explode("-","$data_orig");

		$ano = $conf_data[0];
		$mes = $conf_data[1];
		$dia = $conf_data[2];

		$data = "$dia/$mes/$ano";
		return($data);
	}
?>