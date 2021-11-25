<?php
namespace endpoint;



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
