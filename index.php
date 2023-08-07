<?php 

require_once('function/config.php');
require_once('function/helper.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body align="center">
    <h2>Form Login Barang NOC Pustekinfokom UNHAN RI</h2>
    <p>Silahkan Isi Form</p>
    <form class="form" method="post" action="process/login.php">
  <div class="title">Welcome,<br><span>sign up to continue</span></div>
  <input type="text" placeholder="Nama" name="nama" class="input" required>
  <input type="password" placeholder="Password" name="password" class="input" required>
  <button class="button-confirm">Let`s go →</button>
</form>
</body>
</html>