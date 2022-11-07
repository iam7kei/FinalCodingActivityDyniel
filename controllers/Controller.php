<?php

namespace app\controllers;

use app\core\Application;
use app\core\Session;
use app\models\CustomerModel;

class Controller
{
    public const USER_ADMIN = ['admin', 'user_id'];
    public const USER_CUSTOMER = ['user', 'customer_id'];

    public string $layout = 'main';

    public function render($view, $params = [])
    {
        return Application::$app->router->renderView($view, $params);
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
    }
}
