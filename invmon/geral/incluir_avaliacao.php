<?php session_start();
 

	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");


	$_SESSION['s_page_ocomon'] = $_SERVER['PHP_SELF'];

	$imgsPath = "../../includes/imgs/";
	//$hoje = date("Y-m-d H:i:s");

	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],4);

	$qry_config = "SELECT * FROM config ";
	$exec_config = mysql_query($qry_config) or die (TRANS('ERR_QUERY'));
	$row_config = mysql_fetch_array($exec_config);
	

	$qry = $QRY["useropencall_custom"];
	
	//if(!empty($_SESSION['s_screen'])){
		$qry.= " AND  c.conf_cod = '".$_SESSION['s_screen']."'";
	//}
	
	//dump($qry,'QUERY:');
	//dump($_SESSION);
	//exit;
	
	$execqry = mysql_query($qry);
	$rowconf = mysql_fetch_array($execqry);
	
	
	$qryconfglobal = $QRY["useropencall"];
	$execqryglobal = mysql_query($qryconfglobal);
	$rowconf_global = mysql_fetch_array($execqryglobal);
	
	//dump($rowconf,'ROWCONF');

	$qryarea = "SELECT * FROM sistemas where sis_id = ".$_SESSION['s_area']."";
	$execarea = mysql_query($qryarea);
	$rowarea = mysql_fetch_array($execarea);



	print "<HTML>";
	print "<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>";
	print "<BODY bgcolor=".BODY_COLOR." onLoad=\"";//onLoad=\"Habilitar();

	//if ($rowconf['conf_scr_prob'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
	if ((!empty($rowconf) && $rowconf['conf_scr_prob']) || empty($rowconf)) {
		print "ajaxFunction('Problema', 'showSelProbs.php', 'idLoad', 'prob=idProblema', 'area_cod=idArea','radio_prob=idRadioProb', 'area_habilitada=idAreaHabilitada');";
		print "ajaxFunction('divProblema', 'showProbs.php', 'idLoad', 'prob=idProblema', 'area_cod=idArea', 'radio_prob=idRadioProb'); ";
		
		print "ajaxFunction('divInformacaoProblema', 'showInformacaoProb.php', 'idLoad', 'prob=idProblema', 'area_cod=idArea'); ";	
	
	}

	//if ($rowconf['conf_scr_local'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
	if ((!empty($rowconf) && $rowconf['conf_scr_local']) || empty($rowconf)) {

		if (((!empty($rowconf) && $rowconf['conf_scr_unit']) || empty($rowconf))  && ((!empty($rowconf) && $rowconf['conf_scr_tag']) || empty($rowconf))) { 
			print "ajaxFunction('idDivSelLocal', 'showSelLocais.php', 'idLoad', 'unidade=idUnidade', 'etiqueta=idEtiqueta'); ";
		} else
			print "ajaxFunction('idDivSelLocal', 'showSelLocais.php', 'idLoad'); ";
	}
	if ((!empty($rowconf) && $rowconf['conf_scr_foward']) || empty($rowconf)) {
		print "ajaxFunction('divOperator', 'showOperators.php', 'idLoad');";
	}

	print "\">";

	//if (!$rowconf['conf_user_opencall'] and !$rowarea['sis_atende']){ //VER
	if ((!empty($rowconf) && !$rowconf['conf_user_opencall'])) {
			print "<script>mensagem('".TRANS('MSG_DISABLED_OPENCALL','A abertura de chamados est? desabilitada no sistema',0)."!'); redirect('abertura.php');</script>";
	}


	if (isset($_REQUEST['pai'])) {

		$sql = "select o.*, s.* from ocorrencias o, `status` s where o.`status` = s.stat_id and s.stat_painel not in (3) and o.numero = ".$_REQUEST['pai']."";
		$execSql = mysql_query($sql) or die (TRANS('ERR_QUERY'));
		$ocoOK = mysql_num_rows ($execSql);
		if ($ocoOK != 0) {
			$subCallMsg = "<font color='red'>".TRANS('MSG_OCCO_SUBTICKET')."&nbsp;".$_REQUEST['pai']."</font>";
		} else {
			//$subCallMsg = "<font color='red'>A ocorrencia ".$_REQUEST['pai']." n?o pode possuir subchamados pois n?o est? aberta no sistema!</font>";
			print "<script>mensagem('A ocorrencia ".$_REQUEST['pai']." nao pode possuir subchamados pois nao esta aberta no sistema!'); window.close();</script>";
			exit;
		}

	} else $subCallMsg = "";


