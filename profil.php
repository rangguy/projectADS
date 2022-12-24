<?php
session_start();
include 'koneksi.php';
$id = $_SESSION['id'];

if (isset($_POST['gantiPass'])) {
    $pass1 = md5($_POST['password2']);
    $pass2 = md5($_POST['password3']);
    if ($pass1 == $pass2) {
        if ($_SESSION['status'] == 'admin') {
            $sql = "UPDATE admin set password = '$pass1' where id = '$id'";
            $query = mysqli_query($conn, $sql);
        } else if ($_SESSION['status'] == 'owner') {
            $sql = "UPDATE owner set password = '$pass1' where id = '$id'";
            $query = mysqli_query($conn, $sql);
        } else if ($_SESSION['status'] == 'pelanggan') {
            $sql = "UPDATE pelanggan set password = '$pass1' where id = '$id'";
            $query = mysqli_query($conn, $sql);
        } else if ($_SESSION['status'] == 'pegawai') {
            $sql = "UPDATE pegawai set password = '$pass1' where id = '$id'";
            $query = mysqli_query($conn, $sql);
        }

        if ($query) {
?>
            <script>
                alert("Berhasil mengganti password!");
                document.location = "index.php?page=profil";
            </script>
        <?php
        }
    } else {
        ?><script>
            alert("Password tidak sesuai!");
        </script>

    <?php
    }
}

if (isset($_POST['gantiUser'])) {
    $user = $_POST['username'];
    if ($_SESSION['status'] == 'admin') {
        $sql = "UPDATE admin set username = '$user' where id = '$id'";
        $query = mysqli_query($conn, $sql);
    } else if ($_SESSION['status'] == 'owner') {
        $sql = "UPDATE owner set username = '$user' where id = '$id'";
        $query = mysqli_query($conn, $sql);
    } else if ($_SESSION['status'] == 'pelanggan') {
        $sql = "UPDATE pelanggan set username = '$user' where id = '$id'";
        $query = mysqli_query($conn, $sql);
    } else if ($_SESSION['status'] == 'pegawai') {
        $sql = "UPDATE pegawai set username = '$user' where id = '$id'";
        $query = mysqli_query($conn, $sql);
    }

    if ($query) {
        $_SESSION['user'] = $user;
    ?>
        <script>
            alert("Berhasil mengganti Username!");
            document.location = "index.php?page=profil";
        </script>
<?php
    }
}

if (isset($_POST['gantiNama'])) {
    $nama = $_POST['nama'];
    if ($_SESSION['status'] == 'admin') {
        $sql = "UPDATE admin set nama = '$nama' where id = '$id'";
        $query = mysqli_query($conn, $sql);
    } else if ($_SESSION['status'] == 'owner') {
        $sql = "UPDATE owner set nama = '$nama' where id = '$id'";
        $query = mysqli_query($conn, $sql);
    } else if ($_SESSION['status'] == 'pelanggan') {
        $sql = "UPDATE pelanggan set nama = '$nama' where id = '$id'";
        $query = mysqli_query($conn, $sql);
    } else if ($_SESSION['status'] == 'pegawai') {
        $sql = "UPDATE pegawai set nama = '$nama' where id = '$id'";
        $query = mysqli_query($conn, $sql);
    }

    if ($query) {
    ?>
        <script>
            alert("Berhasil mengganti Nama!");
            document.location = "index.php?page=profil";
        </script>
<?php
    }
}

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<?php
if ($_SESSION['status'] == 'admin') {
    $sql = "SELECT * FROM admin where id = '$id'";
    $query = mysqli_query($conn, $sql);
} else if ($_SESSION['status'] == 'owner') {
    $sql = "SELECT * FROM owner where id = '$id'";
    $query = mysqli_query($conn, $sql);
} else if ($_SESSION['status'] == 'pelanggan') {
    $sql = "SELECT * FROM pelanggan where id = '$id'";
    $query = mysqli_query($conn, $sql);
} else if ($_SESSION['status'] == 'pegawai') {
    $sql = "SELECT * FROM pegawai where id = '$id'";
    $query = mysqli_query($conn, $sql);
}

