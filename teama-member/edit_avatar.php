<?php
require './parts/connect_db.php';



?>
<?php include './parts/html-head.php' ?>
<?php include './parts/navbar.php' ?>
<div class="container">
  <div class="row">
    <div class="col-lg-4">
      <div class="card">
        <input type="hidden" id="avatar_val" value="<?= $_SESSION['admin']['avatar'] ?>">

        <img id="myimg" src="./../uploads/<?= empty($_SESSION['admin']['avatar']) ? '_default.png' : $_SESSION['admin']['avatar'] ?>" class="card-img-top" alt="...">
        <div class="card-body">

          <button class="btn btn-primary" onclick="f.click()">上傳</button>
          <button class="btn btn-danger" onclick="update_avatar()">確定</button>
          <button class="btn btn-warning" onclick="location.reload()">取消</button>
        </div>


        <form name="form1" onsubmit="return false" style="display: none;">
          <input type="file" name="avatar" accept="image/*" />
        </form>
      </div>
    </div>
  </div>
</div>
<?php include './parts/scripts.php' ?>
<script>
  const f = document.form1.avatar;
  const myimg = document.querySelector("#myimg");
  const avatar_val = document.querySelector("#avatar_val");


  f.onchange = async () => {
    const fd = new FormData(document.form1);
    const r = await fetch('./../practice/upload-single.php', {
      method: 'POST',
      body: fd
    });
    const data = await r.json();
    console.log({
      data
    });
    if (data.success) {
      // 成功上傳
      myimg.src = './../uploads/' + data.filename;
      avatar_val.value = data.filename

    } else {
      alert(data.error || '沒有上傳的檔案');
    }
  };

  async function update_avatar() {
    const filename = avatar_val.value;

    const r = await fetch(`edit_avatar-api.php?filename=${filename}`);
    const data = await r.json();
    if (data.success) {
      alert('大頭貼更新完成~');
    } else {
      alert('大頭貼更新發生錯誤!!');
    }
  }
</script>
<?php include './parts/html-foot.php' ?>