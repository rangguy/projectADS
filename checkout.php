<?php 
session_start();
include 'koneksi.php';

$metode = $_POST['metode_bayar'];
$alamat = $_POST['alamat'];
$jasaKirim = $_POST['jasaKirim'];
$idUser = $_SESSION['id'];
$tz = 'Asia/Jakarta';
$dt = new DateTime("now", new DateTimeZone($tz));
$timestamp = $dt->format('Y-m-d G:i:s');
if (isset($_POST['checkout'])){
    $status = 'sedang diproses';
    $sqlUpd = "update transaksi set metode_bayar = '$metode', alamat = '$alamat', jasa_kirim = '$jasaKirim', status = '$status', jam = '$timestamp' where id_pelanggan = '$idUser' and status = ''";
    $queryUpd = mysqli_query($conn, $sqlUpd);
    if($queryUpd){
        ?>
            <script>
                alert("Berhasil Checkout Barang!");
                document.location = "index.php?page=pesanan";
            </script>
        <?php
    }
}

?>
