<?php  $form = \app\core\form\Form::begin('', 'post'); ?>
<?php echo $form->field($model, 'name', 'Name')?>
<?php echo $form->field($model, 'sku', 'SKU') ?>
<?php echo $form->field($model, 'url_key', 'URL Key')?>
<?php echo $form->field($model, 'price', 'Price', 'text')?>
<?php echo $form->field($model, 'description', 'Description')?>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
<?php  \app\core\form\Form::end();?>
