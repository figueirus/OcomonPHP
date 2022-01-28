<?php
require_once "comum/fpdf/fpdf.php";
require_once "comum/util/package_utils.class";
require_once "comum/sessao/configsis.inc";

/**
* Pdf
*
* Classe que extende a classe de FDPF para poder criar os métodos do UNILASALLE, com base nos métodos da classe
* existente.
*
* @author Henrique Girardi dos Santos
* @version 10/09/2007
*/

class Pdf extends FPDF
{
    /**
    * Recebe o valor booleano para gerar ou não o cabeçalho;
    * @var boolean
    */
    var $geraCabecalho;

    /**
    * Recebe o valor booleano para gerar ou não o cabeçalho;
    * @var boolean
    */
    var $geraRodape;

    /**
    * Recebe o caminho default de onde será salvo o arquivo
    * @var string
    */
    var $defaultPath;

    /**
    * Recebe o caminho para abrir o arquivo
    * @var string
    */
    var $pathHost;

    /**
    * Recebe o valor do usuario que realizou a impressao do PDF
    * @var string
    */
    var $usuario;

    /**
    * Recebe o nome do arquivo PDF
    * @var string
    */
    var $arquivo;

    /**
    * Recebe a extenção do arquivo a ser gerado
    * @var string
    */
    var $extensao;

    /**
    * Recebe o valor da origem do relatorio.
    * @var string
    */
    var $origemRelatorio;

    /**
    * Recebe o valor da largura do quadro do cabeçalho
    * @var array
    */
    var $larguraQuadroCabecalho;

    /**
    * Recebe o valor da coluna que irá inicial o início do cabeçalho
    * @var array
    */
    var $colunaInicioCabecalho;

    /**
    * Recebe o valor do tipo de cabecalho que será impresso
    * @var string
    */
    var $tipoCabecalho;


    /**
    * Pdf
    *
    * Método construtor da classe. Recebe os mesmos parametros da classe FPDF que possa chamar o construtor dela.
    * @param string $orientation - como deve ser a orientação da pagina PDF (P: Portrait | L: Landscape)
    * @param string $unit - unidade de medida do PDF - PADRÃO USADO NO UNILASALLE: 'pt'
    * @param string $format - formato da pagina para criação do PDF
    * @param string $path - Caminho onde salvar o arquivo pdf
    * @param string $host - servidor onde será salvo o arquivo pdf
    * @return void
    */
    function Pdf($orientation='P',$unit='pt',$format='A4', $origem= "")
    {
		global $SISCONF;
		if($origem == ""){
			$origem = 'SIS';
		}
		
	    $this->defaultPath = $SISCONF[$origem]['RELATORIO_PDF']['PATH'];
		$this->pathHost = $SISCONF[$origem]['RELATORIO_PDF']['HOST'];
		
        $this->FPDF($orientation, $unit, $format);
        $this->_limpaPropriedades();
        $this->_setaPropriedades();
        $this->setaOrigemRelatorio($origem);
        $this->string = new StringFormat;
    }

    /**
    * _setaPropriedades
    *
    * Método que seta as propriedades da classe
    * @return void
    */
    function _setaPropriedades()
    {
	GLOBAL $SISCONF;
	
	
	// $this->defaultPath = $SISCONF['SIS']['RELATORIO_PDF']['PATH'];
	// $this->pathHost = $SISCONF['SIS']['RELATORIO_PDF']['HOST'];
	$this->usuario = $SISCONF['SESSAO']['USUARIO']['USUARIO'];
    }

    /**
    * _limpaPropriedades
    *
    * Método que inicializa as propriedades da classe
    * @return void
    */
    function _limpaPropriedades()
    {
        $this->geraCabecalho = false;
        $this->geraRodape = false;
        $this->arquivo = "";
        $this->usuario = "";
        $this->extensao = "pdf";
        $this->origemRelatorio = "";
        $this->erro = array();
        $this->larguraQuadroCabecalho = 0;
        $this->colunaInicioCabecalho = 0;
        $this->tipoCabecalho = "";
    }

    /**
    * setaOrigemRelatorio
    *
    * Método que seta valor para a propriedade 'origemRelatorio'.
    * @param string $origem - recebe o valor da origem do relatório. Por default esse valor vem vazio, indicando que o pdf está sendo gerado pelo sistema interno.
    * @return void
    */
    function setaOrigemRelatorio($origem)
    {
        $this->origemRelatorio = $origem;
    }

