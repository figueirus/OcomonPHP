<?php
GLOBAL $SISCONF;
GLOBAL $TNS_SUN;
GLOBAL $TNS_MANAUS;
GLOBAL $PHP_SELF;

$PHP_SELF = $_SERVER["PHP_SELF"];
//$host = "https://sistemas.unilasalle.edu.br/";
$host = "http://10.10.1.229:82";
$pathIntranet = "D:\DESENVOLVIMENTO_LOCAL\SGL";
$pathInternet = "D:\DESENVOLVIMENTO_LOCAL\SGL";
$caminhoLocal = $pathIntranet;

# Variáveis novas
#$SISCONF['SIS']['COMUM']['PATH-INCLUDES'] = '/netdb/www/intranet/sistemas/sgu/portal/includes/';  #criada por diegom em 10/09/2004
$SISCONF['SIS']['COMUM']['MENSAGEM']['CONEXAO'] = '<BR>Por Favor, entre em contato <BR>pelo o Telefone (51) 4768500 ramal 8621';  #criada por diegom 10/09/2004
$SISCONF['SIS']['COMUM']['MENSAGEM']['SISTEMAS'] = 'Unidade de Sistemas de Informação<BR>Ramal: 8620<BR>';  #criada por diegom 13/09/2004
$SISCONF['SIS']['COMUM']['MENSAGEM']['CADASTRO'] = 'Entre em contato com o Centro de Informática';  #criada por diegom 10/09/2004
#$SISCONF['SIS']['PATH_ARQ_COBRANCA_RETORNO'] = "/usr/local/apache2/htdocs/intranet/portal/modulos/financeiro/retorno/";  #criada por JOAO 16/09/2004

//Seção de confuguração dos usuários logados
$SISCONF['SESSAO']['USUARIO']['ID'] = $_SESSION["userid"];
$SISCONF['SESSAO']['USUARIO']['USUARIO'] = $_SESSION["user"];
$SISCONF['SESSAO']['USUARIO']['NOME'] = $_SESSION["usernome"];
$SISCONF['SESSAO']['USUARIO']['SENHA'] = $_SESSION["pwd"];
$SISCONF['SESSAO']['USUARIO']['TEMA'] = "default";

#$TNS_SUN = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = oracle-db.unilasalle.edu.br)(PORT = 1521)) ) (CONNECT_DATA = (SID = LASALLE) ) )';
$TNS_SUN = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.10.1.10)(PORT = 1521)) ) (CONNECT_DATA = (SID = LASALLE) ) )';
//$TNS_SUN = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.10.1.11)(PORT = 1521)) ) (CONNECT_DATA = (SID = LASALLE) ) )';
$TNS_MANAUS = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 200.241.117.156)(PORT = 1521)) ) (CONNECT_DATA = (SID = LASALLE) ) )';
$TNS_DESENV = '(DESCRIPTION = (ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = 10.10.1.10)(PORT = 1521)) ) (CONNECT_DATA = (SID = LASALLE) ) )';

//echo "$selecao_prof_cpf"."$selecao_prof_senha";
$SISCONF['SESSAO']['SELECAO_PROF']['CPF'] = $selecao_prof_cpf;
$SISCONF['SESSAO']['SELECAO_PROF']['SENHA'] = $selecao_prof_senha;
$SISCONF['SESSAO']['SELECAO_PROF']['CHAVE'] = "YHKUSORENKKDAIOW";

$SISCONF['SESSAO']['USUARIO']['IP'] = getenv ("REMOTE_ADDR");
$SISCONF['ARQUIVO'] = $PHP_SELF;

$SISCONF['PAGINA']['LINK'] = getenv("HTTP_REFERER");
$SISCONF['PAGINA']['VARS'] = '';

###############################################
##  SEÇÃO PARA AUTENTICAÇÃO ENVIO DE E-MAIL PARA O SERVIDOR  ##
###############################################
//$SISCONF['SMTP_MAIL']['HOST'] = "mail.unilasalle.edu.br";
$SISCONF['SMTP_MAIL']['HOST'] = "svrmail.unilasalle.edu.br";
$SISCONF['SMTP_MAIL']['USERNAME'] = "";
$SISCONF['SMTP_MAIL']['PASSWORD'] = "";
$SISCONF['SMTP_MAIL']['SMTP_AUTH'] = true;
###############################################
###############################################

//seções de configuração estrutura lógica da arquitetura do sistema

//METRICS_ACTIVE = Se true ativa cálculo de tempo de criação no serv. e carga da página no browser
$SISCONF['SIS']['METRICS']['ACTIVE'] = false;

//seção de configuração dos Targets de programas.
$SISCONF['SIS']['TARGET']['MENU']     = " target=\"menu\" ";
$SISCONF['SIS']['TARGET']['PROGRAMA'] = " target=\"corpo\" ";

