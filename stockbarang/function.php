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


#edit
if(isset($_POST['updatebarang'])){
      $idb = $_POST['idb'];
      $namabarang = $_POST['namabarang'];
      $deskripsi  = $_POST['deskripsi'];

      $update = mysqli_query($conn,"update stock set namabarang='$namabarang', deskripsi='$deskripsi' where idbarang ='$idb'");
      if($update){
        header('location:index.php');
      } else {
        echo 'Gagal';
        header('location:index.php');
      } 
}


#delete
if(isset($_POST['hapusbarang'])){
  $idb = $_POST['idb'];

  $hapus = mysqli_query($conn, "delete from stock where idbarang='$idb'");
  if($hapus){
    header('location:index.php');
    } else {
      echo 'Gagal';
      header('location:index.php');
  }
}



//mengubah data barang masuk
if(isset($_POST['updatebarangmasuk'])){

    $idb = $_POST['idb'];
    $idm = $_POST['idm'];
    $deskripsi = $_POST['keterangan'];
    $qty = $_POST['qty'];

    //cek qty sekarang
    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $qtyskrg = mysqli_query($conn, "select * from masuk where idmasuk='$idm'");
    $qtynya = mysqli_fetch_array($qtyskrg);
    $qtyskrg = $qtynya['qty'];

    if($qty > $qtyskrg){
        $selisih = $qty - $qtyskrg;
        $kurangin = $stockskrg + $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock='$stockbaru' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
        if($updatestock && $updatenya){
            header('location:masuk.php');
            } else {
                echo 'gagal';
                header('location:masuk.php');
        }

    } else {
        $selisih = $qtyskrg - $qty;
        $kurangin = $stockskrg - $selisih;
        $kuranginstocknya = mysqli_query($conn, "update stock set stock='$stockbaru' where idbarang='$idb'");
        $updatenya = mysqli_query($conn, "update masuk set qty='$qty', keterangan='$deskripsi' where idmasuk='$idm'");
        if($updatestock && $updatenya){
            header('location:masuk.php');
            } else {
                echo 'gagal';
                header('location:masuk.php');
        }

    }

}

//Menghapus barang masuk
if(isset($_POST['hapusbarangmasuk'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idm = $_POST['idm'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok-$qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from masuk where idmasuk='$idm'");

    if($update&&$hapusdata){
        header('location:masuk.php');
    }else{
        header('location:masuk.php');
    }

}



//mengubah data barang keluar
if(isset($_POST['updatebarangkeluar'])){

    $idb = $_POST['idb'];
    $idk = $_POST['idk'];
    $penerima = $_POST['penerima'];
    $qty = $_POST['qty'];

    $lihatstock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $stocknya = mysqli_fetch_array($lihatstock);
    $stockskrg = $stocknya['stock'];

    $hasilakhir = $stockskrg - $qty;
    $updateStock = mysqli_query($conn, "update stock set stock='$hasilakhir' where idbarang='$idb'");
    $updateKeluar = mysqli_query($conn, "update keluar set qty='$qty', penerima='$penerima' where idkeluar='$idk'");
    if($updateStock && $updateKeluar){
        header('location:keluar.php');
    } else {
        echo 'gagal';
        header('location:keluar.php');
    }
}


//Menghapus barang keluar
if(isset($_POST['hapusbarangkeluar'])){
    $idb = $_POST['idb'];
    $qty = $_POST['kty'];
    $idk = $_POST['idk'];

    $getdatastock = mysqli_query($conn, "select * from stock where idbarang='$idb'");
    $data = mysqli_fetch_array($getdatastock);
    $stok = $data['stock'];

    $selisih = $stok + $qty;

    $update = mysqli_query($conn, "update stock set stock='$selisih' where idbarang='$idb'");
    $hapusdata = mysqli_query($conn, "delete from keluar where idkeluar='$idk'");
          if($update&&$hapusdata){
              header('location:keluar.php');
          }else{
              header('location:keluar.php');
    }

}





?>
