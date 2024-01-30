<?php
require_once 'connection.php'; //Database connection

// TODO Validate on Server

$method = $_SERVER['REQUEST_METHOD']; //Get HTTP method
$id = $_REQUEST['id'] ?? null;

if ($method == 'PUT') {
    // If method is PUT then adding record getting info from JSON
    $data = json_decode(file_get_contents('php://input'), true);

    //Insert data into DB
    $sql = "INSERT INTO accounts (fname, lname, email, company, position, phone1, phone2, phone3)"
        . " VALUES ('$data[fname]', '$data[lname]', '$data[email]', '$data[company]',
        '$data[position]', '$data[phone1]', '$data[phone2]', '$data[phone3]' )";

    //Exception handling
    try {
        $db_link->query($sql);
    } catch (Exception $e) {
        http_response_code(422); //Unprocessable entity. JSON is correct, but we can't add entry due:
        $msg = $e->getMessage();
        if (str_contains($msg, "Duplicate entry") && str_contains($msg, "accounts.email")) {
            http_response_code(422);
            print("email already in use by another entry");
        } else {
            http_response_code(503); //Service unavailable
            print("something went wrong while adding entry");
        }
    }
    http_response_code(201); //Created
    exit();
}

if ($id == null) {
    http_response_code(400); //Bad request
    print("record id must be specified");
    exit();
}

if ($method == 'POST') {
    //If method is POST then updating record getting info from JSON
    $data = json_decode(file_get_contents('php://input'), true);


    //Update entry in DB
    $sql = "UPDATE accounts SET fname='$data[fname]', lname='$data[lname]', email='$data[email]', company='$data[company]',
        position='$data[position]', phone1='$data[phone1]', phone2='$data[phone2]', phone3='$data[phone3]' 
        WHERE id='$id'";

    //Exception handling same as then adding
    try {
        $db_link->query($sql);
    } catch (Exception $e) {
        http_response_code(422);
        $msg = $e->getMessage();
        if (str_contains($msg, "Duplicate entry") && str_contains($msg, "accounts.email")) {
            http_response_code(422);
            print("email already in use by another entry");
        } else {
            http_response_code(503);
            print("something went wrong while updating entry");
        }
    }
    exit();
}

if ($method == 'DELETE') {
    //Delete entry from DB by id
   $sql = "DELETE FROM accounts WHERE id='$id'";
    try {
        $db_link->query($sql);
    } catch (Exception $e) {
        http_response_code(503); //If something went wrong while deleting then printing a message
        print ($e->getMessage());
    }
}

?>