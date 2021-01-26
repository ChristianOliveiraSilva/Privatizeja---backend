<?php
namespace endpoint;

// APENAS TEMPORARIO
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../../tools/class.endpoint.php';
require_once '../../tools/class.sqlhelper.inc';

use privatizeja\endpoint\Endpoint;
use privatizeja\SqlHelper\SqlHelper;

/**
 * Classe de Logar no sistema
 */
class SignInEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $email = $this->getSanitalizedResquest('email','FILTER_SANITIZE_EMAIL',false);
        $login = $this->getSanitalizedResquest('login','FILTER_SANITIZE_STRING',false);
        $password = $this->getSanitalizedResquest('password');

        if (empty($email) && empty($login)) {
            $this->setResponse(new Response);
            $this->addResponse('Error', 'Email and Login is absent');
            $this->addResponse('status', 400);
            http_response_code(400);
            exit();
        }

        $stmt = $this->execute("select * from user_account where (email = :email or login = :login) and password = :password limit 1", [
            'email' => $email,
            'login' => $login,
            'password' => $password
        ]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result) {
            $this->createJWTAndSetInSession(['id' => $result['id']]);
            $this->addResponse('message', 'OK');
        } else {
            $this->addResponse('Error', 'User was not found');
            $this->addResponse('status', 401);
        }

    }
}
(new SignInEndpoint);
