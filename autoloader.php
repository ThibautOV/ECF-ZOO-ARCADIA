<?php

namespace App;

class Autoloader
{
    public static function register()
    {
        require __DIR__ . '/vendor/autoloader.php';
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    public static function autoload($class)
    {
        if (strpos($class, __NAMESPACE__) === 0) {

            $class = str_replace(__NAMESPACE__ . '\\', '', $class);

            $class = str_replace('\\', '/', $class);

            $file = __DIR__ . '/' . $class . '.php';

            if (file_exists($file)) {
                require_once $file;
            } else {
                error_log("autoloader error $file");
            }
        }
    }
}
