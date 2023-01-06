<?php
if (isset($title)) {
  $title = $title . '-歡迎光臨';
} else {
  $title = '歡迎光臨';
}
$pageName = $pageName ?? ''; //如果沒有設定，就設定為空字串
?>
<!DOCTYPE html>
<html lang="zh">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>毬</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">
  <style>
    /* container,nav,content-title,content{
      border: 1px solid darkblue;
    } */
  </style>
</head>

<body>