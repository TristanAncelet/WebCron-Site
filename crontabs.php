
<!Doctype html>
<html>
    <head>
        <!-- <script src="https://cdn.tailwindcss.com"></script> -->
        <link rel="stylesheet" href="css/main.css">
        <script src="main.js"> </script>
        <title>This is a test</title>
    </head>
    <body>
        <nav>
            <a class="nav-button" href='/'>Logs/Statistics</a>
            <a class="nav-button" href='/crontabs.php'>Crontab Management</a>
            <a class="nav-button" href='contact.php'>Contact</a>
        </nav>

        <div class="content_area bordered rounded_border">

            <div class="menu_bar bordered_right cell">
                <button class="menu_button"> Check Logs </button>
                <button class="menu_button"> View Crontab Statistics</button>
                <button class="menu_button" onclick="setInfoSection()"> View Database Version</button>
            </div>

            <div id="content" class="content cell">
                Total Crontabs:<br>
                <?php
                    $crontab_counts=shell_exec('./count-crontabs.sh');
                    echo "$crontab_counts";
                ?>
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