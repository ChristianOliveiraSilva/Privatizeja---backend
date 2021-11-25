<?php
namespace endpoint;



use privatizeja\endpoint\Endpoint;
use privatizeja\SqlHelper\SqlHelper;

/**
 * Classe de resposta de exemplo
 */
class SelectCompaniesEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $id = $this->getSanitalizedResquest('id');
        $stmt = $this->execute("select * from company where id = :id", ['id' => $id]);
        $this->addResponse('company', SqlHelper::createArrayFromSQLReturn($stmt));
    }
}
(new SelectCompaniesEndpoint);
