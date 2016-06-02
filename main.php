<?php
/**
 * Created by PhpStorm.
 * User: Laura 5
 * Date: 5/27/2016
 * Time: 5:46 PM
 */

include("functions.php");
$connection = doConnect();
?>

<html>
    <head>
        <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
    </head>
    <body>
        <h1>view languages (all)</h1>
        <?php
            var_dump(viewLanguages($connection));
        ?>

        <h1>view languages(user specific)</h1>
        <?
            var_dump(viewLanguages($connection,1));
        ?>

        <h1>pair view</h1>
        <?
            var_dump(getPair($connection));
        ?>

        <h1>enroll</h1>
        <? echo enroll($connection,1,1,1); ?>

        <h1>unenroll</h1>
        <? echo unenroll($connection,1,1,1); ?>
    </body>
</html>