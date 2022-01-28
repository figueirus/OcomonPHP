<?php 
session_start();
 
	if (!isset($_SESSION['s_logado']) || $_SESSION['s_logado'] == 0)
	{
		print "<script>window.open('../../index.php','_parent','')</script>";
		exit;
	}

	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");

	include ("../../includes/classes/paging.class.php");
	print "<html>";
	print "<body>";

	print "<TABLE class='header_centro'  border-top: thin solid #999999;}' border='0' cellpadding='5' cellspacing='0' align='center' width='100%' bgcolor='".$cor."'>";
	print "<TR class='header'>";
		print "<TD  class='line' ><a title='Posi&ccedil;&atilde;o do atendimento'>".TRANS('OCO_NUMBER_PS')."</a></TD>
			<TD  class='line' ><a title='N&uacute;mero do Chamado'>".TRANS('OCO_NUMBER_CH')."</a></TD>
			<TD  class='line' ><a title='N&uacute;mero do Chamado'>".TRANS('MNL_AREAS')."</a></TD>
			<TD  class='line' ><a title='Nome Solicitante'>".TRANS('OCO_CONTACT')."</a></TD>
			<TD class='line'  ><a title='Atende que est&aacute; realizando o chamado'>".TRANS('TXTAREA_IN_ATTEND_BY')."</a></TD>
			<TD  class='line' ><a title='Data Abertura'>".TRANS('OCO_FIELD_DATE_OPEN')."</a></TD>
			<TD  class='line' ><a title='Status do Chamado'>".TRANS('OCO_STATUS')."</a></TD>";
	print "</TR>";
      
	$valign = " VALIGN = TOP ";
	$qry = "select nome from usuarios where user_id = ".$_SESSION['s_uid']."";
	$exec = mysql_query($qry);
	$r_user = mysql_fetch_array($exec);
	$contato = $r_user['nome'];
         
        $sqlSubCall = "SELECT numero,data_abertura,u.nome,s.status, aberto_por, u2.nome as abertopor, o.sistema, sis.sistema
				FROM ocorrencias o INNER JOIN status s on o.status=s.stat_id
				INNER JOIN  usuarios u on o.operador=u.user_id
				INNER JOIN usuarios u2 on o.aberto_por = u2.user_id
				INNER JOIN sistemas sis on o.sistema = sis.sis_id
				and o.sistema in (1,20)
				where o.status in (1,2,16,22,25,33,34,36,40,45,46,54,53,40)
				order by numero";
	$execSubCall = mysql_query($sqlSubCall) or die (TRANS('ERR_QUERY').'<br>'.$sqlSubCall);
	$regSub = mysql_num_rows($execSubCall);
	$count = 1;
	$j = 0;
	while ($row = mysql_fetch_array($execSubCall)){
		$data2 = $row['data_abertura'];
		$data = date('d/m/Y H:i:s ', strtotime($data2));
      
		$cor1 = '#f6f6f6';
		$cor2 = '#e3e1e1';
		$cor3 = '#009933';
		$destaca = '#cccccc';
		if($contato == $row['abertopor']){
			$cor = $cor3;
		}else {
			if ($j % 2) {
				$cor = $cor2;
			} else {
				$cor = $cor1;
			}
		}
		$j++;

		print "<tr style='background:$cor;' id='linhax".$j."' onMouseOver=\"javascript:this.style.backgroundColor='$destaca'\" onMouseOut=\"javascript:this.style.backgroundColor='$cor'\"  onMouseDown=\"marca('linhax".$j."','".$_SESSION['s_colorMarca']."');\">";
		print "<TD  class='line'  ".$valign."><b>$count</TD>";
		print "<TD  class='line'  ".$valign.">".$row['numero']."<br>";
		print "<TD  class='line'  ".$valign.">".$row['sistema']."<br>";
		print "<TD  class='line'  ".$valign.">".$row['abertopor']."<br>";
		//print "<TD  class='line'  ".$valign.">$atendente<br>";
		print "<TD  class='line'  ".$valign.">".$row['nome']."<br>";
		print "<TD  class='line'  ".$valign.">$data<br>";
		print "<TD  class='line'  ".$valign.">".$row['status']."<br>";
		  
		$count++;
      
	}
print "</TABLE>";
print "</body>";
print "</html>";
?>