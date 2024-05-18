<?php

namespace src\handlers;

use Exception;
use \src\models\Nivel;

class NiveisHandlers
{

   public static function buscarNiveis($termo)
   {
      $niveis = Nivel::select()->where('nivel', 'like', '%' . $termo . '%')->execute();
      if (count($niveis) == 0) {
         throw new Exception('Nenhum nível encontrado!', 404);
      }
      return $niveis;
   }

   public static function getNiveis()
   {
      $niveis = Nivel::select()->execute();
      if (count($niveis) == 0) {
         throw new Exception('Sem niveis Cadastrados!', 404);
      }
      return $niveis;
   }

   public static function nivelExiste($nivel)
   {
      return Nivel::select()->where('nivel', $nivel)->exists();
   }

   public static function cadastro($nivel)
   {
      if (self::nivelExiste($nivel)) {
         throw new Exception('Nível já existe!', 400);
      }

      Nivel::insert(['nivel' => $nivel])->execute();
      return 'Nivel cadastrado com sucesso!';
   }

   public static function editar($id, $nivel)
   {
      $existingNivel = Nivel::select()->where('nivel', $nivel)->andWhere('id', '!=', $id)->first();
      if ($existingNivel) {
         return ['error' => true, 'result' => 'Nível já existe!'];
      }

      Nivel::update(['nivel' => $nivel])->where('id', $id)->execute();
      return ['error' => false, 'result' => 'Nível atualizado com sucesso!'];
   }

   public static function delete($id)
   {
      Nivel::delete()->where('id', $id)->execute();
      return 'Nível excluído com sucesso!';
   }
}
