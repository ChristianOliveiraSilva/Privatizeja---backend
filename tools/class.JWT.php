<?php
namespace privatizeja\JWTParser;

/**
 * Classe responsavel por parsear JWT
 */
class JWTParser
{
    const SECRET = 'CAPIVARA';

    /*
     * Função para criação do cabeçalho token
     * @return string
     */
    private static function createHeaderToken() :string
    {
        static $header;
        if (!empty($header)) {
            return $header;
        }

        $header = json_encode([ 'alg' => 'HS256', 'typ' => 'JWT']);
        $header = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($header));

        return $header;
    }

    /*
     * Função para criação do payload token
     * @params array $payloadInfo array para ser mergiado com o payload
     * @params int $expiration Tempo a ser esperido o JWT
     * @return string
     */
    private static function createPayloadToken(array $payloadInfo, int $expiration = 3600) :string
    {
        $payload = [
            "iss" => "privatizeja.com.br",
            "exp" => time() + $expiration
        ];
        $payload = json_encode(array_merge($payload, $payloadInfo));

        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($payload));
    }

    /*
     * Função para criação do payload token
     * @params string $base64UrlHeader cabecaço do JWT
     * @params string $base64UrlPayload payload do JWT
     * @return string
     */
    private static function createSignatureToken(string $base64UrlHeader, string $base64UrlPayload) :string
    {
        $signature = hash_hmac('sha256', "$base64UrlHeader.$base64UrlPayload", JWTParser::SECRET, true);

        return str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($signature));
    }

    /*
     * Função para criação de token
     * @params array $payloadInfo array para ser mergiado com o payload
     * @params int $expiration Tempo a ser esperido o JWT
     * @return string
     */
    public static function createJWT(array $payloadInfo, int $expiration = 3600) :string
    {
        $base64UrlHeader = JWTParser::createHeaderToken();
        $base64UrlPayload = JWTParser::createPayloadToken($payloadInfo, $expiration);
        $base64UrlSignature = JWTParser::createSignatureToken($base64UrlHeader, $base64UrlPayload);

        return "$base64UrlHeader.$base64UrlPayload.$base64UrlSignature";
    }

    /*
     * Função para validar token
     * @params string $jwt JWT a ser validado
     * @return bool
     */
    public static function isValid(string $jwt) :bool
    {
        $part = explode(".", $jwt);
        $header = $part[0];
        $payload = $part[1];
        $signature = $part[2];

        $valid = hash_hmac('sha256',"$header.$payload", JWTParser::SECRET, true);
        $valid = str_replace(['+', '/', '='], ['-', '_', ''], base64_encode($valid));

        return $signature == $valid;
    }

    /*
     * Função para recuperar array do JWT
     * @params string $jwt JWT a ser validado
     * @return array
     */
    public static function unmountJWT(string $jwt) :array
    {
        $payload = explode(".", $jwt)[1] ?? [];
        if (!JWTParser::isValid($jwt) || empty($payload))
            return [];

        $payload =  str_replace(['-', '_'], ['+', '/'], $payload);
        $payload = base64_decode($payload);
        return array_diff_key((array) json_decode($payload), ["iss" => "privatizeja.com.br","exp" => time()]);
    }
}
