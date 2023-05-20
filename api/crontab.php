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
            $res = $db->query("SELECT crontab_path FROM crontabs;");
            while ($row = $res->fetchArray()){
                exit;
            }
            break;
    } 

?>