<?php 
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
  */session_start();


	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");
	include ("../../includes/classes/paging.class.php");

	$_SESSION['s_page_admin'] = $_SERVER['PHP_SELF'];

	print "<HTML>";
	print "<BODY bgcolor=".BODY_COLOR.">";

	$auth = new auth;
	$auth->testa_user($_SESSION['s_usuario'],$_SESSION['s_nivel'],$_SESSION['s_nivel_desc'],1);

	$PAGE = new paging("PRINCIPAL");
	$PAGE->setRegPerPage($_SESSION['s_page_size']);

	print "<BR><B>".TRANS('TTL_ADMIN_LOCAL_SECTORS')."</B><BR>";


		if (isset($_POST['search'])){
			$search = $_POST['search'];
		} else
			$search = "";


		$query = "SELECT l .  * , pr.prior_nivel AS prioridade, staLoc.status_desc
				FROM localizacao AS l
				LEFT  JOIN prioridades AS pr ON pr.prior_cod = l.loc_prior
				LEFT  JOIN statuslocais AS staLoc ON staLoc.status_id = l.loc_status";

		// if (isset($_GET['cod'])) {
			// $query.= "WHERE l.loc_id = ".$_GET['cod']." ";
		// } else
		if (isset($_POST['search'])) {
			$query.= " WHERE lower(l.local) like lower(('%".$_POST['search']."%')) ";
		}
		$query .=" ORDER  BY local";
		
		// dump($query);
		$resultado = mysql_query($query) or die(TRANS('MSG_ERR_QRY_CONS'));
		$registros = mysql_num_rows($resultado);

		if (isset($_GET['LIMIT']))
			$PAGE->setLimit($_GET['LIMIT']);
		$PAGE->setSQL($query,(isset($_GET['FULL'])?$_GET['FULL']:0));

	print "<FORM method='POST' action='".$_SERVER['PHP_SELF']."' onSubmit=\"return valida()\">";
	print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";

	if ((!isset($_GET['action'])) && !isset($_POST['submit'])) {

		$PAGE->execSQL();

		print "<tr><TD align='left'><a href='locais.php?action=incluir'>".TRANS('TXT_INCLUDE_LOCAL')."</a></TD></tr>";


		if (mysql_num_rows($resultado) == 0)
		{
			if (isset($_POST['search'])) {
				print "<tr>".//<td>".TRANS('FIELD_SEARCH')."</td>".
					"<td colspan='4'><input type='text' class='text' name='search' id='idSearch' value='".$search."'>&nbsp;".
					"<input type='submit' name='BT_SEARCH' class='button' value='".TRANS('BT_FILTER')."'>".
					"</td></tr>";

					print "<script>foco('idSearch');</script>";
			}

			print "<tr><td>";
			print mensagem(TRANS('MSG_NO_RECORDS'));
			print "</tr></td>";
		} else {
			$cor=TD_COLOR;
			$cor1=TD_COLOR;
			print "<tr><td colspan='8' class='line'>";
			print "<B>".TRANS('FOUND')." <font color=red>".$PAGE->NUMBER_REGS."</font> ".TRANS('RECORDS_IN_SYSTEM').". ".TRANS('SHOWING_PAGE')." ".$PAGE->PAGE." (".$PAGE->NUMBER_REGS_PAGE." ".TRANS('RECORDS').")</B></TD></tr>";

			print "<tr><td>";
			print "<TABLE border='0' cellpadding='5' cellspacing='0' align='center' width='100%'>";

			print "<tr>".//<td>".TRANS('FIELD_SEARCH')."</td>".
					"<td colspan='4'><input type='text' class='text' name='search' id='idSearch' value='".$search."'>&nbsp;".
					"<input type='submit' name='BT_SEARCH' class='button' value='".TRANS('BT_FILTER')."'>".
				"</td></tr>";
				if (isset($_POST['search'])) {
					print "<script>foco('idSearch');</script>";
				}

			print "<TR class='header'><td class='line'><b>".TRANS('OCO_LOCAL')."</b></TD><td class='line'><b>CNPJ</b></TD> <td class='line'><b>Endereço</b></TD>
				<td class='line'><b>Resp. pela T.I</b></TD><td class='line'><b>Email</b></TD><td class='line'><b>".TRANS('COL_PRIORITY')."</b></TD>
				<td class='line'><b>".TRANS('OCO_STATUS')."</b></TD><td class='line'><b>".TRANS('COL_EDIT')."</b></TD><td class='line'><b>".TRANS('COL_DEL')."</b></TD>";

					$j=2;
			while ($row = mysql_fetch_array($PAGE->RESULT_SQL))
			{
				if ($j % 2){
					$trClass = "lin_par";
				}else	{
					$trClass = "lin_impar";
				}
				
				###### Destaca o Status ######
				if ($row['loc_status'] != 1){
					$status = "<font color=red><b>".strtoupper($row['status_desc'])."</b></font>";
				}else{
					$status = "<font color=blue><b>".strtoupper($row['status_desc'])."</b></font>";
				}
				
				##### Destaca CNPJ #####
				if ($row['loc_cnpj'] != ''){
					$cnpj = $row['loc_cnpj'];
				}else{
					$cnpj = "<font color=red>NÃO INFORMADO</font>";
				}
				$j++;
				print "<tr class=".$trClass." id='linhax".$j."' onMouseOver=\"destaca('linhax".$j."','".$_SESSION['s_colorDestaca']."');\" onMouseOut=\"libera('linhax".$j."','".$_SESSION['s_colorLinPar']."','".$_SESSION['s_colorLinImpar']."');\"  onMouseDown=\"marca('linhax".$j."','".$_SESSION['s_colorMarca']."');\">";
				print "<td class='line'>".$row['local']."</td>";
				print "<td class='line'>".$cnpj."</td>";
				print "<td class='line'>".$row['loc_endereco']."</td>";
				print "<td class='line'>".$row['loc_resp_ti']."</td>";
				print "<td class='line'>".$row['loc_email']."</td>";
				print "<td class='line'>".$row['prioridade']."</td>";
				print "<td class='line'>".$status."</td>";
				print "<td class='line'><a onClick=\"redirect('".$_SERVER['PHP_SELF']."?action=alter&cod=".$row['loc_id']."')\"><img height='16' width='16' src='".ICONS_PATH."edit.png' title='".TRANS('HNT_EDIT')."'></a></td>";
				print "<td class='line'><a onClick=\"confirmaAcao('".TRANS('MSG_DEL_REG')."','".$_SERVER['PHP_SELF']."','action=excluir&cod=".$row['loc_id']."')\"><img height='16' width='16' src='".ICONS_PATH."drop.png' title='".TRANS('HNT_DEL')."'></a></TD>";
				print "</TR>";
			}
               		print "</TABLE>";
               		print "</td></tr>";
			print "<tr><td colspan='8'>";
				$PAGE->showOutputPages();
			print "</td></tr>";
         	}
	} else
	if ((isset($_GET['action']) && $_GET['action'] == "incluir") && (!isset($_POST['submit']))) {

		print "<BR><B>".TRANS('SUBTTL_CAD_LOCAL')."</B><BR>";

		print "<TR>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_LOCAL').":</TD>";
			print "<TD width='80%' align='left' bgcolor=".BODY_COLOR."><INPUT type='text' name='local' class='text' id='idLocal'></TD>";
		print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">CNPJ:</TD>";
			print "<TD width='80%' align='left' bgcolor=".BODY_COLOR."><INPUT type='text' name='loc_cnpj' class='text' id='idLocalCNPJ' onkeypress=\"return digitos(event);\" onkeyup=\"Mascara('CNPJ',this,event);\"></TD>";
		print "</TR>";
		print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">Responsável pela T.I:</TD>";
			print "<TD width='30%' align='left' bgcolor=".BODY_COLOR."><INPUT type='text' name='loc_resp_ti' class='text' id='idResponsavelTI'>";
		print "</tr>";
		print "<tr>";
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Endereço:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'><INPUT type='text' name='loc_endereco' class='text' id='idEndereco'>";		
		print "</tr>";
		print "<tr>";
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Email:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'><INPUT type='text' name='loc_email' class='text' id='idEmail'>";
		print "</tr>";
		print "<TR>";
			print "<TD width='22%' align='left' bgcolor=".TD_COLOR.">Taxa Deslocamento: <font color=red><b>*</font></b> (R$) </TD>";
			print "<TD width='80%' align='left' bgcolor=".BODY_COLOR."><INPUT type='text' name='loc_desloc' class='text' id='idTaxaDesloc' onKeydown=\"Formata(this,20,event,2);\"></TD>";
		print "</TR>";	
		print "<tr>";
		print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_PRIORITY_RESP').":</TD>";
		print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'><select class='select' name='sla' id='idSla'>";
			print "<option value='-1'>".TRANS('SEL_SLA')."</option>";
					$sql="select * from prioridades order by prior_nivel";
					$commit = mysql_query($sql);
					while($row = mysql_fetch_array($commit)){
						print "<option value=".$row['prior_cod'].">".$row["prior_nivel"]."</option>";

					} // while
				print "</select>";
        	print "</td>";
		print "</tr>";

		print "<TR>";
		print "<TD align='left' width='20%' bgcolor='".BODY_COLOR."'><input type='submit'  class='button' value='".TRANS('BT_CAD')."' name='submit'>";
		print "</TD>";
		print "<TD align='left' width='80%' bgcolor='".BODY_COLOR."'><INPUT type='reset'  class='button' value='".TRANS('BT_CANCEL')."' name='cancelar' onClick=\"javascript:history.back()\"></TD>";

        	print "</TR>";

	} else

	if ((isset($_GET['action'])  && $_GET['action']=="alter") && (!isset($_POST['submit']))) {
		
		$sql = "SELECT l .  * , pr.prior_nivel AS prioridade
				FROM localizacao AS l
				LEFT  JOIN prioridades AS pr ON pr.prior_cod = l.loc_prior
				WHERE l.loc_id = ".$_GET['cod']." ";
		// dump($sql);
		$resultado = mysql_query($sql) or die(TRANS('MSG_ERR_QRY_CONS'));
		$row = mysql_fetch_array($resultado);
		
		### Formatação de valores R$ ###
		$taxaDesloc = number_format($row['loc_desloc'],2,',','.');
		
		print "<BR><B>".TRANS('SUBTTL_ALTER_LOCAL')."</B><BR>";

		print "<FORM method='POST' action='".$_SERVER['PHP_SELF']."' onSubmit=\"return valida()\">";
		print "<TABLE border='0'  align='left' width='80%' bgcolor='".BODY_COLOR."'>";
		print "<TR>";
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."' valign='top'>".TRANS('OCO_FIELD_LOCAL').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'><INPUT type='text' class='select' name='local' id='idLocal' value='".$row['local']."'></TD>";
		print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."' valign='top'>CNPJ:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'><INPUT type='text' class='select' name='loc_cnpj' id='idLocalCNPJ' onkeypress=\"return digitos(event);\" onkeyup=\"Mascara('CNPJ',this,event);\" value='".$row['loc_cnpj']."'></TD>";
		print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."' valign='top'>Responsável pela T.I:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'><INPUT type='text' class='select' name='loc_resp_ti' id='idResponsavelTI' value='".$row['loc_resp_ti']."'></TD>";
        	print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Endereço:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'><INPUT type='text' name='loc_endereco' class='text' id='idEndereco' value='".$row['loc_endereco']."'>";
          	print "</TR>";
		print "<TR>";
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Email:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'><INPUT type='text' name='loc_email' class='text' id='idEmail' value='".$row['loc_email']."'>";
        	print "</TR>";
		print "<TR>";
			print "<TD width='22%' align='left' bgcolor=".TD_COLOR.">Taxa Deslocamento: <font color=red><b>*</font></b> (R$) </TD>";
			print "<TD width='80%' align='left' bgcolor=".BODY_COLOR."><INPUT type='text' name='loc_desloc' class='text' id='idTaxaDesloc' onKeydown=\"Formata(this,20,event,2);\" value='".$taxaDesloc."'></TD>";
		print "</TR>";	
		print "<TR>";
		print "<TD width='20%' align='left' bgcolor='".TD_COLOR."' valign='top'>".TRANS('COL_PRIORITY').":</TD>";
		print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>";
			print "<select  class='select' name='p_nivel'>";
			$sql = "select * from prioridades where prior_cod=".$row["loc_prior"]."";
			$commit = mysql_query($sql);
			$rowR = mysql_fetch_array($commit);
				print "<option value='-1'>".TRANS('SEL_SLA')."</option>";

					$sql="select * from prioridades  order by prior_nivel";
					$commit = mysql_query($sql);
					while($rowB = mysql_fetch_array($commit)){
						print "<option value=".$rowB["prior_cod"]."";
					    if ($rowB['prior_cod'] == $row['loc_prior'] ) {
                            print " selected";
                        }
                        print " >".$rowB["prior_nivel"]."</option>";

                    } // while
			print "</select>";
		print "</td>";
		print "</TR>";
		print "<TR>";
		print "<TD width='20%' align='left' bgcolor='".TD_COLOR."' valign='top'>".TRANS('OCO_STATUS').":</TD>";
		print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>";
			print "<select  class='select' name='status'>";
			$sql = "SELECT * FROM statusLocais WHERE status_id=".$row["loc_status"]."";
			$commit = mysql_query($sql);
			$rowR = mysql_fetch_array($commit);
				print "<option value='-1'>".TRANS('SEL_SLA')."</option>";
					$sql="SELECT * FROM statusLocais  ORDER BY status_desc";
					$commit = mysql_query($sql);
					while($rowB = mysql_fetch_array($commit)){
						print "<option value=".$rowB["status_id"]."";
					    if ($rowB['status_id'] == $row['loc_status'] ) {
                            print " selected";
                        }
                        print " >".$rowB["status_desc"]."</option>";

                    } // while
			print "</select>";
		print "</td>";
	        print "</TR>";

		print "<TR>";
		print "<BR>";
		print "<TD align='left' width='20%' bgcolor='".BODY_COLOR."'><input type='submit'  class='button' value='".TRANS('BT_ALTER')."' name='submit'>";
		print "<input type='hidden' name='cod' value='".$_GET['cod']."'>";
		print "</TD>";
	        print "<TD align='left' width='80%' bgcolor='".BODY_COLOR."'><INPUT type='reset'  class='button' value='".TRANS('BT_CANCEL')."' name='cancelar' onClick=\"javascript:history.back()\"></TD>";

        	print "</TR>";


	} else

	if (isset($_GET['action']) && $_GET['action'] == "excluir"){

		$sql_3 = "SELECT * FROM ocorrencias where local ='".$_GET['cod']."'";
		$exec_3 = mysql_query($sql_3) or die(TRANS('MSG_ERR_NOT_RESCUE_INFO_CALL_LOCAL'));
		$total= mysql_num_rows($exec_3);

		if ($total!=0)
		{
			print "<script>mensagem('".TRANS('MSG_NOT_EXCLUDE_LOCAL_ASSOC_OCCO')."');
				redirect('locais.php');</script>";
		}
		else
		{
			$query2 = "DELETE FROM localizacao WHERE loc_id=".$_GET['cod']."";
			$resultado2 = mysql_query($query2) or die(TRANS('ERR_DEL'));

			$aviso = TRANS('MSG_OK_RESG_EXCLUDE');

			print "<script>mensagem('".$aviso."'); redirect('locais.php');</script>";

		}


	} else

	if ($_POST['submit'] == TRANS('BT_CAD')){
	
		$taxaDesloc = trim(str_replace('.','',$_POST['loc_desloc']));
		$taxaDesloc = trim(str_replace(',','.',$taxaDesloc));

		$erro=false;

		$qryl = "SELECT local FROM localizacao WHERE local='".$_POST['local']."'";
		$resultado = mysql_query($qryl);
		$linhas = mysql_num_rows($resultado);

		if ($linhas > 0)
		{
				$aviso = TRANS('MSG_REG_IN_CAD');
				$erro = true;
		}

		if (!$erro)
		{
			$query = "INSERT INTO localizacao (local,loc_cnpj,loc_resp_ti, loc_prior, loc_endereco, loc_email, loc_desloc) ".
						"values ('".$_POST['local']."','".$_POST['loc_cnpj']."','".$_POST['loc_resp_ti']."','".$_POST['sla']."', '".$_POST['loc_endereco']."','".$_POST['loc_email']."', '
								".$taxaDesloc."')";
			$resultado = mysql_query($query) or die(TRANS('MSG_ERR_INCLUDE_LOCAL').$query);
			$aviso = TRANS('MSG_OK_RESG_INCLUDE');
		}

		echo "<script>mensagem('".$aviso."'); redirect('locais.php');</script>";

	} else

	if ($_POST['submit'] == TRANS('BT_ALTER')) {

		$taxaDesloc = trim(str_replace('.','',$_POST['loc_desloc']));
		$taxaDesloc = trim(str_replace(',','.',$taxaDesloc));
	
		$query2 = "UPDATE localizacao SET local='".$_POST['local']."', loc_resp_ti='".$_POST['loc_resp_ti']."', loc_cnpj='".$_POST['loc_cnpj']."', ".
				"loc_prior='".$_POST['p_nivel']."', loc_endereco='".$_POST['loc_endereco']."', loc_email= '".$_POST['loc_email']."', loc_desloc= '".$taxaDesloc."', ".
				"loc_status='".$_POST['status']."' WHERE loc_id=".$_POST['cod']."";
				// dump($query2);exit;
		$resultado2 = mysql_query($query2) or die(TRANS('MSG_ERR_UPDATE_REG'). $query2);

		$aviso = TRANS('MSG_LOCAL_ALTER_OK');
		echo "<script>mensagem('".$aviso."'); redirect('locais.php');</script>";

	}



