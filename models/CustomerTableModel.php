<?php

namespace app\models;

class CustomerTableModel extends DbTableModel
{
    public const ADMIN_EDIT_PATH = '/admin/customers/edit/';
    public function gridAttrbiutes(): array
    {
        return [
            'customer_id',
            'email',
            'name'
        ];
    }

    public function gridAttributeLabels(): array
    {
        return [
            'customer_id' => 'ID',
            'email' => 'Email',
            'name' => 'Name'
        ];
    }

    public function getPrimaryKey(): string
    {
        return 'customer_id';
    }
}