//seção de configuração do COMUM (DOMÍNIOS)
$SISCONF['SIS']['COMUM']['DOMAIN'] = $host."/"; #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['DOMAIN_EMAIL'] = "@unilasalle.edu.br";             #criado por diegom em 13/09/2004
$SISCONF['SIS']['COMUM']['DOMAIN_ACAD'] = $host."/portalAcad/";  #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['DOMAIN_PROF'] = $host."/portalprof/";  #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['DOMAIN_SEL'] = "https://selecao.unilasalle.edu.br/";  #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['DOMAIN_INTRANET'] = "http://www.intranet.unilasalle.edu.br/";  #criado por diegom em 13/09/2004
$SISCONF['SIS']['COMUM']['DOMAIN_BIBLIOTECA'] = "http://biblioteca.unilasalle.edu.br"; #criado por diegom em 15/09/2004
$SISCONF['SIS']['COMUM']['DOMAIN_PROCESSO_SELECAO'] = "http://processoselecao.unilasalle.edu.br/";  #criado por diegom em 13/09/2004
$SISCONF['SIS']['COMUM']['DOMAIN_CONSULTA_WEB'] = "https://www.lasalle.edu.br/portalalunos/";  # criado por diegom em 02/10/2006

$SISCONF['SIS']['COMUM']['ESTAB']['COLEGIO'] = 1;
$SISCONF['SIS']['COMUM']['ESTAB']['GRADUACAO'] = 2;

$SISCONF['SIS']['COMUM']['CONTABILIDADE']['SLIP']['COLCHETES'] = 1; // 1 ou 2 colchetes na exibição do slip
$SISCONF['SIS']['COMUM']['CONTABILIDADE']['SLIP']['EXIBE_LETRA_DC'] = false; // Se habilitado mostrará D ou C dentro dos colchetes quando for mais de um habilitado
$SISCONF['SIS']['COMUM']['CONTABILIDADE']['SLIP']['EXIBE_ESPACO_HISTORICO'] = false; // Mostra um espaço para ser preenchido referente ao histórico
$SISCONF['SIS']['COMUM']['CONTABILIDADE']['SLIP']['EXIBE_CONSOLIDADO_CURSO'] = false; // Valor defaul para sinalizar se deve ou não ser agrupado por curso

//seção de configuração do COMUM (Informações Gerais)
$SISCONF['SIS']['COMUM']['NOME_UNILASALLE']  = "UNILASALLE";
$SISCONF['SIS']['COMUM']['CGC_UNILASALLE'] = "92.741.990/0038-29";    #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['CGC_COLEGIO']    = "92.741.990/0040-43";    #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['CIDADE'] = "Canoas";                        #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['RF'] = "RS";                                #criado por rudinei em 31/08/2004

$SISCONF['SIS']['COMUM']['SELECAO_RESPONSAVEL'] = "Pró-reitoria Acadêmica";    #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['SELECAO_EMAIL'] = "prac@unilasalle.edu.br";          #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['SELECAO_FONE'] = "(xx51) 3476-8500";                   #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['UNILASALLE_EMAIL'] = "lasalle@unilasalle.edu.br";    #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['UNILASALLE_ENDERECO'] = "Av. Victor Barreto, 2288, Centro";    #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['SECRETARIA_EMAIL'] = "secretaria@unilasalle.edu.br"; #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['SECRETARIA_NOME'] = "Setor de Registro e Controle Acadêmico"; #criado por João Felipe em 06/05/2005
$SISCONF['SIS']['COMUM']['SIS_ADMIN_EMAIL'] = "sistemas@unilasalle.edu.br";    #criado por rudinei em 31/08/2004
$SISCONF['SIS']['COMUM']['REDES_ADMIN_EMAIL'] = "redes@unilasalle.edu.br";    #criado por diegom em 13/09/2004
$SISCONF['SIS']['COMUM']['COLEGIO_EMAIL'] = "colegio@unilasalle.edu.br";    #criado por diegom em 13/09/2004
$SISCONF['SIS']['COMUM']['PROTOCOLO_EMAIL'] = "protocolo@unilasalle.edu.br";    #criado por diegom em 13/09/2004
$SISCONF['SIS']['COMUM']['AVALIACAO_EMAIL'] = "avaliacao@unilasalle.edu.br";    #criado por diegom em 13/09/2004
$SISCONF['SIS']['COMUM']['CONTATO_PROUNI'] = "<br>(51) 3476-8568 ou (51) 3476-8613 de segunda à sexta no horário das 14h às 20h.";

$SISCONF['SIS']['COMUM']['OWNER_PERGAMUM'] = "SYSPERGAMUM.";                       #criado por Rudinei em 01/09/2004


