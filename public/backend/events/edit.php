<?php 
include_once '../partials/header.php';
include_once '../../../config/Database.php';
include_once '../../../classes/Event.php';

$database = new Database();
$db = $database->getConnection();

$event  = new Event($db);
$data = $event->edit($_GET);

if(!$data['status']) {
    $_SESSION['error'] = true;
    $_SESSION['error_message'] = $data['message'];
    header("Location: event_list.php");
    exit;
}
$event = $data['event'];

?>

<div class="container">
    <h1 class="text-dark text-center my-3">Edit an Event</h1>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <fieldset>
                <form action="update.php" method="post">
                    <input type="hidden" name="id" value="<?= $event['id'] ?>">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" value="<?= $event['name']?? '' ?>" placeholder="Enter name here..." id="name" name="name" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['name_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description"  class="form-control" rows="3" id="" required>
                            <?= $event['description'] ?>
                        </textarea>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['description_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="startdate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" value="<?= $event['startdate']?? '' ?>" placeholder="Enter start date here..." id="startdate" name="startdate" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['startdate_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="enddate" class="form-label">End Date</label>
                        <input type="date" class="form-control" value="<?= $event['enddate']??  '' ?>" placeholder="Enter start date here..." id="enddate" name="enddate" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['enddate_error'] ?? '') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" value="<?= $event['location'] ?? '' ?>" placeholder="Enter location..." id="location" name="location" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['location_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-control" id="" required>
                            <option value="">Active/Inactive</option>
                            <option <?= $event['status'] == 'Active' ? 'selected' : '' ?> value="Active">Active</option>
                            <option <?= $event['status'] == 'Inactive' ? 'selected' : '' ?> value="Inactive">Inactive</option>
                        </select>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['status'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-success">Update</button>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>

<?php include_once '../partials/footer.php'; ?>