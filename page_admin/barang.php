<?php include_once 'header.php'; ?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">

  <!-- Row -->
  <div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-shopping-cart"></i> Data Barang</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Data Barang</li>
          </ol>
        </div>
        <div class="table-responsive p-3">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" id="#myBtn"><i class="fas fa-plus"></i> Tambah Barang</button>
          <p>
          <table class="table align-items-center table-flush" id="dataTable">

            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Kode Barang</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
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
                  <td>
                    <button type="button" class="btn btn-success text-xs btn-sm" data-toggle="modal" data-target="#myModal2<?= $data['id_barang']; ?>"><i class="fa fa-plus"></i> Tambah Stok</button>
                    <button type="button" class="btn btn-primary text-xs btn-sm" data-toggle="modal" data-target="#myModal<?= $data['id_barang']; ?>"><i class="fa fa-edit"></i> Update</button>
                  </td>
                </tr>

                <!-- Modal Update Barang-->
                <div class="modal fade" id="myModal<?= $data['id_barang']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Update Barang</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="query.php" method="POST">

                          <?php
                          $idb  = $data['id_barang'];
                          $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM barang WHERE id_barang='$idb'"));
                          ?>

                          <input type="hidden" name="id_barang" value="<?= $row['id_barang']; ?>">

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kode Barang</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm" placeholder="Input Kode Barang" name="kode_barang" required value="<?= $row['kode_barang']; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Barang</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm" placeholder="Input Nama Barang" name="nama_barang" required value="<?= $row['nama_barang']; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-9">
                              <input type="number" min="0" class="form-control form-control-sm" placeholder="Input Harga" name="harga" required value="<?= $row['harga']; ?>">
                            </div>
                          </div>
                          <hr>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                              <button type="submit" name="barang_update" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal Update Barang -->

                <!-- Modal Update Stok-->
                <div class="modal fade" id="myModal2<?= $data['id_barang']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Update Stok</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="query.php" method="POST">

                          <?php
                          $idb  = $data['id_barang'];
                          $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM barang WHERE id_barang='$idb'"));
                          ?>

                          <input type="hidden" name="id_barang" value="<?= $row['id_barang']; ?>">

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Kode Barang</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm" readonly value="<?= $row['kode_barang']; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama Barang</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm" readonly value="<?= $row['nama_barang']; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Harga</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm" readonly required value="<?= 'Rp. ' . number_format($row['harga'], 0, ',', '.'); ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Stok Lama</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm" readonly value="<?= $row['stok']; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Stok Baru</label>
                            <div class="col-sm-9">
                              <input type="number" min="0" class="form-control form-control-sm" placeholder="Input Stok Baru" name="stok" required>
                            </div>
                          </div>

                          <hr>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                              <button type="submit" name="stok_update" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal Update Stok -->

              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!--Row-->

  <!-- Modal Input Barang-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Input Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="query.php" method="POST">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Kode Barang</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" placeholder="Input Kode Barang" name="kode_barang" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nama Barang</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" placeholder="Input Nama Barang" name="nama_barang" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Harga</label>
              <div class="col-sm-9">
                <input type="number" min="0" class="form-control form-control-sm" placeholder="Input Harga" name="harga" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Stok</label>
              <div class="col-sm-9">
                <input type="number" min="0" class="form-control form-control-sm" placeholder="Input Stok" name="stok" required>
              </div>
            </div>
            <hr>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label"></label>
              <div class="col-sm-9">
                <button type="submit" name="barang_add" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                <button type="reset" class="btn btn-success btn-sm"><i class="fa fa-sync-alt"></i> Reset</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Input Barang -->

</div>
<!---Container Fluid-->

<?php include_once 'footer.php'; ?>