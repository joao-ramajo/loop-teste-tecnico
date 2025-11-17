<?php

namespace App\Http;

class Response
{
    /**
     * Retorna uma resposta JSON padronizada.
     *
     * @param array $data   Dados a serem convertidos em JSON.
     * @param int   $status Código HTTP da resposta (padrão 200).
     *
     * @return string JSON codificado como string.
     */
    public static function json(array $data, int $status = 200): string
    {
        http_response_code($status);
        header('Content-Type: application/json; charset=utf-8');

        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Retorna uma resposta de erro padronizada em JSON.
     *
     * @param string $message Mensagem de erro.
     * @param int    $status  Código HTTP (padrão 400).
     *
     * @return string JSON de erro.
     */
    public static function error(string $message, int $status = 400): string
    {
        return self::json(['error' => $message], $status);
    }
}
