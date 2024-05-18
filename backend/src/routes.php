<?php
use core\Router;

$router = new Router();
// Rota principal
$router->get('/', 'HomeController@index');

//-----------------niveis-----------------//
$router->get('/api/niveis', 'NiveisController@index');
$router->post('/api/niveis', 'NiveisController@cadastro'); 
$router->put('/api/niveis/{id}', 'NiveisController@editar');
$router->delete('/api/niveis/{id}', 'NiveisController@delete');
$router->get('/api/niveis/buscarTermo/{busca}', 'NiveisController@buscarTermo');
//-----------------desenvolvedores-----------------//
$router->get('/api/desenvolvedores', 'DesenvolvedoresController@index');
$router->post('/api/desenvolvedores', 'DesenvolvedoresController@cadastro'); 
$router->put('/api/desenvolvedores/{id}', 'DesenvolvedoresController@editar');
$router->delete('/api/desenvolvedores/{id}', 'DesenvolvedoresController@delete');
$router->get('/api/desenvolvedores/buscarTermo/{busca}', 'DesenvolvedoresController@buscarTermo');