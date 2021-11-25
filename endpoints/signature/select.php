<?php
namespace endpoint;

use MicroPHPAnswerer\Tools\Endpoint;
use MicroPHPAnswerer\Tools\Helpers\SqlHelper;

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
