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

            <div class="single_width menu_bar bordered_right cell border_rounded_left">
                <button class="menu_button" onclick="setDatabaseVersion()"> View Database Version</button>
                <button class="menu_button" onclick="listTables()"> View Tables </button>
            </div>

            <div id="content" class="content cell">
            </div>

            <div class="double_width menu_bar bordered_left cell border_rounded_right">

            </div>
        </div>

   </body>
</html>