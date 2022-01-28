<?php session_start();
 /*                        Copyright 2005 Flávio Ribeiro

        This file is part of OCOMON.

        OCOMON is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        (at your option) any later version.

        OCOMON is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.

        You should have received a copy of the GNU General Public License
        along with Foobar; if not, write to the Free Software
        Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
  */

   if (!isset($_SESSION['s_logado']) || $_SESSION['s_logado'] == 0)
   {
           print "<script>window.open('../../index.php','_parent','')</script>";
      exit;
   }

   include ("../../includes/include_geral.inc.php");
   include ("../../includes/include_geral_II.inc.php");

   include ("../../includes/classes/paging.class.php");


require "banco/init.php";
if(mysql_connect(SERVIDOR, USUARIO, SENHA)) {
$re = mysql_query("SHOW DATABASES");
} else {
    echo "Nao foi possivel conectar no banco de dados<br />Verifique os dados do config.php";
    exit;
}

print "Tabelas: ".$tabelas."<br>";
print "Banco: ".$_POST["db"]."<br>";
print "Metodo: ".getenv("REQUEST_METHOD");
print "<br>SQL de DUMP do banco: <br>".$sql;

if (getenv("REQUEST_METHOD") == "POST") {
	if(isset($_POST["tabelas"])) {   
		$tabela = $_POST["tabelas"];
		$sql .= "-- Servidor: ". SERVIDOR ."\r\n";       
		$sql .= "-- Banco de dados: ". $_POST["db"] ."\r\n";       
		$sql .= "-- Data backup: ". date("d/m/Y H:i:s")."\r\n";       
		$sql .= "-- Versao MySQL: ". mysql_get_server_info()."\r\n";       
		$sql .= "-- Versao PHP: ". phpversion()."\r\n\r\n";   
		
		mysql_select_db($_POST["db"]);       
		$re  = mysql_query("SHOW TABLE STATUS");  
		//dump($re);
		while($l = mysql_fetch_assoc($re)){       
			$tbl_stat[$l["Name"]] = $l["Auto_increment"]; 
		}
        
		//print "Passei aqui.<br>";
		
		for($i = 0; $i < count($tabela); $i++) {
			$re2 = mysql_query("SHOW CREATE TABLE $tabela[$i]");
			$sql .= "-- Estrutura da tabela $tabela[$i]\r\n\r\n";
			$l2  = mysql_fetch_array($re2);
			if($tbl_stat[$tabela[$i]] != "") {
				$sql .= str_replace("  ", "\t", str_replace("`", "", $l2[1])). " AUTO_INCREMENT=". $tbl_stat[$tabela[$i]] .";\r\n\r\n";                   
			} else {
				$sql .= str_replace("  ", "\t", str_replace("`", "", $l2[1])).";\r\n\r\n";                   
			}           
			$re3 = mysql_query("SHOW COLUMNS FROM $tabela[$i]");   
			$campos = ""; 
			//print "Passei por aqui tbm.<br>";
			while ($row = mysql_fetch_array($re3)) {   
				$campos[] = $row[0];               
			}
			$re4 = mysql_query("SELECT * FROM $tabela[$i]");           
			if(mysql_num_rows($re4)) {                                   
				while($dt = mysql_fetch_row($re4)) {
					$valores = "";           
					for($j = 0; $j < sizeof($dt); $j++){
						$valores[] .= "'". $dt[$j] ."'";
					}
					$campo = implode(", ", $campos);   
					$valor = implode(", ", $valores);   
					$sql  .= "INSERT INTO $tabela[$i] ($campo) VALUES ($valor);\r\n";                                       
				}
			}
			$sql .= "\r\n";   
			print "<pre>".$sql."</pre>";
			//print "Opa. <br>";
			//print "<pre>Bunda! ".$sql."</pre>";
		} 
		print "Tchê";
		print "<pre>Bunda! ".$sql."</pre>";
		$banco = $_POST["db"];
		$spaco = " ";
		$data=date("d-m-Y");
      
			if(isset($_POST["sql"])) {           
				$fp = fopen("banco"."/".$_POST["db"]."".$spaco."".$data.".sql", "w+");
				if(!fwrite($fp, $sql)) {
					echo "Erro na criação do arquivo, verifique a permissao de escrita";
					exit;
				}else{echo "<script>alert('Backup do banco $banco foi realizado com sucesso em $data');</script>";}
				fclose($fp);
			}
			exit;
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Backup</title>
<script>
function seleciona_tudo(retorno){
    var frm = document.form1;
    for(i = 0; i < frm.length; i++) {       
        if(frm.elements[i].type == "select-multiple") {
            for(var j = 0; j < frm.elements[i].options.length; j++) {       
                frm.elements[i].options[j].selected = retorno ? 'selected' : false;       
            }     
        }
    }
}

function envia(val) {
    document.form1.submit();
}

</script>
</head>
<form id="form1" name="form1" method="post" action="" >
<TABLE class='header_centro'  border='0' cellpadding='5' cellspacing='0' align='center' width='100%'>
      <TR class='header'>
      <TD  class='line' ><a title='Selecione o Banco'>Selecione o Banco de dados</a></TD>
      </TR>      
   </TABLE>   
<br />
<br />
<div align="center"><select name="db" id="db" onchange="envia(this.value)">
<?php

while($l = mysql_fetch_array($re)) {   
    if(isset($_POST["db"])) {
        if($_POST["db"] == $l[0]) {
            echo "\t<option value=\"{$l[0]}\" selected=\"selected\">$l[0]</option>\r\n";
        } else {
            echo "\t<option value=\"{$l[0]}\">$l[0]</option>\r\n";
        }
    } else {
        echo "\t<option value=\"{$l[0]}\">$l[0]</option>\r\n";
    }   
}
?>
</select><br />
<input type="checkbox" name="checkbox" value="1" onclick="return seleciona_tudo(this.checked);" /><label>Seleciona tudo</label>
<br />
<select name="tabelas[]" size="10" multiple>
<?php
if (getenv("REQUEST_METHOD") == "POST") {
    $db = $_POST["db"];
    $re = mysql_query("SHOW TABLES FROM $db");
    while($l = mysql_fetch_array($re)) {
        echo "<option value=\"{$l[0]}\">{$l[0]}</option>\r\n";   
    }
}
?>
</select><br />
<input type="checkbox" name="sql" value="1" /><label>Criar arquivo</label><br />
<input type="submit" name="botao" value="Backup" style="cursor:pointer;"/>
</div>
</form>
</body>
</html>