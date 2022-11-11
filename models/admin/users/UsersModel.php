<?php

namespace app\models\admin\users;

use app\core\DbModel;

class UsersModel extends DbModel
{
    public string $name = '';
    public string $username = '';
    public string $password = '';
    public string $confirmPassword  = '';
    public array $oldData = [];
    public int $min = 8;
    public int $max = 12;

    public function tableName(): string
    {
        return 'users';
    }

    public function attributes(): array
    {
        return [
            'username',
            'name',
            'password'
        ];
    }

    public function getPrimaryKey(): string
    {
        return 'user_id';
    }

    public function rules(): array
    {
        return [];
    }

    public function loadOldData(array $oldData)
    {
        $this->oldData = [
            'name' => $oldData['name'],
            'username' => $oldData['username'],
            'password' => $oldData['password']
        ];
    }

    public function validateNewData(string $attribute, string $value)
    {
        if ($value !== $this->oldData[$attribute]) {
            return false;
        }
        return true;
    }

    public function updateRules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED,
                [self::RULE_UPDATE, 'class' => self::class, 'field' => 'email']
            ],
            'name' => [self::RULE_REQUIRED],
            'password' => [
                [self::RULE_MIN, 'min' => $this->min],
                [self::RULE_MAX, 'max' => $this->max],
                [self::RULE_UPDATE, 'field' => 'password']
            ]
        ];
    }

    public function addRules(): array
    {
        return [
            'name' => [self::RULE_REQUIRED],
            'username' => [self::RULE_REQUIRED, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'password' => [
                self::RULE_REQUIRED,
                [self::RULE_MIN, 'min' => '8'],
                [self::RULE_MAX, 'max' => '12']
            ],
            'confirmPassword' => [self::RULE_REQUIRED,[self::RULE_MATCH, 'match' => 'password']]
        ];
    }

    public function save()
    {
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        return parent::save();
    }

    public function update()
    {
        if ($this->password !== $this->oldData['password']) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
        return parent::update();
    }
}
