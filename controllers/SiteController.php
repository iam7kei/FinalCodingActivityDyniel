<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;
use app\models\CustomerModel;

class SiteController extends Controller
{
    public function home()
    {
        return $this->render('home');
    }
}
