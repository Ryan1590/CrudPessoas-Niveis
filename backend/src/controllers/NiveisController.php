<?php

/**
 * Classe responsável pelo controle da NiveisController
 * Autor: Ryan
 * Data de início: 08/05/2024
 */

namespace src\controllers;

use \core\Controller as ctrl;
use Exception;
use \src\handlers\NiveisHandlers as help;
use \src\models\Desenvolvedores;

class NiveisController extends ctrl
{

   public function buscarTermo($agrs)
   {
      try {
         $result = help::buscarNiveis($agrs['busca']);
         ctrl::response($result, 200);
      } catch (\Throwable $th) {
         ctrl::response($th->getMessage(), 500);
      }
   }

   public function index()
   {
      try {
         $result = help::getNiveis();
         ctrl::response($result, 200);
      } catch (\Throwable $th) {
         ctrl::response($th->getMessage(), $th->getCode());
      }
   }

   public function cadastro()
   {
      try {
         $body = ctrl::getBody();
         if ($body && empty($body['nivel'])) {
            throw new Exception('Parametros incorretos!', 400);
         }

         $nivelExistente = help::nivelExiste($body['nivel']);
         if ($nivelExistente) {
            throw new Exception('Nível já existe!', 400);
         }

         $result = help::cadastro($body['nivel']);
         ctrl::response(['result' => $result, 'error' => false], 201);
      } catch (\Throwable $th) {
         ctrl::response(['result' => $th->getMessage(), 'error' => true], $th->getCode() ?: 500);
      }
   }

   public function editar($id)
   {
      try {
         $body = ctrl::getBody();
         if (empty($body['nivel'])) {
            throw new Exception("Parametros incorretos", 400);
         }

         $result = help::editar($id, $body['nivel']);

         if ($result['error']) {

            throw new Exception($result['result'], 400);
         }

         ctrl::response(['error' => false, 'result' => $result['result']], 200);
      } catch (\Throwable $th) {
         ctrl::response(['error' => true, 'result' => $th->getMessage()], $th->getCode());
      }
   }

   public function delete($id)
   {
      try {

         $desenvolvedores = Desenvolvedores::select()->where('nivel_id', $id)->execute();
         if (!empty($desenvolvedores)) {
            throw new Exception('Este nível está associado a um ou mais desenvolvedores e não pode ser excluído.', 400);
         }

         $result = help::delete($id);
         ctrl::response($result, 204);
      } catch (\Throwable $th) {
         ctrl::response($th->getMessage(), $th->getCode());
      }
   }
}
