<?php	
	session_start();
	
	##### NESTE BLOCO ? INFORMADO OS INCLUDES (REQUIRE) QUE 
	##### SER?O UTILIZADOS NESTE SCRIPT
	require_once "../../classes/session.php";
	require_once "../../classes/package_bd.class";
	require_once "../../classes/html.class";
	require_once "../../classes/getElement.class";
	require_once "../../classes/forms.class";
	require_once "../../includes/include_geral.inc.php";
	require_once "../../includes/include_geral_II.inc.php";
	###################################
	
	###### INIC?O DA PROGRAMA??O ######
	//TITULO DO SCRIPT
	
	$_SESSION['s_page_admin'] = $_SERVER['PHP_SELF'];
	$cab = new headers;
	print "<HTML>";
	print "<head><script language='JavaScript' src=\"../../includes/javascript/calendar.js\"></script></head>";
	print "<BODY bgcolor=".BODY_COLOR.">";
	
	$texto = TRANS('MENU_TTL_MOD_ADMIN');
	print "<TABLE class='header_centro' cellspacing='1' border='0' cellpadding='1' align='center' width='100%'>".//#5E515B
		"<TR>". 
			"<TD nowrap width='80%'><b>".$texto."</b></td>".
				"<td width='20%' nowrap><p class='parag'><b>".TRANS(date("l")).",&nbsp;".(formatDate(date("Y/m/d H:i"), " %H:%M"))."</b>".$help."</p></TD>";
		print "</TR>".
		"</TABLE>";
	print "<BR><B>".TRANS('TTL_TYPE_ATEND')."</B><BR>";
	
	###### ESTE BLOCO INICIA OS HEADERS (CABE?ALHO) DO SISTEMA ######
	$geraHeader = new html();
	$geraHeader->getCabecalhoHtml("","#FFFFFF",$js,$css,"");
	$f = new tipoAtend($banco,$_REQUEST);
	$geraHeader->getEndHtml();
	
	#################################################
	
	###### ESTE BLOCO VERIFICA AS PERMISS?ES DO USU?RIO
	###### E INICIALIZA AS PERMISS?ES PARA ACESSO AO BANCO DE DADOS
	
	$banco = new genericDB;
	$banco->setBanco('MYSQL');
	$banco->setConexao(SQL_USER,SQL_PASSWD,SQL_DB,SQL_SERVER);
	$banco->conecta(true);
	
	############################################################

	
	
	class tipoAtend
	{
		var $desc_atend;
		var $flag_atend;
		var $cod;
		var $acao;	
		var $controle;
		var $botao;
		
		function tipoAtend(&$DB,&$requests)
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
			$this->desc_atend =  "";
			$this->flag_atend =  "";
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
			if (isset($this->REQUESTS['desc_atend'])){$this->desc_atend  = $this->REQUESTS['desc_atend'];}	
			if (isset($this->REQUESTS['flag_atend'])){$this->flag_atend  = $this->REQUESTS['flag_atend'];}	
			if (isset($this->REQUESTS['cod'])){$this->cod = $this->REQUESTS['cod'];}	
			
		}
		
		
		/*
		*controle()
		*controle():controla as intera??es do programa
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
						if ($this->armazenaDados() == false){
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro n?o foi efetuado.');redirect('$PHP_SELF')</script>";
						}else{
							print "<script language='javaScript'>alert('Registro salvo com sucesso!');redirect('$PHP_SELF')</script>";
						}
					}	
					$this->limpaPropriedades();	
				break;
				case "ALT_CAD":
					if ($this->validaCampos() === True){
						if ($this->alteraDados() == false){
							print "<script>mensagem('Erro ao incluir o registro! Este cadastro n?o foi efetuado.');redirect('$PHP_SELF')</script>";
						}else{
							print "<script language='javaScript'>alert('Registro salvo com sucesso!');redirect('$PHP_SELF')</script>";
						}
					}	
					$this->limpaPropriedades();
				case "INC_CAD":
					
					$this->formularioCadastro();
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
		* Lista as informa??es da Tabela Tipo de Atendimento
		*/
		function listagemPrincipal()
		{
			print "<td><a href='".$_SERVER['PHP_SELF']."?acao=INC_CAD'>Incluir Cadastro</a></td><br>";
			$resultado = $this->buscaTipoAtend();
			if (mysql_numrows($resultado) == 0){
				echo mensagem(TRANS('MSG_NOT_TYPE_ATEND'));
			}else{
				$linhas = mysql_numrows($resultado);
				print "<td class='line'>";
				
				print "<BR>".TRANS('THERE_IS_ARE')." <b><font color='red'>".$linhas."</font></b> ".TRANS('TXT_TYPE_ATEND')."<br>";
				print "<TABLE border='0' cellpadding='5' cellspacing='0'  width='20%'>";
				print "<TR class='header'><td class='line'>".TRANS('TLT_DESC_ATEND')."</TD>"
					."\n <td class='line'><b>".TRANS('OCO_TLT_AVAL')."</b><td class='line'><b>".TRANS('OCO_FIELD_ALTER')."</b></TD>";
				$j=2;
				while ($row=mysql_fetch_array($resultado)){
					if ($j % 2){
						$trClass = "lin_par";
					}else{
						$trClass = "lin_impar";
					}
					$j++;
					
					if ($row['flag_atend'] == '1' ){
						$flag = $flag = "<font color=green><b>Sim</b></font>";
					}else{
						$flag = "<font color=red><b>N?o</b></font>";
					}

					print "<tr class=".$trClass." id='linhax".$j."' onMouseOver=\"destaca('linhax".$j."','".$_SESSION['s_colorDestaca']."');\" onMouseOut=\"libera('linhax".$j."');\"  onMouseDown=\"marca('linhax".$j."','".$_SESSION['s_colorMarca']."');\">";
					print "<td class='line'>".$row['desc_atend']."</TD>";
					print "<td class='line'>".$flag."</TD>";

					print "<td class='line'><a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=ALTER&cod=".$row['id_atend']."')\"><img height='16' width='16' src='".ICONS_PATH."edit.png' title='".TRANS('HNT_EDIT')."'></a></TD>";
					//print "<td class='line'><a onClick=\"redirect('".$_SERVER['PHP_SELF']."?acao=ALTER&cod=".$row['prod_id']."')\"><img height='16' width='16' src='".ICONS_PATH."edit.png' title='".TRANS('HNT_EDIT')."'></a></TD>";
					print "</TR>";
				}
				print "</TABLE>";
			}
		}
		
		/*
		* formularioCadastro()
		* Formul?rio de cadastro
		*/
		function formularioCadastro()
		{		
			GLOBAL $PHP_SELF;
			GLOBAl $SISCONF;
			$bloqueio = false;
			
			print "<B>".TRANS('SUBTIT_TYPE_CADASTRO').":<br><br>";
			print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TLT_DESC_ATEND').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('desc_atend', $this->desc_atend, 50, 25,  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_FLAG_ATEND').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'> Sim".$this->forms->getRadio('flag_atend','sim','', false, $bloqueio)." "
					."\n N?o".$this->forms->getRadio('flag_atend','n?o','', false, $bloqueio)."</TD>";
			print "</tr>";
		
			print "<tr><td class='line'><input type='submit'  class='button' name='submit' value='Gravar'></td>"
				."<input class='button' type='hidden' name='acao' value='GRAVAR'>";
			print "<td class='line'><input type='reset' name='reset'  class='button' value='".TRANS('BT_CANCEL')."' onclick=\"javascript:history.back()\"></td></tr>";
			print "</table>";
			print "</form>";
			
		}
		
		/*
		* alteraCadastro()
		* Formul?rio para alterar de cadastro
		*/
		function alteraCadastro()
		{		
			$exec = $this->retornaDadosAlter();
			$rowAlter = mysql_fetch_array($exec);
			$bloqueio = false;
			
			print "<B>".TRANS('SUBTIT_TYPE_CADASTRO').":<br><br>";
			print "<form name='incluir' method='post' action='".$_SERVER['PHP_SELF']."' onSubmit='return valida()'>";
			print "<TABLE border='0' align='left' width='100%' bgcolor=".BODY_COLOR.">";
			print "<TD >".$this->forms->getHidden( 'cod',$_GET['cod'])."</TD>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TLT_DESC_ATEND').":</TD>";
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'>".$this->forms->getText('desc_atend', $rowAlter['desc_atend'], 50, 25,  $bloqueio)."</TD>";
			print "</tr>";
			print "<tr>";
			print "<TD width='20%' align='left' bgcolor=".TD_COLOR.">".TRANS('TXT_FLAG_ATEND').":</TD>";
			if ($rowAlter['flag_atend'] == '1'){
					$SIM = $this->forms->getRadio('flag_atend','sim', '', true, false, $bloqueio);
					$N?O =  $this->forms->getRadio('flag_atend','n?o','', false, false, $bloqueio);
				}elseif($rowAlter['flag_atend'] == '0'){
					$SIM = $this->forms->getRadio('flag_atend','sim','', false, false, $bloqueio);
					$N?O = $this->forms->getRadio('flag_atend','n?o','',true, false, $bloqueio);
				}
			print "<TD width='80%' align='left' bgcolor='".BODY_COLOR."'> Sim".$SIM." "
					."\n N?o".$N?O."</TD>";
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
		*fun??o para a valida??o dos campos
		*/
		function validaCampos()
		{
			$retorno = true;
			#Valida se todos os campos foram preenchidos
			if ($this->desc_atend == ""){
				print "<script>mensagem('O campo DESCRI??O, deve ser PREENCHIDO!!!.');redirect('$PHP_SELF?acao=INC_CAD')</script>";
				$retorno = false;
			}
			if ($this->flag_atend == ""){
				print "<script>mensagem('O campo REQUER AVALIA??O, deve ser INFORMADO!!!.');redirect('$PHP_SELF')</script>";
				$retorno = false;
			}
				
			return $retorno;
		}
		
		
		
		/*
		*retornaDadosAlter
		*fun??o para retornar os dados para a altera??o dos registros
		*@return void
		*/
		function retornaDadosAlter()
		{
			$qry = "SELECT * FROM tipo_atend WHERE id_atend = ".$_GET['cod']."";
			$resultado = mysql_query($qry);
			return $resultado;
		}
				
		/*
		* buscaTipoAtend()
		* Busca as informa??es da Tabela Tipo de Atendimento
		*/
		function buscaTipoAtend()
		{
			$sql = " SELECT *
					FROM tipo_atend";
				$resultado = mysql_query($sql);
			return $resultado;
		}

		/**
		* armazenaDados
		* Fun??o para armazenar dados
		*
		*/
		function armazenaDados()
		{
			if ($this->flag_atend == 'sim'){
				$flag = '1';
			}else	{
				$flag = '0';
			}
			
			$sql = "INSERT INTO tipo_atend (desc_atend, flag_atend) "
				."\n VALUES ('".$this->desc_atend."', '".$flag."')";
				//dump ($sql);exit;	
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
		* Fun??o para alterar dados
		*
		*/
		function alteraDados()
		{
			if ($this->flag_atend == 'sim'){
				$flag = '1';
			}else	{
				$flag = '0';
			}
			
			$sql = "UPDATE  tipo_atend SET desc_atend = '".$this->desc_atend."',   flag_atend = '".$flag."' "
				."\n WHERE id_atend  = '".$this->cod."'";
				//dump ($sql);exit;	
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