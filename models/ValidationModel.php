<?php

namespace app\models;

use app\core\Application;

abstract class ValidationModel
{
    public function validateMin(string $value, int $min): bool
    {
        return strlen($value) < $min;
    }
    public function validateMax(string $value, int $max): bool
    {
        return strlen($value) > $max;
    }
    public function validateMatch(string $value, string $match): bool
    {
        return $value !== $match;
    }
    public function validateUnique(array $rule, $attribute, $value)
    {

        $className = $rule['class'];
        $uniqueAttr = $attribute = $rule['attribute'] ?? $attribute;
        $tableName = $className::tableName();
        $statement = Application::$app->db->prepare(
            "SELECT * FROM $tableName WHERE $uniqueAttr = :attr"
        );
        $statement->bindValue(":attr", $value);
        $statement->execute();
        return $result = $statement->fetchObject();
    }
}
