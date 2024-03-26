<?php

# ini_set('safe_mode',1);
 ini_set('display_errors',1);

 require 'libs/settings.php';

require 'config.php';

spl_autoload_register(function ($class) {
    include LIBS . $class . '.php';
});

$app = new Bootstrap();
