<?php
session_start();
include_once '../../config/Database.php';
include_once '../../classes/User.php';

$database = new Database();
$db = $database->getConnection();


$user  = new User($db);
$stmt = $user->login($_POST);

if(!$stmt['status']) {
    $_SESSION['error'] = true;
    $_SESSION['error_message'] = $stmt['message'];
    header("Location: login.php");
    exit; 
}

$_SESSION['success'] = true;
$_SESSION['success_message'] = $stmt['message'];
$_SESSION['user_id'] = $stmt['user_id'];
$_SESSION['user_name'] = $stmt['user_name'];
$_SESSION['password'] = $_POST['password'];
header("Location: ../backend/dashboard/index.php");
exit;


?>