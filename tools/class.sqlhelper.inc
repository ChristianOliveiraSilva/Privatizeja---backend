<?php
namespace privatizeja\SqlHelper;

/**
 * Classe responsavel por ajudar a criar o SQL
 */
class SqlHelper
{

    private static function getSanitalizedResquest(string $request) :string
    {
        # criar flag para validate
        # criar validador para se nada existir colocar 400
        return $_REQUEST[$request] ?? "";
    }

    /*
     * Metodo responsavel por trasnformar o array em string
     * @param string $initialSQL SQl inicial para ser bindado
     * @param array $variables array com os valores para ser bindado para ser bindado
     * @return array
     * @example SqlHelper::createSQLwithMultiCondition("SELECT * FROM signature", ['id','id_user_account', 'id_company']);
     */
    public static function createSQLwithMultiCondition(string $initialSQL, array $variables) :array
    {
        $bind = [];
        $sql = $initialSQL;

        foreach ($variables as $value) {
            $$value = SqlHelper::getSanitalizedResquest($value);
            if (empty($$value))
                continue;

            $sql .= empty($bind) ? ' WHERE ' : ' AND ';
            $sql .= "$value = :$value";
            $bind = array_merge($bind, [$value => $$value]);
        }

        return ['sql' => $sql, 'bind' => $bind];
    }

    /*
     * Metodo resposanvel por trasnformar o retorno SQL em um array para se tornar resposta (json)
     * @param PDOStatement $stmt
     * @return array
     */
    public static function createArrayFromSQLReturn(\PDOStatement $stmt) :array
    {
        $values = [];
        while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            $value = [];
            foreach ($result as $resultKey => $resultValue)
                $value[$resultKey] = $resultValue;

            $values[] = $value;
        }
        return $values;
    }
}