    /**
    * setaLarguraQuadroCabecalho
    *
    * Método que seta valor para propriedade 'larguraQuadroCabecalho'.
    * @param int $valor - valor que a propriedade 'larguraQuadroCabecalho' irá receber
    * @return void
    */
    function setaLarguraQuadroCabecalho($valor)
    {
        $this->larguraQuadroCabecalho = $valor;
    }

    /**
    * setaColunaInicioCabecalho
    *
    * Método que seta valor para propriedade 'colunaInicioCabecalho'.
    * @param int $valor - valor que a propriedade 'colunaInicioCabecalho' irá receber
    * @return void
    */
    function setaColunaInicioCabecalho($valor)
    {
        $this->colunaInicioCabecalho = $valor;
    }

    /**
    * setaTipoCabecalho
    *
    * Método que seta valor para propriedade 'tipoCabecalho'.
    * @param int $valor - valor que a propriedade 'colunaInicioCabecalho' irá receber
    * @return void
    */
    function setaTipoCabecalho($tipo)
    {
        $this->tipoCabecalho = $tipo;
    }

    /**
    * setaCabecalho
    *
    * Método que inicializa as propriedades da classe
    * @param array $dadosCabecalho - se o tipoCabecalho == 'ATESTADO', as chaves serão: 'tipo', 'coluna' e 'linha',
    *  senão será 'pagina', titulo1, titulo1_size, titulo2, titulo2_size, titulo3, titulo3_size, tipo, linha
    * @return void
    */
    function setaCabecalho($dadosCabecalho)
    {
        // Faz a verificação do tipo de cabecalho para poder montar o array DadosCabecalho
        if ($this->tipoCabecalho == "ATESTADO") {

            if (!isset($dadosCabecalho["tipo"])) $dadosCabecalho["tipo"] = "";

            // para poder calcular o meio. Está sendo descontado 400 do valor, pois é a largura da imagem
            $largura = $dadosCabecalho["tipo"] == "landscape" ? 438 : 193;
            if (!isset($dadosCabecalho["coluna"])) $dadosCabecalho["coluna"] = $largura/2;
            if (!isset($dadosCabecalho["linha"])) $dadosCabecalho["linha"] = 30;

        } else {

            if (!isset($dadosCabecalho["pagina"])) $this->Error("A chave 'pagina' do parâmetro do método <b>setaCabecalho</b> deve ser passada");
            if (!isset($dadosCabecalho["titulo1"])) $this->Error("A chave 'titulo1' do parâmetro do método <b>setaCabecalho</b> deve ser passada");
            if (!isset($dadosCabecalho["titulo1_size"])) $this->Error("A chave 'titulo1_size' do parâmetro do método <b>setaCabecalho</b> deve ser passada");
            if (!isset($dadosCabecalho["titulo2"])) $dadosCabecalho["titulo2"] = "";
            if (!isset($dadosCabecalho["titulo2_size"])) $dadosCabecalho["titulo2_size"] = 0;
            if (!isset($dadosCabecalho["titulo3"])) $dadosCabecalho["titulo3"] = "";
            if (!isset($dadosCabecalho["titulo3_size"])) $dadosCabecalho["titulo3_size"] = 0;
            if (!isset($dadosCabecalho["tipo"])) $dadosCabecalho["tipo"] = "";
            if (!isset($dadosCabecalho["linha"])) $dadosCabecalho["linha"] = 30;

        }

        $this->geraCabecalho = true;
        $this->dadosCabecalho = $dadosCabecalho;
    }
	

    /**
    * Header
    *
    * Método que mostra o cabeçalho no PDF. Ele é montado sobre o método da classe FPDF.
    * @return void
    */
    function Header()
    {
	if ($this->geraCabecalho == true) {

		switch($this->tipoCabecalho) {
		case "ATESTADO":
			$this->cabecalhoAtestado($this->dadosCabecalho);
			break;

		default:
			$this->cabecalhoPadrao($this->dadosCabecalho);
		}

        }
    }

