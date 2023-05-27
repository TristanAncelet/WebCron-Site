<?php
/*
This endpoint will get & edit specific tables from the db
<REQUEST METHOD>:
  - <action>

GET:
  - show (show individual tables)
  - list (list table names)

*/


namespace table;
use SQLite3;
$root = $_SERVER['DOCUMENT_ROOT'];
$GLOBALS['db'] = new SQLite3("../../webcron.db");
require("$root/Libraries/table/get.php");


# Setting up DB connection

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        get_main();
        break;
    case 'POST':
        break;
}
   

?>