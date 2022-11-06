<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\core\Application;
use app\Controllers\SiteController;
use app\Controllers\AuthController;
use app\Controllers\admin\AdminController;
use app\Controllers\PalindromeController;

$config = [
    'userClass' => \app\models\CustomerModel::class,
    'db' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=final_dyniel',
        'user' => 'root',
        'password' => 'root',
    ]
];

$app = new Application(dirname(__DIR__), $config);

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/admin/customers', [AdminController::class, 'customers']);
$app->router->get('/admin/customers/add', [AdminController::class, 'customer_add']);
$app->router->get('/admin/products', [AdminController::class, 'products']);
$app->router->get('/admin/products/add', [AdminController::class, 'products_add']);


$app->router->get('/palindrome', [PalindromeController::class, 'palindrome']);
$app->router->post('/palindrome', [PalindromeController::class, 'palindrome']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);


$app->run();
