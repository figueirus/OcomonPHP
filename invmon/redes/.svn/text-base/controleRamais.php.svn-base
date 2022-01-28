<?php	
	session_start();
	
	##### NESTE BLOCO É INFORMADO OS INCLUDES (REQUIRE) QUE 
	##### SERÃO UTILIZADOS NESTE SCRIPT
	require_once "../../classes/session.php";
	require_once "../../classes/package_bd.class";
	require_once "../../classes/html.class";
	require_once "../../classes/getElement.class";
	require_once "../../classes/forms.class";
	require_once "../../includes/include_geral.inc.php";
	require_once "../../includes/include_geral_II.inc.php";
	###################################
	
	###### INICÍO DA PROGRAMAÇÃO ######
	//TITULO DO SCRIPT
	
	$_SESSION['s_page_admin'] = $_SERVER['PHP_SELF'];
	$cab = new headers;
	print "<HTML>";
	print "<head><script language='JavaScript' src=\"../../includes/javascript/calendar.js\"></script></head>";
	print "<BODY bgcolor=".BODY_COLOR.">";
	
	$texto = TRANS('MENU_TTL_MOD_INV');
	print "<TABLE class='header_centro' cellspacing='1' border='0' cellpadding='1' align='center' width='100%'>".//#5E515B
		"<TR>". 
			"<TD nowrap width='80%'><b>".$texto."</b></td>".
				"<td width='20%' nowrap><p class='parag'><b>".TRANS(date("l")).",&nbsp;".(formatDate(date("Y/m/d H:i"), " %H:%M"))."</b>".$help."</p></TD>";
		print "</TR>".
		"</TABLE>";
	print "<BR><B>".TRANS('TTL_CONTROL_RAMAIS')."</B><BR>";
	
	###### ESTE BLOCO INICIA OS HEADERS (CABEÇALHO) DO SISTEMA ######
	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new controleRamais($banco,$_REQUEST);
	$geraHeader->getEndHtml();
	
	#################################################
	
	###### ESTE BLOCO VERIFICA AS PERMISSÕES DO USUÁRIO
	###### E INICIALIZA AS PERMISSÕES PARA ACESSO AO BANCO DE DADOS
	
	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	
	############################################################

	class controleRamais
	{
	###### DECLARÇÃO DE VARIAVÍES ######
		var $ramal_id;
		var $inst_cod;
		var $loc_id;
		var $ramal_cc;
		var $cat_id;
		var $situacao_id;
		var $diretoria_id;
		var $ramal;
		var $novaJanela;
		var $ramal_tipo;
		var $data;
		var $obs;
		var $cod;
		var $acao;	
		var $opcao;	
		var $controle;
		var $botao;
		
		function controleRamais(&$DB,&$requests)
		{
			$this->REQUESTS = $requests;
			$this->conn = &$DB;
			$this->QRY = new genericQuery($this->conn);			
			$this->forms = new getElement;
			$this->limpaPropriedades();
			$this->setaPropriedades();
			$this->controle();
		}
		
		function limpaPropriedades()
		{
			$this->ramal_id =  "";
			$this->inst_cod =  "";
			$this->loc_id =  "";
			$this->ramal_cc =  "";
			$this->cat_id =  "";
			$this->situacao_id =  "";
			$this->diretoria_id =  "";
			$this->ramal =  "";
			$this->novaJanela =  "";
			$this->ramal_tipo =  "";
			$this->data =  "";
			$this->obs =  "";
			$this->cod = "";
			$this->acao =  "";
			$this->opcao =  "";
			$this->controle =   "";
			$this->botao =      "";		
		}
		
		function setaPropriedades()
		{
			if (isset($this->REQUESTS['acao'])){$this->acao = $this->REQUESTS['acao'];}
			if (isset($this->REQUESTS['opcao'])){$this->opcao = $this->REQUESTS['opcao'];}
			if (isset($this->REQUESTS['botao'])){$this->botao = $this->REQUESTS['botao'];}
			if (isset($this->REQUESTS['cod'])){$this->cod = $this->REQUESTS['cod'];}	
			if (isset($this->REQUESTS['controle'])){$this->controle  = $this->REQUESTS['controle'];}
			if (isset($this->REQUESTS['ramal_id'])){$this->ramal_id  = $this->REQUESTS['ramal_id'];}
			if (isset($this->REQUESTS['inst_cod'])){$this->inst_cod = str_replace("inst","",$this->REQUESTS['inst_cod']);}				
			if (isset($this->REQUESTS['ramal_tipo'])){$this->ramal_tipo = str_replace("rt","",$this->REQUESTS['ramal_tipo']);}				
			if (isset($this->REQUESTS['situacao_id'])){$this->situacao_id = str_replace("sit","",$this->REQUESTS['situacao_id']);}				
			if (isset($this->REQUESTS['diretoria_id'])){$this->diretoria_id = str_replace("dir","",$this->REQUESTS['diretoria_id']);}				
			if (isset($this->REQUESTS['loc_id'])){$this->loc_id = str_replace("loc","",$this->REQUESTS['loc_id']);}				
			if (isset($this->REQUESTS['cat_id'])){$this->cat_id = str_replace("cat","",$this->REQUESTS['cat_id']);}				
			if (isset($this->REQUESTS['ramal'])){$this->ramal  = $this->REQUESTS['ramal'];}	
			if (isset($this->REQUESTS['novaJanela'])){$this->novaJanela  = $this->REQUESTS['novaJanela'];}	
			if (isset($this->REQUESTS['ramal_cc'])){$this->ramal_cc  = $this->REQUESTS['ramal_cc'];}
			if (isset($this->REQUESTS['data'])){$this->data  = $this->REQUESTS['data'];}	
			if (isset($this->REQUESTS['obs'])){$this->obs  = $this->REQUESTS['obs'];}	
		}
		
		
		/*
		*controle()
		*controle():controla as interações do programa
		*@return void
		*/
		function controle()
		{			
			GLOBAL $PHP_SELF;
			$PHP_SELF = $_SERVER["SCRIPT_NAME"];				
			switch($this->acao)
			{	
				case "GRAVAR":
					// if ($this->validaCampos() === True){
						if ($this->armazenaDados() == false){
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro não foi efetuado.');redirect('$PHP_SELF')</script>";
						}else{
							print "<script language='javaScript'>alert('Registro salvo com sucesso!');redirect('$PHP_SELF')</script>";
						}
					// }	
					$this->limpaPropriedades();	
				break;
				case "ALT_CAD":
					// if ($this->validaCampos() === True){
						if ($this->alteraDados() == false){
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro não foi efetuado.');redirect('$PHP_SELF')</script>";
						}else{
							print "<script language='javaScript'>alert('Registro salvo com sucesso!');redirect('$PHP_SELF')</script>";
						}
					// }	
					$this->limpaPropriedades();
				case "INC_CAD":
					
					$this->formularioCadastro();
				break;
				case "VIS_RAMAIS":
					$this->visualizacaoRamais();
					// $this->limpaPropriedades();
				break;
				case "PESQ_ESP":
					$this->consultaEspecial();
					// $this->limpaPropriedades();
				break;
				case "ALTER":
					$this->alteraCadastro();
				
				break;
				default:
				$this->listagemPrincipal();					
				break;
			}		
		}
		
		/*
		* listagemPrincipal()
		* Lista as informações da Tabela Tipo de Atendimento
		*/
		function listagemPrincipal()
		{
			print "<td><a href='".$_SERVER['PHP_SELF']."?acao=INC_CAD'>Incluir Cadastro</a></td> | ";
			print "<td><a href='".$_SERVER['PHP_SELF']."?acao=PESQ_ESP'>Consulta Personalizada</a></td><br>";
			$resultado = $this->buscaRamalControle();
			if (mysql_numrows($resultado) == 0){
				echo mensagem(TRANS('MSG_NOT_RAMAIS'));
			}else{
				$linhas = mysql_numrows($resultado);
				print "<table class=estat60 align=center>";
				print "<tr><td align='center'><b>Resumo geral do controle de ramais da Instituição.</b></td></tr>";
				print "<td>";
				print "<fieldset><legend>".TRANS("quadro")."</legend>";
				//print "<BR><b>".TRANS('THERE_IS_ARE')." <font color='red'>".$linhas."</font> ".TRANS('TXT_CAD_RAMAL')."</b><br>";
				print "<BR><b>".TRANS('THERE_IS_ARE')." <font color='red'>".$linhas."</font> ".TRANS('TXT_CAD_RAMAL')."</b>"
				." <a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=VIS_RAMAIS&botao=TODOS')\"><img height='16' width='16' src='" .ICONS_PATH."find.png' title='Visualizar regsitros'></a><br>";
				
				$execAnalogico = $this->buscaRamalAnalogicos();
				$linhasAnalogica = mysql_numrows($execAnalogico);
				print "<BR><b>".TRANS('THERE_IS_ARE')." <b><font color='red'>".$linhasAnalogica."</font> ramal(is) <font color=blue>Analógico(s)</font> cadastrado(s) no sistema. <b> "
					//." <a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=VIS_ANALOGICO&cod=".$row['ramal_id']."')\"><img height='16' width='16' src='" .ICONS_PATH."find.png' title='Visualizar regsitros'><br>";	
					." <a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=VIS_RAMAIS&botao=ANALOGICOS')\"><img height='16' width='16' src='" .ICONS_PATH."find.png' title='Visualizar regsitros'></a><br>";	

				$execDigital = $this->buscaRamalDigitais();
				$linhasDigital = mysql_numrows($execDigital);
				print "<BR><b>".TRANS('THERE_IS_ARE')." <b><font color='red'>".$linhasDigital."</font> ramal(is) <font color=blue>Digitai(s)</font> cadastrado(s) no sistema.<b>"
					." <a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=VIS_RAMAIS&botao=DIGITAIS')\"><img height='16' width='16' src='" .ICONS_PATH."find.png' title='Visualizar regsitros'></a><br>";		

				$execOper = $this->buscaRamalOper();
				$linhasOper = mysql_numrows($execOper);
				print "<BR><b>".TRANS('THERE_IS_ARE')." <b><font color='red'>".$linhasOper."</font> ramal(is) <font color=blue>Operador(es)</font> cadastrado(s) no sistema.<b>"
					." <a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=VIS_RAMAIS&botao=OPER')\"><img height='16' width='16' src='" .ICONS_PATH."find.png' title='Visualizar regsitros'></a><br>";		
					
				$execIP = $this->buscaRamalIp();
				$linhasIP = mysql_numrows($execIP);
				print "<BR><b>".TRANS('THERE_IS_ARE')." <b><font color='red'>".$linhasIP."</font> ramal(is) <font color=blue>IP(s)</font> cadastrado(s) no sistema.<b>"
					." <a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=VIS_RAMAIS&botao=IP')\"><img height='16' width='16' src='" .ICONS_PATH."find.png' title='Visualizar regsitros'></a><br>";		
				
				print "</TABLE>";
			}
		}
		
		/*
		* consultaEspecial()
		* Formulário de Consulta Especial
		*/
		function consultaEspecial()
		{
			// print "<table class=estat60 align=center>";
			print "<BR><BR><B><center>:::Consulta especial dos ramais da Instituição:::</center></B><BR><BR>";
			print "<FORM action='".$_SERVER['PHP_SELF']."' method='post' name='form1' onSubmit=\"return valida()\" >";
			print "<TABLE border='0' align='center' cellspacing='2'  bgcolor=".BODY_COLOR." >";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TTL_RAMAL').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramal', $tis->ramal, 4, 4,  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='40%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_TIPO_RAMAL').": </TD>";
			print "<TD width='60%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('ramal_tipo', 'rt'.$this->ramal_tipo, $this->buscaRamalTipos(), '', "------------- Todos -------------",  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_CATEG_RAMAL').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('cat_id', 'cat'.$this->cat_id, $this->buscaCategRamal(), '', "------------- Todas -------------",  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TTL_SIT_RAMAL').": </TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('situacao_id', 'sit'.$this->situacao_id, $this->buscaRamalSituacao(), '', "------------- Todas -------------",  $bloqueio)."</TD>";
			print "</tr>";			
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_DIR').": </TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('diretoria_id', 'dir'.$this->diretoria_id, $this->buscaDiretoria(), '', "------------- Todas -------------",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_UNIT').": </TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('inst_cod', 'inst'.$this->inst_cod, $this->buscaUnidades(), '', "------------- Todas -------------",  $bloqueio)."</TD>";
			print "</tr>";		
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('FIELD_SECTOR').": </TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('loc_id', 'loc'.$this->loc_id, $this->buscaLocais(), '', "------------- Todas -------------",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">Opicional: </TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCheck('novaJanela', $this->novaJanela, '', false, $bloqueio)." Tela para impressão</TD>";
			// print "</tr>";	
			print "</tr>";	
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gerar'></td>"
				."<input class='button' type='hidden' name='acao' value='VIS_RAMAIS'>";
			print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";			
			print "</TABLE>";
		}
		
		/*
		* formularioCadastro()
		* Formulário de cadastro
		*/
		function formularioCadastro()
		{		
			GLOBAL $PHP_SELF;
			GLOBAl $SISCONF;
			$bloqueio = false;
			
			print "<B>".TRANS('SUBTIT_CAD_RAMAL').":<br><br>";
			print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_TIPO_RAMAL')."<font color=red><b>*</font></b>:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('ramal_tipo', 'rt'.$this->ramal_tipo, $this->buscaRamalTipos(), '', "Selecione o tipo de ramal",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TTL_RAMAL').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramal', $tis->ramal, 4, 4,  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_CATEG_RAMAL').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('cat_id', 'cat'.$this->cat_id, $this->buscaCategRamal(), '', "Selecione o categoria",  $bloqueio)."</TD>";
			print "</tr>";			
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TTL_SIT_RAMAL').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('situacao_id', 'sit'.$this->situacao_id, $this->buscaRamalSituacao(), '', "Selecione a situação",  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_DIR').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('diretoria_id', 'dir'.$this->diretoria_id, $this->buscaDiretoria(), '', "Selecione a diretoria",  $bloqueio)."</TD>";
			print "</tr>";	
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_UNIT')."<font color=red><b>*</font></b>:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('inst_cod', 'inst'.$this->inst_cod, $this->buscaUnidades(), '', "Selecione a unidade",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('FIELD_SECTOR')."<font color=red><b>*</font></b>:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('loc_id', 'loc'.$this->loc_id, $this->buscaLocais(), '', "Selecione o setor",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TTL_CENTER_CUST').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramal_cc', $tis->ramal, 6, 6,  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_OBS_RAMAL')."</TD>";
			print "<TD width='20%' colspan='3' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getTextArea('obs',$this->obs,55,5,$bloqueio)."</TD>";
			print "</tr>";	
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gravar'></td>"
				."<input class='button' type='hidden' name='acao' value='GRAVAR'>";
			print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
			print "</table>";
			print "</form>";
			
		}
		
		/*
		* visualizacaoRamais()
		* Formulário para alterar de cadastro
		*/
		function visualizacaoRamais()
		{		
			$resultado = $this->ListaRamais();
			// dump ($resultado);
			if (mysql_numrows($resultado) == 0){
				echo mensagem(TRANS('MSG_NOT_RAMAIS'));
			}else{
				$linhas = mysql_numrows($resultado);

				// print "<br><b><a href=\"javascript:history.back()\"><img src='../../includes/icons/back_relatorio.png' style=\"{vertical-align:middle;}\" height='32' width='32' border='0'></a>   ";
				// print "<a href=\"javascript:window.print()\"><img src='../../includes/icons/printer1.png' style=\"{vertical-align:middle;}\" height='32' width='32' border='0'><br></a> ";
				
				print "<td class='line'><input type='reset' name='reset'  class='button' value='VOLTAR' onclick=\"javascript:history.back()\"> ";
				
				if ($this->novaJanela == 'checked') {
					print "<input type='reset' name='reset'  class='button' value='IMPRIMIR' onclick=\"javascript:window.print()\"></td></tr> <br>";
				}
				
				print "<br><td class='line'>";
				print "<b>Visualização de <b><font color='red'>".$linhas."</font></b> ramal(is) deste tipo cadastrado(s) no sistema.</b><br>";
				print "<TABLE border='0' cellpadding='5' cellspacing='0'  width='100%'>";
				//print "<TR class='header'><td class='line'>Linha</TD>";
				print "<TR class='header'><td class='line'>Ramal</TD><td class='line'>Diretoria</TD><td class='line'>Tipo de ramal</TD><td class='line'>Unidade</TD><td class='line'>Setor</TD> "
						."\n <td class='line'>Categoria do ramal</TD><td class='line'><b>Situação</b><td class='line'><b>Observação</b> ";
						if ($this->novaJanela != 'checked') {
							print "<td class='line'><b>Alterar</b></TD>";
						}
						
				$j=0;
				while ($row=mysql_fetch_array($resultado)){
					if ($j % 2){
						$trClass = "lin_par";
					}else{
						$trClass = "lin_impar";
					}
					$j++;
					if (trim($row['obs'] ) == ''){
						$obs = "-----------------------------";
					}else{
						$obs = $row['obs'];
					}
					print "<tr class=".$trClass." id='linhax".$j."' onMouseOver=\"destaca('linhax".$j."','".$_SESSION['s_colorDestaca']."');\" onMouseOut=\"libera('linhax".$j."');\"  onMouseDown=\"marca('linhax".$j."','".$_SESSION['s_colorMarca']."');\">";
					// print "<td class='line'>".$j."</TD>";
					print "<td class='line'>".$row['ramal']."</TD>";
					print "<td class='line'>".$row['diretoria_desc']."</TD>";
					print "<td class='line'>".$row['ramalTipo_desc']."</TD>";
					print "<td class='line'>".$row['inst_nome']."</TD>";
					print "<td class='line'>".$row['local']."</TD>";
					print "<td class='line'>".$row['cat_nome']."</TD>";
					print "<td class='line'>".$row['situacao_desc']."</TD>";
					print "<td class='line'><center>".$obs."</center></TD>";
					if ($this->novaJanela != 'checked') {
						// print "<td class='line'><a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=ALTER&cod=".$row['ramal_id']."')\"><img height='16' width='16' src='".ICONS_PATH."edit.png' title='".TRANS('HNT_EDIT')."'></a></TD>";
						print "<td class='line'><a onClick=\"javascript:popup_alertaIII('alteraRamais.php?popup=true&cod=".$row['ramal_id']."')\"><img height='16' width='16' src='".ICONS_PATH."edit.png' title='".TRANS('HNT_EDIT')."'></a></TD>";
					}
					print "</TR>";
				}
				print "</TABLE>";
			}
					
		}
		/*
		* alteraCadastro()
		* Formulário para alterar de cadastro
		*/
		function alteraCadastro()
		{		
			$exec = $this->retornaDadosAlter();
			$rowAlter = mysql_fetch_array($exec);
			$bloqueio = false;
			
			// print $_GET['cod'];
			
			print "<B>Alteração de Dados do Ramal:<br><br>";
			print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<TD >".$this->forms->getHidden( 'cod',$_GET['cod'])."</TD>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_TIPO_RAMAL')."<font color=red><b>*</font></b>:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('ramal_tipo', 'rt'.$rowAlter['ramal_tipo'], $this->buscaRamalTipos(), '', "Selecione o tipo de ramal",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TTL_RAMAL').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramal', $rowAlter['ramal'], 4, 4,  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_CATEG_RAMAL').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('cat_id', 'cat'.$rowAlter['cat_id'], $this->buscaCategRamal(), '', "Selecione o categoria",  $bloqueio)."</TD>";
			print "</tr>";	
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TTL_SIT_RAMAL').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('situacao_id', 'sit'.$rowAlter['situacao_id'], $this->buscaRamalSituacao(), '', "Selecione a situação",  $bloqueio)."</TD>";
			print "</tr>";			
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_DIR').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('diretoria_id', 'dir'.$rowAlter['diretoria_id'], $this->buscaDiretoria(), '', "Selecione a diretoria",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('OCO_FIELD_UNIT')."<font color=red><b>*</font></b>:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('inst_cod', 'inst'.$rowAlter['inst_cod'], $this->buscaUnidades(), '', "Selecione a unidade",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('FIELD_SECTOR')."<font color=red><b>*</font></b>:</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('loc_id', 'loc'.$rowAlter['loc_id'], $this->buscaLocais(), '', "Selecione o setor",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TTL_CENTER_CUST').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramal_cc', $rowAlter['ramal_cc'], 6, 6,  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_OBS_RAMAL')."</TD>";
			print "<TD width='20%' colspan='3' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getTextArea('obs',$rowAlter['obs'],55,5,$bloqueio)."</TD>";
			print "</tr>";	
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gravar'></td>";
				print $this->forms->getHidden('acao', 'ALT_CAD');
			print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
			print "</table>";
			print "</form>";

			
		}
		
		/*
		*validaCampos()
		*
		*função para a validação dos campos
		*/
		function validaCampos()
		{
			$retorno = true;
			#Valida se todos os campos foram preenchidos
			if ($this->desc_atend == ""){
				print "<script>mensagem('O campo DESCRIÇÃO, deve ser PREENCHIDO!!!.');redirect('$PHP_SELF?acao=INC_CAD')</script>";
				$retorno = false;
			}
			if ($this->flag_atend == ""){
				print "<script>mensagem('O campo REQUER AVALIAÇÃO, deve ser INFORMADO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}
				
			return $retorno;
		}

		/*
		*retornaDadosAlter
		*função para retornar os dados para a alteração dos registros
		*@return void
		*/
		function retornaDadosAlter()
		{
			$qry = "SELECT * FROM ramal_controles WHERE ramal_id = ".$_GET['cod']."";
			$resultado = mysql_query($qry);
			return $resultado;
		}
		
		/*
		* ListaRamais()
		* Busca as informações da Tabela Ramal Controles
		*/
		function ListaRamais()
		{
			$sql = "SELECT rc.ramal_id, rc.diretoria_id, rc.ramal, loc.local, rt.ramalTipo_desc, rc.obs, inst.inst_nome, rcat.cat_nome, rsit.situacao_desc, dir.diretoria_desc
					FROM ramal_controles as rc

					left join instituicao as inst on inst.inst_cod = rc.inst_cod
					left join ramal_categ as rcat on rcat.cat_id = rc.cat_id
					left join ramal_situacao as rsit on rsit.situacao_id = rc.situacao_id
					left join diretorias as dir on dir.diretoria_id = rc.diretoria_id
					left join ramal_tipo as rt on rt.ramalTipo_id = rc.ramal_tipo
					left join localizacao as loc on loc.loc_id = rc.loc_id
					WHERE rc.status = 1";
						if ($this->botao == "ANALOGICOS"){
							$sql.= " \n AND rc.ramal_tipo = 1";
						}
						if($this->botao == "DIGITAIS"){
							$sql.= "\n AND rc.ramal_tipo = 2";
						}
						if($this->botao == "OPER"){
							$sql.= "\n AND rc.ramal_tipo = 3";
						}
						if($this->botao == "IP"){
							$sql.= "\n AND rc.ramal_tipo = 4";
						}
						if($this->botao == "TODOS"){
							$sql.= "\n AND rc.ramal_tipo in (1,2,3,4)";
						}
						
						if(!empty($this->ramal_tipo) and  ($this->ramal_tipo != -1)){
							$sql.= "\n AND rc.ramal_tipo = ".$this->ramal_tipo." ";
						}
						if(!empty($this->ramal) and  ($this->ramal != -1)){
							$sql.= "\n AND rc.ramal = ".$this->ramal." ";
						}
						if(!empty($this->cat_id) and  ($this->cat_id != -1)){
							$sql.= "\n AND rc.cat_id = ".$this->cat_id." ";
						} 
						if(!empty($this->situacao_id) and  ($this->situacao_id != -1)){
							$sql.= "\n AND rc.situacao_id = ".$this->situacao_id." ";
						}
						if(!empty($this->diretoria_id) and  ($this->diretoria_id != -1)){
							$sql.= "\n AND rc.diretoria_id = ".$this->diretoria_id." ";
						}
						if(!empty($this->inst_cod) and  ($this->inst_cod != -1)){
							$sql.= "\n AND rc.inst_cod = ".$this->inst_cod." ";
						}
						if(!empty($this->loc_id) and  ($this->loc_id != -1)){
							$sql.= "\n AND rc.loc_id = ".$this->loc_id." ";
						}
					// $sql.= "\n ORDER BY situacao_desc";
					$sql.= "\n ORDER BY local";
					
					// dump ($sql);exit;
			$resultado = mysql_query($sql);
			return $resultado;
		}
		
		/*
		* RamaisDigitais()
		* Busca as informações da Tabela Ramal Controles
		*/
		function RamaisDigitais()
		{
			$sql = "SELECT rc.ramal_id, rc.diretoria_id, rc.ramal, loc.local, rt.ramalTipo_desc, rc.obs, inst.inst_nome, rcat.cat_nome, rsit.situacao_desc
					FROM ramal_controles as rc, instituicao as inst, ramal_categ as rcat, ramal_situacao as rsit, ramal_tipo as rt, 
							localizacao as loc, diretorias as dir
					WHERE rc.ramal_tipo = 2
					AND rc.ramal_tipo = rt.ramalTipo_id
					AND rc.inst_cod = inst.inst_cod
					AND rc.cat_id = rcat.cat_id
					AND rc.situacao_id = rsit.situacao_id
					AND rc.ldiretoria_id= dir.diretoria_id
					AND rc.loc_id = loc.loc_id
					ORDER BY rc.ramal";
			$resultado = mysql_query($sql);
			return $resultado;
		}
		
		/*
		* buscaRamalSituacao()
		* Busca as informações da Tabela Ramal Situação
		*/
		function buscaRamalSituacao()
		{
			$chave = "";
			$situacao_id = array();
			$sql = "SELECT * FROM ramal_situacao";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["situacao_desc"]);
				$chave = "sit".$linha["situacao_id"];
				$situacao_id[$chave] = $descricao;
			}
			return $situacao_id;
		}
		/*
		* buscaDiretoria()
		* Busca as informações da Tabela Diretorias
		*/
		function buscaDiretoria()
		{
			$chave = "";
			$diretoria_id = array();
			$sql = "SELECT * FROM diretorias ORDER BY diretoria_desc";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["diretoria_desc"]);
				$chave = "dir".$linha["diretoria_id"];
				$diretoria_id[$chave] = $descricao;
			}
			return $diretoria_id;
		}
		
		/*
		* buscaRamalTipos()
		* Busca as informações da Tabela Ramal Tipo
		*/
		function buscaRamalTipos()
		{
			$chave = "";
			$ramalTipo = array();
			$sql = "SELECT * FROM ramal_tipo";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["ramalTipo_desc"]);
				$chave = "rt".$linha["ramalTipo_id"];
				$ramalTipo[$chave] = $descricao;
			}
			return $ramalTipo;
		}
		
		/*
		* buscaCategRamal()
		* Busca as informações das categorias de ramal
		*/
		function buscaCategRamal()
		{
			$chave = "";
			$categRamal = array();
			$sql = "SELECT * FROM ramal_categ ORDER BY cat_id";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["cat_nome"]);
				$chave = "cat".$linha["cat_id"];
				$categRamal[$chave] = $descricao;
			}
			return $categRamal;
		}
		
		/*
		* buscaLocais()
		* Busca as informações da Tabela Localização
		*/
		function buscaLocais()
		{
			$chave = "";
			$localSetor = array();
			$sql = "SELECT * FROM localizacao WHERE loc_status = '1' ORDER BY local";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["local"]);
				$chave = "loc".$linha["loc_id"];
				$localSetor[$chave] = $descricao;
			}
			return $localSetor;
		}
		
		/*
		* buscaUnidades()
		* Busca as informações da Tabela Instituição
		*/
		function buscaUnidades()
		{
			$chave = "";
			$unidade = array();
			$sql = "SELECT * FROM instituicao WHERE inst_cod IN (40,1,9,2,15)";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["inst_nome"]);
				$chave = "inst".$linha["inst_cod"];
				$unidade[$chave] = $descricao;
			}
			return $unidade;
		}
				
		/*
		* buscaRamalControle()
		* Busca as informações da Tabela Ramal Controle
		*/
		function buscaRamalControle()
		{
			$sql = " SELECT * FROM ramal_controles";
			$resultado = mysql_query($sql);
			return $resultado;
		}
		
		/*
		* buscaRamalAnalogicos()
		* Busca as informações da Tabela Ramal Controle
		*/
		function buscaRamalAnalogicos()
		{
			$sql = " SELECT * FROM ramal_controles WHERE ramal_tipo = 1";
			$resultado = mysql_query($sql);
			return $resultado;
		}
		
		/*
		* buscaRamalDigitais()
		* Busca as informações da Tabela Ramal Controle
		*/
		function buscaRamalDigitais()
		{
			$sql = " SELECT * FROM ramal_controles WHERE ramal_tipo = 2";
			$resultado = mysql_query($sql);
			return $resultado;
		}
		
		/*
		* buscaRamalOper()
		* Busca as informações da Tabela Ramal Controle
		*/
		function buscaRamalOper()		
		{
			$sql = " SELECT * FROM ramal_controles WHERE ramal_tipo = 3";
			$resultado = mysql_query($sql);
			return $resultado;
		}
		/*
		* buscaRamalIP()
		* Busca as informações da Tabela Ramal Controle
		*/
		function buscaRamalIP()		
		{
			$sql = " SELECT * FROM ramal_controles WHERE ramal_tipo = 4";
			$resultado = mysql_query($sql);
			return $resultado;
		}

		/**
		* armazenaDados
		* Função para armazenar dados
		*
		*/
		function armazenaDados()
		{
			$sql = "INSERT INTO ramal_controles (ramal, ramal_tipo, diretoria_id, ramal_cc, inst_cod, loc_id, cat_id, situacao_id, data, obs, status) "
				."\n VALUES ('".$this->ramal."', '".$this->ramal_tipo."', '".$this-> diretoria_id."', '".$this->ramal_cc."', '".$this->inst_cod."', '".$this->loc_id."', '".$this->situacao_id."', '".date("Y-m-d ")."', '".$this->obs."', '1')";
				// dump ($sql);exit;	
			$result = mysql_query($sql);	
			if (!$result) {
				//array_push($this->erro, mysql_error());				
				$retorno  = false;
			}
			
			$retorno = true;
				
			return $retorno;
		}

		/**
		* alteraDados
		* Função para alterar dados
		*
		*/
		function alteraDados()
		{
			$sql = "UPDATE  ramal_controles SET ramal = '".$this->ramal."',  diretoria_id = '".$this-> diretoria_id."', ramal_tipo = '".$this->ramal_tipo."', ramal_cc = '".$this->ramal_cc."', inst_cod = '".$this->inst_cod."'  "
				."\n , loc_id = '".$this->loc_id."', cat_id = '".$this->cat_id."', situacao_id = '".$this->situacao_id."', data = '".date("Y-m-d ")."',  obs = '".$this->obs."' "
				."\n WHERE ramal_id  = '".$this->cod."' ";
				// dump ($sql);exit;	
			$result = mysql_query($sql);	
			if (!$result) {
				//array_push($this->erro, mysql_error());				
				$retorno  = false;
			}
			$retorno = true;
			return $retorno;
		}		
    }
?>