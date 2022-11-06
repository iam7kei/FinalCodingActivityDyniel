<div class="container">
    <?php $form = \app\core\form\Form::begin('', 'post')?>
    <?php echo $form->field($model, 'palindrome', 'Palindrome')?>
    <button type="submit" class="btn btn-primary">Submit</button>
    <?php  \app\core\form\Form::end();?>
    <?php if ($isPalindrome) {
        echo $form->alert($model);
    } ?>
</div>
