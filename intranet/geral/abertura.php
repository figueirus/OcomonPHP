<?php 

 /*                        Copyright 2011 Alexsandro Corrêa

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
  */session_start();


	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");

	//$_SESSION['s_page_proj'] = $_SERVER['PHP_SELF'];

	$cab = new headers;
	$cab->set_title(TRANS("html_title"));
	// $auth = new auth;
	// $auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],4);
	print "<TABLE class='header_centro' cellspacing='1' border='0' cellpadding='1' align='center' width='100%'>".//#5E515B
			"<TR>
				<TD nowrap width='75%'><b>".TRANS('MENU_TTL_MOD_INTRA')."</b></td>
				<td width='25%' nowrap><p class='parag' align='right'><b>".TRANS(date("l")).",&nbsp;".(formatDate(date("Y/m/d H:i"), " %H:%M"))."</b>".$help."</p></TD>
			</TR>
		</TABLE>";

	
	print "<BODY bgcolor=".BODY_COLOR.">";
	$hoje = date("d-m-Y H:i:s");

	//dump ($_SESSION);
	// Select para retornar a quantidade e percentual de equipamentos cadastrados no sistema
	$query = "SELECT form.form_tipo, form.data_solicit, form.ocorrencia
				FROM formularios as form
				LEFT JOIN ocorrencias as oco on oco.numero = form.ocorrencia
			ORDER BY data_solicit";

	$resultado = mysql_query($query);
	$linhas = mysql_num_rows($resultado);
	$qtd = mysql_numrows($resultado);
	
	print "<table class=estat60 align=center>";
	print "<tr><td></TD></tr>";
	print "<tr><td></TD></tr>";

	print "<tr><td align='center'><b>Você realizou <font color='red'>".$qtd."</font> solicitação(ões) no sistema.</b></td></tr>";

	print "<td>";
	print "<fieldset><legend>".TRANS("quadro")."</legend>";
		print "<TABLE border='0' cellpadding='5' cellspacing='0' align='center' width='60%'>";
	print "<TR><td><b>Solicitação</TD><td><b>Data da Solicitação</TD><td><b>Nro. do chamado</TD></tr>";
	$i=0;
	$j=2;

	while ($row = mysql_fetch_array($resultado)) {
		$varAux = explode("-", $row['data_solicit']);
		$dataSolicit = $varAux['2']."/".$varAux['1']."/".$varAux['0'];
		
		if ($row['form_tipo'] == "FormSolicitEquip"){
			$formTipo = "Solicitação de equipamento";
		}elseif ($row['form_tipo'] == "FormInstRamal"){
			$formTipo = "Instalação de novo ramal";
		}elseif ($row['form_tipo'] == "FormAltRamal"){
			$formTipo = "Alteração de categoria de ramal";
		}elseif ($row['form_tipo'] == "FormSolicitSoft"){
			$formTipo = "Instalação de Software";
		}
		$color =  BODY_COLOR;
		$j++;
		print "<tr id='linha".$j."' onMouseOver=\"destaca('linha".$j."');\" onMouseOut=\"libera('linha".$j."');\"  ".
				"onMouseDown=\"marca('linha".$j."');\">";
		//print "<tr class=".$trClass." id='linhax".$j."' onMouseOver=\"destaca('linhax".$j."','".$_SESSION['s_colorDestaca']."');\" onMouseOut=\"libera('linhax".$j."','".$_SESSION['s_colorLinPar']."','".$_SESSION['s_colorLinImpar']."');\"  onMouseDown=\"marca('linhax".$j."','".$_SESSION['s_colorMarca']."');\">";
			print "<td>".$formTipo."</TD>";
			print "<td><center>".$dataSolicit."</center></TD>";
			print "<td><center><a onClick=\"javascript:popup('../../ocomon/geral/mostra_consulta.php?numero=".$row['ocorrencia']."')\"><b><font color=#666666>".$row['ocorrencia']."</b></font></center></TD>";
		print "</TR>";
		$dados[]=$row['Quantidade'];
		$legenda[]=$row['Equipamento'];
		$i++;
	}

       // print "<TR><td><b>".TRANS('total','Total')."</TD><td><b>".$total."</TD><td><b>100%</TD></tr>";

		print "</TABLE>";

		$valores = "";
		for ($i=0; $i<count($dados);$i++){
			$valores.="data%5B%5D=".$dados[$i]."&";
		}
		for ($i=0; $i<count($legenda); $i++){
				$valores.="legenda%5B%5D=".$legenda[$i]."&";
		}
			$valores = substr($valores,0,-1);

		print "</fieldset>";

		
	$cab->set_foot();

?>


