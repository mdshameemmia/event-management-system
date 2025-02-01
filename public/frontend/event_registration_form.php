<?php
include_once 'partials/header.php';
include_once '../../config/Database.php';
include_once '../../classes/Event.php';

$database = new Database();
$db = $database->getConnection();

$id = $_GET['id'];
if (isset($_GET['id'])) {
    $id = base64_decode($_GET['id']);
    $event  = new Event($db);
    $data = $event->singleItem($id);
}

?>

<div class="container">
    <h1 class="text-dark text-center my-3">Event Registration Form</h1>
    <div class="row">
        <div class="col-md-6 offset-md-3">
            <fieldset>
                <form method="post">
                    <div class="mb-3">
                        <label for="name" class="form-label">Events</label>
                        <select name="event_id" class="form-control" id="event_id" required>
                           <option value="<?= $id ?>"><?= $data['name'] ?></option>
                        </select>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['event_id_error'] ?? '') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" placeholder="Enter your name here..." id="name" name="name" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['name_error'] ?? '') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email address</label>
                        <input type="email" class="form-control" placeholder="Enter your email here..." id="email" name="email" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['email_error'] ?? '') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="mobile" class="form-label">Mobile</label>
                        <input type="text" class="form-control" placeholder="Enter your mobile here..." id="mobile" maxlength="11" name="mobile" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['mobile_error'] ?? '') ?>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="attendee_address" class="form-label">Address</label>
                        <input type="text" class="form-control" placeholder="Enter your attendee_address here..." id="address" name="address" required>
                        <div class="text-danger alert-msg">
                            <?= htmlspecialchars($_SESSION['error']['address_error'] ?? '') ?>
                        </div>
                    </div>


                    <div class="mb-3 text-center">
                        <button type="button" onclick="handleRegistration()" class="btn btn-success">Submit</button>
                    </div>
                </form>
                <div id="message" class="message"></div>
            </fieldset>
        </div>
    </div>
</div>

<script>
    async function handleRegistration() {

        const event_id = document.getElementById('event_id').value;
        const name = document.getElementById('name').value;
        const email = document.getElementById('email').value;
        const mobile = document.getElementById('mobile').value;
        const address = document.getElementById('address').value;

        const formData = {
            event_id,
            name,
            email,
            mobile,
            address
        };


        const messageDiv = document.getElementById('message');
        messageDiv.textContent = 'Processing...';
        messageDiv.className = 'message';


        try {
            const response = await fetch('event_registration_form_process.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const responseData = await response.json();
           alert(responseData.message);
           if(responseData.status){
            window.location.href = 'http://localhost/event-management-system/public/frontend/index.php';
           }else{
            messageDiv.innerHTML = `<b class='text-danger'>${responseData.message}</b>`;
           }

        } catch (error) {
            messageDiv.textContent = 'There was an error. Please try again later.';
            messageDiv.className = 'message error'; // Error message
        }
    }
</script>

<?php include_once 'partials/footer.php'; ?>