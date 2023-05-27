<?php

require("class.php");
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
            }

            if ( array_key_exists("limit", $_GET)){
                $limit=$_GET['limit'];
            } else {
                $limit=0;
            }

            if ( array_key_exists("columns", $_GET)){
                $columns = explode(',', $_GET["columns"]);
            }
            // END: Get show args

            $query_modifier="";
            if (filter_var($limit, FILTER_VALIDATE_INT)){
                if ($limit > 0){
                    $query_modifier="WHERE LIMIT $limit";
                } 
                }else {
                    $query_modifier="";
                }

                $res = $db->query("SELECT * FROM $name $query_modifier");
                echo '<div class="wrapper bordered center_text">'; 
                echo '<div class="log_table bordered">'; 
                echo '<div class="table_row">';
                    if ( !empty($columns) ) {
                        foreach($columns as $column_name){
                            echo "<div class=\"table_header\">{$column_name}</div>";
                        }
                    } else {
                        $counter=0;
                        for ($i = 0; $i < $res->numColumns(); $i++ ){
                            echo "<div class=\"table_header\">{$res->columnName($i)}</div>";
                            $counter++;
                        }
                    }

                    echo '</div>';
                    while ($row = $res->fetchArray()){
                        echo "<div class=\"table_row\">";
                        if ( !empty($columns) ) {
                            foreach($columns as $column_name){
                                echo "<div class=\"table_cell\">{$row[$column_name]}</div>";
                            }
                        } else {
                            for ($i = 0; $i < $counter; $i++){
                                echo "<div class=\"table_cell\">{$row[$i]}</div>";
                            }
                        }
                        echo "</div>";
                    }
                echo '</div>';
                echo '</div>';
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