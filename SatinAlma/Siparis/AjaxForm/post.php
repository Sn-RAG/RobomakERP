<?php
require __DIR__ . '/../../../controller/Db.php';
session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$Kullanici = $SorKullanici->fetch()['Kullanici_ID'];
if (isset($_POST['BoyaEkle'])) {
    $query = $baglanti->prepare('SELECT * FROM boya WHERE Marka=? AND Renk=? AND Seri=? AND Kod=?');
    $query->execute(array($_POST['Marka'], $_POST['Renk'], $_POST['Seri'], $_POST['Kod']));
    if ($query->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('INSERT INTO boya SET Marka=?, Renk=?, Seri=?, Kod=?');
        $query->execute(array($_POST['Marka'], $_POST['Renk'], $_POST['Seri'], $_POST['Kod']));
    }
} elseif (isset($_POST['BoyaDuzenle'])) {
    $query = $baglanti->prepare('UPDATE boya SET Marka=?, Renk=?, Seri=?, Kod=? WHERE Boya_ID=?');
    $query->execute(array($_POST['DMarka'], $_POST['DRenk'], $_POST['DSeri'], $_POST['DKod'], $_POST['DBoyaID']));
} elseif (isset($_POST['BoyaSiparis'])) {
    $b = $_SESSION["Boyalar"];
    $m = $_SESSION["Miktar"];
    for ($i = 0; $i < count($b); $i++) {
        //--------------------------STOĞA EKLE
        $StokKaydet = $baglanti->prepare("INSERT INTO boya_stok SET Siparis_Miktar= ?");
        $StokKaydet->execute(array($m[$i]));
        $StokID = $baglanti->lastInsertId();

        $Siparis = $baglanti->prepare("INSERT INTO siparis SET Siparis= ?, Adet= ?, Agirlik= ?, S_Tarihi= ?, Kullanici_ID= ?");
        $Siparis->execute(array("Boya", 0, $m[$i], $_POST['S_Tarihi'], $Kullanici));
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
        $siparisKaydet->execute(array($b[$i], $UretimT, $StokID, $Siparis_ID));
    }

    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               LEVHA              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

} elseif (isset($_POST['LevhaEklee'])) {
    $T = $_POST['Tip'];
    $C = $_POST['Cap'];
    $K = $_POST['Kalinlik'];
    $F = $_POST['LevhaFirma'];
    if ($baglanti->query("SELECT * FROM levha WHERE Tip='$T' AND Cap='$C' AND Kalinlik='$K'")->rowCount() <= 0) {
        $query = $baglanti->prepare('INSERT INTO levha SET Firma_ID=?, Tip=?, Cap=?, Kalinlik=?');
        $query->execute(array($F == "" ? null : $F, $T, $C, $K));
    }
} elseif (isset($_POST["LevhaDuzenle"])) {
    $F = $_POST['LevhaFirma'];
    $query = $baglanti->prepare('UPDATE levha SET Firma_ID=?, Tip=?, Cap=?, Kalinlik=? WHERE Levha_ID= ?');
    $query->execute(array($F == "" ? null : $F, $_POST['Tip'], $_POST['Cap'],  $_POST['Kalinlik'], $_POST['ID']));
} elseif (isset($_POST['LevhaSiparis'])) {
    $Adet = $_POST['Adet'];
    $kg = $_POST['Agirlik'];
    $S_Tarihi = $_POST['STarihi'];
    //--------------------------STOĞA EKLE
    $L = $_SESSION["Levhalar"];
    for ($i = 0; $i < count($L); $i++) {
        $StokKaydet = $baglanti->prepare("INSERT INTO levha_stok SET Siparis_Adet= ?, Siparis_Agirlik= ?");
        $StokKaydet->execute(array($Adet[$i], $kg[$i]));
        $StokID = $baglanti->lastInsertId();
        //--------------------------Sipariş EKLE
        $Siparis = $baglanti->prepare("INSERT INTO siparis SET Siparis= ?, Adet= ?, Agirlik= ?, S_Tarihi= ?, Kullanici_ID= ?");
        $Siparis->execute(array("Levha", $Adet[$i], $kg[$i], $S_Tarihi, $Kullanici));
        $Siparis_ID = $baglanti->lastInsertId();
        //--------------------------Levha Sipariş EKLE
        $siparisKaydet = $baglanti->prepare("INSERT INTO levha_siparis SET Levha_Stok_ID= ?, Siparis_ID= ?, Levha_ID= ?");
        $siparisKaydet->execute(array($StokID, $Siparis_ID, $L[$i]));
    }

    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               KULP              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

} elseif (isset($_POST["KulpEkle"])) {
    $F = $_POST['Firma'];
    $A = $_POST['Adi'];
    $C = $_POST['Cesit'];
    $R = $_POST['Renk'];
    if ($baglanti->query("SELECT * FROM kulp WHERE KulpAdi=" . $A . " AND KulpCesidi=" . $C . " AND Renk=" . $R)->rowCount() <= 0) {
        $query = $baglanti->prepare('INSERT INTO kulp SET Firma_ID=?, KulpAdi=?, KulpCesidi=?, Renk=?');
        $query->execute(array($F == "" ? null : $F, $A, $C, $R));
    }
} elseif (isset($_POST["KulpDuzenle"])) {
    $F = $_POST['Firma'];
    $query = $baglanti->prepare('UPDATE kulp SET Firma_ID=?, KulpAdi=?, KulpCesidi=?, Renk=? WHERE Kulp_ID= ?');
    $query->execute(array($F == "" ? null : $F, $_POST['Adi'], $_POST['Cesit'],  $_POST['Renk'], $_POST['ID']));

    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               KAPAK              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

} elseif (isset($_POST["KapakEkle"])) {
    $A = $_POST['Adi'];
    $F = $_POST['Firma'];
    if ($baglanti->query("SELECT * FROM kapak WHERE Model_Adi=" . $A)->rowCount() <= 0) {
        $query = $baglanti->prepare('INSERT INTO kapak SET Firma_ID=?, Model_Adi=?');
        $query->execute(array($F == "" ? null : $F, $A));
    }
} elseif (isset($_POST["KapakDuzenle"])) {
    $F = $_POST['Firma'];
    $query = $baglanti->prepare('UPDATE kapak SET Firma_ID=?, Model_Adi=? WHERE Kapak_ID= ?');
    $query->execute(array($F == "" ? null : $F, $_POST['Adi'], $_POST['ID']));

    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               TEPE              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

} elseif (isset($_POST["TepeEkle"])) {
    $A = $_POST['Adi'];
    $F = $_POST['Firma'];
    if ($baglanti->query("SELECT * FROM tepe WHERE TepeAdi=" . $A)->rowCount() <= 0) {
        $query = $baglanti->prepare('INSERT INTO tepe SET Firma_ID=?, TepeAdi=?');
        $query->execute(array($F == "" ? null : $F, $A));
    }
} elseif (isset($_POST["TepeDuzenle"])) {
    $F = $_POST['Firma'];
    $query = $baglanti->prepare('UPDATE tepe SET Firma_ID=?, TepeAdi=? WHERE Tepe_ID= ?');
    $query->execute(array($F == "" ? null : $F, $_POST['Adi'], $_POST['ID']));
}
