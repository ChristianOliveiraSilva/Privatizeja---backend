<?php
namespace privatizeja\Response;

/**
 * Classe responsavel por definir uma resposta a requisição
 */
class Response
{
    /*
     * Array com as respostas
     * @var
     */
    private $response;

    function __construct()
    {
        $this->setResponse(['status' => '200']);
    }
    /*
     * Metodo resposanvel por trasnformar o array em string
     * No caso, a regra de negocio é json
     * @return string
     */
    public function answer() :string
    {
        return json_encode($this->getResponse());
    }

    /*
     * Setter de $response
     * @param $response
     * @return void
     */
    public function setResponse(array $response) :void
    {
        $this->response = $response;
    }

    /*
     * Getter de Response
     * @return array
     */
    public function getResponse() :array
    {
        return $this->response;
    }

    /*
     * Getter de addItem
     * @param string $key
     * @param string | array $value
     * @return void
     */
    public function addItem(string $key, $value) :void
    {
        $this->response = array_merge($this->response, [$key => $value]);
    }
}
