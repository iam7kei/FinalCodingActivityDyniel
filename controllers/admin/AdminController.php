<?php

namespace app\controllers\admin;

use app\controllers\Controller;
use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\models\AdminLoginModel;
use app\models\AdminModel;
use app\models\CustomerModel;
use app\models\LoginModel;

class AdminController extends Controller
{
    protected $params = [];
    public function home()
    {
        $this->setLayout('admin_main');
        return $this->render('home');
    }

    public function login(Request $request, Response $response)
    {
        $adminLogin = new AdminLoginModel();
        if ($request->isPost()) {
            if ($request->isPost()) {
                $adminLogin->loadData($request->getBody());
                if ($adminLogin->validate() && $adminLogin->login(AdminModel::class, 'username')) {
                    $response->redirect('/admin');
                    return;
                }
            }
        }
        $this->setLayout('admin_main');

        return $this->render('admin/auth/login', [
            'model' => $adminLogin
        ]);
    }
    public function customers()
    {
        $this->setLayout('admin_main');

        return $this->render('admin/customers/grid');
    }
    public function customer_add()
    {
        $this->setLayout('admin_main');
        return $this->render('admin/customers/add');
    }
    public function products()
    {
        $this->setLayout('admin_main');
        return $this->render('admin/products/grid');
    }
    public function products_add()
    {
        $this->setLayout('admin_main');
        return $this->render('admin/products/add');
    }
    public function logout(Request $request, Response $response)
    {
        Application::$app->logout(AdminModel::getPrimaryKey());
        $response->redirect('/admin/login');
    }
}