//seção de configuração do COMUM
$SISCONF['SIS']['COMUM']['HOST']  = $host;
$SISCONF['SIS']['COMUM']['PATH']  = "comum/";
$SISCONF['SIS']['COMUM']['SESSAO']= $SISCONF['SIS']['COMUM']['PATH']."sessao/";
$SISCONF['SIS']['COMUM']['BANCO'] = $SISCONF['SIS']['COMUM']['PATH']."banco/";
$SISCONF['SIS']['COMUM']['TELA']  = $SISCONF['SIS']['COMUM']['PATH']."tela/";
$SISCONF['SIS']['COMUM']['UTIL']  = $SISCONF['SIS']['COMUM']['PATH']."util/";
$SISCONF['SIS']['COMUM']['ERRO']  = $SISCONF['SIS']['COMUM']['PATH']."erro/";
$SISCONF['SIS']['COMUM']['TEMAS'] = $SISCONF['SIS']['COMUM']['HOST']."/portal/modulos/temas/";
$SISCONF['SIS']['COMUM']['TEMAS_FONTES'] = $SISCONF['SIS']['COMUM']['TEMAS']."fonts";
$SISCONF['SIS']['COMUM']['IMAGENS'] = $SISCONF['SIS']['COMUM']['HOST']."/portal/imagens/";
$SISCONF['SIS']['COMUM']['IMAGENS_TEMA'] = $SISCONF['SIS']['COMUM']['TEMAS']."comum/images/";
// configuração para a geração das fotos das pessoas
$SISCONF['SIS']['COMUM']['FOTOS']['PATH'] = "/netdb/www/intranet/sistemas/sgu";
$SISCONF['SIS']['COMUM']['FOTOS']['HOST'] = "/portal/temp/";

//sessão de configura do TEMPLATE GENERATOR
$SISCONF['SIS']['TEMPLATE_GENERATOR']['PATH'] = $pathIntranet."/phpclasses";

//seção de configuração do INTRANET
$SISCONF['SIS']['INTRANET']['HOST'] = $host;
$SISCONF['SIS']['INTRANET']['PATH'] = "/phpclasses/";
$SISCONF['SIS']['INTRANET']['PATH_EDITOR']  = $SISCONF['SIS']['INTRANET']['HOST']."portal/modulos/editors/tinymce/jscripts/tiny_mce/tiny_mce.js";
$SISCONF['SIS']['INTRANET']['PATH_EDITOR_INNOVA']  = $SISCONF['SIS']['INTRANET']['HOST']."portal/modulos/editors/editor/";
$SISCONF['SIS']['INTRANET']['SCRIPT']['GREYBOX']  = $SISCONF['SIS']['INTRANET']['HOST']."script/greybox/greybox/";

$SISCONF['SIS']['INTRANET']['NEGOCIO'] = $SISCONF['SIS']['INTRANET']['PATH']."negocio/";
$SISCONF['SIS']['INTRANET']['INTERFACE']  = $SISCONF['SIS']['INTRANET']['PATH']."interface/";

$SISCONF['SIS']['INTRANET']['NEGOCIO']['COMUM']  = $SISCONF['SIS']['INTRANET']['NEGOCIO']."comum/";
$SISCONF['SIS']['INTRANET']['INTERFACE']['COMUM']  = $SISCONF['SIS']['INTRANET']['INTERFACE']."comum/";

$SISCONF['SIS']['INTRANET']['THEMA']['HOST']  = $SISCONF['SIS']['INTRANET']['HOST']."/portal/modulos/temas/default/";
$SISCONF['SIS']['INTRANET']['THEMA']['PATH']  = $pathIntranet."/portal/modulos/temas/default/";
$SISCONF['SIS']['INTRANET']['PROGRAMA']  = $pathIntranet."/portal/modulos/";
$SISCONF['SIS']['RESERVA_MULTIMEIOS']['HOST'] = "/abertura.php?menu[]=6&menu[]=1#Multimeios";

$SISCONF['SIS']['CRYPT_ANT'] = "/netdb/www/intranet/criptAnt.exe";   #criado por rudinei em 31/08/2004
$SISCONF['SIS']['BASE'] = "/netdb/www/intranet/";             #criado por rudinei em 31/08/2004
$SISCONF['SIS']['HOST'] = $pathIntranet;
$SISCONF['SIS']['PATH_SGU'] = "/portal";

$SISCONF['SIS']["FOTOS_SGL"]["PATH"] =  "/netdb/www/intranet/sistemas/sgu/portal/temp/";
$SISCONF['SIS']["FOTOS_SGL"]["HOST"] = $SISCONF['SIS']['COMUM']['HOST']."/portal/temp/";


