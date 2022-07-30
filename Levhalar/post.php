<?php
require __DIR__ . '/../controller/Db.php';
require __DIR__ . "/../logtut.php";
session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];

if (isset($_POST['StokEkle'])) {
    $id = $_POST['Levha_Stok_ID'];
    $LevhaID = $_POST['LevhaID'];
    $TT = $_POST['T_Tarihi'];

    $Tamam = $_POST['Tamam'];

    $GAdet = $_POST['GirAdet'];
    $GAgirlik = $_POST['GirAgirlik'];

    $StokKaydet = $baglanti->prepare("UPDATE levha_stok SET Siparis_Adet=Siparis_Adet-?, Siparis_Agirlik=Siparis_Agirlik-?, Durum=? WHERE LevhaID= ?");
    $StokKaydet->execute(array($GAdet, $GAgirlik, $Tamam, $LevhaID));

    if ($baglanti->query("SELECT Levha_Stok_ID FROM levha_gelen WHERE  Teslim_Tarihi='$TT' AND LevhaID=" . $LevhaID)->rowCount()) {
        $GelenLKaydet = $baglanti->prepare("UPDATE levha_gelen SET Levha_Stok_ID= ?, Stok_Adet=Stok_Adet+?, Stok_Agirlik=Stok_Agirlik+?, Teslim_Tarihi= ?, Kullanici_ID= ? WHERE LevhaID= ? AND Teslim_Tarihi= ?");
        $GelenLKaydet->execute(array($id, $GAdet, $GAgirlik, $TT, $Kullanici, $LevhaID, "$TT"));
    } else {
        $GelenLKaydet = $baglanti->prepare("INSERT INTO levha_gelen SET Levha_Stok_ID= ?, LevhaID=?, Stok_Adet= ?, Stok_Agirlik= ?, Teslim_Tarihi= ?, Kullanici_ID= ?");
        $GelenLKaydet->execute(array($id, $LevhaID, $GAdet, $GAgirlik, $TT, $Kullanici));
    }
    /*LOG KAYDI*/

    logtut($Kullanici, "Stoğa levha ekledi.");

    /*LOG KAYDI SON*/
}
if (isset($_POST['Kullan'])) {
    $id = $_POST['LevhaStokID'];
    $KT = $_POST['KTarihi'];

    //Stok
    $Stok_Adet = $_POST['KStokAdet'];
    $Stok_Agirlik = $_POST['KStokAgirlik'];

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
    logtut($Kullanici, "Levha kullandı.");
}
