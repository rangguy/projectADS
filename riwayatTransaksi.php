<?php
session_start();
include 'koneksi.php';   
$idUser = $_SESSION['id'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<div class="heading_container heading_center mb-5">
        <h2>
            Riwayat Transaksi
        </h2>
    </div>
    <table class='table table-bordered table-striped table-hover table-responsive-sm'>
        <center>
            <a href="index.php?page=profil" class="btn btn-primary mb-3" align="center">Kembali</a>
        </center>
        <thead class='thead-dark'>
            <th>No</th>
            <th>Barang</th>
            <th>Total Barang</th>
            <th>Jam Pemesanan</th>
            <th>Total Harga</th>
        </thead>
        <?php
        $no = 1;
        $sqlTampil = "SELECT * FROM transaksi where id_pelanggan = '$idUser' and status = 'selesai'";
        $queryTampil = mysqli_query($conn, $sqlTampil);
        while ($row1 = mysqli_fetch_array($queryTampil)) {
            $idBarang = $row1['id_barang'];
            $sqlBarang = "select * from barang where id = '$idBarang'";
            $queryBarang = mysqli_query($conn, $sqlBarang);
            while ($row = $queryBarang->fetch_assoc()) {
                $namaBarang = $row['nama'];
                $harga = $row['harga'];
            }
            $subtotal = $harga * $row1['jumlah'];
            echo "
                    <tbody>
                        <tr>
                            <td>$no</td>
                            <td>$namaBarang</td>
                            <td>$row1[jumlah]</td>
                            <td>$row1[jam]</td>
                            <td>Rp. $subtotal</td>
                        </tr>
                    </tbody>  
                    ";
            $no++;
        }
        ?>
    </table><br><br><br><br><br><br><br><br><br><br>
</body>
</html>