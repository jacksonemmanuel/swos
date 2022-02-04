<?php

include_once 'dbConfig.php';
include_once 'helpers.php';

$db = new mysqli($hostName, $username, $password, $dbName);

$matric = $_POST['matricNumber']; $sname = $db->real_escape_string(clean_name($_POST['surname'])); $fname = $db->real_escape_string(clean_name($_POST['firstName'])); $oname = $db->real_escape_string(clean_name($_POST['otherNames'])); $dob = $_POST['dateOfBirth']; $mode = $_POST['modeOfEntry']; $year = $_POST['yearOfEntry']; $fac = $_POST['facultyName']; $disc = $_POST['discipline']; $sex = $_POST['sex']; $cod = $_POST['classOfDegree']; $dop = $_POST['dateOfPresentation'];

$scoreQuery = "INSERT INTO `Scores` VALUES ";

for ($i = 0; $i < count($_POST['courseCode']); $i++) {
    $course = $_POST['courseCode'][$i]; $session = $_POST['session'][$i]; $semester = $_POST['semester'][$i]; $score = $_POST['score'][$i]; $gp = $_POST['gp'][$i];
    $scoreQuery .= "(null, '$course', '$matric', '$session', '$semester', '$score', '$gp'), ";
}

$scoreQuery = substr_replace($scoreQuery, '', -2);

// echo "INSERT INTO `Biodata` VALUES ('$matric', '$sname', '$fname', '$oname', '$mode', '$year', '$fac', '$disc', '$sex', '$cod', '$dop'); $scoreQuery;";

$res = $db->multi_query("INSERT INTO `Biodata` VALUES ('$matric', '$sname', '$fname', '$oname', '$dob', '$mode', '$year', '$fac', '$disc', '$sex', '$cod', '$dop'); $scoreQuery;");

if ($res) header('location:index.html?success=true'); 
else header('location:new.html?success=false');

?>