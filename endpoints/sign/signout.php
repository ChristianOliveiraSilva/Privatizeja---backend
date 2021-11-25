<?php
namespace endpoint;

use MicroPHPAnswerer\Tools\Endpoint;
use MicroPHPAnswerer\Tools\Helpers\SqlHelper;

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
