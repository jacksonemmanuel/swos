function getParameter(key) {
    const address = window.location.search;
    const parameterList = new URLSearchParams(address);
    return parameterList.get(key);
}

function showNotification(bool, text, to) {
    let notification = document.createElement('div');
    notification.innerHTML = `<p>${text}</p><button type="button" class="close-btn" onclick="hideNotification('${to}');">✕</button>`;
    notification.classList.add('notification', 'row');
    if (bool) notification.classList.add('success');
    else notification.classList.add('failure');
    document.body.appendChild(notification);
}

function hideNotification(to) {
    document.querySelector('.notification').style.opacity = 0;
    setTimeout(() => document.querySelector('.notification').remove(), 200);
    window.history.replaceState({}, '', to);
}

function showConfirmation(trigger, text, matricNum) {
    let confirmation = document.createElement('div');
    confirmation.innerHTML = `<p>${text}</p>
                            <div class='row'>
                                <button class='cancel-btn normal-outline-btn' type='button' onclick="cancelConfirmation(document.querySelector('.del-btn'));">Cancel</button>
                                <a class='btn normal-btn' href='delete.php?matricNumber=${matricNum}'>Confirm</a>
                            </div>`;
    confirmation.classList.add('confirmation', 'column');
    confirmation.style.opacity = 0;
    trigger.disabled = true;
    document.body.appendChild(confirmation);
    setTimeout(() => confirmation.style.opacity = 1, 200);
}

function cancelConfirmation(trigger) {
    document.querySelector('.confirmation').style.opacity = 0;
    setTimeout(() => document.querySelector('.confirmation').remove(), 200);
    trigger.disabled = false;
}