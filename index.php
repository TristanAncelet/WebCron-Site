<?php
$root = $_SERVER['DOCUMENT_ROOT'];
require "$root/Libraries/table/class.php";
use table\Table;
$db = new SQLite3("../webcron.db");
?>
<!Doctype html>
<!-- 
    Color pallet: https://colorhunt.co/palette/b9eddd87cbb9569daa577d86 
-->
<html>
    <head>
        <link rel="stylesheet" href="/css/main.css">
        <script src="/js/main.js"> </script>
        <title>Overview</title>
    </head>
    <body>
        <nav>
            <a class='nav-button' href='/index.php'>Log Management</a>
            <?php
                $items = scandir(".");
                foreach ($items as $item){
                    if (preg_match('/\.php$/', $item) && $item != "index.php"){
                        $item_name=ucfirst(explode('.', $item)[0]);
                        echo  "<a class='nav-button' href='$item'>$item_name Management</a>";
                    }
                }
            ?>
            <a class='nav-button' href='admin/index.php'>Administration</a>
        </nav>

        <div class="content_area bordered rounded_border">

            <div class="single_width menu_bar bordered_right cell border_rounded_left">
                <button class="menu_button" onclick="getLogHistory()"> Check Logs </button>
            </div>

            <div id="content" class="content cell">
                Test
                <br>
                <?php
                $user=shell_exec("whoami");
                echo "User: $user<br>";
                $res = $db->querySingle("SELECT COUNT(job_id) FROM job_history;");
                echo "Job History Entries: $res<br>";
                $res = $db->querySingle("SELECT COUNT(log_id) FROM logs;");
                echo "Log Entries: $res<br>";
                ?>
            </div>

            <div class="double_width menu_bar bordered_left cell border_rounded_right">
                <?php
                $table = new Table("log_statistics_last_7_days");
                $table->set_pretty_name("Log Statistics (Last 7 Days)");
                $table->Load($db);
                echo $table->get_html();

                $table = new Table("last_ten_failed_jobs");
                $table->set_pretty_name("Script Failures (Last 10)");
                $table->Load($db);
                echo $table->get_html();
                

                $table = new Table("job_history");
                $table->set_pretty_name("Jobs Run (Last 10)");
                $query = $table->get_query();
                $query->set_order_by_column("job_timestamp DESC");
                $query->set_limit(10);
                $table->Load($db);
                echo $table->get_html();
                ?>
            </div>
        </div>

   </body>
</html>