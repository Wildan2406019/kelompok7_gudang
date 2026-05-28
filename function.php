<?php
$conn = mysqli_connect("localhost", "root", "", "stockbarang");

if(isset($_POST['addnewbarang'])){
  $namabarang = $_POST['namabarang'];
  $deskripsi = $_POST['deskripsi'];
  $stock = $_POST['stock'];

  $addtotable = mysqli_query($conn,
  "INSERT INTO stock (namabarang, deskripsi, stock)
  VALUES ('$namabarang', '$deskripsi', '$stock')");
  if($addtotable){
    header('location: index.php');
  } else {
    echo 'Gagal';
    header('location: index.php');
  }
};

#menambah barang masuk
if(isset($_POST['barangmasuk'])){
  $barangnya = $_POST['barangnya'];
  $keterangan = $_POST['keterangan'];
  $qty = $_POST['qty'];
  $cekstoksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
  $ambildatanya = mysqli_fetch_array($cekstoksekarang);
  $stoksekarang = $ambildatanya['stock'];
  $tambahkanstocksekarangdenganquantity = $stoksekarang + $qty;

  $addtomasuk = mysqli_query($conn,
  "INSERT INTO masuk (idbarang, keterangan, qty) 
  values('$barangnya','$keterangan','$qty')");

  $updatestokmasuk = mysqli_query($conn, "UPDATE stock SET stock = $tambahkanstocksekarangdenganquantity WHERE idbarang = '$barangnya'");
  if($addtomasuk&&$updatestokmasuk){
    header('location: masuk.php');
  } else {
    echo 'Gagal';
    header('location: masuk.php');
  }
};

#menambah barang keluar
if(isset($_POST['addbarangkeluar'])){
  $barangnya = $_POST['barangnya'];
  $penerima = $_POST['penerima'];
  $qty = $_POST['qty'];
  $cekstoksekarang = mysqli_query($conn, "SELECT * FROM stock WHERE idbarang='$barangnya'");
  $ambildatanya = mysqli_fetch_array($cekstoksekarang);
  $stoksekarang = $ambildatanya['stock'];
  $kurangistoksekarangdenganquantity = $stoksekarang - $qty;

  $addtokeluar = mysqli_query($conn,
  "INSERT INTO keluar (idbarang, penerima, qty) 
  values('$barangnya','$penerima','$qty')");

  $updatestokkeluar = mysqli_query($conn, "UPDATE stock SET stock = $kurangistoksekarangdenganquantity WHERE idbarang = '$barangnya'");
  if($addtokeluar&&$updatestokkeluar){
    header('location: keluar.php');
  } else {
    echo 'Gagal';
    header('location: keluar.php');
  }
};

?>
