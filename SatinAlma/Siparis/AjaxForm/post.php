<?php
require __DIR__ . '/../../../controller/Db.php';
session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$Kullanici = $SorKullanici->fetch()['Kullanici_ID'];
if (isset($_POST['BoyaEkle'])) {
    $query = $baglanti->prepare('SELECT * FROM boya WHERE Marka=? AND Renk=? AND Seri=? AND Kod=?');
    $query->execute(array($_POST['Marka'], $_POST['Renk'], $_POST['Seri'], $_POST['Kod']));
    if ($query->rowCount()){
        echo "var";
    }else {
        $query = $baglanti->prepare('INSERT INTO boya SET Marka=?, Renk=?, Seri=?, Kod=?');
        $query->execute(array($_POST['Marka'], $_POST['Renk'], $_POST['Seri'], $_POST['Kod']));
    }
} elseif (isset($_POST['BoyaDuzenle'])) {
    $query = $baglanti->prepare('UPDATE boya SET Marka=?, Renk=?, Seri=?, Kod=? WHERE Boya_ID=?');
    $query->execute(array($_POST['DMarka'], $_POST['DRenk'], $_POST['DSeri'], $_POST['DKod'],$_POST['DBoyaID']));

}elseif (isset($_POST['BoyaSiparis'])) {

    for( $i=0; $i < count($_SESSION["Boyalar"]); $i++ ){
    //--------------------------STOĞA EKLE
    $StokKaydet = $baglanti->prepare("INSERT INTO boya_stok SET Siparis_Miktar= ?");
    $StokKaydet->execute(array($_SESSION["Miktar"][$i]));
    $StokID = $baglanti->lastInsertId();

    $Siparis = $baglanti->prepare("INSERT INTO siparis SET Siparis= ?, Adet= ?, Agirlik= ?, S_Tarihi= ?, Kullanici_ID= ?");
    $Siparis->execute(array("Boya", 0, $_SESSION["Miktar"][$i], $_POST['S_Tarihi'], $Kullanici));
    $Siparis_ID = $baglanti->lastInsertId();

    $UrT = $baglanti->prepare("SELECT Boya_Tarih_ID FROM boya_tarih WHERE Uretim_T= ?");
    $UrT->execute(array("0000-00-00"));
    if ($UrT->rowCount()) {
        $UretimT = $UrT->fetch()["Boya_Tarih_ID"];
    } else {
        $UT = $baglanti->prepare("INSERT INTO boya_tarih SET Uretim_T= ?");
        $UT->execute(array("0000-00-00"));
        $UretimT = $baglanti->lastInsertId();
    }

    $siparisKaydet = $baglanti->prepare("INSERT INTO boya_siparis SET Boya_ID= ?, Boya_Tarih_ID= ?, Boya_Stok_ID= ?, Siparis_ID= ?");
    $siparisKaydet->execute(array($_SESSION["Boyalar"][$i], $UretimT, $StokID, $Siparis_ID));
    }

//##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
//##########      ####################      ###################               LEVHA              ####################      ####################      ####################      ##########
//##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

} elseif (isset($_POST['LevhaEkle'])) {

    $query = $baglanti->prepare('INSERT INTO levha SET Firma_ID=?, Tip=?, Cap=?, Kalinlik=?');
    $query->execute(array($_POST['LevhaFirma'] == "" ? null : $_POST['LevhaFirma'], $_POST['Tip'], number_format((float)$_POST['Cap'], 2, '.', ''),  number_format((float)$_POST['Kalinlik'], 2, '.', '')));

} elseif (isset($_POST['LevhaSiparis'])) {

    $LevhaID = $_POST['LevhaID'];
    $Adet = $_POST['LAdet'];
    $Agirlik = $_POST['LAgirlik'];
    $S_Tarihi = $_POST['LSTarihi'];
//--------------------------STOĞA EKLE
    $StokKaydet = $baglanti->prepare("INSERT INTO levha_stok SET Siparis_Adet= ?, Siparis_Agirlik= ?");
    $StokKaydet->execute(array($Adet, $Agirlik));
    $StokID = $baglanti->lastInsertId();

//--------------------------Sipariş EKLE
    $Siparis = $baglanti->prepare("INSERT INTO siparis SET Siparis= ?, Adet= ?, Agirlik= ?, S_Tarihi= ?, Kullanici_ID= ?");
    $Siparis->execute(array("Levha", $Adet, $Agirlik, $S_Tarihi, $Kullanici));
    $Siparis_ID = $baglanti->lastInsertId();

//--------------------------Levha Sipariş EKLE
    $siparisKaydet = $baglanti->prepare("INSERT INTO levha_siparis SET Levha_Stok_ID= ?, Siparis_ID= ?, Levha_ID= ?");
    $siparisKaydet->execute(array($StokID, $Siparis_ID, $LevhaID));
}

