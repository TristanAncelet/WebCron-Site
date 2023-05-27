<?php

require("class.php");
use table\Table;
function get_main () {
    $db = $GLOBALS["db"];
    /*
    Args will be:
    name: Table Name
    limit: number of entries to return (default all)
    columns: This will be a comma delimited list of column names (in the order that it needs to be displayed)
    */

    // BEGIN: Getting Args if exists

    if ( array_key_exists('action', $_GET)){
        $action=$_GET['action'];
    } else {
        $action="show";
    }

    // END: Getting Args if exists

    switch ($action){
        case "show":
            // BEGIN: Get show args
            if ( ! array_key_exists("name", $_GET) ){
                echo "A tablename was not provided with the request";
                return 1;
            } else {
                $name=$_GET['name'];
                $table = new Table($name);
                $query = $table->get_query();
            }

            if ( array_key_exists("limit", $_GET)){
                $limit=$_GET['limit'];
            } else {
                $limit=0;
            }

            $query->set_limit($limit);

            if ( array_key_exists("columns", $_GET)){
                $columns = explode(',', $_GET["columns"]);
            }

            $query->set_columns($columns);
            // END: Get show args

            $query_modifier="";
            if (filter_var($limit, FILTER_VALIDATE_INT)){
                if ($limit > 0){
                    $query_modifier="WHERE LIMIT $limit";
                } 
                }else {
                    $query_modifier="";
                }
                $table->Load($db);
                $output = $table->get_html();
                echo $output;

            break;
    
    case "list":
        $res = $db->query("SELECT name FROM sqlite_master WHERE type='table';");
        while ($row = $res->fetchArray()){
            echo "<button onclick='getTable(\"{$row['name']}\")'>{$row['name']}</button><br> ";
        }
        break;
    }

}
?>