<?php

namespace src\models;

use core\Database;
use \core\Model;
use PDO;

/**
 * Classe modelo para a tabela 'Nivel' do banco de dados.
 *
 * @author ryan
 * @date 11-05-2024
 */
class Nivel extends Model
{
    // public  static function getNiveis(){
    //     $sql = 'select * from niveis';
    //     $sql = Database::getInstance()->prepare($sql);
    //     $sql->execute();
    //     $res = $sql->fetch(PDO::FETCH_ASSOC);
    //     return $res;
    // }
}