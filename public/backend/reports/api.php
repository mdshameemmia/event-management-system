<?php

include_once '../../../config/Database.php';
include_once '../../../classes/EventRegistration.php';

$database = new Database();
$db = $database->getConnection();

$eventRegistration  = new EventRegistration($db);
$attendees = $eventRegistration->getEventDetails($_POST['event_id']);

if (count($attendees) > 0) {
    echo json_encode($attendees); // Return data as JSON
} else {
    header("Location:". "../../frontend/login.php");
}



?>
