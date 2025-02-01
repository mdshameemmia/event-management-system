
<script src="../../../assets/js/bootstrap.bundle.min.js"></script>
    <script src="../../../assets/js/jquery-3.7.1.min.js"></script>
    <script src="../../../assets/js/custom-js.js"></script>

    <?php 
        include_once '../../../classes/AlertMessage.php';
        $alertMsg = new AlertMessage();
  
        if (isset($_SESSION['error'])) {
            echo  $alertMsg->render(AlertMessage::TYPE_DANGER, $_SESSION['error_message']);
            unset($_SESSION['error']);
            unset($_SESSION['error_message']);
        }
        if (isset($_SESSION['success'])) {
            echo  $alertMsg->render(AlertMessage::TYPE_SUCCESS, $_SESSION['success_message']);
            unset($_SESSION['success']);
            unset($_SESSION['success_message']);
        }
        
     ?>
</body>
</html>
