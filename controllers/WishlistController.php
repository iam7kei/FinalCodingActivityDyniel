<?php

namespace app\controllers;

use app\core\Application;
use app\core\Database;
use app\core\Request;
use app\core\Response;
use app\core\Session;
use app\models\catalog\products\ProductModel;
use app\models\catalog\products\WishlistModel;
use app\models\catalog\products\WishlistTableModel;
use app\models\CustomerModel;
use app\models\CustomerTableModel;

class WishlistController extends Controller
{
    public function wishlist()
    {
        $tableModel = new WishlistTableModel(Database::getInstance());
        $tableModel->setColumns($tableModel->gridAttrbiutes());
        $tableData = $tableModel->getDbTable('wishlist');
        $primaryKey = $tableModel->getPrimaryKey();
        $tableBody = $tableModel->getTableBody(
            $primaryKey,
            $tableData
        );
        $tableHeaders = $tableModel->getTableHeaders($tableModel->gridAttributeLabels());

        return $this->render('products/wishlist', [
            'tableHeaders' => $tableHeaders,
            'tableBody' => $tableBody,
            'model' => $tableModel
        ]);
    }

    public function renderWishlist()
    {
    }

    public function delete(Request $request, Response $response)
    {
        $wishlistModel = new WishlistModel();
        $primaryKey = CustomerModel::getPrimaryKey();
        $customer_id = Session::get($primaryKey);
        $tableName = $wishlistModel->tableName();
        $wishlistModel->removeRecord([
            $primaryKey => $customer_id
        ]);

        Application::$app->session->setFlashMessage('success', 'Successfully deleted wishlist.');
        $response->redirect('/wishlist');
    }
}
