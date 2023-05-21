<?php
/*
UPDATE:
target=<string>
*/


if (array_key_exists("target", $_GET)){
    $target=$_GET['target'];
}

switch ($target) {
    case "crontabs":
        shell_exec("../../Scripts/update-databse.sh");
        break;
}

return 0;

?>