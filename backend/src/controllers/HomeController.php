<?php

/**
 * Classe responsável pelo controle da página inicial
 * Autor: Ryan
 * Data de início: 08/05/2024
 */

namespace src\controllers;

use \core\Controller as ctrl;

class HomeController extends ctrl
{
    /**
     * Exibe uma mensagem de boas-vindas e o status da API na página inicial
     */
    public function index()
    {
        ctrl::response(['API' => 'Crud Gazin'], 200);
    }
}
