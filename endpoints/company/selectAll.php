<?php
namespace endpoint;

use MicroPHPAnswerer\Tools\Endpoint;
use MicroPHPAnswerer\Tools\Helpers\SqlHelper;

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
