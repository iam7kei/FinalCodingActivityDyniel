<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;

class AuthController extends Controller
{
    public function login()
    {
        $this->setLayout('auth');
        return $this->render('login');
    }
    public function register(Request $request)
    {

        $this->setLayout('auth');
        if($request->isPost()) {
            return 'handled submitted data';
        }
        return $this->render('register');
    }
}
