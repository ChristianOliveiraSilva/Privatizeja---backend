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
 * Classe de resposta de exemplo
 */
class SelectAllUsersEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $stmt = $this->execute("select * from user_account");
        $this->addResponse('users', SqlHelper::createArrayFromSQLReturn($stmt));
    }
}
(new SelectAllUsersEndpoint);
