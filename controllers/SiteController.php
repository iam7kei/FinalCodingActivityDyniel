<?php

namespace app\controllers;

use app\core\Application;
use app\core\Database;
use app\core\Request;
use app\core\Response;
use app\models\catalog\products\CommentsModel;
use app\models\catalog\products\CommentsTableModel;
use app\models\catalog\products\ProductModel;
use app\models\CustomerModel;
use app\models\CustomerTableModel;
use app\models\ProductTableModel;

class SiteController extends Controller
{
    public function home()
    {
        return $this->render('home');
    }

    public function products()
    {
        $tableModel = new ProductTableModel(Database::getInstance());
        $tableModel->setColumns($tableModel->gridAttrbiutes());
        $tableData = $tableModel->getDbTable('products');
        $linkAttribute = 'url_key';
        $tableBody = $tableModel->getAnchoredTableBody($linkAttribute, $tableData, ProductTableModel::PDP_PATH);
        $tableHeaders = $tableModel->getTableHeaders($tableModel->gridAttributeLabels());
        return $this->render('products/grid', [
            'tableHeaders' => $tableHeaders,
            'tableBody' => $tableBody
        ]);
    }
    public function pdp(Request $request, Response $response)
    {
        $productUpdateModel = new ProductModel();
        $url_key = $request->getLastSlug();
        $productData = (array) $productUpdateModel->findRecord(
            ['url_key' => $url_key]
        );
        $commentsModel = new CommentsTableModel(Database::getInstance());
        $commentsModel->setColumns($commentsModel->gridAttrbiutes());
        $tableData = $commentsModel->getDbTable('comments');
        $tableData = $commentsModel->getCustomerEmail($tableData);
        $primaryKey = $commentsModel->getPrimaryKey();
        $tableBody = $commentsModel->getTableBody(
            $primaryKey,
            $tableData
        );
        $productUpdateModel->loadData($productData);
        if ($request->isPost()) {
        }

        return $this->render(
            'products/pdp',
            [
                'model' => $productUpdateModel,
                'comments' => $tableData
            ]
        );
    }
}
