<?php
namespace privatizeja\Connection;

/**
 * Classe responsavel por criar conexao com  banco de dados
 */
class Connection
{
    const DBNAME = "privatizeja";
    private $conn;

    /*
     * Construtor
     */
    function __construct()
    {
        $this->connect('localhost','postgres','postgres');
    }

    /*
     * Funcao para fazer a conexao
     * @param string $host host do banco de dados
     * @param string $user usuario do banco de dados
     * @param string $password senha do banco de dados
     * @return ParamCleaner
     */
    public function connect(string $host, string $user, string $password) :void
    {
        $database = Connection::DBNAME;
        try {
            $this->conn = new \PDO("pgsql:host=$host dbname=$database user=$user password=$password");
        } catch (\PDOException $e) {
            echo $e->getMessage();
            http_response_code(500);
            exit();
        }
    }

    /*
     * Funcao para fazer execução de sql
     * @param string $sql sql a ser executado
     * @param array $bind bind variables
     * @return \PDOStatement
     */
    public function execute(string $sql, array $bind = []) :\PDOStatement
    {
        try {
            $stmt = $this->conn->prepare($sql);

            if (!empty($bind))
                foreach ($bind as $key => $value)
                    $stmt->bindValue(':'.$key, $value);

            $stmt->execute();
            return $stmt;
        } catch(\PDOException $e) {
            echo $e->getMessage();
            http_response_code(500);
            exit();
        }
    }

}
