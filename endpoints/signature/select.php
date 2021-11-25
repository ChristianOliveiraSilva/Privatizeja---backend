<?php
namespace endpoint;



use privatizeja\endpoint\Endpoint;
use privatizeja\SqlHelper\SqlHelper;

/**
 * Classe selecionar assinaturas
 */
class SelectSignatureEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $result = SqlHelper::createSQLwithMultiCondition("SELECT * FROM signature", ['id', 'id_user_account', 'id_company']);
        $stmt = $this->execute($result['sql'], $result['bind']);
        $this->addResponse('signature', SqlHelper::createArrayFromSQLReturn($stmt));
    }
}
(new SelectSignatureEndpoint);
