<?php

namespace core;


use Exception;
use \src\Config;

class Controller
{

    public function getQueryParam($key, $default = null) {
        return isset($_GET[$key]) ? $_GET[$key] : $default;
    }

    protected function redirect($url)
    {
        header("Location: " . $this->getBaseUrl() . $url);
        exit;
    }

    public static function getBaseUrl()
    {
        $base = (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') ? 'https://' : 'http://';
        $base .= $_SERVER['SERVER_NAME'];
        if ($_SERVER['SERVER_PORT'] != '80') {
            $base .= ':' . $_SERVER['SERVER_PORT'];
        }
        $base .= Config::BASE_DIR;

        return $base;
    }

    private function _render($folder, $viewName, $viewData = [])
    {
        if (file_exists('../src/views/' . $folder . '/' . $viewName . '.php')) {
            extract($viewData);
            $render = fn ($vN, $vD = []) => $this->renderPartial($vN, $vD);
            $base = $this->getBaseUrl();
            require '../src/views/' . $folder . '/' . $viewName . '.php';
        }
    }

    private function renderPartial($viewName, $viewData = [])
    {
        $this->_render('partials', $viewName, $viewData);
    }

    public function render($viewName, $viewData = [])
    {
        $this->_render('pages', $viewName, $viewData);
    }

    /**
     * recebe um array e verifica item vazios se tiver algum vazio retorna true
     * @param array $error
     */
    public function AllVazio($error)
    {
        foreach ($error as $it => $value) {
            if (empty($it) || is_null($it) || $it == '' || trim($it) == '') {
                return true;
            }
        }
        return false;
    }

    /**
     * Verifica se há campos vazios ou não presentes na lista de campos a serem validados.
     * @param array $campos  Array associativo com os campos e seus respectivos valores a serem verificados.
     * @param array $validar Lista de campos obrigatórios a serem verificados.
     * @return bool Retorna true se todos os campos obrigatórios estiverem preenchidos, caso contrário, rejeita a resposta.
     */
    public static function verificarCamposVazios(array $campos, array $validar): bool
    {

        foreach ($campos as $campo) {
            // Verifica se o campo está presente em 'validar'
            if (!array_key_exists($campo, $validar)) {
                throw new Exception("Campo obrigatório não encontrado: $campo");
            }
    
            // Captura o valor correspondente no array 'validar'
            $valor = $validar[$campo];
    
            // Se o valor for um array, verifica se não está vazio
            if (is_array($valor) && empty($valor)) {
                throw new Exception("Campo obrigatório vazio: $campo");
            }
    
            // Se o valor não for um array, verifica se não está vazio
            if (!is_array($valor) && empty(trim((string) $valor))) {
                throw new Exception("Campo obrigatório vazio: $campo");
            }
        }

        return true;
    }



    /**
     * receber boy e retorna array
     * @param bool $valida_body
     */
    public function getBody($valida_body = true)
    {
        header('Content-Type: application/json');
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        if (empty($data) && $valida_body) {
            throw new Exception('Nenhum dado foi enviado');
        }
        return $data;
    }

    /**
     * define status e respota para usuario
     * @param array $item
     * @param int $status
     * ex: [
     *   result: [dados pro retorno]
     *   error: [msg de erro] || false
     * ]
     */
    public static function response($item, $status)
    {
        http_response_code($status);
        echo json_encode([
            'result' => $item,
            'error' => ($status > 300) ? true : false
        ]);
        die;
    }

}