?>
<script type="text/javascript">
<!--
	function valida(){
		var ok = validaForm('idLocal','','Local',1);
		//if (ok) var ok = validaForm('idReitoria','COMBO','Reitoria',1);
		//if (ok) var ok = validaForm('idStatus','COMBO','Status',1);

		return ok;
	}
	
	function Mascara(tipo, campo, teclaPress) {
        if (window.event)
        {
		   var tecla = teclaPress.keyCode;
        } else {
			tecla = teclaPress.which;
        }

        var s = new String(campo.value);
        // Remove todos os caracteres à seguir: ( ) / - . e espaço, para tratar a string denovo.
        s = s.replace(/(\.|\(|\)|\/|\-| )+/g,'');

        tam = s.length + 1;
        
		if ( tecla != 9 && tecla != 8 ) {
			switch (tipo){
				case 'CPF' :
					if (tam > 3 && tam < 7)
						campo.value = s.substr(0,3) + '.' + s.substr(3, tam);
					if (tam >= 7 && tam < 10)
						campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,tam-6);
					if (tam >= 10 && tam < 12)
						campo.value = s.substr(0,3) + '.' + s.substr(3,3) + '.' + s.substr(6,3) + '-' + s.substr(9,tam-9);
					if (tam > 12)                           
						campo.value = campo.value.substr(0,campo.value.length-1);                                                       
				break;

				case 'CNPJ' :

					if (tam > 2 && tam < 6)
						campo.value = s.substr(0,2) + '.' + s.substr(2, tam);
					if (tam >= 6 && tam < 9)
						campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,tam-5);
					if (tam >= 9 && tam < 13)
						campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,tam-8);
					if (tam >= 13 && tam < 15)
						campo.value = s.substr(0,2) + '.' + s.substr(2,3) + '.' + s.substr(5,3) + '/' + s.substr(8,4)+ '-' + s.substr(12,tam-12);
					if (tam > 15)                           
						campo.value = campo.value.substr(0,campo.value.length-1);                       
				break;

				case 'TEL' :
					if (tam > 2 && tam < 4)
						campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,tam);
					if (tam >= 7 && tam < 11)
						campo.value = '(' + s.substr(0,2) + ') ' + s.substr(2,4) + '-' + s.substr(6,tam-6);
					if (tam > 11)                           
						campo.value = campo.value.substr(0,campo.value.length-1);                       
				break;

				case 'DATA' :
					if (tam > 2 && tam < 4)
						campo.value = s.substr(0,2) + '/' + s.substr(2, tam);
					if (tam > 4 && tam < 11)
						campo.value = s.substr(0,2) + '/' + s.substr(2,2) + '/' + s.substr(4,tam-4);
					if (tam > 9)                            
						campo.value = campo.value.substr(0,campo.value.length-1);                       
				break;
				
				case 'CEP' :
					if (tam > 5 && tam < 7)
						campo.value = s.substr(0,5) + '-' + s.substr(5, tam);
					if (tam > 9)                            
						campo.value = campo.value.substr(0,campo.value.length-1);                       
				break;
			}
        }
	}
	//--->Função para verificar se o valor digitado é número...<---
	function digitos(event){
		if (window.event) {
			// IE
			key = event.keyCode;
		} else if ( event.which ) {
			// netscape
			key = event.which;
		}
		if ( key != 8 || key != 13 || key < 48 || key > 57 )
			return ( ( ( key > 47 ) && ( key < 58 ) ) || ( key == 8 ) || ( key == 13 ) );
		return true;
	}
	
	function Limpar(valor, validos) {
		// retira caracteres invalidos da string
		var result = "";
		var aux;
		for (var i=0; i < valor.length; i++) {
			aux = validos.indexOf(valor.substring(i, i+1));
			if (aux>=0) {
				result += aux;
			}
		}
		return result;
	}
	
	//Formata número tipo moeda usando o evento onKeyDown
	function Formata(campo,tammax,teclapres,decimal) {
		var tecla = teclapres.keyCode;
		vr = Limpar(campo.value,"0123456789");
		tam = vr.length;
		dec=decimal
		if (tam < tammax && tecla != 8){ 
			tam = vr.length + 1 ; 
		}
		if (tecla == 8 ){
			tam = tam - 1 ; 
		}
		if ( tecla == 8 || tecla >= 48 && tecla <= 57 || tecla >= 96 && tecla <= 105 ){
			if ( tam <= dec ){ 
				campo.value = vr ; 
			}
			if ( (tam > dec) && (tam <= 5) ){
				campo.value = vr.substr( 0, tam - 2 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 6) && (tam <= 8) ){
				campo.value = vr.substr( 0, tam - 5 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 9) && (tam <= 11) ){
				campo.value = vr.substr( 0, tam - 8 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 12) && (tam <= 14) ){
				campo.value = vr.substr( 0, tam - 11 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - dec, tam ) ; 
			}
			if ( (tam >= 15) && (tam <= 17) ){
				campo.value = vr.substr( 0, tam - 14 ) + "." + vr.substr( tam - 14, 3 ) + "." + vr.substr( tam - 11, 3 ) + "." + vr.substr( tam - 8, 3 ) + "." + vr.substr( tam - 5, 3 ) + "," + vr.substr( tam - 2, tam ) ;
			}
		} 
	}
	
	
-->
</script>


<?php 
print "</table>";
print "</form>";
print "</body>";
print "</html>";
