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
	
	$diasemana = array('Domingo','Segunda-feira','Terça-feira','Quarta-feira', 'Quinta-feira','Sexta-feira','Sábado');
	
	print "<HTML>";
	print "<head><script language='JavaScript' src=\"../../includes/javascript/calendar.js\"></script></head>";
	print "<BODY bgcolor=".BODY_COLOR.">";
	
	$texto = "OcoMon - Módulo de Intranet";
	print "<TABLE class='header_centro' cellspacing='1' border='0' cellpadding='1' align='center' width='100%'>".//#5E515B
		"<TR>". 
			"<TD nowrap width='80%'><b>".$texto."</b></td>".
				// "<td width='20%' nowrap><p class='parag'><b>".TRANS(date("l")).",&nbsp;".(formatDate(date("Y/m/d H:i"), " %H:%M"))."</b>".$help."</p></TD>";
				"<td width='20%' nowrap><p class='parag'><b>".$diasemana[date('w')].",&nbsp;".date("d/m/Y H:i")."</b>".$help."</p></TD>";
		print "</TR>".
		"</TABLE>";
	print "<BR><B>Registro de Formulários Intranet</B><BR>";
	
	###### ESTE BLOCO INICIA OS HEADERS (CABEÇALHO) DO SISTEMA ######
	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new formAlterRamal($banco,$_REQUEST);
	$geraHeader->getEndHtml();
	
	#################################################
	
	###### ESTE BLOCO VERIFICA AS PERMISSÕES DO USUÁRIO
	###### E INICIALIZA AS PERMISSÕES PARA ACESSO AO BANCO DE DADOS
	
	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	
	############################################################
	
	class formAlterRamal
	{
		var $tipoForm;
		var $reitoria;
		var $centroCusto;
		var $justificativa;
		var $categoriaRamal;
		var $dataPrevistaUso;
		var $localSetor;
		var $solicitante;
		var $ramalSolicit;
		var $ramalAlter;
		var $cod;
		var $acao;	
		var $controle;
		var $botao;
		
		function formAlterRamal(&$DB,&$requests)
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
			$this->tipoForm =  "";
			$this->reitoria =  "";
			$this->centroCusto =  "";
			$this->justificativa =  "";
			$this->categoriaRamal =  "";
			$this->dataPrevistaUso =  "";
			$this->localSetor =  "";
			$this->solicitante =  "";
			$this->ramalSolicit =  "";
			$this->ramalAlter =  "";
			$this->cod = "";
			$this->acao = "";
			$this->controle =   "";
			$this->botao =      "";		
		}
		
		function setaPropriedades()
		{
			if (isset($this->REQUESTS['acao'])){$this->acao = $this->REQUESTS['acao'];}
			if (isset($this->REQUESTS['botao'])){$this->botao = $this->REQUESTS['botao'];}
			if (isset($this->REQUESTS['controle'])){$this->controle  = $this->REQUESTS['controle'];}
			if (isset($this->REQUESTS['cod'])){$this->cod = $this->REQUESTS['cod'];}				
			if (isset($this->REQUESTS['tipoForm'])){$this->tipoForm  = $this->REQUESTS['tipoForm'];}	
			if (isset($this->REQUESTS['reitoria'])){$this->reitoria = str_replace("reit","",$this->REQUESTS['reitoria']);}	
			if (isset($this->REQUESTS['categoriaRamal'])){$this->categoriaRamal = str_replace("cat","",$this->REQUESTS['categoriaRamal']);}	
			if (isset($this->REQUESTS['centroCusto'])){$this->centroCusto = str_replace("cc","",$this->REQUESTS['centroCusto']);}		
			if (isset($this->REQUESTS['solicitante'])){$this->solicitante  = $this->REQUESTS['solicitante'];}	
			if (isset($this->REQUESTS['ramalSolicit'])){$this->ramalSolicit  = $this->REQUESTS['ramalSolicit'];}	
			if (isset($this->REQUESTS['ramalAlter'])){$this->ramalAlter  = $this->REQUESTS['ramalAlter'];}	
			if (isset($this->REQUESTS['justificativa'])){$this->justificativa  = $this->REQUESTS['justificativa'];}	
			if (isset($this->REQUESTS['dataPrevistaUso'])){$this->dataPrevistaUso  = $this->REQUESTS['dataPrevistaUso'];}	
			if (isset($this->REQUESTS['localSetor'])){$this->localSetor = str_replace("local","",$this->REQUESTS['localSetor']);}	
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
				case "GERAR":
					if ($this->validaCampos() == true){
							print "<script language='javaScript'>alert('Registro salvo com sucesso!');</script>";
							$this->geraFormulario();	
							$this->enviaEmail();
							$this->limpaPropriedades();
					}else{
						print "<script>mensagem('ATENÇÃO: Você não preencheu todos os campos OBRIGATÓRIOS do formulário!!!');redirect('$PHP_SELF')</script>";
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

			print "<B>Solicitação de Alteração de Categoria de Ramal:<br><br>";
			print "<font color='red'><a onClick=\"javascript:popup_alertaIII('".FLUXO_PATH."AlterCategRamal.png')\">Clique aqui para entender o fluxo deste formulário.</a><br><br></b>";
						print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Reitoria/Diretoria: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('reitoria', 'reit'.$this->reitoria, $this->buscaReitorias(), '', "Selecione a Reitoria",  $bloqueio)."</TD>";
			print "</tr>";	
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">Solicitante: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('solicitante',$this->solicitante, 50, 50, $bloqueio)."</TD>";
			print "</tr>";	
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">Ramal do responsável: <font color=red><b>*</font></b></TD>";
			//print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramalSolicit',$this->ramalSolicit, 4, 4,  $bloqueio)."</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramalSolicit',$this->ramalSolicit, 4, 4,  $bloqueio)."</TD>";
			print "</tr>";	
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">Ramal a ser alterado: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramalAlter',$this->ramalAlter, 4, 4,  $bloqueio)."</TD>";
			print "</tr>";				
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Categoria desejada: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('categoriaRamal', 'cat'.$this->categoriaRamal, $this->buscaCategRamal(), '', "Selecione o Categoria",  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Setor: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('localSetor', 'local'.$this->localSetor, $this->buscaLocais(), '', "Selecione o Setor",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">Centro de Custo: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('centroCusto', 'cc'.$this->centroCusto, $this->buscaCentroCusto(), '', "Selecione o Centro de Custo",  $bloqueio)."</TD>";
			print "</tr>";	
			print "<TR>";
			print "<TD width='22%' align='left' bgcolor=".TD_COLOR.">Data prevista para uso: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor=".BODY_COLOR."> ".$this->forms->getDateCalendar('dataPrevistaUso', $this->dataPrevistaUso, 10)."</TD>";
			print "</TR>";	
			print "<tr>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Justificativa <font color=red><b>*</font></b></TD>";
			print "<TD width='20%' colspan='3' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getTextArea('justificativa',$this->justificativa,55,5,$bloqueio)."</TD>";
			print "</tr>";	
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gerar'></td>"
				."<input class='button' type='hidden' name='acao' value='GERAR'>";
			print "<td class='line'><input type='reset' name='reset'  class='button' value='Cancelar' onclick=\"javascript:history.back()\"></td></tr>";
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
			if ($this->reitoria == ""){
				print "<script>mensagem('O campo REITORIA, deve ser INFORMADO!!!.');</script>";
				$retorno = false;
			}
			if ($this->solicitante == ""){
				print "<script>mensagem('O campo SOLICITANTE, deve ser INFORMADO!!!.');</script>";
				$retorno = false;
			}
			if ($this->ramalSolicit == ""){
				print "<script>mensagem('O campo RAMAL do RESPONSÁVEL, deve ser INFORMADO!!!.');</script>";
				$retorno = false;
			}
			if ($this->ramalAlter == ""){
				print "<script>mensagem('O campo RAMAL A SER ALTERADO, deve ser PREENCHIDO!!!.');</script>";
				$retorno = false;
			}
			if ($this->categoriaRamal == ""){
				print "<script>mensagem('O campo CATEGORIA DO RAMAL, deve ser INFORMADO!!!.');</script>";
				$retorno = false;
			}
			if ($this->localSetor == ""){
				print "<script>mensagem('O campo LOCAL, deve ser INFORMADO!!!.');</script>";
				$retorno = false;
			}
			if ($this->centroCusto == ""){
				print "<script>mensagem('O campo CENTRO DE CUSTO, deve ser INFORMADO!!!.');</script>";
				$retorno = false;
			}
			if ($this->dataPrevistaUso == ""){
				print "<script>mensagem('O campo DATA PREVISTA PARA USO, deve ser INFORMADO!!!.');</script>";
				$retorno = false;
			}
			if ($this->justificativa == ""){
				print "<script>mensagem('O campo JUSTIFICATIVA, deve ser PREENCHIDO!!!.');</script>";
				$retorno = false;
			}
				
			return $retorno;
		}
							
		/*
		* buscaReitorias()
		* Busca as informações da Tabela Reitorias
		*/
		function buscaReitorias()
		{
			$chave = "";
			$reitoria = array();
			$sql = "SELECT DISTINCT * FROM diretorias ORDER BY diretoria_desc ";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["diretoria_desc"]);
				$chave = "reit".$linha["diretoria_id"];
				$reitoria[$chave] = $descricao;
			}
			return $reitoria;
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
			$sql = "SELECT * FROM localizacao WHERE loc_status = 1 ORDER BY local";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["local"]);
				$chave = "local".$linha["loc_id"];
				$localSetor[$chave] = $descricao;
			}
			return $localSetor;
		}
		
		/*
		* buscaNomeLocais()
		* Busca as informações da Tabela Localização
		*/
		function buscaNomeLocais()
		{
			$sql = "SELECT * FROM localizacao WHERE loc_id = ".$this->localSetor."";
			$exec = mysql_query($sql);
			$linha =  mysql_fetch_array($exec);
			$descricao  = strtoupper ($linha["local"]);
			return $descricao;
		}
		
		/*
		* buscaNomeCateg()
		* Busca as informações da Tabela Categora
		*/
		function buscaNomeCateg()
		{
			$sql = "SELECT * FROM ramal_categ WHERE cat_id = ".$this->categoriaRamal."";
			$exec = mysql_query($sql);
			$linha =  mysql_fetch_array($exec);
			$descricao  = strtoupper ($linha["cat_nome"]);
			return $descricao;
		}
		
		/*
		* enviaEmail()
		* Envia email com os dados do Formulário
		*/
		function enviaEmail()
		{
			$msg = "###########  Alteração de Categoria de Ramal  ###########\n\n";
			//$msg .= "Número: ".$nroForm." / ".$ocorrencia." \n";
			$msg .= "Soliciante: ".$this->solicitante."\n";
			$msg .= "Ramal de contato: ".$this->ramalSolicit."\n";
			$msg .= "Ramal a ser alterado: ".$this->ramalSolicit."\n";
			$msg .= "Categoria do ramal: ".$this->buscaNomeCateg()."\n";
			$msg .= "Local: ".$this->buscaNomeLocais()."\n";
			$msg .= "Justificativa: ".$this->justificativa."\n";
			$msg .= "Data prevista para uso para uso: ".$this->dataPrevistaUso."\n";
			$msg .= "##########################################\n";
			// DESENV
			$mailheaders_sender = "From: acorrea@unilasalle.edu.br";
			mail("acorrea@unilasalle.edu.br", "Alteração de Categoria de Ramal", $msg, $mailheaders_sender);
			//PRODUÇÃO
			// $mailheaders_sender = "From: redes@unilasalle.edu.br";
			// mail("redes@unilasalle.edu.br", "Alteração de Categoria de Ramal", $msg, $mailheaders_sender);
		}
		
		/*
		* buscaCentroCusto()
		* Busca as informações da Tabela CCUSTO
		*/
		function buscaCentroCusto()
		{
			$chave = "";
			$centroCusto = array();
			$sql = "SELECT *
					FROM CCUSTO
					ORDER BY descricao";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["descricao"]);
				$chave = "cc".$linha["codigo"];
				$centroCusto[$chave] = $linha['codccusto']." - ".$descricao;
			}
			return $centroCusto;
		}
		
		/*
		* buscaNomeCentroCusto()
		* Busca as informações da Tabela Centro de Custos
		*/
		function buscaNomeCentroCusto()
		{
			$sql = "SELECT * FROM CCUSTO WHERE codigo = ".$this->centroCusto."";
			$exec = mysql_query($sql);
			$linha =  mysql_fetch_array($exec);
			$descricao  = strtoupper ($linha["descricao"]);
			$centroCusto = $linha['codccusto']." - ".$descricao;
			return $centroCusto;
		}
		
		/*
		* abreChamado()
		* Abre chamado com os dados do formulário
		*/
		function abreChamado()
		{
			// $usuario = $_SESSION['s_usuario'];
			$buscaNomeCateg = $this->buscaNomeCateg();
			$solicitante = $this->solicitante;
			$ramalSolicit = $this->ramalSolicit;
			$dataSolicit = date("Y-m-d H:i:s");
			if (($this->reitoria =='1') OR ($this->reitoria =='2') OR ($this->reitoria =='3') OR ($this->reitoria =='4') OR ($this->reitoria =='5') OR ($this->reitoria =='6')
				OR ($this->reitoria =='7') OR ($this->reitoria =='8') OR ($this->reitoria =='10') OR ($this->reitoria =='11')OR ($this->reitoria =='12')){
				$instituicao = "1";
			}else{
				$instituicao = "2";
			}
			// Usuário da INTRANET
			// Desenv Ocomon
			// $operador = '428'; 
			// Produção Ocomon
			$operador = '435'; 
			$sql = "INSERT INTO ocorrencias (problema, descricao, equipamento, contato, telefone, instituicao, local, operador, data_abertura, aberto_por, status, sistema, id_atend, oco_prior) "
				."\n VALUES ('577', '".$this->justificativa." \n \n - ".$buscaNomeCateg."', '0', '".$solicitante."','".$ramalSolicit."', '".$instituicao."', '".$this->localSetor."', '".$operador."', '".$dataSolicit."' "
				."\n , '".$operador."', '57', '1', '12', '1')";
				// dump ($sql);exit;	
			$result = mysql_query($sql);	
			if (!$result) {
				//array_push($this->erro, mysql_error());				
				$retorno  = false;
			}
			$retorno = true;
			return $retorno;
		}
		
		function dataView($data) {
			$data_orig = $data;
			$separa = substr($data_orig,2,1);

			$conf_data = explode("-","$data_orig");

			$ano = $conf_data[0];
			$mes = $conf_data[1];
			$dia = $conf_data[2];

			$data = "$dia/$mes/$ano";
			return($data);
		}
	
		/*
		* geraFormulario()
		* Gera o formulário para impressão
		*/
		function geraFormulario()
		{
			$data = $this->dataView(date("Y-m-d"));
			//$nroForm = mysql_insert_id();
			$solicitante = $this->solicitante;
			$centro_custo = $this->buscaNomeCentroCusto();
			$formTipo = "FormAltRamal";
			$dataSolicit = date("Y-m-d");
			$ocorrencia = mysql_insert_id();
			$varAux = explode("/", $this->dataPrevistaUso);
			$dataPrevista = $varAux[2]."-".$varAux[1]."-".$varAux[0];		
						
			### ABRE CHAMADO NO OCOMON ###
			$this->abreChamado() ;
			$ocorrencia = mysql_insert_id();
			
			$sql = "INSERT INTO formularios (form_tipo, data_solicit,usuario, usuario_ramal, ocorrencia, centro_custo, categ_ramal, ramal_alter, data_prevista) "
				."\n VALUES ('".$formTipo."', '".$dataSolicit."', '".$this->solicitante."','".$this->ramalSolicit."', '".$ocorrencia."', '".$this->centroCusto."' "
				."\n , '".$this->categoriaRamal."', '".$this->ramalAlter."', '".$dataPrevista."')";
				// dump ($sql);exit;	
			$result = mysql_query($sql);	
			
			$nroForm = mysql_insert_id();
			$sqlForm = "UPDATE ocorrencias SET form_id = '".$nroForm."' WHERE numero = '".$ocorrencia."' ";
			// dump ($sqlForm);exit;	
			$resultForm = mysql_query($sqlForm);	
			
			print "<body>";
			print "<br><b><a href=\"javascript:window.print()\"><img src='../../includes/icons/printer1.png' style=\"vertical-align:middle;\" height='32' width='32' border='0'> "
					."\n Clique aqui para imprimir o formulário</a></b> || <b><font color=red> Este documento deverá ser entregue a Diretoria responsável pela área!</b></font>";
			print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
			print "<tr>";
			print "<td height='53' colspan='3'> <div align='center'><img src='../../includes/icons/Unilasalle.png' width='270' height='65'></div><br></td>";
			print "</tr>";
			print "<tr align='left' valign='middle'>";
			print "<td width='133' height='34'> <div align='left'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Data: ".$data." </font></strong></div></td>";
			print "<td width='404'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Solicitação de Alteração de Categoria de Ramal</font></strong></div></td>";
			print "<td width='149'><strong><font size='2' face='Arial, Helvetica, sans-serif'>No.: ".$nroForm." / ".$ocorrencia."</font></strong></td>";
			print "</tr>";
			print "<tr bgcolor='#CCCCCC'> ";
			print "<td height='18' colspan='3'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Responsável pela solicitação</font></strong></div></td>";
			print "</tr>";
			print "<tr>";
			print "<td height='21' colspan='3'>&nbsp;</td>";
			print "</tr>";
			print "<tr>";
			print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>Centro de Custo: ".$centro_custo." </font></td>";
			print "</tr>";
			print "<tr> ";
			print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>Solicitante: <b>".$solicitante."</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "
				."\n Ramal do responsável: <b>".$this->ramalSolicit."</b></font></td>";
			print "</tr>";
			print "<tr> ";
			print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>Ramal a ser alterado: ".$this->ramalAlter."</font></td>";
			print "</tr>";
			print "<tr> ";
			print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>Categoria desejada: ".$this->buscaNomeCateg()."</font></td>";
			print "</tr>";
			print "<tr> ";
			print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>Setor: ".$this->buscaNomeLocais()."</font></td>";
			print "</tr>";
			print "</table>";
			print "<table width='700' border='0' bordercolor='#000000'>";
			print "<tr>";
			print "<td height='5'>&nbsp;</td>";
			print "<td height='5'>&nbsp;</td>";
			print "</tr>";
			print "<tr bgcolor='#CCCCCC'>";
			print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Justificativa</font></strong></div></td>";
			print "</tr>";
			print "</table>";
			print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
			print "<tr valign='top'>";
			print "<td height='100'> <blockquote> <font size='2' face='Arial, Helvetica, sans-serif'><br> ".$this->justificativa." </font> </blockquote></td>";
			print "</tr>";
			print "<tr>";
			print "<td height='20'><font size='2' face='Arial, Helvetica, sans-serif'>Data prevista para uso: ".$this->dataPrevistaUso."</font></td>";
			print "</tr>";
			print "<tr>";
			print "<td height='40'><font size='2' face='Arial, Helvetica, sans-serif'>Assinatura do responsável pela área/setor:</font></td>";
			print "</tr>";
			print "</table>";
			print "<table width='700' border='0' bordercolor='#000000'>";
			print "<tr>";
			print "<td height='5'>&nbsp;</td>";
			print "<td height='5'>&nbsp;</td>";
			print "</tr>";
			print "<tr bgcolor='#CCCCCC'>";
			print "<td height='21' colspan='2'><div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Parecer da Diretoria Responsável:</font></strong></div></td>";
			print "</tr>";
			print "</table>";
			print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
			print "<tr>";
			print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'><br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) Deferido &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			(&nbsp;&nbsp;&nbsp;&nbsp;) Indeferido <br><br> Justificativa: 
				<br><br>.....................................................................................................................................................................<br><br>
				.....................................................................................................................................................................<br><br>
				.....................................................................................................................................................................<br></font></p>";
			print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
			print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>Diretoria Responsável<br><br></font></p></td>";
			print "</tr>";
			print "</table>";
			print "<table width='700' border='0' bordercolor='#000000'>";
			print "<tr>"; 
			print "<td height='5'>&nbsp;</td>";
			print "<td height='5'>&nbsp;</td>";
			print "</tr>";
			print "<tr bgcolor='#CCCCCC'>";
			print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Parecer da Diretoria Administrativa </font></strong></div></td>";
			print "</tr>";
			print "</table>";
			print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
			print "<tr>";
			print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'> <br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) Deferido &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			(&nbsp;&nbsp;&nbsp;&nbsp;) Indeferido <br><br> Justificativa: 
				<br><br>.....................................................................................................................................................................<br><br>
				.....................................................................................................................................................................<br><br>
				.....................................................................................................................................................................<br></font></p>";
			print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
			print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>Diretoria Administrativa<br><br></font></p></td>";
			print "</tr>";
			print "</table>";
			print "<table width='700' border='0' bordercolor='#000000'>";
			print "<tr> ";
			print "<td height='5'><p>&nbsp;</p></td>";
			print "</tr>";
			//print "<td height='5'><blockquote><font size='2' face='Arial, Helvetica, sans-serif'>".TRANS('TXT_OBS_RAMAL')."</font></blockquote></td>";
			print "</tr>";
			print "</table>";
			print "</body>";
			print "</body>";
		}
		
	}
?>