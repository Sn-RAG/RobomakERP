<?php
require __DIR__ . '/../../controller/Db.php';

//--------------------------------Kullanici Kim
session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];

if (isset($_POST['StokEkle'])) {
    $Kulp_Stok_ID = (int)$_POST['KulpStokID'];
    $T_Tarihi = $_POST['T_Tarihi'];

//Kulp Stok

    $StokAdet = (int)$_POST['StokAdet'];

//Sipariş Edilen

    $SipAdet = (int)$_POST['SipAdet'];

//Gelen Adet
    $GirAdet = (int)$_POST['GirAdet'];

    $TplMevcutAdet = $GirAdet + $StokAdet;

    $TplAdet = $SipAdet - $GirAdet;

    $StokKaydet = $baglanti->prepare("UPDATE kulp_stok SET Siparis_Adet= ? WHERE Kulp_Stok_ID= ?");
    $StokKaydet->execute(array($TplAdet, $Kulp_Stok_ID));

    $Varmi = $baglanti->query("SELECT Kulp_Stok_ID FROM kulp_gelen WHERE Kulp_Stok_ID=" . $Kulp_Stok_ID);
    if ($Varmi->rowCount()) {
        $VarmiT = $baglanti->prepare("SELECT Teslim_Tarihi FROM kulp_gelen WHERE Teslim_Tarihi= ?");
        $VarmiT->execute(array($T_Tarihi));
//--------------------------STOĞA EKLE
        if ($VarmiT->rowCount()) {
            $GelenLKaydet = $baglanti->prepare("UPDATE kulp_gelen SET Kulp_Stok_ID= ?, Stok_Adet= ?,  Teslim_Tarihi= ?, Kullanici_ID= ? WHERE Kulp_Stok_ID= ? AND Teslim_Tarihi= ?");
            $GelenLKaydet->execute(array($Kulp_Stok_ID, $TplMevcutAdet, $T_Tarihi, $Kullanici, $Kulp_Stok_ID, "$T_Tarihi"));
        } else {
            $GelenLKaydet = $baglanti->prepare("INSERT INTO kulp_gelen SET Kulp_Stok_ID= ?, Stok_Adet= ?, Teslim_Tarihi= ?, Kullanici_ID= ?");
            $GelenLKaydet->execute(array($Kulp_Stok_ID, $GirAdet, $T_Tarihi, $Kullanici));
        }
    } else {
        $GelenLKaydet = $baglanti->prepare("INSERT INTO kulp_gelen SET Kulp_Stok_ID= ?,  Stok_Adet= ?, Teslim_Tarihi= ?, Kullanici_ID= ?");
        $GelenLKaydet->execute(array($Kulp_Stok_ID, $TplMevcutAdet, $T_Tarihi, $Kullanici));
    }


    ##############################################################################################################################################################################

} elseif (isset($_POST['KulpKullan'])) {
    $Kulp_Stok_ID = (int)$_POST['KulpStokID'];
    $K_Tarihi = $_POST['Kullanma_T'];


//Kulp Stok

    $StokAdet = (int)$_POST['StokAdet'];

//Kullanılmış

    $K_Adet = (int)$_POST['K_Adet'];

//Gelen Adet
    $GirAdet = (int)$_POST['GirAdet'];

    $TplMevcutAdet = $GirAdet + $K_Adet;

    $TplAdet = $StokAdet - $GirAdet;


    $StokKaydet = $baglanti->prepare("UPDATE kulp_gelen SET  Stok_Adet= ? WHERE Kulp_Stok_ID= ?");
    $StokKaydet->execute(array($TplAdet, $Kulp_Stok_ID));

    $Varmi = $baglanti->query("SELECT Kulp_Stok_ID FROM kulp_giden WHERE Kulp_Stok_ID=" . $Kulp_Stok_ID);
    if ($Varmi->rowCount()) {
        $VarmiT = $baglanti->prepare("SELECT Gidis_Tarihi FROM kulp_giden WHERE Gidis_Tarihi= ?");
        $VarmiT->execute(array($K_Tarihi));
        if ($VarmiT->rowCount()) {

            $Kaydet = $baglanti->prepare("UPDATE kulp_giden SET Kulp_Stok_ID= ?, Kullanilan_Adet= ?, Gidis_Tarihi= ?, Kullanici_ID= ? WHERE Kulp_Stok_ID= ? AND Gidis_Tarihi= ?");
            $Kaydet->execute(array($Kulp_Stok_ID, $TplMevcutAdet, $K_Tarihi, $Kullanici, $Kulp_Stok_ID, "$K_Tarihi"));

        } else {
            $Kaydet = $baglanti->prepare("INSERT INTO kulp_giden SET Kulp_Stok_ID= ?, Kullanilan_Adet= ?, Gidis_Tarihi= ?, Kullanici_ID= ?");
            $Kaydet->execute(array($Kulp_Stok_ID, $GirAdet, $K_Tarihi, $Kullanici));
        }
    } else {
        $Kaydet = $baglanti->prepare("INSERT INTO kulp_giden SET Kulp_Stok_ID= ?, Kullanilan_Adet= ?, Gidis_Tarihi= ?, Kullanici_ID= ?");
        $Kaydet->execute(array($Kulp_Stok_ID, $TplMevcutAdet, $K_Tarihi, $Kullanici));
    }
}