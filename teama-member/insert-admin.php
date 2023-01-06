<?php
require './parts/connect_db.php';

$account = 'nancy';
$password = '654321';

$hash = password_hash($password, PASSWORD_BCRYPT);

$sql = "INSERT INTO `admins`(`account`, `password_hash`) VALUES ('{$account}', '{$hash}')"; //遇到錯誤訊息

try {
  echo $pdo->query($sql)->rowCount(); //有執行成功-> 執行A & C; 沒有執行成功->執行B & C

  echo "A~<br>";
} catch (PDOException $ex) {
  echo "B~<br>";
  echo $ex->getMessage();
}
echo "C~<br>";
