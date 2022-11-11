<?php

namespace app\models;

class ProductTableModel extends DbTableModel
{
    public const ADMIN_EDIT_PATH = '/admin/products/edit/';
    public const PDP_PATH = '/products/';
    public function gridAttrbiutes(): array
    {
        return [
            'product_id',
            'sku',
            'name',
            'url_key'
        ];
    }

    public function gridAttributeLabels(): array
    {
        return [
            'product_id' => "ID",
            'sku' => "SKU",
            'name' => "Name",
            'url_key' => "URL Key"
        ];
    }
    public function getPrimaryKey(): string
    {
        return 'product_id';
    }
}
