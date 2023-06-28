<?php
// Include config file
require_once "koneksi.php";
 
// Define variables and initialize with empty values
$nim = $nama = $alamat = $jenis_kelamin = "";
$nim_err = $nama_err = $alamat_err = $jenis_kelamin_err = "";
 
// Processing form data when form is submitted
if(isset($_POST["id"]) && !empty($_POST["id"])){
    // Get hidden input value
    $id = $_POST["id"];
    
    // Validate name
    $input_nim = trim($_POST["nim"]);
    if(empty($input_nim)){
        $nim_err = "Silahkan Masukkan NIM.";
    } elseif(!filter_var($input_nim)){
        $nim_err = "Silahkan Masukkan NIM dengan benar !.";
    } else{
        $nim = $input_nim;
    }
    // Validate name
    $input_nama = trim($_POST["nama"]);
    if(empty($input_nama)){
        $nama_err = "Silahkan Masukkan Nama.";
    } elseif(!filter_var($input_nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $name_err = "Silahkan Masukkan Nama dengan benar !.";
    } else{
        $nama = $input_nama;
    }
    
    // Validate address address
    $input_alamat = trim($_POST["alamat"]);
    if(empty($input_alamat)){
        $address_err = "Silahkan masukkan alamat.";     
    } else{
        $alamat = $input_alamat;
    }
    
    // Validate salary
    $input_jenis_kelamin = trim($_POST["jenis_kelamin"]);
    if(empty($input_jenis_kelamin)){
        $jenis_kelamin_err = "Silahkan masukkan jenis kelamin.";     
    } elseif(!ctype_digit($input_salary)){
        $jenis_kelamin_err = "Masukkan jenis kelamin dengan benar.";
    } else{
        $jenis_kelamin = $input_jenis_kelamin;
    }
    
    // Check input errors before inserting in database
    if(empty($nim_err) && ($nama_err) && empty($alamat_err) && empty($jenis_kelamin_err)){
        // Prepare an update statement
        $sql = "UPDATE mahasiswa SET nim=?, nama=?, alamat=?, jenis_kelamin=? WHERE id=?";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sssi", $param_nim, $param_nama, $param_alamat, $param_jenis_kelamin, $param_id);
            
            // Set parameters
            $param_nim = $nim;
            $param_nama = $nama;
            $param_alamat = $alamat;
            $param_jenis_kelamin = $jenis_kelamin;
            $param_id = $id;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records updated successfully. Redirect to landing page
                header("location: tampil_mahasiswa.php");
                exit();
            } else{
                echo "Something went wrong. Please try again later.";
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
        $sql = "SELECT * FROM mahasiswa WHERE id = ?";
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
                    $nim = $row["nim"];
                    $nama = $row["nama"];
                    $alamat = $row["alamat"];
                    $jenis_kelamin = $row["jenis_kelamin"];
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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper{
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Update Record</h2>
                    </div>
                    <p>Please edit the input values and submit to update the record.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                    <div class="form-group <?php echo (!empty($nim_err)) ? 'has-error' : ''; ?>">
                            <label>NIM</label>
                            <input type="text" name="nim" class="form-control" value="<?php echo $nim; ?>">
                            <span class="help-block"><?php echo $nim_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($nama_err)) ? 'has-error' : ''; ?>">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>">
                            <span class="help-block"><?php echo $nama_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($alamat_err)) ? 'has-error' : ''; ?>">
                            <label>Alamat</label>
                            <textarea name="alamat" class="form-control"><?php echo $alamat; ?></textarea>
                            <span class="help-block"><?php echo $alamat_err;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($jenis_kelamin_err)) ? 'has-error' : ''; ?>">
                            <label>Jenis Kelamin</label>
                            <p><input type="radio" name="jenis_kelamin" value="L" <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin']=="L") echo "checked";?>> Laki-laki</p>
                            <P><input type="radio" name="jenis_kelamin" value="P" <?php if (isset($_POST['jenis_kelamin']) && $_POST['jenis_kelamin']=="P")  echo "checked";?>> Perempuan</P>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Submit">
                        <a href="tampil_mahasiswa.php" class="btn btn-default">Cancel</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>