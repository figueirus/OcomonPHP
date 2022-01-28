<?php
session_start();	

	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");
	print "<link rel='stylesheet' href='../../includes/css/calendar.css.php' media='screen'></LINK>";
	$_SESSION['s_page_ocomon'] = $_SERVER['PHP_SELF'];

	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],4);
	$ok = $_REQUEST['ok'];
	
	
	$area = $_SESSION['area'];
	$s_nivel = $_SESSION['s_nivel'];
	$s_uareas = $_SESSION['s_uareas'] ;
	
	
	
//print $ok;
	if ($ok != 'Pesquisar')   {
		//print "Estou Aqui ==> ".$_REQUEST['ok'];
		print "<html>";
		print "<head><script language=\"JavaScript\" src=\"../../includes/javascript/calendar.js\"></script></head>";
		print "	<BR><BR>";
		print "	<B><center>:::RelatÛrio de Indicadores de Qualidade:::</center></B><BR><BR>";
		print "		<FORM action='".$_SERVER['PHP_SELF']."' method='post' name='form1' onSubmit=\"return valida()\" >"; //onSubmit=\"return valida()\"
		//print "		<FORM name='form1' action='".$_SERVER['PHP_SELF']."' method='post'>";
		print "		<TABLE border='0' align='center' cellspacing='2'  bgcolor=".BODY_COLOR." >";
		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">¡rea Respons·vel:</td>";
		
		print "					<td class='line'><Select name='area' class='select'>";
		print "							<OPTION value=-1 selected>-->Todos<--</OPTION>";
										$query="select * from sistemas where sis_status ='1' order by sistema";
										$resultado=mysql_query($query);
										$linhas = mysql_num_rows($resultado);
										while($row=mysql_fetch_array($resultado))
										{
											print "<option value=".$row['sis_id']."";
											if ($row['sis_id']==$s_area) print " selected";
											print ">".$row['sistema']."</option>";
										} // while
		print "		 				</Select>";
		print "					</td>";
		print "				</tr>";	

		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Usuario:</td>";
		print "					<td><Select name='operador' class='select' size='1'>";
		print "							<OPTION value=-1 selected>-->Todos<--</OPTION>";
										$query="select * from usuarios order by nome";
										$resultado=mysql_query($query);
										$linhas = mysql_num_rows($resultado);
										while($row=mysql_fetch_array($resultado)){
											print "<option value=".$row['user_id'].">".$row['nome']."</option>";
										} // while
		print "		 				</Select>";
		//	print "						<input type='checkbox' name='opTodos'>Todos";
		print "					 </td>";
		print "				</tr>";	


			print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Local:</td>";
		print "					<td><Select name='local' class='select' size='1'>";
		print "							<OPTION value=-1 selected>-->Todos<--</OPTION>";
										$query="select * from localizacao where loc_status not in (0) order by local";
										$resultado=mysql_query($query);
										$linhas = mysql_num_rows($resultado);
										while($row=mysql_fetch_array($resultado))
										{
											//$sis_id=$row['user_id'];
											//$sis_name=$row['nome'];
											print "<option value=".$row['loc_id'].">".$row['local']."</option>";
										} // while
		print "		 				</Select>";
		print "					 </td>";
		print "				</tr>";	

		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Qualidade:</td>";
		print "					<td><Select name='qualidade' class='select' size='1'>";
		print "							<OPTION value=-1 selected>-->Todos<--</OPTION>";
										//$query = "SELECT * FROM nota_aval WHERE status_id = '1'";
										$query = "SELECT * FROM nota_aval";
										$exec_nota = mysql_query($query);
										while ($linhaNota = mysql_fetch_array($exec_nota)){
											print "<option value=".$linhaNota['nota_aval_id'].">".$linhaNota['nota_aval']."</option>";
										}
		print "					</select>";
		print "					 </td>";
		print "				</tr>";	

		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Data Inicial:</td>";
		print "					<td><INPUT type='text' name='d_ini' class='data' id='idD_ini' value='01-".date("m-Y")."'><a onclick=\"displayCalendar(document.forms[0].d_ini,'dd-mm-yyyy',this)\"><img height='14' width='14' src='../../includes/javascript/img/cal.gif' width='16' height='16' border='0' alt='".TRANS('HNT_SEL_DATE')."'></a></td>";
		print "				</tr>";
		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Data Final:</td>";
		print "					<td><INPUT type='text' name='d_fim' class='data' id='idD_fim' value='".date("d-m-Y")."'><a onclick=\"displayCalendar(document.forms[0].d_fim,'dd-mm-yyyy',this)\"><img height='14' width='14' src='../../includes/javascript/img/cal.gif' width='16' height='16' border='0' alt='".TRANS('HNT_SEL_DATE')."'></a></td>";
		print "				</tr>";
		
		print "				<tr>";
		print "					<td bgcolor=".TD_COLOR.">Tipo de relatÛrio:</td>";
		print "					<td class='line'><select name='saida' class='data'>";
		print "							<option value=-1 selected>Normal</option>";
	//	print "							<option value=1>RelatÛrio 1 linha</option>";
		print "						</select>";
		print "					</td>";
		print "				</tr>";
		print "<tr><td colspan='2'><input type='checkbox' name='novaJanela' title='Selecione para que a saÌda seja em uma nova janela.'>Nova Janela (para impress„o)<td><tr>";
		print "		</TABLE><br>";
		
		print "		<TABLE align='center'>";
		print "			<tr>";
		print "	            <TD>";
		//print"					<input type='hidden' name='sis_name' value='$sis_name' "; 
		print "					<input type='submit' value='Pesquisar' name='ok' >";//onClick=\"submitForm();\"
		print "	            </TD>";
		print "	            <TD>";
		print "					<INPUT type='reset' value='Limpar campos' name='cancelar'>";
		print "				</TD>";
		print "			</tr>";
		print "	    </TABLE>";
		print "</form>";
		print "</BODY>";
		print "</html>"; 
	}//if $ok!=Pesquisar
	else //if $ok==Pesquisar
{
	// print "Passei por Aqui!!";
	$operador = $_POST['operador'];
	$local = $_POST['local'];
	$qualidade = $_POST['qualidade'];
	$area = $_POST['area'];
	$s_area = $_SESSION['s_area'];
	$s_uareas = $_SESSION['$s_uareas'];
	$d_ini = $_POST['d_ini'];
	$d_fim = $_POST['d_fim'];
	$saida = $_POST['saida'];


	//SLA 1 √â menor do que o SLA 2 - VERDE	
	$sla3 = 6; //INICIO DO VERMELHO - Tempo de SOLU√á√ÉO
	$sla2 = 4; //INICIO DO AMARELO
	$slaR3 = 3600; //Tempo de RESPOSTA em segundos VERMELHO
	$slaR2 = 1800; //AMARELO

	$corSla1 = "green";
	$corSla2 = "orange";
	$corSla3 = "red";
	$percLimit = 20; //Limite em porcento que um chamado pode estourar para ficar no SLA2 antes de ficar no vermelho
    
	$chamadosSgreen = array();
	$chamadosSyellow = array();
	$chamadosSred = array();

	$chamadosRgreen = array();
	$chamadosRyellow = array();
	$chamadosRred = array();
	
	
	
	$hora_inicio = ' 00:00:00';
	$hora_fim = ' 23:59:59';            
    
	$query = "select o.numero, o.data_abertura, o.data_atendimento, o.data_fechamento, o.descricao as descc, o.contato as contatoc, o.usu_nota as usu_nota, o.sistema as cod_area, s.sistema as area, 
            p.problema as problema, sl.slas_desc as sla, sl.slas_tempo as tempo , l.*, pr.*, res.slas_tempo as resposta,
			u.nome as operador
            from localizacao as l left join prioridades as pr on pr.prior_cod = l.loc_prior left join sla_solucao as res on res.slas_cod = pr.prior_sla, problemas as p left join sla_solucao as sl on p.prob_sla = sl.slas_cod,
            ocorrencias as o, sistemas as s, usuarios as u 
            where o.status=4 and s.sis_id=o.sistema and p.prob_id = o.problema  and o.local =l.loc_id and o.operador=u.user_id";	
	if (!empty($operador) and ($operador !=-1)){
		$query.=" and o.operador=".$operador."";
	}
	if (!empty($local) and ($local !=-1)){
		$query.=" and o.local=".$local."";
	}
	
	if (($qualidade !=-1)){
		$query.=" and o.usu_nota=".$qualidade."";
	}	
	if (!empty($area) and ($area != -1) and (($area == $s_area)|| ($s_nivel==1) ||(isIn($area, $s_uareas)) )){ // variavel do select name 
	    $query .= " and o.sistema = $area";
	} else 
	if (($s_nivel!=1) && !isIn($area, $s_uareas ) ) {
	// if (($_SESSION['s_nivel'] !=1) && !isIn($_SESSION['area'], $_SESSION['s_uareas'] ) ) {
		print "<script>window.alert('VocÍ sÛ pode consultar os dados da sua ·rea!');</script>";
		print "<script>history.back();</script>";
		exit;
	}
	
	
	if ((empty($d_ini)) and (empty($d_fim))) 
	{
		$aviso = "O perÌodo deve ser informado.";
        $origem = 'javascript:history.back()';
        session_register("aviso");
        session_register("origem");
        print "<script>window.alert('O perÌodo deve ser informado!'); history.back();</script>";
		//echo "<META HTTP-EQUIV=REFRESH CONTENT=\"0;URL=mensagem.php\">";
	}
	else
	{
	   $d_ini = str_replace("-","/",$d_ini);
	   $d_fim = str_replace("-","/",$d_fim);
	   $d_ini_nova = converte_dma_para_amd($d_ini);
	   $d_fim_nova = converte_dma_para_amd($d_fim);
	   
	   $d_ini_completa = $d_ini_nova.$hora_inicio;
	   $d_fim_completa = $d_fim_nova.$hora_fim;	   
	   // print $d_ini_completa."<br>";
	   // print $d_fim_completa;
	   
	if($d_ini_completa <= $d_fim_completa)
	    { 
			//$dias_va  //Alterado de data_abertura para data_fechamento -- ordena mudou de fechamento para abertura
		   $query .= " and o.data_fechamento >= '".$d_ini_completa."' and o.data_fechamento <= '".$d_fim_completa."' and
					    o.data_atendimento is not null order by o.data_abertura";
		//print $query;exit;
		   $resultado = mysql_query($query);       // print "<b>Query--></b> $query<br><br>";
		   $linhas = mysql_num_rows($resultado);  //print "Linhas: $linhas";
			
			
			
		  // $row = mysql_fetch_array($resultado);		
		
		    if($linhas==0) 
			   {	//print "Passei aqui. E n„o deu nada";
		       		$aviso = "N„o h· dados no perÌodo informado. <br>Refa√ßa sua pesquisa.";
			        $origem = 'javascript:history.back()';
			        session_register("aviso");
			        session_register("origem");
		            //echo "<META HTTP-EQUIV=REFRESH CONTENT=\"0;URL=mensagem.php\">";
					print "<script>window.alert('N„o h· dados no perÌodo informado!'); history.back();</script>";
		       } 
		    else //if($linhas==0)
		   	   	{
				//print "Passei por aqui agora!!1<br>";
			   		$campos=array();	
					//print "Aqui: ".$_POST['saida'];
					switch($saida)
					{	
						case -1: 
						// print "TÙ aqui.";
							//print "Passei por aqui agora!!1<br>";
							$criterio = "<br>";
							$sql_area = "select * from sistemas where sis_id = '".$area."'";
							$exec_area = mysql_query($sql_area);
							$row_area = mysql_fetch_array($exec_area);
							if (!empty($row_area['sistema'])) {
								$criterio.="√ÅREA: ".$row_area['sistema']."";
							}
						
						
						if (!empty($operador) and ($operador !=-1)){
							$sqlOp = "Select * from usuarios where user_id = '".$operador."'";
							$execOp= mysql_query($sqlOp);
							$rowOp = mysql_fetch_array($execOp);
							$criterio.= "- Operador: ".$rowOp['nome'];
						}
						if (!empty($local) and ($local !=-1)){
							$sqlLoc = "Select * from localizacao where loc_id = ".$local."";
							$execLoc = mysql_query($sqlLoc);
							$rowLoc = mysql_fetch_array($execLoc);
							$criterio.="- Local: ".$rowLoc['local']."";
						}
							// print "TÙ aqui.";
							
							//echo "<br><br>";
							$background = '#C7D0D9';
						$sqlTotal = "SELECT count(*) quantidade, n.nota_aval aval, n.nota_aval_id nota 
						FROM ocorrencias oco, nota_aval n
						WHERE oco.usu_nota = n.nota_aval_id
						AND oco.data_fechamento >= '".$d_ini_completa."'
						AND oco.data_fechamento <= '".$d_fim_completa."'
						AND oco.data_atendimento IS NOT NULL";
						if (!empty($operador) and ($operador !=-1)){
							$sqlTotal.=" AND oco.operador=".$operador."";
						}
						if (!empty($local) and ($local !=-1)){
							$sqlTotal.=" AND oco.local=".$local."";
						}
						
						if (($qualidade !=-1)){
							$sqlTotal.=" AND oco.usu_nota=".$qualidade."";
						}	
						if (!empty($area) and ($area != -1) and (($area == $s_area)|| ($s_nivel==1) ||(isIn($area, $s_uareas)) )){ // variavel do select name 
							$sqlTotal .= " AND oco.sistema = '".$area."'";
						}
						$sqlTotal.=" GROUP by nota_aval 
								ORDER BY quantidade desc, aval";
						$execTotal =  mysql_query($sqlTotal);
						//print $sqlTotal;
						print "<p class='titulo'>..:: RelatÛrio de Qualidade do Atendimento ::..</p>";
						print "<br><center><b>TOTAL DE CHAMADOS AVALIADOS NO PERÕODO:</center></b><br>";
						print "<table align='center' class='centro' cellspacing='0' border='1' align='center'>";
						print "<tr bgcolor='".$background."'><td class='line'><b>NOTAS</b></td><td class='line'><b>QTD</b></td></tr>";
						$TOTAL = 0;
						while ($rowTotal = mysql_fetch_array($execTotal)) {
							$nota = $rowTotal['aval'];
							if (($nota == "PÈssimo") OR ($nota == "Regular")){
								$nota = "<font color=red><b> ".$nota."</b> </font>";
							}
							print "<tr><td class='line'>".$nota."</a></td><td class='line'>".$rowTotal['quantidade']."</td></tr>";
							$TOTAL+=$rowTotal['quantidade'];
						}
						print "<tr><td class='line'><b>".TRANS('TOTAL')."</b></td><td class='line'>".$TOTAL."</td></tr>";
						print "</table><br><br>";
													
			                            print "<table align='center' class='centro' cellspacing='0' border='1' >";
										print "<p class='titulo'>An·lise dos resultados: Chamados Encerrados</p>";
										//print "<p>An·lise dos resultados:</p>";
							print "<tr bgcolor=$background><td><B>NUMERO</td>
									   <td width='120'><b><a title='contato'>ABERTO EM</a></td>
									   <td width='100'><b><a title='contato'>USUARIO</a></td>
									   <td><b><a title='descricao'>DESCRICAO</a></td>
									   <td><b><a title='tempo de solu√ß„o'>T SOLUCAO VALIDO</a></td></B>
									   <td><b><a title='operador'>OPERADOR</a></td></B>
									   <td><b><a title='qualificacao'>QUALIFICACAO</a></td></B>
								  </tr>";
						
						
						  
                           //INICIALIZANDO CONTADORES!!
				$sla_green=0;
				$sla_red=0;
				$sla_yellow=0;
				$slaR_green=0;
				$slaR_red=0;
				$slaR_yellow=0;
				$c_slaS_blue = 0;
				$c_slaS_yellow = 0;
				$c_slaS_red = 0;
				$c_slaR_blue = 0;
				$c_slaR_yellow = 0;
				$c_slaR_red = 0;
				$c_slaM_blue = 0;
				$c_slaM_yellow = 0;
				$c_slaM_red = 0;
				$c_slaR_checked = 0;
				$c_slaS_checked = 0;
				$c_slaM_checked = 0;
				$imgSlaS = 'checked.png';
				$imgSlaR = 'checked.png';
				$imgSlaM = 'checked.png';

				$c_slaSR_blue = 0;
				$c_slaSR_yellow = 0;
				$c_slaSR_red = 0;
				$c_slaSR_checked = 0;
				
				
				$dtS = new dateOpers; //solu√ß„o
				$dtR = new dateOpers; //resposta							
				$dtM = new dateOpers; //tempo entre resposta e solu√ß„o							 
				 
				$cont = 0;
							 
							// print "TÙ aqui.";
				while ($row = mysql_fetch_array($resultado))  {

					// if (array_key_exists($row['cod_area'],$H_horarios)){  //verifica se o cÛdigo da ·rea possui carga hor·ria definida no arquivo config.inc.php
						// $area = $row['cod_area']; //Recebe o valor da ·rea de atendimento do chamado
					// } else $area = 1; //Carga hor·ria default definida no arquivo config.inc.php
					$areaReal=$row['cod_area'];
					$area=testaArea($area,$row['cod_area'],$H_horarios);

					$dtR->setData1($row['data_abertura']);
					$dtR->setData2($row['data_atendimento']);									
					$dtR->tempo_valido($dtR->data1,$dtR->data2,$H_horarios[$area][0],$H_horarios[$area][1],$H_horarios[$area][2],$H_horarios[$area][3],"H");

					$dtS->setData1($row['data_abertura']);
					$dtS->setData2($row['data_fechamento']);									
					$dtS->tempo_valido($dtS->data1,$dtS->data2,$H_horarios[$area][0],$H_horarios[$area][1],$H_horarios[$area][2],$H_horarios[$area][3],"H");
					$t_horas = $dtS->diff["hValido"];
					
					$dtM->setData1($row['data_atendimento']);
					$dtM->setData2($row['data_fechamento']);									
					$dtM->tempo_valido($dtM->data1,$dtM->data2,$H_horarios[$area][0],$H_horarios[$area][1],$H_horarios[$area][2],$H_horarios[$area][3],"H");
					//-----------------------------------------------------------------

					$sql_status = "select sum(T.ts_tempo) as segundos, sec_to_time(sum(T.ts_tempo)) as tempo, 
								T.ts_status as codStat, A.sistema as area, CAT.stc_desc as dependencia, CAT.stc_cod as cod_dependencia
							from ocorrencias as O, tempo_status as T, `status` as S, sistemas as A, status_categ as CAT
							where O.numero = T.ts_ocorrencia and O.numero = ".$row['numero']." and S.stat_id = T.ts_status and S.stat_cat = CAT.stc_cod and
								O.sistema = A.sis_id and O.sistema =$areaReal and O.status = 4 and O.data_fechamento >= '$d_ini_completa'  
								and O.data_fechamento <='$d_fim_completa'
							group by A.sis_id,CAT.stc_desc
							order by CAT.stc_cod";	
					$exec_sql_status = mysql_query($sql_status);
										
					//-----------------------------------------------------------------
						//PARA CHECAR O SLA DO PROBLEMA -  TEMPO DE SOLU√á√ÉO
					$t_segundos_total = $dtS->diff["sValido"];
					
					if ($row['tempo'] !=""){	
						if ($t_segundos_total <= ($row['tempo']*60))  { //transformando em segundos
								//$corSLA = $corSla1;
								$imgSlaS = 'sla1.png';
								$c_slaS_blue++;
						}else if ($t_segundos_total <= ( ($row['tempo']*60) + (($row['tempo']*60) *$percLimit/100)) ){ //mais 20%
								//$corSLA = $corSla2;
								$imgSlaS = 'sla2.png';
								$c_slaS_yellow++;
						} else {
							//$corSLA = $corSla3;
							$imgSlaS = 'sla3.png';
							$c_slaS_red++;
						}
					} else {
						$imgSlaS = 'checked.png';
						$c_slaS_checked++;
					}
					//-------------------------------------------------------------------             
					 //PARA CHECAR O SLA DO SETOR - TEMPO DE RESPOSTA   
					
					$t_segundos_resposta = $dtR->diff["sValido"];    
					if ($row['resposta'] != "") {    
						if ($t_segundos_resposta <= ($row['resposta']*60))  { //transformando em segundos
								//$corSLA = $corSla1;
								$imgSlaR = 'sla1.png';
								$c_slaR_blue++;
								$chamadosRgreen[]=$row['numero'];
						}else if ($t_segundos_resposta <= ( ($row['resposta']*60) + (($row['resposta']*60) *$percLimit/100)) ){ //mais 20%
								//$corSLA = $corSla2;
								$imgSlaR = 'sla2.png';
								$c_slaR_yellow++;
								$chamadosRyellow[]=$row['numero'];
						} else {
							//$corSLA = $corSla3;
							$imgSlaR = 'sla3.png';
							$c_slaR_red++;
							$chamadosRred[]=$row['numero'];
						}
					} else {
						$c_slaR_checked++;
						$imgSlaR = 'checked.png';
					}
					//-----------------------------------------------------------------------            
						$t_segundos_m = $dtM->diff["sValido"];

						if ($row['tempo'] !=""){ //est„o em minutos	
						if ($t_segundos_m <= ($row['tempo']*60))  { //transformando em segundos
								$imgSlaM = 'sla1.png';
								$c_slaM_blue++;
						}else if ($t_segundos_m <= ( ($row['tempo']*60) + (($row['tempo']*60) *$percLimit/100)) ){ //mais 20%
								$imgSlaM = 'sla2.png';
								$c_slaM_yellow++;
						} else {
							$imgSlaM = 'sla3.png';
							$c_slaM_red++;
						}
						} else {
						$imgSlaM = 'checked.png';
						$c_slaM_checked++;
						}                    	
						if ($t_horas>=$sla3){ //>=6
						$cor = $corSla3;
						$sla_red++;

						}else if ($t_horas>=$sla2)  {
						$cor = $corSla2;
						$sla_yellow++;
						} else {
						$cor = $corSla1;
						$sla_green++;

						}
					#######################################################################
					$t_resp = $dtR->diff["sValido"];
				
					if ($t_resp>=$slaR3) {//>=6
						$corR = $corSla3;
						$slaR_red++;
					} else if ($t_resp>=$slaR2)  {
						$corR = $corSla2;
						$slaR_yellow++;
					}  else  {
						$corR = $corSla1;
						$slaR_green++;
					}

					$total_sol_segundos+= $dtS->diff["sFull"]; 
					$total_res_segundos+=$dtR->diff["sFull"];					
					$total_res_valido+=$dtR->diff["sValido"];
					$total_sol_valido+=$dtS->diff["sValido"];
					//Linhas de dados do relatÛrio
					$texto = $row['descc']; 	
					if (strlen($texto)>30){
						$texto = substr($texto,0,25)." ... ";
					}																
						print "<tr id='linha".$cont."' onMouseOver=\"destaca('linha".$cont."');\" onMouseOut=\"libera('linha".$cont."');\"  onMouseDown=\"marca('linha".$cont."');\">"; 
							print "<td><a onClick= \"javascript: popup_alerta('mostra_consulta.php?popup=true&numero=".$row['numero']."')\"><font color='blue'>$row[numero]</font></a></td>
								   <td><font color=$corR>".$row['data_abertura']."</font></td>
								   <td><font color=$corR>".$row['contatoc']."</font></td>

								   <td><font color=$corR>".$texto."</font></td>															   
								   <td><font color=$cor>".$dtS->tValido."</font></td>
								   <td><font color=$corR>".$row['operador']."</font></td>";														
									if ($row['usu_nota'] == 7) {
										print "<TD ".$valign."><img src='".ICONS_PATH."info.png' width='16' height='16'> N„o qualificado</TD>";
									}
									else if ($row['usu_nota'] == 1) {
										print "<TD ".$valign."><img src='".ICONS_PATH."3star.png' width='48' height='16'>  Excelente</TD>";
									}
									else if ($row['usu_nota'] == 2) {
										print "<TD ".$valign."><img src='".ICONS_PATH."2star.png' width='48' height='16'>  Muito bom </TD>";
									}
								
									else if ($row['usu_nota'] == 3) {
										print "<TD ".$valign."><img src='".ICONS_PATH."1star.png' width='48' height='16'>  Bom</TD>";
									}
									else if ($row['usu_nota'] == 4) {
										print "<TD ".$valign."><img src='".ICONS_PATH."4star.png' width='48' height='16'><font color=red><b> Regular</b></font></TD>";
									} else if ($row['usu_nota'] == 5) {
										print "<TD ".$valign."><img src='".ICONS_PATH."5star.png' width='48' height='16'><font color=red><b> PÈssimo</b></font></TD>";
									} 
						print "</tr>"; 	
							$dependUser = 0;
							$dependTerc = 0;
							$dependNone = 0;
							while ($row_status = mysql_fetch_array($exec_sql_status)){
								//print $row_status['dependencia'].": ".$row_status['tempo']." | ";
								if ($row_status['cod_dependencia'] == 1) {//dependente ao usu·rio
									$dependUser+= $row_status['segundos'];
								} else
								if ($row_status['cod_dependencia'] == 3 ){ //dependente de terceiros
									$dependTerc+=$row_status['segundos'];
								} else
								if ($row_status['cod_dependencia'] == 4 ){ //dependente de terceiros
									$dependNone+=$row_status['segundos'];
								}
							
							}
							// 																
							$cont++;
				}//while chamados
							
							$media_resposta_geral = $dtR->secToHour(floor($total_res_segundos/$linhas));
							$media_solucao_geral = $dtS->secToHour(floor($total_sol_segundos/$linhas));
							$media_resposta_valida = $dtR->secToHour(floor($total_res_valido/$linhas));
							$media_solucao_valida = $dtS->secToHour(floor($total_sol_valido/$linhas));
			
					//print "<tr><td colspan=5><b>M√âDIAS -></td><td><b>$media_resposta_valida</td><td><B>$media_solucao_valida</td></tr>";	
							
							//MEDIAS DE SOLU«√O
							$perc_ate_sla2=round((($sla_green*100)/$linhas),2);
							$perc_ate_sla3=round((($sla_yellow*100)/$linhas),2);
							$perc_mais_sla3=round((($sla_red*100)/$linhas),2);
							//MEDIAS DE RESPOSTA
							$perc_ate_slaR2=round((($slaR_green*100)/$linhas),2);
							$perc_ate_slaR3=round((($slaR_yellow*100)/$linhas),2);
							$perc_mais_slaR3=round((($slaR_red*100)/$linhas),2);

							$slaR2M = $slaR2/60;
							$slaR3M = $slaR3/60;
	#####################################################################################						
			//TOTAL DE HORAS V√ÅLIDAS NO PERÕçODO:
							$area_fixa = 1;//Padrao 
							$dt = new dateOpers;
							$dt->setData1($d_ini_completa);
							$dt->setData2($d_fim_completa);									
							$dt->tempo_valido($dt->data1,$dt->data2,$H_horarios[$area_fixa][0],$H_horarios[$area_fixa][1],$H_horarios[$area_fixa][2],$H_horarios[$area_fixa][3],"H");
							$hValido = $dt->diff["hValido"]+1; //Como o perÌodo passado n„o È arredondado (xx/xx/xx 23:59:59) È necess·rio arrendondar o total de horas.
     ####################################################################################							
							print "</table>";
							

							##TRANSFORMA«’ES DOS ARRAYS
							
							$numerosRed=putComma($chamadosSred);
							$numerosYellow=putComma($chamadosSyellow);
							$numerosGreen=putComma($chamadosSgreen);

							$numerosRred=putComma($chamadosRred);
							$numerosRyellow=putComma($chamadosRyellow);
							$numerosRgreen=putComma($chamadosRgreen);							
							
							
							

					} // switch		
				} //if($linhas==0)
			}//if  $d_ini_completa <= $d_fim_completa
			else 
			{
				$aviso = "A data final n„o pode ser menor do que a data inicial. Refa√ßa sua pesquisa.";
				print "<script>mensagem('".$aviso."'); history.back();</script>";
				}
		}//if ((empty($d_ini)) and (empty($d_fim)))
        
        
}//if $ok==Pesquisar
?>

