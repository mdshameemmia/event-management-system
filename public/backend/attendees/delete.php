<?php
session_start();
include_once '../../../config/Database.php';
include_once '../../../classes/EventRegistration.php';

$database = new Database();
$db = $database->getConnection();

$eventRegistration  = new EventRegistration($db);
$stmt = $eventRegistration->delete($_POST);

if(!$stmt['status']) {
    $_SESSION['error'] = true;
    $_SESSION['error_message'] = $stmt['message'];
    header("Location: create.php");
    exit; 
}

$_SESSION['success'] = true;
$_SESSION['success_message'] = "Attendees has been deleted successfully";
header("Location: index.php");
exit;


?>