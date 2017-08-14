<?php

spl_autoload_register(function ($className) {
    $arrayPaths = array(
        ROOT.'/classes/'
    );

    foreach ($arrayPaths as $path) {
        $filePath = $path.$className.'.php';

        if (is_file($filePath)) {
            require $filePath;

            return;
        }

    }

    throw new Exception("Error, file $className.php not found", 1);
});
