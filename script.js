const scoresColumn = document.querySelector('.scores-column');
const scoreComponentClone = document.querySelector('.score-component').cloneNode(true); //A fresh node
const dropdownYearOfEntry = document.querySelector('#year-of-entry');
const dropdownDiscipline = document.querySelector('#discipline');
const dropdownFaculty = document.querySelector('#faculty-name');
const courseCodeInputs = document.querySelectorAll('.input-course');
let scoreComponentId = 0;
let blankCount = 0;
addIdToScoreComponent(document.querySelector('.score-component'), scoreComponentId);

for (let i = 2000; i < 2025; i++) { //Adds the years of entry dynamically
    let optionElement = document.createElement('option');
    dropdownYearOfEntry.appendChild(optionElement);
    optionElement.innerText = `${i - 1}${i}`;
}

autoSessionUpdateAll(); //calls the function on opening the page
dropdownYearOfEntry.onchange = autoSessionUpdateAll; //Calls the function on changing the year of entry
populateDropdownFaculty();
populateDropdownDiscipline();
dropdownFaculty.onchange = populateDropdownDiscipline;

function capitalizeOnInput(input) {
    let p = input.selectionStart;
    input.value = input.value.toUpperCase();
    input.setSelectionRange(p, p);
}

function validateCourseCodeOnKeypress(input, event) {
    if (event.key == ' ') event.preventDefault();
    if (input.value.length == 3 && event.key != "Backspace") input.value += ' ';
}

function autoSessionUpdateAll() { //Changes the years shown in the session dropdown according to year of entry
    for (let sessionDropdown of document.querySelectorAll('.input-session')) {
        for (let i = 0; i < 5; i++) {
            let optionElement = document.createElement('option');
            sessionDropdown[i] = optionElement;
            optionElement.innerText = dropdownYearOfEntry[dropdownYearOfEntry.selectedIndex + i].textContent;
        }
    }
}

function populateDropdownDiscipline() {
    dropdownDiscipline.replaceChildren();
    Object.values(disciplines[dropdownFaculty.selectedIndex]).forEach((faculty) => {
        faculty.forEach((discipline) => {
            let optionElement = document.createElement('option');
            dropdownDiscipline.appendChild(optionElement);
            optionElement.innerText = discipline;
        });
    });
}

function populateDropdownFaculty() {
    disciplines.forEach((_, index) => {
        let optionElement = document.createElement('option');
        dropdownFaculty.appendChild(optionElement);
        optionElement.innerText = Object.keys(disciplines[index]).join('');
    });
}

function autoSessionUpdate(scoreComponent) {
    for (let i = 0; i < 5; i++) {
        let optionElement = document.createElement('option');
        scoreComponent.querySelector('select[name^=session]')[i] = optionElement;
        optionElement.innerText = dropdownYearOfEntry[dropdownYearOfEntry.selectedIndex + i].textContent;
    }
}

function addScoreComponent(blank = false) {
    scoreComponentId++; //Unique identifier for each component's control's name
    scoresColumn.insertBefore(scoreComponentClone.cloneNode(true), scoresColumn.lastElementChild); //Adds a new score component
    let lastScoreComponent = document.querySelectorAll('.score-component')[document.querySelectorAll('.score-component').length - 1];
    addDeleteButton(lastScoreComponent, blank);

    addIdToScoreComponent(lastScoreComponent, scoreComponentId);
    autoSessionUpdate(lastScoreComponent);
}

function deleteScoreComponent(scoreComponent) {
    scoreComponentId--;
    scoreComponent.remove();
    // if (scoreComponentId == 0) document.querySelector('.remove-score-btn').disabled = true;
}

function addBlankComponent() {
    addScoreComponent(true);
    blankCount++;
}

function removeBlankComponent(scoreComponent) {
    if (blankCount >= 1) { //At least one score component
        deleteScoreComponent(scoreComponent);
        blankCount--;
        if (blankCount < 1) document.querySelector('.remove-score-btn').disabled = true;
    }
}

function autoScore(scoreComponent) {
    const inputScore = scoreComponent.querySelector('.input-score');
    const GPValue = scoreComponent.querySelector('.input-gp').value;

    switch (Number(GPValue)) {
        case 1:
            inputScore.value = 40;
            break;
        case 2:
            inputScore.value = 45;
            break;
        case 3:
            inputScore.value = 50;
            break;
        case 4:
            inputScore.value = 60;
            break;
        case 5:
            inputScore.value = 70;
            break;
        default:
            inputScore.value = 0;
    }
}

function addIdToScoreComponent(scoreComponent, id) {
    scoreComponent.querySelector('.input-course').name += `[${id}]`;
    scoreComponent.querySelector('.input-session').name += `[${id}]`;
    scoreComponent.querySelector('.input-radio-harmattan').name += `[${id}]`;
    scoreComponent.querySelector('.input-radio-rain').name += `[${id}]`;
    scoreComponent.querySelector('.input-score').name += `[${id}]`;
    scoreComponent.querySelector('.input-gp').name += `[${id}]`;
}

function addDeleteButton(scoreComponent, blank = false) {
    if (!scoreComponent.querySelector('.remove-btn')) {
        let deleteButton = document.createElement('button');
        deleteButton.setAttribute('type', 'button');
        deleteButton.classList.add('remove-btn');
        deleteButton.setAttribute('title', 'Remove');
        blank ? deleteButton.setAttribute('onclick', 'removeBlankComponent(this.parentElement);') : deleteButton.setAttribute('onclick', 'deleteScoreComponent(this.parentElement)');
        deleteButton.innerHTML = '✕';
        scoreComponent.appendChild(deleteButton);
    }
}