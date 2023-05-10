<!Doctype html>
<!-- 
    Color pallet: https://colorhunt.co/palette/b9eddd87cbb9569daa577d86 
-->
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
                Test
                <br>
                <?php
                $user=shell_exec("whoami");
                echo "User: $user<br>";
                $db = new SQLite3('../webcron.db');
                $res = $db->querySingle("SELECT COUNT(job_id) FROM job_history;");
                echo "Job History Entries: $res<br>";
                $res = $db->querySingle("SELECT COUNT(log_id) FROM logs;");
                echo "Log Entries: $res<br>";
                ?>
            </div>

            <div class="double_width_menu_bar bordered_left cell">
                <div class="wrapper bordered center_text">
                    Log Statistics (This Week)
                    <div id="log_statistics_table" class="log_table bordered">
                        <div class="table_row">
                            <div class="table_header">Level</div>
                            <div class="table_header"># of occurances</div>
                        </div>
                        <?php
                        $db = new SQLite3('../webcron.db');
                        $res = $db->query("SELECT * FROM log_statistics_last_7_days;");
                        while ($row = $res->fetchArray()){
                            echo "<div class='table_row'>";
                            echo "<div class='table_cell'>{$row['log_level_name']}</div> <div class='table_cell'>{$row['count']}</div>";
                            echo "</div>";
                        }
                        ?>
                    </div>
                </div>

                <div class="wrapper bordered center_text">
                    Script Failures (Last 10)
                    <div id="script_failures" class="log_table">
                        <div class="table_row">
                            <div class="table_header">Date/Time</div> <div class="table_header">Script</div> <div class="table_header">Exit Code</div> 
                        </div>
                        <?php
                            $db = new SQLite3('../webcron.db');
                            $res = $db->query("SELECT * FROM last_ten_failed_jobs;");
                            while ($row = $res->fetchArray()){
                                echo "<div class='table_row'>";
                                echo "<div class='table_cell'>{$row['job_timestamp']}</div> <div class='table_cell'>{$row['job_source']}</div><div class='table_cell'>{$row['job_exit_code']}</div>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                </div>

                <div class="wrapper bordered center_text">
                    Jobs Run (Last 10)
                    <div id="jobs_run_table" class="log_table">
                        <div class="table_row">
                            <div class="table_header">Date/Time</div> <div class="table_header">Script</div> <div class="table_header">Exit Code</div> <div class="table_header">Job Result</div>
                        </div>
                        <?php
                            $db = new SQLite3('../webcron.db');
                            $res = $db->query("SELECT * FROM job_history ORDER BY job_timestamp DESC LIMIT 10;");
                            while ($row = $res->fetchArray()){
                                echo "<div class='table_row'>";
                                echo "<div class='table_cell'>{$row['job_timestamp']}</div> <div class='table_cell'>{$row['job_source']}</div><div class='table_cell'>{$row['job_exit_code']}</div><div class='table_cell'>{$row['job_result']}</div>";
                                echo "</div>";
                            }
                        ?>
                    </div>
                </div>

            </div>
        </div>

   </body>
</html>