<script type='text/javascript'>

<!--			
	team = new Array(
<?
$sql="select * from sistemas where sis_status NOT in (0) order by sistema";//Somente as ·reas ativas
$sql_result=mysql_query($sql);
echo mysql_error();
$num=mysql_numrows($sql_result);
while ($row_A=mysql_fetch_array($sql_result)){
$conta=$conta+1;
	$cod_item=$row_A["sis_id"];
		echo "new Array(\n";
		$sub_sql="select * from usuarios u left join sistemas s on u.AREA = s.sis_id where u.AREA=$cod_item or u.AREA is null order by u.nome";
		$sub_result=mysql_query($sub_sql);
		$num_sub=mysql_numrows($sub_result);
		if ($num_sub>=1){
			echo "new Array(\"-->Todos<--\", -1),\n";
			while ($rowx=mysql_fetch_array($sub_result)){
				$codigo_sub=$rowx["user_id"];
				$sub_nome=$rowx["nome"];
			$conta_sub=$conta_sub+1;
				if ($conta_sub==$num_sub){
					echo "new Array(\"$sub_nome\", $codigo_sub)\n";
					$conta_sub="";
				}else{
					echo "new Array(\"$sub_nome\", $codigo_sub),\n";
				}
			}
		}else{
			echo "new Array(\"Qualquer\", -1)\n";
		}
	if ($num>$conta){
		echo "),\n";
	}
}
echo ")\n";
echo ");\n";
?>

function fillSelectFromArray(selectCtrl, itemArray, goodPrompt, badPrompt, defaultItem) {
	var i, j;
	var prompt;
	// empty existing items
	for (i = selectCtrl.options.length; i >= 0; i--) {
		selectCtrl.options[i] = null; 
	}
	prompt = (itemArray != null) ? goodPrompt : badPrompt;
	if (prompt == null) {
		j = 0;
	}
	else {
		selectCtrl.options[0] = new Option(prompt);
		j = 1;
	}
	if (itemArray != null) {
		// add new items
		for (i = 0; i < itemArray.length; i++) {
			selectCtrl.options[j] = new Option(itemArray[i][0]);
			if (itemArray[i][1] != null) {
				selectCtrl.options[j].value = itemArray[i][1]; 
			}
			j++;
		}
	// select first item (prompt) for sub list
	selectCtrl.options[0].selected = true;
   }
}		
		
		
			 function popup(pagina)	{ //Exibe uma janela popUP
				x = window.open(pagina,'popup','dependent=yes,width=400,height=200,scrollbars=yes,statusbar=no,resizable=yes');
				//x.moveTo(100,100);
				x.moveTo(window.parent.screenX+100, window.parent.screenY+100);	  	
				return false
			 }
             
			 function popup_alerta(pagina)	{ //Exibe uma janela popUP
                x = window.open(pagina,'_blank','dependent=yes,width=700,height=470,scrollbars=yes,statusbar=no,resizable=yes');
                //x.moveTo(100,100);
                x.moveTo(window.parent.screenX+50, window.parent.screenY+50);	  	
                return false
             }
    
		function checar() {
			var checado = false;
			if (document.form1.novaJanela.checked){
		      	checado = true;
				//document.form1.target = "_blank";
				
			} else {
		      	checado = false;
				//document.form1.target = "";
			}
			return checado;
		}		
		
		window.setInterval("checar()",1000);
		
		
				function valida(){
					var ok = validaForm('idD_ini','DATA-','Data Inicial',1);
					if (ok) var ok = validaForm('idD_fim','DATA-','Data Final',1);
			
					if (ok) submitForm();
					
					return ok;
				}								
		
		
				function submitForm()
				{
					
					if (checar() == true) {
						document.form1.target = "_blank";
						document.form1.submit();
					} else {
						document.form1.target = "";
						document.form1.submit();
					}
		
				}

		
		-->
	
	</script>
