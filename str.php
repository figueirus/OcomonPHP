<?php
	$var = "100px";
	
	$str = str_replace(array('%','px'), '', $var);
	
	print $str;
	
	//OUTRA Maneira
		$largura = str_replace(array('%','px'), '', $arrayRs['nrlargura']);
		if ($largura < 100 && is_numeric($largura)){
			$styleCode .= "body{overflow-x : auto;}";
		}


?>