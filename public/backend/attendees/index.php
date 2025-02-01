<?php
include_once '../partials/header.php';

include_once '../../../config/Database.php';
include_once '../../../classes/EventRegistration.php';

$database = new Database();
$db = $database->getConnection();

$eventRegistration  = new EventRegistration($db);
$data = $eventRegistration->index();
$indexColumnKeys = $eventRegistration->indexColumnKeys;

?>

<div class="container">

    <h2 class="text-center my-2">Attendees Information</h2>
    <div class="my-2 col-md-12 d-flex justify-content-between">
        <div class="col-md-4">
            <input type="text" class="form-control" onkeyup="globalSearch(this)" placeholder="Search here by your keywords...">
        </div>
    </div>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th onclick='getHeadingValue("id")'>
                    ID
                    <span class="d-none all-down down-icon-id">🔽</span>
                    <span class="d-none all-up up-icon-id">🔼</span>
                </th>

                
                <?php foreach ($indexColumnKeys as $key => $value) : ?>
                    <th onclick='getHeadingValue("<?= $key ?>")'> <?= $value ?></span>
                    <span class="d-none all-down down-icon-<?= $key ?>">🔽</span>
                    <span class="d-none all-up up-icon-<?= $key ?>">🔼</span>
                </th>
                <?php endforeach ?>
                <th>Event Name</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="event_registration_list">

        </tbody>
    </table>

    <div id="pagination"></div>
</div>
<script src="../../../assets/js/event_registration.js"></script>

<?php include_once '../partials/footer.php'; ?>