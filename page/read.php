<?php
// Mengecek keberadaan id parameter sebelum melanjutkan ke proses berikutnya.
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    // Include config file
    require_once "../function/config.php";
    require_once "../function/helper.php";
    
    // Prepare a select statement
    $sql = "SELECT * FROM pustik_stuff WHERE id = ?";
    
    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i", $param_id);
        
        // Set parameters
        $param_id = trim($_GET["id"]);
        
        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            $result = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($result) == 1){
                /* Fetch result row as an associative array. Since the result set
                contains only one row, we don't need to use while loop */
                $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                
                // Retrieve stuff field value
                $nama_barang = $row["nama_barang"];
                $jumlah = $row["jumlah"];
                $barang = $row["barang"];
                $tahunan = $row["tahunan"];
            } else{
                // URL doesn't contain valid id parameter. Redirect to error page
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
} else{
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Record</title>
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
                    <h1 class="mt-5 mb-3">View Record</h1>
                    <div class="form-group">
                        <label>Nama Barang</label>
                        <p><b><?php echo $row["nama_barang"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Jumlah</label>
                        <p><b><?php echo $row["jumlah"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Ketersediaan Barang</label>
                        <p><b><?php echo $row["barang"]; ?></b></p>
                    </div>
                    <div class="form-group">
                        <label>Tahunan</label>
                        <p><b><?php echo $row["tahunan"];?></b></p>
                    </div>
                    <p><a href="<?= HOME_URL?>" class="btn btn-primary">Back</a></p>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>