    /**
    * cabecalhoAtestado
    *
    * Método que monta o cabeçalho dos atestados.
    * @param array $dadosCabecalho - recebe um array com os dados necessários para montar o cabeçalho. Esse array
    *  é a propriedade da classe 'dadosCabecalho'.
    * @return void
    */
    function cabecalhoAtestado($dadosCabecalho)
    {
	GLOBAL $SISCONF;
	
	if ( $this->origemRelatorio == "PORTAL_ACAD") {
		$local = $SISCONF['PORTAL_ACAD']['PATH_IMG'];
	} else {
		$local = $SISCONF['SIS']['PATH_IMG_CAB_PADRAO'];
	}
	
	$this->Image($local."logoOficial_PDF.jpg", $dadosCabecalho["coluna"], $dadosCabecalho["linha"], 400, 75);
    }

    /**
    * cabecalhoPadrao
    *
    * Método que monta o cabeçalho padrão dos PDFs.
    * @param array $dadosCabecalho - recebe um array com os dados necessários para montar o cabeçalho. Esse array
    *  é a propriedade da classe 'dadosCabecalho'.
    * @return void
    */
    function cabecalhoPadrao($dadosCabecalho) {
	GLOBAL $SGU_INTERNET;
	GLOBAL $SISCONF;

	if ($this->origemRelatorio == "PORTAL_PROF") {
		$local = $SISCONF['PORTAL_PROF']['PATH_IMG'];
	} else {
		$local = $SISCONF['SIS']['PATH_IMG_CAB_PADRAO'];
	}
	$coluna = 15;
	if ( (int) $this->colunaInicioCabecalho > 0 ) $coluna = $this->colunaInicioCabecalho;

	$this->SetLineWidth(0.1);
	$linha = $dadosCabecalho["linha"];

	// adiciona a imagem do logotipo do UNILASALLE
	$this->Image($local."unilasalle_pb_pq.jpg", $coluna+12, $linha+10, 200, 35);
	
	$tamQuadro = 565;
	if ( isset($dadosCabecalho["tipo"]) ) {
		if ($dadosCabecalho["tipo"] == "landscape") {
			$tamQuadro = 825;
		} else {
			$tamQuadro = 565;
		}
	}

	if ( $this->larguraQuadroCabecalho > 0 ) $tamQuadro = $this->larguraQuadroCabecalho;

	$this->Line($coluna, $linha+60, $tamQuadro, $linha+60);
	$this->Line($coluna+225, $linha+45, $tamQuadro, $linha+45);
	$this->Line($coluna, $linha+5, $tamQuadro, $linha+5);
	$this->Line($coluna, $linha+60, $coluna, $linha+5);
	$this->Line($coluna+225, $linha+60, $coluna+225, $linha+5);
	$this->Line($tamQuadro, $linha+60, $tamQuadro, $linha+5);

	if ($dadosCabecalho["titulo1_size"] == 0) $dadosCabecalho["titulo1_size"] = 11;
	if ($dadosCabecalho["titulo2_size"] == 0) $dadosCabecalho["titulo2_size"] = 9;
	if ($dadosCabecalho["titulo3_size"] == 0) $dadosCabecalho["titulo3_size"] = 9;

	$this->SetFont('Times', 'B', $dadosCabecalho["titulo1_size"]);
	$this->Text($coluna+230, $linha+17, $dadosCabecalho["titulo1"]);

	$this->SetFontSize($dadosCabecalho["titulo2_size"]);
	$this->Text($coluna+230, $linha+30, $dadosCabecalho["titulo2"]);

	$this->SetFontSize($dadosCabecalho["titulo3_size"]);
	$this->Text($coluna+230, $linha+40, $dadosCabecalho["titulo3"]);

	$this->SetFont('Times', '', 9);

	$this->Text($coluna+230, $linha+55, "SGL");
	$this->Text($tamQuadro-45, $linha+55, "Pág: ".$this->string->left($dadosCabecalho["pagina"], 4));

	$this->SetXY($coluna+230, $linha+48);
	$this->Cell(0, 9, date('d/m/Y H:i'), 0, 1, "C");
    }

