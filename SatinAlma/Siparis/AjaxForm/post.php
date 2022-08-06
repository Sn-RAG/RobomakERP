<?php
require __DIR__ . '/../../../controller/Db.php';
require __DIR__ . "/../../../logtut.php";
session_start();
$Sor = $baglanti->query("SELECT Kullanici_ID FROM kullanici WHERE Kadi='$_SESSION[Kullanici]'");
$Kullanici = $Sor->fetch()['Kullanici_ID'];
if (isset($_POST['BoyaEkle'])) {
    $M = $_POST['Marka'];
    $R = $_POST['Renk'];
    $S = $_POST['Seri'];
    $K = $_POST['Kod'];
    if ($baglanti->prepare("SELECT * FROM boya WHERE Marka='$M' AND Renk='$R' AND Seri='$S' AND Kod='$K'")->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('INSERT INTO boya SET Marka=?, Renk=?, Seri=?, Kod=?');
        $query->execute(array($M, $R, $S, $K));
        logtut($Kullanici, "Boya ekledi.");
    }
} elseif (isset($_POST['BoyaDuzenle'])) {
    $M = $_POST['Marka'];
    $R = $_POST['Renk'];
    $S = $_POST['Seri'];
    $K = $_POST['Kod'];
    if ($baglanti->prepare("SELECT * FROM boya WHERE Marka='$M' AND Renk='$R' AND Seri='$S' AND Kod='$K'")->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('UPDATE boya SET Marka=?, Renk=?, Seri=?, Kod=? WHERE Boya_ID=?');
        $query->execute(array($M, $R, $S, $K, $_POST['BoyaID']));
        logtut($Kullanici, "Boya düzenledi.");
    }
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
    logtut($Kullanici, "Boya sipariş etti.");
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               LEVHA              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

} elseif (isset($_POST['LevhaEkle'])) {
    $T = $_POST['Tip'];
    $C = $_POST['Cap'];
    $C2 = $_POST['Cap2'];
    $K = $_POST['Kalinlik'];
    $F = $_POST['LevhaFirma'];
    $bak = $T == "DikDörtgen" ? " AND Cap2='$C2'" : "";
    $EKLE = $T == "DikDörtgen" ? $C2 : null;
    if ($baglanti->query("SELECT * FROM levha WHERE Tip='$T' AND Cap='$C' AND Kalinlik='$K'" . $bak)->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('INSERT INTO levha SET Firma_ID=?, Tip=?, Cap=?, Cap2=?, Kalinlik=?');
        $query->execute(array($F == "" ? null : $F, $T, $C, $EKLE, $K));
        logtut($Kullanici, "Levha ekledi.");
    }
} elseif (isset($_POST["LevhaDuzenle"])) {
    $T = $_POST['Tip'];
    $C = $_POST['Cap'];
    $C2 = $_POST['Cap2'];
    $K = $_POST['Kalinlik'];
    $F = $_POST['LevhaFirma'];
    $bak = $T == "DikDörtgen" ? " AND Cap2='$C2'" : "";
    $EKLE = $T == "DikDörtgen" ? $C2 : null;
    if ($baglanti->query("SELECT * FROM levha WHERE Tip='$T' AND Cap='$C' AND Kalinlik='$K'" . $bak)->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('UPDATE levha SET Firma_ID=?, Tip=?, Cap=?, Cap2=?, Kalinlik=? WHERE Levha_ID= ?');
        $query->execute(array($F == "" ? null : $F, $T, $C, $EKLE, $K, $_POST['ID']));
        logtut($Kullanici, "Levha Düzenledi.");
    }
} elseif (isset($_POST['LevhaSiparis'])) {
    $Adet = $_POST['Adet'];
    $kg = $_POST['Agirlik'];
    $S_Tarihi = $_POST['STarihi'];
    //--------------------------STOĞA EKLE
    $L = $_SESSION["Levhalar"];
    for ($i = 0; $i < count($L); $i++) {
        $StokKaydet = $baglanti->prepare("INSERT INTO levha_stok SET Siparis_Adet= ?, Siparis_Agirlik= ?, Durum=?, LevhaID= ?");
        $StokKaydet->execute(array($Adet[$i], $kg[$i], 0, $L[$i]));
        $StokID = $baglanti->lastInsertId();
        //--------------------------Sipariş EKLE
        $Siparis = $baglanti->prepare("INSERT INTO siparis SET Siparis= ?, Adet= ?, Agirlik= ?, S_Tarihi= ?, Kullanici_ID= ?");
        $Siparis->execute(array("Levha", $Adet[$i], $kg[$i], $S_Tarihi, $Kullanici));
        $Siparis_ID = $baglanti->lastInsertId();
        //--------------------------Levha Sipariş EKLE
        $siparisKaydet = $baglanti->prepare("INSERT INTO levha_siparis SET Levha_Stok_ID= ?, Siparis_ID= ?, Levha_ID= ?");
        $siparisKaydet->execute(array($StokID, $Siparis_ID, $L[$i]));
    }
    logtut($Kullanici, "Levha sipariş etti.");
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               KULP              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

} elseif (isset($_POST["KulpEkle"])) {
    $F = $_POST['Firma'];
    $A = $_POST['Adi'];
    $C = $_POST['Cesit'];
    $R = $_POST['Renk'];
    if ($baglanti->query("SELECT * FROM kulp WHERE KulpAdi=" . $A . " AND KulpCesidi=" . $C . " AND Renk=" . $R)->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('INSERT INTO kulp SET Firma_ID=?, KulpAdi=?, KulpCesidi=?, Renk=?');
        $query->execute(array($F == "" ? null : $F, $A, $C, $R));
        logtut($Kullanici, "Kulp ekledi.");
    }
} elseif (isset($_POST["KulpDuzenle"])) {
    $F = $_POST['Firma'];
    $A = $_POST['Adi'];
    $C = $_POST['Cesit'];
    $R = $_POST['Renk'];
    if ($baglanti->query("SELECT * FROM kulp WHERE KulpAdi=" . $A . " AND KulpCesidi=" . $C . " AND Renk=" . $R)->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('UPDATE kulp SET Firma_ID=?, KulpAdi=?, KulpCesidi=?, Renk=? WHERE Kulp_ID= ?');
        $query->execute(array($F == "" ? null : $F, $A, $C,  $R, $_POST['ID']));
        logtut($Kullanici, "Kulp düzenledi.");
    }
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               KAPAK              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

} elseif (isset($_POST["KapakEkle"])) {
    $A = $_POST['Adi'];
    $F = $_POST['Firma'];
    if ($baglanti->query("SELECT * FROM kapak WHERE Model_Adi=" . $A)->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('INSERT INTO kapak SET Firma_ID=?, Model_Adi=?');
        $query->execute(array($F == "" ? null : $F, $A));
        logtut($Kullanici, "Kapak ekledi.");
    }
} elseif (isset($_POST["KapakDuzenle"])) {
    $A = $_POST['Adi'];
    $F = $_POST['Firma'];
    if ($baglanti->query("SELECT * FROM kapak WHERE Model_Adi=" . $A)->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('UPDATE kapak SET Firma_ID=?, Model_Adi=? WHERE Kapak_ID= ?');
        $query->execute(array($F == "" ? null : $F, $A, $_POST['ID']));
        logtut($Kullanici, "Kapak düzenledi.");
    }
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               TEPE              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

} elseif (isset($_POST["TepeEkle"])) {
    $A = $_POST['Adi'];
    $F = $_POST['Firma'];
    if ($baglanti->query("SELECT * FROM tepe WHERE TepeAdi=" . $A)->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('INSERT INTO tepe SET Firma_ID=?, TepeAdi=?');
        $query->execute(array($F == "" ? null : $F, $A));
        logtut($Kullanici, "Tepe ekledi.");
    }
} elseif (isset($_POST["TepeDuzenle"])) {
    $A = $_POST['Adi'];
    $F = $_POST['Firma'];
    if ($baglanti->query("SELECT * FROM tepe WHERE TepeAdi=" . $A)->rowCount()) {
        echo "var";
    } else {
        $query = $baglanti->prepare('UPDATE tepe SET Firma_ID=?, TepeAdi=? WHERE Tepe_ID= ?');
        $query->execute(array($F == "" ? null : $F, $A, $_POST['ID']));
        logtut($Kullanici, "Tepe düzenledi.");
    }
}
