<?php

require_once __DIR__ . '/../vendor/autoload.php';

use app\controllers\admin\ProductController;
use app\controllers\admin\UsersController;
use app\controllers\CommentController;
use app\controllers\WishlistController;
use app\core\Application;
use app\Controllers\SiteController;
use app\Controllers\AuthController;
use app\Controllers\admin\AdminController;
use app\Controllers\PalindromeController;

$config = [
    'userClass' => ['customer' => \app\models\CustomerModel::class, 'users' => \app\models\AdminModel::class],
    'db' => [
        'dsn' => 'mysql:host=localhost;port=3306;dbname=final_dyniel',
        'user' => 'root',
        'password' => 'root',
    ]
];

$app = new Application(dirname(__DIR__), $config);

$lastSlug = $app->request->getLastSlug();

$app->router->get('/', [SiteController::class, 'home']);

$app->router->get('/palindrome', [PalindromeController::class, 'palindrome']);
$app->router->post('/palindrome', [PalindromeController::class, 'palindrome']);

$app->router->get('/register', [AuthController::class, 'register']);
$app->router->post('/register', [AuthController::class, 'register']);
$app->router->get('/login', [AuthController::class, 'login']);
$app->router->post('/login', [AuthController::class, 'login']);
$app->router->get('/logout', [AuthController::class, 'logout']);

if (!$app->isGuest()) {
    $app->router->get('/products', [SiteController::class, 'products']);
    $app->router->get('/products/' . $lastSlug, [SiteController::class, 'pdp']);
    $app->router->post('/products/add/comment/' . $lastSlug, [CommentController::class, 'comment']);
    $app->router->post('/products/add/wishlist/' . $lastSlug, [ProductController::class, 'addToWishlist']);
    $app->router->get('/wishlist', [WishlistController::class, 'wishlist']);
    $app->router->post('/wishlist/delete', [WishlistController::class, 'delete']);
}

$app->router->get('/admin', [AdminController::class, 'home']);
$app->router->get('/admin/login', [AdminController::class, 'login']);
$app->router->post('/admin/login', [AdminController::class, 'login']);


if ($app->request->isAdmin() && !$app->isGuest()) {
    $app->router->get('/admin/customers', [AdminController::class, 'customers']);
    $app->router->get('/admin/customers/edit/' . $lastSlug, [AdminController::class, 'customerEdit']);
    $app->router->post('/admin/customers/edit/' . $lastSlug, [AdminController::class, 'customerEdit']);
    $app->router->get('/admin/customers/add', [AuthController::class, 'register']);
    $app->router->post('/admin/customers/add', [AuthController::class, 'register']);
    $app->router->post('/admin/customers/delete/' . $lastSlug, [AdminController::class, 'delete']);

    $app->router->get('/admin/users', [UsersController::class, 'users']);
    $app->router->get('/admin/users/edit/' . $lastSlug, [UsersController::class, 'userEdit']);
    $app->router->post('/admin/users/edit/' . $lastSlug, [AdminController::class, 'userEdit']);
    $app->router->get('/admin/users/add', [UsersController::class, 'userAdd']);
    $app->router->post('/admin/users/add', [UsersController::class, 'userAdd']);
    $app->router->post('/admin/users/delete/' . $lastSlug, [UsersController::class, 'delete']);

    $app->router->get('/admin/products', [ProductController::class, 'products']);
    $app->router->get('/admin/products/add', [ProductController::class, 'productsAdd']);
    $app->router->post('/admin/products/add', [ProductController::class, 'productsAdd']);
    $app->router->get('/admin/products/edit/' . $lastSlug, [ProductController::class, 'productsEdit']);
    $app->router->post('/admin/products/edit/' . $lastSlug, [ProductController::class, 'productsEdit']);
    $app->router->post('/admin/products/delete/' . $lastSlug, [ProductController::class, 'delete']);
    $app->router->get('/admin/logout', [AdminController::class, 'logout']);
}

$app->run();
