<?php
namespace privatizeja\ParamCleaner;

/**
 * Classe responsavel por tratar os parametros da requisição
 */
class ParamCleaner
{
    /*
     * Função que valida os dados
     * @param string $request
     * @param string $flag
     * @return bool
     */
    public function validate(string $request, string $flag) :bool
    {
        return empty(trim($request));
    }

    /*
     * Função que limpa os dados
     * @param $request
     * @param $flag
     * @return string
     */
    public function sanitalize(string $request, string $flag = 'FILTER_SANITIZE_STRING') :string
    {
        return $request;
    }
}
