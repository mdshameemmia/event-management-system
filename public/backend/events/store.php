<?php
session_start();
include_once '../../../config/Database.php';
include_once '../../../classes/Event.php';
include_once '../../../classes/Sanitize.php';

$database = new Database();
$db = $database->getConnection();

// sanitize data
$sanitize = new Sanitize($_POST);
$filtered_data = $sanitize->event();


if(isset($filtered_data['error'])){
    $_SESSION['error_message'] = "Please try again";
    $_SESSION['error'] = $filtered_data['error'];
    header("Location: create.php");
    exit;
}

$event  = new Event($db);
$stmt = $event->create($_POST);

if(!$stmt['status']) {
    $_SESSION['error'] = true;
    $_SESSION['error_message'] = $stmt['message'];
    header("Location: create.php");
    exit; 
}

$_SESSION['success'] = true;
$_SESSION['success_message'] = "Event has been created successfully";
header("Location: ../dashboard/index.php");
exit;


?>