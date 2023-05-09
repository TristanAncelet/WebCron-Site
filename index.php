<!Doctype html>
<!-- 
    Color pallet: https://colorhunt.co/palette/b9eddd87cbb9569daa577d86 
-->
<html>
    <head>
        <!-- <script src="https://cdn.tailwindcss.com"></script> -->
        <link rel="stylesheet" href="css/main.css">
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
            </div>

            <div class="content cell">
                test
                <?php
                echo "<br>";
                echo "<ul>";
                for ($x = 0; $x <= 10; $x++){
                    echo "<li> Hey there $x </li>";
                }
                echo "</ul>";
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
                        <div class="table_row">
                            <div class="table_cell">Warning</div> <div class="table_cell">N/A</div>
                        </div>
                        <div class="table_row">
                            <div class="table_cell">Critical</div> <div class="table_cell">N/A</div>
                        </div>
                        <div class="table_row">
                            <div class="table_cell">Info</div> <div class="table_cell">N/A</div>
                        </div>
                    </div>
                </div>

                <div class="wrapper bordered center_text">
                    Script Failures (Last 10)
                    <div id="script_failures" class="log_table">
                        <div class="table_row">
                            <div class="table_header">Date</div> <div class="table_header">Script</div>
                        </div>
                    </div>
                </div>

                <div class="wrapper bordered center_text">
                    Jobs Run (Last 10)
                    <div id="jobs_run_table" class="log_table">
                        <div class="table_row">
                            <div class="table_header">Date/Time</div> <div class="table_header">Script</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

   </body>
</html>