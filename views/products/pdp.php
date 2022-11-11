<?php
?>

<h1><?php echo $model->name;?></h1>
<h2>&#36;<?php echo $model->price;?></h2>
<p><?php echo $model->description;?></p>
<?php $form = \app\core\form\Form::begin(
    '/products/add/wishlist/' . \app\core\Application::$app->request->getLastSlug(),
    'post'
)
?>
<button type="submit" class="btn btn-primary">Add to wishlist</button>
<?php $form->end() ?>

<?php $form->begin(
    '/products/add/comment/' . \app\core\Application::$app->request->getLastSlug(),
    'post'
) ?>
<?php echo $form->field($model, 'subject', 'Subject') ?>
<?php echo $form->field($model, 'comment', 'Add a Comment') ?>
<button type="submit" class="btn btn-primary">Add comment</button>
<?php $form->end() ?>

<?php
\app\controllers\CommentController::renderComments($comments);
