<?php
include("../Libraries/table/class.php");
$db = new SQLite3("../../webcron.db");
$table = new Table("crontabs");

$table->Load($db, "");

echo $table->get_html();
?>
