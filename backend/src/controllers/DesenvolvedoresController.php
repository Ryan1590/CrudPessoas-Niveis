<?php

/**
 * Classe responsável pelo controle da NiveisController
 * Autor: Ryan
 * Data de início: 08/05/2024
 */

namespace src\controllers;

use \core\Controller as ctrl;
use Exception;
use \src\handlers\DesenvolvedoresHandlers as devHandlers;
use \src\models\Nivel;

class DesenvolvedoresController extends ctrl
{

    public function buscarTermo($agrs)
    {
        try {
            $result = devHandlers::getProgramadoresTermo($agrs['busca']);
            ctrl::response($result, 200);
        } catch (\Throwable $th) {
            ctrl::response($th->getMessage(), 500);
        }
    }

    public function index()
    {
        try {
            $result = devHandlers::getProgramadores();
            ctrl::response($result, 200);
        } catch (\Throwable $th) {
            ctrl::response($th->getMessage(), $th->getCode());
        }
    }


    public function cadastro()
    {
        try {
            $body = ctrl::getBody();
            if (empty($body['nivel_id']) || empty($body['nome']) || empty($body['sexo']) || empty($body['data_nascimento']) || empty($body['hobby'])) {
                throw new Exception('Parâmetros incorretos!', 400);
            }
            $nivelId = $body['nivel_id'];
            if (!self::nivelExists($nivelId)) {
                throw new Exception('Nível não existe!', 404);
            }
            $result = devHandlers::cadastro($body);
            ctrl::response(['error' => false, 'result' => $result], 201);
        } catch (\Throwable $th) {
            ctrl::response(['error' => true, 'result' => $th->getMessage()], $th->getCode());
        }
    }

    public static function nivelExists($nivelId)
    {
        $nivel = Nivel::select()->where('id', $nivelId)->execute();
        return count($nivel) > 0;
    }

    public function editar($id)
    {
        try {
            $body = ctrl::getBody();
            if (!devHandlers::nivelExists($body['nivel_id'])) {
                throw new Exception('Nível não encontrado!', 404);
            }
            $result = devHandlers::editar($id, $body);
            ctrl::response(['error' => false, 'result' => $result], 200);
        } catch (\Throwable $th) {
            ctrl::response(['error' => true, 'result' => $th->getMessage()], $th->getCode());
        }
    }

    public function delete($id)
    {
        try {
            $result = devHandlers::delete($id);
            ctrl::response($result, 204);
        } catch (\Throwable $th) {
            ctrl::response($th->getMessage(), $th->getCode());
        }
    }
}
