<?php

namespace app\models;

use app\core\Application;
use app\core\Model;
use app\core\UserModel;

class LoginModel extends Model
{
    public string $password = '';

    public function rules(): array
    {
        return [];
    }

    public function login(string $className, string $type)
    {
        $user = $className::findRecord([$type => $this->{$type}]);
        if (!$user) {
            $this->addError($type, 'This user does not exist');
            return false;
        }
        if (!password_verify($this->password, $user->password)) {
            $this->addError('password', 'Incorrect password');
            return false;
        }
        return Application::$app->login($user);
    }
}
