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
                $customerLoginModel->validate('loginRules') &&
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
        if (!Application::isGuest() && $request->isAdmin()) {
            $response->redirect('/');
            return;
        }
        $customerModel = new CustomerModel();

        if ($request->isPost()) {
            $customerModel->loadData($request->getBody());

            if ($customerModel->validate('registerRules') && $customerModel->save()) {
                $url = '/';
                Application::$app->session->setFlashMessage('success', 'Successfully registered account.');
                if ($request->isAdmin()) {
                    $url = '/admin/customers';
                }
                Application::$app->response->redirect($url);
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
