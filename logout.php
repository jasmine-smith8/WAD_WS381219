<?php

// Logout
@session_start();
unset($_SESSION['userRole']);
session_destroy();

header("Location: login.php");