$SISCONF['SIS']['PATH_IMAGENS'] = $SISCONF['SIS']['HOST'] . $SISCONF['SIS']['PATH_SGU']."/imagens/";
$SISCONF['SIS']['PATH_IMG_CAB_PADRAO'] = $SISCONF['SIS']['HOST'] . $SISCONF['SIS']['PATH_SGU']."/modulos/temas/imagens/";
$SISCONF['SIS']['PATH_ARQ_COBRANCA_RETORNO'] = $pathIntranet."/portal/modulos/financeiro/retorno/";  #criada por JOAO 16/09/2004
$SISCONF['SIS']['PATH_ARQ_COBRANCA_REMESSA'] = $SISCONF['SIS']['HOST'].$SISCONF['SIS']['PATH_SGU']."/modulos/financeiro/remessa/";  #criada por JOAO 28/04/2005
$SISCONF['SIS']['PATH_ARQ_LEITORA_VESTIBULAR'] = $pathIntranet."/portal/modulos/proc_selecao/respostas/";  #criada por JOAO 21/03/2005
$SISCONF['SIS']['PATH_ARQ_LEITORA_AVAL_ESCOLAS'] = $SISCONF['SIS']['HOST']."/portal/modulos/avalEscolas/respostas/";  #criada por JOAO 06/11/2006

# Configuração para emissão do relatório de gratuidade. Entra todos os lançamentos (1) ou somente os que ainda
# não foram slipados (0)
$SISCONF['SIS']['REL_GRATUIDADE']['CONSIDERA_LCTOS_SLIPADOS'] = 1;

//Seção de configuração de bancos de dados -- ALIASES --

//Configurações do DESENV (BD de teste)
$SISCONF['DB']['DESENV']['BANCO'] = 'ORACLE';
$SISCONF['DB']['DESENV']['USER_CONNECT'] = 'REQUEST';
$SISCONF['DB']['DESENV']['USUARIO'] = '';
$SISCONF['DB']['DESENV']['SENHA'] = '';
$SISCONF['DB']['DESENV']['HOST'] = '';
$SISCONF['DB']['DESENV']['SID'] = 'DESENV';
$SISCONF['DB']['DESENV']['BASE'] = '';

//Configurações do LASALLE (BD de PRODUÇÃO)
$SISCONF['DB']['LASALLE']['BANCO'] = 'ORACLE';
$SISCONF['DB']['LASALLE']['USER_CONNECT'] = 'REQUEST';
$SISCONF['DB']['LASALLE']['USUARIO'] = '';
$SISCONF['DB']['LASALLE']['SENHA'] = '';
$SISCONF['DB']['LASALLE']['HOST'] = '';
$SISCONF['DB']['LASALLE']['SID'] = $TNS_SUN;
$SISCONF['DB']['LASALLE']['BASE'] = '';

$SISCONF['DB']['CONSULTA_WEB']['BANCO'] = 'POSTGRES';
$SISCONF['DB']['CONSULTA_WEB']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['CONSULTA_WEB']['USUARIO'] = 'consultaweb';
$SISCONF['DB']['CONSULTA_WEB']['SENHA'] = 'cw2006CELyXc710h';
$SISCONF['DB']['CONSULTA_WEB']['HOST'] = '10.10.1.18';
$SISCONF['DB']['CONSULTA_WEB']['BASE'] = 'lasalle';

//Configuração de acesso aos professores do colégio para a reserva de salas
$SISCONF['DB']['INTEGRACAO_POSTGRES']['BANCO'] = 'POSTGRES';
$SISCONF['DB']['INTEGRACAO_POSTGRES']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['INTEGRACAO_POSTGRES']['USUARIO'] = 'INTEGRACAO_ORACLE';
$SISCONF['DB']['INTEGRACAO_POSTGRES']['SENHA'] = 'opgko5t03wr324';
$SISCONF['DB']['INTEGRACAO_POSTGRES']['HOST'] = '10.10.50.1';
$SISCONF['DB']['INTEGRACAO_POSTGRES']['SID'] = '';
$SISCONF['DB']['INTEGRACAO_POSTGRES']['BASE'] = 'canoas';

//Configurações do LASALLE (BD de PRODUÇÃO)
$SISCONF['DB']['SELPROF']['BANCO'] = 'ORACLE';
$SISCONF['DB']['SELPROF']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['SELPROF']['USUARIO'] = 'PDM7YG35TFLOS';
$SISCONF['DB']['SELPROF']['SENHA'] = 'xpo390idpo490kpwep3';
$SISCONF['DB']['SELPROF']['HOST'] = '';
$SISCONF['DB']['SELPROF']['SID'] = $TNS_SUN;
$SISCONF['DB']['SELPROF']['BASE'] = '';

