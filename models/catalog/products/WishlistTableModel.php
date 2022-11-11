<?php

namespace app\models\catalog\products;

use app\models\CustomerModel;
use app\models\DbTableModel;

class WishlistTableModel extends DbTableModel
{
    public function gridAttrbiutes(): array
    {
        return [
            'wishlist_id',
            'customer_id',
            'product_id'
        ];
    }

    public function gridAttributeLabels(): array
    {
        return [
            'wishlist_id' => 'Wishlist',
            'customer_id' => 'Customer',
            'product_id' => 'Product'
        ];
    }

    public function getPrimaryKey(): string
    {
        return 'wishlist_id';
    }

    public function getCustomerEmail(array $tableData): array
    {
        foreach ($tableData as $row => $attributes) {
            $result = CustomerModel::findRecord([
                'customer_id' => $attributes['customer_id']
            ]);

            $tableData[$row]['email'] = $result->email;
        }
        return $tableData;
    }
}
