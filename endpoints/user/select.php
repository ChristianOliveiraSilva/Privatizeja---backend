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
 * Classe de resposta de exemplo
 */
class SelectUsersEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $id = $this->getSanitalizedResquest('id');
        $stmt = $this->execute("select * from user_account where id = :id", ['id' => $id]);
        $this->addResponse('users', SqlHelper::createArrayFromSQLReturn($stmt));
    }
}
(new SelectUsersEndpoint);
