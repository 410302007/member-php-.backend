<?php
require './admin-required.php';
require './parts/connect_db.php';
$title = '修改資料';

$mid =  isset($_GET['mid']) ? intval($_GET['mid']) : 0;

if (empty($mid)) {
  header('Location: list.php');  //回到列表頁
  exit;
}

$sql = "SELECT * FROM member WHERE mid = $mid ";

$r = $pdo->query($sql)->fetch();
if (empty($r)) {
  //透過編號找不到資料的話 就不用作修改
  header('Location: list.php');
  exit;
}
// echo json_encode($r, JSON_UNESCAPED_UNICODE);
?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>
<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">修改資料</h5>
          <form name="form1" onsubmit="checkForm(event)" novalidate>
            <input type="hidden" name="mid" value="<?= $r['mid'] ?>">
            <div class="mb-3">
              <label for="name" class="form-label">名字</label>
              <!-- htmlentities => 把字轉換為html -->
              <input type="text" class="form-control" id="name" name="name" value="<?= htmlentities($r['name']) ?>" required>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label">信箱</label>
              <input type="email" class="form-control" id="email" name="email" value="<?= $r['email'] ?>" required>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="mobile" class="form-label">電話</label>
              <input type="text" class="form-control" id="mobile" name="mobile" value="<?= $r['mobile'] ?>" pattern="09\d{2}?\d{3}?\d{3}">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="birthday" class="form-label">生日</label>
              <input type="date" class="form-control" id="birthday" name="birthday" value="<?= $r['birthday'] ?>">
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="address" class="form-label">地址</label>
              <!-- htmlentities => 把字轉換為html -->
              <textarea class="form-control" name="address" id="address" cols="30" rows="3"><?= htmlentities($r['address']) ?></textarea>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="member_status" class="form-label">帳號狀態</label>

              <select name="member_status" id="member_status" class="form-control">
                <option value="0" <?= $r['member_status'] == 0 ? 'selected' : '' ?>>停權</option>
                <option value="1" <?= $r['member_status'] == 1 ? 'selected' : '' ?>>正常</option>
              </select>
            </div>
            <!-- <div class="mb-3 ">
              <label for="pet_type" class="form-label">寵物種類</label>
              <select class="form-select form-select-sm" aria-label=".form-select-sm example">
                <option value="0" <?= $r['pet_type'] == 0 ? 'selected' : '' ?>>貓</option>
                <option value="1" <?= $r['pet_type'] == 1 ? 'selected' : '' ?>>狗</option>
              </select>
            </div> -->


            <button type="submit" class="btn btn-primary">修改</button>
            <input type="button" class="btn btn-primary" onclick="history.back();" value="返回">
          </form>

        </div>
      </div>

    </div>
  </div>



</div>
<?php include './parts/scripts.php' ?>
<script>
  // email 驗證
  function validateEmail(email) {
    var re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;
    return re.test(email);
  }



  const checkForm = (e) => {
    e.preventDefault(); // 不要讓原來的表單送出

    // 所有輸入欄回復原來的外觀
    const inputs = document.querySelectorAll('input.form-control');
    inputs.forEach((el) => {
      el.style.border = '1px solid #CCCCCC';
      el.nextElementSibling.innerHTML = '';
    });


    // TODO: 欄位資料檢查

    let isPass = true; // 預設是通過驗證的

    let field = document.form1.name; // 當前要驗證的欄位
    if (field.value.length < 2) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入正確的名字';
    }

    field = document.form1.email; // 當前要驗證的欄位
    if (!validateEmail(field.value)) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入正確的 Email';
    }


    if (!isPass) {
      return; // 沒有通過檢查就結束, 不發 AJAX request
    }
    const fd = new FormData(document.form1);
    fetch('edit-api.php', {
        method: 'POST',
        body: fd
      })
      .then(r => r.json())
      .then(obj => {
        console.log(obj);
        if (obj.success) {
          alert('修改成功');
          location.href = 'list.php';
        } else {
          for (let k in obj.errors) {
            const el = document.querySelector('#' + k);
            if (el) {
              el.style.border = '2px solid red';
              el.nextElementSibling.innerHTML = obj.errors[k];
            }
          }
          alert(`資料沒有修改`);
        }
      })
  };
</script>
<?php include './parts/html-foot.php' ?>