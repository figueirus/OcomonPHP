<?php
//Tela de cadastro de configuração para preventivas

session_start();

	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");
        print "<link rel='stylesheet' href='../../includes/css/calendar.css.php' media='screen'></LINK>";

	$_SESSION['s_page_admin'] = $_SERVER['PHP_SELF'];

	print "<HTML>";
	print "<head>";
        print "<script language=\"JavaScript\" src=\"../../includes/javascript/calendar.js\"></script>";
	print "</head>";
	print "<BODY bgcolor=".BODY_COLOR." >"; 

	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],1,'helpconfigprev.php');
        
        print "<BR><B>".TRANS('MNL_PREV_CONFIG').":</b><BR>";
        $query = "SELECT * FROM config_preventiva ";
        	$resultado = mysql_query($query) or die (TRANS('ERR_QUERY'));
		$row = mysql_fetch_array($resultado);

        
        if ((empty($_GET['action'])) and empty($_POST['submit'])){

		print "<br><TD align='left'>".
				"<input type='button' class='button' id='idBtIncluir' value='".TRANS('BT_EDIT_CONFIG','',0)."' onClick=\"redirect('".$_SERVER['PHP_SELF']."?action=alter&cellStyle=true');\">".
			"</TD><br><BR>";
		if (mysql_numrows($resultado) == 0)
		{
			echo mensagem(TRANS('ALERT_CONFIG_EMPTY'));
		}
		else
		{
				$cor=TD_COLOR;
				$cor1=TD_COLOR;
				$linhas = mysql_numrows($resultado);
				print "<td>";
				print "<TABLE border='0' cellpadding='5' cellspacing='0'  width='50%'>";
				print "<TR class='header'><td>".TRANS('OPT_DIRETIVA')."</TD><td>".TRANS('OPT_VALOR')."</TD></TD></tr>";
				print "<tr><td colspan='2'>&nbsp;</td></tr>";

				print "<tr><td><b>".TRANS('OPT_PREV_CH','Chamado da Preventiva')."</b></td>";
                                     $sqlStatus = "SELECT * FROM `problemas` WHERE prob_id = ".$row['conf_num_chamado']."";
                                     $execStatus = mysql_query($sqlStatus) OR die($sqlStatus);
                                     $rowStatus = mysql_fetch_array($execStatus);
                                       
				print "<td>".$rowStatus['problema']."</td>";
				print "</tr>";
				print "<tr><td colspan='2'>&nbsp;</td></tr>";

				print "<tr><td><b>".TRANS('FIELD_TYPE_EQUIP')."</b></td>";
					$query = "SELECT * from tipo_equip WHERE tipo_cod=  ".$row['conf_tipo_equip']."";
					$resultado = mysql_query($query)  OR die ($query) ;
					$rowTypeEquip = mysql_fetch_array($resultado);
				print "<td>".$rowTypeEquip['tipo_nome']."</td>";
				print "</tr>";
				print "<tr><td colspan='2'>&nbsp;</td></tr>";
				
				print "<tr><td><b>".TRANS('COL_SITUAC')."</b></td>";
					$query = "SELECT * from situacao WHERE situac_cod = ".$row['conf_equip_situac']."";
					$resultado = mysql_query($query)  OR die ($query) ;
					$rowSituac = mysql_fetch_array($resultado);
				print "<td>".$rowSituac['situac_nome']."</td>";
				print "</tr>";
				print "<tr><td colspan='2'>&nbsp;</td></tr>";
				
				print "<tr><td><b>".TRANS('OPT_PREV_ACEIT','Tempo Minimo (meses)')."</b></td>";
				print "<td>".$row['conf_tempo_min']."</td>";
				print "</tr>";
				print "<tr><td colspan='2'>&nbsp;</td></tr>";

				
				print "<tr><td><b>".TRANS('OPT_PREV_CRIT','Tempo crítico (meses)')."</b></td>";
				print "<td>".$row['conf_tempo_max']."</td>";
				print "</tr>";
				print "<tr><td colspan='2'>&nbsp;</td></tr>";

				print "<tr><td><b>".TRANS('OPT_PREV_1_PREV','Tempo para 1ª preventiva')."</b></td>";
				print "<td>".$row['conf_maq_nova']."</td>";
				print "</tr>";
				print "<tr><td colspan='2'>&nbsp;</td></tr>";


                                print "<tr><td><b>".TRANS('OPT_PREV_DATA_INI','Data para inicio das preventivas')."</b></td>";
				print "<td>".formatDate($row['conf_data_inic'],'')."</td>";
				print "</tr>";
				print "<tr><td colspan='2'>&nbsp;</td></tr>";
                                

				print "<tr><td colspan='2'>&nbsp;</td></tr>";

				print "</TABLE>";
		}

	} else

	if ((isset($_GET['action']) && ($_GET['action']=="alter")) && empty($_POST['submit'])){

	        $query = "SELECT * FROM config_preventiva ";
        	$resultado = mysql_query($query) or die (TRANS('ERR_QUERY'));
		$row = mysql_fetch_array($resultado);

		print "<form name='alter' action='".$_SERVER['PHP_SELF']."' method='post' onSubmit=\"return valida()\">"; //onSubmit='return valida()'
		print "<TABLE border='0' cellpadding='1' cellspacing='0' width='50%'>";
		print "<TR class='header'><td>".TRANS('OPT_DIRETIVA')."</TD><td>".TRANS('OPT_VALOR')."</TD></TD></tr>";
		print "<tr><td colspan='2'>&nbsp;</td></tr>";

		print "<tr><td><b>".TRANS('OPT_PREV_CH','Chamado da Preventiva')."</b></td>";
		print "<td><select name='num_chamado' id='idNum_chamado' class='select'>"; //<input type='text' name='lang' id='idLang' class='text' value='".$row['conf_language']."'></td>";
                        $sqlStatus = "SELECT * FROM `problemas` ORDER BY problema";
			$execStatus = mysql_query($sqlStatus) OR die($sqlStatus);
			while ($rowStatus = mysql_fetch_array($execStatus)) {
				print "<option value='".$rowStatus['prob_id']."' ";
					if ($rowStatus['prob_id'] == $row['conf_num_chamado'])
						print " selected";
					print ">".$rowStatus['problema']."</option>";
			}
		print "</select>";
		print "</td>";
		print "</tr>";
		print "<tr><td colspan='2'>&nbsp;</td></tr>";
		print "<tr>";
		print "<TD align='left'><b>".TRANS('FIELD_TYPE_EQUIP').": </b></TD>";
		print "<TD  align='left' bgcolor='".BODY_COLOR."'>";
			print "<SELECT class='select2' name='comp_tipo_equip' size='1'>";
			print "<option value=-1 selected>".TRANS('SEL_ALL_CONS')."</option>";
			$query = "SELECT * from tipo_equip WHERE tipo_cod=1  order by tipo_nome";
			$resultado = mysql_query($query);
			$linhas = mysql_numrows($resultado);
			while ($rowTipo = mysql_fetch_array($resultado))
			{
				print "<option value='".$rowTipo['tipo_cod']."' ";
					if ($rowTipo['tipo_cod'] == $row['conf_tipo_equip'])
						print " selected";
					print ">".$rowTipo['tipo_nome']."</option>";
			}
			print "</SELECT>";
		print "</TD>";
		print "</TR>";
		print "<tr><td colspan='2'>&nbsp;</td></tr>";
		print "<TR>";
		print "<TD align='left'><b>".TRANS('COL_SITUAC').":</b></TD>";
		print "<TD  align='left' bgcolor='".BODY_COLOR."'>";
			print "<SELECT class='select2'name='comp_situac' size=1>";
			print "<option value=-1 selected>".TRANS('SEL_ALL_CONS')."</option>";
			$query = "SELECT * from situacao WHERE situac_cod = 1 order by situac_nome";
			$resultado = mysql_query($query);
			$linhas = mysql_numrows($resultado);
			while ($rowSit = mysql_fetch_array($resultado))
			{
				print "<option value='".$rowSit['situac_cod']."' ";
					if ($rowSit['situac_cod'] == $row['conf_equip_situac'])
						print " selected";
				print ">".$rowSit['situac_nome']."</option>";
			}
			print "</SELECT>";
		print "</TD>";
		print "</tr>";
		print "<tr><td colspan='2'>&nbsp;</td></tr>";

		print "<tr><td><b>".TRANS('OPT_PREV_ACEIT','Tempo Minimo (meses)')."</b></td>";
		print "<td><input type='text' name='tempo_min' id='idTempo_min' class='text' value='".$row['conf_tempo_min']."'></td>";
		print "</tr>";
		print "<tr><td colspan='2'>&nbsp;</td></tr>";

		print "<tr><td><b>".TRANS('OPT_PREV_CRIT','Tempo crítico (meses)')."</b></td>";
		print "<td><input type='text' name='tempo_max' id='idTempo_max' class='text' value='".$row['conf_tempo_max']."'></td>";
		print "</tr>";
		print "<tr><td colspan='2'>&nbsp;</td></tr>";


		print "<tr><td><b>".TRANS('OPT_PREV_1_PREV','Tempo para 1ª preventiva')."</b></td>";
		print "<td><input type='text' class='text' name='maq_nova' id='idMaq_nova' value='".$row['conf_maq_nova']."'></td>";
		print "</tr>";

		print "<tr><td colspan='2'>&nbsp;</td></tr>";


		print "<tr><td><b>".TRANS('OPT_PREV_DATA_INI','Data para inicio das preventivas')."</b></td>";
		//print "<td><input type='text' class='text' name='data_inic' id='idData_inic' value='".$row['conf_data_inic']."'></td>";
		print "<td><INPUT type='text' name='data_inic' class='data' id='idData_inic' value='".formatDate($row['conf_data_inic'],'0')."'><a onclick=\"displayCalendar(document.forms[0].data_inic,'dd/mm/yyyy',this)\"><img height='14' width='14' src='../../includes/javascript/img/cal.gif' width='16' height='16' border='0' alt='".TRANS('HNT_SEL_DATE')."'></a></td>";
                print "</tr>";
                print "<tr><td colspan='2'>&nbsp;</td></tr>";
                
                
		print "<tr><td colspan='2'>&nbsp;</td></tr>";
		print "<tr><td><input type='submit'  class='button' name='submit' value='".TRANS('BT_ALTER','',0)."'></td>";
		print "<td><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL','',0)."' onclick=\"javascript:history.back()\"></td></tr>";

		print "</table>";
		print "</form>";
	} else

	if ($_POST['submit'] == TRANS('BT_ALTER')){
		
		$dataPreventiva = explode ("/", $_POST['data_inic']);
		$data = "$dataPreventiva[2]-$dataPreventiva[1]-$dataPreventiva[0]";

		$query = "SELECT conf_data_inic  FROM config_preventiva";
		$exQry = mysql_query($query) or die(TRANS('ERR_EDIT').$query);
		$linha = mysql_numrows ($exQry);

		if ($linha == 0){

			$qry= "INSERT INTO config_preventiva (conf_num_chamado, conf_tempo_min,conf_tempo_max, conf_maq_nova, 
					 conf_tipo_equip,conf_equip_situac, conf_data_inic)
				 VALUES ('".$_POST['num_chamado']."','".$_POST['tempo_min']."','".$_POST['tempo_max']."', '".$_POST['maq_nova']."',
				 			'".$_POST['comp_tipo_equip']."','".$_POST['comp_situac']."','".$data."')";
			$exec = mysql_query($qry) or die(TRANS('ERR_EDIT').$qry);

			//dump($qry); exit;

		}else{
			$qry = "UPDATE config_preventiva SET ".
				"conf_num_chamado = '".$_POST['num_chamado']."', ".
				"conf_tempo_min = '".$_POST['tempo_min']."', ".
				"conf_tempo_max = '".$_POST['tempo_max']."', ".
				"conf_maq_nova  = '".$_POST['maq_nova']."', ".
				"conf_tipo_equip  = '".$_POST['comp_tipo_equip']."', ".
				"conf_equip_situac  = '".$_POST['comp_situac']."', ".
				"conf_data_inic = '".$data."' ";

			 //dump($qry); exit;
		
                $exec = mysql_query($qry) or die(TRANS('ERR_EDIT').$qry);
		}
	
		print "<script>mensagem('".TRANS('OK_EDIT','',0)."!');redirect('".$_SERVER['PHP_SELF']."'); </script>";
		
	}

?>

<script type="text/javascript">
<!--
	function valida(){

		var ok = validaForm('idNum_chamado','INTEIRO','NUMERO DO CHAMADO',1);
		if (ok) var ok = validaForm('idTempo_min','INTEIRO','TEMPO MINIMO',1);
		if (ok) var ok = validaForm('idTempo_max','INTEIRO','TEMPO MAXIMO',1);
		if (ok) var ok =  validaForm('idMaq_nova','INTEIRO','TEMPO MAQUINAS NOVAS',1);
		if (ok) var ok =  validaForm('idData_inic','DATA','DATA INICIO',1);

		return ok;
	}

-->
</script>
<SCRIPT LANGUAGE="JavaScript">cp.writeDiv()</SCRIPT>
<?php 
print "</body>";
print "</html>";

?>
