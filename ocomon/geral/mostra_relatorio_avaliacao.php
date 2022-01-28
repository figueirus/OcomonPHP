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
		$_SESSION['origem'] = "relatorio_avaliacao.php";

		print "<script>redirect('mensagem.php')</script>";
	}

	$linhas = 0;

	print "<BR><B>".TRANS('TTL_REL_AVAL')."</B><BR>";

	print "<TABLE border='0' align='center' width='100%'>";
		print "<TR>";
		print "<hr>";
			print "<TD class='colunarel'><b>".TRANS('OCO_FIELD_NUMBER').":</b></TD>";
			print "<TD class='colunarel'> ".$row['numero']."</TD>";
			print "<TD class='colunarel'><b>".TRANS('FIELD_AREA_ATTEND').":</b></TD>";
			print "<TD class='colunarel'>".$row['area']."</TD>";
		print "</TR>";	
		print "<TR>";
			print "<TD class='colunarel'><b>".TRANS('OCO_FIELD_UNIT').":</b></TD>";
			print "<TD class='colunarel'>".$row['unidade']."</TD>";
			print "<TD class='colunarel'><b>".TRANS('FIELD_TAG_EQUIP').":</b></TD>";
			print "<TD class='colunarel'>".$row['etiqueta']."</TD>";
		print "</TR>";
		print "<TR>";
			print "<TD class='colunarel'><b>".TRANS('OCO_FIELD_CONTACT').":</b></TD>";
			print "<TD class='colunarel'>".$row['contato']."</TD>";
			print "<TD class='colunarel'><b>".TRANS('OCO_FIELD_PHONE').":</b></TD>";
			print "<TD class='colunarel'>".$row['telefone']."</TD>";
		print "</tr>";
		print "<TR>";
			print "<TD class='colunarel'><b>".TRANS('OCO_FIELD_LOCAL').":</b></TD>";
			print "<TD class='colunarel'>".$row['setor']."</TD>";
			print "<TD class='colunarel'><b>".TRANS('OCO_FIELD_OPERATOR').":</b></TD>";
			print "<TD class='colunarel'>".$row['nome']."</TD>";
		print "</TR>";
		print "<TR>";
			print "<tr>";
				print "<TD class='colunarel'><b>".TRANS('OCO_FIELD_DATE_OPEN').":</b></TD>";
				print "<TD class='colunarel'>".formatDate($row['data_abertura'])."</TD>";
			print "</tr>";
	
		print "</TR>";
	print "</TABLE>";
	
	print "<TABLE border='0' align='center' width='100%'>";	
			print "<TR>";
				print "<TD class='colunarel'><b>".TRANS('OCO_DESC')."</b></TD>";
				print "<TD class='linhas' align='justify'>".nl2br($row['descricao'])."</TD>";
			print "</TR>";
	print "</TABLE>";
	
	print "<TABLE border='0' align='center' width='100%'>";
	print "<TD valign='top'><b>".TRANS('FIELD_SOLUC_AVAL')."</b></TD>";
	print "<br>";
	print "<br>";
	
	for ($i =0; $i<6; $i++)
		{
			print "<tr>";
				print "<TD class='bordaprint' colspan='4' width='100%' align='center'>&nbsp;";
				print "</TD>";
			print "</tr>";
		}
	print "</TABLE>";
	
	print "<TABLE border='0' align='center' width='100%'>";
	print "<TD valign='top'><b>".TRANS('FIELD_OBS_AVAL')."</b></TD>";
	print "<br>";
	print "<br>";
	
	for ($i =0; $i<3; $i++)
		{
			print "<tr>";
				print "<TD class='bordaprint' colspan='4' width='100%' align='center'>&nbsp;";
				print "</TD>";
			print "</tr>";
		}
	print "</TABLE>";
	print "<br>";
	print "<br>";
	print "<BR><B>".TRANS('FIELD_AVALIACAO')."</B><BR>";
	print "<hr>";
	print "<br>";
	print "<br>";
	
	$sql="SELECT * FROM nota_aval WHERE status_id = '1'";
	$exec=mysql_query($sql);
	
	
	print "<TABLE border='0' align='center' width='100%'>";
	
	while($rowAVAL=mysql_fetch_array($exec)){
	
		print "<TD class='colunarel'><b> (  ) ".$rowAVAL['nota_aval']."</b></TD>";
	
	}
		
	
	print "</TABLE>";
	print "<br>";
	print "<br>";
	print "<TABLE border='0' align='center' width='100%'>";
	
	print "<TD valign='top'><b>".TRANS('FIELD_COMENT')."</b></TD>";
	
	for ($i =0; $i<3; $i++)
		{
			print "<tr>";
				print "<TD class='bordaprint' colspan='4' width='100%' align='center'>&nbsp;";
				print "</TD>";
			print "</tr>";
		}	

	print "</TABLE>";
	
	print "<TABLE border='0' align='center' width='100%'>";
		print "<TR>";
			print "<br>";
			print "<br>";
			print "<br>";
				print "<tr>";
					print "<TD class='colunarel';><b>".TRANS('FILED_ASS_TEC')."</b></TD>";
					print "<TD class='linha_ass'><b>";
					print "<TD class='colunarel'><b>".TRANS('FIELD_SIGNATURE_USER')."</b></TD>";
					print "<TD class='linha_ass'><b>";
	
				print "</tr>";	
		print "</TR>";
	print "</TABLE>";
	
print "</BODY>";
print "</HTML>";
?>