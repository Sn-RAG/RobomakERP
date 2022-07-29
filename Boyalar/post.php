<?php
require __DIR__ . '/../controller/Db.php';
//--------------------------------Kullanici Kim
session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];

if (isset($_POST['Gelen'])) {
    $Stokid = (int)$_POST['BoyaStokID'];
    $TT = $_POST['T_Tarihi'];
    $GirMiktar = (int)$_POST['GirMiktar'];
    $BoyaID = (int)$_POST['BoyaID'];

    $Say = $baglanti->query("SELECT COUNT(Boya_Stok_ID) AS a FROM boya_gelen WHERE Boya_Stok_ID=" . $Stokid)->fetch()["a"];
    if ($Say > 1) {
        $TplMiktar = ($Stok - $Deger) / $Say;
    } else {
        $TplMiktar = $Stok - $Deger;
    }

    $StokKaydet = $baglanti->prepare("UPDATE boya_stok SET Siparis_Miktar= ? WHERE Boya_Stok_ID= ?");
    $StokKaydet->execute(array($TplMiktar, $Stokid));

    if ($baglanti->query("SELECT Boya_Stok_ID FROM boya_gelen WHERE Teslim_Tarihi='$TT' AND Boya_Stok_ID=" . $Stokid)->rowCount()) {
        $GelenLKaydet = $baglanti->prepare("UPDATE boya_gelen SET Boya_Stok_ID= ?, Stok_Miktar= Stok_Miktar+?,  Teslim_Tarihi= ?, Kullanici_ID= ?, Boya_ID= ? WHERE Boya_Stok_ID= ? AND Teslim_Tarihi= ?");
        $GelenLKaydet->execute(array($Stokid, $GirMiktar, $TT, $Kullanici, $BoyaID, $Stokid, "$TT"));
    } else {
        $GelenLKaydet = $baglanti->prepare("INSERT INTO boya_gelen SET Boya_Stok_ID= ?,  Stok_Miktar= ?, Teslim_Tarihi= ?, Kullanici_ID= ?, Boya_ID= ?");
        $GelenLKaydet->execute(array($Stokid, $GirMiktar, $TT, $Kullanici, $BoyaID));
    }

    ////////   //////////// // Üretim Tarihini Ekle

    $UrT = $baglanti->prepare("SELECT Boya_Tarih_ID FROM boya_tarih WHERE Uretim_T= ?");
    $UrT->execute(array($_POST['Uretim_T']));
    if ($UrT->rowCount()) {
        $UretimT = $UrT->fetch()["Boya_Tarih_ID"];
    } else {
        $UT = $baglanti->prepare("INSERT INTO boya_tarih SET Uretim_T= ?");
        $UT->execute(array($_POST['Uretim_T']));
        $UretimT = $baglanti->lastInsertId();
    }

    $SiparisTarih = $baglanti->prepare("UPDATE boya_siparis SET Boya_Tarih_ID= ? WHERE Boya_Siparis_ID= ?");
    $SiparisTarih->execute(array($UretimT, (int)$_POST['Sipid']));


    ##############################################################################################################################################################################

} elseif (isset($_POST['Kullan'])) {
    $Stokid = (int)$_POST['KBoyaStokID'];
    $KT = $_POST['Kullanma_T'];

    //Boya Stok
    $StokMiktar = (int)$_POST['KStokMiktar'];

    //Gelen Miktar
    $GirMiktar = (int)$_POST['KGirMiktar'];


    $TplMiktar = $StokMiktar - $GirMiktar;

    $StokKaydet = $baglanti->prepare("UPDATE boya_gelen SET  Stok_Miktar= ? WHERE Boya_Stok_ID= ?");
    $StokKaydet->execute(array($TplMiktar, $Stokid));

    if ($baglanti->query("SELECT Boya_Stok_ID FROM boya_giden WHERE  Gidis_Tarihi='$KT' AND Boya_Stok_ID=" . $Stokid)->rowCount()) {
        $Kaydet = $baglanti->prepare("UPDATE boya_giden SET Boya_Stok_ID= ?, Kullanilan_Miktar= Kullanilan_Miktar+?, Gidis_Tarihi= ?, Kullanici_ID= ? WHERE Boya_Stok_ID= ? AND Gidis_Tarihi=?");
        $Kaydet->execute(array($Stokid, $GirMiktar, $KT, $Kullanici, $Stokid, "$KT"));
    } else {
        $Kaydet = $baglanti->prepare("INSERT INTO boya_giden SET Boya_Stok_ID= ?, Kullanilan_Miktar= ?, Gidis_Tarihi= ?, Kullanici_ID= ?");
        $Kaydet->execute(array($Stokid, $GirMiktar, $KT, $Kullanici));
    }
} elseif (isset($_POST["StkID"])) {
    $S = $_POST["StkID"];
    $M = $_POST["iMiktar"];
    $k = $baglanti->prepare("UPDATE boya_stok SET Siparis_Miktar=Siparis_Miktar-?,iade_Miktar= ? WHERE Boya_Stok_ID= ?");
    $k->execute(array($M, $M, $S));
} elseif (isset($_POST["EStkID"])) {
    $S = $_POST["EStkID"];
    $M = $_POST["EMiktar"];

    $k = $baglanti->prepare("UPDATE boya_stok SET Siparis_Miktar=Siparis_Miktar-?,Emanet_Miktar= ? WHERE Boya_Stok_ID= ?");
    $k->execute(array($M, $M, $S));
}
