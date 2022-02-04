<?php

include_once 'dbConfig.php';

$matric = $_GET['matricNumber'];
$db = new mysqli($hostName, $username, $password, $dbName);

$bio = $db->query("SELECT * FROM `Biodata` WHERE `MatricNumber` = '$matric'");
$scores = $db->query("SELECT * FROM `Scores` WHERE `MatricNumber` = '$matric'");

$bioResult = $bio->fetch_assoc();
$scoresResult = $scores->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="popup.css" />
    <title></title>
    <style>
        p {
            font-size: 1.1rem;
            margin: .3em 0;
            text-align: center;
        }

        label {
            color: #777;
            font-size: .7em;
            text-transform: uppercase;
            text-align: center;
        }

        .row {
            margin-bottom: 2em;
            gap: 5em;
        }

        .score-component:last-child {
            border-bottom: none;
        }
        .score-component:nth-last-child(2) {
            border-bottom: 1px solid #ccc;
        }

        .semester-column {
            width: 5em;
        }
        .action-btn {
            gap: 1em;
        }
    </style>
</head>

<body>
    <div class="container row level-0-row">
        <div class="biodata-column column">
            <h2>Biodata</h2>
            <div class="row">
                <div class="column">
                    <p><?php echo $matric; ?></p>
                    <label>Matric Number</label>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <p><?php echo $bioResult['Surname']; ?></p>
                    <label>Surname</label>
                </div>
                <div class="column">
                    <p><?php echo $bioResult['FirstName']; ?></p>
                    <label>First Name</label>
                </div>
                <div class="column">
                    <p><?php echo $bioResult['OtherNames']; ?></p>
                    <label>Other Name(s)</label>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <p><?php echo $bioResult['DateOfBirth']; ?></p>
                    <label>Date of Birth</label>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <p><?php echo $bioResult['ModeOfEntry']; ?></p>
                    <label>Mode of Entry</label>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <p><?php echo substr_replace($bioResult['YearOfEntry'], '/', 4, 0); ?></p>
                    <label>Year of Entry</label>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <p><?php echo $bioResult['FacultyName']; ?></p>
                    <label>Faculty Name</label>
                </div>
                <div class="column">
                    <p><?php echo $bioResult['Discipline']; ?></p>
                    <label>Discipline</label>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <p><?php echo $bioResult['Sex'] == 'M' ? "Male" : "Female"; ?></p>
                    <label>Sex</label>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <p><?php echo $bioResult['ClassOfDegree']; ?></p>
                    <label>Class of Degree</label>
                </div>
            </div>
            <div class="row">
                <div class="column">
                    <p><?php echo $bioResult['DateOfPresentation']; ?></p>
                    <label>Date of Presentation</label>
                </div>
            </div>
        </div>

        <div class="column scores-column">
            <h2>Scores</h2>
            <?php
            foreach ($scoresResult as $score) {
                $course = $score['CourseCode']; $session = substr_replace($score['Session'], '/', 4, 0); $semester = $score['Semester']; $totalMark = $score['TotalMark']; $gp = $score['GP'];
                echo <<<_END
                    <div class="row score-component">
                        <div class="column">
                            <p>$course</p>
                            <label>Course Code</label>
                        </div>
                        <div class="column">
                            <p>$session</p>
                            <label>Session</label>
                        </div>
                        <div class="column semester-column">
                            <p>$semester</p>
                            <label>Semester</label>
                        </div>
                        <div class="column">
                            <p>$totalMark</p>
                            <label>Score</label>
                        </div>
                        <div class="column">
                            <p>$gp</p>
                            <label>Grade Point</label>
                        </div>
                    </div>
                _END;

            }
            ?>
        </div>
    </div>
    <div class="row action-btn">
        <button type="button" class="del-btn danger-outline-btn" onclick="showConfirmation(this, 'Are you sure you want to delete <?php echo $bioResult['Surname']; ?>\'s records?', '<?php echo $matric; ?>'); ">Delete</button>
        <a class='normal-outline-btn btn' href="edit.php?matricNumber=<?php echo $matric; ?>">Edit</a>
    </div>

    <script src="popup.js"></script>
    <script>
        if (getParameter('success') === 'false' && document.referrer) showNotification(false, "An error has occured", document.referrer);
    </script>
</body>

</html>