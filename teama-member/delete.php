<?php
require './admin-required.php';
require './parts/connect_db.php';

$mid =  isset($_GET['mid']) ? intval($_GET['mid']) : 0;

if (empty($mid)) {
  header('Location: list3.php');  //回到列表頁
  exit;
}
$sql = "DELETE FROM `member` WHERE mid =$mid";
$pdo->query($sql);

if (empty($_SERVER['HTTP_REFERER'])) {
  $come_from = 'list3.php';
} else {
  $come_from = $_SERVER['HTTP_REFERER']; // 從哪裡來, 回哪裡去
}

header("Location: $come_from");
