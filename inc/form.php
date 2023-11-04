<?php

if (isset($_POST['firstName'])) {
    $firstName = $_POST['firstName'];
} else {
    $firstName = ''; // Set a default value or handle the absence of data.
}

if (isset($_POST['lastName'])) {
    $lastName = $_POST['lastName'];
} else {
    $lastName = ''; // Set a default value or handle the absence of data.
}

if (isset($_POST['email'])) {
    $email = $_POST['email'];
} else {
    $email = ''; // Set a default value or handle the absence of data.
}

$errors = [
    'firstNameError' => '',
    'lastNameError' => '',
    'emailError' => '',
];

if(isset($_POST['submit'])){

    $firstName =    mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName =     mysqli_real_escape_string($conn, $_POST['lastName']);
    $email =        mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "INSERT INTO users(firstName, lastName, email)
    VALUES ('$firstName' , '$lastName', '$email')";

    
    if(empty($firstName)){
        $errors['firstNameError'] = 'Enter the first name';
    } 
    
    if(empty($lastName)){
        $errors['lastNameError'] = 'please enter last name';
    }
    
    if(empty($email)){
        $errors['emailError'] = 'please enter email';
    }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errors['emailError'] = 'please enter correct email address';
    }else{ 
        if(mysqli_query($conn, $sql)){
           header('Location: ' . $_SERVER['PHP_SELF']);
        }else{
           echo 'Error: '.mysqli_error($conn);
        }
    } 

}
