<?php
session_start();
include_once '../../../config/Database.php';
include_once '../../../classes/User.php';
include_once '../../../classes/Sanitize.php';

$database = new Database();
$db = $database->getConnection();

// sanitize data
$sanitize = new Sanitize($_POST);
$filtered_data = $sanitize->register();

if(isset($filtered_data['error'])){
    $_SESSION['error_message'] = "Please try again";
    $_SESSION['error'] = $filtered_data['error'];
    header("Location: ../users/edit.php?id=$_POST[id]");
    exit;
}


$user  = new User($db);
$stmt = $user->update($_POST);

if(!$stmt['status']) {
    $_SESSION['error'] = true;
    $_SESSION['error_message'] = $stmt['message'];
    header("Location: ../users/edit.php?id=$_POST[id]");
    exit; 
}

$_SESSION['success'] = true;
$_SESSION['success_message'] = "User has been updated successfully";
header("Location: index.php");
exit;


?>