$SISCONF['DB']['PORTAL_ACAD']['BANCO'] = 'ORACLE';
$SISCONF['DB']['PORTAL_ACAD']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['PORTAL_ACAD']['USUARIO'] = 'bro74cujah';
//$SISCONF['DB']['PORTAL_ACAD']['SENHA'] = 'xpod2o09fj20j1kla';//Produção
$SISCONF['DB']['PORTAL_ACAD']['SENHA'] = 'pq4nnjkfs8939hio';//Desenv
$SISCONF['DB']['PORTAL_ACAD']['HOST'] = '';
$SISCONF['DB']['PORTAL_ACAD']['SID'] = $TNS_SUN;
$SISCONF['DB']['PORTAL_ACAD']['BASE'] = '';

$SISCONF['DB']['PORTAL_COL']['BANCO'] = 'ORACLE';
$SISCONF['DB']['PORTAL_COL']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['PORTAL_COL']['USUARIO'] = 'bro74cujah';
$SISCONF['DB']['PORTAL_COL']['SENHA'] = 'xpod2o09fj20j1kla';
$SISCONF['DB']['PORTAL_COL']['HOST'] = '';
$SISCONF['DB']['PORTAL_COL']['SID'] = $TNS_SUN;
$SISCONF['DB']['PORTAL_COL']['BASE'] = '';

$SISCONF['DB']['PORTAL_ACAD_DESENV']['BANCO'] = 'ORACLE';
$SISCONF['DB']['PORTAL_ACAD_DESENV']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['PORTAL_ACAD_DESENV']['USUARIO'] = 'bro74cujah';
$SISCONF['DB']['PORTAL_ACAD_DESENV']['SENHA'] = 'pq4nnjkfs8939hio';
$SISCONF['DB']['PORTAL_ACAD_DESENV']['HOST'] = '';
$SISCONF['DB']['PORTAL_ACAD_DESENV']['SID'] = 'DESENV';
$SISCONF['DB']['PORTAL_ACAD_DESENV']['BASE'] = '';

//Configurações do DESENV (BD de teste)
$SISCONF['DB']['SIMULADO-LASALLE']['BANCO'] = 'ORACLE';
$SISCONF['DB']['SIMULADO-LASALLE']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['SIMULADO-LASALLE']['USUARIO'] = 'INSCR_SIM';
$SISCONF['DB']['SIMULADO-LASALLE']['SENHA'] = 'po29k0fakkxp2';
$SISCONF['DB']['SIMULADO-LASALLE']['HOST'] = '';
$SISCONF['DB']['SIMULADO-LASALLE']['SID'] = $TNS_SUN;
$SISCONF['DB']['SIMULADO-LASALLE']['BASE'] = '';

//Configurações do LASALLE (BD de PRODUÇÃO)
$SISCONF['DB']['CONS']['BANCO'] = 'ORACLE';
$SISCONF['DB']['CONS']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['CONS']['USUARIO'] = 'PHP';
$SISCONF['DB']['CONS']['SENHA'] = 'pxos8akxpa1ksx3kk3';
$SISCONF['DB']['CONS']['HOST'] = '';
$SISCONF['DB']['CONS']['SID'] = 'SUN';
$SISCONF['DB']['CONS']['SID'] = $TNS_SUN;
$SISCONF['DB']['CONS']['BASE'] = '';

//Configurações do contador de acesso (BD de PRODUÇÃO)
$SISCONF['DB']['WEBACCESS']['BANCO'] = 'ORACLE';
$SISCONF['DB']['WEBACCESS']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['WEBACCESS']['USUARIO'] = 'webaccess';
$SISCONF['DB']['WEBACCESS']['SENHA'] = 'kop239j0jdjoalfwe';
$SISCONF['DB']['WEBACCESS']['HOST'] = '';
$SISCONF['DB']['WEBACCESS']['SID'] = $TNS_SUN;
$SISCONF['DB']['WEBACCESS']['BASE'] = '';

//Configurações do BD de INTERNET - DBINT (BD de PRODUÇÃO)
$SISCONF['DB']['SUN_MY_INTERNET']['BANCO'] = 'MYSQL';
$SISCONF['DB']['SUN_MY_INTERNET']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['SUN_MY_INTERNET']['USUARIO'] = 'intranet';
$SISCONF['DB']['SUN_MY_INTERNET']['SENHA'] = 'oap1o@uak!0)ksm';
$SISCONF['DB']['SUN_MY_INTERNET']['HOST'] = '10.10.1.28';
$SISCONF['DB']['SUN_MY_INTERNET']['BASE'] = 'internet';

//Configurações do PARSER de BD para Matrizes
$SISCONF['DB']['MATRIX']['BANCO'] = 'MATRIX';
$SISCONF['DB']['MATRIX']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['MATRIX']['USUARIO'] = 'x';
$SISCONF['DB']['MATRIX']['SENHA'] = 'x';
$SISCONF['DB']['MATRIX']['HOST'] = 'x';
$SISCONF['DB']['MATRIX']['BASE'] = 'x';
$SISCONF['DB']['MATRIX']['SID'] = 'x';

