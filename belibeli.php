<?php
//untuk menghapus bagian error
ob_start();
error_reporting(0); 
include "koneksi.php";
session_start();


include "header.php";
// ------------------

// mengambil data dari halaman sebelumnya 

if(isset($_GET['nama_beras'])){

$nama_beras = $_GET['nama_beras'];
}
// ----------------------------------------
// [[[[[[[[[[[[[[[[[[[[[[[[PHP AWAL KONEKSI]]]]]]]]]]]]]]]]]]]]]]]]

 // [[[[[[[[[[MENGAMBIL DATA DARI DATABASE DENGAN SYARAT nama_beras = GET -> dari HALAMAN SEBELUMNYA]]]]]]]]]]]]]]]]]]]]]]
  $result = mysqli_query($con,"SELECT * FROM produk WHERE nama_beras = '$nama_beras' ORDER BY id ASC");
  // [[[[[[[[[[MENGAMBIL DATA DARI DATABASE DENGAN SYARAT nama_beras = GET -> dari HALAMAN SEBELUMNYA]]]]]]]]]]]]]]]]]]]]]]

?>

<?php 
// [[[[[[[[[[[[[[[[MEMBUAT SESSION]]]]]]]]]]]]]]]]

// [[[[[[[[[[[[[[[[[MEMBUAT SESSION]]]]]]]]]]]]]]]]]]

// [[[[[[[[[[[[[[[[[[[MEMBUAT ARRAY KOSONG DENGAN TUJUAN SEBAGAI KOTAK BARU UNTUK PENYIMPANAN]]]]]]]]]]]]]]]]]]]
$product_ids = array();
// [[[[[[[[[[[[[[[[[[[MEMBUAT ARRAY KOSONG DENGAN TUJUAN SEBAGAI KOTAK BARU UNTUK PENYIMPANAN]]]]]]]]]]]]]]]]]]]


// [[[[[[[[BUKA[[[[[[[[[[[[[[[[SCRIPT SHOPPING CART]]]]]]]]]]]]]]]]]]]]]]]]
if (filter_input(INPUT_POST, 'submit')) {
  # code...
  if (isset($_SESSION['shopping_cart'])) {
    # code...
  
    //keep track of how mnay products are in the shopping cart
        $count = count($_SESSION['shopping_cart']);
  
        //create sequantial array for matching array keys to products id's
        $product_ids = array_column($_SESSION['shopping_cart'], 'id');
      
        if (!in_array(filter_input(INPUT_GET, 'id'), $product_ids)){
        $_SESSION['shopping_cart'][$count] = array
            (
                'id' => filter_input(INPUT_GET, 'id'),
                'nama_beras' => filter_input(INPUT_POST, 'nama_beras'),
                'harga' => filter_input(INPUT_POST, 'harga'),
                'quantity' => filter_input(INPUT_POST, 'quantity')
            );  
               // ==================
             
        }
        else { //product already exists, increase quantity
            //match array key to id of the product being added to the cart
            for ($i = 0; $i < count($product_ids); $i++){
                if ($product_ids[$i] == filter_input(INPUT_GET, 'id')){
                    //add item quantity to the existing product in the array
                    $_SESSION['shopping_cart'][$i]['quantity'] += filter_input(INPUT_POST, 'quantity');
                }
               
            }
        }
  }
  else{

      $_SESSION['shopping_cart'][0] = array(
        'id' =>filter_input(INPUT_GET, 'id'), 
        'nama_beras' => filter_input(INPUT_POST, 'nama_beras'),
        'harga' => filter_input(INPUT_POST, 'harga'),
        'quantity' => filter_input(INPUT_POST, 'quantity')
      );
            
    }
  }
 // print_r($_SESSION);

if(filter_input(INPUT_GET, 'action') == 'delete'){
    //loop through all products in the shopping cart until it matches with GET id variable
    foreach($_SESSION['shopping_cart'] as $key => $product){
        if ($product['id'] == filter_input(INPUT_GET, 'id')){
            //remove product from the shopping cart when it matches with the GET id
            unset($_SESSION['shopping_cart'][$key]);
        }
    }
    //reset session array keys so they match with $product_ids numeric array
    $_SESSION['shopping_cart'] = array_values($_SESSION['shopping_cart']);
}




