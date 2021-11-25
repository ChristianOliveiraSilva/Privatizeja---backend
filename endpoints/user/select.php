<?php
namespace endpoint;



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
        $this->addResponse('user', SqlHelper::createArrayFromSQLReturn($stmt));
    }
}
(new SelectUsersEndpoint);
