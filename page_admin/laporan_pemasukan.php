<?php
include_once 'header.php';
error_reporting(0);
?>
<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">

  <!-- Row -->
  <div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-download"></i> Laporan Pemasukan</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan Pemasukan</li>
          </ol>
        </div>

        <div class="card-body">
          <form action="" method="POST">
            <div class="form-group row" id="simple-date4">
              <label class="col-sm-2 col-form-label text-sm">Pilih Periode Tanggal</label>
              <div class="col-sm-4">
                <div class="input-daterange input-group">
                  <input type="text" class="input-sm form-control form-control-sm" name="start" />
                  <div class="input-group-prepend">
                    <span class="input-group-text text-xs">s/d</span>
                  </div>
                  <input type="text" class="input-sm form-control form-control-sm" name="end" />
                </div>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-2 col-form-label"></label>
              <div class="col-sm-4">
                <button type="submit" name="tampil" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Tampilkan</button>
              </div>
            </div>
          </form>
          <hr>

          <!-- TABEL -->
          <?php
          if (isset($_POST['tampil'])) {
            $start = $_POST['start'];
            $end   = $_POST['end'];
          ?>

            <div class="table-responsive p-3">
              <a href="laporan_pemasukan_print.php?start=<?= $start; ?>&end=<?= $end; ?>" target="_blank" type="button" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Cetak Laporan</a>
              <p>
              <table class="table align-items-center table-flush text-xs" id="dataTable">

                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Nota</th>
                    <th>Tanggal</th>
                    <th>Pelanggan</th>
                    <th>Barang</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                  </tr>
                </thead>

                <tbody>

                  <?php
                  $sql = mysqli_query($con, "SELECT * FROM pemasukan,barang,pelanggan WHERE
                      pemasukan.id_barang=barang.id_barang AND
                      pemasukan.id_pelanggan=pelanggan.id_pelanggan AND
                      tanggal BETWEEN '$start' AND '$end'");
                  $no  = 1;
                  while ($data = mysqli_fetch_array($sql)) {
                    $subtotal = $data['jumlah'] * $data['harga'];
                  ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $data['nota']; ?></td>
                      <td><?= $data['tanggal']; ?></td>
                      <td><?= $data['nama_pelanggan']; ?></td>
                      <td><?= $data['nama_barang']; ?></td>
                      <td><?= $data['jumlah']; ?></td>
                      <td><?= 'Rp. ' . number_format($subtotal, 0, ',', '.'); ?></td>
                    </tr>

                  <?php
                    $total = $total + $subtotal;
                  }
                  ?>
                </tbody>
                <tfoot>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th>TOTAL</th>
                  <th><?= 'Rp. ' . number_format($total, 0, ',', '.'); ?></th>
                </tfoot>
              </table>
            </div>
          <?php
          }
          ?>

        </div>

      </div>
    </div>
  </div>
  <!--Row-->

</div>
<!---Container Fluid-->

<?php include_once 'footer.php'; ?>