<?php
//Variables declaration for connection to database
$db_host = 'localhost:3306';
$db_user = 'service';
$db_pass = '12345';
$db_db = 'test';

//Open connection
$db_link = mysqli_connect($db_host, $db_user, $db_pass, $db_db)
or die("Connection failed: " . mysqli_error($db_link));
?>