<?php
include 'koneksi.php';
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Data Barang.xls");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <div class="">
        <div class="">
            <h2>
                Laporan Barang
            </h2>
        </div>
        <table border="1">
            <thead>
                <th>No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Harga Satuan</th>
                <th>Stok</th>
                <th>Jumlah Terjual</th>
                <th>Total Harga Terjual</th>
            </thead>
            <?php
            $no = 1;
            $sqlTampil = "SELECT * FROM barang";
            $queryTampil = mysqli_query($conn, $sqlTampil);
            while ($row1 = mysqli_fetch_array($queryTampil)) {
                $idBarang = $row1['id'];
                $sqlHitung = "SELECT * FROM transaksi WHERE id_barang = $idBarang AND status = 'selesai'";
                $queryHitung = mysqli_query($conn, $sqlHitung);
                while($row2 = mysqli_fetch_array($queryHitung)){
                    $jumlah = $row2['jumlah'];
                }
                $totalHargaTerjual = $jumlah * $row1['harga'];
                echo "
                <tbody>
                    <tr>
                        <td>$no</td>
                        <td>$row1[nama]</td>
                        <td>$row1[kategori]</td>
                        <td>Rp. $row1[harga]</td>
                        <td>$row1[stok]
                        <td>$jumlah</td>
                        <td>Rp. $totalHargaTerjual</td>
                    </tr>
                </tbody>  
                        ";
                        $totalBarang = $row1['stok'] + $totalBarang;
                        $totalJumlahTerjual = $jumlah + $totalJumlahTerjual;
                        $totalHarga = $totalHargaTerjual + $totalHarga;
                        $no++;
                    }
            ?>
            <td colspan="4"><b>Jumlah</b></td>
            <td><?php echo $totalBarang ?></td>
            <td><?php echo $totalJumlahTerjual?></td>
            <td>Rp. <?php echo $totalHarga ?></td>
        </table>
    </div>
</body>

</html>