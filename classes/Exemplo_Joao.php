<?PHP


// $dados[1]["PROFESSOR"] = "ALEX";
// $dados[1]["CURSOS"][1]["NOME"] = "INGL�S";
// $dados[1]["CURSOS"][2]["NOME"] = "ESPANHOL";
// $dados[1]["CURSOS"][2]["NIVEIS"][1] = "INTERMEDI�RIO";
// $dados[1]["CURSOS"][2]["NIVEIS"][2] = "AVAN�ADO";
// $dados[3]["PROFESSOR"] = "JO�O";
// $dados[3]["CURSOS"][1]["NOME"] = "INGL�S";
// $dados[3]["CURSOS"][4]["NOME"] = "ALEM�O";
// $dados[1]["CURSOS"][2]["NIVEIS"][2] = "B�SICO";

$dados = array();
while ($linha=mysql_fetch_array($exec)){
   $dados[$linha["prof_cod"]]["PROFESSOR"] = $linha["prof_nome"];
   $dados[$linha["prof_cod"]]["CURSOS"][$linha["cur_id"]]["NOME"] = $linha["cur_nome"];
   $dados[$linha["prof_cod"]]["CURSOS"][$linha["cur_id"]]["NIVEIS"][$linha["modu_id"]]= $linha["modu_nome"];
}

foreach( $dados as $idProf=>$dadosProfessor) {
   echo "<br>Nome Professor: ".$dadosProfessor["PROFESSOR"];
   foreach($dadosProfessor["CURSOS"] as $idCurso=>$dadosCurso) {
       echo "<br>Nome Curso: ".$dadosCurso["NOME"];
       foreach($dadosCurso["NIVEIS"] as $idNivel=>$nivel) {
           echo "<br>N�vel: ".$nivel;
       }
       echo "<br><br>";
   }
   echo "<br><br>";
}

?> 