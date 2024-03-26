<?php

$conf = parse_ini_file("conf/config.ini",true);

define('GW_URL', $conf['gconnect']['connect']);
/*
 * Development Environment DB Parameters
 *
 */

ini_set('memory_limit', '-1');
define('TIMEZONE', $conf['datastore']['timezone']);
define('DB_TYPE', $conf['datastore']['dtype']);
/* PDN  */
define('DB_HOST'  ,$conf['datastore']['dhost']);
define('DB_USER'  ,$conf['datastore']['duser']);
define('DB_PASS'  ,$conf['datastore']['dpass']);
define('DB_NAME'  ,$conf['datastore']['dname']);
define('DB_QUERY_LIMIT'  ,$conf['datastore']['process_limit']);