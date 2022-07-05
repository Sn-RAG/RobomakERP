<?php
require __DIR__ . '/../controller/Db.php';
session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];

if (isset($_POST['StokEkle'])) {
    $Levha_Stok_ID = $_POST['Levha_Stok_ID'];
    $T_Tarihi = $_POST['T_Tarihi'];

    //Levha Stok

    $Stok_Adet = $_POST['Stok_Adet'];
    $Stok_Agirlik = $_POST['Stok_Agirlik'];

    //Sipariş Edilen

    $Adet = $_POST['SipAdet'];
    $Agirlik = $_POST['SipAgirlik'];

    //Gelen Miktar
    $GAdet = $_POST['GirAdet'];
    $GAgirlik = $_POST['GirAgirlik'];

    $TplMevcutAdet = $GAdet + $Stok_Adet;
    $TplMevcutAgirlik = $GAgirlik + $Stok_Agirlik;

    $TplAdet = $Adet - $GAdet;
    $TplAgirlik = $Agirlik - $GAgirlik;

    $StokKaydet = $baglanti->prepare("UPDATE levha_stok SET Siparis_Adet= ?, Siparis_Agirlik= ? WHERE Levha_Stok_ID= ?");
    $StokKaydet->execute(array($TplAdet, $TplAgirlik, $Levha_Stok_ID));

    if ($baglanti->query("SELECT Levha_Stok_ID FROM levha_gelen WHERE Levha_Stok_ID=" . $Levha_Stok_ID)->rowCount()) {
        //--------------------------STOĞA EKLE
        if ($baglanti->query("SELECT Teslim_Tarihi FROM levha_gelen WHERE Teslim_Tarihi='$T_Tarihi'")->rowCount()) {

            $GelenLKaydet = $baglanti->prepare("UPDATE levha_gelen SET Levha_Stok_ID= ?, Stok_Adet=Stok_Adet+?, Stok_Agirlik=Stok_Agirlik+?, Teslim_Tarihi= ?, Kullanici_ID= ? WHERE Levha_Stok_ID= ? AND Teslim_Tarihi= ?");
            $GelenLKaydet->execute(array($Levha_Stok_ID, $GAdet, $GAgirlik, $T_Tarihi, $Kullanici, $Levha_Stok_ID, "$T_Tarihi"));
        } else {
            $GelenLKaydet = $baglanti->prepare("INSERT INTO levha_gelen SET Levha_Stok_ID= ?, Stok_Adet= ?, Stok_Agirlik= ?, Teslim_Tarihi= ?, Kullanici_ID= ?");
            $GelenLKaydet->execute(array($Levha_Stok_ID, $GAdet, $GAgirlik, $T_Tarihi, $Kullanici));
        }
    } else {
        $GelenLKaydet = $baglanti->prepare("INSERT INTO levha_gelen SET Levha_Stok_ID= ?,  Stok_Adet= ?, Stok_Agirlik= ?, Teslim_Tarihi= ?, Kullanici_ID= ?");
        $GelenLKaydet->execute(array($Levha_Stok_ID, $TplMevcutAdet, $TplMevcutAgirlik, $T_Tarihi, $Kullanici));
    }
}
if (isset($_POST['Kullan'])) {
    $Levha_Stok_ID = $_POST['LevhaStokID'];
    $K_Tarihi = $_POST['KTarihi'];

    //Levha Stok

    $Stok_Adet = $_POST['KStokAdet'];
    $Stok_Agirlik = $_POST['KStokAgirlik'];

    //Kullanılan Edilen

    $KAdet = $_POST['KAdet'];
    $KAgirlik = $_POST['KAgirlik'];

    //Gelen Miktar
    $GAdet = $_POST['KGirAdet'];
    $GAgirlik = $_POST['KGirAgirlik'];

    $TplMevcutAdet = $GAdet + $KAdet;
    $TplMevcutAgirlik = $GAgirlik + $KAgirlik;


    $Say = $baglanti->query("SELECT COUNT(Levha_Stok_ID) AS a FROM levha_gelen WHERE Levha_Stok_ID=" . $Levha_Stok_ID)->fetch()["a"];
    if ($Say > 1) {
        $TplAdet = ($Stok_Adet - $GAdet) / $Say;
        $TplAgirlik = ($Stok_Agirlik - $GAgirlik) / $Say;
    } else {
        $TplAdet = $Stok_Adet - $GAdet;
        $TplAgirlik = $Stok_Agirlik - $GAgirlik;
    }
    $StokKaydet = $baglanti->prepare("UPDATE levha_gelen SET  Stok_Adet= ?, Stok_Agirlik= ? WHERE Levha_Stok_ID= ?");
    $StokKaydet->execute(array($TplAdet, $TplAgirlik, $Levha_Stok_ID));

    if ($baglanti->query("SELECT Levha_Stok_ID FROM levha_giden WHERE Levha_Stok_ID=" . $Levha_Stok_ID)->rowCount()) {

        if ($baglanti->query("SELECT Gidis_Tarihi FROM levha_giden WHERE Gidis_Tarihi='$K_Tarihi'")->rowCount()) {

            $Kaydet = $baglanti->prepare("UPDATE levha_giden SET Levha_Stok_ID= ?, Kullanilan_Adet=Kullanilan_Adet+?, Kullanilan_Agirlik=Kullanilan_Agirlik+?, Gidis_Tarihi= ?, Kullanici_ID= ? WHERE Levha_Stok_ID= ? AND Gidis_Tarihi= ?");
            $Kaydet->execute(array($Levha_Stok_ID, $GAdet, $GAgirlik, $K_Tarihi, $Kullanici, $Levha_Stok_ID, "$K_Tarihi"));
        } else {
            $Kaydet = $baglanti->prepare("INSERT INTO levha_giden SET Levha_Stok_ID= ?, Kullanilan_Adet= ?, Kullanilan_Agirlik= ?, Gidis_Tarihi= ?, Kullanici_ID= ?");
            $Kaydet->execute(array($Levha_Stok_ID, $GAdet, $GAgirlik, $K_Tarihi, $Kullanici));
        }
    } else {
        $Kaydet = $baglanti->prepare("INSERT INTO levha_giden SET Levha_Stok_ID= ?, Kullanilan_Adet= ?, Kullanilan_Agirlik= ?, Gidis_Tarihi= ?, Kullanici_ID= ?");
        $Kaydet->execute(array($Levha_Stok_ID, $TplMevcutAdet, $TplMevcutAgirlik, $K_Tarihi, $Kullanici));
    }
}