<?php
require './admin-required-api.php';
require './parts/connect_db.php';
header('Content-Type: application/json');

$output = [
  'success' => false,
  'code' => 0,
  'error' => ''
];

if (empty($_GET['filename'])) {
  $output['error'] = '沒有資料';
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}


$sql = "UPDATE `admins` SET `avatar`=? WHERE `sid`=?";
$stmt = $pdo->prepare($sql);


$stmt->execute([
  $_GET['filename'],
  $_SESSION['admin']['sid'],    //登入成功後，session會有值，可代入
]);

$output['success'] = !!$stmt->rowCount();
if ($output['success']) {
  // 記得去修改 session 存放的內容
  $_SESSION['admin']['avatar'] = $_GET['filename'];
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
