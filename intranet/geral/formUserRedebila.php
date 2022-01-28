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
	require_once "../../classes/funcoes.php";
	###################################
	
	##### INÍCIO CABEÇALHO DO SISTEMA #####
	print "<link rel='stylesheet' href='../../includes/css/calendar.css.php' media='screen'></LINK>";
	$_SESSION['s_page_admin'] = $_SERVER['PHP_SELF'];
	$cab = new headers;
	
	print "<HTML>";
	print "<head><script language='JavaScript' src=\"../../includes/javascript/calendar.js\"></script></head>";
	print "<BODY bgcolor=".BODY_COLOR.">";
	
	$texto = TRANS('MENU_TTL_MOD_INTRA');
	print "<TABLE class='header_centro' cellspacing='1' border='0' cellpadding='1' align='center' width='100%'>".//#5E515B
		"<TR>". 
			"<TD nowrap width='80%'><b>".$texto."</b></td>".
				"<td width='20%' nowrap><p class='parag'><b>".TRANS(date("l")).",&nbsp;".(formatDate(date("Y/m/d H:i"), " %H:%M"))."</b>".$help."</p></TD>";
		print "</TR>".
		"</TABLE>";
	print "<BR><B>".TRANS('TTL_REDEBILA')."</B><BR>";
	
	###### ESTE BLOCO INICIA OS HEADERS (CABEÇALHO) DO SISTEMA ######
	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new formUserRedebila($banco,$_REQUEST);
	$geraHeader->getEndHtml();
	
	#################################################
	
	###### ESTE BLOCO VERIFICA AS PERMISSÕES DO USUÁRIO
	###### E INICIALIZA AS PERMISSÕES PARA ACESSO AO BANCO DE DADOS
	
	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	
	############################################################
	
	class formUserRedebila
	{
		var $instituicao;
		var $cargo;
		var $horario;
		var $dataPrevistaUso;
		var $skype;
		var $solicitante;
		var $colaborador;
		var $ramalSolicit;
		var $flagCoord;
		var $flagOco;
		var $senha;
		var $emailInstitucional;
		var $modAquisicao;
		var $modCatalogacao;
		var $modUsuarios;
		var $modEmprestimos;
		var $modConsulta;
		var $modRelatorios;
		var $modColetaDados;
		var $modMalote;
		var $acao;	
		var $servico;	
		var $controle;
		var $botao;
		
		function formUserRedebila(&$DB,&$requests)
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
			
			$this->instituicao =  "";
			$this->cargo =  "";
			$this->horario =  "";
			$this->flagCoord =  "";
			$this->flagOco =  "";
			$this->dataPrevistaUso =  "";
			$this->skype =  "";
			$this->solicitante =  "";
			$this->ramalSolicit =  "";
			$this->colaborador =  "";
			$this->senha =  "";
			$this->emailInstitucional =  "";
			$this->modAquisicao =  "";
			$this->modCatalogacao =  "";
			$this->modUsuarios =  "";
			$this->modEmprestimos =  "";
			$this->modConsulta =  "";
			$this->modRelatorios =  "";
			$this->modColetaDados =  "";
			$this->modMalote =  "";
			$this->servico = "";
			$this->acao = "";
			$this->controle =   "";
			$this->botao =      "";		
		}
		
		function setaPropriedades()
		{
			if (isset($this->REQUESTS['acao'])){$this->acao = $this->REQUESTS['acao'];}
			if (isset($this->REQUESTS['botao'])){$this->botao = $this->REQUESTS['botao'];}
			if (isset($this->REQUESTS['controle'])){$this->controle  = $this->REQUESTS['controle'];}
			if (isset($this->REQUESTS['servico'])){$this->servico = $this->REQUESTS['servico'];}				
			if (isset($this->REQUESTS['tipoForm'])){$this->tipoForm  = $this->REQUESTS['tipoForm'];}	
			if (isset($this->REQUESTS['instituicao'])){$this->instituicao = str_replace("inst","",$this->REQUESTS['instituicao']);}	
			if (isset($this->REQUESTS['cargo'])){$this->cargo = str_replace("cc","",$this->REQUESTS['cargo']);}		
			if (isset($this->REQUESTS['solicitante'])){$this->solicitante  = $this->REQUESTS['solicitante'];}	
			if (isset($this->REQUESTS['colaborador'])){$this->colaborador  = $this->REQUESTS['colaborador'];}	
			if (isset($this->REQUESTS['ramalSolicit'])){$this->ramalSolicit  = $this->REQUESTS['ramalSolicit'];}	
			if (isset($this->REQUESTS['flagCoord'])){$this->flagCoord  = $this->REQUESTS['flagCoord'];}	
			if (isset($this->REQUESTS['flagOco'])){$this->flagOco  = $this->REQUESTS['flagOco'];}	
			if (isset($this->REQUESTS['dataPrevistaUso'])){$this->dataPrevistaUso  = $this->REQUESTS['dataPrevistaUso'];}	
			if (isset($this->REQUESTS['skype'])){$this->skype = str_replace("local","",$this->REQUESTS['skype']);}	
			if (isset($this->REQUESTS['senha'])){$this->senha  = $this->REQUESTS['senha'];}	
			if (isset($this->REQUESTS['emailInstitucional'])){$this->emailInstitucional  = $this->REQUESTS['emailInstitucional'];}	
			if (isset($this->REQUESTS['modAquisicao'])){$this->modAquisicao  = $this->REQUESTS['modAquisicao'];}	
			if (isset($this->REQUESTS['modCatalogacao'])){$this->modCatalogacao = str_replace("tipo","",$this->REQUESTS['modCatalogacao']);}	
			if (isset($this->REQUESTS['modUsuarios'])){$this->modUsuarios = str_replace("uni","",$this->REQUESTS['modUsuarios']);}	
			if (isset($this->REQUESTS['modConsulta'])){$this->modConsulta  = $this->REQUESTS['modConsulta'];}	
			if (isset($this->REQUESTS['modRelatorios'])){$this->modRelatorios  = $this->REQUESTS['modRelatorios'];}	
			if (isset($this->REQUESTS['modColetaDados'])){$this->modColetaDados  = $this->REQUESTS['modColetaDados'];}	
			if (isset($this->REQUESTS['modMalote'])){$this->modMalote  = $this->REQUESTS['modMalote'];}	
			if (isset($this->REQUESTS['modEmprestimos'])){$this->modEmprestimos  = $this->REQUESTS['modEmprestimos'];}	
			if (isset($this->REQUESTS['horario'])){$this->horario  = $this->REQUESTS['horario'];}	
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
				case "SALVAR":
						if ($this->abreChamado() == false){
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro não foi efetuado.');redirect('$PHP_SELF')</script>";
						}else{
							print "<script language='javaScript'>alert('Registro salvo com sucesso!');redirect('abertura.php')</script>";
							$this->enviaEmail();
							$this->limpaPropriedades();
						}			
						
						
				break;
				default:
				$this->formPrincipal();					
				break;
			}		
		}
		
		/*
		* listagemPrincipal()
		* Lista as informações da Tabela Tipo de Atendimento
		*/
		function formPrincipal()
		{
			GLOBAL $PHP_SELF;
			GLOBAl $SISCONF;
			$bloqueio = false;
			#CADASTRO DE USUÁRIO
			if ($_GET['servico'] == "cadastrar"){
				print "<B>Solicitação de cadastro de usuário:<br><br>";
				print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
				print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
				print "<tr>";
				print " ".$this->forms->getHidden( 'servico',$_GET['servico'])." ";
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_SOLICITANTE').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('solicitante',$this->buscaNomeUserLogado(), 50, 50, true)."</TD>";
				print "</tr>";	
				print "<tr>";
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_FORM_RAMAL_SOLICIT').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramalSolicit',$this->buscaRamalUserLogado(), 4, 4,  true)."</TD>";
				print "</tr>";
				print "<TR>";
				print "<TD width='22%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_DATA_PREV').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor=".BODY_COLOR."> ".$this->forms->getDateCalendar('dataPrevistaUso', $this->dataPrevistaUso, 10)."</TD>";
				print "</TR>";	
				print "<TR>";	
				print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('FIELD_INSTITUTION').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('instituicao', 'inst'.$this->instituicao, $this->buscaInstituicao(), '', "Selecione a instituição",  $bloqueio)." </TD>";
				print "</tr>";
				print "<tr>";
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_COLABORADOR').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('colaborador',$this->colaborador, 50, 50,  $bloqueio)."</TD>";
				print "</tr>";
				print "<tr>";	
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_COORD_SETOR')."? <font color=red><b>*</TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'> ".$this->forms->getRadio('flagCoord','sim','', false, $bloqueio)." Sim"
				."\n ".$this->forms->getRadio('flagCoord','não','', false, $bloqueio)." Não</TD>";
				print "</tr>";	
				print "<tr>";	
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_PER_OCO')."? <font color=red><b>*</TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'> ".$this->forms->getRadio('flagOco','sim','', false, $bloqueio)." Sim"
				."\n ".$this->forms->getRadio('flagOco','não','', false, $bloqueio)." Não</TD>";
				print "</tr>";
				print "<tr>";
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_EMAIL_INST').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('emailInstitucional',$this->emailInstitucional, 50, 50,  $bloqueio)."</TD>";
				print "</tr>";
				print "<tr>";
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('MNS_SENHA').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getTextPsw('senha',$this->senha, 8, 8,  $bloqueio)."</TD>";
				print "</tr>";
				#### MÓDULOS DO PERGAMUM
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">Módulos: <font color=red><b>*</TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'> ".$this->forms->getCheck('modAquisicao','Aquisição','', false, false)." Aquisição "
					."\n ".$this->forms->getCheck('modCatalogacao','Catalogação','', false, '')." Catalogação \n ".$this->forms->getCheck('modUsuarios','Usuários','', false, false)." Usuários <br>"
					."\n ".$this->forms->getCheck('modColetaDados','Coleta de Dados','', false, false)." Coleta de Dados \n ".$this->forms->getCheck('modMalote','Malote','', false, false)." Malote "
					."\n ".$this->forms->getCheck('modConsulta','Consulta','', false, true)." Consulta <br> ".$this->forms->getCheck('modRelatorios','Relatorios','', false, false)." Relatórios "
					."\n ".$this->forms->getCheck('modEmprestimos','Empréstimo','', false, true)." Empréstimo </TD>";
				print "</tr>";
				print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gerar'></td>"
					."<input class='button' type='hidden' name='acao' value='SALVAR'>";
				print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
				print "</table>";
				print "</form>";
			}			
			#DESLIGAMENTO DE USUÁRIO
			if ($_GET['servico'] == "desligar"){
				print "<B>Solicitação de desligamento de usuário:<br><br>";
				print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
				print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
				print "<tr>";
				print " ".$this->forms->getHidden( 'servico',$_GET['servico'])." ";
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_SOLICITANTE').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('solicitante',$this->buscaNomeUserLogado(), 50, 50, true)."</TD>";
				print "</tr>";	
				print "<tr>";
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_FORM_RAMAL_SOLICIT').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramalSolicit',$this->buscaRamalUserLogado(), 4, 4,  true)."</TD>";
				print "</tr>";
				print "<TR>";
				print "<TD width='22%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_DATA_DESL').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor=".BODY_COLOR."> ".$this->forms->getDateCalendar('dataPrevistaUso', $this->dataPrevistaUso, 10)."</TD>";
				print "</TR>";	
				print "<TR>";	
				print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('FIELD_INSTITUTION').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('instituicao', 'inst'.$this->instituicao, $this->buscaInstituicao(), '', "Selecione a instituição",  $bloqueio)." </TD>";
				print "</tr>";
				print "<tr>";
				print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_COLABORADOR').": <font color=red><b>*</font></b></TD>";
				print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('colaborador',$this->colaborador, 50, 50,  $bloqueio)."</TD>";
				print "</tr>";
				print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gerar'></td>"
					."<input class='button' type='hidden' name='acao' value='SALVAR'>";
				print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
				print "</table>";
				print "</form>";
			}			
		}
		
		/*
		* abreChamado()
		* Abre chamado com os dados do formulário
		*/
		function abreChamado()
		{
			if ($this->servico == "desligar"){
				$usuario = $_SESSION['s_usuario'];
				$solicitante = $this->buscaNomeUserLogado();
				$ramalSolic = $this->buscaRamalUserLogado();
				$funcionario = strtoupper($this->colaborador);
				$dataSolicit = date("Y-m-d H:i:s");
				//print $this->instituicao;
				
				$sql = "INSERT INTO ocorrencias (problema, descricao, equipamento, contato, telefone, instituicao, local, operador, data_abertura, aberto_por, status, sistema, id_atend, oco_prior) "
					."\n VALUES ('572', 'Desligamento de usuário da Instituição: ".$funcionario."', '0', '".$solicitante."','".$ramalSolic."', '".$this->instituicao."', '335', '".$_SESSION['s_uid']."', '".$dataSolicit."' "
					."\n , '".$_SESSION['s_uid']."', '1','23', '13', '1')";
					//dump ($sql);exit;
				$result = mysql_query($sql);	
				if (!$result) {
					//array_push($this->erro, mysql_error());				
					$retorno  = false;
				}
				$retorno = true;
			}	
			
			if ($this->servico == "cadastrar"){
				$usuario = $_SESSION['s_usuario'];
				$solicitante = $this->buscaNomeUserLogado();
				$ramalSolic = $this->buscaRamalUserLogado();
				$funcionario = strtoupper($this->colaborador);
				$dataSolicit = date("Y-m-d H:i:s");
				
				$sql = "INSERT INTO ocorrencias (problema, descricao, equipamento, contato, telefone, instituicao, local, operador, data_abertura, aberto_por, status, sistema, id_atend, oco_prior) "
					."\n VALUES ('573', 'Cadastro de usuário: ".$funcionario." <br> Módulos: ".$this->modAquisicao." ".$this->modCatalogacao." ".$this->modUsuarios." ".$this->modColetaDados."  "
					."\n  ".$this->modMalote." ".$this->modConsulta." ".$this->modRelatorios." ".$this->modEmprestimos." <br> Coord. setor: ".$this->flagCoord." <br> Permissão Ocomon: ".$this->flagOco."' "
					."\n , '0', '".$solicitante."', '".$ramalSolic."', '".$this->instituicao."', '335', '".$_SESSION['s_uid']."', '".$dataSolicit."' "
					."\n , '".$_SESSION['s_uid']."', '1','23', '13', '1')";
					//dump ($sql);exit;
				$result = mysql_query($sql);	
				if (!$result) {
					//array_push($this->erro, mysql_error());				
					$retorno  = false;
				}
				$retorno = true;
			}
			
			return $retorno;
		}
		
		/*
		* enviaEmail()
		* Envia email com os dados do Formulário
		*/
		function enviaEmail()
		{
			$ocorrencia = mysql_insert_id();
			if($this-servico == "desligar"){
				$msg = "###########  Desligamento de usuário REDEBILA  ###########\n\n";
				$msg .= "Chamado: ".$ocorrencia." \n";
				$msg .= "Soliciante: ".$this->buscaNomeUserLogado()."\n";
				$msg .= "Ramal de contato: ".$this->buscaRamalUserLogado()."\n";
				//$msg .= "Local: ".$this->buscaNomeLocais()."\n";
				$msg .= "Descrição: Desligamento de usuário na Instituição: ".$this->colaborador." \n";
				$msg .= "Data do desligamento: ".$this->dataPrevistaUso."\n";
				$msg .= "##############################################\n";

				$mailheaders_sender = "From: redebila@unilasalle.edu.br \r\n";
				$mailheaders_sender .= "Cc: suporte@unilasalle.edu.br \r\n";
				mail("redebila@unilasalle.edu.br", "Desligamento de usuário - REDEBILA ", $msg, $mailheaders_sender);
			}
			if ($this->servico == "cadastrar"){
				$msg = "###########  Cadastro de usuário REDEBILA  ###########\n\n";
				$msg .= "Chamado: ".$ocorrencia." \n";
				$msg .= "Soliciante: ".$this->buscaNomeUserLogado()."\n";
				$msg .= "Ramal de contato: ".$this->buscaRamalUserLogado()."\n";
				$msg .= "Módulos: ".$this->modAquisicao.", ".$this->modCatalogacao.", ".$this->modUsuarios.",".$this->modColetaDados.", "
						." ".$this->modMalote.", ".$this->modConsulta.", ".$this->modRelatorios.",".$this->modEmprestimos." \n";
				$msg .= "Descrição: Cadastro de usuário: ".$this->colaborador." \n";
				$msg .= "Email Institucional: ".$this->emailInstitucional." \n";
				$msg .= "Senha: ".$this->senha." \n";
				$msg .= "Coord. Setor: ".$this->flagCoord." \n";
				$msg .= "Acesso ao Ocomon: ".$this->flagOco." \n";
				$msg .= "Data de utilização: ".$this->dataPrevistaUso."\n";
				$msg .= "##############################################\n";

				$mailheaders_sender = "From: redebila@unilasalle.edu.br \r\n";
				$mailheaders_sender .= "Cc: suporte@unilasalle.edu.br \r\n";
				mail("redebila@unilasalle.edu.br", "Cadastro de Novo Usuário - REDEBILA ", $msg, $mailheaders_sender);
			}
		}
		/*
		* buscaInstituicao()
		* Busca as informações da Tabela Instituição
		*/
		function buscaInstituicao()
		{
			if (($_SESSION['s_nivel'] == '1') OR ($_SESSION['s_nivel'] == '2')) {
				$chave = "";
				$instituicao = array();
				$sql = "SELECT inst_nome, inst_cod 
						FROM instituicao
						WHERE inst_status = 1
						AND inst_cod IN (1,3,11,12,13,14,16,17,18,19,20,25,23,26,27,28,29,30,31,32,33,34,35,36,37,40,41)
						ORDER BY inst_nome";
				$exec = mysql_query($sql);
				while ($linha =  mysql_fetch_array($exec)){
					$descricao  = strtoupper ($linha["inst_nome"]);
					$chave = "inst".$linha["inst_cod"];
					$instituicao[$chave] = $descricao;
				}
				return $instituicao;
			}else{
				$chave = "";
				$instituicao = array();
				$sql = "SELECT inst.*, vinc.*
					FROM instituicao inst, usuarioXinstituicao vinc
					WHERE inst.inst_cod = vinc.inst_cod
					AND inst_status = 1 
					AND vinc.user_id = ".$_SESSION['s_uid']."
					ORDER BY inst_nome";
				$exec = mysql_query($sql);
				while ($linha =  mysql_fetch_array($exec)){
					$descricao  = strtoupper ($linha["inst_nome"]);
					$chave = "inst".$linha["inst_cod"];
					$instituicao[$chave] = $descricao;
				}
				return $instituicao;
			}
			
		}
		
		/*
		* buscaRamalUserLogado()
		* Busca as informações do usuário
		*/
		function buscaRamalUserLogado()
		{
			$sql = "SELECT * FROM usuarios WHERE user_id = ".$_SESSION['s_uid']."";
			$exec = mysql_query($sql);
			$linha =  mysql_fetch_array($exec);
			$descricao  = strtoupper ($linha["fone"]);
			return $descricao;
		}
		
			
		/*
		* buscaNomeUserLogado()
		* Busca as informações do usuário
		*/
		function buscaNomeUserLogado()
		{
			$sql = "SELECT * FROM usuarios WHERE user_id = ".$_SESSION['s_uid']."";
			$exec = mysql_query($sql);
			$linha =  mysql_fetch_array($exec);
			$descricao  = strtoupper ($linha["nome"]);
			return $descricao;
		}
		
	}
?>