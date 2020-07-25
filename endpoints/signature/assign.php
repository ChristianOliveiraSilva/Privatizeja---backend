<?php
namespace endpoint;

// APENAS TEMPORARIO
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once '../tools/class.endpoint.php';
require_once '../tools/class.sqlhelper.inc';

use privatizeja\endpoint\Endpoint;

/**
 * Classe para fazer uma assinatura
 */
class AssignEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $id_company = $this->getSanitalizedResquest('id_company');
        $id_user_account = $this->getIdLoggedUser(); ######################MOCADO####################

        $stmt = $this->execute("INSERT INTO signature VALUES(default, :id_user_account, :id_company, NOW())", [
            'id_user_account' => $id_user_account,
            'id_company' => $id_company
        ]);
        $this->addResponse('saved','true');
    }
}
(new AssignEndpoint);
