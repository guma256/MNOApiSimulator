<?php


    /*
     * System Paths
     */
    $conf = parse_ini_file("conf/config.ini",true);

    define('LIBS', 'libs/');
    define('gw_callback'  ,$conf['gconnect']['connect']);


?>
