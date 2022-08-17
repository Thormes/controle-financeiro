<?php

namespace App\Exceptions;

use Illuminate\Http\Response;


class Responser extends Response
{
    public static function error($code = 400, $message = null)
    {
        // check if $message is object and transforms it into an array
        if (is_object($message)) {
            $message = $message->toArray();
        }

        switch ($code) {
            case 400:
                $code_message = "erro na requisição";
                break;
            case 404:
                $code_message = "não encontrado";
                break;
            case 409:
                $code_message = "conflito";
                break;
            case 422:
                $code_message = "Requisição contém erros";
                break;
            default:
                $code_message = 'erro diverso';
                break;
        }

        $data = array(
            'código'      => $code,
            'tipo'   => $code_message,
            'mensagem'      => $message
        );

        // return an error
        return response()->json($data, $code);
    }
}
