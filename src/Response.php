<?php

/**
* Classe Response, representa uma resposta a uma requisição
*/
class Response
{

  private $responseCode;
  private $responseBody;

  function __construct($curl)
  {
    // Executa o Curl para obter os dados do objeto
    $this->responseBody = curl_exec($curl);
    $err = curl_error($curl);
    if($err) {
      $this->responseBody = $err;
    }
    $this->responseCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
  }

  public function getResponseBody() {
    return $this->responseBody;
  }

  public function getResponseCode() {
    return $this->responseCode;
  }

}



?>
