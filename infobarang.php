<?php
session_start();
include 'koneksi.php';

$id = $_GET['id'];
$del = $_GET['del'];
$upd = $_GET['upd'];

$nama = $_POST['namaBarang'];
$stok = $_POST['stokBarang'];
$harga = $_POST['hargaBarang'];
$kategori = $_POST['katBarang'];
$ket = $_POST['ketBarang'];
$foto = $_FILES['foto']['name'];

if ($del != "") {
   $row = mysqli_fetch_array(mysqli_query($conn, "select * from barang where id='$del'"));
   $filegambar = $row['gambar'];
   unlink($filegambar);
   $sqlDel = "delete from barang where id='$del' ";
   $queryDel = mysqli_query($conn, $sqlDel);
   if ($queryDel) {
      ?>
      <!-- Javascript -->
      <script>
         alert('Data Barang Berhasil Dihapus!');
         document.location = 'index.php?page=barang';
         </script>
<?php
   }
}

if (isset($_POST['edit'])) {
   if ($foto != '') {
      $row = mysqli_fetch_array(mysqli_query($conn, "select * from barang where id='$upd'"));
		$filegambar = $row['gambar'];
		unlink($filegambar);
		$upload = 'images/' . $foto;
		move_uploaded_file($_FILES['foto']['tmp_name'], $upload);
		$sqlUpd =  "update barang set nama='$nama',kategori = '$kategori',stok='$stok', harga='$harga', keterangan='$ket',gambar='$upload' 
		where id='$upd' ";
	} else {
      $sqlUpd =  "update barang set nama='$nama',kategori = '$kategori',stok='$stok', harga='$harga', keterangan='$ket' 
		where id='$upd' ";
	}
   
	$queryUpd = mysqli_query($conn, $sqlUpd);
	if ($queryUpd) {
      ?>
		<!-- Javascript -->
		<script>
         alert('Data Barang Berhasil Diubah!');
			document.location = 'index.php?page=barang';
         </script>
	<?php
	}
}

$feedback = $_POST['feedback'];
$idfb = $_GET['fb'];
if(isset($_POST['InsertFeedback'])){
   $sqlSelFb = "SELECT * FROM barang where id = '$idfb'";
   $querySelFb = mysqli_query($conn, $sqlSelFb);
   $row3 = mysqli_fetch_array($querySelFb);
   $feedbackLama = $row3['feedback'];
   if ($row3['feedback'] != ''){
      $feedbackBaru = "$feedbackLama, ". "$feedback";
      $sqlUpdFb = "UPDATE barang set feedback = '$feedbackBaru' where id = '$idfb'";
      $queryUpdFb = mysqli_query($conn, $sqlUpdFb);
      if ($queryUpdFb){
         ?>
            <script>
               alert("Terima Kasih Feedback Anda telah kami terima!");
               document.location = "index.php?page=barang";
               </script>
         <?php
      }
   } else {
      $sqlUpdFb2 = "UPDATE barang set feedback = '$feedback' where id = '$idfb'";
      $queryUpdFb2 = mysqli_query($conn, $sqlUpdFb2);
      if ($queryUpdFb2){
         ?>
            <script>
               alert("Terima Kasih Feedback Anda telah kami terima!");
               document.location = "index.php?page=barang";
            </script>
         <?php
      } 
   }
}

?>

<!DOCTYPE html>
<html>

<head>
   <!-- Basic -->
   <meta charset="utf-8" />
   <meta http-equiv="X-UA-Compatible" content="IE=edge" />
   <!-- Mobile Metas -->
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
   <!-- Site Metas -->
   <meta name="keywords" content="" />
   <meta name="description" content="" />
   <meta name="author" content="" />
   <link rel="shortcut icon" href="images/favicon.png" type="">
   <!-- bootstrap core css -->
   <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
   <!-- font awesome style -->
   <link href="css/font-awesome.min.css" rel="stylesheet" />
   <!-- Custom styles for this template -->
   <link href="css/style.css" rel="stylesheet" />
   <!-- responsive style -->
   <link href="css/responsive.css" rel="stylesheet" />
</head>