$a = json_encode($_SESSION['shopping_cart'] , JSON_FORCE_OBJECT);


setcookie('bahagia', $a, time()+1000);


$c = json_decode($_COOKIE['bahagia'], TRUE);

// print_r($c);

// pre_r($_SESSION);

// pre_r($_COOKIE);

function pre_r($array){
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}
// [[[[[[[TUTUP[[[[[[[[[[[SCRIPT SHOPPING CART]]]]]]]]]]]]]]]]]]
 ?>


<!-- [[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[[MEMULAI BODY]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]] -->
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Theme Made By www.w3schools.com - No Copyright -->
  <title>Bootstrap Theme Company Page</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato" rel="stylesheet" type="text/css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<style>
  

</style>

</head>
<body style="opacity: 1; background-image: url(whiteback.jpg); background-position: center;
    background-repeat: no-repeat;
    background-size: cover; border-top: 2px solid white;
    
    "> 


<?php 
// \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\
// melempar ke halaman lain jika terbukti tidak login 
  if (empty($_SESSION['username'])) {
    # code...
    echo "<script>alert('Anda Dipersilahkan Untuk Login Dulu');
    window.location='contoh_form.php'</script>";
    
  }
  // \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\

 ?>
<?php 
// include "bocaboca2.php";
 ?>



<!-- [[[[[[[[[[[[[[[[[[[[[[[[TAMPILAN]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]]] -->
<div style="font-family: montserrat, sans-serif; color: blue; margin-top: 160px;" class="text-center">
  <?php while ($row=mysqli_fetch_assoc($result)) : ?>
 
</div>

<!-- coba -->
<!-- [[[[[[[[[[[[[[[[[[[[[[[[MEMBUAT TAMPILAN BERSISA KIRI DAN KANAN]]]]]]]]]]]]]]]]]]]]]]]] -->
<div class="container-fluid">

  <?php
  // [[[[[[[[[[[[[[[[[[[[[[[MEMBUAT KONEKSI KE DATABASE]]]]]]]]]]]]]]]]]]]]]]]
  include "koneksi.php";
  // [[[[[[[[[[[[[[[[[[[[[[[[[[[[MEMBUAT KONEKSI]]]]]]]]]]]]]]]]]]]]]]]]]]]]


 
  // [[[[[[[[[[MENGAMBIL DATA DARI DATABASE DENGAN SYARAT nama_beras = GET -> dari HALAMAN SEBELUMNYA]]]]]]]]]]]]]]]]]]]]]]
  $result = mysqli_query($con,"SELECT * FROM produk WHERE nama_beras = '$nama_beras' ORDER BY id ASC");
  // [[[[[[[[[[MENGAMBIL DATA DARI DATABASE DENGAN SYARAT nama_beras = GET -> dari HALAMAN SEBELUMNYA]]]]]]]]]]]]]]]]]]]]]]
if (isset($_GET['nama_beras'])) {
  # code...
  $nama_beras = $_GET['nama_beras'];
}
 $result = mysqli_query($con,"SELECT * FROM produk WHERE nama_beras = '$nama_beras' ORDER BY id ASC");


  // [[[[[[[[[[[[BUKA[[[[[[[[[[[[[[[[MEMBUAT PERULANGAN DENGAN WHILE TERHADAP DATA YANG DIAMBIL DARI DATABASE]]]]]]]]]]]]
  if ($result) :
    # code...
    // -------------------jika ada database yang dimaksud maka-----------------
    if (mysqli_num_rows($result)>0) :
      // -------------------jika ada database yang dimaksud maka-----------------
      # code...
      // -------------perulangan--------------
      while ($row = mysqli_fetch_assoc($result)) :
        # code...
     


        // -------------perulangan------------------
      ?>


      <!-- [[[[[[[[[[[[[[[[[[[[[[[[[[[[[TAMPILAN DARI SHOPPING CART]]]]]]]]]]]]]]]]]]]]]]]]]]]]] -->
      <div class="row" align="center" style="opacity: 1; background-image: url(whiteback.jpg); background-position: center;
    background-repeat: no-repeat;
    background-size: cover; border-top: 2px solid white; border-bottom: 2px solid white; margin-bottom: 20px; " >  
        <form action="beli.php?action=add&id=<?php echo $row['id'];?>" method="POST">
          <h1 style="color: red; "  class=" voldemort"><?php echo $row['nama_beras']; ?> </h1> <br>
          <img style="width: 300px;" class="img-responsif " src="gambar/<?php echo $row['nama_gambar'];?>" alt="<?php echo $row['nama_beras']; ?>">
          <br><br>
          <h4><i><b>DESKRIPSI PRODUK:</b></i></h4>
          <h4 style="background-color: white;" class="ron container"> <?php echo $row['rincian']; ?></h4>
          <hr >

          <!-- <<<<<<[[[[[[[[[[BUKA[[[[[[[HARGA DALAM KOTAK MERAH -> DATA DIAMBIL DARI DATABASE]]]]]]]]]]]]]]]]] -->

          <center>

            <div class="row" style="width: 600px;  font-style: italic;  font-family: Montserrat, sans-serif;" >
              <div class="col-sm-0" style="produk: inline;"><span style="color: Red;" class="glyphicon glyphicon-tags"></span><br><h3 style="color: Red;  "><b> Rp.<?php echo $row['harga']; ?>,00/Karung</b></h3><br><br><br></div>
              
            </div>
          
              <!-- <<<<<<<[[[[[[[[[[BUKA[[[[[[[HARGA DALAM KOTAK MERAH -> DATA DIAMBIL DARI DATABASE]]]]]]]]]]]]]]]]] -->
              <!-- <<<<<<<<<[[[BUKA[[[[[[[[[HIDDEN DATA]]]]]]]]]]]] -->
              <label style="color: blue;" for="ayo"> Ayo masukkan jumlah beras (Karung): </label>
         <input id="ayo" style="width: 100px;" class="form-control" type="number" min="2" max="13" name="quantity" value="2" ><br><br><br>
         <?php 
         $username = $_SESSION['username'];
          $kerja = mysqli_query($con, "SELECT * FROM users WHERE username ='$username'");
          $roki = mysqli_fetch_assoc($kerja);
          ?>

           <label style="color: blue;" for="hape"> Ayo masukkan nomor handphone anda: </label>
         <input id="hape" style="width: 200px;" class="form-control" type="number"  name="hapeku" value="<?php echo $roki['kontak']; ?>" ><br><br><br>

            
         

           <label class="container" style="color: blue;" for="ayo"> Ayo masukkan alamat anda: </label>
         <textarea id="ayo" style="width: 500px;" class="form-control " name="alamat"  value="1" rows="5" ><?php echo $roki['alamat']; ?> </textarea>
          <input type="hidden" name="nama_beras" value="<?php echo $row['nama_beras'];?>">
          <input type="hidden" name="harga" value="<?php echo $row['harga'];?>">
              <!-- <<<<<<<<[[[[[[TUTUP[[[[[[[[[[[[[[HIDDEN DATA]]]]]]]]]]]]]]]]]]]] -->
          <br>
       

 <a href="beli.php?action=add&id=<?php echo $row['id'];?>"><input  class="btn btn-primary" type="submit" name="submit" value="Pesan"></a>

          
        </form>
        </center>

      </div>
     
      <!-- [[[[[[[[[[[[[[[[[[[[[[[[[[TAMPILAN DARI SHOPPING CART]]]]]]]]]]]]]]]]]]]]]]]]]] -->
      <?php
      endwhile;
    endif;
  endif;
   ?>

</div >
<!-- coba -->

<?php endwhile; ?> 
<!-- ---------------------------------------------- -->
<center>
  <h1 class="harry" style="color: red;"><i>
<?php 
if (isset($_COOKIE['bahagia'])) {
  # code...
  $roni = mysqli_query($con, "SELECT * FROM transaksi WHERE array= '$a'");
$ronki = mysqli_fetch_assoc($roni);

echo "Kode Order Anda  ";
echo  $ronki['kode_order'];
}
 ?>
 </center></i></h1>
 <!-- --------------------------------------  -->
<!-- <!-- // [[[[[[[[[TUTUP[[[[[[[[[[[[[[[[[[[MEMBUAT PERULANGAN
DENGAN WHILE TERHADAP DATA YANG DIAMBIL DARI DATABASE]]]]]]]]]]]] --> <!--
coba -->  <div style="clear:both;"></div>           
<br />          
 <div class="table-responsive container">         
   <table align="center" class="table">               
  <tr>
    <th colspan="5"><h3>Rincian Pembelian</h3></th>
  </tr>           
 <tr>
<th width="40%">Nama Produk</th>                
<th width="10%">Jumlah</th>
<th width="20%">Harga</th>               
 <th width="15%">Total</th>
<th width="5%">Aksi</th>           
</tr>       
    <?php
if(!empty($_SESSION['shopping_cart'] OR $c)):
             
                 # code...
             
             $total = 0;  
             
                                             if (isset($_SESSION['shopping_cart'])) {
                                                  # code...
                                                  foreach ($_SESSION['shopping_cart']  as $key => $product) {
                                                  # code...
                                                     ?>
     
                                                            <tr>  
                                                               <td><?php echo $product['nama_beras']; ?></td>  
                                                               <td><?php echo $product['quantity']; ?></td>  
                                                               <td>Rp <?php echo $product['harga']; ?></td>  
                                                               <td>Rp <?php echo($product['quantity'] * $product['harga']); ?></td>  
                                                               <td>
                                                                   <a href="belibeli.php?action=delete&id=<?php echo $product['id']; ?>">
                                                                        <div class="btn-danger">batal</div>
                                                                   </a>
                                                               </td>  
                                                            </tr>  
                                                    <?php   
                                                     
                                                      $total = $total + ($product['quantity'] * $product['harga']);  
                                                      $jumlah = $jumlah + $product['quantity'];
                                              
                                                    } 
                                                  
                                                  
                                                  
                                                }else{
                                                  foreach ($c as $key => $product) {
                                                  # code...
                                                    ?>

                                                      <tr>  
                                                               <td><?php echo $product['nama_beras']; ?></td>  
                                                               <td><?php echo $product['quantity']; ?></td>  
                                                               <td>Rp <?php echo $product['harga']; ?></td>  
                                                               <td>Rp <?php echo($product['quantity'] * $product['harga']); ?></td>  
                                                               <td>
                                                                   <a href="belibeli.php?action=delete&id=<?php echo $product['id']; ?>">
                                                                        <div class="btn-danger">Batal</div>
                                                                   </a>
                                                               </td>  
                                                            </tr>  
                                                    <?php 


                                                      $total = $total + ($product['quantity'] * $product['harga']); 
                                                        
                                                    $jumlah = $jumlah + $product['quantity']; 
                                                    } 
                                                   
                                                }
                                             
                                                ?>
        <tr>  
             <td colspan="3" align="right">Total</td>  
             <td align="right">Rp <?php echo ($total); ?> </td>  
             <td></td>  
        </tr>  
        <tr>
            <!-- Show checkout button only if the shopping cart is not empty -->
            <td colspan="5">
             <?php 
                if (isset($c)):
                if (count($c) > 0):
             ?>
                <!-- modal -->
  

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body style="opacity: 1; background-image: url(whiteback.jpg); background-position: center;
    background-repeat: no-repeat;
    background-size: cover; border-top: 2px solid white;  ">
  
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Cara Pembayaran
</button> -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Cara Pembayaran </h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <!-- ------------------------------------------------- -->
<div class="container-fluid">

  <h3 style="text-transform: capitalize;">1. Silahkan melakukan pembayaran melalui rekening kami <i><b style="color: red;">BRI:080809499343596</b></i> sesuai dengan jumlah yang tertera hingga digit terakhir. </h3>
   <h3 style="text-transform: capitalize;">2. Setelah melakukan Pembayaran, anda bisa menghubungi kami ke nomor <i><b style="color: red;">Whatsapp: 081214931944 (yanto)</b></i></h3>
</div>
<center> <h3 style="text-transform: capitalize;">3. Setelah mendapat verifikasi dari kami, Pesanan Anda akan segera kami proses. Terimakasih</h3></center>

      </div>
   

 



        <!-- ------------------------------------------------- -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
      
      </div>
    </div>
  </div>
</div>

</body>
</html>

                <!-- modal -->
                 <a href="baru.php" ><button class="btn btn-success">Kembali Halaman Awal</button></a>
             <?php endif; endif; ?>
            </td>
        </tr>
        <?php  
        endif;
        ?>  
        </table>  
         </div>
        </div>
<!-- coba -->

<center class="voldemort">  <!-- ------------------------------------------------- -->
<div class="container-fluid">

  <h3 style="text-transform: capitalize;">1. Silahkan melakukan pembayaran melalui rekening kami <i><b style="color: red;" class="harry">BRI:080809499343596</b></i> atas nama <i><b style="color: red;"class="harry">YANTO SULIS</b></i> sesuai dengan jumlah yang tertera hingga digit terakhir. </h3>
   <h3 style="text-transform: capitalize;">2. Setelah melakukan Pembayaran, anda bisa menghubungi kami ke nomor <i><b style="color: red;"class="harry">Whatsapp: 081214931944 (yanto)</b></i></h3>
</div>
<center> <h3 style="text-transform: capitalize;">3. Setelah mendapat verifikasi dari kami, Pesanan Anda akan segera kami proses. Terimakasih</h3></center>

      </div>
   

 



        <!-- ------------------------------------------------- --></center>
 
<!-- \\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\\ -->

<!-- ///////////////////////////////////////////// -->

<?php 
if (isset($_POST['submit'])) {
  # code...
$quera = mysqli_query($con, "SELECT * FROM transaksi ORDER BY id DESC");
$rowk = mysqli_fetch_assoc($quera);
$rowka = $rowk['id'];

$an =  $rowk['id']+1;


$masuk = "BRS0000$an";
// $tambah = mysqli_query($con, "INSERT INTO chart (nama_beras) VALUES('$masuk')"); 

$hape = $_POST['hapeku'];
$alamat = $_POST['alamat'];
$f= $_SESSION['shopping_cart'];
$pembeli = $_SESSION['username'];

if ($_SESSION['username'] == $rowk['pembeli']) {

        $tambah = mysqli_query($con, "UPDATE transaksi SET array = '$a',kode_order = '$masuk',handphone = '$hape',alamatnya = '$alamat',pembeli = '$pembeli', keterangan = '0' WHERE id = '$rowka' ");
                 echo "<script>alert('Terimakasih, anda telah submit'); window.location = 'belibeli.php'</script>"; 

       
       }else{
         $tambah = mysqli_query($con, "INSERT INTO transaksi(id,array,kode_order,handphone,alamatnya,pembeli) VALUES('','$a','$masuk','$hape','$alamat','$pembeli')");
         echo "<script>alert('Terimakasih, anda telah submit'); window.location = 'belibeli.php'</script>";   
       } 

}
if ($jumlah < 2) {
  # code...
   echo "<script>alert('Minimum pesanan harus 2 karung. Anda Dipersilahkan Untuk Memilih Beras lagi!');
    window.location='index.php'</script>";
}
?>
<center>
<?php


if (empty($_SESSION['shopping_cart'])) {
  # code...
   echo "<script>alert('Anda Dipersilahkan Untuk Memilih Beras');
    window.location='baru.php'</script>";
}

ob_flush();
 ?>
 </center>
</body>
</html>
