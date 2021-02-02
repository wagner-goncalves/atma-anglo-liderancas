<?php

namespace App\Traits;

trait HandleSqlError
{
    public function formatSqlError($errorCode, $mensagem)
    {

        $friendlyMessages = [
            1451 => [
                "pattern" => "Por questões de segurança e integridade, não é possível excluir em %s enquanto houver referências em %s.",
                "params" => [
                    substr(strstr(strstr($mensagem, 'REFERENCES `'), '` (', true), 12),
                    substr(strstr(strstr($mensagem, '`.`'), '`,', true), 3),

                ],
            ],
        ];

        if (array_key_exists($errorCode, $friendlyMessages)) {
            return vsprintf($friendlyMessages[$errorCode]["pattern"], $friendlyMessages[$errorCode]["params"]);
        } else {
            return $mensagem;
        }

    }
}
