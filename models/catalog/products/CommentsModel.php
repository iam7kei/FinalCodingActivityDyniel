<?php

namespace app\models\catalog\products;

use app\core\DbModel;
use app\core\Session;

class CommentsModel extends DbModel
{
    public string $product_id = '';
    public string $customer_id = '';
    public string $subject = '';
    public string $comment = '';
    public string $comment_date = '';
    public string $customer_username = '';

    public int $max = 120;
    public function tableName(): string
    {
        return 'comments';
    }

    public function attributes(): array
    {
        return [
            'product_id',
            'customer_id',
            'comment_date',
            'subject',
            'comment'
        ];
    }

    public function getPrimaryKey(): string
    {
        return 'comment_id';
    }

    public function rules(): array
    {
        return [];
    }
    public function addRules(): array
    {
        return [
            'subject' => [self::RULE_REQUIRED],
            'comment' => [self::RULE_REQUIRED,[
                self::RULE_MAX, 'max' => $this->max
            ]]
        ];
    }

    public function loadGeneratedData(array $data)
    {
        foreach ($data as $attribute => $value) {
                $this->{$attribute} = $value;
        }
    }

    public function generateCommentData(string $product_id): array
    {
        return [
            'product_id' => $product_id,
            'customer_id' => Session::get('customer_id'),
            'comment_date' => date("Y-m-d")
        ];
    }
}
