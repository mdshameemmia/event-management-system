<?php

include_once '../../../config/Database.php';
include_once '../../../classes/EventRegistration.php';

$database = new Database();
$db = $database->getConnection();

$eventRegistration  = new EventRegistration($db);
$attendees = $eventRegistration->getEventDetails($_POST['event_id']);

$filename = "attendees_list.csv";
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$output = fopen('php://output', 'w');

fputcsv($output, ["Event Name","Description" ,"Attendee Name", "Email", "Mobile", "Registration Date", "Address"]);

foreach ($attendees as $attendee) {
    fputcsv($output, [
        $attendee['eventname'], 
        $attendee['description'], 
        $attendee['name'],  
        $attendee['email'], 
        $attendee['mobile'], 
        $attendee['registrationdate'],  
        $attendee['address'] 
    ]);
}

fclose($output);



?>
