<?php
session_start();
include 'koneksi.php';

$nama = $_POST['namaBarang'];
$stok = $_POST['stokBarang'];
$harga = $_POST['hargaBarang'];
$kategori = $_POST['katBarang'];
$ket = $_POST['ketBarang'];
$foto = $_FILES['foto']['name'];

if(isset($_POST['insert'])){
	if($foto!=''){
		$upload = 'images/'.$foto;
		move_uploaded_file($_FILES['foto']['tmp_name'],$upload);
	}
	$sql = "insert into barang(id,nama,kategori,stok,harga,keterangan, gambar) values('','$nama','$kategori','$stok','$harga', '$ket','$upload') ";
	$query = mysqli_query($conn,$sql);
	if($query){
		?>
		<!-- Javascript -->
		<script>alert('Data Barang Berhasil Ditambahkan!');
        document.location='index.php?page=barang';</script>
		<?php
	}
}

?>
