<?php
namespace endpoint;



use privatizeja\endpoint\Endpoint;
use privatizeja\SqlHelper\SqlHelper;

/**
 * Classe de resposta de exemplo
 */
class SelectAllCompaniesEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $stmt = $this->execute("select * from company");
        $this->addResponse('companies', SqlHelper::createArrayFromSQLReturn($stmt));
    }
}
(new SelectAllCompaniesEndpoint);
