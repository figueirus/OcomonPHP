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
		
	// dump ($query);

	// $query2 = "select * from assentamentos where ocorrencia='".$_GET['numero']."'  ORDER BY numero DESC LIMIT 1";
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
	print "<img src='../../Rodape.png' width=450px height=146px><br>";
	// print "<img src='../../Rodape.png'><br>";
	print "<BR><B>".TRANS('TTL_OCOMON_REP_ATTEND')." - via do Cliente</B><BR>";

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
			print "<TD width='20%' align='left' valign='top'><b>".TRANS('OCO_DESC')." da ocorr�ancia:</b></TD>";
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

			// print "<TD width='20%' align='left' valign='top'><b>".TRANS('FIELD_TAG_EQUIP').":</b></TD>";
			// print "<TD width='30%' align='left' valign='top'>".$row['etiqueta']."</TD>";
		print "</TR>";

		print "<TR>";
			print "<TD width='20%' align='left' valign='top'><b></b></TD>";
			print "<TD width='30%' align='left' valign='top'><br></TD>";
		print "</TR>";
		
		print "<TR>";
			print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_CONTACT').":</b></TD>";
			print "<TD width='30%' align='left'>".$row['contato']."</TD>";
			print "<TD width='20%' align='left'><b>Telefone:</b></TD>";
			print "<TD width='30%' align='left'>".$row['telefone']."</TD>";
		print "</tr>";
		print "<TR>";
			print "<TD width='20%' align='left'><b>Local:</b></TD>";
			print "<TD width='30%' align='left'>".$row['setor']."</TD>";
			print "<TD width='20%' align='left'><b>CNPJ:</b></TD>";
			if ($row['loc_cnpj'] == ''){
				print "<TD width='30%' align='left'>N�O INFORMADO</TD>";
			}else{
				print "<TD width='30%' align='left'>".$row['loc_cnpj']."</TD>";
			}
			
		print "</TR>";		
		print "<TR>";
			print "<TD width='20%' align='left'><b>Endere�o:</b></TD>";
			print "<TD width='30%' align='left'><i>".$row['loc_endereco']."</i></TD>";
		print "</TR>";
		
		if ($row['setor'] == 'ACF Tech - Cliente Avulso'){
			print "<TR>";
				print "<TD width='20%' align='left'><b>Nome do(a) cliente:</b></TD>";
				print "<TD width='30%' align='left'><i>".$row['contato']."</i></TD>";
			print "</TR>";
		}else{
			print "<TR>";
				print "<TD width='20%' align='left'><b>Nome do(a) cliente:</b></TD>";
				print "<TD width='30%' align='left'><i>".$row['loc_resp_ti']."</i></TD>";
			print "</TR>";
			print "<TR>";
				print "<TD width='20%' align='left'><b>E-mail do(a) cliente:</b></TD>";
				print "<TD width='30%' align='left'><i><u>".$row['loc_email']."</u></i></TD>";
			print "</TR>";
		}
			
		
		
		print "<TR>";
			print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_OPERATOR').":</b></TD>";
			print "<TD width='30%' align='left'>".$row['nome']."</TD>";
		print "</TR>";

			print "<TR>";
				print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_DATE_OPEN').":</b></TD>";
				print "<TD width='30%' align='left'>".formatDate($row['data_abertura'])."</TD>";
				print "<TD width='20%' align='left'><b>".TRANS('OCO_FIELD_STATUS').":<b></TD>";
				print "<TD width='30%' align='left' bgcolor='white'>".$row['chamado_status']."</TD>";
			print "</TR>";

		print "<TR>";
		print "<TABLE border='0'  align='center' width='100%'>";
		print "<hr>";
		print "</table>";
		print "</TR>";
		print "<TR>";
			print "<TABLE border='0'  align='center' width='100%'>";

				print "<tr>";	
					print "<TD width='30%' align='left'>&nbsp;</TD>";

					$taxaDesloc = number_format($row['loc_desloc'],2,',','.');				
				print "<TABLE>";				
				print "<tr>";	
					print "<TD width='30%' align='justify'><b>DECLARO ESTAR CIENTE E CONCORDO COM AS CONDI��ES ABAIXO DESCRITAS: </b><br><br>
					<i>- DA GARANTIA: Fixada em 45 (noventa) dias contados a partir da retirada do(s) equipamento(s), cobrindo SOMENTE PE�AS TROCADAS E SERVI�OS ESPECIFICAMENTE
					REALIZADOS, excluindo assim qualquer outro defeito que n�o seja o que foi consertado e excluindo tamb�m garantia de funcionamento de softwares, isto se deve ao fato que a ACF TECH
					estar impossibilitada de controlar o uso de qualquer software instalado pelo cliente. E este, mesmo que n�o intencionalmente excluir um simples arquivo que comprometa todo o bom 
					funcionamento do sistema ou ent�o permitir que algum programa novo instalado facilite a entrada de v�rus, trojans ou qualquer outra praga virtual. Em todas as pe�as trocadas eno equipamento 
					reparado, a ACF TECH coloca selos de garantia (lacres) a fim de preservar o servi�o prestado. Evitando assim que o equipamento venha a ser aberto por pessoas n�o autorizadas pela empresa.
					No caso de rompimento ou adultera��o deste lacre a empresa fica desobrigada a cumprir a garantia firmada com o contratante. Quando a venda � de um computador completo, a <font color='red'>garantia � de 1 ano</font>
					<br><br>
					- DAS C�PIAS DE SEGURAN�A: � de exclusiva obriga��o do cliente manter c�pias de seguran�a (BACKUPS) dos seu dados. � imposs�vel a empresa determinar QUAIS DADOS est�o gravados
					no equipamento, e levando em conta que estes dados est�o gravados em dispositivos eletr�nicos sujeitos a falhas ou defeitos casuais, a empresa n�o tem como se responsabilizar por qualquer
					dados armazenados no(s) equipmento(s) deixado(s) sob seu(s) cuidado(s).
					<br><br>
					- DA PROCED�NCIA: � de inteira responsabilidade do contratante a proced�ncia dos equipamentos e ou softwares contido(s) nele, entregues neste estabelecimento para servi�o.
					<br><br>
					- DA PERMAN�NCIA DOS EQUIPAMENTOS: Ap�s a aprova��o do or�amento e a efetiva��o do servi�o contratado, a empresa ir� comunicar o contratante para retirar o equipamento, ap�s essa
					comunica��o o contratante ter� o prazo de 30 (trinta) dias para retira-lo. Ap�s este prazo, ser� cobrado o valor de R$ 5,00 (cinco reais) por dia a t�tulo de estocagem por pe�a. Ap�s 120 (cento e vinte)
					dias o equipamento ser� considerado como <b> abandonado</b> e poder� ser vendido para cobrir os custos de estocagem e de servi�o prestado. As mesmas regras servem para os equipamentos que
					n�o tiveram seus or�amentos aprovados, sendo que no ato da recusa do servi�o a ACF TECH j� comunicar� ao contratante para retirar o equipamento ap�s 48hs (quarenta e oito) horas a fim de remontagem
					do mesmo, ap�s estas 48 (quarenta e oito) horas passa a contar os prazos acima citado.
					</i><br>
					</TD>";
				print "</tr>";				
				print "<tr>";	
					print "<TD width='30%' align='left'>&nbsp;</TD>";
				print "</tr>";	
				print "<tr>";
					if (($row['status_cod'] == 30)|| ($row['status_cod'] == 4)){
						
						$sqlPagto = "SELECT valor FROM pagto_chamado WHERE ocorrencia = ".$row['numero']." ";
						$execPagto = mysql_query($sqlPagto);
						$linha = mysql_fetch_array ($execPagto);
						$valor = number_format($linha['valor'], 2, ',', '.');
							
						print "<TD width='50% align='left'><font size=2><b>Valor total: &nbsp; R$ ".$valor."</b></font></TD>";
					}else{
						print "<TD width='50% align='left'><b>O valor da O.S ainda est� em aberto.</b></TD>";
					}
				print "</tr>";	
				print "<tr>";	
					print "<TD width='30%' align='left'>&nbsp;</TD>";
				print "</tr>";	
			print "</TABLE>";
			print "<hr>";
		print "</TR>";
	print "</TABLE>";
	
	###### RECIBO de ATENDIMENTO ######
		print "<TABLE border='0' align='center' width='100%'>";
		print "<TR>";
			print "<TD align='left'>&nbsp;</TD>";
			print "<TD align='left'>&nbsp;</TD>";
		print "</TR>";
	print "</TABLE>";
	print "<TABLE border='0' align='center' width='100%'>";
		print "<TR>";
			// print "<TD width='60%align='left'><font size=2><b>ACF TECH - SOLU��ES EM T.I</b></font></TD>";
		print "</TR>";
	print "</TABLE>";
	print "<TABLE border='0' align='center' width='100%'>";
		print "<TR>";
			print "<TD align='left'>&nbsp;</TD><br>";
		print "</TR>";
		print "<TR>";
			// print "<TD width='40% align='center'><center>_________________________________</center></TD>";
			print "<TD width='30% align='center'><center>______/ ______/ _______</center></TD>";
			print "<TD width='40% align='center'><center>_________________________________</center></TD>";
		print "</TR>";
		print "<TR>";
			// 	print "<TD width='40% align='center'><center>T�cnico</center></TD>";
			print "<TD width='30% align='center'><center>Data</center></TD>";
			print "<TD width='40% align='center'><center>Assinatura</center></TD>";
		print "</TR>";
	print "</TABLE>";
	

print "</BODY>";
print "</HTML>";
?>