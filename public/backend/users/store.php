<?php
session_start();
include_once '../../../config/Database.php';
include_once '../../../classes/User.php';
include_once '../../../classes/Sanitize.php';

$database = new Database();
$db = $database->getConnection();

if ($_POST['password'] !== $_POST['confirm_password']) {
    http_response_code(400);
    $_SESSION['error'] = true;
    $_SESSION['error_message'] = "Passwords do not match";
    header("Location: ../dashboard/index.php");

    exit;
}

// sanitize data
$sanitize = new Sanitize($_POST);
$filtered_data = $sanitize->register();




if($filtered_data['error']){
    $_SESSION['error_message'] = "Please try again";
    $_SESSION['error'] = $filtered_data['error'];
    header("Location: ../dashboard/index.php");
    exit;
}

$_POST['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);

$user  = new User($db);
$stmt = $user->create($_POST);

if(!$stmt['status']) {
    $_SESSION['error'] = true;
    $_SESSION['error_message'] = $stmt['message'];
    header("Location: ../dashboard/index.php");
    exit; 
}

$_SESSION['success'] = true;
$_SESSION['success_message'] = "Registration successful";
header("Location: ../dashboard/index.php");

exit;


?>