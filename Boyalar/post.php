<?php
require __DIR__ . '/../controller/Db.php';
//--------------------------------Kullanici Kim
session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];

if (isset($_POST['Gelen'])) {
    $Boya_Stok_ID = (int)$_POST['BoyaStokID'];
    $TT = $_POST['T_Tarihi'];
    $StokMiktar = (int)$_POST['StokMiktar'];
    $SipMiktar = (int)$_POST['SipMiktar'];
    $GirMiktar = (int)$_POST['GirMiktar'];

    $TplMevcutMiktar = $GirMiktar + $StokMiktar;

    $TplMiktar = $SipMiktar - $GirMiktar;

    $StokKaydet = $baglanti->prepare("UPDATE boya_stok SET Siparis_Miktar= ? WHERE Boya_Stok_ID= ?");
    $StokKaydet->execute(array($TplMiktar, $Boya_Stok_ID));

    $Varmi = $baglanti->query("SELECT Boya_Stok_ID FROM boya_gelen WHERE Boya_Stok_ID=" . $Boya_Stok_ID);
    if ($Varmi->rowCount()) {
        $VarmiT = $baglanti->prepare("SELECT Teslim_Tarihi FROM boya_gelen WHERE Teslim_Tarihi= ?");
        $VarmiT->execute(array($TT));
        //--------------------------STOĞA EKLE
        if ($VarmiT->rowCount()) {
            $GelenLKaydet = $baglanti->prepare("UPDATE boya_gelen SET Boya_Stok_ID= ?, Stok_Miktar= Stok_Miktar+?,  Teslim_Tarihi= ?, Kullanici_ID= ? WHERE Boya_Stok_ID= ? AND Teslim_Tarihi= ?");
            $GelenLKaydet->execute(array($Boya_Stok_ID, $GirMiktar, $TT, $Kullanici, $Boya_Stok_ID, "$TT"));
        } else {
            $GelenLKaydet = $baglanti->prepare("INSERT INTO boya_gelen SET Boya_Stok_ID= ?, Stok_Miktar= ?, Teslim_Tarihi= ?, Kullanici_ID= ?");
            $GelenLKaydet->execute(array($Boya_Stok_ID, $GirMiktar, $TT, $Kullanici));
        }
    } else {
        $GelenLKaydet = $baglanti->prepare("INSERT INTO boya_gelen SET Boya_Stok_ID= ?,  Stok_Miktar= ?, Teslim_Tarihi= ?, Kullanici_ID= ?");
        $GelenLKaydet->execute(array($Boya_Stok_ID, $TplMevcutMiktar, $TT, $Kullanici));
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
    $Boya_Stok_ID = (int)$_POST['KBoyaStokID'];
    $K_Tarihi = $_POST['Kullanma_T'];

    //Boya Stok

    $StokMiktar = (int)$_POST['KStokMiktar'];

    //Kullanılmış

    $K_Miktar = (int)$_POST['K_Miktar'];

    //Gelen Miktar
    $GirMiktar = (int)$_POST['KGirMiktar'];

    $TplMevcutMiktar = $GirMiktar + $K_Miktar;

    $TplMiktar = $StokMiktar - $GirMiktar;

    $StokKaydet = $baglanti->prepare("UPDATE boya_gelen SET  Stok_Miktar= ? WHERE Boya_Stok_ID= ?");
    $StokKaydet->execute(array($TplMiktar, $Boya_Stok_ID));

    $Varmi = $baglanti->query("SELECT Boya_Stok_ID FROM boya_giden WHERE Boya_Stok_ID=" . $Boya_Stok_ID);
    if ($Varmi->rowCount()) {
        $VarmiT = $baglanti->prepare("SELECT Gidis_Tarihi FROM boya_giden WHERE Gidis_Tarihi= ?");
        $VarmiT->execute(array($K_Tarihi));
        if ($VarmiT->rowCount()) {
            $Kaydet = $baglanti->prepare("UPDATE boya_giden SET Boya_Stok_ID= ?, Kullanilan_Miktar= Kullanilan_Miktar+?, Gidis_Tarihi= ?, Kullanici_ID= ? WHERE Boya_Stok_ID= ? AND Gidis_Tarihi=?");
            $Kaydet->execute(array($Boya_Stok_ID, $GirMiktar, $K_Tarihi, $Kullanici, $Boya_Stok_ID, "$K_Tarihi"));
        } else {
            $Kaydet = $baglanti->prepare("INSERT INTO boya_giden SET Boya_Stok_ID= ?, Kullanilan_Miktar= ?, Gidis_Tarihi= ?, Kullanici_ID= ?");
            $Kaydet->execute(array($Boya_Stok_ID, $GirMiktar, $K_Tarihi, $Kullanici));
        }
    } else {
        $Kaydet = $baglanti->prepare("INSERT INTO boya_giden SET Boya_Stok_ID= ?, Kullanilan_Miktar= ?, Gidis_Tarihi= ?, Kullanici_ID= ?");
        $Kaydet->execute(array($Boya_Stok_ID, $TplMevcutMiktar, $K_Tarihi, $Kullanici));
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
