<?php
require './client-required.php';
require './parts/connect_db.php';
$title = '重設密碼';

// echo json_encode($_POST);

$mid =  isset($_GET['mid']) ? intval($_GET['mid']) : 0;

// if (empty($email)) {
//   header('Location: list.php');  //回到列表頁
//   exit;
// }

$sql = "SELECT * FROM member WHERE mid = $mid";

$r = $pdo->query($sql)->fetch();
// if (empty($r)) {
//   //透過編號找不到資料的話 就不用作修改
//   header('Location: list.php');
//   exit;
// }
echo json_encode($r, JSON_UNESCAPED_UNICODE);
?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbarforclient.php' ?>
<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">重設密碼</h5>
          <form action="" name="form1" onsubmit="checkForm(event)" novalidate>
            <!--novalidate->不要驗證-->
            <input type="hidden" name="mid" value="<?= $mid ?>">
            <div class="mb-3">
              <label for="password" class="form-label">密碼</label>
              <input type="password" class="form-control" id="password" name="password">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">再次確認密碼</label>
              <input type="password" class="form-control" id="cpassword" name="cpassword">
              <div class="form-text"></div>
            </div>

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
  const checkForm = (e) => {
    e.preventDefault(); // 不要讓原來的表單送出

    // 所有輸入欄回復原來的外觀
    const inputs = document.querySelectorAll('input.form-control');
    inputs.forEach((el) => {
      el.style.border = '1px solid #CCCCCC';
      el.nextElementSibling.innerHTML = '';
    });

    let isPass = true; // 預設是通過驗證的

    let field = document.form1.password;
    if (field.value.length < 8) {
      isPass = false;
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '密碼長度必須要大於 8 個字元以上，並包含小寫字母、大寫字母、數字至少各1';
    }


    if (!isPass) {
      return; // 沒有通過檢查就結束, 不發 AJAX request
    }
    const fd = new FormData(document.form1);
    fetch('reset_password-api.php', {
        method: 'POST',
        body: fd
      })
      .then(r => r.json())
      .then(obj => {
        console.log(obj);
        if (obj.success) {
          alert('修改成功');
          location.href = 'welcome.php';
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