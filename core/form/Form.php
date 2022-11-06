<?php

namespace app\core\form;

use app\core\Model;

class Form
{
    public static function begin($action, $method)
    {
        echo sprintf('<form action="%s" method="%s">', $action, $method);
        return new Form();
    }
    public static function end()
    {
        echo '</form>';
    }

    public function field(Model $model, $attribute, $name, $type = 'text')
    {
        return new Field($model, $attribute, $name, $type);
    }
    public function alert(Model $model)
    {
        return new Alert($model->status);
    }
}
