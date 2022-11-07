<?php

namespace app\models;

use app\core\DbModel;
use app\core\Model;
use app\core\UserModel;

class AdminModel extends UserModel
{
    public string $username = '';
    public string $name = '';
    public string $password = '';
    public string $confirmPassword = '';

    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED,[
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'name' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => '8'],[self::RULE_MAX, 'max' => '12']],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function getPrimaryKey(): string
    {
        return 'user_id';
    }

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return ['username','password','name'];
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
