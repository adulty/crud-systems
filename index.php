<?php 

require_once('function/connection.php');
require_once('function/helper.php');

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <style>
        table {
            margin-left:auto;
            margin-right:auto;
        }
    </style>
</head>
<body align="center">
    <form method="POST" action="process/login.php">
        <h2>Form Login Barang Pustik</h2>
        <p>Silahkan Isi Form</p>
        <table> 
            <tr>
                <td width="40px">Username</td>
                <td>:
                    <input type="text" name="nama" placeholder="Masukkan Nama">
                </td>
                <tr>
                    <td width="40px">Password</td>
                    <td>:
                    <input type="password" name="password" placeholder="Masukkan Password">
                </td>
                </tr>

            </tr>
        </table><br>

        <input type="submit" value="Login">
    </form>
</body>
</html>