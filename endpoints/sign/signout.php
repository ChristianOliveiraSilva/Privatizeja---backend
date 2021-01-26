<?php
namespace endpoint;

require_once '../../tools/class.endpoint.php';
require_once '../../tools/class.sqlhelper.inc';

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