$row = mysqli_fetch_array($query);

?>

<body>
    <div class="container mt-5 mb-5">
        <div class="row mt-5">
            <div class="col">
                <h5>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16">
                        <path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
                    </svg> <?php echo "$_SESSION[user]" ?>
                </h5>
            </div>
            <?php if($_SESSION['status'] == 'pelanggan')  { ?>
            <div class="d-inline">
                <a href="index.php?page=riwayatTransaksi" class="btn btn-primary mb-1">Riwayat Transaksi</a>
            </div> <?php } ?>
        </div>
        <div class="border border-bottom-0 border-secondary row ">
            <div class="col">
                <p>Profil Akun</p>
            </div>
        </div>
        <div class="border border-bottom-0 border-top-0  border-secondary row ">
            <div class="col">
                <p>Nama</p>
            </div>
            <div class="col">
                <?php echo $row['nama'] ?><b><a type="button" data-toggle="modal" data-target="#gantiNama" style="color: red;">&nbsp;&nbsp; Ubah</a></b>
            </div>
        </div>
        <div class="border border-bottom-0 border-top-0 border-secondary row ">
            <div class="col">
                <p>Username</p>
            </div>
            <div class="col">
                <?php echo $row['username'] ?><b><a type="button" data-toggle="modal" data-target="#gantiUser" style="color: red;">&nbsp;&nbsp; Ubah Username</a></b>
            </div>
        </div>
        <div class="border border-bottom-0 border-top-0 border-secondary row ">
            <div class="col">
                <p>Status</p>
            </div>
            <div class="col">
                <?php echo $row['status'] ?>
            </div>
        </div>
        <div class="border border-top-0 border-secondary row ">
            <div class="col">
                <p>Password</p>
            </div>
            <div class="col">
                <p>******** <b><a type="button" data-toggle="modal" data-target="#gantiPassword" style="color: red;">&nbsp;&nbsp; Ubah Password</a></b></p>
            </div>
        </div>
        <div class="row mt-2">
        <?php 
            if($_SESSION['status'] == 'admin'){
                echo "<a type='submit' class='btn btn-primary d-inline m-2' href='index.php?page=lapUser&&user=pegawai'>Data Pegawai </a>
                <a class='btn btn-primary d-inline m-2' href='index.php?page=lapUser&&user=pelanggan'>Data Pelanggan </a>
                <a class='btn btn-primary d-inline m-2' href='index.php?page=lapUser&&user=admin'>Data Admin </a>
                ";
            }else if($_SESSION['status'] == 'owner'){
                echo "<a class='btn btn-primary d-inline m-2' href='index.php?page=lapUser&&user=pegawai'>Data Pegawai </a>
                <a class='btn btn-primary d-inline m-2' href='index.php?page=lapUser&&user=admin'>Data Admin </a>
                ";
            }
        ?>

        </div>
        <!-- Modal Password-->
        <div class="modal fade" id="gantiPassword" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ganti Password</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" name="form1">
                            <div class='form-group'>
                                <label for='exampleFormControlInput1'>Password Baru</label>
                                <input type='password' name='password2' id='password2'>
                            </div>
                            <div class='form-group'>
                                <label for='exampleFormControlInput1'>Re Password Baru</label>
                                <input type='password' name='password3' id='password3'>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" name="gantiPass" class="btn btn-primary" value="Simpan"></input>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal User-->
        <div class="modal fade" id="gantiUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ganti Username</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" name="form1">
                            <div class='form-group'>
                                <label for='exampleFormControlInput1'>Username Baru</label>
                                <input type='text' name='username' id='username'>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" name="gantiUser" class="btn btn-primary" value="Simpan"></input>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Nama-->
        <div class="modal fade" id="gantiNama" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Ganti Nama</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" name="form1">
                            <div class='form-group'>
                                <label for='exampleFormControlInput1'>Nama Anda</label>
                                <input type='text' name='nama' id='nama'>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" name="gantiNama" class="btn btn-primary" value="Simpan"></input>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br><br><br><br><br><br><br><br><br><br>
</body>

</html>