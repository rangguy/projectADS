<?php
session_start();
include 'koneksi.php';

?>

<!DOCTYPE html>
<html lang="en">

<body>
    <div class="mt-5">
        <div class="heading_container heading_center mb-5">
            <h2>
                Laporan Transaksi
            </h2>
        </div>
        <table class='table table-bordered table-striped table-hover table-responsive-sm mb-5'>
            <?php if($_SESSION['status'] == 'admin') {
                echo " 
                <center>
                    <a href='index.php?page=pesanan' class='btn btn-primary mb-5' align='center'>Pesanan</a>
                </center>
                ";
            } ?>
            <thead class='thead-dark'>
                <th>No</th>
                <th>Barang</th>
                <th>Total Barang</th>
                <th>Jam Pemesanan</th>
                <th>Alamat</th>
                <th>Jasa Kirim</th>
                <th>Total Harga</th>
            </thead>
            <?php
            $no = 1;
            $sqlTampil = "SELECT * FROM transaksi where status = 'selesai'";
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
                        <td>$row1[alamat]</td>
                        <td>$row1[jasa_kirim]</td>
                        <td>Rp. $subtotal</td>
                        </tr>
                        </tbody>  
                        ";
                        $totalBarang = $row1['jumlah'] + $totalBarang;
                        $totalHarga = $subtotal + $totalHarga;
                        $no++;
                    }
                    ?>
                <td></td>
                <td><b>Total Barang</b></td>
                <td colspan="2"><?php echo $totalBarang ?></td>
                <td colspan="2"><b>Total Harga</b></td>
                <td>Rp. <?php echo $totalHarga?></td>
        </table>
    </div>
</body>

</html>