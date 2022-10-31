<?php
include_once 'header.php';
error_reporting(0);

date_default_timezone_set("Asia/Jakarta");
$today  = date("Ymd");
$query1 = "SELECT max(nota_keluar) as maxNota FROM pengeluaran WHERE nota_keluar LIKE '$today%'";
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
          <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-upload"></i> Pengeluaran</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pengeluaran</li>
          </ol>
        </div>
        <div class="table-responsive p-3">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" id="#myBtn"><i class="fas fa-plus"></i> Tambah Pengeluaran</button>
          <p>
          <table class="table align-items-center table-flush text-xs" id="dataTable">

            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Nota</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Total Pengeluaran</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>

              <?php
              $sql = mysqli_query($con, "SELECT * FROM pengeluaran ORDER BY nota_keluar DESC");
              $no  = 1;
              while ($data = mysqli_fetch_array($sql)) {
              ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $data['nota_keluar']; ?></td>
                  <td><?= $data['tanggal']; ?></td>
                  <td><?= $data['keterangan']; ?></td>
                  <td><?= 'Rp. ' . number_format($data['nominal'], 0, ',', '.'); ?></td>
                  <td>
                    <button type="button" class="btn btn-primary text-xs btn-sm" data-toggle="modal" data-target="#myModal<?= $data['nota_keluar']; ?>"><i class="fa fa-edit"></i> Update</button>
                    <a href="query.php?pengeluaran_del=<?= $data['nota_keluar']; ?>" type="button" class="btn btn-danger text-xs btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini : \n<?= $data['nota_keluar']; ?>')"><i class="fa fa-trash"></i> Hapus</a>
                  </td>
                </tr>

                <!-- Modal Update User-->
                <div class="modal fade" id="myModal<?= $data['nota_keluar']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Update Pengeluaran</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="query.php" method="POST">

                          <?php
                          $nota  = $data['nota_keluar'];
                          $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pengeluaran WHERE nota_keluar='$nota'"));
                          ?>

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nota</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm" name="nota" readonly value="<?= $row['nota_keluar']; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Tanggal</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm" readonly value="<?= date('d F Y', strtotime($row['tanggal'])); ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Pengeluaran</label>
                            <div class="col-sm-9">
                              <input type="number" min="0" class="form-control form-control-sm" placeholder="Input Total Pengeluaran" name="nominal" required value="<?= $row['nominal']; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Keterangan</label>
                            <div class="col-sm-9">
                              <textarea class="form-control form-control-sm" rows="3" name="keterangan" placeholder="Input Keterangan"><?= $row['keterangan']; ?></textarea>
                            </div>
                          </div>
                          <hr>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                              <button type="submit" name="pengeluaran_update" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal Update User -->
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
      </div>
    </div>
  </div>
  <!--Row-->

  <!-- Modal Tambah Pengeluaran-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Input Pengeluaran</h5>
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
              <label class="col-sm-3 col-form-label">Pengeluaran</label>
              <div class="col-sm-9">
                <input type="number" min="1" class="form-control form-control-sm" placeholder="Input Total Pengeluaran" name="nominal" required>
              </div>
            </div>

            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Keterangan</label>
              <div class="col-sm-9">
                <textarea class="form-control form-control-sm" rows="3" name="keterangan" required placeholder="Input Keterangan"></textarea>
              </div>
            </div>

            <hr>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label"></label>
              <div class="col-sm-9">
                <button type="submit" name="pengeluaran_add" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                <button type="reset" class="btn btn-success btn-sm"><i class="fa fa-sync-alt"></i> Reset</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Pengeluaran -->

</div>
<!---Container Fluid-->

<?php include_once 'footer.php'; ?>