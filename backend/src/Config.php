<?php

namespace src;

require_once __DIR__ . '/Env.php';

class Config
{
    const BASE_DIR = BASE_DIR;

    const DB_DRIVER = DB_DRIVER;
    const DB_HOST = DB_HOST;
    const DB_DATABASE = DB_DATABASE;
    const DB_USER = DB_USER;
    const DB_PASS = DB_PASS;

    const ERROR_CONTROLLER = 'ErrorController';
    const DEFAULT_ACTION = 'index';
}
