<?php

namespace app\controllers\admin;

use app\controllers\Controller;
use app\core\Application;
use app\core\Request;

class AdminController extends Controller
{
    protected $params = [];

    public function customers()
    {

        $this->setLayout('admin_main');

        return $this->render('admin/customers/grid', $this->params);
    }
    public function customer_add()
    {

        $this->setLayout('admin_main');
        return $this->render('admin/customers/add', $this->params);
    }
    public function products()
    {

        $this->setLayout('admin_main');
        return $this->render('admin/products/grid', $this->params);
    }
    public function products_add()
    {
        $this->setLayout('admin_main');
        return $this->render('admin/products/add', $this->params);
    }
}
