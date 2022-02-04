<?php

include_once 'dbConfig.php';

$db = new mysqli($hostName, $username, $password, $dbName);

$matric = $_POST['matricNumber'];

$res = $db->query("SELECT * FROM `Biodata` WHERE `MatricNumber` = '$matric'");

if (mysqli_num_rows($res)) header("Location:retrieve.php?matricNumber=$matric");
else header("Location:new.html?matricNumber=$matric");

?>