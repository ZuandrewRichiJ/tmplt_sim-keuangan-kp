<?php
include_once 'header.php';
error_reporting(0);

date_default_timezone_set("Asia/Jakarta");
$today  = date("dmY");
$query1 = "SELECT max(nota) as maxNota FROM pemasukan WHERE nota LIKE '$today%'";
$hasil  = mysqli_query($con, $query1);
$data   = mysqli_fetch_array($hasil);
$idMax  = $data['maxNota'];
$NoUrut = (int) substr($idMax, 8, 3);
$NoUrut++; //nomor urut +1
$Nota = $today . sprintf('%03s', $NoUrut);
?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">

  <!-- Row -->
  <div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-download"></i> Pemasukan</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pemasukan</li>
          </ol>
        </div>
        <div class="table-responsive p-3">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" id="#myBtn"><i class="fas fa-plus"></i> Tambah Pemasukan</button>
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
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>

              <?php
              $sql = mysqli_query($con, "SELECT * FROM pemasukan,barang,pelanggan WHERE
                      pemasukan.id_barang=barang.id_barang AND
                      pemasukan.id_pelanggan=pelanggan.id_pelanggan");
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
                  <td>
                    <a href="query.php?pemasukan_del=<?= $data['nota']; ?>" type="button" class="btn btn-danger text-xs btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini : \n<?= $data['nota']; ?>')"><i class="fa fa-trash"></i> Hapus</a>
                  </td>
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
      </div>
    </div>
  </div>
  <!--Row-->

  <!-- Modal Pemasukan-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Input Pemasukan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="query.php" method="POST">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nota</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" name="nota" readonly value="<?= $Nota; ?>">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Tanggal</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" readonly value="<?= date('l, d F Y'); ?>">
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Pelanggan</label>
              <div class="col-sm-9">
                <select name="id_pelanggan" class="form-control form-control-sm" required>
                  <option selected disabled value="">--Pilih Pelanggan--</option>
                  <?php
                  $sql = mysqli_query($con, "SELECT * FROM pelanggan ORDER BY nama_pelanggan");
                  while ($data = mysqli_fetch_array($sql)) {
                  ?>
                    <option value="<?= $data['id_pelanggan']; ?>"><?= $data['nama_pelanggan']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Barang</label>
              <div class="col-sm-9">
                <select name="id_barang" class="form-control form-control-sm" required>
                  <option selected disabled value="">--Pilih Barang--</option>
                  <?php
                  $sql = mysqli_query($con, "SELECT * FROM barang WHERE stok>0 ORDER BY nama_barang");
                  while ($data = mysqli_fetch_array($sql)) {
                  ?>
                    <option value="<?= $data['id_barang']; ?>"><?= $data['nama_barang']; ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Jumlah</label>
              <div class="col-sm-9">
                <input type="number" min="1" class="form-control form-control-sm" name="jumlah" required>
              </div>
            </div>

            <hr>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label"></label>
              <div class="col-sm-9">
                <button type="submit" name="pemasukan_add" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                <button type="reset" class="btn btn-success btn-sm"><i class="fa fa-sync-alt"></i> Reset</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Pemasukan -->

</div>
<!---Container Fluid-->

<?php include_once 'footer.php'; ?>