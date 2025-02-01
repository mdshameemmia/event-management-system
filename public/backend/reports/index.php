<?php
include_once '../partials/header.php';

include_once '../../../config/Database.php';
include_once '../../../classes/Event.php';

$database = new Database();
$db = $database->getConnection();

$event  = new Event($db);
$data = $event->index();

?>

<div class="container">
  <h2 class="text-center my-3">Reports</h2>
  <form action="download.php" method="post">
    <div class="form-group">
        <label for="">Event Name</label>
        <select class="form-control" name="event_id" id="event_id">
            <option value="">Select Event</option>
            <?php foreach($data['events'] as $key => $value): ?>
                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Download</button>
  </form>

  <h2 class="text-center my-3">API</h2>
  <form action="api.php" method="post">
    <div class="form-group">
        <label for="">Event Name</label>
        <select class="form-control" name="event_id" id="event_id">
            <option value="">Select Event</option>
            <?php foreach($data['events'] as $key => $value): ?>
                <option value="<?= $value['id'] ?>"><?= $value['name'] ?></option>
            <?php endforeach ?>
        </select>
    </div>
    <button type="submit" class="btn btn-success">GET API</button>
  </form>

</div>

<?php include_once '../partials/footer.php'; ?>