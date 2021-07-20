<?php

namespace app\core;

use app\core\Router;
use app\core\Request;

class Application
{
    public $router;
    public $request;
    public $response;
    public $db;
    public static $app;
    public static $ROOT_DIR;

    public function __construct($rootPath, array $config)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->db = new Database($config['db']);
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}