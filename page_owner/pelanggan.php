<?php include_once 'header.php'; ?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">

  <!-- Row -->
  <div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-users"></i> Pelanggan</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Pelanggan</li>
          </ol>
        </div>
        <div class="table-responsive p-3">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" id="#myBtn"><i class="fas fa-plus"></i> Tambah Pelanggan</button>
          <p>
          <table class="table align-items-center table-flush" id="dataTable">

            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Nama Pelangan</th>
                <th>No HP</th>
                <th>Alamat</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>

              <?php
              $sql = mysqli_query($con, "SELECT * FROM pelanggan ORDER BY nama_pelanggan");
              $no  = 1;
              while ($data = mysqli_fetch_array($sql)) {
              ?>

                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $data['nama_pelanggan']; ?></td>
                  <td><?= $data['no_hp']; ?></td>
                  <td class="text-xs"><?= $data['alamat']; ?></td>
                  <td>
                    <button type="button" class="btn btn-primary text-xs btn-sm" data-toggle="modal" data-target="#myModal<?= $data['id_pelanggan']; ?>"><i class="fa fa-edit"></i> Update</button>
                    <a href="query.php?pelanggan_del=<?= $data['id_pelanggan']; ?>" type="button" class="btn btn-danger text-xs btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini : \n<?= $data['nama_pelanggan']; ?>')"><i class="fa fa-trash"></i> Hapus</a>
                  </td>
                </tr>

                <!-- Modal Update Pelanggan-->
                <div class="modal fade" id="myModal<?= $data['id_pelanggan']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Update Pelanggan</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="query.php" method="POST">

                          <?php
                          $idp = $data['id_pelanggan'];
                          $row = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM pelanggan WHERE id_pelanggan='$idp'"));
                          ?>

                          <input type="hidden" name="id_pelanggan" value="<?= $row['id_pelanggan']; ?>">

                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Nama</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm" placeholder="Input Nama Pelanggan" name="nama_pelanggan" required value="<?= $row['nama_pelanggan']; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">No HP</label>
                            <div class="col-sm-9">
                              <input type="text" class="form-control form-control-sm" placeholder="Input No HP" name="no_hp" required value="<?= $row['no_hp']; ?>">
                            </div>
                          </div>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Alamat</label>
                            <div class="col-sm-9">
                              <textarea class="form-control form-control-sm" name="alamat" rows="3" placeholder="Input Alamat"><?= $row['alamat']; ?></textarea>
                            </div>
                          </div>
                          <hr>
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-9">
                              <button type="submit" name="pelanggan_update" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal Update Pelanggan -->

              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!--Row-->

  <!-- Modal Input Pelanggan-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Input Pelanggan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="query.php" method="POST">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nama</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" placeholder="Input Nama Pelanggan" name="nama_pelanggan" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">No HP</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" placeholder="Input No HP" name="no_hp" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Alamat</label>
              <div class="col-sm-9">
                <textarea class="form-control form-control-sm" name="alamat" rows="3" placeholder="Input Alamat"></textarea>
              </div>
            </div>
            <hr>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label"></label>
              <div class="col-sm-9">
                <button type="submit" name="pelanggan_add" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                <button type="reset" class="btn btn-success btn-sm"><i class="fa fa-sync-alt"></i> Reset</button>
                <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End Modal Input User -->

</div>
<!---Container Fluid-->

<?php include_once 'footer.php'; ?>