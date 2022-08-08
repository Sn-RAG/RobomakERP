<?php
require __DIR__ . '/Db.php';
require __DIR__ . '/VTHataMesaji.php';
require __DIR__ . "/../logtut.php";
//--------------------------------Kullanici Kim

$Sor = $baglanti->query("SELECT Kullanici_ID FROM kullanici WHERE Kadi='$_SESSION[Kullanici]'");
$Kullanici = $Sor->fetch()['Kullanici_ID'];

//----------------------------------------------- Urun Düzenle
if (isset($_POST['UrunDuzenle'])) {
    $Resim = $_POST['UrunFoto'];
    $UrunAdi = $_POST['UrunAdi'];
    $Urun_ID = $_POST['Urun_ID'];
    $Aciklama = $_POST['Aciklama'];
    $Kategori_ID = $_POST['Kategori_ID'];

    //if ($Resim != "") {

    $Duzenle = $baglanti->prepare("UPDATE urun SET Kategori_ID= ?, UrunAdi= ?, UrunFoto= ?, Aciklama= ? WHERE Urun_ID= ?");
    $Duzenle->execute(array($Kategori_ID, $UrunAdi, $Resim, $Aciklama, $Urun_ID));
    header("location:Urunler.php");

    /* } else {
         move_uploaded_file($_FILES['Resim']['tmp_name'], __DIR__ . '/../assets/img/Keksan/' . $_FILES["Resim"]['name']);
         $ResimYeni = $_FILES["Resim"]["name"];

         $Duzenle = $baglanti->prepare("UPDATE urun SET Kategori_ID= ?, UrunAdi= ?, UrunFoto= ?, Aciklama= ? WHERE Urun_ID= ?");
         $Duzenle->execute(array($Kategori_ID, $UrunAdi, $ResimYeni, $Aciklama, $Urun_ID));
     }*/
}
//----------------------------------------------- Urun BOYA Bilgisi Düzenle
if (isset($_POST['UrunBoyaBilgiDuzenle'])) {
    $Uid = $_POST['Urun_ID'];

    $Bid = $_POST["Bid"];
    $sor = $baglanti->query("SELECT * FROM boya WHERE Boya_ID=" . $Bid);
    if ($sor->rowCount()) {
        $Bid = $sor->fetch()["Boya_ID"];
    } else {
        echo "<script>" . $KayitAcilmamis . "</script>";
        return;
    }
    $SetKaydet = $baglanti->prepare("UPDATE urun_boya_bilgi SET Urun_ID= ?, Boya_ID= ?, icAstar= ?, icUstkat= ?, DisAstar= ?, DisUstkat= ?, Kullanici_ID= ? WHERE Urun_Boya_Bilgi_ID= ?");
    $SonucSor = $SetKaydet->execute(array($Uid, $Bid, $_POST['icAstar'], $_POST['icUstkat'], $_POST['DisAstar'], $_POST['DisUstkat'], $Kullanici, $_POST['Urun_Boya_Bilgi_ID']));

    logtut($Kullanici, "Ürünün boya verisini düzenledi.");
    header("location:UrunBoyaBilgi.php?Urun_ID=$Uid");
}
//---------------------////////-------------------------- Urun LEVHA Bilgisi Düzenle
if (isset($_POST['UrunLevhaBilgiDuzenle'])) {
    $id = $_POST['Urun_Levha_Bilgi_ID'];
    $T = $_POST['Tip'];
    $C = $_POST['Cap'];
    $C2 = $_POST['Cap2'];
    $K = $_POST['Kalinlik'];
    $bak = $T == "DikDörtgen" ? " AND Cap2='$C2'" : "";
    $EKLE = $T == "DikDörtgen" ? $C2 : null;

    $Sor = $baglanti->query("SELECT Levha_ID FROM levha WHERE Tip='$T' AND Cap='$C' AND Kalinlik='$K'" . $bak);
    if ($Sor->rowCount()) {
        $Lid = $Sor->fetch()['Levha_ID'];
    } else {
        echo "<script>" . $KayitAcilmamis . "</script>";
        return;
    }
    $Kaydet = $baglanti->prepare("UPDATE urun_levha_bilgi SET Levha_ID= ?, Kullanici_ID= ? WHERE Urun_Levha_Bilgi_ID= ?");
    $SonucSor = $Kaydet->execute(array($Lid, $Kullanici, $id));
    header("location:UrunLevhaBilgi.php?Urun_ID=$_POST[Urun_ID]");
    logtut($Kullanici, "Ürünün levha verisini düzenledi.");
}
