<?php
$db = new SQLite3("../../webcron.db");
$res = $db->querySingle("SELECT COUNT(*) FROM crontabs");
echo "Total Crontabs:$res<br>";
?>
