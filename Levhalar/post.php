<?php
require __DIR__ . '/../controller/Db.php';
session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];

if (isset($_POST['StokEkle'])) {
    $id = $_POST['Levha_Stok_ID'];
    $TT = $_POST['T_Tarihi'];

    $Stok_Adet = $_POST['Stok_Adet'];
    $Stok_Agirlik = $_POST['Stok_Agirlik'];

    $Adet = $_POST['SipAdet'];
    $Agirlik = $_POST['SipAgirlik'];

    $GAdet = $_POST['GirAdet'];
    $GAgirlik = $_POST['GirAgirlik'];

    $TplAdet = $Adet - $GAdet;
    $TplAgirlik = $Agirlik - $GAgirlik;

    $StokKaydet = $baglanti->prepare("UPDATE levha_stok SET Siparis_Adet= ?, Siparis_Agirlik= ? WHERE Levha_Stok_ID= ?");
    $StokKaydet->execute(array($TplAdet, $TplAgirlik, $id));

    if ($baglanti->query("SELECT Levha_Stok_ID FROM levha_gelen WHERE  Teslim_Tarihi='$TT' AND Levha_Stok_ID=" . $id)->rowCount()) {
        $GelenLKaydet = $baglanti->prepare("UPDATE levha_gelen SET Levha_Stok_ID= ?, Stok_Adet=Stok_Adet+?, Stok_Agirlik=Stok_Agirlik+?, Teslim_Tarihi= ?, Kullanici_ID= ? WHERE Levha_Stok_ID= ? AND Teslim_Tarihi= ?");
        $GelenLKaydet->execute(array($id, $GAdet, $GAgirlik, $TT, $Kullanici, $id, "$TT"));
    } else {
        $GelenLKaydet = $baglanti->prepare("INSERT INTO levha_gelen SET Levha_Stok_ID= ?,  Stok_Adet= ?, Stok_Agirlik= ?, Teslim_Tarihi= ?, Kullanici_ID= ?");
        $GelenLKaydet->execute(array($id, $GAdet, $GAgirlik, $TT, $Kullanici));
    }
}
if (isset($_POST['Kullan'])) {
    $id = $_POST['LevhaStokID'];
    $KT = $_POST['KTarihi'];

    //Stok
    $Stok_Adet = $_POST['KStokAdet'];
    $Stok_Agirlik = $_POST['KStokAgirlik'];

    //Kullanılan
    $KAdet = $_POST['KAdet'];
    $KAgirlik = $_POST['KAgirlik'];

    //Girilen
    $GAdet = $_POST['KGirAdet'];
    $GAgirlik = $_POST['KGirAgirlik'];

    $Say = $baglanti->query("SELECT COUNT(Levha_Stok_ID) AS a FROM levha_gelen WHERE Levha_Stok_ID=" . $id)->fetch()["a"];
    if ($Say > 1) {
        $TplAdet = ($Stok_Adet - $GAdet) / $Say;
        $TplAgirlik = ($Stok_Agirlik - $GAgirlik) / $Say;
    } else {
        $TplAdet = $Stok_Adet - $GAdet;
        $TplAgirlik = $Stok_Agirlik - $GAgirlik;
    }
    $StokKaydet = $baglanti->prepare("UPDATE levha_gelen SET  Stok_Adet= ?, Stok_Agirlik= ? WHERE Levha_Stok_ID= ?");
    $StokKaydet->execute(array($TplAdet, $TplAgirlik, $id));

    if ($baglanti->query("SELECT Levha_Stok_ID FROM levha_giden WHERE Gidis_Tarihi='$KT' AND Levha_Stok_ID=" . $id)->rowCount()) {

        $Kaydet = $baglanti->prepare("UPDATE levha_giden SET Levha_Stok_ID= ?, Kullanilan_Adet=Kullanilan_Adet+?, Kullanilan_Agirlik=Kullanilan_Agirlik+?, Gidis_Tarihi= ?, Kullanici_ID= ? WHERE Levha_Stok_ID= ? AND Gidis_Tarihi= ?");
        $Kaydet->execute(array($id, $GAdet, $GAgirlik, $KT, $Kullanici, $id, "$KT"));
    } else {
        $Kaydet = $baglanti->prepare("INSERT INTO levha_giden SET Levha_Stok_ID= ?, Kullanilan_Adet= ?, Kullanilan_Agirlik= ?, Gidis_Tarihi= ?, Kullanici_ID= ?");
        $Kaydet->execute(array($id, $GAdet, $GAgirlik, $KT, $Kullanici));
    }
}
