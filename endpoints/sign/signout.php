<?php
namespace endpoint;




use privatizeja\endpoint\Endpoint;
use privatizeja\SqlHelper\SqlHelper;

/**
 * Classe de Log out
 */
class SignOutEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $this->destroyAllSession();
    }
}
(new SignOutEndpoint);
