<?php
    /*
    GET Variables
        name: Name of crontab
    */
    $GLOBALS['db'] = new SQLite3('../../webcron.db');
    
    if (!array_key_exists("name", $_GET)) {
        $name = "";
    } else {
        $name = $_GET["name"];
    }

    $db = $GLOBALS['db'];
    $id = $db->querySingle("select crontab_id from crontabs where crontab_path like '%/$name';");
    
    if (empty($id)){
        echo "$name is not a valid crontab";
    } else {
        $data = $db->querySingle("SELECT crontab_data FROM crontabs WHERE crontab_id = $id;");
        echo "$data";
    }




?>