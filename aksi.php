<?php
    include "koneksi.php";

    if(isset($_POST['bsimpan'])) {
        $simpan = mysqli_query($koneksi, "insert into mahasiswa (nim, nama, alamat, jenis_kelamin)
                                            values ('$_POST[tnim]',
                                                    '$_POST[tnama]',
                                                    '$_POST[talamat]',
                                                    '$_POST[tjenis_kelamin]') ");

    if($simpan) {
        echo "<script>
                alert('Simpan Data Sukses!');
                document.location='tampil_mahasiswa.php';
             </script>";
        }
    }

?>