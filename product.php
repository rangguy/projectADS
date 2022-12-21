<?php
session_start();
include 'koneksi.php';
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
                     <h5 class="card-title" align="center">Kategori Produk</h5>
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
               <?php
               if ($_SESSION['status'] == 'admin' | $_SESSION['status'] == 'pegawai') {
               ?>
                  <div class="row">
                     <div class='col-md-4 col-sm-6 center-responsive'>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                           Tambah
                        </button>
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                           <div class="modal-dialog" role="document">
                              <div class="modal-content">
                                 <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Tambah Barang</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                       <span aria-hidden="true">&times;</span>
                                    </button>
                                 </div>
                                 <div class="modal-body">
                                    <form method="POST" action="tambahBarang.php" name="formBarang" enctype="multipart/form-data">
                                       <div class="form-group">
                                          <label for="exampleFormControlInput1">Nama Barang</label>
                                          <input name="namaBarang" type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nama Barang">
                                       </div>
                                       <div class="form-group">
                                          <label for="exampleFormControlInput1">Stok</label>
                                          <input name="stokBarang" type="number" class="form-control" id="exampleFormControlInput1" placeholder="Stok Barang">
                                       </div>
                                       <div class="form-group">
                                          <label for="exampleFormControlInput1">Harga</label>
                                          <input name="hargaBarang" type="number" class="form-control" id="exampleFormControlInput1" placeholder="Harga Barang">
                                       </div>
                                       <div class="form-group">
                                          <label for="exampleFormControlSelect1">Kategori</label>
                                          <select name="katBarang" class="form-control" id="exampleFormControlSelect1">
                                             <option value="sembako">Sembako</option>
                                             <option value="elektronik">Elektronik</option>
                                             <option value="jajanan">Snack</option>
                                          </select>
                                       </div>
                                       <div class="form-group">
                                          <label for="exampleFormControlTextarea1">Keterangan</label>
                                          <textarea name="ketBarang" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                       </div>
                                       <div class="form-group">
                                          <label for="exampleFormControlFile1">Foto Barang</label>
                                          <input name="foto" type="file" accept=".png,.jpg" class="form-control-file" id="exampleFormControlFile1">
                                       </div>
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                       <input type="submit" name="insert" class="btn btn-primary" value="Submit"></input>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               <?php } if ($_SESSION['status'] == 'owner' | $_SESSION['status'] == 'admin') { 
                  echo "
                     <a href='index.php?page=lapbarang' class='btn btn-primary mt-2' align='center'>Lap. Barang</a>
                  ";
               }?>
               <div class="row">
                  <?php
                  $no++;
                  if($_GET['kategori'] == 'sembako'){
                     $kat = "sembako"; 
                  }else if($_GET['kategori'] == 'instan'){
                     $kat = "produk instan";
                  }else if($_GET['kategori'] == 'perlengkapanmandi'){
                     $kat = "perlengkapan mandi";
                  }else {
                     $kat = '';
                  }

                  if($kat!=''){
                     $sql = "SELECT * FROM barang WHERE kategori = '$kat'";
                     $query = mysqli_query($conn, $sql);
                  }else{
                     $sql = "SELECT * FROM barang";
                     $query = mysqli_query($conn, $sql);
                  }

                  while ($row = mysqli_fetch_array($query)) {
                     $stok = $row['stok'];
                     if ($stok > 10) {
                        $ketStok = "Stok Tersedia";
                     } else if ($stok <= 10 && $stok > 0) {
                        $ketStok = "Stok Menipis";
                     } else {
                        $ketStok = "Stok Habis";
                     }
                     echo "
                        <div class='col-md-4 col-sm-6 center-responsive'>
                           <div class='box'>
                              <div class='option_container'>
                                 <div class='options'>
                                    <a href='index.php?page=infobarang&id=$row[id]' class='option1'>
                                    Info Produk
                                    </a>
                                    <a href='index.php?page=infobarang&id=$row[id]' class='option2'>
                                    Tambah
                                    </a>
                                 </div>
                              </div>
                              <div class='img-box'>
                                 <img src='$row[gambar]' alt=''>
                              </div>
                              <div class='detail-box'>
                                 <h5>
                                    $row[nama]
                                 </h5>
                                 <h6>
                                    Rp. $row[harga]
                                 </h6>
                              </div>
                              <div class='detail-box'>
                                 <p class='text-center'>
                                    $ketStok
                                 </p>
                              </div>
                           </div>
                        </div>";
                  }
                  $no++;
                  ?>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- end product section -->
   
</body>

</html>