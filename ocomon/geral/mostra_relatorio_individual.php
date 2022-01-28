<?php 
session_start();
print "<html>";
print "<body>";

	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");

        //$query  = "SELECT * FROM ocorrencias WHERE numero='$numero'";
	$query = $QRY["ocorrencias_full_ini"]." where numero in (".$_GET['numero'].") order by numero";
	$resultado = mysql_query($query);
	$row = mysql_fetch_array($resultado);
	$linhas = mysql_numrows($resultado);


	$query2 = "select * from assentamentos where ocorrencia='".$_GET['numero']."'";
	$resultado2 = mysql_query($query2);
	$linhas2=mysql_numrows($resultado2);

	if ($linhas==0)
	{
		$_SESSION['aviso'] = "Nenhuma_ocorrencia_localizada.";
		$_SESSION['origem'] = "relatorio_individual.php";

		print "<script>redirect('mensagem.php')</script>";
	}

	$linhas = 0;
	print "<img src='../../MAIN_LOGO.png'><br>";
	print "<BR><B>".TRANS('TTL_OCOMON_REP_ATTEND')." - via do Técnico</B><BR>";

	print "<TABLE border='0' align='center' width='100%'>";
		print "<TR>";
		print "<hr>";
			print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_NUMBER').":</b></TD>";
			print "<TD colspan='3' width='80%' align='left'>".$row['numero']."</TD>";
		print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left'><b>".TRANS('OCO_PROB').":<b></TD>";
			print "<TD style=\"text-align:justify;\" width='30%' align='left'>".$row['problema']."</TD>";
			print "<TD width='20%' align='left'><b>".TRANS('FIELD_AREA_ATTEND').":</b></TD>";
			print "<TD width='30%' align='left'>".$row['area']."</TD>";
		print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left' valign='top'><b>".TRANS('OCO_DESC')." da ocorrêancia:</b></TD>";
			print "<TD  colspan='3' width='80%' align='left'><i>".nl2br($row['descricao'])."</i></TD>";
		print "</TR>";

		if ($linhas2!=0)
		{
		$i=0;
			while ($i < $linhas2)
			{
				$OP = mysql_result($resultado2,$i,4);
				$qryOP = "select * from usuarios where user_id = ".$OP."";
				$execOP = mysql_query($qryOP);
				$rowOP = mysql_fetch_array($execOP) or die($qryOP);
				$countAssentamento = $i+1;
				print "<TR>";
					print "<TD width='20%' align='left' valign='top'>".TRANS('FIELD_NESTING')." ".$countAssentamento." de ".$linhas2." por ".
							"".$rowOP['nome']." em ".formatDate(mysql_result($resultado2,$i,3))."</TD>";
					print "<TD style=\"text-align:justify;\" colspan='3' width='40%' align='left' valign='top'>".nl2br(mysql_result($resultado2,$i,2))."</TD>";
				print "</TR>";
			$i++;
			}
		}
		print "<TR>";
			print "<TD width='20%' align='left' valign='top'><b>".TRANS('OCO_FIELD_UNIT').":</b></TD>";
			print "<TD width='30%' align='left' valign='top'>".$row['unidade']."</TD>";

			print "<TD width='20%' align='left' valign='top'><b>".TRANS('FIELD_TAG_EQUIP').":</b></TD>";
			print "<TD width='30%' align='left' valign='top'>".$row['etiqueta']."</TD>";
		print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_CONTACT').":</b></TD>";
			print "<TD width='30%' align='left'>".$row['contato']."</TD>";
			print "<TD width='20%' align='left'><b>Telefone:</b></TD>";
			print "<TD width='30%' align='left'>".$row['telefone']."</TD>";
		print "</tr>";
		print "<TR>";
			print "<TD width='20%' align='left'><b>Cliente:</b></TD>";
			print "<TD width='30%' align='left'>".$row['setor']."</TD>";
			print "<TD width='20%' align='left'><b>CNPJ:</b></TD>";
			print "<TD width='30%' align='left'>".$row['loc_cnpj']."</TD>";
		print "</TR>";		
		print "<TR>";
			print "<TD width='20%' align='left'><b>Endereço:</b></TD>";
			print "<TD width='30%' align='left'><i>".$row['loc_endereco']."</i></TD>";
		print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left'><b>Responsável pela T.I:</b></TD>";
			print "<TD width='30%' align='left'><i>".$row['loc_resp_ti']."</i></TD>";
		print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left'><b>E-mail Resp. T.I:</b></TD>";
			print "<TD width='30%' align='left'><i><u>".$row['loc_email']."</u></i></TD>";
		print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_OPERATOR').":</b></TD>";
			print "<TD width='30%' align='left'>".$row['nome']."</TD>";
		print "</TR>";

		if ($row['status_cod']== 4)
		{
			print "<TR>";
				print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_DATE_OPEN').":</b></TD>";
				print "<TD width='30%' align='left'>".formatDate($row['data_abertura'])."</TD>";
				print "<TD width='20%' align='left'><b>".TRANS('FIELD_DATE_CLOSING').":</b></TD>";
				print "<TD width='30%' align='left'>".formatDate($row['data_fechamento'])."</TD>";
			print "</tr>";
			print "<tr>";
				print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_STATUS').":</b></TD>";
				print "<TD colspan='3' width='80%' align='left' bgcolor='white'>".$row['chamado_status']."</TD>";
			print "</TR>";
		}
		else
		{
			print "<TR>";
				print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_DATE_OPEN').":</b></TD>";
				print "<TD width='30%' align='left'>".formatDate($row['data_abertura'])."</TD>";
				print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_STATUS').":<b></TD>";
				print "<TD width='30%' align='left' bgcolor='white'>".$row['chamado_status']."</TD>";
			print "</TR>";
		}

		print "<TR>";
		print "<TABLE border='0'  align='center' width='100%'>";
		print "<hr>";
			print "<tr>";
				print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_OPERATOR').":</b></TD>";
				print "<TD width='30%' align='left'>&nbsp;</TD>";
			print "</tr>";
		print "</table>";
		print "<hr>";
		print "</TR>";


		print "<TR>";
		print "<TABLE border='0'  align='center' width='100%'>";
		for ($i =0; $i<10; $i++)
		{
			print "<tr>";
				print "<TD class='bordaprint' colspan='4' width='100%' align='center'>&nbsp;";
				print "</TD>";
			print "</tr>";
		}
		print "</table>";
		print "</TR>";


		print "<TR>";
			print "<TABLE border='0'  align='center' width='100%'>";
			//print "<hr>";
				print "<tr><td colspan='4'>&nbsp;</td></tr>";
				print "<tr>";
					print "<TD width='20%' align='left'>".TRANS('FIELD_NAME_USER').":</TD>";
					
				print "</tr>";
				print "<tr>";	
					print "<TD width='30%' align='left'>&nbsp;</TD>";
				print "</tr>";	
				print "<tr>";	
					print "<TD width='30%' align='left'>&nbsp;</TD>";
				print "</tr>";	
				// print "<tr>";	
					// print "<TD width='30%' align='left'>&nbsp;</TD>";
				// print "</tr>";		
				print "<tr>";	
					print "<TD width='30%' align='left'><b>Checklist para encerramento: &nbsp;&nbsp;RMA  (________)&nbsp;&nbsp; Comercial (__________)  &nbsp;&nbsp;
													Finalizado com sucesso  (______)</b>/TD>";
					// print "<TD width='35%' align='left'><b>RMA  (____)&nbsp; Comercial (_____)  &nbsp;Finalizado com sucesso  (__)</b></TD>";
				print "</tr>";	
				print "<tr>";	
					print "<TD width='30%' align='left'>&nbsp;</TD>";
				print "</tr>";					
				print "<tr>";	
					print "<TD width='30%' align='left'>&nbsp;</TD>";
				print "</tr>";				print "<tr>";	
					print "<TD width='30%' align='left'>&nbsp;</TD>";
				print "</tr>";	
				print "<tr>";
					print "<TD width='20%' align='left'><b>Assinatura:</b></TD>";
					print "<TD width='35%' align='left'><b>".TRANS('FIELD_ATTEND_IN').":</b>  ______/ ______/ _______  &nbsp;  às &nbsp;  ______ : ______</TD>";
					// print "<TD width='30%' align='left'></TD>";
					// print "<TD width='10%' align='left'>".TRANS('FIELD_SIGNATURE_USER')."</TD>";
					// print "<TD width='30%' align='left'>&nbsp;</TD>";
				print "</tr>";
			print "</TABLE>";
			print "<hr>";
		print "</TR>";
	print "</TABLE>";

print "</BODY>";
print "</HTML>";
?>