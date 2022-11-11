<?php

namespace app\controllers\admin;

use app\core\Application;
use app\core\Database;
use app\core\Request;
use app\core\Response;
use app\controllers\Controller;
use app\models\admin\users\UsersModel;
use app\models\admin\users\UsersTableModel;
use app\models\CustomerDeleteModel;

class UsersController extends Controller
{
    public function users()
    {
        $this->setLayout('admin_main');
        $tableModel = new UsersTableModel(Database::getInstance());
        $tableModel->setColumns($tableModel->gridAttrbiutes());
        $tableData = $tableModel->getDbTable('users');
        $primaryKey = $tableModel->getPrimaryKey();

        $tableBody = $tableModel->getAnchoredTableBody(
            $primaryKey,
            $tableData,
            UsersTableModel::ADMIN_EDIT_PATH
        );
        $tableHeaders = $tableModel->getTableHeaders($tableModel->gridAttributeLabels());

        return $this->render('admin/users/grid', [
            'tableHeaders' => $tableHeaders,
            'tableBody' => $tableBody
        ]);
    }

    public function userAdd(Request $request, Response $response)
    {
        $this->setLayout('admin_main');
        $usersModel = new UsersModel();

        if ($request->isPost()) {
            $usersModel->loadData($request->getBody());

            if ($usersModel->validate('addRules') && $usersModel->save()) {
                Application::$app->session->setFlashMessage('success', 'Successfully created user.');

                Application::$app->response->redirect('/admin/users');
            }

            return $this->render(
                'admin/users/add',
                [
                    'model' => $usersModel
                ]
            );
        }

        return $this->render(
            'admin/users/add',
            [
                'model' => $usersModel
            ]
        );
    }
    public function userEdit(Request $request, Response $response)
    {
        $this->setLayout('admin_main');
        $usersModel = new UsersModel();
        $customerId = $request->getLastSlug();
        $userData = (array) $usersModel->findRecord(
            [$usersModel->getPrimaryKey() => $customerId]
        );
        $usersModel->loadData($userData);

        if ($request->isPost()) {
            $usersModel->loadData($request->getBody());
            $usersModel->loadOldData($userData);
            if (!$usersModel->password) {
                $usersModel->password = $userData['password'];
                $usersModel->loadOldData($userData);
                $usersModel->max = strlen($usersModel->password);
            }

            if ($usersModel->validate('updateRules') && $usersModel->update()) {
                Application::$app->session->setFlashMessage(
                    'success',
                    'Successfully updated user.'
                );
                Application::$app->response->redirect('/admin/users/edit/' . $customerId);
            }

            $usersModel->password = '';
            return $this->render(
                'admin/users/edit',
                [
                    'model' => $usersModel
                ]
            );
        }

        $usersModel->password = '';
        $this->setLayout('admin_main');
        return $this->render(
            'admin/users/edit',
            [
                'model' => $usersModel
            ]
        );
    }

    public function delete(Request $request, Response $response)
    {
        $id = $request->getLastSlug();
        $usersMo = new UsersModel();
        $primaryKey = $usersMo->getPrimaryKey();
        $tableName = $usersMo->tableName();
        $usersMo->removeRecord([
            $primaryKey => $id
        ]);

        Application::$app->session->setFlashMessage(
            'success',
            'Successfully removed user account.'
        );
        $response->redirect('/admin/users');
    }
}
