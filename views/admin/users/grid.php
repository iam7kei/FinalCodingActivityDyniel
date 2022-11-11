<?php ?>
    <a href="/admin/users/add" ><button type="submit" class="btn btn-primary">Add New</button></a>
<?php

$table = \app\core\elements\Table::start();
echo $table->thead($tableHeaders);
echo $table->tbody($tableBody);
echo $table->end();

?>
