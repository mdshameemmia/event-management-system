<?php
session_start();
include_once '../../../config/Database.php';
include_once '../../../classes/Event.php';
include_once '../../../classes/Sanitize.php';

$database = new Database();
$db = $database->getConnection();

$event  = new Event($db);
$stmt = $event->delete($_POST);

if(!$stmt['status']) {
    $_SESSION['error'] = true;
    $_SESSION['error_message'] = $stmt['message'];
    header("Location: create.php");
    exit; 
}

$_SESSION['success'] = true;
$_SESSION['success_message'] = "Event has been deleted successfully";
header("Location: index.php");
exit;


?>