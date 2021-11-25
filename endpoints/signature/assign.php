<?php
namespace endpoint;



use privatizeja\endpoint\Endpoint;

/**
 * Classe para fazer uma assinatura
 */
class AssignEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $id_user_account = $this->getIdLoggedUserOrDie();
        $id_company = $this->getSanitalizedResquest('id_company');

        $stmt = $this->execute("INSERT INTO signature VALUES(default, :id_user_account, :id_company, NOW())", [
            'id_user_account' => $id_user_account,
            'id_company' => $id_company
        ]);
        $this->addResponse('saved','true');
    }
}
(new AssignEndpoint);
