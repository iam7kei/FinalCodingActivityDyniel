<?php  $form = \app\core\form\Form::begin('', 'post'); ?>
<?php echo $form->field($model, 'name', 'Name') ?>
<?php echo $form->field($model, 'username', 'Username')?>
<?php echo $form->field($model, 'password', 'Password', 'password')?>
<?php echo $form->field($model, 'confirmPassword', 'Confirm Password', 'password')?>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
<?php  \app\core\form\Form::end();?>