    /**
    * setaRodape
    *
    * Método que seta os valores para montar o rodapé
    * @param object $query - recebe o objeto de conexão
    * @param array $dadosRodape - array com os dados necessários para gerar o rodapé. Se o array for passado
    * vazio, será usado os valores default das chaves. As chaves do array são:
    * int 'estId' - código do estabecimento, por default é 2
    * string 'tipo' - tipo de PDF (portrait ou landscape). Por default vem em braco, que é portrait
    * int 'linha' - a linha onde deve ser escrito o rodapé, já há valores default, dependendo do tipo escolhido.
    * @return void
    */
    function setaRodape($query, $dadosRodape)
    {
	if (is_array($dadosRodape)) {

		if (!isset($dadosRodape["estId"])) $dadosRodape["estId"] = 2;
		if (!isset($dadosRodape["tipo"])) $dadosRodape["tipo"] = "";
		if (!isset($dadosRodape["linha"])) {
			if ($dadosRodape["tipo"] == "landscape") {
				$dadosRodape["linha"] = 555;
			} else {
				$dadosRodape["linha"] = 800;
			}
		}

		$this->geraRodape = true;
		$this->dadosRodape = $dadosRodape;
		$this->qryRodape = $query;
	} else {
		$this->Error("O parâmetro do método <b>setaRodape</b> deve ser um <b>ARRAY</b>");
	}
    }

    /**
    * Footer
    *
    * Método que mostra o rodapé no PDF. Ele é montado sobre o método da classe FPDF.
    * @return void
    */
    function Footer()
    {
        if ($this->geraRodape == true) {
            $this->rodapeRelatorio($this->qryRodape, $this->dadosRodape);
        }
    }

    /**
    * rodapeRelatorio
    *
    * Método que monta o rodapé do PDF.
    * @param object $query - recebe o valor da propriedade 'qryRodape'.
    * @param array $dadosRodape - recebe um array com os dados necessários para montar o cabeçalho. Esse array
    *  é a propriedade da classe 'dadosRodape'.
    * @return void
    */
    function rodapeRelatorio($query, $dadosRodape)
    {
        $endereco = "";
        $cep = "";
        $cidade = "";
        $cnpj = "";
        $fone = "";
        $fax = "";
        $site = "";
        $tamanhoFonte = 8;

        if ( $dadosRodape["estId"] != "" ) {

            // busca os dados do estabelecimento para imprimir o rodapé da página
            $sql = "select fn_first_maiuscula(E.EST_ENDERECO) as EST_ENDERECO, E.EST_CEP, C.CID_NOME, C.CID_EST".
                "\n     , E.EST_CNPJ, E.EST_FONE, E.EST_FAX, lower(E.EST_SITE) as EST_SITE".
                "\n from ESTABELECIMENTO E, CIDADES C".
                "\n where E.EST_ID = ".$dadosRodape["estId"].
                "\n and E.CID_ID = C.CID_ID";
            $query->TQuery($sql);
            if ( $row = $query->fetchrow() ) {
                $endereco = $row["EST_ENDERECO"];
                $cep = substr($row["EST_CEP"], 0, 5)."-".substr($row["EST_CEP"],5,3);
                $cidade = $row["CID_NOME"]."/".$row["CID_EST"];
                $cnpj = $row["EST_CNPJ"];
                $cnpj = substr($cnpj,0,2).".".substr($cnpj,2,3).".".substr($cnpj,5,3)."/".substr($cnpj,8,4)."-".substr($cnpj,12,2);
                $fone = $row["EST_FONE"];
                $fax = $row["EST_FAX"];
                $site = $row["EST_SITE"];
            }
        }

        $texto = $endereco." - ".$cep." - ".$cidade." - CNPJ ".$cnpj." - Fone: ".$fone." - Fax ".$fax." - ".$site;

        $this->setFont('Arial', '', $tamanhoFonte);
        $this->setY($dadosRodape["linha"]);
        $this->Cell(0, 0, $texto, 0, 0, "C");
    }

    /**
    * criaNomeArquivo
    *
    * Método que cria o nome do arquivo PDF que será gerado
    * @return void
    */
    function criaNomeArquivo()
    {
        GLOBAL $SISCONF;
        $this->arquivo = date("YmdHis").$this->usuario.".".$this->extensao;
    }

    /**
    * geraArquivoPDF
    *
    * Método adiciona mensagem ao array de erro.
    * @param boolean $retornaCaminho - parametro que informa se é para retornar o caminho onde é gerado
    *   o arquivo. Por default é FALSE.
    * @return void/string
    */
    function geraArquivoPDF($retornaCaminho=false)
    {
        $this->criaNomeArquivo();
        $this->Output($this->defaultPath.$this->arquivo,'F');
        $this->close();

        if ($retornaCaminho == false) {
            echo "<script language='javascript'>
                    window.open('".$this->pathHost.$this->arquivo."','','');
                </script>";
        } else {
            return $this->pathHost.$this->arquivo;
        }
    }
}
?>