<?php
require './parts/connect_db.php';
$pageName = 'list';
$title = "資料列表";

$perPage = 20;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
if ($page < 1) {
  header('Location: ?page=1');
  exit;
}

$t_sql = "SELECT COUNT(1) FROM member";
// 總筆數
$totalRows = $pdo->query($t_sql)->fetch(PDO::FETCH_NUM)[0];

// 總頁數
$totalPages = ceil($totalRows / $perPage);

$rows = [];
// 如果有資料的話
if (!empty($totalRows)) {
  if ($page > $totalPages) {
    // 頁碼超出範圍時, 轉向到最後一頁
    header('Location: ?page=' . $totalPages);
    exit;
  }

  $sql = sprintf(
    "SELECT * FROM member ORDER BY mid  LIMIT %s, %s",
    ($page - 1) * $perPage,
    $perPage
  );
  $rows = $pdo->query($sql)->fetchAll();
}






?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>
<div class="container">
  <div class="row">
    <div class="col">
      <nav aria-label="Page navigation example">
        <ul class="pagination">
          <li class="page-item <?= $page == 1 ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page - 1 ?>"><i class="fa-solid fa-circle-arrow-left"></i></a>
          </li>

          <?php for ($i = $page - 5; $i <= $page + 5; $i++) :
            if ($i >= 1 and $i <= $totalPages) :
          ?>
              <li class="page-item <?= $i == $page ? 'active' : '' ?> ">
                <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
              </li>
          <?php endif;
          endfor; ?>

          <li class="page-item <?= $page == $totalPages ? 'disabled' : '' ?>">
            <a class="page-link" href="?page=<?= $page + 1 ?>"><i class="fa-solid fa-circle-arrow-right"></i></a>
          </li>
        </ul>
      </nav>
    </div>
  </div>
  <div class="row">
    <div class="col">
      <table class="table table-striped table-bordered">
        <thead>
          <tr>
            <th scope="col"><i class="fa-solid fa-trash-can"></i></th>
            <th scope="col">#</th>
            <th scope="col">姓名</th>
            <th scope="col">信箱</th>
            <th scope="col">手機</th>
            <th scope="col">生日</th>
            <th scope="col">地址</th>
            <th scope="col">帳號狀態</th>
            <th scope="col">創建時間</th>
            <th scope="col"><i class="fa-solid fa-file-pen"></i></th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($rows as $r) : ?>
            <tr>
              <td>
                <?php /*
                <a href="delete.php?mid=<?= $r['mid'] ?>"
                  onclick="return confirm('確定要刪除這筆資料嗎?')"
                >
                  <i class="fa-solid fa-trash-can"></i>
                </a>
              */ ?>

                <a href="javascript: delete_it(<?= $r['mid'] ?>)">
                  <i class="fa-solid fa-trash-can"></i>
                </a>
              </td>
              <td><?= $r['mid'] ?></td>
              <td><?= $r['name'] ?></td>
              <td><?= $r['email'] ?></td>
              <td><?= $r['mobile'] ?></td>
              <td><?= $r['birthday'] ?></td>
              <!--
              <td><?= strip_tags($r['address']) ?></td>
          -->
              <td><?= htmlentities($r['address']) ?></td>
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
</div>
<?php include './parts/scripts.php' ?>
<script>
  function delete_it(mid) {
    if (confirm(`確定要刪除編號為 ${mid} 的資料嗎?`)) {
      location.href = `delete.php?mid=${mid}`;
    }
  }
</script>
<?php include './parts/html-foot.php' ?>