//Configurações do BD LOGs do SISTEMA (Oracle)
$SISCONF['DB']['LOG']['BANCO'] = 'ORACLE';
$SISCONF['DB']['LOG']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['LOG']['USUARIO'] = 'webaccess';
$SISCONF['DB']['LOG']['SENHA'] = 'JSHABNA872QACESS';
$SISCONF['DB']['LOG']['HOST'] = '';
$SISCONF['DB']['LOG']['SID'] = $TNS_SUN;
$SISCONF['DB']['LOG']['BASE'] = '';

$SISCONF['DB']['POSTGRES']['BANCO'] = 'POSTGRES';
$SISCONF['DB']['POSTGRES']['USER_CONNECT'] = 'REQUEST';
$SISCONF['DB']['POSTGRES']['USUARIO'] = '';
$SISCONF['DB']['POSTGRES']['SENHA'] = '';
$SISCONF['DB']['POSTGRES']['HOST'] = '10.10.50.1';
$SISCONF['DB']['POSTGRES']['BASE'] = 'canoas';

$SISCONF['DB']['POSTGRES_WEB']['BANCO'] = 'POSTGRES';
$SISCONF['DB']['POSTGRES_WEB']['USER_CONNECT'] = 'DEFAULT';
$SISCONF['DB']['POSTGRES_WEB']['USUARIO'] = 'consultaweb';
$SISCONF['DB']['POSTGRES_WEB']['SENHA'] = 'cw2006celyxc710h';
$SISCONF['DB']['POSTGRES_WEB']['HOST'] = "10.10.50.1";
$SISCONF['DB']['POSTGRES_WEB']['BASE'] = 'lasalle';

//Configuração do PATH padrão para os relatórios .PDF
$SISCONF['SIS']['RELATORIO_PDF']['PATH'] = $caminhoLocal.'/portal/modulos/relatorios/';
$SISCONF['SIS']['RELATORIO_PDF']['HOST'] = $host.'/portal/modulos/relatorios/';

//Configuração do PATH padrão para os relatórios .PDF do mestrado
$SISCONF['MESTRADO']['RELATORIO_PDF']['PATH'] = $caminhoLocal."/mestrado/relatorios/";
$SISCONF['MESTRADO']['RELATORIO_PDF']['HOST'] = 'http://www.unilasalle.edu.br/canoas/inscrmestrado/relatorios/';
$SISCONF['MESTRADO']['PATH_IMAGENS'] = $caminhoLocal.'/mestrado/imagens/';


//Configuração de retorno do gerador de relatórios p/menu principal
$SISCONF['SIS']['GERADOR']['HOST'] = "/portal/abertura.php?menu=5&submenu=1#Cadastros";

//Configuração do PATH padrão para os relatórios .PDF do Portal dos professores

//Configuração do PATH padrão dos arquivos chave do PORTAL SGU
$SISCONF['PORTAL']['PATH'] = '/portal';
$SISCONF['PORTAL']['HOST'] = $SISCONF['SIS']['COMUM']['HOST'].$SISCONF['PORTAL']['PATH'];
$SISCONF['PORTAL']['MAIN'] = 'portal.php';

//Configuração do PATH padrão dos arquivos chave do PORTAL dos Professores
$SISCONF['PORTAL_PROF']['HOST'] = $host."/portalprof/";
$SISCONF['PORTAL_PROF']['PATH'] =  $caminhoLocal."/portalprof";
$SISCONF['PORTAL_PROF']['MAIN'] = 'portal.php';
$SISCONF['PORTAL_PROF']['HOST_IMG'] =  $SISCONF['PORTAL_PROF']['HOST'].'imagens/';
$SISCONF['PORTAL_PROF']['HOST_STYLO'] = $SISCONF['PORTAL_PROF']['HOST']."config/styloSGU.css";
$SISCONF['PORTAL_PROF']['STYLO'] = $SISCONF['PORTAL_PROF']['HOST']."config/";
$SISCONF['PORTAL_PROF']['PATH_FOTOS'] = $SISCONF['PORTAL_PROF']['PATH'].'/temp';
$SISCONF['PORTAL_PROF']['HOST_FOTOS'] = $SISCONF['PORTAL_PROF']['HOST'].'/temp/';
$SISCONF['PORTAL_PROF']['PATH_DIRETORIO'] = '/temp/';
//configurações do editor innova e do efeito greybox
$SISCONF['PORTAL_PROF']['PATH_EDITOR_INNOVA'] = $SISCONF['PORTAL_PROF']['HOST']."editors/editor/";
$SISCONF['PORTAL_PROF']['SCRIPT']['GREYBOX'] = $SISCONF['PORTAL_PROF']['HOST']."script/greybox/greybox/";
$SISCONF['PORTAL_PROF']['SCRIPT']['JS'] = $SISCONF['PORTAL_PROF']['HOST']."script/";
$SISCONF['PORTAL_PROF']['RELATORIO_PDF']['PATH'] = $SISCONF['PORTAL_PROF']['PATH']."/pdf/";
$SISCONF['PORTAL_PROF']['RELATORIO_PDF']['HOST'] = $host;

