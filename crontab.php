
<!Doctype html>
<html>
    <head>
        <!-- <script src="https://cdn.tailwindcss.com"></script> -->
        <link rel="stylesheet" href="css/main.css">
        <script src="main.js"> </script>
        <title><?php 
        $filename = ucfirst(explode('.',basename($_SERVER['SCRIPT_FILENAME']))[0]);
        echo $filename;
        ?> Management</title>
    </head>
    <body>
        <nav>
            <a class='nav-button' href='index.php'>Log Management</a>
            <?php
                $items = scandir(".");
                foreach ($items as $item){
                    if (preg_match('/\.php$/', $item) && $item != "index.php"){
                        $item_name=ucfirst(explode('.', $item)[0]);
                        echo  "<a class='nav-button' href='$item'>$item_name Management</a>";
                    }
                }
            ?>
        </nav>

        <div class="content_area bordered rounded_border">

            <div class="menu_bar bordered_right cell">
                <button class="menu_button" onclick="setCrontabStats()"> View Crontab Statistics </button>
                <button class="menu_button" onclick="getTable('job_history')">View Script Run History</button>
                <button class="menu_button" onclick="listCrontabs()">View Crontabs</button>
                <button class="menu_button" onclick="test()">Test</button>
            </div>

            <div id="content" class="content cell">
           </div>

            <div class="double_width_menu_bar bordered_left cell">
                <div class="wrapper bordered center_text">
                    All Crontabs
                    <div id="log_statistics_table" class="log_table bordered">
                        <div class="table_row">
                            <div class="table_header">Crontab</div> <div class="table_header">Created At</div><div class="table_header">Last Modified</div>
                        </div>
                        <?php
                        $db = new SQLite3('../webcron.db');
                        $res = $db->query("SELECT crontab_path, crontab_created_timestamp, crontab_modified_timestamp FROM crontabs;");

                        while ($row = $res->fetchArray()){
                            echo "<div class=\"table_row\">";
                            echo "<div class=\"table_cell\">{$row['crontab_path']}</div> <div class=\"table_cell\">{$row['crontab_created_timestamp']}</div><div class=\"table_cell\">{$row['crontab_modified_timestamp']}</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>

            </div>
        </div>

   </body>
</html>