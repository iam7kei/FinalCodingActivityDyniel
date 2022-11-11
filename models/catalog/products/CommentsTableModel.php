<?php

namespace app\models\catalog\products;

use app\models\CustomerModel;
use app\models\DbTableModel;

class CommentsTableModel extends DbTableModel
{
    public function gridAttrbiutes(): array
    {
        return [
            'customer_id',
            'subject',
            'comment_date',
            'comment'
        ];
    }

    public function gridAttributeLabels(): array
    {
        return [
            'customer_id' => 'Customer',
            'subject' => 'Subject',
            'comment_date' => 'Date',
            'comment' => 'Comment'
        ];
    }

    public function getPrimaryKey(): string
    {
        return 'comment_id';
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
