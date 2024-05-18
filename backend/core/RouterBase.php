<?php

namespace core;

use \src\Config;

class RouterBase extends Auth
{
    public $token;

    public function __construct()
    {
        $headers = getallheaders();
        $authorizationHeader = isset($headers['Authorization']) ? $headers['Authorization'] : null;

        if (!empty($authorizationHeader)) {
            if (strpos($authorizationHeader, 'Basic ') === 0) {
                // Trata como Basic Auth
                $this->token = $authorizationHeader;
            } elseif (strpos($authorizationHeader, 'Bearer ') === 0) {
                // Trata como Bearer Token
                $this->token = $authorizationHeader;
            } else {
                // Formato não reconhecido ou ausente
                $this->token = null;
            }
        } else {
            // Tenta pegar o token JWT de $_REQUEST, se disponível
            $this->token = isset($_REQUEST['jwt']) ? 'Bearer ' . $_REQUEST['jwt'] : null;
        }
    }


    public function run($routes)
    {

      
        $method = Request::getMethod();
        $url = Request::getUrl();


        // Define os itens padrão
        $controller = Config::ERROR_CONTROLLER;
        $action = Config::DEFAULT_ACTION;
        $privado = false;
        $args = [];

        if (isset($routes[$method])) {

            foreach ($routes[$method] as $route => $callback) {

                // Identifica os argumentos e substitui por regex
                //print_r($route);die;
                $pattern = preg_replace('(\{[a-z0-9_]{1,}\})', '([a-z0-9-_]{1,})', $route);
                //$pattern = preg_replace('(\{[^\}]{1,}\})', '([^\/]{1,})', $route);
                // Faz o match da URL
                if (preg_match('#^(' . $pattern . ')*$#i', $url, $matches) === 1) {

                    
                    array_shift($matches);
                    array_shift($matches);

                    

                    // Pega todos os argumentos para associar
                    $itens = array();
                    if (preg_match_all('(\{[a-z0-9_]{1,}\})', $route, $m)) {
                        $itens = preg_replace('(\{|\})', '', $m[0]);
                    }
                    // Faz a associação
                    $args = array();
                    foreach ($matches as $key => $match) {
                        $args[$itens[$key]] = $match;
                    }

                    // Seta o controller/action
                    $callbackSplit = explode('@', $callback[0]);
                    $controller = $callbackSplit[0];
                    $privado =  $callback[1];
                    if (isset($callbackSplit[1])) {
                        $action = $callbackSplit[1];
                    }

                    break;
                }
            }
        }

        if ($privado) {
            $this->validaToken($this->token, $args);
            $args['usuario'] = $this->usuario;
            unset($args['usuario']['senha']);
        }


        $controller = "\src\controllers\\$controller";
        $definedController = new $controller();
        $definedController->$action($args);
    }
}
