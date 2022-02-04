<?php

include_once 'dbConfig.php';
include_once 'helpers.php';

$db = new mysqli($hostName, $username, $password, $dbName);

$matric = $_POST['matricNumber']; $sname = $db->real_escape_string(clean_name($_POST['surname'])); $fname = $db->real_escape_string(clean_name($_POST['firstName'])); $oname = $db->real_escape_string(clean_name($_POST['otherNames'])); $dob = $_POST['dateOfBirth']; $mode = $_POST['modeOfEntry']; $year = $_POST['yearOfEntry']; $fac = $_POST['facultyName']; $disc = $_POST['discipline']; $sex = $_POST['sex']; $cod = $_POST['classOfDegree']; $dop = $_POST['dateOfPresentation'];

$scoreQuery = "";
$oldScores = flatten($db->query("SELECT `ID` FROM `Scores` WHERE `MatricNumber` = '$matric'")->fetch_all());

for ($i = 0; $i <= array_key_last($_POST['courseCode']); $i++) {
    $course = $_POST['courseCode'][$i]; $session = $_POST['session'][$i]; $semester = $_POST['semester'][$i]; $score = $_POST['score'][$i]; $gp = $_POST['gp'][$i]; $id = $_POST['ID'][$i];
    if ($id && $i <= array_key_last($_POST['ID'])) $scoreQuery .= "UPDATE `Scores` SET `CourseCode` = '$course', `MatricNumber` = '$matric', `Session` = '$session', `Semester` = '$semester', `TotalMark` = '$score', `GP` = '$gp' WHERE `ID` = '$id'; "; 
    elseif (!$id && $i > array_key_last($_POST['ID'])) $scoreQuery .= "INSERT INTO `Scores` VALUES (null, '$course', '$matric', '$session', '$semester', '$score', '$gp'); ";
}

$deleteQuery = "";

foreach ($oldScores as $oldId) {
    if (!in_array($oldId, $_POST['ID'])) {
        $deleteQuery .= "DELETE FROM `Scores` WHERE `ID` = '$oldId'; ";
    }
}

// echo "UPDATE `Biodata` SET `MatricNumber` = '$matric', `Surname` = '$sname', `FirstName` = '$fname', `OtherNames` = '$oname', `DateOfBirth` = '$dob', `ModeOfEntry` = '$mode', `YearOfEntry` = '$year', `FacultyName` = '$fac', `Discipline` = '$disc', `Sex` = '$sex', `ClassOfDegree` = '$cod', `DateOfPresentation` = '$dop' WHERE `MatricNumber` = '$matric'; $scoreQuery $deleteQuery";

$res = $db->multi_query("UPDATE `Biodata` SET `MatricNumber` = '$matric', `Surname` = '$sname', `FirstName` = '$fname', `OtherNames` = '$oname', `DateOfBirth` = '$dob', `ModeOfEntry` = '$mode', `YearOfEntry` = '$year', `FacultyName` = '$fac', `Discipline` = '$disc', `Sex` = '$sex', `ClassOfDegree` = '$cod', `DateOfPresentation` = '$dop' WHERE `MatricNumber` = '$matric'; $scoreQuery $deleteQuery");

if ($res) header('location:index.html?success=true'); 
else header("location:edit.php?matricNumber=$matric&success=false");

?>