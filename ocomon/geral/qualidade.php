<?php 
	session_start();
	include ("../../includes/include_geral.inc.php");
	include ("../../includes/include_geral_II.inc.php");;		

 ?>

<HTML>
<HEAD>
</head>

<BODY bgcolor=<?php print BODY_COLOR ?>>

<?php 	


	
		$numero = $_REQUEST['numero'];
		
		$hoje = date("Y-m-d H:i:s");
		$hoje2 = date("d/m/Y");
		
		$query = "select o.*,u.user_id as user, u.* from ocorrencias as o, usuarios as u where o.operador = u.user_id and numero=".$numero."";
		
		$resultado = mysql_query($query);
		$row = mysql_fetch_array($resultado);
		$linhas = mysql_numrows($resultado);
		$s_uid = $row['user'];

		//flavio
		$data_atend = $row['data_atendimento']; //Data de atendimento!!!
		//flavio
		
		$query2 = "select a.*, u.* from assentamentos a, usuarios u where a.responsavel=u.user_id and a.ocorrencia='$numero' order by numero";
		$resultado2 = mysql_query($query2);
		$linhas2 = mysql_num_rows($resultado2);
		
		if ($s_nivel == 1) $linkEdita = "<br><b><a href='altera_dados_ocorrencia.php?numero=".$numero."'>Editar ocorrência como admin:</a></b><br>"; else
			$linkEdita = "<b>Qualificar o chamado</b>";			
	
	
		print $linkEdita;
		
		#### VERIFICA SE O CHAMADO JÁ FOI AVALIADO #####
		error_reporting(0);
		$sqlNota = "SELECT * 
				FROM ocorrencias 
				WHERE numero = ".$numero."";
		$execNota = mysql_query($sqlNota);
		$achou = mysql_fetch_array($execNota);
		
		// print "BLÁ: ".$achou ['usu_nota'];
		
		if ($achou ['usu_nota'] != 7){
			print "<script>alert('ATENÇÃO: Este chamado já possui uma nota de avaliação em nosso sistema e por isso não é possível reavaliá-lo! Obrigado.');</script>";
		}
		#######################################

 ?>

	<FORM method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" ENCTYPE="multipart/form-data" onSubmit="return valida()">

		<TABLE border="0"  align="left" width="100%" bgcolor=<?php print BODY_COLOR ?>>
        	
