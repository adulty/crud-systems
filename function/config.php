<?php
// Starting the session, necessary
// for using session variables

$nama = "";
$email = "";
$errors = array();

 
/* Attempt to connect to MySQL database */
$link = mysqli_connect('localhost', 'root', '', 'pustik');

// Registration code
if (isset($_POST['reg_user'])) {

    $nama = mysqli_real_escape_string($link, $_POST['nama']);
    $email = mysqli_real_escape_string($link, $POST['email']);
    $password_1 = mysqli_real_escape_string($link, $POST['password_1']);
    $password_2 = mysqli_real_escape_string($link, $POST['password_2']);


    if (empty($nama)) { array_push($errors, "Nama tidak boleh kosong."); }
    if (empty($email)) { array_push($errors, "E-mail tidak boleh kosong."); }
    if (empty($password_1)) { array_push($errors, "Password tidak boleh kosong."); }


    if ($password_1 != $password_2) {
        array_push($errors, "Password kedua tidak sama.");
    }


    if (count($errors)  == 0) {

        $password = md5($password_1);

        $query = "INSERT INTO users (nama, email, password) VALUES('$nama', '$email', '$password')";

        mysqli_query($link, $query);


        $_SESSION['nama'] = $nama;

        header('location: dashboard.php');
    } 

}

//UserLogin
if (isset($_POST['login_user'])) {

    $nama = mysqli_real_escape_string($link, $_POST['nama']);
    $password = mysqli_real_escape_string($link, $_POST['password']);


    if (empty($nama)) {
        array_push($errors, "Nama tidak boleh kosong.");
    }
    if (empty($password)) {
        array_push($errors, "Password tidak boleh kosong.");
    }

    if (count($errors) == 0) {

        $password = md5($password);

        $query = "SELECT * FROM users WHERE nama= '$nama' AND password='$password'";
        $results = mysqli_query($link, $query);

        if (mysqli_num_rows($results) == 1) {
            $_SESSION['nama'] = $nama;

            header('location: dashboard.php');
        } else {
            array_push($errors, "Nama atau password salah!");
        }
    }

}

?>
