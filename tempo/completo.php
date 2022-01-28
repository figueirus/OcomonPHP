<?php

/*
 * Obtendo os dados HG Weather utilizando a funcao hg_request()
 *
 * Consulte nossa documentacao em http://hgbrasil.com/weather
 * Contato: hugodemiglio@hgbrasil.com
 * Copyright 2015 - Hugo Demiglio - @hugodemiglio
 *
*/

$chave = 'fe1132f6'; // Obtenha sua chave de API gratuitamente em http://hgbrasil.com/weather

// Resgata o IP do usuario
$ip = $_SERVER["REMOTE_ADDR"];

// !!! Descomente um dos exemplos abaixo para visualizar !!!

/* 1 - Somente por CID */
// $dados = hg_request(array(
//   'cid' => 'BRXX0198', // CID da sua cidade, encontre a sua em http://hgbrasil.com/weather
// ), $chave);

/* 2 - Por Geo IP (requer chave) */
// $dados = hg_request(array(
//   'user_ip' => $ip
// ), $chave);

/* 3 - Coordenadas GPS (requer chave) */
// $dados = hg_request(array(
//   'user_ip' => $ip,
//   'lat' => '-22.9035',
//   'lon' => '-43.2096'
// ), $chave);

/* 4 - Nome da Cidade (requer chave) */
$dados = hg_request(array(
'city_name' => 'Porto Alegre'
 ), $chave);



if(!isset($dados)) {echo 'Descomente um dos exemplos para visualizar.'; die();}

/* ================================================
 * Função para resgatar os dados da API HG Brasil
 *
 * Parametros:
 *
 * parametros: array, informe os dados que quer enviar para a API
 * chave: string, informe sua chave de acesso
 * endpoint: string, informe qual API deseja acessar, padrao weather (previsao do tempo)
 */

function hg_request($parametros, $chave = null, $endpoint = 'weather'){
  $url = 'http://api.hgbrasil.com/'.$endpoint.'/?format=json&';
  
  if(is_array($parametros)){
    // Insere a chave nos parametros
    if(!empty($chave)) $parametros = array_merge($parametros, array('key' => $chave));
    
    // Transforma os parametros em URL
    foreach($parametros as $key => $value){
      if(empty($value)) continue;
      $url .= $key.'='.urlencode($value).'&';
    }
    
    // Obtem os dados da API
    $resposta = file_get_contents(substr($url, 0, -1));
    
    return json_decode($resposta, true);
  } else {
    return false;
  }
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Previsão do Tempo - HG Weather</title>
  </head>
  <body>
    <?php echo $dados['results']['city']; ?> <?php echo $dados['results']['temp']; ?> ºC<br>
    <?php echo $dados['results']['description']; ?><br>
    Nascer do Sol: <?php echo $dados['results']['sunrise']; ?> - Pôr do Sol: <?php echo $dados['results']['sunset']; ?><br>
    Velocidade do vento: <?php echo $dados['results']['wind_speedy']; ?><br>
    <img src="imagens/<?php echo $dados['results']['img_id']; ?>.png" class="imagem-do-tempo"><br>
  </body>
</html>