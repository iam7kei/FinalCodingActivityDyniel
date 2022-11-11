<?php

$table = \app\core\elements\Table::start();
echo $table->thead($tableHeaders);
echo $table->tbody($tableBody);
echo $table->end();
