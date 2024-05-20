<?php
session_start();
include 'koneksi.php';

$tabel = $_GET['user'];
$del = $_GET['del'];

if ($del != ""){
    if($tabel == "pegawai"){
        $sqlDel = "DELETE FROM pegawai WHERE id = $del";
        $queryDel = mysqli_query($conn, $sqlDel);
        if($queryDel){
            ?>
                <script>alert("Berhasil menghapus data pegawai!");document.location = "index.php?page=lapUser&&user=pegawai";</script>
            <?php
        }
    }else if ($tabel == "admin"){
        $sqlDel = "DELETE FROM admin WHERE id = $del";
        $queryDel = mysqli_query($conn, $sqlDel);
        if($queryDel){
            ?>
                <script>alert("Berhasil menghapus data admin!");document.location = "index.php?page=lapUser&&user=admin";</script>
            <?php
        }
    }else if ($tabel == "pelanggan"){
        $sqlDel = "DELETE FROM pelanggan WHERE id = $del";
        $queryDel = mysqli_query($conn, $sqlDel);
        if($queryDel){
            ?>
                <script>alert("Berhasil menghapus data pelanggan!");document.location = "index.php?page=lapUser&&user=pelanggan";</script>
            <?php
        }
    }
}

$nama = $_POST['nama'];
$user = $_POST['user'];
$pass = md5($_POST['password']);

if (isset($_POST['tambahData'])){
    if ($tabel == "admin"){
        $sqlAdd = "INSERT into admin(id, nama, status, username, password) values (0, '$nama', 'admin', '$user', '$pass')";
        $queryAdd = mysqli_query($conn, $sqlAdd);
        if ($queryAdd){
            ?> 
                <script>alert("Berhasil menambah data admin");document.location = "index.php?page=lapUser&&user=admin";</script>
            <?php
        }
    }else if($tabel == "pegawai"){
        $sqlAdd = "INSERT into pegawai(id, nama, status, username, password) values (0, '$nama', 'pegawai', '$user', '$pass')";
        $queryAdd = mysqli_query($conn, $sqlAdd);
        if ($queryAdd){
            ?> 
                <script>alert("Berhasil menambah data pegawai");document.location = "index.php?page=lapUser&&user=pegawai";</script>
            <?php
        }
    }
}

?>
<script>
    function cek(){
        alert("Tidak dapat menghapus User!");
    }
</script>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">

<body>
    
    <div class="container">
        <div class="heading_container heading_center mb-5">
            <h2>
                Data <?php echo $tabel?>
            </h2>
        </div>
        <table class='table table-bordered table-striped table-hover table-responsive-sm mb-5'>
            <center>
                <a href="index.php?page=profil" class="btn btn-primary mb-5">Kembali</a>
                <?php if($_SESSION['status'] == 'admin' && $tabel == "pegawai" | $tabel == "admin") { ?>
                    <button type="button" data-toggle="modal" data-target="#tambahData" class="btn btn-success mb-5">Tambah</button>
                <?php } ?>
            </center>
            <thead class='thead-dark'>
                <th>No</th>
                <th>ID</th>
                <th>Nama</th>
                <th>Username</th>
                <?php if($tabel != "pelanggan") { ?>
                <th>Aksi</th><?php } ?>
            </thead>
            <?php
            $no = 1;
            $sql = "SELECT * FROM ". $tabel;
            $query = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_array($query)) {
                echo "<tbody>
                <tr>
                    <td>$no</td>
                    <td>$row[id]</td>
                    <td>$row[nama]</td>
                    <td>$row[username]</td>";
                    if ($tabel != "pelanggan") {
                        if ($tabel == 'admin'){
                            if ($row['id'] == $_SESSION['id']){
                                echo "<td><a href='#' class='btn btn-danger' onclick='return cek();'><i class='bi bi-trash'></i></a></td>
                                ";
                            }else{
                                echo "<td><a href='index.php?page=lapUser&&user=$tabel&&del=$row[id]'class='btn btn-danger'><i class='bi bi-trash'></i></a></td>
                                ";
                            }
                        }else {
                            echo "<td><a href='index.php?page=lapUser&&user=$tabel&&del=$row[id]'class='btn btn-danger'><i class='bi bi-trash'></i></a></td>
                            ";
                        }
                    }
                echo "</tr>
            </tbody>  
            ";
                $no++;
            }

            ?>
        </table><br><br><br><br><br><br><br>

        <!-- Modal tambah data-->
        <div class="modal fade" id="tambahData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Data <?php echo $tabel?></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form method="POST" action="<?php $_SERVER['PHP_SELF'] ?>" name="formTambah">
                            <div class='form-group'>
                                <label for='exampleFormControlInput1'>Nama</label>
                                <input type='text' name='nama' id='nama'>
                            </div>
                            <div class='form-group'>
                                <label for='exampleFormControlInput1'>Username</label>
                                <input type='text' name='user' id='user'>
                            </div>
                            <div class='form-group'>
                                <label for='exampleFormControlInput1'>Password</label>
                                <input type='password' name='password' id='password'>
                            </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <input type="submit" name="tambahData" class="btn btn-primary" value="Simpan"></input>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>

</html>