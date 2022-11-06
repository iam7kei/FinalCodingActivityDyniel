<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;

class SiteController extends Controller
{
    protected $params = [];
    public function home()
    {
        $this->params = [
            "name" => 'Kei'
        ];
        return $this->render('home', $this->params);
    }
    public function admin_customers()
    {

        $this->setLayout('admin_main');

        return $this->render('admin/customers/grid', $this->params);
    }
    public function admin_customers_add()
    {

        $this->setLayout('admin_main');
        return $this->render('admin/customers/add', $this->params);
    }
    public function admin_products()
    {

        $this->setLayout('admin_main');
        return $this->render('admin/products/grid', $this->params);
    }
    public function admin_products_add()
    {
        $this->setLayout('admin_main');
        return $this->render('admin/products/add', $this->params);
    }
}
