<?php

require './parts/connect_db.php';
$pageName = 'register';
$title = '註冊';


if (isset($_SESSION["action"])) {
  header("Location: index_.php");
  exit();
}
?>


<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>
<div class="container">
  <div class="row">
    <div class="col-lg-6">
      <div class="card">
        <div class="card-body">
          <h5 class="card-title">會員註冊</h5>
          <form action="" name="form1" onsubmit="checkForm(event)" novalidate>
            <!--novalidate->不要驗證-->
            <div class="mb-3">
              <label for="name" class="form-label">名字</label>
              <input type="text" class="form-control" id="name" name="name" required>
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="email" class="form-label">信箱</label>
              <input type="email" class="form-control" id="email" name="email" required>
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="mobile" class="form-label">電話</label>
              <input type="text" class="form-control" id="mobile" name="mobile" pattern="09\d{2}\d{3}\d{3}">
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="birthday" class="form-label">生日</label>
              <input type="date" class="form-control" id="birthday" name="birthday">
              <!--input type="datetime-local" => 年、月、日、時、分-->
              <div class="form-text"></div>
            </div>
            <div class="mb-3">
              <label for="address" class="form-label">地址</label>
              <textarea class="form-control" name="address" id="address" cols="30" rows="3"></textarea>
              <div class="form-text"></div>
            </div>
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

            <button type="submit" value="register" class="btn btn-primary">送出</button>
            <br>
            <p>已經成為會員?</p><a href="login-client.php">登入</a>
          </form>
        </div>
      </div>
    </div>
  </div>





</div>

<?php include './parts/scripts.php' ?>
<script>
  //驗證信箱
  function validateEmail(email) {
    var re =
      /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zAZ]{2,}))$/;
    return re.test(email);
  }

  // function validating(mobile) {
  //   var me = preg_match('/^[0-9]{10}+$/');
  //   return me.test(mobile);
  // }


  const checkForm = (e) => {
    e.preventDefault(); //不要讓原來的表單送出

    //所有輸入欄回復原來的外觀
    const inputs = document.querySelectorAll('input.form-control');
    inputs.forEach((el) => {
      el.style.border = '1px solid #CCCCCC';
      el.nextElementSibling.innerHTML = '';

    });






    //TODO: 欄位資料檢查 
    let isPass = true; //預設通過驗證

    let field = document.form1.name; //當前要驗證的欄位
    if (field.value.length < 2) { //name長度大於2
      isPass = false; //沒有通過驗證
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入正確的名字';
    }

    field = document.form1.email; //當前要驗證的欄位
    if (!validateEmail(field.value)) {
      isPass = false; //沒有通過驗證
      field.style.border = '2px solid red';
      field.nextElementSibling.innerHTML = '請輸入正確的信箱';
    }

    let pw1 = document.form1.password; //當前要驗證的欄位
    if (pw1.value.length < 8) { //password長度大於8
      isPass = false; //沒有通過驗證
      pw1.style.border = '2px solid red';
      pw1.nextElementSibling.innerHTML = '密碼長度必須要大於 8 個字元以上，並包含小寫字母、大寫字母、數字至少各1';
    }
    pw1 = document.form1.password;
    let pw2 = document.form1.cpassword; //當前要驗證的欄位
    if (pw1.value != pw2.value) {
      isPass = false; //沒有通過驗證
      pw2.style.border = '2px solid red';
      pw2.nextElementSibling.innerHTML = '兩次密碼並不相同!';
    }

    // field = document.form1.mobile; //當前要驗證的欄位
    // if (!validating(field.value).length < 10) {
    //   isPass = false; //沒有通過驗證
    //   field.style.border = '2px solid red';
    //   field.nextElementSibling.innerHTML = '請輸入正確的電話';
    // }
    if (!isPass) {
      return; //沒有通過驗證就結束，不發AJAX request
    }

    const formData = new FormData(document.form1); //formData 為表單物件




    //轉換為json格式
    // fetch('add-api.php', {
    //   method: 'POST', //post 方式送表單
    //   body: formData //送formData這個物件
    // }).then(function(response) {
    //   return response.json()
    // }).then(obj => {
    //   console.log(obj);
    // })方法同下
    fetch('register-api.php', {
        method: 'POST', //post 方式送表單
        body: formData //送formData這個物件
      }).then(r => r.json())
      .then(obj => {
        console.log(obj);
        if (obj.success) {
          alert('註冊成功');
          location.href = "index_.php";
        } else {
          for (let k in obj.errors) {
            const el = document.querySelector('#' + k);
            if (el) {
              el.style.border = '2px solid red';
              el.nextElementSibling.innerHTML = obj.errors[k];
            }
          }
        }
      })

    //轉換為純文字
    // fetch('add-api.php', {
    //   method: 'POST', //post 方式送表單
    //   body: formData //送formData這個物件
    // }).then(function(response) {
    //   return response.text()    
    // }).then(txt => {
    //   console.log(txt);
    // })
    /*
    取得頁面上所有的表單
      document.forms
    某個表單(名稱為form1)裡的所有欄位
      document.form1.elements
    
    拿到某一個表單欄位
    document.form1.mobile
    document.form1.elements['mobile']
    document.forom1.elements[2]


    */
  };
</script>
<?php include './parts/html-foot.php' ?>