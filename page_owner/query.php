<?php
include '../config.php';

// SETTING
if (isset($_POST['setting'])) {
  $id_user  = $_POST['id_user'];
  $nama     = $_POST['nama'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  mysqli_query($con, "UPDATE user SET nama='$nama', username='$username', password='$password' WHERE id=$id_user");
  echo '<script>alert("Data berhasil di Update");window.location="index.php";</script>';
}
// ========================================================================================================


// PROSES TAMBAH/EDIT/HAPUS USER
if (isset($_POST['user_add'])) {
  $nama     = $_POST['nama'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $level    = "ADMIN";

  mysqli_query($con, "INSERT INTO user VALUES ('','$nama','$username','$password','$level')");
  echo '<script>alert("Data berhasil ditambahkan");window.location="user.php";</script>';
}

if (isset($_POST['user_update'])) {
  $id_user  = $_POST['id_user'];
  $nama     = $_POST['nama'];
  $username = $_POST['username'];
  $password = $_POST['password'];

  mysqli_query($con, "UPDATE user SET nama='$nama', username='$username', password='$password' WHERE id=$id_user");
  echo '<script>alert("Data berhasil di Update");window.location="user.php";</script>';
}

if (isset($_GET['user_del'])) {
  $id = $_GET['user_del'];

  mysqli_query($con, "DELETE FROM user WHERE id='$id'");
  echo '<script>alert("Data berhasil dihapus");window.location="user.php";</script>';
}
// ========================================================================================================


// PROSES TAMBAH/EDIT/HAPUS PELANGGAN
if (isset($_POST['pelanggan_add'])) {
  $nama_pelanggan = $_POST['nama_pelanggan'];
  $no_hp          = $_POST['no_hp'];
  $alamat         = $_POST['alamat'];

  mysqli_query($con, "INSERT INTO pelanggan VALUES ('','$nama_pelanggan','$no_hp','$alamat')");
  echo '<script>alert("Data berhasil ditambahkan");window.location="pelanggan.php";</script>';
}

if (isset($_POST['pelanggan_update'])) {
  $id_pelanggan   = $_POST['id_pelanggan'];
  $nama_pelanggan = $_POST['nama_pelanggan'];
  $no_hp          = $_POST['no_hp'];
  $alamat         = $_POST['alamat'];

  mysqli_query($con, "UPDATE pelanggan SET nama_pelanggan='$nama_pelanggan', no_hp='$no_hp', alamat='$alamat' WHERE id=$id_pelanggan");
  echo '<script>alert("Data berhasil di Update");window.location="pelanggan.php";</script>';
}

if (isset($_GET['pelanggan_del'])) {
  $idp = $_GET['pelanggan_del'];

  mysqli_query($con, "DELETE FROM pelanggan WHERE id_pelanggan='$idp'");
  echo '<script>alert("Data berhasil dihapus");window.location="pelanggan.php";</script>';
}
// ========================================================================================================


// PROSES TAMBAH/EDIT/HAPUS BARANG
if (isset($_POST['barang_add'])) {
  $kode_barang = $_POST['kode_barang'];
  $nama_barang = $_POST['nama_barang'];
  $harga       = $_POST['harga'];
  $stok        = $_POST['stok'];

  $cek = mysqli_num_rows(mysqli_query($con, "SELECT * FROM barang WHERE kode_barang='$kode_barang' AND nama_barang='$nama_barang'"));
  if ($cek > 0) {
    echo '<script>alert("Input Gagal, Data Sudah tersedia");history.go(-1);</script>';
  } else {
    mysqli_query($con, "INSERT INTO barang VALUES ('','$kode_barang','$nama_barang','$harga','$stok')");
    echo '<script>alert("Data berhasil ditambahkan");window.location="barang.php";</script>';
  }
}

if (isset($_POST['barang_update'])) {
  $id_barang   = $_POST['id_barang'];
  $kode_barang = $_POST['kode_barang'];
  $nama_barang = $_POST['nama_barang'];
  $harga       = $_POST['harga'];

  mysqli_query($con, "UPDATE barang SET kode_barang='$kode_barang', nama_barang='$nama_barang', harga='$harga' WHERE id_barang=$id_barang");
  echo '<script>alert("Data berhasil di Update");window.location="barang.php";</script>';
}

if (isset($_POST['stok_update'])) {
  $id_barang = $_POST['id_barang'];
  $stok      = $_POST['stok'];

  mysqli_query($con, "UPDATE barang SET stok=stok+$stok WHERE id_barang=$id_barang");
  echo '<script>alert("Stok berhasil di Update");window.location="barang.php";</script>';
}

if (isset($_GET['barang_del'])) {
  $idb = $_GET['barang_del'];

  mysqli_query($con, "DELETE FROM barang WHERE id_barang='$idb'");
  echo '<script>alert("Data berhasil dihapus");window.location="barang.php";</script>';
}
// ========================================================================================================


// PROSES TAMBAH/EDIT/HAPUS PEMASUKAN
if (isset($_POST['pemasukan_add'])) {
  $nota         = $_POST['nota'];
  $tanggal      = date('Ymd');
  $id_pelanggan = $_POST['id_pelanggan'];
  $id_barang    = $_POST['id_barang'];
  $jumlah       = $_POST['jumlah'];

  $cek = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM barang WHERE id_barang='$id_barang'"));
  $stok = $cek['stok'];
  if ($jumlah > $stok) {
    echo '<script>alert("Transaksi gagal, stok tidak mencukupi.");history.go(-1);</script>';
  } else {
    mysqli_query($con, "INSERT INTO pemasukan VALUES('$nota','$id_pelanggan','$tanggal','$id_barang','$jumlah')");
    mysqli_query($con, "UPDATE barang SET stok=stok-$jumlah WHERE id_barang=$id_barang");
    echo '<script>alert("Transaksi Berhasil");window.location="pemasukan.php";</script>';
  }
}

if (isset($_GET['pemasukan_del'])) {
  $nota = $_GET['pemasukan_del'];

  $sql = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pemasukan WHERE nota='$nota'"));
  $id_barang = $sql['id_barang'];
  $jumlah    = $sql['jumlah'];

  $sql2 = mysqli_query($con, "DELETE FROM pemasukan WHERE nota='$nota'");
  if ($sql2) {
    mysqli_query($con, "UPDATE barang SET stok=stok+$jumlah WHERE id_barang='$id_barang'");
    echo '<script>alert("Data berhasil dihapus");window.location="pemasukan.php";</script>';
  }
}
// ========================================================================================================


// PROSES TAMBAH/EDIT/HAPUS PENGELUARAN
if (isset($_POST['pengeluaran_add'])) {
  $nota       = $_POST['nota'];
  $tanggal    = date('Ymd');
  $nominal    = $_POST['nominal'];
  $keterangan = $_POST['keterangan'];

  mysqli_query($con, "INSERT INTO pengeluaran VALUES('$nota','$tanggal','$nominal','$keterangan')");
  echo '<script>alert("Data berhasil ditambahkan");window.location="pengeluaran.php";</script>';
}

if (isset($_POST['pengeluaran_update'])) {
  $nota       = $_POST['nota'];
  $nominal    = $_POST['nominal'];
  $keterangan = $_POST['keterangan'];

  mysqli_query($con, "UPDATE pengeluaran SET nominal='$nominal', keterangan='$keterangan' WHERE nota_keluar='$nota'");
  echo '<script>alert("Data berhasil ditambahkan");window.location="pengeluaran.php";</script>';
}

if (isset($_GET['pengeluaran_del'])) {
  $nota = $_GET['pengeluaran_del'];

  mysqli_query($con, "DELETE FROM pengeluaran WHERE nota_keluar='$nota'");
  echo '<script>alert("Data berhasil dihapus");window.location="pengeluaran.php";</script>';
}
// ========================================================================================================