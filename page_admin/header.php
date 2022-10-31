<?php
include '../config.php';
session_start();

if (!isset($_SESSION['user'])) {
  header("location:../403.php");
  exit;
} else {
  $id  = $_SESSION['user'];
  $sql = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM user WHERE id='$id'"));
  $use = $sql['nama'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Sistem Manajemen Keuangan</title>
  <link href="../assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="../assets/css/ruang-admin.min.css" rel="stylesheet">
  <!-- Select2 -->
  <link href="../assets/vendor/select2/dist/css/select2.min.css" rel="stylesheet" type="text/css">
  <!-- Bootstrap DatePicker -->
  <link href="../assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">

  <link href="../assets/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <!-- <div class="sidebar-brand-icon">
          <img src="../assets/img/logo/logo2.png">
        </div> -->
        <div class="sidebar-brand-text mx-3">Rumah Doodle</div>
      </a>
      <hr class="sidebar-divider my-0">
      <li class="nav-item active">
        <a class="nav-link" href="index.php">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span></a>
      </li>
      <hr class="sidebar-divider">
      <div class="sidebar-heading">
        Navigation
      </div>
      <li class="nav-item">
        <a class="nav-link" href="pelanggan.php">
          <i class="fas fa-fw fa-users"></i>
          <span>Data Pelanggan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="barang.php">
          <i class="fas fa-fw fa-shopping-cart"></i>
          <span>Data Barang</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pemasukan.php">
          <i class="fas fa-fw fa-download"></i>
          <span>Pemasukan</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="pengeluaran.php">
          <i class="fas fa-fw fa-upload"></i>
          <span>Pengeluaran</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap2" aria-expanded="true" aria-controls="collapseBootstrap">
          <i class="far fa-fw fa-list-alt"></i>
          <span>Laporan</span>
        </a>
        <div id="collapseBootstrap2" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Laporan</h6>
            <a class="collapse-item" href="laporan_pemasukan.php">Pemasukan</a>
            <a class="collapse-item" href="laporan_pengeluaran.php">Pengeluaran</a>
          </div>
        </div>
      </li>

      <hr class="sidebar-divider">
      <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#myModal<?= $id; ?>">
          <i class="fas fa-fw fa-cogs"></i>
          <span>Setting</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../auth.php?logout" onclick="return confirm('Apakah anda yakin ingin keluar dari sistem ?')">
          <i class="fas fa-fw fa-sign-out-alt"></i>
          <span>Logout</span>
        </a>
      </li>

    </ul>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
          <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
          <ul class="navbar-nav ml-auto">

            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="img-profile rounded-circle" src="../assets/img/boy.png" style="max-width: 60px">
                <span class="ml-2 d-none d-lg-inline text-white small"><?= $use; ?></span>
              </a>
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="" data-toggle="modal" data-target="#myModal<?= $id; ?>">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="../auth.php?logout" onclick="return confirm('Apakah anda yakin ingin keluar dari sistem ?')">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </nav>
        <!-- Topbar -->


        <!-- Modal Setting-->
        <div class="modal fade" id="myModal<?= $id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Setting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="query.php" method="POST">

                  <?php
                  $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM user WHERE id='$id'"));
                  ?>

                  <input type="hidden" name="id_user" value="<?= $row['id']; ?>">

                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Nama User</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm" placeholder="Input Nama User" name="nama" required value="<?= $row['nama']; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Username</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm" placeholder="Input Username" name="username" required value="<?= $row['username']; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Password</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm" placeholder="Input Password" name="password" required value="<?= $row['password']; ?>">
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label">Level User</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control form-control-sm" name="level" readonly value="<?= $row['level']; ?>">
                    </div>
                  </div>
                  <hr>
                  <div class="form-group row">
                    <label class="col-sm-3 col-form-label"></label>
                    <div class="col-sm-9">
                      <button type="submit" name="setting" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                      <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- End Modal Setting -->