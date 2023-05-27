#!/usr/bin/php

<?php
require("Libraries/db/query.php");
use db\Query;

$query = new Query("crontabs");
$query->set_limit(-1);

echo $query->get_query_string();
?>
