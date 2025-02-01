<?php
session_start();
include_once '../../../config/Database.php';
include_once '../../../classes/User.php';

$database = new Database();
$db = $database->getConnection();

$user  = new User($db);
$stmt = $user->delete($_POST);

if(!$stmt['status']) {
    $_SESSION['error'] = true;
    $_SESSION['error_message'] = $stmt['message'];
    header("Location: index.php");
    exit; 
}

$_SESSION['success'] = true;
$_SESSION['success_message'] = "User has been deleted successfully";
header("Location: index.php");
exit;


?>