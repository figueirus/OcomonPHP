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
	require_once "../../includes/queries/queries.php";
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
	print "<BR><B>".TRANS('TTL_MIGRA_TAG')."</B><BR>";
	
	###### ESTE BLOCO INICIA OS HEADERS (CABEÇALHO) DO SISTEMA ######
	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new migracaoEtiqueta($banco,$_REQUEST);
	$geraHeader->getEndHtml();
	
	#################################################
	
	###### ESTE BLOCO VERIFICA AS PERMISSÕES DO USUÁRIO
	###### E INICIALIZA AS PERMISSÕES PARA ACESSO AO BANCO DE DADOS
	
	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	
	############################################################

	
	
	class migracaoEtiqueta
	{
		var $compInvOriginal;
		var $compInvAlterada;
		var $compInstOriginal;
		var $compInstAlterada;
		var $cod;
		var $acao;	
		var $controle;
		var $botao;
		
		function migracaoEtiqueta(&$DB,&$requests)
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
			$this->compInvOriginal =  "";
			$this->compInvAlterada =  "";
			$this->compInstOriginal =  "";
			$this->compInstAlterada =  "";
			$this->cod 	= 	"";
			$this->acao =       "";
			$this->controle =   "";
			$this->botao =      "";		
		}
		
		function setaPropriedades()
		{
			if (isset($this->REQUESTS['acao'])){$this->acao = $this->REQUESTS['acao'];}
			if (isset($this->REQUESTS['botao'])){$this->botao = $this->REQUESTS['botao'];}
			if (isset($this->REQUESTS['controle'])){$this->controle  = $this->REQUESTS['controle'];}		
			if (isset($this->REQUESTS['compInvOriginal'])){$this->compInvOriginal  = $this->REQUESTS['compInvOriginal'];}	
			if (isset($this->REQUESTS['compInvAlterada'])){$this->compInvAlterada  = $this->REQUESTS['compInvAlterada'];}	
			if (isset($this->REQUESTS['compInstOriginal'])){$this->compInstOriginal = str_replace("instOri","",$this->REQUESTS['compInstOriginal']);}	
			if (isset($this->REQUESTS['compInstAlterada'])){$this->compInstAlterada = str_replace("instAlter","",$this->REQUESTS['compInstAlterada']);}	
			if (isset($this->REQUESTS['cod'])){$this->cod = $this->REQUESTS['cod'];}	
			
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
					if ($this->validaCampos() === True){
						if ($this->alteraDados() == false){
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro não foi efetuado.');redirect('$PHP_SELF')</script>";
						}else{
							// print "<script language='javaScript'>alert('Registro salvo com sucesso!');redirect('$PHP_SELF')</script>";
							print "<script language='javaScript'>alert('Dados atualizados com sucesso nas tabelas: EQUIPAMENTOS, HISTÓRICO e OCORRÊNCIAS!');</script>";
						}
					}	
					// $this->limpaPropriedades();	
					$this->mostraEquipAlterado();
					break;
				
				default:
				$this->formularioCadastro();					
				break;
			}		
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
						
			print "<B>".TRANS('SUBTIT_MIGRA_TAG').":<br><br>";
			
			// print "<form name='incluir' method='post' action='mostraEquipMigrado.php' onSubmit='return valida()'>";
			print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_MIGRA_INST_ORI').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('compInstOriginal', 'instOri'.$this->compInstOriginal, $this->buscaUnidadesOriginal(), '', "Selecione a unidade",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_MIGRA_TAG_ORI').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('compInvOriginal', $this->compInvOriginal, 5, 5,  $bloqueio)."</TD>";
			print "</tr>";
			print "<TR>";	
			print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'>".TRANS('TXT_MIGRA_INST_ALT').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getCombo('compInstAlterada', 'instAlter'.$this->compInstAlterada, $this->buscaUnidadesAlterada(), '', "Selecione a unidade",  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_MIGRA_TAG_ALT').": <font color=red><b>*</font></b></TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('compInvAlterada', $this->compInvAlterada, 5, 5,  $bloqueio)."</TD>";
			print "</tr>";
						
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gravar'></td>"
				."<input class='button' type='hidden' name='acao' value='GRAVAR'>";
				// print $this->forms->getHidden('cod', 'bosta');
			//print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
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
			if ($this->compInvOriginal == ""){
				print "<script>mensagem('O campo ETIQUETA ATUAL, deve ser INFORMADO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}if ($this->compInstOriginal == ""){
				print "<script>mensagem('O campo UNIDADE ATUAL, deve ser INFORMADO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}if ($this->compInstAlterada == ""){
				print "<script>mensagem('O campo UNIDADE DESEJADA, deve ser INFORMADO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}if ($this->compInvAlterada == ""){
				print "<script>mensagem('O campo ETIQUETA DESEJADA, deve ser INFORMADO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}
					
			return $retorno;
		}
		
		/*
		* buscaUnidadesOriginal()
		* Busca as informações da Tabela Instituição Original
		*/
		function buscaUnidadesOriginal()
		{
			$chave = "";
			$inst_cod = array();
			$sql = "SELECT * FROM instituicao WHERE inst_cod IN (1,2,9,15,39)
					AND inst_status = 1
					ORDER BY inst_nome";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["inst_nome"]);
				$chave = "instOri".$linha["inst_cod"];
				$inst_cod[$chave] = $descricao;
			}
			return $inst_cod;
		}
		
		/*
		* buscaUnidadesAlterada()
		* Busca as informações da Tabela Instituição Alterada
		*/
		function buscaUnidadesAlterada()
		{
			$chave = "";
			$inst_cod = array();
			$sql = "SELECT * FROM instituicao WHERE inst_cod IN (1,2,9,15,39)
					AND inst_status = 1
					ORDER BY inst_nome";
			$exec = mysql_query($sql);
			while ($linha =  mysql_fetch_array($exec)){
				$descricao  = strtoupper ($linha["inst_nome"]);
				$chave = "instAlter".$linha["inst_cod"];
				$inst_cod[$chave] = $descricao;
			}
			return $inst_cod;
		}

		/**
		* alteraDados
		* Função para alterar dados
		*
		*/
		function alteraDados()
		{
			//Atualiza a etiqueta e a unidade na tabela EQUIPAMENTOS
			$sql = "UPDATE  equipamentos SET comp_inv = '".$this->compInvAlterada."',   comp_inst = '".$this->compInstAlterada."' "
				."\n WHERE comp_inv = '".$this->compInvOriginal."' "
				."\n AND comp_inst = '".$this->compInstOriginal."'";
				// dump ($sql);
				// exit;	
			
			//Atualiza a etiqueta e a unidade na tabela HISTORICO
			$sqlHist = "UPDATE  historico SET hist_inv = '".$this->compInvAlterada."',   hist_inst = '".$this->compInstAlterada."' "
				."\n WHERE hist_inv = '".$this->compInvOriginal."' "
				."\n AND hist_inst = '".$this->compInstOriginal."'";
				// dump ($sqlHist);
				// exit;	
			
			//Atualiza a etiqueta e a unidade na tabela OCORRÊNCIAS
			$sqlOcorrencias = "UPDATE  ocorrencias SET equipamento = '".$this->compInvAlterada."',   instituicao = '".$this->compInstAlterada."' "
				."\n WHERE equipamento = '".$this->compInvOriginal."' "
				."\n AND instituicao = '".$this->compInstOriginal."'";
				// dump ($sqlOcorrencias);
				// exit;	
			
			//Executa os comandos SQL
			$result = mysql_query($sql);	
			$resultHist = mysql_query($sqlHist);	
			$resultOcorrencias= mysql_query($sqlOcorrencias);	

			if (!$result || !$resultHist || !$resultOcorrencias)  {
				$retorno  = false;
			}

			$retorno = true;
			return $retorno;
		}	
		
		function consultaEquipMigrado()
		{
			$sql = "SELECT c.comp_inv as etiqueta, c.comp_sn as serial, c.comp_nome as nome, ".
					"\n\tc.comp_nf as nota, inst.inst_nome as instituicao, inst.inst_cod as cod_inst, ".
					"\n\tc.comp_coment as comentario, c.comp_valor as valor, c.comp_data as data_cadastro, ".
					"\n\tc.comp_data_compra as data_compra, c.comp_ccusto as ccusto, c.comp_situac as situacao, ".
					"\n\tc.comp_local as tipo_local, loc.loc_reitoria as reitoria_cod, reit.reit_nome as reitoria, ".
					"\n\tc.comp_mb as tipo_mb, c.comp_proc as tipo_proc, ".
					"\n\tc.comp_tipo_equip as tipo, c.comp_memo as tipo_memo, c.comp_video as tipo_video, ".
					"\n\tc.comp_modelohd as tipo_hd, c.comp_modem as tipo_modem, c.comp_cdrom as tipo_cdrom, ".
					"\n\tc.comp_dvd as tipo_dvd, c.comp_grav as tipo_grav, c.comp_resolucao as tipo_resol, ".
					"\n\tc.comp_polegada as tipo_pole, c.comp_tipo_imp as tipo_imp, c.comp_assist as assistencia_cod, ".
					"\n\tequip.tipo_nome as equipamento, c.comp_rede as tipo_rede, c.comp_som as tipo_som, ".
					"\n\tt.tipo_imp_nome as impressora, loc.local, ".

					"\n\tproc.mdit_fabricante as fabricante_proc, proc.mdit_desc as processador, ".
					"\n\tproc.mdit_desc_capacidade as clock, proc.mdit_cod as cod_processador, ".
					"\n\tproc.mdit_sufixo as proc_sufixo, ".
					"\n\thd.mdit_fabricante as fabricante_hd, hd.mdit_desc as hd, hd.mdit_desc_capacidade as hd_capacidade, ".
					"\n\thd.mdit_cod as cod_hd, ".
					"\n\thd.mdit_sufixo as hd_sufixo, ".
					"\n\tvid.mdit_fabricante as fabricante_video, vid.mdit_desc as video, vid.mdit_cod as cod_video, ".
					"\n\tred.mdit_fabricante as rede_fabricante, red.mdit_desc as rede, red.mdit_cod as cod_rede, ".
					"\n\tmd.mdit_fabricante as fabricante_modem, md.mdit_desc as modem, md.mdit_cod as cod_modem, ".
					"\n\tcd.mdit_fabricante as fabricante_cdrom, cd.mdit_desc as cdrom, cd.mdit_cod as cod_cdrom, ".
					"\n\tgrav.mdit_fabricante as fabricante_gravador, grav.mdit_desc as gravador, grav.mdit_cod as cod_gravador, ".
					"\n\tdvd.mdit_fabricante as fabricante_dvd, dvd.mdit_desc as dvd, dvd.mdit_cod as cod_dvd, ".
					"\n\tmb.mdit_fabricante as fabricante_mb, mb.mdit_desc as mb, mb.mdit_cod as cod_mb, ".
					"\n\tmemo.mdit_desc_capacidade as memoria, memo.mdit_cod as cod_memoria, memo.mdit_sufixo as memo_sufixo, ".
					"\n\tsom.mdit_fabricante as fabricante_som, som.mdit_desc as som, som.mdit_cod as cod_som, ".

					"\n\tfab.fab_nome as fab_nome, fab.fab_cod as fab_cod, fo.forn_cod as fornecedor_cod, ".
					"\n\tfo.forn_nome as fornecedor_nome, model.marc_cod as modelo_cod, model.marc_nome as modelo, ".
					"\n\tpol.pole_cod as polegada_cod, pol.pole_nome as polegada_nome, ".
					"\n\tres.resol_cod as resolucao_cod, res.resol_nome as resol_nome, ".
					"\n\tsit.situac_cod as situac_cod, sit.situac_nome as situac_nome, sit.situac_destaque as situac_destaque, ".

					"\n\ttmp.tempo_meses as tempo, tmp.tempo_cod as tempo_cod, ".
					"\n\ttp.tipo_garant_nome as tipo_garantia, tp.tipo_garant_cod as garantia_cod, ".

					"\n\tdate_add(c.comp_data_compra, interval tmp.tempo_meses month)as vencimento, ".
					"\n\tsoft.soft_desc as software, soft.soft_versao as versao, ".
					"\n\tassist.assist_desc as assistencia ".

				"\nFROM ((((((((((((((((((((((((equipamentos as c left join  tipo_imp as t on ".
					"\n\tt.tipo_imp_cod = c.comp_tipo_imp) ".
					"\n\tleft join polegada as pol on c.comp_polegada = pol.pole_cod) ".
					"\n\tleft join resolucao as res on c.comp_resolucao = res.resol_cod) ".
					"\n\tleft join fabricantes as fab on fab.fab_cod = c.comp_fab) ".
					"\n\tleft join fornecedores as fo on fo.forn_cod = c.comp_fornecedor) ".
					"\n\tleft join situacao as sit on sit.situac_cod = c.comp_situac) ".
					"\n\tleft join tempo_garantia as tmp on tmp.tempo_cod =c.comp_garant_meses) ".
					"\n\tleft join tipo_garantia as tp on tp.tipo_garant_cod = c.comp_tipo_garant) ".

					"\n\tleft join assistencia as assist on assist.assist_cod = c.comp_assist) ".

					"\n\tleft join modelos_itens as proc on proc.mdit_cod = c.comp_proc) ".
					"\n\tleft join modelos_itens as hd on hd.mdit_cod = c.comp_modelohd) ".
					"\n\tleft join modelos_itens as vid on vid.mdit_cod = c.comp_video) ".
					"\n\tleft join modelos_itens as red on red.mdit_cod = c.comp_rede) ".
					"\n\tleft join modelos_itens as md on md.mdit_cod = c.comp_modem) ".
					"\n\tleft join modelos_itens as cd on cd.mdit_cod = c.comp_cdrom) ".
					"\n\tleft join modelos_itens as grav on grav.mdit_cod = c.comp_grav) ".
					"\n\tleft join modelos_itens as dvd on dvd.mdit_cod = c.comp_dvd) ".
					"\n\tleft join modelos_itens as mb on mb.mdit_cod = c.comp_mb) ".
					"\n\tleft join modelos_itens as memo on memo.mdit_cod = c.comp_memo) ".
					"\n\tleft join modelos_itens as som on som.mdit_cod = c.comp_som) ".

					"\n\tleft join hw_sw as hw on hw.hws_hw_cod = c.comp_inv and hw.hws_hw_inst = c.comp_inst) ".
					"\n\tleft join softwares as soft on soft.soft_cod = hw.hws_sw_cod) ".

					"\n\tleft join localizacao as loc on loc.loc_id = c.comp_local) ".
					"\n\tleft join reitorias as reit on reit.reit_cod = loc.loc_id), ".

					"\n\tinstituicao as inst, marcas_comp as model, tipo_equip as equip ".
				"\nWHERE ".
					"\n\t(c.comp_inst = inst.inst_cod) and (c.comp_marca = model.marc_cod) and ".
					"\n\t(c.comp_tipo_equip = equip.tipo_cod)
				AND (c.comp_inv in (".$this->compInvAlterada.")) 
				AND (inst.inst_cod in (".$this->compInstAlterada."))
				\nGROUP BY comp_inv, comp_inst";
			$resultado = mysql_query($sql);
			return $resultado;
		}
		
		function componentesEquips()
		{
			$sql = "SELECT ".
					"e.estoq_cod, e.estoq_tipo, e.estoq_desc, e.estoq_sn, e.estoq_comentario, e.estoq_tag_inv, e.estoq_tag_inst, ".
					"e.estoq_nf, e.estoq_warranty, e.estoq_value, e.estoq_data_compra, e.estoq_partnumber,  ".
					"i.item_nome,  ".
					"f.forn_nome, f.forn_cod, ".
					"t.tempo_meses, t.tempo_cod, ".
					"c.descricao as ccusto, c.codigo,  ".
					"m.mdit_fabricante as fabricante, m.mdit_desc as modelo, m.mdit_desc_capacidade as capacidade, m.mdit_sufixo as sufixo, ".
					"l.local, l.loc_id, ".
					"inst.inst_nome, ".
					"s.situac_nome, s.situac_cod, ".
					"eqp.eqp_equip_inv, eqp.eqp_equip_inst, ".
					"instEquip.inst_nome as instEquipamento ".
				"FROM ".
					"estoque e ".
					"left join instituicao as inst on inst.inst_cod = e.estoq_tag_inst ".
					"left join equipXpieces as eqp on eqp.eqp_piece_id = e.estoq_cod ".
					"left join instituicao as instEquip on instEquip.inst_cod = eqp.eqp_equip_inst ".
					"left join fornecedores as f on f.forn_cod = e.estoq_vendor ".
					"left join tempo_garantia as t on t.tempo_cod = e.estoq_warranty ".
					"left join CCUSTO as c on c.codigo = e.estoq_ccusto ".
					"left join situacao as s on s.situac_cod = e.estoq_situac, ".
					"itens i, modelos_itens m, localizacao l ".
				"WHERE ".
					"e.estoq_tipo = i.item_cod ".
					"and e.estoq_tipo = m.mdit_tipo ".
					"and e.estoq_desc = m.mdit_cod ".
					"and e.estoq_local = l.loc_id   ".
					"and eqp.eqp_equip_inv in (".$this->compInvAlterada.") and eqp.eqp_equip_inst=".$this->compInstAlterada." ".
					"ORDER BY i.item_nome, e.estoq_desc";
			$resultado = mysql_query($sql);
			return $resultado;
		}
		
		
		

		function mostraEquipAlterado()
		{
			$resultado = $this->consultaEquipMigrado();
			$linhas = mysql_num_rows($resultado);
			// dump ($query);
			// exit;
			if ($linhas == 0){
				print "<script>mensagem('".TRANS('MSG_THIS_CONS_NOT_RESULT')."')</script>";
				print "<script>history.back()</script>";
				exit;
			}else	{
				print "<FORM method='POST' action=".$_SERVER['PHP_SELF'].">";
				while ($row = mysql_fetch_array($resultado)) {
					if (!(empty($row['ccusto'])))
					{
						$CC =  $row['ccusto'];
						$query2 = "select * from `".DB_CCUSTO."`.".TB_CCUSTO." where ".CCUSTO_ID."= $CC "; //and ano=2003
						$resultado2 = mysql_query($query2);
						$row2 = mysql_fetch_array($resultado2);
						$centroCusto = $row2[CCUSTO_DESC];
						$custoNum = $row2[CCUSTO_COD];
					} else $centroCusto = '';

					//GERAÇÃO DE LOG DAS CONSULTAS EFETUADAS NO SISTEMA

					$inst = $row['instituicao'];
					$texto = "[Etiqueta = ".$_REQUEST['comp_inv']."], [Unidade = ".$row['instituicao']."]";

					geraLog(LOG_PATH.'invmon.txt',date ("d-m-Y H:i:s"),$_SESSION['s_usuario'],$_SERVER['PHP_SELF'],$texto);

					if ($linhas == 1){

						print "<table width='100%'>";
						print "<tr>";
						if ($_SESSION['s_ocomon']==1){
							print "<td  width='10%' align='center'>
								<br><B><a onClick= \"javascript: popup_alerta('ocorrencias.php?popup=true&comp_inv=".$row['etiqueta']."&comp_inst=".$row['cod_inst']."')\" title='".TRANS('HNT_OCCO_EQUIP')."'>".TRANS('MNS_OCORRENCIAS')."</a></B><br>
								</td>";
						}

						print " <td width='10%' align='center'>";
						if ($row['tipo'] == 1 || $row['tipo']== 2){//Se o equipamento não for do tipo computador não terá softwares
							print "<br><B><a class='botao' onClick= \"javascript: popup_alerta('comp_soft.php?popup=true&comp_inv=".$row['etiqueta']."&comp_inst=".$row['cod_inst']."')\" title='".TRANS('HNT_SW_INSTALL')."'>".TRANS('MNL_SW')."</a></B><br>";
						}
						print "</td>";

						print "<td width='10%' align='center'><br><B><a class='botao' ".
								"onClick= \"javascript: popup_alerta('hw_historico.php?inv=".$row['etiqueta']."&inst=".$row['cod_inst']."')\" ".
								"title='".TRANS('HNT_HISTORY_ALTER_COMP')."'>".TRANS('LINK_HISTORY_EXCHANGE')."</a></B><br>";
						print "</td>";


						print "<td width='10%' align='center'><br><B><a class='botao' ".
								"onClick= \"javascript: popup_alerta('mostra_historico.php?popup=true&comp_inv=".$row['etiqueta']."".
								"&comp_inst=".$row['cod_inst']."')\" title='".TRANS('HNT_HISTORY_LOCAL_EQUIP')."'>".TRANS('MNL_LOCAIS')."</a></B><br>";
						print "</td>";
						print "<td width='10%'  align='center'><br><B><a class='botao' ".
								"onClick= \"javascript: popup_alerta('consulta_garantia.php?popup=true&comp_inv=".$row['etiqueta']."".
								"&comp_inst=".$row['cod_inst']."')\" title='".TRANS('HNT_INFO_GARANT_EQUIP')."'>".TRANS('LINK_GUARANT')."</a></B><br>";
						print "</td>";

						print "<td width='10%'  align='center'><br><B><a class='botao' ".
								"onClick=\"javascript: popup_alerta('docs_assoc_model.php?popup=true&model=".$row['modelo_cod']." ')\" ".
								"title='".TRANS('HNT_DOCS_ASSOC_EQUIP')."'>".TRANS('LINK_DOCUMENTS')."</a></B><br>";
						print "</td>";

						if ($_SESSION['s_invmon']==1){
							print "<td width='10%'  align='center'>
								<br><B><a class='botao' href='altera_dados_computador.php?comp_inv=".$row['etiqueta']."&comp_inst=".$row['cod_inst']."'>".TRANS('LINK_ALTER_DATA')."</a></B><br>
								</td>";
						}
						print "</tr>";
						print "</table>";

						print "<table width='100%'>";
						print "<tr><TD colspan='4' align='left'><br><B>".TRANS('TXT_GENERAL_DATA').":</B></td></tr></table>";
					}

					print "<TABLE border='0'  align='left' width='100%' >";

					//print "<tr><td colspan='4'>";
					//print "<TABLE border='0' cellpadding='1' cellspacing='2' align='center' width='100%'>";


					print "<tr><td colspan='4'></td></tr>";
					print "<tr>";
							print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_TYPE_EQUIP').":</b></TD>";
							print "<TD class='borda' width='30%' align='left' >".
									"<a href='mostra_consulta_comp.php?comp_tipo_equip=".$row['tipo']."'".
									" title='".TRANS('HNT_LIST_EQUIP_TYPE')." ".$row['equipamento']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['equipamento']."</a>".
								"</TD>";
							print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('COL_MANUFACTURE').":</b></TD>";
							print "<TD class='borda' width='30%' align='left' >".
									"<a href='mostra_consulta_comp.php?comp_fab=".$row['fab_cod']."'".
									" title='".TRANS('HNT_LIST_EQUIP_MANUF')." ".$row['fab_nome']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['fab_nome']."</a>".
								"</TD>";
						print "</tr>";
					print "<tr>";
							print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('OCO_FIELD_TAG').":</b></TD>".
								"<TD class='borda' width='30%' align='left' >".$row['etiqueta']."</TD>".
								"<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('COL_SN').":</b></TD>".
						"<TD class='borda' width='30%' align='left' >".strtoupper($row['serial'])."</TD>";
						print "</tr>";

					print "<tr>";
							print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('COL_MODEL').":</b></TD>".
								"<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
									"comp_marca=".$row['modelo_cod']."' title='".TRANS('HNT_LIST_EQUIP_MODEL')." ".$row['modelo']."  ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['modelo']."</a>".
								"</TD>";
					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('OCO_LOCAL').":</b></TD>".
								"<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
									"comp_local=".$row['tipo_local']."' ".
									"title='".TRANS('HNT_LIST_EQUIP_LOCAL')." ".$row['local']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['local']."</a>".
								"</TD>";
					print "</tr>";

					print "<tr>";
					print "<TD  width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('COL_SITUAC').":</b></TD>";
					print "<TD  class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
							"comp_situac=".$row['situac_cod']."' ".
							"title='".TRANS('HNT_LIST_EQUIP_SITUAC')." ".$row['situac_nome']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['situac_nome']."</a>".
						"</TD><td colspan='2'></td>";
					print "</tr>";

					//print "</table></td></tr>";

					if (($row['tipo']==1) or ($row['tipo']==2) or ($row['tipo']==12)or ($row['tipo']==16)) {

						print "<tr><td colspan='4'></td></tr>";
						print "<tr><td colspan='4'><IMG ID='imgconfig' SRC='../../includes/icons/close.png' width='9' height='9' ".
								"STYLE=\"{cursor: pointer;}\" onClick=\"invertView('config')\">&nbsp;<b>".TRANS('SUBTTL_DATA_COMPLE_CONFIG').": </b></td></tr>";
						print "<tr><td colspan='4'></td></tr>";
						print "<tr><td colspan='4'><div id='config'>"; //style='{display:none}'	//style='{padding-left:5px;}'

						print "<TABLE border='0' cellpadding='1' cellspacing='2' align='center' width='100%'>";

						print "<TR>";
						print "<TD width='20%' align='lef't bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_NAME_COMPUTER').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' >".$row['nome']."</TD>";

						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_MB').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?comp_mb=".$row['cod_mb']."' ".
								"title='".TRANS('HNT_LIST_EQUIP_MOTHERBOARD')." ".$row['fabricante_mb']." ".$row['mb']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".
								"".$row['fabricante_mb']." ".$row['mb']."</a>".
							"</TD>";
						print "</TR>";

						print "<TR>";
						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('MNL_PROC').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_proc=".$row['cod_processador']."' ".
								"title='".TRANS('HNT_LIST_EQUIP_PROCESSOR')." ".$row['processador']." ".$row['clock']." ".
								"".$row['proc_sufixo']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['processador']." ".$row['clock']." ".
								"".$row['proc_sufixo']."</a>".
							"</TD>";

						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('MNL_MEMO').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_memo=".$row['cod_memoria']."' title".
								"='".TRANS('HNT_LIST_EQUIP_WITH')." ".$row['memoria']." ".$row['memo_sufixo']." ".TRANS('HNT_LIST_EQUIP_OF_MEMORY')." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['memoria']." ".$row['memo_sufixo']."</a>".
								//"='".TRANS('HNT_LIST_EQUIP_WITH')." ".$row['memo_fabricante']." ".$row['desc_memoria']." ".TRANS('HNT_LIST_EQUIP_OF_MEMORY')." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['memoria']." ".$row['memo_sufixo']."</a>".
							"</TD>";
						print "</TR>";


						print "<TR>";
						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('MNL_VIDEO').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?comp_video".
								"=".$row['cod_video']."' title='".TRANS('HNT_LIST_EQUIP_VIDEO')." ".$row['fabricante_video']." ".$row['video']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".
								"".$row['fabricante_video']." ".$row['video']."</a>".
							"</TD>";

						print "<TD width='20%' align='lef't bgcolor='".TD_COLOR."'><b>".TRANS('MNL_SOM').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_som=".$row['cod_som']."' title='".TRANS('HNT_LIST_EQUIP_AUDIO')." ".$row['fabricante_som']." ".$row['som']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".
								"".$row['fabricante_som']." ".$row['som']."</a>".
							"</TD>";
						print "</TR>";

						print "<TR>";
						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('MNL_REDE').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_rede=".$row['cod_rede']."' title='".TRANS('HNT_LIST_EQUIP_NETWORK')." ".$row['rede_fabricante']." ".$row['rede']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['rede_fabricante']." ".$row['rede']."</a>".
							"</TD>";

						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_MODEM').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_modem=".$row['cod_modem']."' title='HNT_LIST_EQUIP_MODEM ".$row['fabricante_modem']." ".$row['modem']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['fabricante_modem']." ".$row['modem']."</a>".
							"</TD>";
						print "</TR>";
						print "<TR>";
						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('MNL_HD').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_modelohd=".$row['cod_hd']."' title='HNT_LIST_EQUIP_HARDDISK ".$row['fabricante_hd']." ".TRANS('TXT_OF')." ".$row['hd_capacidade']." ".$row['hd_sufixo']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['fabricante_hd']." ".$row['hd']." ".$row['hd_capacidade']." ".$row['hd_sufixo']."</a>".
							"</TD>";

						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_CDROM').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_cdrom=".$row['cod_cdrom']."' title='".TRANS('HNT_LIST_EQUIP_CDROM')." ".$row['fabricante_cdrom']." ".$row['cdrom']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['fabricante_cdrom']." ".$row['cdrom']."</a>".
							"</TD>";
						print "</TR>";

						print "<TR>";
						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_RECORD_CD').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_grav=".$row['cod_gravador']."' title='".TRANS('HNT_LIST_EQUIP_RECORD')." ".$row['fabricante_gravador']." ".$row['gravador']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".
								"".$row['fabricante_gravador']." ".$row['gravador']."</a>".
							"</TD>";

						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('MNL_DVD').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_dvd=".$row['cod_dvd']."' title='".TRANS('HNT_LIST_EQUIP_DVD')." ".$row['fabricante_dvd']." ".$row['dvd']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".
								"".$row['fabricante_dvd']." ".$row['dvd']."</a>".
							"</TD>";
						print "</TR>";
						print "</table>";
						print "</div></td></tr>";
					}

					if (($row['tipo']!=1) AND ($row['tipo']!=2)) { // O equipamento não é computador!!
						print "<TR><TD colspan='4'></TD></TR>";
						print "<tr><TD colspan='4'><b>".TRANS('SUBTTL_DATA_COMPLE_CONFIG').":</b></TD></tr>";
						print "<TR><TD colspan=4></TD></TR>";

						print "<TR>";
						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_TYPE_PRINTER').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_tipo_imp=".$row['tipo_imp']." title='".TRANS('HNT_LIST_TYPE_PRINTER')." ".$row['impressora']."".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['impressora']."</a>".
							"</TD>";

						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_MONITOR').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_polegada=".$row['tipo_pole']."' title='".TRANS('HNT_LIST_MONITOR')." ".$row['polegada_nome']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['polegada_nome']."</a>".
							"</TD>";
						print "</tr>";
						print "<tr>";
						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_SCANNER').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
								"comp_resolucao=".$row['tipo_resol']."' title='".TRANS('HNT_LIST_RESOLUTION_SCANNER')." ".$row['resol_nome']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['resol_nome']."</a>".
							"</TD>";
						print "</TR>";
					}

					NL(4);

					// print $this->componentesEquips();
					
					$qryPieces = "";
					$execQryPieces = $this->componentesEquips();

					// $execQryPieces = mysql_query($qryPieces) or die (TRANS('ERR_QUERY')."<br>".$qryPieces);

					print "<TR><TD colspan='4'></TD></TR>";
					print "<tr><TD colspan='4'><b>".TRANS('SUBTTL_DATA_COMPLE_PIECES').":</b></TD></tr>";
					print "<TR><TD colspan=4></TD></TR>";


					while ($rowPiece = mysql_fetch_array($execQryPieces)){


						print "<TR>";
						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".$rowPiece['item_nome'].":</b></TD>";
						print "<TD class='borda' width='30%' align='left' >".
							//"<a href='mostra_consulta_comp.php?piece=".$rowPiece['estoq_desc']."'>".
							$rowPiece['fabricante']." ".$rowPiece['modelo']." ".$rowPiece['capacidade']." ".$rowPiece['sufixo']."".
							//"</a>".
							"</TD>";

						print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('COL_SN').":</b></TD>";
						print "<TD class='borda' width='30%' align='left' ><a onClick=\"popup('estoque.php?action=details&cod=".$rowPiece['estoq_cod']."&cellStyle=true')\">".$rowPiece['estoq_sn']."</a></TD>";

						print "</tr>";

							//"<a href='mostra_consulta_comp.php?comp_dvd=".$row['cod_dvd']."' title='".TRANS('HNT_LIST_EQUIP_DVD')." ".$row['fabricante_dvd']." ".$row['dvd']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>";

					}


					print "<tr><td colspan='4'></td></tr>";
					print "<tr><td colspan='4'><IMG ID='imgcontabeis' SRC='../../includes/icons/open.png' width='9' height='9' ".
							"STYLE=\"{cursor: pointer;}\" onClick=\"invertView('contabeis')\">&nbsp;<b>".TRANS('TXT_OBS_DATA_COMPLEM_2').": </b></td></tr>";

					print "<tr><td colspan='4'></td></tr>";
					print "<tr><td colspan='4'><div id='contabeis' style='{display:none}'>"; //style='{display:none}'	//style='{padding-left:5px;}'
					print "<TABLE border='0' cellpadding='1' cellspacing='2' align='center' width='100%'>";

					print "<TR>";
					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('OCO_FIELD_UNIT').":</b></TD>";
					print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
							"comp_inst[]=".$row['cod_inst']."' title='".TRANS('HNT_LIST_EQUIP_CAD_TO')." ".$row['instituicao'].".'>".$row['instituicao']."</a>".
						"</TD>";

					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_CENTER_COST').":</b></TD>";
					print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
							"comp_ccusto=".$row['ccusto']."' title='".TRANS('HNT_LIST_EQUIP_CAD_TO_CENTER_COST')." ".$centroCusto.".'>".$centroCusto."</a>".
						"</TD>";
					print "</tr>";
					print "<TR>";
					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('COL_VENDOR').":</b></TD>";
					print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
							"comp_fornecedor=".$row['fornecedor_cod']."' ".
							"title='".TRANS('HNT_LIST_EQUIP_SUPPLIER')." ".$row['fornecedor_nome']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".
							"".$row['fornecedor_nome']."</a>".
						"</TD>";

					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_FISCAL_NOTES').":</b></TD>";
					print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
							"comp_nf=".$row['nota']."' title='".TRANS('HNT_LIST_EQUIP_FISCAL_NOTES')." ".$row['nota']." ".TRANS('HNT_CAD_IN_SYSTEM')."'>".$row['nota']."</a>".
						"</TD>";
					print "</tr>";
					print "<TR>";
					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_VALUE').":</b></TD>";
					print "<TD class='borda' width='30%' align='left' >R$ ".valueSeparator($row['valor'],',')."</TD>";
					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_DATE_PURCHASE').":</b></TD>";
					print "<TD class='borda' width='30%' align='left' >".$row['data_compra']."</TD>";
					print "</tr>";
					print "<TR>";
					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('COL_MAJOR').":</b></TD>";
					print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
							"comp_reitoria=".$row['reitoria_cod']."'".
							">".$row['reitoria']."</a>".
						"</TD>";

					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('COL_SUBSCRIBE_DATE').":</b></TD>";
					print "<TD class='borda' width='30%' align='left' >".$row['data_cadastro']."</TD>";
					print "</TR>";
					print "<TR>";
					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."'><b>".TRANS('FIELD_TECH_ASSIST').":</b></TD>";
					print "<TD class='borda' width='30%' align='left' ><a href='mostra_consulta_comp.php?".
							"comp_assist=".$row['assistencia_cod']."'".
							">".$row['assistencia']."</a>".
						"</TD>";
					print "</TR>";
					print "</table>";
					print "</div></td></tr>";
					print "<TR>";
					print "<TD width='20%' align='left' bgcolor='".TD_COLOR."' ><b>".TRANS('COL_COMMENT').":</b></TD>";
					print "<TD class='borda' colspan='3' width='30%' align='left' >".$row['comentario']."</TD>";
					print "</TR>";
					print "<tr><td colspan='4'></td></tr>";
					print "<tr><td colspan='4'><IMG ID='imganexos' SRC='../../includes/icons/open.png' width='9' height='9' ".
						"STYLE=\"{cursor: pointer;}\" onClick=\"invertView('anexos')\">&nbsp;<b>".TRANS('FIELD_IMAGE_ASSOC').": </b></td></tr>";

					$noImg = false;

					print "<tr><td colspan='4'></td></tr>";
					print "<tr><td colspan='4'><div id='anexos' style='{display:none}'>"; //style='{display:none}'	//style='{padding-left:5px;}'
					print "<TABLE border='0' cellpadding='1' cellspacing='2' align='center' width='100%'>";

					$qryTela3 = "select  i.* from imagens i  WHERE i.img_model ='".$row['modelo_cod']."'  order by i.img_inv ";
					$execTela3 = mysql_query($qryTela3) or die (TRANS('MSG_ERR_NOT_INFO_IMAGE'));
					//$rowTela = mysql_fetch_array($execTela);
					$isTela3 = mysql_num_rows($execTela3);
					$cont = 0;

					while ($rowTela3 = mysql_fetch_array($execTela3)) {
						$cont++;
						print "<tr>";
						print "<TD  width='20%' bgcolor='".TD_COLOR."' >".TRANS('TXT_IMAGE')." ".$cont." ".TRANS('TXT_OF_MODEL').":</td>";
						print "<td colspan='3' ><a onClick=\"javascript:popupWH('../../includes/functions/showImg.php?file=".$rowTela3['img_cod']."&cod=".$rowTela3['img_cod']."',".$rowTela3['img_largura'].",".$rowTela3['img_altura'].")\"><img src='../../includes/icons/attach2.png'>".$rowTela3['img_nome']."</a></TD>";
						print "</tr>";
						$noImg = true;
					}
					$qryTela2 = "select  i.* from imagens i  WHERE i.img_inst ='".$row['cod_inst']."' and i.img_inv ='".$row['etiqueta']."'  order by i.img_inv ";
					$execTela2 = mysql_query($qryTela2) or die (TRANS('MSG_ERR_NOT_INFO_IMAGE'));
					$isTela2 = mysql_num_rows($execTela2);
					$cont = 0;
					while ($rowTela2 = mysql_fetch_array($execTela2)) {
						$cont++;
						print "<tr>";
						print "<TD  width='20%' bgcolor='".TD_COLOR."' >".TRANS('TXT_INV_ATTACH')." ".$cont.":</td>";
						print "<td colspan='3' ><a onClick=\"javascript:popupWH('../../includes/functions/showImg.php?file=".$rowTela2['img_cod']."&cod=".$rowTela2['img_cod']."',".$rowTela2['img_largura'].",".$rowTela2['img_altura'].")\"><img src='../../includes/icons/attach2.png'>".$rowTela2['img_nome']."</a></TD>";
						print "</tr>";
						$noImg = true;
					}

					$qryTela = "select o.*, i.* from ocorrencias o , imagens i
								WHERE (i.img_oco = o.numero) and (o.equipamento ='".$row['etiqueta']."' and o.instituicao ='".$row['cod_inst']."')  order by o.numero ";
					$execTela = mysql_query($qryTela) or die (TRANS('MSG_ERR_NOT_INFO_IMAGE'));
					$isTela = mysql_num_rows($execTela);
					$cont = 0;
					while ($rowTela = mysql_fetch_array($execTela)) {
						$cont++;
						print "<tr>";
						print "<TD  width='20%' bgcolor='".TD_COLOR."' >".TRANS('TXT_OCCO_ATTACH')." <a onClick= \"javascript:popup_alerta('../../ocomon/geral/mostra_consulta.php?popup=true&numero=".$rowTela['img_oco']."')\"><font color='blue'>".$rowTela['img_oco']."</font></a>:</td>";
						print "<td colspan='3' ><a onClick=\"javascript:popupWH('../../includes/functions/showImg.php?file=".$rowTela['img_oco']."&cod=".$rowTela['img_cod']."',".$rowTela['img_largura'].",".$rowTela['img_altura'].")\"><img src='../../includes/icons/attach2.png'>".$rowTela['img_nome']."</a></TD>";
						print "</tr>";
						$noImg = true;
					}

					if (!$noImg) {
						print "<tr><td width='40%' bgcolor='yellow'>&nbsp;".TRANS('MSG_NO_IMAGE_ASSOC_EQUIP')."</td><td colspan='3' ></td></tr>";
					}

					print "</table>";
					print "</div></td></tr>";

					print "<TR><TD colspan='4' align='left' bgcolor= ".TD_COLOR.">&nbsp</TD></TR>";
					//print "<tr><td colspan='4'><img src='tesoura.png'> - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -</td></tr>";

					print "<TR><TD colspan='4'></TD><TD colspan='4'></TD></TR>";
					print "</table>";
					print "</FORM>";
				} //while $row

			} //linhas != 0
			
		}
		

		
    }
	
	
?>