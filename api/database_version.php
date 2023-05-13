<?php
$ver = SQLite3::version();
$versionString=$ver['versionString'];
$versionNumber=$ver['versionNumber'];
echo "Database Type: SQLite3<br>";
echo "Version: $versionString <br>";
echo "Version Number: $versionNumber" ;
?>