print "<BR><B>".TRANS('OCO_TTL_OPENCALL','Abertura de Ocorr?ncias').":&nbsp;".$subCallMsg."</B><BR>";
print "<FORM name='form1' method='POST' action='".$_SERVER['PHP_SELF']."'  ENCTYPE='multipart/form-data'  onSubmit=\"return valida()\">";
	print "<input type='hidden' name='MAX_FILE_SIZE' value='".$row_config['conf_upld_size']."' />";
print "<TABLE border='0'  align='center' width='100%' bgcolor='".BODY_COLOR."'>";


	if (isset($_POST['carrega'])){

		$sqlTag = "select c.*, l.* from equipamentos c, localizacao l where c.comp_local=l.loc_id and c.comp_inv=".$_POST['equipamento']." and c.comp_inst=".$_POST['instituicao']."";
		$execTag = mysql_query($sqlTag);
		$rowTag = mysql_fetch_array($execTag);

		//$invTag = $rowTag['comp_inv'];
		$invTag = $_POST['equipamento'];
		$invInst = $rowTag['comp_inst'];
		$invLoc = $rowTag['comp_local'];
		$contato = $_POST['contato'];
		$telefone = $_POST['telefone'];

		if (isset($_POST['radio_prob'])){
			$radio_prob = $_POST['radio_prob'];
		} else $radio_prob = -1;

		if (isset($_POST['problema'])) 	{
			$problema = $_POST['problema'];
		}else {
			$problema = -1;
		}
		
		if (isset($_POST['foward'])){
			$foward = $_POST['foward'];
		} else {
			$foward = -1;
		}

	} else {

		$invTag = "";
		$invInst = "";
		$invLoc = "";
		$contato = "";
		$telefone = "";
		if (isset($_POST['problema'])) 	{
			$radio_prob = $_POST['problema'];
			$problema = $_POST['problema'];
		}else {
			$radio_prob = -1;
			$problema = -1;
		}
		
		if (isset($_POST['foward'])){
			$foward = $_POST['foward'];
		} else {
			$foward = -1;
		}		
		
	}
	
	#### TESTE KARINE ##### 
		print "<TR>";
				print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('FIELD_TYPE_ATEND').":</TD>";
				print "<TD  width='30%' align='left' bgcolor='".BODY_COLOR."'>";
				print "<select name='atendimento' class='select' id='id_atend'>";

					print "<option value=-1>".TRANS('FIELD_TYPE_ATEND')."</option>";
						$sql2="select * from tipo_atend";
						$commit2 = mysql_query($sql2);
						while($rowB = mysql_fetch_array($commit2)){
							print "<option value=".$rowB["id_atend"].">".$rowB["id_atend"]." - ".$rowB["descricao"]."</option>";
						} // while
	
				print "</select>";
				print "</td>";
		
		
		##### FIM TESTE KARINE #####
		
			


		//if ($rowconf['conf_scr_local'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
		if ((!empty($rowconf) && $rowconf['conf_scr_local']) || empty($rowconf)) {
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_LOCAL','Local').": ";
				//if ($rowconf['conf_scr_btloadlocal'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
				if ((!empty($rowconf) && $rowconf['conf_scr_btloadlocal']) || empty($rowconf)) {
 					//print "<input type='submit' class='btPadrao' id='idBtCarrega' title='".TRANS('LOAD_EQUIP_LOCAL')."'onClick=\"LOAD=1;\"".
 						//"style=\"{align:center; valign:middle; width:19px; height:19px; background-image: url('../../includes/icons/kmenu-hack.png'); background-repeat:no-repeat;}\" value='' name='carrega'>";

 					print "<input type='button' class='btPadrao' id='idBtCarrega' title='".TRANS('LOAD_EQUIP_LOCAL')."' ".
 							"onClick=\"ajaxFunction('idDivSelLocal', 'showSelLocais.php', 'idLoad', 'unidade=idUnidade', 'etiqueta=idEtiqueta');\"".
 							"style=\"{align:center; valign:middle; width:19px; height:19px; background-image: url('../../includes/icons/kmenu-hack.png'); background-repeat:no-repeat;}\" value='' name='carrega'>";

				}
			print "</TD>";

			
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TLT_AVALIACAO').":</TD>";
			print "<TD width='30%' align='left' bgcolor='".BODY_COLOR."'>";
				print "<select class='select' name='nota_aval_id' id='nota_aval_id'>";
				
					$qrynota = "select * from nota_aval ";
					$exec_nota = mysql_query($qrynota);
					print "<option value=-1>".TRANS('OCO_SELECIONE_AVAL')."</option>";
					while($row=mysql_fetch_array($exec_nota)){
						print "<option value=".$row['nota_aval_id']."";
							if ($row['nota_aval_id']== $nota) {
								print " selected";
							}
						print ">".$row['nota_aval']."</option>";
					}

			print "</TD>";
			print "</TR>";

				//<!--{ background-image: url('/images/css.gif');} -->
			print "<TD width='30%' align='left' bgcolor=".BODY_COLOR.">";

			if (isset($_GET['invLoc'])){
				$invLoc = $_GET['invLoc'];
			} else
			if (!isset($_POST['carrega'])){
				if (isset($_POST['local'])){
					$invLoc = $_POST['local'];
				}
			}


				print "<div id='idDivSelLocal'>";
				print "</div>";

				//if ($rowconf['conf_scr_searchbylocal'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
				if ((!empty($rowconf) && $rowconf['conf_scr_searchbylocal']) || empty($rowconf)) {
					print "<a onClick=\"checa_por_local()\"><img title='".TRANS('CONS_EQUIP_LOCAL')."' width='15' height='15' src='".$imgsPath."consulta.gif' border='0'></a>";
				}
			print "</td>";


		} else {
			$local = -1;
			print "<input type='hidden' name='local' value='-1'>";
		}

		//if ($rowconf['conf_scr_operator'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
		if ((!empty($rowconf) && $rowconf['conf_scr_operator']) || empty($rowconf)) {
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_OPERATOR','Operador').":</TD>";
			print "<TD width='30%' align='left' bgcolor=".BODY_COLOR."><input class='disable' value='".$_SESSION['s_usuario']."' readonly></TD>";
		} else {
			$operador = $_SESSION['s_usuario'];
			print "<input type='hidden' name='operador' value='".$operador."'>";
		}
        	print "</TR>";


        	print "<TR>";

		//if ($rowconf['conf_scr_date'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
		if ((!empty($rowconf) && $rowconf['conf_scr_date']) || empty($rowconf)) {
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_DATE_OPEN','Data de abertura').":</TD>";
                	print "<TD width='30%' align='left' bgcolor=".BODY_COLOR."><input name='data_abertura' class='disable' value='".date("d/m/Y H:i:s")."' readonly></TD>";//datab($hoje)
		}
		//if ($rowconf['conf_scr_status'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
		if ((!empty($rowconf) && $rowconf['conf_scr_status']) || empty($rowconf)) {
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_STATUS','Status').":</TD>";
                	print "<TD width='30%' align='left' bgcolor=".BODY_COLOR.">".TRANS('OCO_WAITING_STATUS','Aguardando atendimento')."</TD>";
		}
        	print "</TR>";

        	print "<TR>";

		//if ($rowconf['conf_scr_schedule'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
		if ((!empty($rowconf) && $rowconf['conf_scr_schedule']) || empty($rowconf)) {
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_SCHEDULE').": <input type='checkbox' value='ok' name='chk_squedule' onChange=\"checarSchedule();\"></TD>";
                	print "<TD width='30%' align='left' bgcolor=".BODY_COLOR."><input type='text' name='date_schedule' id='idDate_schedule' class='text' value='".formatDate(date("Y-m-d H:i:s"))."' disabled></TD>";
		}

		//if ($rowconf['conf_scr_replicate'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
		if ((!empty($rowconf) && $rowconf['conf_scr_replicate']) || empty($rowconf)) {
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_REPLICATE','Replicar este chamado mais')."</TD>";
		print "<TD  bgcolor=".BODY_COLOR."><INPUT type='text' class='mini' name='replicar' id='idReplicar' value='0' maxlength='2'>&nbsp;".TRANS('TIMES','vezes').".</TD> ";
		} else $replicar = 0;

        	print "</TR>";

		print "<tr>";
		
		if ((!empty($rowconf) && $rowconf['conf_scr_prior']) || empty($rowconf)) {
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('OCO_PRIORITY').":</TD>";
			print "<TD  width='30%' align='left' bgcolor='".BODY_COLOR."'>";
				print "<select name='prioridade' class='select' id='idPrioridade'>";
	
				$sql = "select * from prior_atend where pr_default = 1 ";
				$commit1 = mysql_query($sql);
				$rowR = mysql_fetch_array($commit1);
					print "<option value=-1>".TRANS('OCO_PRIORITY')."</option>";
						$sql2="select * from prior_atend order by pr_nivel";
						$commit2 = mysql_query($sql2);
						while($rowB = mysql_fetch_array($commit2)){
							print "<option value=".$rowB["pr_cod"]."";
							if ($rowB['pr_cod'] == $rowR['pr_cod'] ) {
								print " selected";
							}
							print ">".$rowB["pr_desc"]."</option>";
						} // while
	
				print "</select>";
				print "</td>";
		} else {
			$sql = "select * from prior_atend where pr_default = 1 ";
			$commit1 = mysql_query($sql);
			$rowR = mysql_fetch_array($commit1);			
			print "<input type='hidden' name='prioridade' value='".$rowR['pr_cod']."'>";
		}
		
	
		
		//if ($rowconf['conf_scr_foward'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
		if ((!empty($rowconf) && $rowconf['conf_scr_foward']) || empty($rowconf)) {
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_FOWARD').":</TD>";
//                 	print "<TD width='30%' align='left' bgcolor=".BODY_COLOR.">";
// 
// 				print "<SELECT class='select' name='foward' id='idFoward' onChange=\"checkMailOper();\">";
//                     	    		print "<option value='-1' selected>".TRANS('OCO_SEL_OPERATOR')."</option>";
//                     	    	$query = "SELECT u.*, a.* from usuarios u, sistemas a where u.AREA = a.sis_id and a.sis_atende='1' and u.nivel not in (3,4,5) order by login";
//                         	$exec_oper = mysql_query($query);
//         	                while ($row_oper = mysql_fetch_array($exec_oper))
//             	            	{
// 					print "<option value=".$row_oper['user_id'].">".$row_oper['nome']."</option>";
// 				}
//                 	        print "</SELECT>";
//                 	print "</TD>";
			print "<TD width='30%' align='left' bgcolor=".BODY_COLOR.">";
				print "<div id='divOperator'>";
					print "<input type='hidden' name='foward' id='idFoward' value='".$foward."'>";
					//print "<input type='hidden' name='problema' id='idProblema' value='-1'>";
				print "</div>";
            		print "</TD>";		
		
		}

		print "</tr>";

		/* ----------------- INICIO ALTERACAO ----------------- */
		print "<tr>";
		print "<td colspan='4'>";
		if ((!empty($rowconf) && $rowconf['conf_scr_upload']) || empty($rowconf)) {
			for($i=1;$i<=$row_config['conf_qtd_max_anexos']; $i++){
				$estilo = 'width: 100%; margin: 0; height: 20px; margin-bottom: 2px;';
				if($i > 1)
					$estilo .= " display: none;";
				print "<div id='tr_anexo_$i' style='{ $estilo }'>";					
				//print "<tr id='tr_anexo_$i' $estilo>";
					print "<div style='{width: 20%; height: 100%; background-color: ".TD_COLOR."; float: left; margin: 0;}'>".TRANS('OCO_FIELD_ATTACH_FILE','Anexar arquivo').":</div>";
					print "<div style='{width: 70%; background-color: ".BODY_COLOR."; float: left; margin-left: 2px;}'>";
					print "		<INPUT type='file' class='text' name='anexo_$i' id='id_anexo_$i' />";
					if($i != $row_config['conf_qtd_max_anexos']){
						print "		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
						print "<a id='link_adic_$i'
									onclick=\"
									javascript:document.getElementById('tr_anexo_".($i+1)."').style.display='block';
									document.getElementById('link_adic_".($i)."').style.display='none';
								\">&nbsp;&nbsp;".TRANS('ATTACH_ANOTHER')."</a>";
					}
					print "</div>";
				print "</div>";
			}
		}
		print "</td>";
		print "</tr>";
		/* ----------------- FIM ALTERACAO ----------------- */
		
		
		print "<tr>";
		//if ($rowconf['conf_scr_mail'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
		if ((!empty($rowconf) && $rowconf['conf_scr_mail']) || empty($rowconf)) {
			print "<td bgcolor='".TD_COLOR."'>".TRANS('OCO_FIELD_SEND_MAIL_TO','Enviar e-mail para').":</td>".
				"<td colspan='2'><input type='checkbox' value='ok' name='mailAR' checked>".TRANS('OCO_FIELD_AREA','')."&nbsp;&nbsp;".
								"<input type='checkbox' value='ok' name='mailOP' disabled title='".TRANS('HNT_SENDMAIL_OPERATOR_SEL_CALL')."'>".TRANS('OCO_FIELD_OPERATOR')."&nbsp;&nbsp;".
								"<input type='checkbox' value='ok' name='mailUS' disabled>".TRANS('OCO_FIELD_USER','Usu?rio')."</td>";
		}
		print "</tr>";


		if (!empty($invTag)){
			$saida = "javascript:window.close()";
		} else
			$saida = "javascript:location.href='abertura.php'";



		print "<TR>";
	        print "<BR>";

		if (isset($_REQUEST['pai'])) {
			print "<input type='hidden' name='pai' value='".$_REQUEST['pai']."'>";
		}

			print "<input type='hidden' name='data_gravada' value='".date("Y-m-d H:i:s")."'>";


		
		
		print "<TD colspan='2' align='center' width='50%' bgcolor='".BODY_COLOR."'><input type='submit' id='idSubmit' class='button' value='".TRANS('BT_OK','OK', 0)."' name='OK' onClick=\"LOAD=0;\">";
		print "</TD>";

		print "<TD colspan='2' align='center' width='50%' bgcolor='".BODY_COLOR."'><INPUT type='button' class='button' value='".TRANS('BT_CANCEL','Cancelar',0)."' name='desloca' OnClick=".$saida."></TD>";
		print 
		
		
	
		
		"</TR>";

		$aviso="";
		if (isset($_POST['OK'])==TRANS('BT_OK')) {


			$queryB = "SELECT sis_id,sistema, sis_email FROM sistemas WHERE sis_id = ".$sistema."";
			$sis_idB = mysql_query($queryB);
			$rowSis = mysql_fetch_array($sis_idB);

			//if ($rowconf['conf_scr_local'] || !isIn($_SESSION['s_area'],$rowconf['conf_custom_areas'])) {
			if ((!empty($rowconf) && $rowconf['conf_scr_local']) || empty($rowconf)) {
				$queryC = "SELECT local from localizacao where loc_id = ".$_POST['local']."";
				$loc_idC = mysql_query($queryC);
				$setor = mysql_result($loc_idC,0);
			}

			$queryD = "SELECT u.*,a.* from usuarios u, sistemas a where u.AREA = a.sis_id and user_id=".$_SESSION['s_uid']."";
			$loginD = mysql_query($queryD);
			$rowqryD = mysql_fetch_array($loginD);
			$nome = $rowqryD['nome'];

			/* ----------------- INICIO ALTERACAO ----------------- */
			$gravaImg = false;
			$qryConf = "SELECT * FROM config";
			$execConf = mysql_query($qryConf) or die (TRANS('ERR_QUERY').", A TABELA CONF FOI CRIADA?");
			$rowConf = mysql_fetch_array($execConf);
			$arrayConf = array();
			$arrayConf = montaArray($execConf,$rowConf);
			for($i=1;$i<=$row_config['conf_qtd_max_anexos']; $i++){
				$nomeAnexo = 'anexo_'.$i;
				if (isset($_FILES[$nomeAnexo]) and $_FILES[$nomeAnexo]['name']!="") {
					$upld = upload($nomeAnexo,$arrayConf,$rowConf['conf_upld_file_types']);
					if ($upld =="OK") {
						$gravaImg[$i] = true;
					} else {
						$gravaImg[$i] = false;
						$upld.="<br><a align='center' onClick=\"exibeEscondeImg('idAlerta');\"><img src='".ICONS_PATH."/stop.png' width='16px' height='16px'>&nbsp;".TRANS('LINK_CLOSE','Fechar')."</a>";
						print "</table>";
						print "<div class='alerta' id='idAlerta'><table bgcolor='#999999'><tr><td colspan='2' bgcolor='yellow'>".$upld."</td></tr></table></div>";
						exit;
					}
				}
			}
			/* ----------------- FIM ALTERACAO ----------------- */

			//$data = date("Y-m-d H:i:s");
			$i = 0;

			if (!isset($_POST['replicar'])){
				$replicate = 0;
			} else {
				$replicate = $_POST['replicar'];
			}

			$date_schedule = date("Y-m-d H:i:s");

			while ($i<=$replicate) //'".noHtml($descricao)."'
			{
					$operator = $_SESSION['s_uid'];


					if (isset($_POST['chk_squedule']) && $_POST['chk_squedule']!=""){
						$schedule = 1;
						$date_schedule = FDate($_POST['date_schedule']);
						$oStatus = $row_config['conf_schedule_status'];
						$first_queued = false;
					} else {
						$schedule = 0;
						$date_schedule = date("Y-m-d H:i:s");

						if (isset($_POST['foward']) && $_POST['foward']!=-1){
							$oStatus = $row_config['conf_foward_when_open'];
							$operator = $_POST['foward'];
						} else
							$oStatus = 1; //Aguardando atendimento
						
						$first_queued = true;//date("Y-m-d H:i:s");
					}

					//dump($_POST,'POSTS'); exit;
					if (!isset($_POST['radio_prob'])){
						$catProb = $problema;
					} else {
						$catProb = $_POST['radio_prob'];
					}

					$query = "";
					$query = "INSERT INTO ocorrencias (problema, descricao, instituicao, equipamento, sistema, contato, telefone, local, operador, ".
						"data_abertura, data_fechamento, status, data_atendimento, aberto_por, oco_scheduled, oco_real_open_date, date_first_queued, oco_prior, id_atend )".
						" values ".
						//"(".$problema.",  ";
						"(".$catProb.",  ";

					if ($_SESSION['s_formatBarOco']) {
						$query.= " '".$descricao."',";
					} else {
						$query.= " '".noHtml($descricao)."',";
					}

					if (!$schedule){
						$query.="".$_POST['instituicao'].",'".$_POST['equipamento']."','".$sistema."',".
						"'".noHtml($_POST['contato'])."','".$_POST['telefone']."',".$_POST['local'].",".$operator.",".
						" '".$date_schedule."',NULL,".$oStatus.",NULL,".$_SESSION['s_uid'].",".$schedule.", '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."', '".$_POST['prioridade']."','".$_POST['atendimento']."')";
					} else {
						$query.="".$_POST['instituicao'].",'".$_POST['equipamento']."','".$sistema."',".
						"'".noHtml($_POST['contato'])."','".$_POST['telefone']."',".$_POST['local'].",".$operator.",".
						" '".$date_schedule."',NULL,".$oStatus.",NULL,".$_SESSION['s_uid'].",".$schedule.", '".date("Y-m-d H:i:s")."', NULL, '".$_POST['prioridade']."','".$_POST['atendimento']."')";					
					}

					$resultado = mysql_query($query) or die (TRANS('ERR_QUERY'));
						//dump($query);exit;
					$numero = mysql_insert_id();
					$globalID = random();
					
					//GERA ID GLOBAL PARA ACESSO ? OCORR?NCIA
					$qryGlobal = "INSERT INTO global_tickets (gt_ticket, gt_id) values (".$numero.", ".$globalID.")";
					$execGlobal = mysql_query($qryGlobal) or die($qryGlobal);

					//INSERSAO PARA ARMAZENAR O TEMPO DO CHAMADO EM CADA STATUS
					$sql = " insert into tempo_status (ts_ocorrencia, ts_status, ts_tempo, ts_data) values (".$numero.", ".$oStatus.", 0, '".date("Y-m-d H:i:s")."')  ";
					$exec_sql = mysql_query($sql);
					if ($exec_sql == 0) $error = " erro na tabela TEMPO_STATUS ";

					$i++;
			}

			if ($resultado == 0) {
				$aviso.= "ERRO na inclusao dos dados.".$query;
			} else {
				//$numero = mysql_insert_id();

				$sqlDoc = "insert into doc_time (doc_oco, doc_open, doc_edit, doc_close, doc_user) values (".$numero.",".diff_em_segundos($_POST['data_gravada'],date("Y-m-d H:i:s")).", 0, 0, ".$_SESSION['s_uid'].")";
				$execDoc = mysql_query($sqlDoc) or die (TRANS('ERR_QUERY').'br>').$sqlDoc;


				if (isset($_POST['pai'])) {
					$sqlDep = "insert into ocodeps (dep_pai, dep_filho) values (".$_POST['pai'].", ".$numero.")";
					$execDep = mysql_query($sqlDep) or die (TRANS('ERR_QUERY').'<br>'.$sqlDep);
					if ($execDep == 0) $aviso.= TRANS('MSG_NOT_TO_TIE_OCCOR');
				}

				
				
				/* ----------------- INICIO ALTERACAO ----------------- */
				for($i=1;$i<=$row_config['conf_qtd_max_anexos']; $i++){
					if ($gravaImg[$i]) {
						$nomeAnexo = 'anexo_'.$i;
						//INSERSAO DO ARQUIVO NO BANCO
						$fileinput=$_FILES[$nomeAnexo]['tmp_name'];
						$tamanho = getimagesize($fileinput);
						$tamanho2 = filesize($fileinput);
	
						if(chop($fileinput)!=""){
							// $fileinput should point to a temp file on the server
							// which contains the uploaded image. so we will prepare
							// the file for upload with addslashes and form an sql
							// statement to do the load into the database.
							$image = addslashes(fread(fopen($fileinput,"r"), 1000000));
							$SQL = "Insert Into imagens (img_nome, img_oco, img_tipo, img_bin, img_largura, img_altura, img_size) values ".
									"('".noSpace($_FILES[$nomeAnexo]['name'])."',".$numero.", '".$_FILES[$nomeAnexo]['type']."', ".
									"'".$image."', '".$tamanho[0]."', '".$tamanho[1]."', '".$tamanho2."')";
							// now we can delete the temp file
							unlink($fileinput);
						} /*else {
							echo "".TRANS('MSG_NOT_IMAGE_SELECT')."";
							exit;
						}*/
						$exec = mysql_query($SQL); //or die ("N?O FOI POSS?VEL GRAVAR O ARQUIVO NO BANCO DE DADOS! ");
						if ($exec == 0) 
							$aviso.= TRANS('MSG_ATTACH_IMAGE')."<br>";	
					}
				}
				/* ----------------- FIM ALTERACAO ----------------- */


				

		$qrylogado = "SELECT sis_atende FROM sistemas where sis_id = ".$_SESSION['s_area']."";
		$execlogado = mysql_query($qrylogado) or die(TRANS('ERR_QUERY'));
		$rowlogado = mysql_fetch_array($execlogado);

?>
<script type="text/javascript">
<!--

	function valida(){
		var ok = true;
		LOAD=0;
		if (!LOAD) {
			//var ok = false;

			var operador = <?php print $rowlogado['sis_atende']?>;
			var unit = document.getElementById('idUnidade');
			var tag = document.getElementById('idEtiqueta');

			var sel_area = document.getElementById('idArea');
			var sel_problema = document.getElementById('idProblema');
			var descricao = document.getElementById('idDescricao');
			var contato = document.getElementById('idContato');

			//var carreg = '<?php //print $carrega?>';

			if (ok) {
				if (sel_area != null){
					var ok = validaForm('idArea','COMBO','<?php print TRANS('OCO_FIELD_AREA')?>',1);
				} //else ok = true;
			}

			if (ok) {
				if (sel_problema != null){
					var ok = validaForm('idProblema','COMBO','<?php print TRANS('OCO_FIELD_PROB')?>',1);
				} //else ok = true;
			}

			if (ok) {
				if (descricao != null){
					var ok = validaForm('idDescricao','','<?php print TRANS('OCO_FIELD_DESC')?>',1);
				} //else ok = true;
			}

			if (ok) {
				if (unit != null){
					if (operador == 0){
						var ok = validaForm('idUnidade','COMBO','<?php print TRANS('OCO_FIELD_UNIT')?>',1);
					} else ok = true;
				} else ok = true;
			}

			if (ok) {
				if (tag != null){
					if (operador == 1){
						var ok = validaForm('idEtiqueta','INTEIRO','<?php print TRANS('OCO_FIELD_TAG')?>',0);
					} else {
						var ok = validaForm('idEtiqueta','INTEIRO','<?php print TRANS('OCO_FIELD_TAG')?>',1);
					}
				} else ok = true;
			}

			if (ok) {
				if (contato != null){
					var ok = validaForm('idContato','','<?php print TRANS('OCO_FIELD_CONTACT')?>',1);
				} else ok = true;
			}

			if (ok){
				var fone = document.getElementById('idTelefone');
				//if (carreg){
				if (fone != null){
					//var ok = validaForm('idTelefone','INTEIRO','ramal',1);
					var ok = validaForm('idTelefone','FONE','<?php print TRANS('OCO_FIELD_PHONE')?>',1);
				} else ok = true;
				//}
			}
			if (ok){
				var local = document.getElementById('idLocal');
				//if (carreg){
				if (local != null){
					//var ok = validaForm('idTelefone','INTEIRO','ramal',1);
					var ok = validaForm('idLocal','COMBO','<?php print TRANS('OCO_FIELD_LOCAL')?>',1);
				} else ok = true;
				//}
			}
			if (ok){
				var replicate = document.getElementById('idReplicar');
				if (replicate != null){
					var ok = validaForm('idReplicar','INTEIROFULL','<?php print TRANS('OCO_FIELD_REPLICATE')?>',0);
				} else ok = true;
			}
			if (ok){
				var schedule = document.getElementById('idDate_schedule');
				if (schedule != null){
					var ok = validaForm('idDate_schedule','DATAHORA','<?php print TRANS('OCO_FIELD_SCHEDULE')?>',0);
				} else ok = true;
			}
		}
		return ok;

	}

	function popup_alerta(pagina)	{ //Exibe uma janela popUP
      		x = window.open(pagina,'Alerta','dependent=yes,width=700,height=470,scrollbars=yes,statusbar=no,resizable=yes');
      		//x.moveTo(100,100);
		x.moveTo(window.parent.screenX+50, window.parent.screenY+50);
		return false
     	}

	function checa_etiqueta(){
	 	var inst = document.getElementById('idUnidade');
		var inv = document.getElementById('idEtiqueta');
		if (inst != null && inv != null){
			if (inst.value=='null' || !inv.value){
				var msg = '<?php print TRANS('MSG_UNIT_TAG');?>!'
				window.alert(msg);
			} else
			popup_alerta('../../invmon/geral/mostra_consulta_inv.php?comp_inst='+inst.value+'&comp_inv='+inv.value+'&popup='+true);
		}
		return false;
	}


	function checa_chamados(){
	 	var inst = document.getElementById('idUnidade');
		var inv = document.getElementById('idEtiqueta');
		if (inst != null && inv != null){
			if (inst.value=='null' || !inv.value){
				window.alert('<?php print TRANS('FILL_UNIT_TAG');?>');
			} else
			popup_alerta('../../invmon/geral/ocorrencias.php?comp_inst='+inst.value+'&comp_inv='+inv.value+'&popup='+true);
		}
		return false;
	}

	function checa_por_local(){
	 	//var local = document.form1.local.value;
		var local = document.getElementById('idLocal');
		if (local != null) {
			if (local.value==-1){
				window.alert('<?php print TRANS('FILL_LOCATION');?>');
			} else
				popup_alerta('../../invmon/geral/mostra_consulta_comp.php?comp_local='+local.value+'&popup='+true);
		}
		return false;
	}

	function desabilita(v)
	{
		document.form1.OK.disabled=v;

	}

 	function desabilitaCarrega(v){
		//document.form1.carrega.disabled=v;
		var btLoad = document.getElementById('idBtCarrega');
		if (btLoad != null){
			btLoad.disabled = v;
		}
	}

	function Habilitar(){
		var descricao = document.getElementById('idDescricao');
		var ramal = document.getElementById('idTelefone');
		var contato = document.getElementById('idContato');
		var sel_area = document.getElementById('idArea');
		var sel_problema = document.getElementById('idProblema');
		var sel_local = document.getElementById('idLocal');
		var botao = document.getElementById('idSubmit');

		var ok = false;
		var ok2 = true;

		if (descricao != null){
			if (descricao.value == "" ) {ok = true;}
		}
		if (sel_area != null){
			if (sel_area.value ==-1) { ok = true;}
		}
		if (sel_problema != null){
			if (sel_problema.value ==-1) { ok = true;}
		}
		//if (sel_local != null){
			//if (sel_local.value ==-1) { ok = true;}
		//}
		if (ramal != null){
			if (ramal.value =="") { ok = true;}
		}
		if (contato != null){
			if (contato.value =="") {ok = true;}
		}
		if (!ok2)
		{
			//alert('desabilita::true');
			desabilita(true);
			botao.className= "button-disabled";
		} else {
			//alert('desabilita::false');
			desabilita(false);
			botao.className= "button";
		}
	}

	function HabilitarCarrega(){
		var sel_inst = document.getElementById('idUnidade');
		var etiqueta = document.getElementById('idEtiqueta');

		if (sel_inst != null && etiqueta != null){
			if ((sel_inst.value=="null")||(etiqueta.value=="")) {
				desabilitaCarrega(true);
			} else{
				desabilitaCarrega(false);
			}
		}
	}


	function checarSchedule() {
		var checado = false;
		if (document.form1.chk_squedule.checked){
			checado = true;
			disable_schedule(false);
			document.form1.foward.value=-1;
			document.form1.foward.disabled=true;

		} else {
			checado = false;
			disable_schedule(true);
			document.form1.date_schedule.value=document.form1.data_abertura.value;
			document.form1.foward.disabled=false;
		}
		return checado;
	}

	function checkMailOper(){
		if (document.form1.foward.value!=-1){
			document.form1.mailOP.disabled=false;
		} else {
			document.form1.mailOP.disabled=true;
		}
	}

	function disable_schedule(v) {
		document.form1.date_schedule.disabled = v;
		document.form1.date_schedule.focus();
	}


	//window.setInterval("Habilitar()",100);
	window.setInterval("HabilitarCarrega()",200);

//-->
</script>
<?php 
print "</TABLE>";

print "</FORM>";

print "</body>";
print "</html>";
?>
