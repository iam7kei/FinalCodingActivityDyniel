<?php

namespace app\models\catalog\products;

use app\core\Application;
use app\core\DbModel;

class ProductModel extends DbModel
{
    public string $sku = '';
    public string $name = '';
    public string $url_key = '';
    public string $description = '';
    public string $price = '0.00';
    public string $subject = '';
    public string $comment = '';
    public array $oldData = [];

    public function tableName(): string
    {
        return 'products';
    }

    public function attributes(): array
    {
        return [
            'sku',
            'name',
            'url_key',
            'description',
            'price'

        ];
    }

    public function getPrimaryKey(): string
    {
        return 'product_id';
    }

    public function rules(): array
    {
        return [];
    }

    public function loadData($data)
    {
        parent::loadData($data);

        $this->url_key = preg_replace('/ /i', '-', trim($this->url_key));
        $this->sku = preg_replace('/ /i', '-', trim($this->sku));
    }

    public function loadOldData(array $oldData)
    {
        $this->oldData = [
            'sku' => $oldData['sku'],
            'name' => $oldData['name'],
            'url_key' => $oldData['url_key'],
            'description' => $oldData['description'],
            'price' => $oldData['price']
        ];
    }

    public function validateNewData(string $attribute, string $value)
    {
        if ($value !== $this->oldData[$attribute]) {
            return false;
        }
        return true;
    }

    public function updateRules(): array
    {
        return [
            'sku' => [self::RULE_REQUIRED, [
                self::RULE_UPDATE, 'class' => self::class, 'field' => 'sku'
            ]
            ],
            'name' => [self::RULE_REQUIRED],
            'url_key' => [self::RULE_REQUIRED, [
                self::RULE_UPDATE, 'class' => self::class, 'field' => 'url_key'
            ]
            ],
            'price' => [self::RULE_PRICE]
        ];
    }

    public function addRules(): array
    {
        return [
            'sku' => [self::RULE_REQUIRED, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'name' => [self::RULE_REQUIRED],
            'url_key' => [self::RULE_REQUIRED, [
                self::RULE_UNIQUE, 'class' => self::class
            ]],
            'price' => [self::RULE_REQUIRED,self::RULE_PRICE]
        ];
    }

    public function sanitize()
    {
    }
}
