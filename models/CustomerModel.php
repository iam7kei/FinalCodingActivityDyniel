<?php

namespace app\models;

use app\core\DbModel;
use app\core\Model;
use app\core\UserModel;

class CustomerModel extends UserModel
{
    public string $email = '';
    public string $name = '';
    public string $gender = '';
    public string $address = '';
    public string $dob = '';
    public string $password = '';
    public string $confirmPassword = '';
    public array $oldData = [];

    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'name' => [self::RULE_REQUIRED],
            'gender' => [self::RULE_REQUIRED],
            'address' => [self::RULE_REQUIRED],
            'dob' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => '8'],[self::RULE_MAX, 'max' => '12']],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
        ];
    }
    public function registerRules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'name' => [self::RULE_REQUIRED],
            'gender' => [self::RULE_REQUIRED],
            'address' => [self::RULE_REQUIRED],
            'dob' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => '8'],[self::RULE_MAX, 'max' => '12']],
            'confirmPassword' => [self::RULE_REQUIRED, [self::RULE_MATCH, 'match' => 'password']]
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

    public function getName(): string
    {
        return $this->name;
    }
}
