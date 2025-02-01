<?php include_once '../partials/header.php'; ?>

<div class="container">
    <h1 class="text-dark text-center my-3">Create an Event</h1>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <fieldset>
                <form action="store.php" method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" placeholder="Enter name here..." id="name" name="name" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['name_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3" id="" required></textarea>
                        <div class="text-danger alert-msg">
                        <?= htmlspecialchars($_SESSION['error']['description_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="startdate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" placeholder="Enter start date here..." id="startdate"  name="startdate" required>
                        <div class="text-danger alert-msg">
                        <?= htmlspecialchars($_SESSION['error']['startdate_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="enddate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" placeholder="Enter start date here..." id="enddate"  name="enddate" required>
                        <div class="text-danger alert-msg">
                        <?= htmlspecialchars($_SESSION['error']['enddate_error'] ?? '') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" placeholder="Enter location..." id="location" name="location" required>
                        <div class="text-danger alert-msg">
                        <?= htmlspecialchars($_SESSION['error']['location_error'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" class="form-control" id="" required>
                            <option value="">Active/Inactive</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['status'] ?? '') ?>
                        </div>
                    </div>
                    <div class="mb-3 text-center">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </fieldset>
        </div>
    </div>
</div>

<?php include_once '../partials/footer.php'; ?>