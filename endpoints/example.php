<?php
namespace endpoint;

// APENAS TEMPORARIO
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once 'tools/class.endpoint.php';
require_once 'tools/class.sqlhelper.inc';

use privatizeja\endpoint\Endpoint;
use privatizeja\SqlHelper\SqlHelper;

/**
 * Classe de resposta de exemplo
 */
class ExampleEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $this->addResponse('sessao',$_SESSION);
        $this->addResponse('id do user',$this->getIdLoggedUserOrDie());
    }
}
(new ExampleEndpoint);
