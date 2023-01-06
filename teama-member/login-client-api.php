<?php
require './parts/connect_db.php';
header('Content-Type: application/json');

$output = [
  'success' => false,
  'postData' => $_POST,
  'code' => 0,
  'error' => ''
];
if (empty($_POST['email']) or empty($_POST['password'])) {
  $output['error'] = '欄位不足';
  $output['code'] = 50;
  echo json_encode($output, JSON_UNESCAPED_UNICODE);
  exit;
}

$sql = "SELECT * FROM member WHERE email=?";
$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_POST['email']
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
  password_verify($_POST['password'], $row['password'])
) {
  $output['success'] = true;
  $_SESSION['client'] = [
    'name' => $row['name'],
    'email' => $row['email'],
    'mid' => $row['mid'],
    'avatar' => $row['avatar'],
    // 'password' => $row['password'],

  ];
} else {
  # 密碼錯誤
  $output['error'] = '帳號或密碼錯誤';
  $output['code'] = 200;
}

echo json_encode($output, JSON_UNESCAPED_UNICODE);
