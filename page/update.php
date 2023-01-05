<?php
// Include config file
require_once "../function/config.php";
require_once "../function/helper.php";
 
// Define variables and initialize with empty values
$nama_barang = $jumlah = $satuan = $tahunan = "";
$nama_err = $jumlah_err = $satuan_err = $tahun_err = "";
// Memproses data ketika form sudah dikirim
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validasi name
    $input_nama = trim($_POST["nama_barang"]);
    if(empty($input_nama)){
        $nama_err = "Mohon masukkan nama..";
    } elseif(!filter_var($input_nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nama_err = "Mohon masukkan nama yang benar.";
    } else{
        $nama_barang = $input_nama;
    }
    
    // Validasi jumlah
    $input_jumlah = trim($_POST["jumlah"]);
    if(empty($input_jumlah)){
        $jumlah_err = "Mohon masukkan jumlah.";     
    } else{
        $jumlah = $input_jumlah;
    }
    
    // Validasi satuan
    $input_satuan = trim($_POST["satuan"]);
    if(empty($input_satuan)){
        $satuan_err = "Mohon masukkan satuan.";     
    } elseif(!filter_var($input_satuan, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))) {
        $satuan_err = "Mohon masukkan satuan yang benar.";
    }  else{
        $satuan = $input_satuan;
    }

    // Validasi tahunan
    $input_tahunan = trim($_POST["tahunan"]);
    if(empty($input_tahunan)) {
        $tahun_err = "Mohon masukkan tahunan.";
    } elseif(!ctype_digit($input_tahunan)){
        $tahun_err = "Mohon isi dengan bilangan integer positif.";
    } else{
        $tahunan = $input_tahunan;
    }
    
    // Memeriksa inputan error sebelum memasukkannya ke DataBase
    if(empty($nama_err) && empty($jumlah_err) && empty($satuan_err) && empty($tahun_err)){
        // Prepare an update statement
        $sql = "UPDATE pustik_stuff SET nama_barang=?, jumlah=?, satuan=?, tahunan=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sisii", $param_nama, $param_jumlah, $param_satuan, $param_tahun, $param_id);
            
            // Set parameters
            $param_nama= $nama_barang;
            $param_jumlah = $jumlah;
            $param_satuan = $satuan;
            $param_tahun = $tahunan;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: ". HOME_URL);
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
} else{
    // Check existence of id parameter before processing further
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // Get URL parameter
        $id =  trim($_GET["id"]);
        
        // Prepare a select statement
        $sql = "SELECT * FROM pustik_stuff WHERE id = ?";
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "i", $param_id);
            
            // Set parameters
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                $result = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($result) == 1){
                    /* Fetch result row as an associative array. Since the result set
                    contains only one row, we don't need to use while loop */
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    
                    // Retrieve individual field value
                    $nama_barang = $row["nama_barang"];
                    $jumlah = $row["jumlah"];
                    $satuan = $row["satuan"];
                    $tahunan = $row["tahunan"];
                } else{
                    // URL doesn't contain valid id. Redirect to error page
                    header("location: error.php");
                    exit();
                }
                
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
        
        // Close connection
        mysqli_close($link);
    }  else{
        // URL doesn't contain id parameter. Redirect to error page
        header("location: error.php");
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Record</title>
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
                    <h2 class="mt-5">Update Record</h2>
                    <p>Please edit the input values and submit to update the employee record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
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
                            <input type="number" name="tahunan" class="form-control <?php echo(!empty($tahun_err)) ? 'is-invalid': ''; ?>" value="<?php echo $tahunan; ?>">
                            <span class="invalid-feedback"><?php echo $tahun_err; ?> </span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="../dashboard.php" class="btn btn-secondary ml-2">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>