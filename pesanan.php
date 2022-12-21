<?php
session_start();
include 'koneksi.php';

$del = $_GET['del'];
$jumlah = $_GET['jumlah'];
$idBarang = $_GET['idBarang'];
if ($del != "") {
    $sqlDel = "delete from transaksi where id='$del' ";
    $queryDel = mysqli_query($conn, $sqlDel);
    $sqlStok = "select * from barang where id = '$idBarang' ";
    $queryStok = mysqli_query($conn, $sqlStok);
    $row = mysqli_fetch_array($queryStok);
    $stok = $row['stok'];
    $stokBaru = $stok + $jumlah;
    $sqlUpd = "update barang set stok = '$stokBaru' where id = '$idBarang'";
    $queryUpd = mysqli_query($conn, $sqlUpd);
    if ($queryUpd) {
?>
        <!-- Javascript -->
        <script>
            alert('Data Barang Berhasil Dihapus!');
            document.location = 'index.php?page=pesanan';
        </script>
    <?php
    }
}


if ($_SESSION['user'] == '') {
    ?> 
        <script>alert("Anda harus login terlebih dahulu!");document.location = "login/login.php";</script>
    <?php
} else {
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <body>
        <div class="container mt-5 mb-5">
            <div class="heading_container heading_center">
                <h2>
                    Keranjang
                </h2>
            </div>
            <div id="content mt-5">
                <div class="container mt-5 mb-5">
                    <div class="row">
                        <div class="col-md-8" id="cart">
                            <div class="card">
                                <div class="card-body">
                                    <h3>Keranjang Belanja</h3>
                                    <?php
                                    $idUser = $_SESSION['id'];
                                    $sql = "SELECT * FROM transaksi where id_pelanggan = '$idUser'";
                                    $query = mysqli_query($conn, $sql);
                                    $jumlah = 0;
                                    $no++;
                                    while ($row = mysqli_fetch_array($query)) {
                                        if($row['status'] == ''){
                                            $jumlah = $row['jumlah'] + $jumlah;
                                            $idBarang = $row['id_barang'];
                                        }
                                        $no++;
                                    }
                                    ?>
                                    <p class="text-muted">
                                        Kamu punya <?php echo $jumlah ?> di keranjang kamu
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th colspan="2">Produk</th>
                                                    <th>Jumlah</th>
                                                    <th colspan="1">Harga per unit</th>
                                                    <th>Action</th>
                                                    <th colspan="2">Sub Total</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $i++;
                                                $sqlTampil = "SELECT * FROM transaksi WHERE id_pelanggan = '$idUser'";
                                                $queryTampil = mysqli_query($conn, $sqlTampil);
                                                while ($row = mysqli_fetch_array($queryTampil)) {
                                                    if($row['status'] == ''){
                                                        $idBarang = $row['id_barang'];
                                                        $sqlBarang = "SELECT * FROM barang WHERE id = '$idBarang'";
                                                        $queryBarang = mysqli_query($conn, $sqlBarang);
                                                        while ($row1 = $queryBarang->fetch_assoc()) {
                                                            $nama = $row1['nama'];
                                                            $foto = $row1['gambar'];
                                                            $harga = $row1['harga'];
                                                        }
                                                        $subTotal = $harga * $row['jumlah'];
                                                        echo "<tr>
                                                        <td><img src='$foto' width='80' height='50'></td>
                                                        <td><a href='index.php?page=infobarang&id=$idBarang' style='color:black;'>$nama</a></td>
                                                        <td>$row[jumlah]</td>
                                                        <td>Rp. $harga</td>
                                                        <td>
                                                            <a href='index.php?page=pesanan&&del=$row[id]&&jumlah=$row[jumlah]&&idBarang=$idBarang' class='btn btn-danger'><svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash' viewBox='0 0 16 16'>
                                                            <path d='M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z'/>
                                                            <path fill-rule='evenodd' d='M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z'/>
                                                            </svg></a>
                                                        </td>
                                                        <td>Rp. $subTotal</td>
                                                        </tr>";
                                                    }
                                                    
                                                    $totalHarga = $subTotal + $totalHarga;
                                                    $i++;
                                                }
                                                if ($totalHarga > 50000) {
                                                    $diskon = 0.1 * $totalHarga;
                                                } else {
                                                    $diskon = 0;
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th colspan="5">Total </th>
                                                    <th colspan="2"><?php echo "Rp. " . $totalHarga ?></th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div><!-- table-responsive ends -->
                                    <div class="card-footer">
                                        <div class="float-left">
                                            <a href="index.php?page=barang" class="btn btn-secondary btn-sm">
                                                <i class="fa fa-chevron-left"></i>
                                                Lanjut Belanja
                                            </a>
                                        </div><!-- float left ends -->
                                        <div class="float-right">
                                            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModal">
                                                Checkout
                                                <i class="fa fa-chevron-right"></i>
                                            </button>
                                            <!-- Modal -->
                                            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Ringkasan Belanja</h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="POST" action="checkout.php" name="formCO">
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">Jumlah Barang</label>
                                                                <p><?php echo $jumlah ?></p>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1">Pembayaran</label>
                                                                <select name="metode_bayar" class="form-control" id="exampleFormControlSelect1">
                                                                    <option selected>--pilih--</option>
                                                                    <option value="cod">Cash On Delivery / Bayar di Tempat</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleFormControlTextarea1">Alamat</label>
                                                                <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleFormControlSelect1">Pengiriman</label>
                                                                <select name="jasaKirim" class="form-control" id="exampleFormControlSelect1">
                                                                    <option selected>--pilih--</option>
                                                                    <option value="jnt">J&T Express</option>
                                                                    <option value="tiki">Tiki</option>
                                                                    <option value="jne">JNE</option>
                                                                    <option value="anteraja">Anteraja</option>
                                                                    <option value="sicepat">Si Cepat</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">Potongan Harga</label>
                                                                <p><?php echo "Rp. ".$diskon?></p>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="exampleFormControlInput1">Total Harga</label>
                                                                <p><?php echo "Rp. ".$totalHarga ?></p>
                                                            </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                                        <input type="submit" name="checkout" class="btn btn-primary" value="Checkout"></input>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- float right ends -->
                                    </div><!-- card footer ends -->
                                </div><!-- card body ends -->
                            </div><!-- card ends -->

                        </div><!--  .col-md-9 #cart ends -->
                        <div class="col-md-4 mb-5">
                            <div class="card" id="order-summary">
                                <div class="card-header">
                                    <h5>Ringkasan Belanja</h5>
                                </div><!-- card-header ends -->
                                <div class="card-body">
                                    <p class="text-muted">
                                        Total Barang : <?php echo $jumlah ?> Barang
                                    </p>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>Total Harga</td>
                                                    <th><?php echo "Rp. " . $totalHarga ?></th>
                                                </tr>
                                                <tr class="total">
                                                    <td>Total Bayar</td>
                                                    <th><?php $hargaAkhir = $totalHarga - $diskon;
                                                        echo "Rp. " . $hargaAkhir ?></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div><!-- table responsive ends -->
                                </div><!-- card-body ends -->
                            </div><!-- card order-summary ends -->
                        </div><!-- col-md-3 ends -->
                    </div><!-- row ends -->
                </div><!-- container ends -->
            </div><!-- content ends -->
        </div>
    </body>

    </html>

<?php } ?>