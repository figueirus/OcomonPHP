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
				
				case "ALT_CAD":
					// if ($this->validaCampos() === True){
						if ($this->alteraDados() == false){
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro não foi efetuado.');redirect('$PHP_SELF')</script>";
						}else{
							print "<script language='javaScript'>alert('Registro salvo com sucesso!');window.close();</script>";
						}
					// }	
					// $this->limpaPropriedades();

				case "ALTER":
					$this->alteraCadastro();
				
				break;
				default:
				$this->alteraCadastro();				
				break;
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
			// print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
			print "</table>";
			print "</form>";

			
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