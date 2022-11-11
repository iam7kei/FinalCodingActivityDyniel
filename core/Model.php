<?php

namespace app\core;

use app\models\ValidationModel;

abstract class Model extends ValidationModel
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MATCH = 'match';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_PALINDROME = 'palindrome';
    public const RULE_UNIQUE = 'unique';
    public const RULE_EXISTS = 'exists';
    public const RULE_UPDATE = 'update';
    public const RULE_PRICE = 'price';
    public const RULE_ONCE = 'once';

    abstract public function rules(): array;
    public array $errors = [];

    public function loadData($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }
    public function validate(string $ruleType)
    {
        foreach ($this->{$ruleType}() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $ruleName = $rule;

                if (!is_string($ruleName)) {
                    $ruleName = $rule[0];
                }

                if ($ruleName === self::RULE_REQUIRED && !$value) {
                    $this->addRuleError($attribute, self::RULE_REQUIRED);
                }
                if ($ruleName === self::RULE_EMAIL && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    $this->addRuleError($attribute, self::RULE_EMAIL);
                }

                if ($ruleName === self::RULE_MIN && $this->validateMin($value, $rule['min'])) {
                    $this->addRuleError($attribute, self::RULE_MIN, $rule);
                }

                if ($ruleName === self::RULE_MAX && $this->validateMax($value, $rule['max'])) {
                    $this->addRuleError($attribute, self::RULE_MAX, $rule);
                }

                if ($ruleName === self::RULE_MATCH && $this->validateMatch($value, $this->{$rule['match']})) {
                    $this->addRuleError($attribute, self::RULE_MATCH, $rule);
                }

                if ($ruleName === self::RULE_PALINDROME && !$this->isPalindrome()) {
                    $this->addRuleError($attribute, self::RULE_PALINDROME);
                }
                if ($ruleName === self::RULE_UNIQUE && $this->validateUnique($rule, $attribute, $value)) {
                    $this->addRuleError($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                }

                if ($ruleName === self::RULE_UPDATE) {
                    if (!$this->validateNewData($attribute, $value)) {
                        if (isset($rule['class'])) {
                            if ($this->validateUnique($rule, $attribute, $value)) {
                                $this->addRuleError($attribute, self::RULE_UNIQUE, ['field' => $attribute]);
                            }
                        }
                    }
                }
                if ($ruleName === self::RULE_PRICE && !filter_var($value, FILTER_VALIDATE_FLOAT)) {
                    $this->addRuleError($attribute, self::RULE_PRICE);
                }

                if ($ruleName === self::RULE_ONCE) {
                    $model = new $rule['class']();
                    if ($model->findRecord($rule['where'])) {
                        $this->addRuleError($attribute, self::RULE_ONCE, ['table' => $model::tableName()]);
                    }
                }
            }
        }
        return empty($this->errors);
    }

    private function addRuleError(string $attribute, string $rule, $params = [])
    {
        $message = $this->errorMessages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function addError(string $attribute, string $message)
    {
        $this->errors[$attribute][] = $message;
    }

    public function errorMessages()
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_EMAIL => 'This field must be a valid email address',
            self::RULE_MATCH => 'This field must match with {match}',
            self::RULE_PALINDROME => 'Not a palindrome',
            self::RULE_UNIQUE => 'This {field} already exists',
            self::RULE_EXISTS => 'This {field} does not exists',
            self::RULE_PRICE => 'Please enter a valid price',
            self::RULE_ONCE => 'This is already in {table}'
        ];
    }

    public function hasError($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }
    public function getFirstError($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}
