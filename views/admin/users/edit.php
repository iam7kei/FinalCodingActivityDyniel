<?php  $form = \app\core\form\Form::begin('', 'post'); ?>
<?php echo $form->field($model, 'name', 'Name') ?>
<?php echo $form->field($model, 'username', 'Username')?>
<?php echo $form->field($model, 'password', 'Password', 'password')?>
    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
<?php  \app\core\form\Form::end();?>
<?php  $form = \app\core\form\Form::begin(
    '/admin/users/delete/' . \app\core\Application::$app->request->getLastSlug(),
    'post'
);
?>
    <a href="/admin/users/delete/<?php  echo\app\core\Application::$app->request->getLastSlug()?>"
    ><button class="btn btn-danger">Delete</button>
    </a>

<?php  \app\core\form\Form::end();?>
