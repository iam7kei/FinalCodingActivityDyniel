<?php

namespace app\models;

use app\core\DbModel;
use app\core\Model;
use app\core\UserModel;

class CustomerUpdateModel extends UserModel
{
    public string $email = '';
    public string $name = '';
    public string $gender = '';
    public string $address = '';
    public string $dob = '';
    public string $password = '';
    public array $oldData = [];
    public int $min = 8;
    public int $max = 12;

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL,
                [self::RULE_UPDATE, 'class' => self::class, 'field' => 'email']
            ],
            'name' => [self::RULE_REQUIRED],
            'gender' => [self::RULE_REQUIRED],
            'address' => [self::RULE_REQUIRED],
            'dob' => [self::RULE_REQUIRED],
            'password' => [
                [self::RULE_MIN, 'min' => $this->min],
                [self::RULE_MAX, 'max' => $this->max],
                [self::RULE_UPDATE, 'field' => 'password']
            ]
        ];
    }
    public function updateRules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL,
                [self::RULE_UPDATE, 'class' => self::class, 'field' => 'email']
            ],
            'name' => [self::RULE_REQUIRED],
            'gender' => [self::RULE_REQUIRED],
            'address' => [self::RULE_REQUIRED],
            'dob' => [self::RULE_REQUIRED],
            'password' => [
                [self::RULE_MIN, 'min' => $this->min],
                [self::RULE_MAX, 'max' => $this->max],
                [self::RULE_UPDATE, 'field' => 'password']
            ]
        ];
    }

    public function getPrimaryKey(): string
    {
        return 'customer_id';
    }

    public function tableName(): string
    {
        return 'customer';
    }

    public function attributes(): array
    {
        return ['email','password','name','address','gender','dob'];
    }

    public function update()
    {
        if ($this->password !== $this->oldData['password']) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }
        return parent::update();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function loadOldData(array $oldData)
    {
        $this->oldData = [
            'email' => $oldData['email'],
            'name' => $oldData['name'],
            'password' => $oldData['password'],
            'dob' => $oldData['dob'],
            'address' => $oldData['address'],
            'gender' => $oldData['gender']
        ];
    }

    public function validateNewData()
    {
        foreach ($this->oldData as $field => $value) {
            if ($value !== $this->{$field}) {
                return false;
            }
        }
        return true;
    }
}
