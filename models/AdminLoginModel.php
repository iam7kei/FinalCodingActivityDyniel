<?php

namespace app\models;

class AdminLoginModel extends LoginModel
{
    public string $username = '';
    public function rules(): array
    {
        return [
            'username' => [self::RULE_REQUIRED],
            'password' => [self::RULE_REQUIRED]
        ];
    }
}
