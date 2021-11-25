<?php
namespace endpoint;
require_once '../tools/class.endpoint.php';
require_once '../tools/class.sqlhelper.inc';

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
        $this->addResponse('sessao', $_SESSION);
        $this->addResponse('id do user', 'teste asdasdsadsasadsa');
    }
}
(new ExampleEndpoint);
