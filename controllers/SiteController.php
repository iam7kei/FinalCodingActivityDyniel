<?php

namespace app\controllers;

use app\core\Application;
use app\core\Request;

class SiteController extends Controller
{
    public function home()
    {
        $params = [
            'name' => '7Kei'
        ];
        return $this->render('home', $params);
    }

}
