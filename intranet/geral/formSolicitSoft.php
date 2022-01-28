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
	$f = new formSolicitSoft($banco,$_REQUEST);
	$geraHeader->getEndHtml();
	
	#################################################
	
	###### ESTE BLOCO VERIFICA AS PERMISSÕES DO USUÁRIO
	###### E INICIALIZA AS PERMISSÕES PARA ACESSO AO BANCO DE DADOS
	
	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	
	############################################################
	
	class formSolicitSoft
	{
		var $tipoForm;
		var $reitoria;
		var $centroCusto;
		var $justificativa;
		var $dataPrevistaUso;
		var $localSetor;
		var $solicitante;
		var $ramalSolicit;
		var $fabricante;
		var $software;
		var $tipoLicenca;
		var $valorEstimado;
		var $unidade;
		var $etiqueta;
		var $cod;
		var $acao;	
		var $controle;
		var $botao;
		
		function formSolicitSoft(&$DB,&$requests)
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
			$this->dataPrevistaUso =  "";
			$this->localSetor =  "";
			$this->solicitante =  "";
			$this->ramalSolicit =  "";
			$this->fabricante =  "";
			$this->software =  "";
			$this->tipoLicenca =  "";
			$this->valorEstimado =  "";
			$this->unidade =  "";
			$this->etiqueta =  "";
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
			if (isset($this->REQUESTS['centroCusto'])){$this->centroCusto = str_replace("cc","",$this->REQUESTS['centroCusto']);}		
			if (isset($this->REQUESTS['solicitante'])){$this->solicitante  = $this->REQUESTS['solicitante'];}	
			if (isset($this->REQUESTS['ramalSolicit'])){$this->ramalSolicit  = $this->REQUESTS['ramalSolicit'];}	
			if (isset($this->REQUESTS['dataPrevistaUso'])){$this->dataPrevistaUso  = $this->REQUESTS['dataPrevistaUso'];}	
			if (isset($this->REQUESTS['localSetor'])){$this->localSetor = str_replace("local","",$this->REQUESTS['localSetor']);}	
			if (isset($this->REQUESTS['fabricante'])){$this->fabricante  = $this->REQUESTS['fabricante'];}	
			if (isset($this->REQUESTS['software'])){$this->software  = $this->REQUESTS['software'];}	
			if (isset($this->REQUESTS['tipoLicenca'])){$this->tipoLicenca = str_replace("tipo","",$this->REQUESTS['tipoLicenca']);}	
			if (isset($this->REQUESTS['valorEstimado'])){$this->valorEstimado  = $this->REQUESTS['valorEstimado'];}	
			if (isset($this->REQUESTS['unidade'])){$this->unidade = str_replace("uni","",$this->REQUESTS['unidade']);}	
			if (isset($this->REQUESTS['etiqueta'])){$this->etiqueta  = $this->REQUESTS['etiqueta'];}	
			if (isset($this->REQUESTS['justificativa'])){$this->justificativa  = $this->REQUESTS['justificativa'];}	
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

			print "<B>Solicitação de Instalação de Software:<br><br>";
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
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramalSolicit',$this->ramalSolicit, 4, 4,  $bloqueio)."</TD>";
			// print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('ramalSolicit',$this->buscaRamalUserLogado(), 4, 4,  true)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Setor: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('localSetor', 'local'.$this->localSetor, $this->buscaLocais(), '', "Selecione o Setor",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">Centro de Custo: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('centroCusto', 'cc'.$this->centroCusto, $this->buscaCentroCusto(), '', "Selecione o Centro de Custo",  $bloqueio)."</TD>";
			print "</tr>";				
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">Fabricantes: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('fabricante',$this->fabricante, 50, 50,  $bloqueio)."</TD>";
			print "</tr>";	
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">Softwares: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('software',$this->software, 50, 50,  $bloqueio)."</TD>";
			print "</tr>";				
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Tipo de Licença: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('tipoLicenca', 'tipo'.$this->tipoLicenca, $this->buscaLicencasSoft(), '', "Selecione a Licença",  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Valor estimado: <font color=red><b>*</font></b> (valor em R$)</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('valorEstimado',$this->valorEstimado, 7, 7,  $bloqueio, 'onKeydown="Formata(this,20,event,2)"')."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Unidade: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('unidade', 'uni'.$this->unidade, $this->buscaInstituicao(), '', "Selecione a Unidade",  $bloqueio)." </TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Etiqueta: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('etiqueta',$this->etiqueta, 5, 5,  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";
			print "<TD width='22%' align='left' bgcolor=".TD_COLOR.">Data prevista para uso: <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor=".BODY_COLOR."> ".$this->forms->getDateCalendar('dataPrevistaUso', $this->dataPrevistaUso, 10)."</TD>";
			print "</TR>";	
			print "<tr>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>Justificativa: <font color=red><b>*</font></b></TD>";
			print "<TD width='20%' colspan='3' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getTextArea('justificativa',$this->justificativa,55,5,$bloqueio)."</TD>";
			print "</tr>";	
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gerar'></td>"
				."<input class='button' type='hidden' name='acao' value='GERAR'>";
			print "<td class='line'><input type='reset' name='reset'  class='button' value='Cancelar' onclick=\"javascript:history.back()\"></td></tr>";
			print "</table>";
			print "</form>";

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
			$ramalSolicit = $this->ramalSolicit;
			$centro_custo = $this->buscaNomeCentroCusto();
			$valor = trim(str_replace('.','',$this->valorEstimado));
			$valor = trim(str_replace(',','.',$valor));
			$valorEstimado = number_format($valor,2, ',','.');	
			$formTipo = "FormSolicitSoft";
			$dataSolicit = date("Y-m-d");
			$ocorrencia = mysql_insert_id();
			$varAux = explode("/", $this->dataPrevistaUso);
			$dataPrevista = $varAux[2]."-".$varAux[1]."-".$varAux[0];		
			
			### ABRE CHAMADO NO OCOMON ###
			$this->abreChamado() ;
			$ocorrencia = mysql_insert_id();
			
			$sql = "INSERT INTO formularios (form_tipo, data_solicit,usuario, usuario_ramal, ocorrencia, centro_custo, fornecedor, software, tipo_licenca, inst_cod, etiqueta, valor_estimado, data_prevista) "
				."\n VALUES ('".$formTipo."', '".$dataSolicit."', '".$solicitante."','".$usuario_ramal."', '".$ocorrencia."', '".$this->centroCusto."', '".$this->fabricante."', '".$this->software."', '".$this->tipoLicenca."' "
				."\n , '".$this->unidade."','".$this->etiqueta."', '".$valor."', '".$dataPrevista."')";
				//dump ($sql);exit;	
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
			print "<td width='404'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Solicitação de Instalação de Software</font></strong></div></td>";
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
				."\n Ramal do responsável: <b>".$ramalSolicit."</b></font></td>";
			print "</tr>";
			print "<tr> ";
			print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>Fabricantes: <b>".$this->fabricante."</b> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; "
				."\n Softwares: <b>".$this->software."</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tipo de Licença: <b>".$this->retornaNomeLicencasSoft()." </b></font></td>";
			print "</tr>";

			print "<tr> ";
			print "<td height='20' colspan='3'><font size='2' face='Arial, Helvetica, sans-serif'>Valor estimado: R$ ".$valorEstimado."</font></td>";
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
			print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Setor</font></strong></div></td>";
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
			(&nbsp;&nbsp;&nbsp;&nbsp;) Indeferido <br><br> Setor: 
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
			print "<td height='21' colspan='2'> <div align='center'><strong><font size='2' face='Arial, Helvetica, sans-serif'>Parecer da T.I:</font></strong></div></td>";
			print "</tr>";
			print "</table>";
			print "<table width='700' border='1' cellpadding='0' cellspacing='0' bordercolor='#000000'>";
			print "<tr>";
			print "<td height='21'><p><font size='2' face='Arial, Helvetica, sans-serif'> <br> &nbsp(&nbsp;&nbsp;&nbsp;&nbsp;) Deferido &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
			(&nbsp;&nbsp;&nbsp;&nbsp;) Indeferido <br><br> Setor: 
				<br><br>.....................................................................................................................................................................<br><br>
				.....................................................................................................................................................................<br><br>
				.....................................................................................................................................................................<br></font></p>";
			print "<p><font size='2' face='Arial, Helvetica, sans-serif'>Data: ......../......../20.....</font></p>";
			print "<p align='center'><font size='2' face='Arial, Helvetica, sans-serif'>______________________________<br><br>Tecnologia da Informação<br><br></font></p></td>";
			print "</tr>";
			print "</table>";
			print "<table width='700' border='0' bordercolor='#000000'>";
			print "<tr> ";
			print "<td height='5'><p>&nbsp;</p></td>";
			print "</tr>";
			print "</tr>";
			print "</table>";
			print "</body>";
			print "</body>";
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
			if ($this->fabricante == ""){
				print "<script>mensagem('O campo FABRICANTE, deve ser PREENCHIDO!!!.');</script>";
				$retorno = false;
			}
			if ($this->software == ""){
				print "<script>mensagem('O campo SOFTWARE, deve ser PREENCHIDO!!!.');</script>";
				$retorno = false;
			}
			if ($this->tipoLicenca == ""){
				print "<script>mensagem('O campo TIPO DE LICENÇA, deve ser INFORMADO!!!.');</script>";
				$retorno = false;
			}
			if ($this->unidade == ""){
				print "<script>mensagem('O campo UNIDADE, deve ser INFORMADO!!!.');</script>";
				$retorno = false;
			}
			if ($this->tipoLicenca == ""){
				print "<script>mensagem('O campo ETIQUETA, deve ser INFORMADO!!!.');</script>";
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
			if ($this->valorEstimado == ""){
				print "<script>mensagem('O campo VALOR ESTIMADO, deve ser PREENCHIDO!!!.');</script>";
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
			$$chave = "";
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
		* buscaInstituicao()
		* Busca as informações da Tabela Instituicao
		*/
		function buscaInstituicao()
		{
			$chave = "";
			$unidade = array();
			$sql = "SELECT * FROM instituicao WHERE inst_cod in(1,2,15)";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["inst_nome"]);
				$chave = "uni".$linha["inst_cod"];
				$unidade[$chave] = $descricao;
			}
			return $unidade;
		}
		
		/*
		* buscaLicencasSoft()
		* Busca as informações da Tabela Licenças de Softwares
		*/
		function buscaLicencasSoft()
		{
			$chave = "";
			$licenca = array();
			$sql = "SELECT * FROM licencas ORDER BY lic_desc ";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["lic_desc"]);
				$chave = "tipo".$linha["lic_cod"];
				$licenca[$chave] = $descricao;
			}
			return $licenca;
		}
		
		/*
		* retornaNomeLicencasSoft()
		* Busca as informações da Tabela Licenças de Softwares
		*/
		function retornaNomeLicencasSoft()
		{
			$sql = "SELECT * FROM licencas WHERE lic_cod = '".$this->tipoLicenca."' ";
			$exec = mysql_query($sql);
			$linha =  mysql_fetch_array($exec);
			$descricao  = strtoupper ($linha["lic_desc"]);
			return $descricao;
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
		* enviaEmail()
		* Envia email com os dados do Formulário
		*/
		function enviaEmail()
		{
			$msg = "###########  Solicitação de Instalação de Software  ###########\n\n";
			//$msg .= "Número: ".$nroForm." / ".$ocorrencia." \n";
			$msg .= "Soliciante: ".$this->solicitante."\n";
			$msg .= "Ramal de contato: ".$this->ramalSolicit."\n";
			$msg .= "Local: ".$this->buscaNomeLocais()."\n";
			$msg .= "Justificativa: ".$this->justificativa."\n";
			$msg .= "Software: ".$this->software."\n";
			$msg .= "Licença: ".$this->retornaNomeLicencasSoft()."\n";
			$msg .= "Data prevista para uso: ".$this->dataPrevistaUso."\n";
			$msg .= "##############################################\n";
			//DESENV
			$mailheaders_sender = "From: acorrea@unilasalle.edu.br";
			mail("acorrea@unilasalle.edu.br", "Solicitação de Instalação de Software ", $msg, $mailheaders_sender);
			//PRODUÇÃO
			// $mailheaders_sender = "From: suporte@unilasalle.edu.br";
			// mail("suporte@unilasalle.edu.br", "Solicitação de Instalação de Software ", $msg, $mailheaders_sender);
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
			$solicitante = $this->solicitante;
			$ramalSolic = $this->ramalSolicit;
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
				."\n VALUES ('344', '".$this->justificativa."', '".$this->etiqueta."', '".$solicitante."','".$ramalSolic."', '".$instituicao."', '".$this->localSetor."', '".$operador."', '".$dataSolicit."' "
				."\n , '".$operador."', '57','20', '10', '1')";
				//dump ($sql);
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
<script type="text/javascript">
<!--
	function barra(objeto){
		if (objeto.value.length == 2 || objeto.value.length == 5 ){
			objeto.value = objeto.value+"/";
		}
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