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
</head>

<body>
    <form action="update.php" method="post" class="container">
        <div class="row level-0-row">
            <div class="column">
                <h2>Biodata</h2>
                <h3>Matric Number</h3>
                <input type="text" placeholder="Matric Number" name="matricNumber" oninput="capitalizeOnInput(this)" pattern="\d|\w{9}" maxlength="9" required value="<?php echo $matric; ?>" />
                <h3>Names</h3>
                <div class="row">
                    <div class="column">
                        <h4>Surname</h4>
                        <input type="text" placeholder="Surname" name="surname" required value="<?php echo $bioResult['Surname']; ?>" />
                    </div>
                    <div class="column">
                        <h4>First Name</h4>
                        <input type="text" placeholder="First Name" name="firstName" required value="<?php echo $bioResult['FirstName']; ?>" />
                    </div>
                    <div class="column">
                        <h4>Other Name(s)</h4>
                        <input type="text" placeholder="Other Name(s)" name="otherNames" value="<?php echo $bioResult['OtherNames']; ?>" />
                    </div>
                </div>
                <h3>Date of Birth</h3>
                <input type="date" name="dateOfBirth" value="<?php echo $bioResult['DateOfBirth']; ?>" />
                <h3>Mode of Entry</h3>
                <div class="row" data-mode-of-entry="<?php echo $bioResult['ModeOfEntry']; ?>">
                    <label><input type="radio" name="modeOfEntry" value="UME" required />UME</label>
                    <label><input type="radio" name="modeOfEntry" value="DE" />DE</label>
                </div>
                <h3>Year of Entry</h3>
                <select id="year-of-entry" name="yearOfEntry" data-year-of-entry="<?php echo $bioResult['YearOfEntry']; ?>"></select>
                <div class="row">
                    <div class="column">
                        <h3>Faculty Name</h3>
                        <select id="faculty-name" name="facultyName" data-faculty-name="<?php echo $bioResult['FacultyName']; ?>"></select>
                    </div>
                    <div class="column">
                        <h3>Discipline</h3>
                        <select name="discipline" id="discipline" data-discipline="<?php echo $bioResult['Discipline']; ?>"></select>
                    </div>
                </div>
                <h3>Sex</h3>
                <div class="row" data-sex="<?php echo $bioResult['Sex']; ?>">
                    <label><input type="radio" name="sex" value="M" required />Male</label>
                    <label><input type="radio" name="sex" value="F" />Female</label>
                </div>
                <h3>Class of Degree</h3>
                <select id="class-of-degree" name="classOfDegree" data-class-of-degree="<?php echo $bioResult['ClassOfDegree']; ?>">
                    <option>First Class (Hons.)</option>
                    <option>Second Class (Hons.) Upper Div.</option>
                    <option>Second Class (Hons.) Lower Div.</option>
                    <option>Third Class</option>
                    <option>Pass</option>
                </select>
                <h3>Date of Presentation</h3>
                <input type="date" name="dateOfPresentation" value="<?php echo $bioResult['DateOfPresentation']; ?>" required />
            </div>

            <div class="column scores-column" data-scores='<?php echo json_encode($scoresResult); ?>'>
                <h2>Scores</h2>
                <div class="row score-component">
                    <div class="column">
                        <h4>Course Code</h4>
                        <input type="text" placeholder="Course Code" name="courseCode" class="input-course" maxlength="7" pattern="\w\w\w \d\d\d" oninput="capitalizeOnInput(this);" onkeydown="validateCourseCodeOnKeypress(this, event);" required />
                    </div>
                    <div class="column">
                        <h4>Session</h4>
                        <select class="input-session" name="session"></select>
                    </div>
                    <div class="column">
                        <h4>Semester</h4>
                        <div class="row" style="margin-top: .5em;">
                            <label><input type="radio" name="semester" class="input-radio-harmattan" value="Harmattan" required />Harmattan</label>
                            <label><input type="radio" name="semester" class="input-radio-rain" value="Rain" />Rain</label>
                        </div>
                    </div>
                    <div class="column">
                        <h4>Score</h4>
                        <input type="number" name="score" class="input-score" placeholder="Score" min="0" max="100" readonly />
                    </div>
                    <div class="column">
                        <h4>Grade Point</h4>
                        <input type="number" name="gp" class="input-gp" placeholder="Grade Point" min="0" max="5" required onchange="autoScore(this.parentElement.parentElement);" />
                    </div>
                </div>
                <div class="row">
                    <button type="button" class="success-outline-btn add-score-btn" onclick="addBlankComponent(); document.querySelector('.remove-score-btn').disabled = false;">Add Blank</button>
                    <button type="button" class="danger-outline-btn remove-score-btn" onclick="removeBlankComponent(document.querySelectorAll('.score-component')[document.querySelectorAll('.score-component').length - 1]);" disabled>Remove Blank</button>
                </div>
            </div>
        </div>
        <button type="submit" class="normal-btn action-btn">Save</button>
    </form>

    <script src="disciplines.js"></script>
    <script src="popup.js"></script>
    <script src="script.js"></script>
    <script>
        document.querySelector('[data-mode-of-entry]').getAttribute('data-mode-of-entry') == 'UME' ? document.querySelector('input[name=modeOfEntry][value=UME]').checked = true : document.querySelector('input[name=modeOfEntry][value=DE]').checked = true;

        Array.from(document.getElementById('year-of-entry')).forEach(option => {
            if (option.text == option.parentElement.getAttribute('data-year-of-entry')) {
                option.selected = true;
                option.parentElement.dispatchEvent(new Event('change'));
            }
        });

        Array.from(document.getElementById('faculty-name')).forEach(option => {
            if (option.text == option.parentElement.getAttribute('data-faculty-name')) {
                option.selected = true;
                option.parentElement.dispatchEvent(new Event('change'));
            }
        });

        Array.from(document.getElementById('discipline')).forEach(option => {
            if (option.text == option.parentElement.getAttribute('data-discipline')) option.selected = true;
        });

        Array.from(document.getElementById('class-of-degree')).forEach(option => {
            if (option.text == option.parentElement.getAttribute('data-class-of-degree')) option.selected = true;
        });

        document.querySelector('[data-sex]').getAttribute('data-sex') == 'M' ? document.querySelector('input[name=sex][value=M]').checked = true : document.querySelector('input[name=sex][value=F]').checked = true;

        let scores = JSON.parse(document.querySelector('.scores-column').getAttribute('data-scores'));
        scores.forEach((score, index) => {
            addScoreComponent();
            let scoreComponent = document.querySelector(`[name='courseCode[${index}]']`).parentElement.parentElement;
            document.querySelector(`[name='courseCode[${index}]']`).value = score.CourseCode;
            Array.from(document.querySelector(`[name='session[${index}]']`)).forEach(option => {
                if (option.text == score.Session) option.selected = true;
            });
            score.Semester == 'Harmattan' ? document.querySelector(`input[name='semester[${index}]'][value=Harmattan]`).checked = true : document.querySelector(`input[name='semester[${index}]'][value=Rain]`).checked = true;
            document.querySelector(`[name='gp[${index}]']`).value = score.GP;
            document.querySelector(`[name='gp[${index}]']`).dispatchEvent(new Event('change'));

            //Hidden input for ID
            let inputId = document.createElement('input');
            inputId.setAttribute('type', 'hidden');
            inputId.setAttribute('value', score.ID);
            inputId.setAttribute('name', `ID[${index}]`);
            scoreComponent.appendChild(inputId);

        });
        deleteScoreComponent(document.querySelectorAll('.score-component')[document.querySelectorAll('.score-component').length - 1]);
        addDeleteButton(document.querySelector('.score-component'));
    </script>
</body>

</html>