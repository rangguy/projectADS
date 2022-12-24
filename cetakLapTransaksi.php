<?php
include 'koneksi.php';

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Transaksi.xls");
?>

<!DOCTYPE html>
<html lang="en">

<body>
    <div class="container mt-5">
        <div class="heading_container heading_center mb-5">
            <h2>
                Laporan Transaksi
            </h2>
        </div>
        <table border="1">
            <thead>
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
                <td><?php echo $totalBarang ?></td>
                <td></td>
                <td></td>
                <td><b>Total Harga</b></td>
                <td>Rp. <?php echo $totalHarga?></td>
        </table>
    </div>
</body>

</html>