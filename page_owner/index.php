<?php
include_once 'header.php';
error_reporting(0);

$stok        = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(stok) AS stok FROM barang"));
$pelanggan   = mysqli_fetch_assoc(mysqli_query($con, "SELECT COUNT(no_hp) AS pelanggan FROM pelanggan"));
$pengeluaran = mysqli_fetch_assoc(mysqli_query($con, "SELECT SUM(nominal) AS pengeluaran FROM pengeluaran"));

$sql1 = mysqli_query($con, "SELECT * FROM pemasukan,barang,pelanggan WHERE
          pemasukan.id_barang=barang.id_barang");
while ($data = mysqli_fetch_array($sql1)) {
  $subtotal = $data['jumlah'] * $data['harga'];
  $pemasukan = $pemasukan + $subtotal;
}
?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.php">Home</a></li>
      <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
    </ol>
  </div>

  <div class="row mb-3">
    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Stok Barang</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $stok['stok']; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-shopping-cart fa-2x text-primary"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Earnings (Annual) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Pelanggan</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $pelanggan['pelanggan']; ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-users fa-2x text-success"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- New User Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Pemasukan</div>
              <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= 'Rp. ' . number_format($pemasukan, 0, ',', '.'); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-download fa-2x text-info"></i>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card h-100">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-uppercase mb-1">Pengeluaran</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800"><?= 'Rp. ' . number_format($pengeluaran['pengeluaran'], 0, ',', '.'); ?></div>
            </div>
            <div class="col-auto">
              <i class="fas fa-upload fa-2x text-warning"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
  <!--Row-->

  <!-- Row -->
  <div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
      <div class="card mb-4">

        <div class="table-responsive p-3 text-xs">
          <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-shopping-cart"></i> Data Stok Barang</h6>
          <p>
          <table class="table align-items-center table-flush text-xs" id="dataTable">

            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
              </tr>
            </thead>

            <tbody>

              <?php
              $sql = mysqli_query($con, "SELECT * FROM barang ORDER BY nama_barang");
              $no  = 1;
              while ($data = mysqli_fetch_array($sql)) {
              ?>

                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $data['kode_barang']; ?></td>
                  <td><?= $data['nama_barang']; ?></td>
                  <td><?= 'Rp. ' . number_format($data['harga'], 0, ',', '.'); ?></td>
                  <td><?= $data['stok']; ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!--Row-->

</div>
<!---Container Fluid-->

<?php include_once 'footer.php'; ?>