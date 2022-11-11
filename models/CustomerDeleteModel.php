<?php

namespace app\models;

use app\core\DbModel;

class CustomerDeleteModel extends DbModel
{
    public function rules(): array
    {
        return [];
    }

    public function tableName(): string
    {
        return 'customer';
    }

    public function attributes(): array
    {
        return [];
    }

    public function getPrimaryKey(): string
    {
        return 'customer_id';
    }
}
