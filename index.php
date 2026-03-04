<?php
  if (!$_SESSION['user']) {
    header("Location: ./front-end/sign_up.php");
  }
?>