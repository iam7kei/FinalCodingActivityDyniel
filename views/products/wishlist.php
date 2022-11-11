<?php $form = \app\core\form\Form::begin('wishlist/delete', 'post') ?>
<button type="submit" class="btn btn-danger">Remove wishlist</button>
<?php $form->end();?>
<?php

$table = \app\core\elements\Table::start();
echo \app\models\catalog\products\WishlistModel::renderWishlistData();
