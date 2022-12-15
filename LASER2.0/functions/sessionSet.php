<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_POST['current'])){
    $_SESSION['currentData'] = $_POST['current'];

}

?>