<?php

namespace app\models\catalog\products;

use app\core\DbModel;
use app\core\elements\Card;
use app\core\Session;
use app\models\CustomerModel;

class WishlistModel extends DbModel
{
    public string $customer_id = '';
    public string $product_id = '';
    public function rules(): array
    {
        return [
            'product_id' => [[
                self::RULE_ONCE,
                'class' => self::class,
                'where' => [
                    'product_id' => $this->product_id,
                    'customer_id' => $this->customer_id
                ]
            ]]
        ];
    }

    public function getPrimaryKey(): string
    {
        return 'wishlist_id';
    }

    public function tableName(): string
    {
        return 'wishlist';
    }

    public function attributes(): array
    {
        return ['customer_id','product_id'];
    }

    public function wishlistProductKeys(): array
    {
        return [
            'name',
            'sku',
            'price'
        ];
    }

    public function setWishlistData(string $product_id)
    {
        $this->customer_id = Session::get(CustomerModel::getPrimaryKey());
        $this->product_id = $product_id;
    }

    public function renderWishlistData()
    {
        $content = '';

        $primarykey = CustomerModel::getPrimaryKey();
        $wishlist = self::findAllOf([
            $primarykey => Session::get($primarykey)
        ]);

        foreach ($wishlist as $row => $data) {
            $productID = $data['product_id'];
            $wishlistProductData = [];
            $productData = (array) ProductModel::findRecord([
                ProductModel::getPrimarykey() => $productID
            ]);
            $productData['price'] = '&#36;' . $productData['price'];
            $content .= Card::renderCard(self::wishlistProductKeys(), $productData);
        }
        return $content;
    }
}
