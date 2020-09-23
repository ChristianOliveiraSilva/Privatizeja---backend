<?php
namespace endpoint;

// APENAS TEMPORARIO
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../tools/class.endpoint.php';
require_once '../tools/class.sqlhelper.inc';

use privatizeja\endpoint\Endpoint;
use privatizeja\SqlHelper\SqlHelper;

/**
 * Classe de cadastro
 */
class SignUpEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $email = $this->getSanitalizedResquest('email','FILTER_SANITIZE_EMAIL');
        $name = $this->getSanitalizedResquest('name');
        $login = $this->getSanitalizedResquest('login');
        $password = $this->getSanitalizedResquest('password'); # CRIPTOGRAFIAR ISSO
        $cpf = $this->getSanitalizedResquest('cpf'); #validar CPF

        $stmt = $this->execute("insert into user_account values(default, :name, :email, :login, :password, :cpf)",[
            'name' => $name,
            'email' => $email,
            'login' => $login,
            'password' => $password,
            'cpf' => $cpf
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result !== false) {
            $this->addResponse('message', 'OK');
        } else {
            $this->addResponse('status', 400);
            $this->addResponse('Error', $stmt->errorInfo()[2]);
            http_response_code(400);
            exit();
        }
    }
}
(new SignUpEndpoint);
