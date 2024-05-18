<?php

namespace core;

use \core\Controller as ctrl;
use \src\models\Usuarios as Users;
use \src\handlers\UserHandlers;
use \src\Config;

class Auth extends ctrl
{
    public  function validaToken($token, $args)
    {
        if (empty($token)) {
            self::VALIDATION();
        }

        // Verifica se é um token fixo JWT válido
        if (in_array($token, Config::TOKEN_JV)) {
            return; // Token fixo válido, não precisa de mais validações
        }
       
        $authHeaderParts = explode(' ', $token);
        $tokenType = $authHeaderParts[0]; // Basic ou Bearer
        $tokenValue = $authHeaderParts[1]; // O valor do token após o tipo

        if ($tokenType === 'Basic') {
            $decode = base64_decode($tokenValue);
            $login = explode(':', $decode)[0];
            $senha = explode(':', $decode)[1];
    
            $authorization = Users::select()->where('login', $login)->one();
            if (empty($authorization)) {
                self::VALIDATION();
            }
            if(!password_verify($senha, $authorization['senha'])){
                self::VALIDATION();
            }
    
            $this->setUsuario($authorization);
        } else {
            self::VALIDATION();
        }
    }

    public function verificarEmpresa($args)
    {
        $idempresa = null;
        if (isset($args['idempresa'])) {
            $idempresa = $args['idempresa'];
        }

        $payload = ctrl::getBody(false);
        if (isset($payload['idempresa'])) {
            $idempresa = $payload['idempresa'];
        }

        return $idempresa;
    }

    public static function VALIDATION()
    {
        ctrl::response('Sem permissão/token não Informado!/token inválido', 401);
    }
}
