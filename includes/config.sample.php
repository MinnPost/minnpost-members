<?php

$db = new mysqli('host', 'username', 'password', 'databasename');

if($db->connect_errno > 0){
    die('Unable to connect to database [' . $db->connect_error . ']');
}

$table = 'tablename';