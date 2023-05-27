<?php
/*
This endpoint will get & edit specific tables from the db
<REQUEST METHOD>:
  - <action>

GET:
  - show (show individual tables)
  - list (list table names)

*/

require('../Libraries/table/get.php');


# Setting up DB connection
$GLOBALS['db'] = new SQLite3("../../webcron.db");

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        get_main();
        break;
    case 'POST':
        break;
}
   

?>