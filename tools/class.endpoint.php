<?php
namespace privatizeja\Endpoint;

require_once 'class.paramCleaner.php';
require_once 'class.response.php';
require_once 'class.connection.php';
require_once 'class.JWT.php';
require_once 'class.sessionManager.php';

use privatizeja\ParamCleaner\ParamCleaner;
use privatizeja\Response\Response;
use privatizeja\Connection\Connection;
use privatizeja\JWTParser\JWTParser;
use privatizeja\SessionManager\SessionManager;

/**
 * Classe responsavel por criar os endpoints
 */
class Endpoint
{

    /*
     * Objeto responsavel por manipular a sessao
     * @var sessionManager
     */
    private $sessionManager;

    /*
     * Objeto responsavel por tratar os parametros da requisição
     * @var ParamCleaner
     */
    private $paramCleaner;

    /*
     * Objeto responsavel por criar a resposta da requisição
     * @var Response
     */
    private $response;

    /*
     * Objeto responsavel por criar a resposta da requisição
     * @var Response
     */
    private $connection;

    /*
     * Constante para evitar login's durante testes
     * @var Response
     */
    const isDev = true;

    /*
     * Construtor
     * @param bool $validateJWT Validar o JWT da requisição
     */
    function __construct($validateJWT = true)
    {
        header("Content-type: application/json");

        // Validações na requsição
        $this->ignoreRequestMethodIfNotPost();
        $this->sessionManager = new SessionManager;
        if ($validateJWT)
            $this->validateJWTOrDie();

        $this->paramCleaner = new ParamCleaner;
        $this->response = new Response;
        $this->connection = new Connection;
        register_shutdown_function(array($this, 'answerRequest'));
    }

