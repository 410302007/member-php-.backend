<?php

require './parts/connect_db.php';


?>
<?php include './parts/html-head.php' ?>

<?php include './parts/html-body-sidebar.php' ?>
<div class="container">
  <h2>歡迎<b><?php echo $_SESSION["admin"]['account']; ?></b>!</h2>

</div>

<?php include './parts/scripts.php' ?>
<?php include './parts/html-foot.php' ?>