<?php
include 'config.php';

######################################################################################
# Login Proccess
######################################################################################
if (isset($_POST['login'])) {
  session_start();

  $username = mysqli_escape_string($con, $_POST['username']);
  $password = mysqli_escape_string($con, $_POST['password']);

  $sql = mysqli_query($con, "SELECT * FROM user WHERE username='$username' AND password='$password'");
  $cek = mysqli_num_rows($sql);

  if ($cek > 0) {
    $data = mysqli_fetch_assoc($sql);
    $_SESSION['user']       = $data['id'];

    if ($data['level'] == "OWNER") {
      header("location:page_owner");
    } else {
      header("location:page_admin");
    }
  } else {
    echo "<script> alert('Username / Password salah!'); window.location='index.php';</script>";
  }
}

######################################################################################
# Logout Proccess
######################################################################################
if (isset($_GET['logout'])) {
  session_start();
  session_destroy();
  header("location:index.php");
}