//$SISCONF['PORTAL_ACAD']['HOST'] = "http://10.10.1.28:31/";
$SISCONF['PORTAL_ACAD']['HOST'] = $host."/portalAcad/";
$SISCONF['PORTAL_ACAD']['PATH'] =  $caminhoLocal."/academicos/";
$SISCONF['PORTAL_ACAD']['MAIN'] = 'portal.php';
$SISCONF['PORTAL_ACAD']['PATH_IMG'] =  $SISCONF['PORTAL_ACAD']['PATH'].'imagens/';
$SISCONF['PORTAL_ACAD']['HOST_IMG'] =  $SISCONF['PORTAL_ACAD']['HOST'].'imagens/';
$SISCONF['PORTAL_ACAD']['HOST_STYLO'] = $SISCONF['PORTAL_ACAD']['HOST']."config/styloSGU.css";
$SISCONF['PORTAL_ACAD']['STYLO'] = $SISCONF['PORTAL_ACAD']['HOST']."config/";
$SISCONF['PORTAL_ACAD']['PATH_FOTOS'] = $SISCONF['PORTAL_ACAD']['PATH']."temp/";
$SISCONF['PORTAL_ACAD']['HOST_FOTOS'] = $SISCONF['PORTAL_ACAD']['HOST'].'temp/';
$SISCONF['PORTAL_ACAD']['HOST_FONTES'] = $SISCONF['PORTAL_ACAD']['HOST'].'fonts';
$SISCONF['PORTAL_ACAD']['RELATORIO_PDF']['PATH'] = $SISCONF['PORTAL_ACAD']['PATH']."pdf/";
$SISCONF['PORTAL_ACAD']['RELATORIO_PDF']['HOST'] = $SISCONF['PORTAL_ACAD']['HOST']."pdf/";

$SISCONF['PORTAL_COL']['HOST'] = 'https://alunos.colegiolasalle.com.br/';
$SISCONF['PORTAL_COL']['MAIN'] = 'portal.php';
$SISCONF['PORTAL_COL']['HOST_IMG'] =  $SISCONF['PORTAL_COL']['HOST'].'imagens/';
$SISCONF['PORTAL_COL']['HOST_STYLO'] = $SISCONF['PORTAL_COL']['HOST']."config/styloSGU.css";
$SISCONF['PORTAL_COL']['STYLO'] = $SISCONF['PORTAL_COL']['HOST']."config/";

/** criado por diegom em 02/10/2006 */
$SISCONF['CONSULTA_WEB']['HOST'] = 'https://www.lasalle.edu.br/portalalunos/';
$SISCONF['CONSULTA_WEB']['HOST_ADMIN'] = 'https://www.lasalle.edu.br/portalalunos/admin/';
$SISCONF['CONSULTA_WEB']['HOST_LOCAL'] = '/netdb/www/internet/portal.lasalle.edu.br/portalalunos/';
$SISCONF['CONSULTA_WEB']['MAIN'] = 'portal.php';
$SISCONF['CONSULTA_WEB']['HOST_IMG'] = $SISCONF['CONSULTA_WEB']['HOST'].'imagens/';
$SISCONF['CONSULTA_WEB']['HOST_FOTOS'] =  $SISCONF['CONSULTA_WEB']['HOST'].'fotos/';
$SISCONF['CONSULTA_WEB']['HOST_LOCAL_FOTOS'] =  $SISCONF['CONSULTA_WEB']['HOST_LOCAL'].'fotos/';
$SISCONF['CONSULTA_WEB']['HOST_STYLO'] = $SISCONF['CONSULTA_WEB']['HOST']."config/styloSGU.css";
$SISCONF['CONSULTA_WEB']['STYLO'] = $SISCONF['CONSULTA_WEB']['HOST']."config/";
$SISCONF['CONSULTA_WEB']['MODULOS'] = $SISCONF['CONSULTA_WEB']['HOST']."modulos/";
$SISCONF['CONSULTA_WEB']['MODULOS_ADMIN'] = $SISCONF['CONSULTA_WEB']['HOST_ADMIN']."modulos/";



