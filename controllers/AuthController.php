<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\CustomerLoginModel;
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
        $customerLoginModel = new CustomerLoginModel();
        if ($request->isPost()) {
            $customerLoginModel->loadData($request->getBody());

            if (
                $customerLoginModel->validate() &&
                $customerLoginModel->login(CustomerModel::class, 'email')
            ) {
                $response->redirect('/');
                return;
            }
        }
        return $this->render('login', [
            'model' => $customerLoginModel
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
        Application::$app->logout(CustomerModel::getPrimaryKey());
        $response->redirect('/');
    }
}