    /*
     * Mata a execução se não for POST
     * @param $paramCleaner
     * @return void
     */
    private function ignoreRequestMethodIfNotPost() :void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !Endpoint::isDev) {
            echo json_encode(['alert' => 'REQUEST METHOD is not POST']);
            exit();
        }
    }

    /*
     * Valida o JWT e mata caso não exista
     * @return void
     */
    private function validateJWTOrDie() :void
    {
        if ($this->hasInSession('JWT') && JWTParser::isValid($_SESSION['JWT']) && !Endpoint::isDev) {
            echo json_encode(['alert' => 'JWT was not sent']);
            exit();
        }
    }

    /*
     * Setter de SessionManager
     * Não existe um setter de session manager
     * Devido a sessao ser iniciada apenas uma vez
     * Não se deve construir mais que uma vez
     */

    /*
     * Getter de SessionManager
     * @return SessionManager
     */
    public function getSessionManager() :SessionManager
    {
        return $this->sessionManager;
    }

    /*
     * Verifica se existe na sessao
     * @param string $key Chave da Sessão
     * @return bool
     */
    public function hasInSession(string $key) :bool
    {
        return $this->getSessionManager()->has($key);
    }

    /*
     * Pega o valor na Sessão
     * @param string $key Chave da Sessão
     * @return string
     */
    public function getInSession(string $key) :string
    {
        return $this->getSessionManager()->get($key);
    }

    /*
     * Seta o valor na sessão
     * @param string $key Chave da Sessão
     * @return void
     */
    public function setInSession(string $key, string $value) :void
    {
        $this->getSessionManager()->set($key, $value);
    }

    /*
     * Destroi um valor na sessão
     * @param string $key Chave da Sessão
     * @return void
     */
    public function destroyInSession(string $key) :void
    {
        $this->getSessionManager()->destroy($key);
    }

    /*
     * Destroi todos os valores na sessão
     * @return void
     */
    public function destroyAllSession() :void
    {
        $this->getSessionManager()->destroyAll();
    }

    /*
     * Setter de paramCleaner
     * @param $paramCleaner
     * @return void
     */
    public function setParamCleaner(ParamCleaner $paramCleaner) :void
    {
        $this->paramCleaner = $paramCleaner;
    }

    /*
     * Getter de ParamCleaner
     * @return ParamCleaner
     */
    public function getParamCleaner() :ParamCleaner
    {
        return $this->paramCleaner;
    }

    /*
     * Verifica se um valor é valido
     * @param $Itemresponse Chave do Item a ser inserido
     * @param $response Valor Item a ser inserido
     * @return Response
     */
    public function isValid(string $request, string $flag) :bool
    {
        return $this->getParamCleaner()->validate($request, $flag);
    }

    /*
     * Retorna um valor da request valido
     * @param string $Itemresponse Chave do Item a ser inserido
     * @param string $response Valor Item a ser inserido
     * @param boolean $isExit Se o valor não existir, matar a request
     * @return Response
     */
    public function getSanitalizedResquest(string $request, string $flag = 'FILTER_SANITIZE_STRING', bool $isExit = true) :string
    {
        if (!isset($_REQUEST[$request])) {
            if ($isExit) {
                $this->setResponse(new Response);
                $this->addResponse('status', 400);
                http_response_code(400);
                exit();
            } else {
                return "";
            }
        }

        return $this->getParamCleaner()->sanitalize($_REQUEST[$request], $flag);
    }

    /*
     * Retorna um valor da sanitalizado
     * @param $Itemresponse Chave do Item a ser inserido
     * @param $response Valor Item a ser inserido
     * @return Response
     */
    public function getSanitalizedValue(string $request, string $flag = 'FILTER_SANITIZE_STRING') :string
    {
        return $this->getParamCleaner()->sanitalize($request, $flag);
    }

    /*
     * Setter de Response
     * @param $response
     * @return void
     */
    public function setResponse(Response $response) :void
    {
        $this->response = $response;
    }

    /*
     * Getter de Response
     * @return Response
     */
    public function getResponse() : Response
    {
        return $this->response;
    }

    /*
     * Adicionar Resposta a requisição
     * @param $key Chave do Item a ser inserido
     * @param $value Valor Item a ser inserido
     * @return void
     */
    public function addResponse(string $key, $value) :void
    {
        $this->getResponse()->addItem($key, $value);
    }

    /*
     * Ser executado no final da executação como Resposta a requisição
     * @return void
     */
    public function answerRequest() :void
    {
        echo $this->getResponse()->answer();
    }

    /*
     * Setter de Connection
     * @param $connection
     * @return void
     */
    public function setConnection(Connection $connection) :void
    {
        $this->connection = $connection;
    }

    /*
     * Getter de Connection
     * @return Connection
     */
    public function getConnection() :Connection
    {
        return $this->connection;
    }

    /*
     * Executar sql
     * @return PDOStatement
     */
    public function execute(string $sql, array $bind = []) :\PDOStatement
    {
        return $this->getConnection()->execute($sql, $bind);
    }

    /*
     * Retorna o id do usuário
     * @return int|null
     */
    public function getIdLoggedUser() :?int
    {
        $values = $this->getValuesInJWT();
        return $values['id'] ?? null;
    }


    /*
     * Retorna o id do usuário ou morre
     * @return int|null
     */
    public function getIdLoggedUserOrDie() :?int
    {
        $values = $this->getValuesInJWT();

        if (isset($values['id'])) {
            return $values['id'];
        }

        $this->setResponse(new Response);
        $this->addResponse('Error', 'User is not logged');
        $this->addResponse('status', 403);
        http_response_code(403);
        exit();
    }

    /*
     * Função para criação de token e salva na sessao
     * @params array $payloadInfo array para ser mergiado com o payload
     * @params int $expiration Tempo a ser esperido o JWT
     * @return void
     */
    public function createJWTAndSetInSession(array $payloadInfo, int $expiration = 3600) :void
    {
        $this->setInSession('JWT', JWTParser::createJWT($payloadInfo, $expiration));
    }

    /*
     * Função para recuperar array do JWT
     * @params string $jwt JWT a ser validado
     * @return array
     */
    public function getValuesInJWT() :array
    {
        if ($this->hasInSession('JWT')) {
            return JWTParser::unmountJWT($_SESSION['JWT']);
        } else {
            return [];
        }
    }

}
