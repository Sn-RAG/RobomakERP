<?php
session_start();
session_destroy();
setcookie("Keksan", "", time() - 1);
header('location:index.php');