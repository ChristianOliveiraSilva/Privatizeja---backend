<?php
namespace endpoint;

require_once '../vendor/autoload.php';

use MicroPHPAnswerer\Tools\Endpoint;

/**
 * Classe de resposta de exemplo
 */
class ExampleEndpoint extends Endpoint
{
    function __construct()
    {
        parent::__construct();
        $this->addResponse('teste', 'teste');
    }
}
(new ExampleEndpoint);