<body class="sub_page">
   <!-- product section -->
   <section class="product_section layout_padding">
      <div class="container">
         <div class="heading_container heading_center">
            <h2>
               Produk <span>Kami</span>
            </h2>
         </div>

         <div class="row">
            <div class="col-md-3 mb-3">
            <div class="card sidebar-menu">
                  <div class="card-header">
                     <h5 class="card-title">Kategori Produk</h5>
                  </div><!-- card-header ends-->
                  <div class="card-body">
                     <ul class="nav nav-pills flex-column nav-stacked category-menu">
                        <li><a class="nav-link btn btn-danger mb-2" href="index.php?page=barang"> Semua</a></li>
                        <li><a class="nav-link btn btn-danger mb-2" href="index.php?page=barang&&kategori=sembako">Sembako</a></li>
                        <li><a class="nav-link btn btn-danger mb-2" href="index.php?page=barang&&kategori=instan">Produk Instan</a></li>
                        <li><a class="nav-link btn btn-danger mb-2" href="index.php?page=barang&&kategori=perlengkapanmandi">Perlengkapan Mandi</a></li>
                     </ul><!-- nav nav-pills nav-stacked category-menu ends -->
                  </div><!-- card body ends -->
               </div><!-- card sidebar-menu ends -->
            </div>
            <div class="col-md-9">
               <div class="row">
                  <?php
                  $idUser = $_SESSION['id'];
                  $no++;
                  $sql = "SELECT * FROM barang where id='$id'";
                  $query = mysqli_query($conn, $sql);
                  $row = mysqli_fetch_array($query);
                  echo "
                     <div class='col-sm-6'>
								<div id='mainImage'>
                           <div class='img-box'>
                              <img class='d-block w-100 h-25' src='$row[gambar]' alt='gambarProduk'>
                           </div>
							   </div><!-- mainImage ends -->
							</div><!-- col-sm-6 ends -->
                     <div class='col-sm-6'>
                        <div class='card'>
                           <div class='card-body'>
                              <h3 class='text-center mb-4'>$row[nama]</h3>
                              <form action='addToCart.php?id=$row[id]' method='post'>
                                 <div class='form-group row'>
                                    <label class='col-md-5 col-form-label'>Jumlah</label>
                                    <div class='col-md-7'>
                                       <input type='number' name='jumlah' id='jumlah' class='form-control form-control-sm' value=1 min='1' max='$row[stok]'></input>
                                       <input type='text' name='stok' value=$row[stok] hidden>
                                       <input type='text' name='harga' value=$row[harga] hidden>
                                       Stok : $row[stok]
                                    </div>
                                 </div><!-- form-group row ends -->
                                 <div class='form-group row'>
                                    <label class='col-md-5 col-form-label'>Sub Total</label>
                                    <div class='col-md-7'>
                                    <p class='price' name='SubTotal' id='SubTotal' >Rp. $row[harga] / pcs</p>
                                    </div>
                                 </div><!-- form-group row ends -->
                                 <p class='text' >$row[keterangan]</p>";
                                 if ($_SESSION['status'] != 'pelanggan'){
                                    echo "
                                    <div class='form-group row'>
                                       <label class='col-md-5 col-form-label'>Feedback</label>
                                       <div class='col-md-7'>
                                       <p class='text'>$row[feedback]</p>
                                       </div>
                                    </div><!-- form-group row ends -->";
                                 }
                                 if($row['stok'] == 0 | $_SESSION['status'] != 'pelanggan'){
                                    echo "<p class='text-center buttons'>
                                       <button class='btn btn-primary' name='addBarang' type='submit' disabled>
                                          <i class='fa fa-shopping-cart'></i>
                                          Add to cart
                                       </button>
                                    </p>";
                                 } else {
                                    echo "<p class='text-center buttons'>
                                       <button class='btn btn-primary' name='addBarang' type='submit'>
                                          <i class='fa fa-shopping-cart'></i>
                                          Add to cart
                                       </button>
                                    </p>";
                                 } echo " 
                              </form>
                              <p class='text-center buttons'>"; 
                              if ($_SESSION['status'] == 'admin' | $_SESSION['status'] == 'pegawai') {
                              ?>
                              <!-- Button trigger modal -->
                              <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#exampleModal">
                                 Edit
                              </button>
                              <a class="btn btn-danger" href="index.php?page=infobarang&del=<?php echo $row['id'] ?>">Delete</a>
                              <?php } else {
                                 $sqlCek = "SELECT * FROM transaksi";
                                 $queryCek = mysqli_query($conn, $sqlCek);
                                 while ($row2 = mysqli_fetch_array($queryCek)){
                                    if ($row2['id_barang'] == $row['id'] && $row2['id_pelanggan'] == $_SESSION['id'] && $row2['status'] == 'selesai'){
                                       echo "<p class='text-center buttons'>
                                       <button type='button' class='btn btn-warning' data-toggle='modal' data-target='#ModalFeedback'>
                                          Feedback
                                       </button>
                                    </p>";
                                    }
                                 }   
                              }?>
                              <!-- Modal Feedback-->
                              <div class="modal fade" id="ModalFeedback" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                              <div class="modal-dialog" role="document">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Feedback</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                    </div>
                                    <div class="modal-body">
                                       <form action="index.php?page=infobarang&fb=<?php echo $row['id']?>" method="POST">
                                          <div class="form-group">
                                             <label for="exampleFormControlTextarea1">Masukan Feedback Anda</label>
                                             <textarea name="feedback" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                          </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                       <input type="submit" class="btn btn-primary" name="InsertFeedback" value="Kirim"></input>
                                    </form>
                                    </div>
                                 </div>
                              </div>
                              </div>
                              <!-- Modal Edit Barang -->
                              <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                 <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                       <div class="modal-header">
                                          <h5 class="modal-title" id="exampleModalLabel">Edit Barang</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                             <span aria-hidden="true">&times;</span>
                                          </button>
                                       </div>
                                       <div class="modal-body">
                                          <form method="POST" action="index.php?page=infobarang&upd=<?php echo $row['id']?>" name="formEditBarang" enctype="multipart/form-data">
                                             <div class="form-group">
                                                <label for="exampleFormControlInput1">Nama Barang</label>
                                                <input name="namaBarang" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nama Barang" value="<?php echo $row['nama'] ?>">
                                             </div>
                                             <div class="form-group">
                                                <label for="exampleFormControlInput1">Stok</label>
                                                <input name="stokBarang" type="number" class="form-control" id="exampleFormControlInput1" placeholder="Stok Barang" value="<?php echo $row['stok'] ?>">
                                             </div>
                                             <div class="form-group">
                                                <label for="exampleFormControlInput1">Harga</label>
                                                <input name="hargaBarang" type="number" class="form-control" id="exampleFormControlInput1" placeholder="Harga Barang" value="<?php echo $row['harga'] ?>">
                                             </div>
                                             <div class="form-group">
                                                <label for="exampleFormControlSelect1">Kategori</label>
                                                <select name="katBarang" class="form-control" id="exampleFormControlSelect1">
                                                   <?php
                                                   $opsi = array("sembako", "produk instan", "perlengkapan mandi");
                                                   foreach ($opsi as $opsi) {
                                                      if ($opsi == $row['kategori']) {
                                                         echo "<option value='$opsi' selected>$opsi</option>";
                                                      } else {
                                                         echo "<option value='$opsi'>$opsi</option>";
                                                      }
                                                   }
                                                   ?>
                                                </select>
                                             </div>
                                             <div class="form-group">
                                                <label for="exampleFormControlTextarea1">Keterangan</label>
                                                <textarea name="ketBarang" class="form-control" id="exampleFormControlTextarea1" rows="3"><?php echo $row['keterangan']?></textarea>
                                             </div>
                                             <div class="form-group">
                                                <label for="exampleFormControlFile1">Foto Barang</label>
                                                <input name="foto" type="file" accept=".png,.jpg" class="form-control-file" id="exampleFormControlFile1">
                                             </div>
                                       </div>
                                       <div class="modal-footer">
                                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                          <input type="submit" name="edit" class="btn btn-primary" value="Submit"></input>
                                          </form>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <?php  echo " 
                           </div>
                        </div>
                     </div>
                  </div>";
                  ?>
               </div>
            </div>
         </div>
   </section>
   <!-- end product section -->
   
</body>

</html>