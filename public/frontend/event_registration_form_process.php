<?php
session_start();
include_once '../../config/Database.php';
include_once '../../classes/EventRegistration.php';
include_once '../../classes/Sanitize.php';

$database = new Database();
$db = $database->getConnection();

$data = json_decode(file_get_contents("php://input"), true);

// sanitize data
// $sanitize = new Sanitize($_POST);
// $filtered_data = $sanitize->register();


$eventRegistration  = new EventRegistration($db);
$stmt = $eventRegistration->create($data);

if($stmt['status']){
    echo json_encode(['status' => true, 'message' => $stmt['message']]);
}else{
    echo json_encode(['status' => false, 'message' => $stmt['message']]);
}

// $_SESSION['success'] = true;
// $_SESSION['success_message'] = "Registration successful";
// header("Location: index.php");
// exit;


?>