$SISCONF['PORTAL_EVENTOS']['HOST'] = 'http://www.unilasalle.edu.br/canoas/inscricoes/eventos/';
$SISCONF['PORTAL_EVENTOS']['PATH'] =  '/usr/local/apache2/htdocs/eventos/';
$SISCONF['PORTAL_EVENTOS']['MAIN'] = 'portal.php';
$SISCONF['PORTAL_EVENTOS']['HOST_IMG']   = $SISCONF['PORTAL_EVENTOS']['HOST'].'imagens/';
$SISCONF['PORTAL_EVENTOS']['PATH_IMG']   = $SISCONF['PORTAL_EVENTOS']['PATH'].'imagens/';
$SISCONF['PORTAL_EVENTOS']['HOST_STYLO'] = $SISCONF['PORTAL_EVENTOS']['HOST']."config/styles.css";
$SISCONF['PORTAL_EVENTOS']['STYLO']      = $SISCONF['PORTAL_EVENTOS']['HOST']."config/";
$SISCONF['PORTAL_EVENTOS']['PATH_FOTOS'] = $SISCONF['PORTAL_EVENTOS']['PATH'].'/temp/';
$SISCONF['PORTAL_EVENTOS']['HOST_FOTOS'] = $SISCONF['PORTAL_EVENTOS']['HOST'].'/temp/';
$SISCONF['PORTAL_EVENTOS']['PATH_DIRETORIO'] = '/temp/';

// $SISCONF['SIS']['DEBUG'] = false;
// $SISCONF['SIS']['DEBUG_IP'] = array();
// $SISCONF['SIS']['QUERIES'] = array();
// $SISCONF['SIS']['EVENTS'] = array();

//require_once $SISCONF['SIS']['COMUM']['SESSAO']."debug_function.inc";

//Não é classe, somente função
function memorizeQuery($query = ''){
    GLOBAL $SISCONF;
    //Comentada a instrução abaixo para otimização do uso de memória do servidor de produção
    array_push($SISCONF['SIS']['QUERIES'],$query);
}


// $SISCONF['SIS']['DEBUG_IP'] = array();
// $SISCONF['SIS']['DEBUG_IP'][] = '10.10.1.205';	// joão
// $SISCONF['SIS']['DEBUG_IP'][] = '10.10.1.212';	// cristofer
// $SISCONF['SIS']['DEBUG_IP'][] = '10.10.1.214';	// eduardo
// $SISCONF['SIS']['DEBUG_IP'][] = '10.10.1.229';	// alexsandro correa
// $SISCONF['SIS']['DEBUG_IP'][] = '10.10.1.213';	// tiago martins
/*
	$SISCONF['SIS']['DEBUG_IP'][] = '10.10.1.215';
	$SISCONF['SIS']['DEBUG_IP'][] = '10.10.1.216';
	$SISCONF['SIS']['DEBUG_IP'][] = '10.10.2.101';
	$SISCONF['SIS']['DEBUG_IP'][] = '10.10.1.218';
	$SISCONF['SIS']['DEBUG_IP'][] = '10.10.3.56';
	$SISCONF['SIS']['DEBUG_IP'][] = '10.10.1.231';
	$SISCONF['SIS']['DEBUG_IP'][] = '10.10.1.108';
*/

// function isLocked(){
    // GLOBAL $SISCONF;
    // $ret = false;
    // for ($d=0; $d < count($SISCONF['SIS']['DEBUG_IP']); $d++){
        // if ( isset($SISCONF['SIS']['DEBUG_IP'][$d]) ) {
            // if ($SISCONF['SESSAO']['USUARIO']['IP'] == $SISCONF['SIS']['DEBUG_IP'][$d]) {
                // $ret = true;
            // }
        // }
    // }
    // return $ret;
// }

function isDeveloper(){
    GLOBAL $SISCONF;
    $ret = false;

    for ($d=0; $d < count($SISCONF['SIS']['DEBUG_IP']); $d++){
        if ($SISCONF['SESSAO']['USUARIO']['IP'] == $SISCONF['SIS']['DEBUG_IP'][$d]) {
            $ret = true;
        }
    }
    return $ret;
}

/**
 * Só exibe um DUMP de uma variável passada
 * Adicionada por diegom em 09/03/2006
 */
// function dump($variavel,$info="",$cor='magenta'){
    // if ( isLocked() ){
        // if (trim($info)!="") {
            // echo "<br><font color='".$cor."'>Exibindo ".$info."</font>";
        // }

        // if (is_array($variavel)) {
            // echo "<pre>";
            // print_r($variavel);
            // echo "</pre>";
        // } else {
            // echo "<pre>";
            // echo $variavel;
            // echo "</pre>";
        // }
    // }
// }

// require_once "comum/util/debug.class";

#COMENTARIO

//$SISCONF['DEBUG'] = new ext_debug_class();

?>
