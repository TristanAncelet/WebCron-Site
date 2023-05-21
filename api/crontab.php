<?php
    /*

    /api/crontab.php

    This script is meant to act as a interface for in logic for 
    */
    if (array_key_exists("action",$_GET)){
        $action=$_GET['action'];
    }

    $db = new SQLite3("../../webcron.db");

    switch ($action) {
        case "list":
            $res = $db->query("SELECT crontab_id, crontab_path FROM crontabs;");
            while ($row = $res->fetchArray()){
                echo "<button onclick=loadCrontab({$row['crontab_id']})>{$row['crontab_path']}</button><br>";
            }
            break;
    } 

?>