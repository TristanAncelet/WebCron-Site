<?php
echo "Total Crontabs:<br>";
$crontab_counts=shell_exec('../../Scripts/count-crontabs.sh');
echo "$crontab_counts";
?>
