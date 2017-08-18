<?php
define('BASEDIR',realpath(dirname(__FILE__) . '/..') . '/');

// DB config global.
define('DBHOST','localhost');
define('DBUSER','root');
define('DBNAME','mapbox');
define('DBPASSWD','123pass');
// Connect string for PDO
define('DBCONN', 'host=' . DBHOST);
// Charset
define('DBCHARSET','utf8');
// Timezone
define('DBTIMEZONE','+2:00');
// Admin mail.
define('ADMINMAIL','moriarti@cp.if.ua');

// Debuging On/Off.
define('DEBUG',true);

// ErrorSupervisor.
define('ERROR_FILE',BASEDIR.'../logs/main.errors.log');
