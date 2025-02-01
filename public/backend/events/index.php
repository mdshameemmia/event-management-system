<?php
include_once '../partials/header.php';

include_once '../../../config/Database.php';
include_once '../../../classes/Event.php';

$database = new Database();
$db = $database->getConnection();

$event  = new Event($db);
$data = $event->index();
$indexColumnKeys = $event->indexColumnKeys;

?>

<div class="container">
 
    <h2 class="text-center my-2">Event List</h2>
    <div class="my-2 col-md-12 d-flex justify-content-between">
        <div class="col-md-4">
            <input type="text" class="form-control" onkeyup="globalSearch(this)" placeholder="Search here by your keywords...">
        </div>
        <p class="col-md-1 text-right"><a href="create.php"><button class="btn btn-success btn-sm">Add Event</button></a></p>
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
                    <th onclick='getHeadingValue("<?= $key ?>")'><?= $value ?>
                        <span class="d-none all-down down-icon-<?= $key ?>">🔽</span>
                        <span class="d-none all-up up-icon-<?= $key ?>">🔼</span>
                    </th>
                <?php endforeach ?>
                <th>Action</th>
            </tr>
        </thead>
        <tbody id="eventList">

        </tbody>
    </table>

    <div id="pagination"></div>
</div>
<script src="../../../assets/js/event.js"></script>

<?php include_once '../partials/footer.php'; ?>