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
          <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-upload"></i> Laporan Pengeluaran</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Laporan Pengeluaran</li>
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
              <a href="laporan_pengeluaran_print.php?start=<?= $start; ?>&end=<?= $end; ?>" target="_blank" type="button" class="btn btn-success btn-sm"><i class="fas fa-print"></i> Cetak Laporan</a>
              <p>
              <table class="table align-items-center table-flush text-xs" id="dataTable">

                <thead class="thead-light">
                  <tr>
                    <th>#</th>
                    <th>Nota</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Total Pengeluaran</th>
                  </tr>
                </thead>

                <tbody>

                  <?php
                  $sql = mysqli_query($con, "SELECT * FROM pengeluaran WHERE
                      tanggal BETWEEN '$start' AND '$end' ORDER BY tanggal DESC");
                  $no  = 1;
                  while ($data = mysqli_fetch_array($sql)) {
                  ?>
                    <tr>
                      <td><?= $no++; ?></td>
                      <td><?= $data['nota_keluar']; ?></td>
                      <td><?= date('d-m-Y', strtotime($data['tanggal'])); ?></td>
                      <td><?= $data['keterangan']; ?></td>
                      <td><?= 'Rp. ' . number_format($data['nominal'], 0, ',', '.'); ?></td>
                    </tr>

                  <?php
                    $total = $total + $data['nominal'];
                  }
                  ?>
                </tbody>
                <tfoot>
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