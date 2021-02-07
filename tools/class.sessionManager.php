<?php
namespace privatizeja\SessionManager;

/**
 * Classe responsavel por manipular a sessao
 */
class SessionManager
{

    function __construct()
    {
        if (empty(session_id()))
            session_start();
    }

    /*
     * Verifica se existe na requisição
     * @param string $key Chave da Sessão
     * @return bool
     */
    public function has(string $key) :bool
    {
        return isset($_SESSION[$key]);
    }

    /*
     * Pega o valor na Sessão
     * @param string $key Chave da Sessão
     * @return string
     */
    public function get(string $key) :string
    {
        return $_SESSION[$key] ?? '';
    }

    /*
     * Seta o valor na sessão
     * @param string $key Chave da Sessão
     * @param string $value Valor da Sessão
     * @return void
     */
    public function set(string $key, string $value) :void
    {
        $_SESSION[$key] = $value;
    }

    /*
     * Destroi um valor na sessão
     * @param string $key Chave da Sessão
     * @return void
     */
    public function destroy(string $key) :void
    {
        unset($_SESSION[$key]);
    }

    /*
     * Destroi todos os valores na sessão
     * @return void
     */
    public function destroyAll() :void
    {
        session_unset();
        session_destroy();
    }

}
