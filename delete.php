<?php 

include_once 'dbConfig.php';

$db = new mysqli($hostName, $username, $password, $dbName);
$matric = $_GET['matricNumber'];


$biodata = $db->query("SELECT * FROM `Biodata` WHERE `MatricNumber` = '$matric'")->fetch_assoc();
$scores = $db->query("SELECT * FROM `Scores` WHERE `MatricNumber` = '$matric'")->fetch_all(MYSQLI_ASSOC);

$sname = $biodata['Surname']; $fname = $biodata['FirstName']; $oname = $biodata['OtherNames']; $dob = $biodata['DateOfBirth']; $mode = $biodata['ModeOfEntry']; $year = $biodata['YearOfEntry']; $faculty = $biodata['FacultyName']; $discipline = $biodata['Discipline']; $sex = $biodata['Sex']; $cod = $biodata['ClassOfDegree']; $dop = $biodata['DateOfPresentation'];

$query = "INSERT INTO `backupBiodata` VALUES ('$matric', '$sname', '$fname', '$oname', '$dob', '$mode', '$year', '$faculty', '$discipline', '$sex', '$cod', '$dop'); ";

foreach ($scores as $score) {
    $id = $score['ID']; $code = $score['CourseCode']; $session = $score['Session']; $semester = $score['Semester']; $mark = $score['TotalMark']; $gp = $score['GP'];
    $query .= "INSERT INTO `backupScores` VALUES ('$id', '$code', '$matric', '$session', '$semester', '$mark', '$gp'); ";
}

// $res = $db->multi_query($query . "DELETE FROM `Biodata` WHERE `MatricNumber` = '$matric'; DELETE FROM `Scores` WHERE `MatricNumber` = '$matric'");

if ($res) header('Location:index.html?success=true');
else header("Location:retrieve.php?matricNumber=$matric&from=delete&success=false");

?>