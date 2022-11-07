<?php

namespace app\models;

class CustomerLoginModel extends LoginModel
{
    public string $email = '';
    public function rules(): array
    {
        return [
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED]
        ];
    }
}