<?php 
			print "<div id='anexos' style='display:none'>";
				if ($row['status'] == 4){$stat_flag="";} else $stat_flag =" where stat_id<>4 ";
				print "<SELECT class='select' name='status' id='idStatus' size=1>";
				print "<option value= '-1'>Selecione o status</option>";
				$query_stat = "SELECT * from status ".$stat_flag." order by status";  
				$exec_stat = mysql_query($query_stat);
				while ($row_stat = mysql_fetch_array($exec_stat)){
					print "<option value=".$row_stat['stat_id']."";
						if ($row_stat['stat_id'] == $row['status']) {
							print " selected";
						}
					print " >".$row_stat['status']." </option>";
				}
				print "</select>";
				
				print "<SELECT class='select' name='problema' id='idProblema' size=1>";
				print "<option value= '-1'>Selecione o problema</option>";
				$query = "SELECT * from problemas order by problema";
				$exec_prob = mysql_query($query);
				while ($row_prob = mysql_fetch_array($exec_prob)){
					print "<option value=".$row_prob['prob_id']."";
						if ($row_prob['prob_id'] == $row['problema']) {
							print " selected";
						}
					print " >".$row_prob['problema']." </option>";
				}
				print "</select>";
				print "<SELECT class='select' name='sistema' id='idArea'>";
				print "<option value= '-1'>Selecione a área</option>";
				$query = "SELECT * from sistemas order by sistema";
				$exec_sis = mysql_query($query);
				while ($row_sis = mysql_fetch_array($exec_sis)){
					print "<option value=".$row_sis['sis_id']."";
						if ($row_sis['sis_id'] == $row['sistema']) {
							print " selected";
						}
					print " >".$row_sis['sistema']." </option>";
				}
				print "</select>";
				print "</div>";

			
			print "<TR>";
			print "<TD  width='30%' align='left' bgcolor='".BODY_COLOR."'>";
			$instituicao = $row['instituicao'];
			//print "SACO";
			if ($instituicao != null){
				$query = "SELECT * FROM instituicao WHERE inst_cod=$instituicao";    
			}else	{
				$query = "SELECT * FROM instituicao WHERE inst_cod is null";   
			}
			$resultado3 = mysql_query($query);
			$nomeinst = "";
			if (mysql_numrows($resultado3) > 0) {
				$nomeinst=mysql_result($resultado3,0,1);
			}
			print "<div id='instit' style='display:none'>";
			print "<select  class='select' name='institui' id='idUnidade' size=1>";
			$query_todas="select * from instituicao order by inst_cod";
			$result_todas=mysql_query($query_todas);
			if ($nomeinst == ""){
				print "<option value='' selected> </option>";	    
			}
			while($row_todas=mysql_fetch_array($result_todas)){
				if ($row_todas[inst_cod]==$instituicao){
					$s='selected ';
				}else{
					$s='';
				}
					print "<option value=".$row_todas[inst_cod]." $s>".$row_todas[inst_nome]."</option>";	
			} // while
			print "</select>";
			print "</TD>";
			print "</div>";
			
        	        print "<TD colspan='3' width='30%' align='left' bgcolor='".BODY_COLOR."'>";
			print "<div id='anexos' style='display:none'>";
			print "<INPUT type='text'  class='text' name='etiq' id='idEtiqueta' value ='".$row['equipamento']."' size='15'></TD>";
			print "</div>";
			print "</TR>";
			print "<TR>";
			print "<TD  width='30%' align='left' bgcolor='".BODY_COLOR."'>";	
			print "<div id='anexos' style='display:none'>";
			print "<SELECT  class='select' name='local' id='idLocal' size=1>";
				print "<option value= '-1'>Selecione o setor</option>";
				$query = "SELECT * from localizacao order by local";
				$exec_loc = mysql_query($query);
				while ($row_loc = mysql_fetch_array($exec_loc)){
					print "<option value=".$row_loc['loc_id']."";
						if ($row_loc['loc_id'] == $row['local']) {
							print " selected";
						}
						print " >".$row_loc['local']." </option>";
				}
				print "</select>";
				print "</div>";
				print "</TD>";
				print "<TD colspan='3' width='30%' align='left' bgcolor='".BODY_COLOR."'>";
				print "<div id='anexos' style='display:none'>";
				print "<SELECT class='select' name='operador' id='idOperador'>";
				//print "<option value=".$row['user_id']." selected>".$row['nome']."</option>";
				$query = "SELECT u.*, a.* from usuarios u, sistemas a where u.AREA = a.sis_id and a.sis_atende=1 and u.nivel not in (3,4,5) order by login";
				$exec_oper = mysql_query($query);
				while ($row_oper = mysql_fetch_array($exec_oper)){
					print "<option value=".$row_oper['user_id']." ";
					if ($row_oper['user_id']== $row['operador'])
						print " selected";
					print ">".$row_oper['nome']."</option>";
				}
				print "</select>";
				print "</div>";
				print "</TD>";
				print "</TR>";
    	    
		$antes = $row['status'];
		if ($row['status'] == 4) //Encerrado
		{
			$antes = 4;
			
             ?>
            <TR>
                	<TD align="left" bgcolor=<?php print TD_COLOR ?>>Data de abertura:</TD>
                    <TD align="left" bgcolor=<?php print BODY_COLOR ?>><?php print datab($row['data_abertura']); ?></TD>
                    <TD align="left" bgcolor=<?php print TD_COLOR ?>>Data de encerramento:</TD>
                    <TD colspan='3' align="left" bgcolor=<?php print BODY_COLOR ?>><?php print datab($row['data_fechamento']); ?></TD>
          </TR>
          <?php 
		      }
        		else //chamado não encerrado
    		  {
	       ?>
        <?php 
        }
        if ($linhas2!=0) {
                $i=0;
			while ($rowAS=mysql_fetch_array($resultado2)){
                         ?>
				<tr>        
					<TD width="30%" bgcolor="<?php print TD_COLOR ?>" valign="top">Assentamento <?php print $i+1; ?> de <?php print $linhas2; ?> por <b><?php print $rowAS['nome']; ?></b> em <?php print datab($rowAS['data']); ?></TD>
					<TD colspan='5' align="left" bgcolor="white" valign="top"><?php print nl2br($rowAS['assentamento']); ?></TD>
				</TR>
             <?php 
			$i++;
			}
		}	
		?>

		<TR>
			<TD width="20%" align="left" bgcolor=<?php print TD_COLOR ?> valign="top">Assentamento:</TD>
			<TD colspan='5' width="80%" align="left" bgcolor=<?php print BODY_COLOR ?>><TEXTAREA id="idAssentamento" class="textarea"  name="assentamento"></textarea> 
			</TD>
		</TR>
        

		<?php 
			
			$qryTela = "select * from imagens where img_oco = ".$row['numero']."";
			$execTela = mysql_query($qryTela) or die ("NÃO FOI POSSÍVEL RECUPERAR AS INFORMAÇÕES DA TABELA DE IMAGENS!");
			//$rowTela = mysql_fetch_array($execTela);
			$isTela = mysql_num_rows($execTela);
			$cont = 0;
			while ($rowTela = mysql_fetch_array($execTela)) {
			//if ($isTela !=0) {		
				$cont++;
				print "<tr>";
			
				print "<TD  bgcolor='".TD_COLOR."' >Anexo ".$cont.":</td>";
				print "<td colspan='5' bgcolor='".BODY_COLOR."'><a onClick=\"javascript:popupWH('../../includes/functions/showImg.php?file=".$row['numero']."&cod=".$rowTela['img_cod']."',".$rowTela['img_largura'].",".$rowTela['img_altura'].")\"><img src='../../includes/icons/attach2.png'>".$rowTela['img_nome']."</a></TD>";
				print "</tr>";
			}

			$qrymail = "SELECT u.*, a.*,o.* from usuarios u, sistemas a, ocorrencias o where ".
						"u.AREA = a.sis_id and o.aberto_por = u.user_id and o.numero = ".$numero."";
			$execmail = mysql_query($qrymail);
			$rowmail = mysql_fetch_array($execmail);
			if ($rowmail['sis_atende']==0){
				$habilita = "";
			} else $habilita = "disabled";
			
			print "<tr><td bgcolor='".TD_COLOR."'>N&iacute;vel de satisfa&ccedil;&atilde;o para este chamado:";
			print "<td colspan='2'><SELECT class='select' name='nota' id='idNota' size=1>";
	        	  	 // print "<option value=-1>Selecione a Nota</option>";
				$query = "SELECT * FROM nota_aval WHERE status_id = '1'";
				$exec_nota = mysql_query($query);
				while ($linhaNota = mysql_fetch_array($exec_nota)){
					print "<option value=".$linhaNota['nota_aval_id'].">".$linhaNota['nota_aval']."</option>";
				}
				print "</select>";
			print "<td>";
			print "</tr>";
				
			print "<tr><td bgcolor='".TD_COLOR."'>Enviar e-mail para:</td>".
					"<td colspan='2'><input type='checkbox' value='ok' name='mailAR' checked title='Envia email para a área selecionada para esse chamado'>&Aacute;rea Respons&aacute;vel&nbsp;&nbsp;".
									// "<input type='checkbox' value='ok' name='mailOP' checked title='Envia e-mail para o operador selecionado no chamado'>Operador&nbsp;&nbsp;".
					"</tr>";
			
			print "<tr><td colspan='3'>&nbsp;</td></tr>";					
			print "<tr><td colspan='3' align='center'>";
                            if ($data_atend =="") { 
                                print "<input type='checkbox' value='ok' name='resposta' checked title='Desmarque essa opção se esse assentamento não corresponder a uma primeira resposta do chamado'>1.ª Resposta";
                            } 
			print "</td><td colspan='3'></td></tr>";

		 ?>
		<tr>
		<TD colspan='3' align="center" width="50%" bgcolor=<?php print BODY_COLOR ?>>
	                <input type="hidden" name="rodou" value="sim">
			<?php 
				print "<input type='hidden' name='data_gravada' value='".date("Y-m-d H:i:s")."'>";				
			 ?>
					<input type="submit" value="Ok  " name="ok">
					<input type="hidden" name="abertopor" value="<?php print $rowmail['user_id'] ?>">
                </TD>
                <TD colspan='3' align="center" width="25%" bgcolor=<?php print BODY_COLOR ?>> 
					<INPUT type="reset" value="Cancelar" onClick="javascript:history.back()" name="cancelar">
				</TD>
				
         </TR>
         <?php 
		 // print "<pre>";
				// dump($_SESSION);
			// print "</pre>";
			// exit;
			$s_uid = $_SESSION['s_uid'];
			
			$operador = $_POST['operador'];
			$problema = $_POST['problema'];
			$institui = $_POST['institui'];
			$sistema = $_POST['sistema'];
			$local = $_POST['local'];
			$status = $_POST['status'];
			$etiq = $_POST['etiq'];
			$resposta = $_POST['resposta'];
			$dataFechamento = date("Y-m-d H:i:s");
			
		 $rodou = $_REQUEST['rodou'];
         	if ($rodou == "sim") {
                	$depois = $status;
                   	$erro= "nao";
			
                    if ($erro == "nao")  {
	                    
	                    //showArray($_FILES); showArray($_POST); exit;
	                    
			$gravaImg = false;
			if (isset($_FILES['img']) and $_FILES['img']['name']!="") {
				$qryConf = "SELECT * FROM config";
				$execConf = mysql_query($qryConf) or die ("NÃO FOI POSSÍVEL ACESSAR AS INFORMAÇÕES DE CONFIGURAÇÃO, A TABELA CONF FOI CRIADA?");
				$rowConf = mysql_fetch_array($execConf);
				$arrayConf = array();
				$arrayConf = montaArray($execConf,$rowConf);
				$upld = upload('img',$arrayConf);	
				
				if ($upld =="Ok") {
					$gravaImg = true;
				} else {
					$upld.="<br><a align='center' onClick=\"exibeEscondeImg('idAlerta');\"><img src='".ICONS_PATH."/stop.png' width='16px' height='16px'>&nbsp;Fechar</a>";
					print "</table>";
					print "<div class='alerta' id='idAlerta'><table bgcolor='#999999'><tr><td colspan='2' bgcolor='yellow'>".$upld."</td></tr></table></div>";
					exit;
				}
			}

				$data = datam($hoje2);
				$responsavel = $_SESSION['s_uid'];
				
				//print "User_ID: ".$responsavel;
				
                            //$assentamento = addslashes($assentamento);
                            
				$assentamento = $_POST['assentamento'];
							
                            $queryA = "INSERT INTO assentamentos (ocorrencia, assentamento, data, responsavel)".
													" values (".$numero.",'".$assentamento."', '".$data."', '".$responsavel."')";
								
					if ($gravaImg) {
						//INSERÇÃO DA IMAGEM NO BANCO
						$fileinput=$_FILES['img']['tmp_name'];
						$tamanho = getimagesize($fileinput);
						
						if(chop($fileinput)!=""){
							// $fileinput should point to a temp file on the server
							// which contains the uploaded image. so we will prepare
							// the file for upload with addslashes and form an sql
							// statement to do the load into the database.
							$image = addslashes(fread(fopen($fileinput,"r"), 1000000));
							$SQL = "Insert Into imagens (img_nome, img_oco, img_tipo, img_bin, img_largura, img_altura) values ".
									"('".$_FILES['img']['name']."',".$numero.", '".$_FILES['img']['type']."', '".$image."', ".$tamanho[0].", ".$tamanho[1].")";
							// now we can delete the temp file
							unlink($fileinput);
						} /*else {
							echo "NENHUMA IMAGEM FOI SELECIONADA!";
							exit;
						}*/
						$exec = mysql_query($SQL);// or die ("NÃO FOI POSSÍVEL GRAVAR O ARQUIVO NO BANCO DE DADOS! ".$SQL);
						if ($exec == 0) $aviso.= "NÃO FOI POSSÍVEL ANEXAR A IMAGEM!<br>";
						
					}						
					
				$s_usuario = $_SESSION['s_usuario'];
				$sqlMailLogado = "select * from usuarios where login = '".$s_usuario."'";
				$execMailLogado = mysql_query($sqlMailLogado) or die('ERRO AO TESTAR RECUPERAR AS INFORMAÇÕES DO USUÁRIO!');
				$rowMailLogado = mysql_fetch_array($execMailLogado);
				
				$local = $_REQUEST['local'];
				$qryLocal = "select * from localizacao where loc_id=".$local."";
				$execLocal = mysql_query($qryLocal);
				$rowLocal = mysql_fetch_array($execLocal);

				$qryfull = $QRY["ocorrencias_full_ini"]." WHERE o.numero = ".$numero."";
				$execfull = mysql_query($qryfull) or die('ERRO, NÃO FOI POSSÍVEL RECUPERAR AS VARIÁVEIS DE AMBIENTE!'.$qryfull);
				$rowfull = mysql_fetch_array($execfull);
				
				$VARS = array();
				$VARS['%numero%'] = $rowfull['numero'];
				$VARS['%usuario%'] = $rowfull['contato'];
				$VARS['%contato%'] = $rowfull['contato'];
				$VARS['%descricao%'] = $rowfull['descricao'];
				$VARS['%setor%'] = $rowfull['setor'];
				$VARS['%ramal%'] = $rowfull['telefone'];
				$VARS['%assentamento%'] = $assentamento;
				//$VARS['%site%'] = "<a href='http://localhost/desenv_ocomon'>http://localhost/desenv_ocomon/</a>";
				$VARS['%site%'] = "<a href='".$_SESSION['s_ocomon_site']."'>OcoMon - Suporte ao Usuário</a>";
				$VARS['%area%'] = $rowfull['area'];
				$VARS['%operador%'] = $rowfull['nome'];
				$VARS['%editor%'] = $rowMailLogado['contato'];
				$VARS['%problema%'] = $rowfull['problema'];
				$VARS['%versao%'] = VERSAO;
				
				$qryconf = "SELECT * FROM mailconfig";
				$execconf = mysql_query($qryconf) or die ('ERRO NA TENTATIVA DE RECUPERAR AS INFORMAÇÕES DE ENVIO DE E-MAIL!');
				$rowconf = mysql_fetch_array($execconf);
				$mailOP = $_POST['mailOP'];
				$mailAR = $_POST['mailAR'];
				
				if ($mailOP){ 
					$event = 'edita-para-operador';
					$qrymsg = "SELECT * FROM msgconfig WHERE msg_event like ('".$event."')";
					$execmsg = mysql_query($qrymsg) or die('ERRO NO MSGCONFIG');
					$rowmsg = mysql_fetch_array($execmsg);
					
					$sqlMailOper = "select * from usuarios where user_id =".$operador."";
					$execMailOper = mysql_query($sqlMailOper);
					$rowMailOper = mysql_fetch_array($execMailOper);
					
/*								$flag = envia_email_operador($numero, $rowMailOper['email'],$rowMailLogado['email'] ,$row['descricao'], 
											$assentamento, $row['contato'], $rowLocal['local'], $row['telefone'], $rowMailOper['nome'], 
											$rowMailLogado['nome'], OCOMON_SITE);							*/
					$VARS['%operador%'] = $rowMailOper['nome'];
					// send_mail($event, $rowMailOper['email'], $rowconf, $rowmsg, $VARS);
				}
				if ($mailAR){
					$event = 'edita-para-area';
					$qrymsg = "SELECT * FROM msgconfig WHERE msg_event like ('".$event."')";
					$execmsg = mysql_query($qrymsg) or die('ERRO NO MSGCONFIG');
					$rowmsg = mysql_fetch_array($execmsg);
					
					$sqlMailArea = "select * from sistemas where sis_id = ".$sistema."";
					$execMailArea = mysql_query($sqlMailArea);
					$rowMailArea = mysql_fetch_array($execMailArea);
					
/*								$flag = envia_email_area($numero, $rowMailArea['sis_email'], $row['descricao'], 
											$assentamento, $row['contato'], $rowLocal['local'], $row['telefone'], 
											$rowMailLogado['nome'], $rowMailArea['sistema'], OCOMON_SITE);*/
					
					// send_mail($event, $rowMailArea['sis_email'], $rowconf, $rowmsg, $VARS);
				}
				if ($mailUS){
					$event = 'edita-para-usuario';
					$qrymsg = "SELECT * FROM msgconfig WHERE msg_event like ('".$event."')";
					$execmsg = mysql_query($qrymsg) or die('ERRO NO MSGCONFIG');
					$rowmsg = mysql_fetch_array($execmsg);
					
					
					$sqlMailUs = "select * from usuarios where user_id = ".$_POST['abertopor']."";
					$execMailUs = mysql_query($sqlMailUs) or die('NÃO FOI POSSÍVEL ACESSAR A BASE DE USUÁRIOS PARA O ENVIO DE EMAIL!');
					$rowMailUs = mysql_fetch_array($execMailUs);
					
					$qryresposta = "select u.*, a.* from usuarios u, sistemas a where u.AREA = a.sis_id and u.user_id = ".$_SESSION['s_uid'].""; 
					$execresposta = mysql_query($qryresposta) or die ('NÃO FOI POSSÍVEL IDENTIFICAR O EMAIL PARA RESPOSTA!');
					$rowresposta = mysql_fetch_array($execresposta);
					
/*								$flag = mail_user_assentamento($rowMailUs['email'], $rowresposta['sis_email'], $rowMailUs['nome'],$_GET['numero'],
											$assentamento,OCOMON_SITE);*/
					// send_mail($event, $rowMailUs['email'], $rowconf, $rowmsg, $VARS);
				}

				$query = "UPDATE ocorrencias SET usu_nota = ".$_POST['nota']." WHERE numero=".$numero."";
				//$query = "UPDATE ocorrencias SET usu_nota = ".$nota." WHERE numero=".$numero."";
				//print $query;
				$resultado4 = mysql_query($query);
				
				$resultado3 = mysql_query($queryA) or die('NÃO FOI POSSÍVEL GRAVAR AS INFORMAÇÕES DE EDIÇÃO DO CHAMADO!<br>'.$queryA);
				// print "Antes: ".$antes;
				// print "Depois: ".$depois;
								
                            	if ($antes != $depois) //Status alterado!!
				{   //$status!=1 and 
					
					if (($data_atend==null) and ($status!=4) and ($resposta == "Ok")) //para verificar se já foi setada a data do inicio do atendimento. //Se eu incluir um assentamento seto a data de atendimento
                                    	{    
						$query = "UPDATE ocorrencias SET operador='".$operador."', problema = '".$problema."', instituicao='".$institui."', equipamento = '".$etiq."', sistema = '".$sistema."' "
								."\n , local=".$local.", data_fechamento=NULL, status='".$status."', data_atendimento='".$data."' WHERE numero='".$numero."'";
	                                	//print "<script>mensagem('Passo 1');</script>";exit;
						$resultado4 = mysql_query($query);
					}  else
				 	{							
            	    	                 	$query = "UPDATE ocorrencias SET operador='".$operador."', problema =' ".$problema."' , instituicao='".$institui."', equipamento = '".$etiq."', sistema = '".$sistema."' "
								."\n , local='".$local."', data_fechamento='".$dataFechamento."', status='".$status." 'WHERE numero='".$numero."'";
                        	        	//print "<script>mensagem('Passo 2');</script>";
						//print $query;exit;
						$resultado4 = mysql_query($query);
					}
				} else
				{
				//exit;
					if (($data_atend==null) and ($status!=4) and ($resposta == "ok")) //para verificar se já foi setada a data do inicio do atendimento. //Se eu incluir um assentamento seto a data de atendimento
                                    	{    
						$query = "UPDATE ocorrencias SET operador='".$operador."', problema = '".$problema."', instituicao='".$institui."', equipamento = '".$etiq."', sistema = '".$sistema."' "
								."\n , local='".$local."', data_fechamento='NULL', status=".$status.", data_atendimento='".$data."' WHERE numero=".$numero."";
						//print "<script>mensagem('Passo 3');</script>";exit;
	                                	$resultado4 = mysql_query($query);
					} else {
						$query = "UPDATE ocorrencias SET operador=".$operador.", problema = ".$problema.", instituicao='".$institui."', equipamento = '".$etiq."', sistema = '".$sistema."' "
								."\n, local=".$local.", status=".$status." WHERE numero=".$numero."";
						//print "<script>mensagem('Passo 4');</script>";exit;
						$resultado4 = mysql_query($query);
					}
				}		

                                if (($resultado3==0) OR ($resultado4 == 0))
	                       	{
                                 	$aviso = "ERRO DE ACESSO. Um erro ocorreu ao tentar alterar ocorrência no sistema. - $query";
    	                        }  else
        	               {
        	               
 					$sqlDoc1 = "select * from doc_time where doc_oco = ".$numero."";
					//$sqlDoc1 = "select * from doc_time where doc_oco = ".$numero." and doc_user = ".$_SESSION['s_uid']."";
 					$execDoc1 = mysql_query($sqlDoc1) or die('ERRO<br>'.$sqlDoc1);
 					$regDoc1 = mysql_num_rows($execDoc1);
 					$rowDoc1 = mysql_fetch_array($execDoc1);
 					if ($regDoc1 >0) {
 						$sqlDoc  = "update doc_time set doc_edit=doc_edit+".diff_em_segundos($_POST['data_gravada'],date("Y-m-d H:i:s"))." where doc_id = ".$rowDoc1['doc_id']."";
 						$execDoc =mysql_query($sqlDoc) or die ('ERRO NA TENTATIVA DE ATUALIZAR O TEMPO DE DOCUMENTAÇÃO DO CHAMADO!<br>').$sqlDoc;
 					} else {
 						$sqlDoc = "insert into doc_time (doc_oco, doc_open, doc_edit, doc_close, doc_user) values (".$numero.", 0, ".diff_em_segundos($_POST['data_gravada'],date("Y-m-d H:i:s"))." , 0, ".$_SESSION['s_uid'].")";
 						$execDoc = mysql_query($sqlDoc) or die ('ERRO NA TENTATIVA DE ATUALIZAR O TEMPO DE DOCUMENTAÇÃO DO CHAMADO!!<br>').$sqlDoc;
 					}	
        	               
        	               		##ROTINAS PARA GRAVAR O TEMPO DO CHAMADO EM CADA STATUS
                               		 if ($status != $row['status']) { //O status foi alterado
					##TRATANDO O STATUS ANTERIOR
					//Verifica se o status 'atual' já foi gravado na tabela 'tempo_status' , em caso positivo, atualizo o tempo, senão devo gravar ele pela primeira vez.
						$sql_ts_anterior = "select * from tempo_status where ts_ocorrencia = ".$row['numero']." and ts_status = ".$row['status']." ";
						$exec_sql = mysql_query($sql_ts_anterior);
						
						if ($exec_sql == 0) $error= " erro 1";
						
						$achou = mysql_num_rows($exec_sql);
						if ($achou >0){ //esse status já esteve setado em outro momento
							$row_ts = mysql_fetch_array($exec_sql); 
							
						// if (array_key_exists($row['sistema'],$H_horarios)){  //verifica se o código da área possui carga horária definida no arquivo config.inc.php
							// $areaT = $row['sistema']; //Recebe o valor da área de atendimento do chamado
						// } else $areaT = 1; //Carga horária default definida no arquivo config.inc.php
						
						$areaT=testaArea($areaT,$row['sistema'],$H_horarios);	
							
							$dt = new dateOpers; 
							$dt->setData1($row_ts['ts_data']);
							$dt->setData2($hoje);					
							$dt->tempo_valido($dt->data1,$dt->data2,$H_horarios[$areaT][0],$H_horarios[$areaT][1],$H_horarios[$areaT][2],$H_horarios[$areaT][3],"H");
							$segundos = $dt->diff["sValido"]; //segundos válidos
							
							$sql_upd = "update tempo_status set ts_tempo = (ts_tempo+$segundos) , ts_data ='$hoje' where ts_ocorrencia = ".$row['numero']." and 
									ts_status = ".$row['status']." ";
							$exec_upd = mysql_query($sql_upd);
							if ($exec_upd ==0) $error.= " erro 2";
							
						} else {
							$sql_ins = "insert into tempo_status (ts_ocorrencia, ts_status, ts_tempo, ts_data) values (".$row['numero'].", ".$row['status'].", 0, '$hoje' )";
							$exec_ins = mysql_query ($sql_ins); 
							if ($exec_ins == 0) $error.= " erro 3 ";
						}
						##TRATANDO O NOVO STATUS
						//verifica se o status 'novo' já está gravado na tabela 'tempo_status', se estiver eu devo atualizar a data de início. Senão estiver gravado então devo gravar pela primeira vez
						$sql_ts_novo = "select * from tempo_status where ts_ocorrencia = ".$row['numero']." and ts_status = $status ";
						$exec_sql = mysql_query($sql_ts_novo);
						if ($exec_sql == 0) $error.= " erro 4";
						
						$achou_novo = mysql_num_rows($exec_sql);
						if ($achou_novo > 0) { //status já existe na tabela tempo_status
							$sql_upd = "update tempo_status set ts_data = '$hoje' where ts_ocorrencia = ".$row['numero']." and ts_status = $status ";
							$exec_upd = mysql_query($sql_upd);
							if ($exec_upd == 0) $error.= " erro 5";
						} else {//status novo na tabela tempo_status
							$sql_ins = "insert into tempo_status (ts_ocorrencia, ts_status, ts_tempo, ts_data) values (".$row['numero'].", ".$status.", 0, '$hoje' )";
							$exec_ins = mysql_query($sql_ins);
							if ($exec_ins == 0) $error.= " erro 6 ";
						}
					}
			
			
					$aviso = "Ocorrência alterada com sucesso! ";
	
				}
                        } //fecha if erro=nao
			if ($_SESSION['s_usuario'] != ""){
				print "<script>mensagem('".$aviso."'); redirect('mostra_consulta.php?numero=".$numero."');</script>";
			} else{
				print "<script>mensagem('".$aviso."'); redirect('../../index.php');</script>";
			}
		}//fecha if rodou=sim
         ?>

</TABLE>

</FORM>
</body>

<script language="javascript">
	document.getElementById('idStatus').style.display = 'none'; 
	document.getElementById('idProblema').style.display = 'none'; 
	document.getElementById('idArea').style.display = 'none'; 
	document.getElementById('idUnidade').style.display = 'none';
	document.getElementById('idEtiqueta').style.display = 'none';
	document.getElementById('idLocal').style.display = 'none';
	document.getElementById('idOperador').style.display = 'none';
</script>

<script type="text/javascript">
<!--			
	
	function valida(){
		var ok = validaForm('idStatus','COMBO','Status',1);
		if (ok) var ok = validaForm('idProblema','COMBO','Problema',1);
		if (ok) var ok = validaForm('idArea','COMBO','Área',1);
		
		if (ok) var ok = validaForm('idEtiqueta','INTEIROFULL','Etiqueta',0);
		if (ok) var ok = validaForm('idLocal','COMBO','Local',1);
		if (ok) var ok = validaForm('idAssentamento','','Assentamento',1);
		
		return ok;
	
	}		


-->	
	
</script>

</html>
