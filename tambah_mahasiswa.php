<?php
// Include config file
require_once "koneksi.php";

// Define variables and initialize with empty values
$nim = $nama = $alamat = $jenis_kelamin = "";
$nim_err = $nama_err = $alamat_err = $jenis_kelamin = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate nim
    $input_nim = trim($_POST["nim"]);
    if(empty($input_nim)){
        $nim_err = "Masukkan NIM.";
    } elseif(!filter_var($input_nim)){
        $nim_err = "Masukkan NIM dengan benar.";
    } else{
        $nim = $input_nim;
    }

    // Validate nama
    $input_nama = trim($_POST["nama"]);
    if(empty($input_nama)){
        $nama_err = "Masukkan Nama.";
    } elseif(!filter_var($input_nama, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nama_err = "Masukkan Nama dengan benar.";
    } else{
        $nama = $input_nama;
    }

    // Validate address
    $input_alamat = trim($_POST["alamat"]);
    if(empty($input_alamat)){
        $alamat_err = "Masukkan Alamat.";
    } else{
        $alamat = $input_alamat;
    }

    // Validate salary
    $input_jenis_kelamin = trim($_POST["jenis_kelamin"]);
    if(empty($input_jenis_kelamin)){
        $jenis_kelamin_err = "Masukkan Jenis Kelamin.";
    } elseif(!ctype_digit($input_jenis_kelamin)){
        $jenis_kelamin_err = "Masukkan Jenis Kelamin dengan benar.";
    } else{
        $jenis_kelamin = $input_jenis_kelamin;
    }

    // Check input errors before inserting in database
    if(empty($nim_err) && empty($nama_err) && empty($alamat_err) && empty($jenis_kelamin_err)){
        // Prepare an insert statement
        $sql = "INSERT INTO mahasiswa (nim, nama, alamat, jenis_kelamin) VALUES (?, ?, ?, ?)";

        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "sss", $param_nim, $param_nama, $param_alamat, $param_jenis_kelamin);

            // Set parameters
            $param_nim = $nim;
            $param_nama = $nama;
            $param_alamat = $alamat;
            $param_jenis_kelamin = $jenis_kelamin;

            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Records created successfully. Redirect to landing page
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
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
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
                        <h2>Tambah Data Mahasiswa</h2>
                    </div>
                    <p>Silahkan isi form di bawah ini kemudian submit untuk menambahkan data mahasiswa ke dalam database.</p>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
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