<?php
require './parts/connect_db.php';
$pageName = 'list';
$title = "資料列表";

$perPage = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;  //如果沒有設定，查看的就是第一頁 
if ($page < 1) {
  header('Location: ?page=1'); //頁數小於1,轉向第一頁
  exit;
}



$t_sql = "SELECT COUNT(1) FROM member";
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];
$totalPages = ceil($totalRows / $perPage);



$rows = [];
//如果有資料的話，我才做分頁
if (!empty($totalRows)) {
  if ($page > $totalPages) {
    //頁碼超出範圍時，轉向最後一頁
    header('Location: ?page=' . $totalPages);
    exit;
  }

  $sql = sprintf(
    "SELECT * FROM member ORDER BY mid LIMIT %s, %s",
    ($page - 1) * $perPage,
    $perPage
  );
  $rows = $pdo->query($sql)->fetchAll();  //如果有資料,再拿資料分頁
}




?>

<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>
<div class="container">
  <!-- <input type="text" name="keyword"> -->
  <!-- <div class="row">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fa-solid fa-circle-arrow-left"></i></a></li>
          <?php for ($i = $page - 3; $i <= $page + 3; $i++) : if ($i >= 1 and $i <= $totalPages) : ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
          <?php endif;
          endfor ?>

          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page + 1 ?>"><i class="fa-solid fa-circle-arrow-right"></i></a></li>
        </ul>
      </nav>
    </div>
  </div> -->
  <div class="row">
    <div class="col">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th scope="col">檢視</i></th>
            <th scope="col"><i class="fa-solid fa-trash"></i></th>
            <th scope="col">#</th>
            <th scope="col">姓名</th>
            <th scope="col">電郵</th>
            <th scope="col">手機</th>
            <th scope="col">生日</th>
            <th scope="col">地址</th>
            <!-- <th scope="col">寵物種類</th> -->
            <th scope="col">帳號狀態</th>
            <th scope="col">創建時間</th>
            <th scope="col"><i class="fa-solid fa-file-pen"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <tr>
              <td>
                <a href="details.php?mid=<?= $r['mid'] ?>">
                  <i class="fa-solid fa-eye"></i>
                </a>
              </td>
              <td>
                <a href="delete.php?mid=<?= $r['mid'] ?>">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
              <td><?= $r['mid'] ?></td>
              <td><?= $r['name'] ?></td>
              <td><?= $r['email'] ?></td>
              <td><?= $r['mobile'] ?></td>
              <td><?= $r['birthday'] ?></td>
              <td><?= $r['address'] ?></td>
              <!-- <td><?= $r['pet_type'] == 1 ? '狗' : '貓' ?></td> -->
              <td><?= $r['member_status'] == 1 ? '正常' : '停權' ?></td>
              <td><?= $r['created_at'] ?></td>
              <td>
                <a href="edit.php?mid=<?= $r['mid'] ?>">
                  <i class="fa-solid fa-file-pen"></i>
                </a>
              </td>
            </tr>
          <?php endforeach ?>
        </tbody>

      </table>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fa-solid fa-circle-arrow-left"></i></a></li>
          <?php for ($i = $page - 3; $i <= $page + 3; $i++) : if ($i >= 1 and $i <= $totalPages) : ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                <!---->
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
          <?php endif;
          endfor ?>

          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>"><a class="page-link" href="?page=<?= $page + 1 ?>"><i class="fa-solid fa-circle-arrow-right"></i></a></li>
        </ul>
      </nav>
    </div>
  </div>
</div>

<?php include './parts/scripts.php' ?>

<?php include './parts/html-foot.php' ?>