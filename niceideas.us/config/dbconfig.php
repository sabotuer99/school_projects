<?php

define('DB_SERVER', 'fdb4.freehostingeu.com');
define('DB_USERNAME', '1250984_ni');
define('DB_PASSWORD', 'sentry5');
define('DB_DATABASE', '1250984_ni');
$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die(mysql_error());
$database = mysql_select_db(DB_DATABASE) or die(mysql_error());
?>
