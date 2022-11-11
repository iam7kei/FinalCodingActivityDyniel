<?php

namespace app\controllers\admin;

use app\controllers\CommentController;
use app\controllers\Controller;
use app\core\Application;
use app\core\Database;
use app\core\Request;
use app\core\Response;
use app\core\Session;
use app\models\catalog\products\ProductModel;
use app\models\catalog\products\WishlistModel;
use app\models\CustomerModel;
use app\models\ProductTableModel;

class ProductController extends Controller
{
    public function products()
    {
        $this->setLayout('admin_main');
        $tableModel = new ProductTableModel(Database::getInstance());
        $tableModel->setColumns($tableModel->gridAttrbiutes());
        $tableData = $tableModel->getDbTable('products');
        $primaryKey = $tableModel->getPrimaryKey();
        $tableBody = $tableModel->getAnchoredTableBody($primaryKey, $tableData, ProductTableModel::ADMIN_EDIT_PATH);
        $tableHeaders = $tableModel->getTableHeaders($tableModel->gridAttributeLabels());
        return $this->render('admin/products/grid', [
            'tableHeaders' => $tableHeaders,
            'tableBody' => $tableBody
        ]);
    }
    public function productsAdd(Request $request, Response $response)
    {
        $this->setLayout('admin_main');
        $productModel = new ProductModel();

        if ($request->isPost()) {
            $productModel->loadData($request->getBody());

            if ($productModel->validate('addRules') && $productModel->save()) {
                Application::$app->session->setFlashMessage('success', 'Successfully created product.');

                Application::$app->response->redirect('/admin/products');
            }

            return $this->render(
                'admin/products/add',
                [
                    'model' => $productModel
                ]
            );
        }

        return $this->render(
            'admin/products/add',
            [
                'model' => $productModel
            ]
        );
    }
    public function productsEdit(Request $request, Response $response)
    {
        $this->setLayout('admin_main');
        $productUpdateModel = new ProductModel();
        $productID = $request->getLastSlug();
        $productData = (array) $productUpdateModel->findRecord(
            [$productUpdateModel->getPrimaryKey() => $productID]
        );

        $productUpdateModel->loadData($productData);
        if ($request->isPost()) {
            $productUpdateModel->loadData($request->getBody());
            $productUpdateModel->loadOldData($productData);
            if ($productUpdateModel->validate('updateRules') && $productUpdateModel->update()) {
                Application::$app->session->setFlashMessage(
                    'success',
                    'Successfully updated product.'
                );
                Application::$app->response->redirect('/admin/products/edit/' . $productID);
            }

            $productUpdateModel->password = '';
            return $this->render(
                'admin/products/edit',
                [
                    'model' => $productUpdateModel
                ]
            );
        }

        $this->setLayout('admin_main');

        return $this->render(
            'admin/products/edit',
            [
                'model' => $productUpdateModel
            ]
        );
    }

    public function addToWishlist(Request $request, Response $response)
    {
        $wishlistModel = new WishlistModel();
        $productID = $request->getLastSlug();
        $customerID = Session::get(CustomerModel::getPrimaryKey());
        if ($request->isPost()) {
            $wishlistModel->setWishlistData($productID);
            if ($wishlistModel->validate('rules') && $wishlistModel->save()) {
                Application::$app->session->setFlashMessage('success', 'Successfully added to wishlist.');
                Application::$app->response->redirect("/products/$productID");
            }
            if ($wishlistModel->errors) {
                Application::$app->session->setFlashMessage('error', $wishlistModel->getFirstError('product_id'));
            }
            Application::$app->response->redirect("/products/$productID");
        }
    }

    public function delete(Request $request, Response $response)
    {
        $id = $request->getLastSlug();
        $productModel = new ProductModel();
        $primaryKey = $productModel->getPrimaryKey();
        $tableName = $productModel->tableName();
        $productModel->removeRecord([
            $primaryKey => $id
        ]);

        Application::$app->session->setFlashMessage('success', 'Successfully deleted product.');
        $response->redirect('/admin/products');
    }
}
