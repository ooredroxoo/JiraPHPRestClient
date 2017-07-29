<?php

/**
* Classe que lida com as credenciais necessárias para o JIRA.
*/
class Credentials
{

  private $username;
  private $password;

  function __construct($username, $password)
  {
    $this->username = $username;
    $this->password = $password;
  }

  public function getBasicAuthHeaderString() {
    return 'Authorization: Basic '. base64_encode($this->username . ':' . $this->password);
  }

}


?>
