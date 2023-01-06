<?php
require './parts/connect_db.php';
$pageName = 'login-client';

if (isset($_SESSION['client'])) {
  header('Location: welcome.php');
  exit;
}

?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>

<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">用戶登入</h5>
          <form name="form1" onsubmit="checkForm(event)">
            <div class="mb-3">
              <label for="email" class="form-label">信箱</label>
              <input type="text" class="form-control" id="email" name="email" required>
              <div class="form-text"></div>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">密碼</label>
              <input type="password" class="form-control" id="password" name="password" required>
              <div class="form-text"></div>
            </div>
            <button type="submit" value="Login" class="btn btn-primary">登入</button>
            <button type="submit" value="reset" class="btn btn-primary"><a href="#" onclick="location.href='forget-password.php'"></a>忘記密碼</button>
            <br>
            <p>還沒成為會員嗎?</p>
            <a href="register.php">註冊會員</a>

          </form>

        </div>
      </div>
    </div>
  </div>

</div>
<?php include './parts/scripts.php' ?>
<script>
  function checkForm(e) {
    e.preventDefault();
    // TODO: 欄位檢查

    const fd = new FormData(document.form1);

    fetch('login-client-api.php', {
        method: 'POST',
        body: fd
      })
      .then(r => r.json())
      .then(data => {
        console.log(data);
        if (data.success) {
          alert('成功登入');
          location.href = 'welcome.php';
        } else {
          alert(data.error);
        }
      })

  }
</script>
<?php include './parts/html-foot.php' ?>