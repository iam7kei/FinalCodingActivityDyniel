<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;

class AuthController extends Controller
{
    public function login()
    {
        return $this->render('login');
    }
    public function register(Request $request)
    {
        if($request->isPost()) {
            return 'handled submitted data';
        }
        return $this->render('register');
    }
}
