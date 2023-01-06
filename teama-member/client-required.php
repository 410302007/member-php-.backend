<?php

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['client'])) {
  header('Location: login-client.php');
  exit;
}
