<?php

require_once('../function/helper.php');
require_once('../function/connection.php');

// Menangkap request
$username = $_POST['nama'];
$password = md5($_POST['password']);

$query = mysqli_query($connection, "SELECT * FROM login_form WHERE nama = '$username' AND password = '$password'");

// Mengecek pengguna ke database
if (mysqli_num_rows($query) != 0) {
    $row = mysqli_fetch_assoc($query);

    // var_dump($row);
    // die();
    // Membuat session
    session_start();
    $_SESSION['id'] = $row['id'];
    header("location: " . BASE_URL . 'dashboard.php?page=home');
} else {
    header("location: " . BASE_URL);
}