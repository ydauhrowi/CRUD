<?php

	$_server = "localhost";
	$user	= "root";
	$password	= "";
	$database	= "db_siska";

$koneksi = mysqli_connect($_server, $user, $password, $database) or die(mysqli_error($koneksi));
