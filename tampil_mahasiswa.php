<?php

    include "koneksi.php";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" type=text/css href="css/bootstrap.min.css">
</head>
<body>
    <div class=container>
        <h1 class="text-center mt-2">INFORMASI DATA MAHASISWA</h1> 
        <hr>
    <div class="card">
        <div class="card-header bg-primary text-white">
            Data Mahasiswa
        </div>
    <div class="card-body">
    <button type="button" class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#modaltambah">
    Tambah Data
    </button>
    <table class="table table-striped table-hover">
        <tr>
            <th>NO.</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Alamat</th>
            <th>Jenis Kelamin</th>
            <th>Created At</th>
            <th>Aksi</th>
        </tr>

        <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * from mahasiswa order by id desc");
            while ($data = mysqli_fetch_array($tampil)) :
        
        ?>

        <tr>
            <td><?= $no++ ?></td>
            <td><?= $data['nim']?></td>
            <td><?= $data['nama']?></td>
            <td><?= $data['alamat']?></td>
            <td><?= $data['jenis_kelamin']?></td>
            <td><?= $data['created_at']?></td>
            <td>
                <a href="#" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#modalubah<?= $no ?>">Ubah</a>
                <a href="#" class="btn btn-danger">Hapus</a>
            </td>
            
        </tr>

<!--modal ubah-->

<div class="modal fade modal-lg" id="modalubah<?= $no ?>" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Baru</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form method="POST" action="aksi.php">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="tnim" value="<?=$data['nim']?>" placeholder="Masukkan NIM Anda !.">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="tnama" value="<?=$data['nama']?>" placeholder="Masukkan Nama Anda !.">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="talamat" placeholder="Masukkan Alamat Anda !" rows="3"><?=$data['alamat']?></textarea>
                </div>
                <div class="form-check">
                <label for="exampleFormControlInput1" class="form-label">Jenis Kelamin</label><br>
                    <label><input class="form-check-input" type="radio" <?php if($hasil['jenis_kelamin']=="L"){echo "checked";}?> name="tjenis_kelamin" value="L">Laki - laki</label><br>
                    <label><input class="form-check-input" type="radio" <?php if($hasil['jenis_kelamin']=="P"){echo "checked";}?> name="tjenis_kelamin" value="P">Perempuan</label>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="bubah">Ubah</button>
      </div>
      </form>
    </div>
  </div>
</div>

        <?php endwhile; ?>
    </table>

<!-- Modal -->
<div class="modal fade modal-lg" id="modaltambah" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Tambah Data Baru</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <form method="POST" action="aksi.php">
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">NIM</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="tnim" placeholder="Masukkan NIM Anda !.">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlInput1" class="form-label">Nama</label>
                    <input type="text" class="form-control" id="exampleFormControlInput1" name="tnama" placeholder="Masukkan Nama Anda !.">
                </div>
                <div class="mb-3">
                    <label for="exampleFormControlTextarea1" class="form-label">Alamat</label>
                    <textarea class="form-control" id="exampleFormControlTextarea1" name="talamat" placeholder="Masukkan Alamat Anda !" rows="3"></textarea>
                </div>
                <div class="form-check">
                <label for="exampleFormControlInput1" class="form-label">Jenis Kelamin</label><br>
                    <label><input class="form-check-input" type="radio" name="tjenis_kelamin" value="L">Laki - laki</label><br>
                    <label><input class="form-check-input" type="radio" name="tjenis_kelamin" value="P">Perempuan</label>
                </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="submit" class="btn btn-primary" name="bsimpan">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
    </div>
    </div>   
    </div>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
</body>
</html>
        