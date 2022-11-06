<?php

    use app\core\Application;

?>
    <h1>Welcome
        <?php
        $displayedUser = 'Guest';
        if (!Application::isGuest()) {
            $displayedUser = Application::$app->user->getName();
        }
        echo $displayedUser;
        ?>
    </h1>
