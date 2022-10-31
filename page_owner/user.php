<?php include_once 'header.php'; ?>

<!-- Container Fluid-->
<div class="container-fluid" id="container-wrapper">

  <!-- Row -->
  <div class="row">
    <!-- Datatables -->
    <div class="col-lg-12">
      <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
          <h4 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-secret"></i> Manajemen User</h4>
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manajemen User</li>
          </ol>
        </div>
        <div class="table-responsive p-3">
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#exampleModal" id="#myBtn"><i class="fas fa-plus"></i> Tambah User</button>
          <p>
          <table class="table align-items-center table-flush" id="dataTable">

            <thead class="thead-light">
              <tr>
                <th>#</th>
                <th>Nama User</th>
                <th>Username</th>
                <th>password</th>
                <th>Level</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>

              <?php
              $sql = mysqli_query($con, "SELECT * FROM user ORDER BY level");
              $no  = 1;
              while ($data = mysqli_fetch_array($sql)) {
                if ($data['level'] == "OWNER") {
                  $bg = "danger";
                } else {
                  $bg = "warning";
                }

              ?>
                <tr>
                  <td><?= $no++; ?></td>
                  <td><?= $data['nama']; ?></td>
                  <td><?= $data['username']; ?></td>
                  <td><?= $data['password']; ?></td>
                  <td><span class="badge badge-<?= $bg; ?>"><?= $data['level']; ?></span></td>
                  <td>
                    <button type="button" class="btn btn-primary text-xs btn-sm" data-toggle="modal" data-target="#myModal<?= $data['id']; ?>"><i class="fa fa-edit"></i> Update</button>
                    <a href="query.php?user_del=<?= $data['id']; ?>" type="button" class="btn btn-danger text-xs btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini : \n<?= $data['nama']; ?>')"><i class="fa fa-trash"></i> Hapus</a>
                  </td>
                </tr>

                <!-- Modal Update User-->
                <div class="modal fade" id="myModal<?= $data['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Form Update User</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form action="query.php" method="POST">

                          <?php
                          $id  = $data['id'];
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
                              <button type="submit" name="user_update" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
                              <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
                            </div>
                          </div>
                        </form>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- End Modal Update User -->

              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <!--Row-->

  <!-- Modal Input User-->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Form Input User</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="query.php" method="POST">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Nama User</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" placeholder="Input Nama User" name="nama" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Username</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" placeholder="Input Username" name="username" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Password</label>
              <div class="col-sm-9">
                <input type="password" class="form-control form-control-sm" placeholder="Input Password" name="password" required>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label">Level User</label>
              <div class="col-sm-9">
                <input type="text" class="form-control form-control-sm" value="ADMIN" readonly>
              </div>
            </div>
            <hr>
            <div class="form-group row">
              <label class="col-sm-3 col-form-label"></label>
              <div class="col-sm-9">
                <button type="submit" name="user_add" class="btn btn-primary btn-sm"><i class="fas fa-check"></i> Simpan</button>
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