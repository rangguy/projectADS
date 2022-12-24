<?php
    session_start();
    include 'koneksi.php';
    $username = $_POST['username'];
    $password = md5($_POST['password']);

    $_SESSION['user'] = $_POST['username'];
    $query1 = mysqli_query($conn, "SELECT * from admin where username = '$username' AND password = '$password'");
    $query2 = mysqli_query($conn, "SELECT * from pelanggan where username = '$username' AND password = '$password'");
    $query3 = mysqli_query($conn, "SELECT * from owner where username = '$username' AND password = '$password'");
    $query4 = mysqli_query($conn, "SELECT * from pegawai where username = '$username' AND password = '$password'");
    $row1 = mysqli_fetch_array($query1);
    $row2 = mysqli_fetch_array($query2);
    $row3 = mysqli_fetch_array($query3);
    $row4 = mysqli_fetch_array($query4);
    if($row1['username']==$username && $row1['password']==$password){     
        $_SESSION['id'] = $row1['id'];
        $_SESSION['status'] = $row1['status'];
        $_SESSION['nama'] = $row1['nama'];
        ?>
        <script>
            var user = "<?php echo $_SESSION['user'];?>"
            alert("Selamat Datang, " + user);
            document.location = "index.php";
            </script>
        <?php
    }else if($row2['username']==$username && $row2['password']==$password){
        $_SESSION['id'] = $row2['id'];
        $_SESSION['status'] = $row2['status'];
        $_SESSION['nama'] = $row2['nama'];
        ?>
        <script>
            var user = "<?php echo $_SESSION['user'];?>"
            alert("Selamat Datang, " + user);
            document.location = "index.php";
        </script>
        <?php
    }else if($row3['username']==$username && $row3['password']==$password){
        $_SESSION['id'] = $row3['id'];
        $_SESSION['status'] = $row3['status'];
        $_SESSION['nama'] = $row3['nama'];
        ?>
        <script>
            var user = "<?php echo $_SESSION['user'];?>"
            alert("Selamat Datang, " + user);
            document.location = "index.php";
        </script>
        <?php
    } else if($row4['username']==$username && $row4['password']==$password){
        $_SESSION['id'] = $row4['id'];
        $_SESSION['status'] = $row4['status'];
        $_SESSION['nama'] = $row4['nama'];
        ?>
        <script>
            var user = "<?php echo $_SESSION['user'];?>"
            alert("Selamat Datang, " + user);
            document.location = "index.php";
        </script>
        <?php
    } else {
        ?>
        <script>
        alert("Username atau Password Salah!");
        </script>
        <?php
        header("Location:login/login.php");
    }   
?>
