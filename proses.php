<?php
session_start();
include 'koneksi.php';

$upd = $_GET['upd'];

if($upd != ''){
    $sqlUpd = "update transaksi set status = 'selesai' where id = $upd";
    $queryUpd = mysqli_query($conn, $sqlUpd);
    if($queryUpd){
        header("location:index.php?page=pesanan");
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<body>
    <div class="mt-5">  
        <center>
            <h1 class="mt-3 mb-3">Data Transaksi</h1>
            <table class='table table-bordered table-striped table-hover table-responsive-sm'>
                <thead class='thead-dark'>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Total Barang</th>
                    <th>Jam Pemesanan</th>
                    <th>Alamat</th>
                    <th>Jasa Kirim</th>
                    <th>Jam Pemesanan</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </thead>
                <?php 
                    $no = 1;
                    $sqlTampil = "SELECT * FROM transaksi where status = 'sedang diproses'";
                    $queryTampil = mysqli_query($conn, $sqlTampil);
                    while($row1 = mysqli_fetch_array($queryTampil)){
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
                                <td>$row1[alamat]</td>
                                <td>$row1[jasa_kirim]</td>
                                <td>$row1[jam]</td>
                                <td>Rp. $subtotal</td>
                                <td><a href='index.php?page=pesanan&&upd=$row1[id]'class='btn btn-warning'>Proses</a></td>
                            </tr>
                        </tbody>  
                        ";$no++;
                    }
                ?>
            </table>
        </center>
    </div>
</body>
</html>