<?php
require './parts/connect_db.php';
header('Content-Type: application/json');

$output = [
  'success' => false,
  'postData' => $_POST,
  'code' => 0,
  'error' => ''
];
if (empty($_POST['account']) or empty($_POST['password'])) {
  $output['error'] = '欄位不足';
  $output['code'] = 50;
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

$sql = "SELECT * FROM admins WHERE account=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_POST['account']
]);
$row = $stmt->fetch();

// echo json_encode($row, JSON_UNESCAPED_UNICODE);
// exit;


if (empty($row)) {
  # 帳號是錯的
  $output['error'] = '帳號或密碼錯誤';
  $output['code'] = 100;
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}



if (
  password_verify($_POST['password'], $row['password_hash'])
) {
  $output['success'] = true;
  $_SESSION['admin'] = [
    'sid' => $row['sid'],
    'account' => $row['account'],
    'avatar' => $row['avatar'],
  ];
} else {
  # 密碼錯誤
  $output['error'] = '帳號或密碼錯誤';
  $output['code'] = 200;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
