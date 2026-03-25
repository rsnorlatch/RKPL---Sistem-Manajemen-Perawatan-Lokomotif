<?php
if (!$_SESSION['user']) {
  header("Location: ./front-end/sign_up.php");
}

if (isset($_SESSION['user_is_driver'])) {
  header("Location: ./front-end/dashboard_masinis.php");
} else if (isset($_SESSION['user_is_maintainer'])) {
  header("Location: ./front-end/dashboard_timbalaiyasa.php");
} else if (isset($_SESSION['user_is_central_office'])) {
  header("Location: ./front-end/dashboard_kantorpusat.php");
} else {
  echo "idk how you got here";
}

