<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="powcm">
    <title><?php echo $title; ?></title>
    <?php
        foreach(
            array(
            ) as $style
        ){
            echo "<link rel='stylesheet' type='text/css' href='\\public" . DS . 'css' . DS . $style . "' />\n";
        }
        
        foreach(
            array(
            ) as $script
        ){
            echo "<script type='text/javascript' defer='defer' src='\\public" . DS . 'js' . DS . $script . "' ></script>\n";
        }
    ?>
</head>
<body>