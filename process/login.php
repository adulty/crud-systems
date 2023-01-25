<?php

require_once('../function/helper.php');
require_once('../function/config.php');

// Menangkap request
$username = $_POST['nama'];
$password = md5($_POST['password']);

$query = mysqli_query($link, "SELECT * FROM login WHERE nama = '$username' AND password = '$password'");

// Define variables and initialize with empty value
$username = $password = "";
$user_error = $pass_error = "";

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