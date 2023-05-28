<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/Libraries/table/class.php";
use table\Table;
$db = new SQLite3("../webcron.db");
?>
<!Doctype html>
<html>
    <head>
        <!-- <script src="https://cdn.tailwindcss.com"></script> -->
        <link rel="stylesheet" href="/css/main.css">
        <script src="/js/main.js"> </script>
        <title><?php 
        $filename = ucfirst(explode('.',basename($_SERVER['SCRIPT_FILENAME']))[0]);
        echo $filename;
        ?> Management</title>
    </head>
    <body>
        <nav>
            <a class='nav-button' href='/index.php'>Log Management</a>
            <?php
                $items = scandir($root);
                foreach ($items as $item){
                    if (preg_match('/\.php$/', $item) && $item != "index.php"){
                        $item_name=ucfirst(explode('.', $item)[0]);
                        echo  "<a class='nav-button' href='$item'>$item_name Management</a>";
                    }
                }
            ?>
            <a class='nav-button' href='/admin/index.php'>Administration</a>
        </nav>

        <div class="content_area bordered rounded_border">

            <div class="single_width menu_bar bordered_right cell border_rounded_left">
                <button class="menu_button" onclick="setCrontabStats()"> View Crontab Statistics </button>
                <button class="menu_button" onclick="getTable('job_history')">View Script Run History</button>
                <button class="menu_button" onclick="listCrontabs()">View Crontabs</button>
                <button class="menu_button" onclick="test()">Test</button>
            </div>

            <div id="content" class="content cell">
           </div>

        <div class="double_width menu_bar bordered_left cell border_rounded_right">
           <?php
           $columns = array(
            'crontab_path AS "Crontab Path"',
            'crontab_created_timestamp AS "Created At"',
            'crontab_modified_timestamp AS "Last Modified At"'
           );
           $table = new Table("crontabs");
           $table->set_pretty_name("Crontabs");
           $query = $table->get_query();
           $query->set_columns($columns);
           $table->Load($db);
           echo $table->get_html();
           ?>

        </div>
    </div>

   </body>
</html>