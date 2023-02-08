<?php
    require_once('errors.php');
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Daftar Barang Pustik</title>
    <style>
        table {
            margin-left:auto;
            margin-right:auto;
        }
    </style>
</head>
<body align="center">
    <form action="register.php" method="POST">
        <h2>Form Registrasi Akun</h2>
        <p>Silahkan isi Form</p>
        <table> 
            <tr>
                <label for="nama"><td width="40px">Username</td></label>
                <td>:
                    <input type="text" name="nama" value="<?php echo $nama; ?>">
                </td>
                <tr>
                    <label for="email"><td width="40px">Email</td></label>
                    <td>:
                    <input type="email" name="email" value="<?php echo $email; ?>">
                </td>
                <td>
                <label for="password_1"><td width="40px">Masukkan Password</td></label>
                <td>:
                    <input type="password" name="password_1">
                </td>
                </td>
                <td>
                <label for="password_2"><td width="40px">Confirm password</td></label>
                <td>:
                    <input type="password" name="password_2">
                </td>
                </tr>

            </tr>
        </table><br>
    </form>
</body>
</html>