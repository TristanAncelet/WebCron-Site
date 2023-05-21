<?php
    /*
    GET Variables
      Optional:
        id: id of the crontab
    */
    $GLOBALS['db'] = new SQLite3('../../webcron.db');
    
    if (!array_key_exists("id", $_GET)) {
        $name = "";
    } else {
        $id = $_GET["id"];
    }

    $db = $GLOBALS['db'];
    
    if (empty($id)){
        echo "$name is not a valid crontab";
    } else {
        $data = $db->querySingle("SELECT crontab_data FROM crontabs WHERE crontab_id = $id;");
        $lines = explode("\n", $data);
        foreach ($lines as $line){
            echo "$line<br>";
        }
    }




?>