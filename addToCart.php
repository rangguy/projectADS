<?php
session_start();
include 'koneksi.php';
if(isset($_POST['addBarang'])){
	$updBarang = $_GET['id'];
    $id = $_SESSION['id'];
	$stok = $_POST['stok'];
	$jumlahBeli = intval($_POST['jumlah']);
    $stokBaru = $stok- $jumlahBeli;
	$updateStok = "update barang set stok='$stokBaru' where id='$updBarang'";
	$queryUpdate = mysqli_query($conn, $updateStok);
	if($queryUpdate){
		$sqlInsert = "INSERT INTO transaksi (id, id_pelanggan, id_barang, jumlah, metode_bayar, alamat, jasa_kirim, status) 
		values(0, '$id', '$updBarang', '$jumlahBeli', '', '','','')";
		$queryInsert = mysqli_query($conn, $sqlInsert);
		if($queryInsert){
		?>
			<script>
				alert("Berhasil Memasukkan ke Keranjang!");
				document.location = "index.php?page=barang";
			</script>
		<?php
		}
	}
}