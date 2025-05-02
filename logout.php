<?php
session_start();
session_destroy(); // Destroy session
header("Location: ../login_form.php"); // Ensure this is the correct relative path
exit();
?>
