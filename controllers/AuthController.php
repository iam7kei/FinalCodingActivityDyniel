<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\CustomerModel;
use app\models\LoginModel;

class AuthController extends Controller
{
    public function login(Request $request, Response $response)
    {
        if (!Application::isGuest()) {
            $response->redirect('/');
            return;
        }
        $loginModel = new LoginModel();
        if ($request->isPost()) {
            $loginModel->loadData($request->getBody());
            if ($loginModel->validate() && $loginModel->login()) {
                $response->redirect('/');
                return;
            }
        }
        return $this->render('login', [
            'model' => $loginModel
        ]);
    }
    public function register(Request $request, Response $response)
    {
        if (!Application::isGuest()) {
            $response->redirect('/');
            return;
        }
        $customerModel = new CustomerModel();

        if ($request->isPost()) {
            $customerModel->loadData($request->getBody());

            if ($customerModel->validate() && $customerModel->save()) {
                Application::$app->session->setFlashMessage('success', 'Successfully registered account.');
                Application::$app->response->redirect('/');
            }

            return $this->render(
                'register',
                [
                'model' => $customerModel
                ]
            );
        }

        return $this->render(
            'register',
            [
            'model' => $customerModel
            ]
        );
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout();
        $response->redirect('/');
    }
}
