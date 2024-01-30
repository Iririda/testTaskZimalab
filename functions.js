//Function for adding entry into DB
function add() {


    var request = {};
    var invalid = false;

    //Getting information from elements by their id

    var elem = document.getElementById("fname");
    request['fname'] = elem.value;
    if (isInvalidName(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    var elem = document.getElementById("lname");
    request['lname'] = elem.value;
    if (isInvalidName(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    var elem = document.getElementById("email");
    request['email'] = elem.value;
    if (isInvalidEmail(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    request['company'] = document.getElementById("company").value;
    request['position'] = document.getElementById("position").value;

    var elem = document.getElementById("phone1");
    request['phone1'] = elem.value;
    if (isInvalidPhone(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    var elem = document.getElementById("phone2");
    request['phone2'] = elem.value;
    if (isInvalidPhone(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    var elem = document.getElementById("phone3");
    request['phone3'] = elem.value;
    if (isInvalidPhone(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    if (invalid) {
        alert("Invalid entry");
        return;
    }

    fetch('/record.php', {
        method: 'PUT', //Using HTTP method PUT for adding entry
        headers: {
            'Content-Type': 'application/json; charset=UTF-8'
        },
        body: JSON.stringify(request)
    })
        .then(response => {
            if (response.status == 201) { //If HTTP Response "201-Created" then alerting and reloading page for new info
                // TODO clear add form
                alert("Added successfully!");
                location.reload();
                return Promise.reject();
            } else if (response.status == 202) { //HTTP response "202-Accepted"
                return Promise.reject();
            } else {
                return response.text();
            }
        })
        .then(errorText => { //Exception handling
            alert("ERROR adding entry: " + errorText);
        })
}

//Function for updating entry
function update(id) {

    var request = {};
    var invalid = false;

    //Getting information from element by their id

    var elem = document.getElementById("fname" + id);
    request['fname'] = elem.value;
    if (isInvalidName(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    var elem = document.getElementById("lname" + id);
    request['lname'] = elem.value;
    if (isInvalidName(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    var elem = document.getElementById("email" + id);
    request['email'] = elem.value;
    if (isInvalidEmail(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    request['company'] = document.getElementById("company" + id).value;
    request['position'] = document.getElementById("position" + id).value;

    var elem = document.getElementById("phone1_" + id);
    request['phone1_'] = elem.value;
    if (isInvalidPhone(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    var elem = document.getElementById("phone2_" + id);
    request['phone2_'] = elem.value;
    if (isInvalidPhone(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    var elem = document.getElementById("phone3_" + id);
    request['phone3_'] = elem.value;
    if (isInvalidPhone(elem.value)){
        elem.classList.add("invalid");
        invalid = true;
    }

    if (invalid) {
        alert("Invalid entry");
        return;
    }

    fetch('/record.php?id=' + id, {
        method: 'POST', //Using HTTP method POST for updating entry
        headers: {
            'Content-Type': 'application/json; charset=UTF-8'
        },
        body: JSON.stringify(request)
    })
        .then(response => {
            if (response.status == 200) { //If HTTP Response "200-OK" then alerting and reloading page for new info
                alert("Updated successfully!");
                location.reload();
                return Promise.reject();
            } else {
                return response.text();
            }
        })
        .then(errorText => { //Exception handling
            alert("ERROR updating entry: " + errorText);
        })
}

//Function for deleting entry from DB
function remove(id) {
    fetch('/record.php?id=' + id, {
        method: 'DELETE', //Using HTTP method DELETE for deleting entry
        headers: {
            'Content-Type': 'application/json; charset=UTF-8'
        },
        body: "{}"
    })
        .then(response => {
            if (response.status == 200) { //If HTTP Response "200-OK" then alerting and reloading page for new info
                alert("Deleted successfully!");
                location.reload();
                return Promise.reject();
            } else {
                return response.text();
            }
        })
        .then(errorText => { //Exception handling
            alert("ERROR deleting entry: " + errorText);
        })
}

function mkValid(elem) {
    elem.classList.remove("invalid"); //Function changes class invalid after removing focus
}

var nameRegExp = /^[A-zА-я]+$/; //Regular expression for first name and last name validation

//Validation name
function isInvalidName(value){
    return ((value === "") || (value.length > 50) || (value.match(nameRegExp) == null));
}

var emailRegExp = /^[A-Za-z0-9._-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/; //RegExp for email validation

//Validation email
function isInvalidEmail(value){
    return ((value === "") || (value.length > 100) || (value.match(emailRegExp) == null));
}

var phoneRegExp = /^[0-9-+]/; //RegExp for phone

//Validation phone
function isInvalidPhone(value){
    if (value == null || value.length < 1) {
        return false;
    }
    return ((value.length > 20) || (value.match(phoneRegExp) == null));
}