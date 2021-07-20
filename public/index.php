<?php
use app\core\Application;
use app\controllers\ExportController;
use app\controllers\ReportController;
use app\controllers\SiteController;
use Dotenv\Dotenv;

require_once __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../include/utils.php';

$dotenv = Dotenv::createUnsafeImmutable(dirname(__DIR__));
$dotenv->load();

$config = [
    'db' => [
        'dsn' => $_ENV['DB_DSN'],
        'user' => $_ENV['DB_USER'],
        'password' => $_ENV['DB_PASSWORD']
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', function(){
    return 'Hello World';
});
$app->router->get('/export', [ExportController::class, 'export']);
// $app->router->get('/export', function(){
//     $args = collect($_REQUEST);
//     $format = $args->pull('format') ?: 'html';
//     $type = $args->pull('type');
//     if (!$type) {
//         exit('Please specify a type');
//     }

//     $controller = new ExportController($args);
   
//     echo $controller->export($type, $format);
// });
$app->router->get('/report', [ReportController::class, 'report']);


$app->run();

