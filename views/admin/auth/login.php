<div class="container">
    <?php  $form = \app\core\form\Form::begin('', 'post')?>
    <div class="mb-3">
        <?php echo $form->field($model, 'username', 'Username', 'text')?>
    </div>
    <div class="mb-3">
        <?php echo $form->field($model, 'password', 'Password', 'password')?>
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
    <?php  \app\core\form\Form::end();?>

</div>
