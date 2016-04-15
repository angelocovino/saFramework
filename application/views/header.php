<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <style>
        <?php
        /*
        body{
            background-color:rgb(33,33,33);
            color:white;
        }
        a, a:link, a:active, a:hover, a:visited{
            color:white;
        }
        */
        ?>
    <?php
        if(isset($styles)):
            foreach($styles as $style):
                include($style);
                //echo "<link rel='stylesheet' type='text/css' href='/saFramework/application/views/items/style.css' />\n";
                //echo "<link rel='stylesheet' type='text/css' href='{$style}' />\n";
            endforeach;
        endif;
    ?>
    </style>
    <title><?php echo $title; ?></title>
</head>
<body>