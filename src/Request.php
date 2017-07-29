<?php

require_once('Credentials.php');
require_once('Response.php');

/**
* Classe responsável por realizar os envios das requisições
*/
abstract class Request
{

  /**
   * Método base para realizar uma requisição
   *
   * @param string $method - Método da requisição, ex. POST, GET, PUT, DELETE, PATCH.
   * @param string $url - URL para qual será realizada a request.
   * @param mixed $data - Uma array ou string contendo a informação a ser enviada na requisição.
   * @param Credentials $credentials - Objeto de credenciais caso precise realizar autenticação básica - Default null;
   * @param array $aditionalHeaders - Cabeçalhos adicionais que podem ser passados - Default []
   * @return Response $response - Objeto Response da requisição realizada.
   */
  protected function doRequest($method, $url, $data = null, Credentials $credentials = null, $aditionalHeaders = array()) {

    // Definindo o cabeçalho
    $headers = array();

    if($credentials) {
      array_push($headers, $credentials->getBasicAuthHeaderString());
    }

    $newHeaders = array_merge($headers, $aditionalHeaders);

    // Iniciando o CURL
    $curl = curl_init();

    // Definindo a maior parte das propriedades.
    curl_setopt_array($curl, array(
      CURLOPT_URL => $url,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $method,
      CURLOPT_HTTPHEADER => $newHeaders
    ));

    // Adicionando as informações caso hajam
    if($data) {
      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }

    // Executando o CURL
    $response = new Response($curl);

    // Encerrando o CURL
    curl_close($curl);

    // Retornando a resposta
    return $response;
  }

  /**
  * Um Wrapper do doRequest para o metodo PUT
  *
  * @param string $url - A URL que deve receber a request.
  * @param mixed $data - uma URL encoded ou uma Array com as informações para serem enviadas.
  * @param Credentials $credentials - Objeto de credenciais caso precise realizar autenticação básica - Default null;
  * @param array $aditionalHeaders - Cabeçalhos adicionais que podem ser passados - Default []
  * @return Response $response - Objeto Response da requisição realizada.
  */
  protected function doPutRequest($url, $data, Credentials $credentials = null, $aditionalHeaders = array()) {
    $response = $this->doRequest("PUT", $url, $data, $credentials, $aditionalHeaders);
    return $response;
  }

  /**
  * Um Wrapper do doRequest para o metodo POST
  *
  * @param string $url - A URL que deve receber a request.
  * @param mixed $data - uma URL encoded ou uma Array com as informações para serem enviadas.
  * @param Credentials $credentials - Objeto de credenciais caso precise realizar autenticação básica - Default null;
  * @param array $aditionalHeaders - Cabeçalhos adicionais que podem ser passados - Default []
  * @return Response $response - Objeto Response da requisição realizada.
  */
  protected function doPostRequest($url, $data, Credentials $credentials = null, $aditionalHeaders = array()) {
    $response = $this->doRequest("POST", $url, $data, $credentials, $aditionalHeaders);
    return $response;
  }

  /**
  * Um Wrapper do doRequest para o metodo GET
  *
  * @param string $url - A URL que deve receber a request.
  * @param Credentials $credentials - Objeto de credenciais caso precise realizar autenticação básica - Default null;
  * @param array $aditionalHeaders - Cabeçalhos adicionais que podem ser passados - Default []
  * @return Response $response - Objeto Response da requisição realizada.
  */
  protected function doGetRequest($url, Credentials $credentials = null, $aditionalHeaders = array()) {
    $response = $this->doRequest("GET", $url, null, $credentials, $aditionalHeaders);
    return $response;
  }

  /**
  * Um Wrapper do doRequest para o metodo DELETE
  *
  * @param string $url - A URL que deve receber a request.
  * @param Credentials $credentials - Objeto de credenciais caso precise realizar autenticação básica - Default null;
  * @param array $aditionalHeaders - Cabeçalhos adicionais que podem ser passados - Default []
  * @return Response $response - Objeto Response da requisição realizada.
  */
  protected function doDeleteRequest($url, Credentials $credentials = null, $aditionalHeaders = array()) {
    $response = $this->doRequest("DELETE", $url, null, $credentials, $aditionalHeaders);
    return $response;
  }

}




?>
