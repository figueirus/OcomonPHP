<?php	
	//session_start();
	//TESTE
	
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
	
	$texto = TRANS('MENU_TTL_MOD_AVAL');
	print "<TABLE class='header_centro' cellspacing='1' border='0' cellpadding='1' align='center' width='100%'>".//#5E515B
		"<TR>". 
			"<TD nowrap width='50%'><b>".$texto."</b></td>".
				"<td width='20%' nowrap><p class='parag'><b>".TRANS(date("l")).",&nbsp;".(formatDate(date("Y/m/d H:i"), " %H:%M"))."</b>".$help."</p></TD>";
		print "</TR>".
		"</TABLE>";
	print "<BR><B>".TRANS('TLT_AVALIACAO')."</B><BR>";
	print"<BR>";
	
	###### ESTE BLOCO INICIA OS HEADERS (CABEÇALHO) DO SISTEMA ######
	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new incluirAval($banco,$_REQUEST);
	$geraHeader->getEndHtml();
	#################################################
	
	###### ESTE BLOCO VERIFICA AS PERMISSÕES DO USUÁRIO
	###### E INICIALIZA AS PERMISSÕES PARA ACESSO AO BANCO DE DADOS
	
	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	
	############################################################

	class incluirAval
	{
		var $nota_aval;
		var $tipo_atend;
		var $obs;
		var $data;
		var $comentario;
		var $tecnico;
		var $descricao;
		var $num_oco;
		var $nro_ocorrencia;
		var $acao;	
		var $controle;
		var $botao;
		
		function incluirAval(&$DB,&$requests)
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
			$this->nota_aval =  "";
			$this->tipo_atend =  "";
			$this->obs =  "";
			$this->data =  "";
			$this->comentario =  "";
			$this->tecnico =  "";
			$this->descricao =  "";
			$this->num_oco =  "";
			$this->nro_ocorrencia =  "";
			$this->acao =       "";
			$this->controle =   "";
			$this->botao =      "";		
		}
		
		function setaPropriedades()
		{
			if (isset($this->REQUESTS['acao'])){$this->acao = $this->REQUESTS['acao'];}
			if (isset($this->REQUESTS['botao'])){$this->botao = $this->REQUESTS['botao'];}
			if (isset($this->REQUESTS['controle'])){$this->controle  = $this->REQUESTS['controle'];}		
			if (isset($this->REQUESTS['num_oco'])){$this->num_oco  = $this->REQUESTS['num_oco'];}
			if (isset($this->REQUESTS['nro_ocorrencia'])){$this->nro_ocorrencia  = $this->REQUESTS['nro_ocorrencia'];}
			if (isset($this->REQUESTS['nota_aval'])){$this->nota_aval = str_replace("nota","",$this->REQUESTS['nota_aval']);}	
			if (isset($this->REQUESTS['tipo_atend'])){$this->tipo_atend = str_replace("tipo","",$this->REQUESTS['tipo_atend']);}	
			if (isset($this->REQUESTS['descricao'])){$this->descricao  = $this->REQUESTS['descricao'];}
			if (isset($this->REQUESTS['obs'])){$this->obs  = $this->REQUESTS['obs'];}
			if (isset($this->REQUESTS['data'])){$this->data  = $this->REQUESTS['data'];}
			if (isset($this->REQUESTS['comentario'])){$this->comentario  = $this->REQUESTS['comentario'];}
			if (isset($this->REQUESTS['tecnico'])){$this->tecnico  = $this->REQUESTS['tecnico'];}	
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
					if ($this->armazenaDados() == false){
						print "<script>mensagem('Erro ao incluir o registro! Este cadastro não foi efetuado.');redirect('$PHP_SELF')</script>";
					}else{
						print "<script>mensagem('Registro salvo com sucesso!');window.self.close();</script>";
					}	
				break;
				default:
				//print $this-> pesqAvalExist();
				if ($this-> pesqAvalExist() > 0){
					
					print "<script >mensagem('Já exsite uma AVALIAÇÃO para essa OCORRÊNCIA'); window.self.close();</script>";
					

				}else{
					$this->formularioCadastro();					
				}
				break;
			}		
		}

		/**
		* armazenaDados
		* Função para armazenar dados
		*
		*/
		function armazenaDados()
		{
			$this->tecnico = $_SESSION['s_usuario'];
			//print $this->num_oco;
			$dataBanco = date("Y-m-d H:i:s");
			$sql = "INSERT INTO avaliacao_oco (nota_aval_id,tipo_atend_id,aval_obs,data_aval,aval_comentario,tecnico,numero) "
				."\n VALUES ('".$this->nota_aval."','".$this->descricao."','".$this->obs."','".$dataBanco."' "
				."\n ,'".$this->comentario."', '".$this->tecnico."','".$this->nro_ocorrencia."')";
				//dump ($sql);exit;	
			$result = mysql_query($sql);	
			if (!$result) {
				//array_push($this->erro, mysql_error());				
				$retorno  = false;
			}
			
			$retorno = true;
				
			return $retorno;
		}
		
		/*
		* buscaNotaAval
		* Função para buscar as notas da avaliação
		*
		*/
		function buscaNotaAval()
		{
			$chave = "";
			$nota = array();
			$sql = "SELECT * FROM nota_aval";
			$commit = mysql_query($sql);
			while ($linha =  mysql_fetch_array($commit)){
				$descricao  = strtoupper ($linha["nota_aval"]);
				$chave = "nota".$linha["nota_aval_id"];
				$nota[$chave] = $descricao;
			}
			return $nota;
		}
		
		/*
		* pesqAvalExist
		* Função para buscar as notas da avaliação
		*
		*/
		function pesqAvalExist()
		{
			$sql = "SELECT * FROM avaliacao_oco WHERE numero = '".$_GET['cod']."'";
			$exec = mysql_query($sql);
			$achou = mysql_num_rows($exec);
			
			return $achou;
		}
		
		/*
		* buscaTipoAtendimento
		* Função para buscar os tipos de atendimento
		*
		*/
		function buscaTipoAtendimento()
		{
			$chave = "";
			$nota = array();
			$sql = "SELECT * FROM tipo_atend";
			$commit = mysql_query($sql);
			while ($linha =  mysql_fetch_array($commit)){
				$desc_atend  = strtoupper ($linha["desc_atend"]);
				$chave = "tipo".$linha["id_atend"];
				$nota[$chave] = $desc_atend;
			}
			return $nota;
		}

		function formularioCadastro()
		{		
			GLOBAL $PHP_SELF;
			GLOBAl $SISCONF;
			$bloqueio = false;
			print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<TR>";
				
			$this->tecnico = $_SESSION['s_usuario'];
			$this->num_oco = $_GET['cod'];
			print "<TD width='100%' align='left' bgcolor='".TD_COLOR."'>".TRANS('OCO_USUARIO').":</TD>";
			print "<TD width='30%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('tecnico', $this->tecnico , 50, 25,  true)."</TD>";
			print "<TD width='100%' align='left' bgcolor='".TD_COLOR."'>".TRANS('OCO_NUM_OCOR').":</TD>";
			print "<TD width='30%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('num_oco', $_GET['cod'] , 50, 25,  true)."</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getHidden('nro_ocorrencia', $_GET['cod'])."</TD>";
	
			print "</TR>";
			print "<TR>";
			print "<TD width='100%' align='left' bgcolor='".TD_COLOR."'>".TRANS('OCO_NOTA_AVAL').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('nota_aval', 'nota'.$this->nota_aval, $this->buscaNotaAval(), "", "Selecione a nota da avaliação",  $bloqueio)."</TD>";
			print "<TD width='100%' align='left' bgcolor='".TD_COLOR."'>".TRANS('FIELD_TYPE_ATEND').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('tipo_atend', 'tipo'.$this->tipo_atend, $this->buscaTipoAtendimento(), "", "Selecione o tipo de atendimento",  $bloqueio)."</TD>";
			print "</TD>";
			print "<TR>";
			print "<TD width='100%' align='left' bgcolor='".TD_COLOR."'>".TRANS('OCO_DATA').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('data_fechamento', formatDate(date("Y-m-d H:i:s")) , 50, 25,  true)."</TD>";
			print "</TR>";
			print "</TR>";
			
			print "<BR>";
			print "<TR>";
			print "<TD width='19%' align='left' bgcolor='".TD_COLOR."'>".TRANS('OCO_COMENTARIOS').":</TD>";
			print "<TD width='20%' colspan='3' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getTextArea('comentario',$this->comentario,65,5,$bloqueio)."</TD>";
			print"</TR>";		
			print "<TR>";
			print "<TD width='19%' align='left' bgcolor='".TD_COLOR."'>".TRANS('OCO_OBS_TEC').":</TD>";
			print "<TD width='20%' colspan='3' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getTextArea('obs',$this->obs,65,5,$bloqueio)."</TD>";
			print"</TR>";		
			print "<TD align='left' width='20%' bgcolor='".BODY_COLOR."'><input type='submit' class='button' value='Cadastrar' name='submit'>";
			print $this->forms->getHidden('acao', 'GRAVAR');
			
			print "</TABLE>";
			print "</form>";
			
		}
		
    }
	
	
?>