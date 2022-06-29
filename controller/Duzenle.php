<?php
require __DIR__ . '/Db.php';
require __DIR__ . '/VTHataMesaji.php';
//--------------------------------Kullanici Kim

$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];


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
    $id = $_POST['Urun_Boya_Bilgi_ID'];
    $Urun_ID = $_POST['Urun_ID'];
    $BoyaTipi = $_POST['BoyaTipi'];
    $İcAstar = $_POST['icAstar'];
    $icUstkat = $_POST['icUstkat'];
    $DisAstar = $_POST['DisAstar'];
    $DisUstkat = $_POST['DisUstkat'];
    $SetKaydet = $baglanti->prepare("UPDATE Urun_Boya_Bilgi SET Urun_ID= ?, BoyaTipi= ?, icAstar= ?, icUstkat= ?, DisAstar= ?, DisUstkat= ?, Kullanici_ID= ? WHERE Urun_Boya_Bilgi_ID= ?");
    $SonucSor = $SetKaydet->execute(array($Urun_ID, $BoyaTipi, $İcAstar, $icUstkat, $DisAstar, $DisUstkat, $Kullanici, $id));
    header("location:UrunBoyaBilgi.php?Urun_ID=$Urun_ID");
}
//---------------------////////-------------------------- Urun LEVHA Bilgisi Düzenle
if (isset($_POST['UrunLevhaBilgiDuzenle'])) {
    $id = $_POST['Urun_Levha_Bilgi_ID'];
    $Tip = $_POST['Tip'];
    $Cap = $_POST['Cap'];
    $Kalinlik = $_POST['Kalinlik'];

    $Sor = $baglanti->prepare("SELECT Levha_ID FROM levha WHERE Tip= ? AND Cap= ? AND Kalinlik= ?");
    $Sor->execute(array($Tip, $Cap, $Kalinlik));
    if($Sor->rowCount()){
        $Levha_ID = $Sor->fetch()['Levha_ID'];
    }else{
        $Kaydet = $baglanti->prepare("INSERT INTO levha SET Tip= ?, Cap= ?, Kalinlik= ?");
        $Kaydet->execute(array($Tip, $Cap, $Kalinlik));
        $Levha_ID = $baglanti->lastInsertId();
    }
    $Kaydet = $baglanti->prepare("UPDATE urun_levha_bilgi SET Levha_ID= ?, Kullanici_ID= ? WHERE Urun_Levha_Bilgi_ID= ?");
    $SonucSor = $Kaydet->execute(array($Levha_ID, $Kullanici, $id));
    header("location:UrunLevhaBilgi.php?Urun_ID=$_POST[Urun_ID]");
}
