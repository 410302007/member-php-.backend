<?php

if (!isset($_SESSION)) {
  session_start();
}

if (!isset($_SESSION['client'])) {
  echo json_encode([
    'success' => false,
    'error' => '尚未登入!'
  ]);
  exit;
}
