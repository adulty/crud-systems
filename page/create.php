<?php
// Include config file
require_once "../function/config.php";
require_once "../function/helper.php";

 
// Define variables and initialize with empty values
$nama_barang = $jumlah = $satuan = $tahunan = "";
$nama_err = $jumlah_err = $satuan_err = $tahun_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate name
    $input_name = trim($_POST["nama_barang"]);
    if(empty($input_name)){
        $nama_err = "Please enter a name.";
    } elseif(!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nama_err = "Please enter a valid name.";
    } else{
        $nama_barang = $input_name;
    }
    
    // Validate Total
    $input_jumlah = trim($_POST["jumlah"]);
    if(!ctype_digit($input_jumlah)){
        $jumlah_err = "Please enter a positive integer value.";     
    } else{
        $jumlah = $input_jumlah;
    }
    
    // Validate Satuan
    $input_satuan = trim($_POST["satuan"]);
    if(empty($input_satuan)){
        $satuan_err = "Mohon masukkan satuan.";     
    } elseif(!filter_var($input_satuan, FILTER_VALIDATE_REGEXP, array
    ("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $satuan_err = "Mohon masukkan satuan yang benar.";
    }  else {
        $satuan = $input_satuan;
    }
    
    // Validasi Tahunan
    $input_tahunan = trim($_POST["tahunan"]);
    if(empty($input_tahunan)){
        $tahun_err = "Please enter the salary amount.";     
    } elseif(!ctype_digit($input_tahunan)){
        $tahun_err = "Please enter a positive integer value.";
    } else{
        $tahunan = $input_tahunan;
    }

    // Check input errors before inserting in database
    if(empty($nama_err) && empty($jumlah_err) && empty($satuan_err) && empty($tahun_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO pustik_stuff (nama_barang, jumlah, satuan, tahunan) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_nama, $param_jumlah, $param_satuan, $param_tahun);
            
            // Set parameters
            $param_nama = $nama_barang;
            $param_jumlah = $jumlah;
            $param_satuan = $satuan;
            $param_tahun = $tahunan;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
                header("location: ". BASE_URL . 'dashboard.php?page=home');
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .wrapper{
            width: 600px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="mt-5">Create Record</h2>
                    <p>Mohon isi Form ini dan Kirim untuk Menambahkan record ke Database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group">
                            <label>Nama Barang</label>
                            <input type="text" name="nama_barang" class="form-control <?php echo (!empty($nama_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $nama_barang; ?>">
                            <span class="invalid-feedback"><?php echo $nama_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Jumlah</label>
                            <textarea name="jumlah" class="form-control <?php echo (!empty($jumlah_err)) ? 'is-invalid' : ''; ?>"><?php echo $jumlah; ?></textarea>
                            <span class="invalid-feedback"><?php echo $jumlah_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Satuan</label>
                            <input type="text" name="satuan" class="form-control <?php echo (!empty($satuan_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $satuan; ?>">
                            <span class="invalid-feedback"><?php echo $satuan_err;?></span>
                        </div>
                        <div class="form-group">
                            <label>Tahunan</label>
                            <input type="number" name="tahunan" class="form-control <?php echo (!empty($tahun_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $tahunan; ?>">
                            <span class="invalid-feedback"><?php echo $tahun_err;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Kirim">
                        <a href="../dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>