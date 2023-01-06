<?php
require './parts/connect_db.php';
// require '/client-required.php';
$pageName = 'welcome';
$title = '歡迎';


$id = intval($_SESSION['client']['mid']);
$sql2 = "SELECT * FROM member WHERE mid=$id";
$r = $pdo->query($sql2)->fetch();

$sql = "SELECT * FROM `member` where `name` =?";
$stmt = $pdo->prepare($sql);
$stmt->execute([
  $_SESSION['client']['name']
]);
$row = $stmt->fetch();

// echo json_encode($row);



?>
<?php include './parts/html-headforclient.php' ?>
<?php include './parts/navbarforclient.php' ?>

<h2 class="my-5 text-center">你好， <b><?php echo $r['name']; ?></b>，歡迎光臨!</h2>
<p class="text-center">
  <a href="edit-for-client.php?mid=<?php echo $_SESSION["client"]['mid']; ?>" class="btn btn-primary">編輯個人資料</a>
  <a href="reset_password.php" class="btn btn-primary ml-3">重設密碼</a>
  <a href="logout-api.php" class="btn btn-danger ml-3">登出</a>
</p>
<?php include './parts/scripts.php' ?>

<?php include './parts/html-foot.php' ?>