<?php

namespace app\controllers\admin;

use app\controllers\Controller;
use app\core\Application;
use app\core\Request;
use app\core\Response;
use app\core\Database;
use app\models\admin\users\UsersModel;
use app\models\AdminLoginModel;
use app\models\AdminModel;
use app\models\admin\users\UsersTableModel;
use app\models\CustomerDeleteModel;
use app\models\CustomerModel;
use app\models\CustomerTableModel;
use app\models\CustomerUpdateModel;
use app\models\DbTableModel;
use app\models\LoginModel;
use app\models\ProductTableModel;

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
            $adminLogin->loadData($request->getBody());
            if (
                $adminLogin->validate('loginRules') && $adminLogin->login(
                    AdminModel::class,
                    'username'
                )
            ) {
                $response->redirect('/admin');
                return;
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
        $tableModel = new CustomerTableModel(Database::getInstance());
        $tableModel->setColumns($tableModel->gridAttrbiutes());
        $tableData = $tableModel->getDbTable('customer');
        $primaryKey = $tableModel->getPrimaryKey();
        $tableBody = $tableModel->getAnchoredTableBody(
            $primaryKey,
            $tableData,
            CustomerTableModel::ADMIN_EDIT_PATH
        );
        $tableHeaders = $tableModel->getTableHeaders($tableModel->gridAttributeLabels());

        return $this->render('admin/customers/grid', [
            'tableHeaders' => $tableHeaders,
            'tableBody' => $tableBody
        ]);
    }
    public function customerAdd(Request $request, Response $response)
    {
       /* $this->setLayout('admin_main');
        $customerModel = new ProductModel();

        if ($request->isPost()) {
            $customerModel->loadData($request->getBody());

            if ($customerModel->validate('registerRules') && $customerModel->save()) {
                Application::$app->session->setFlashMessage(
                    'success',
                    'Successfully registered account.'
                );
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
        return $this->render('admin/customers/add');*/
    }
    public function customerEdit(Request $request, Response $response)
    {
        $this->setLayout('admin_main');
        $customerModel = new CustomerUpdateModel();
        $customerId = $request->getLastSlug();
        $customerData = (array) $customerModel->findRecord(
            [$customerModel->getPrimaryKey() => $customerId]
        );
        $customerModel->loadData($customerData);

        if ($request->isPost()) {
            $customerModel->loadData($request->getBody());

            if (!$customerModel->password) {
                $customerModel->password = $customerData['password'];
                $customerModel->loadOldData($customerData);
                $customerModel->max = strlen($customerModel->password);
            }

            if ($customerModel->validate('updateRules') && $customerModel->update()) {
                Application::$app->session->setFlashMessage(
                    'success',
                    'Successfully updated account.'
                );
                Application::$app->response->redirect('/admin/customers/edit/' . $customerId);
            }

            $customerModel->password = '';
            return $this->render(
                'admin/customers/edit',
                [
                    'model' => $customerModel
                ]
            );
        }

        $customerModel->password = '';
        $this->setLayout('admin_main');
        return $this->render(
            'admin/customers/edit',
            [
                'model' => $customerModel
            ]
        );
    }

    public function logout(Request $request, Response $response)
    {
        Application::$app->logout(AdminModel::getPrimaryKey());
        $response->redirect('/admin/login');
    }
    public function delete(Request $request, Response $response)
    {
        $id = $request->getLastSlug();
        $customerDeleteModel = new CustomerDeleteModel();
        $primaryKey = $customerDeleteModel->getPrimaryKey();
        $tableName = $customerDeleteModel->tableName();
        $customerDeleteModel->removeRecord([
            $primaryKey => $id
        ]);

        Application::$app->session->setFlashMessage(
            'success',
            'Successfully removed customer account.'
        );
        $response->redirect('/admin/customers');
    }
}
