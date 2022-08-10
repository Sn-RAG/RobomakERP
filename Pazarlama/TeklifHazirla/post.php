<?php
require __DIR__ . '/../../controller/Db.php';
session_start();
$Sor = $baglanti->query("SELECT Kullanici_ID FROM kullanici WHERE Kadi='$_SESSION[Kullanici]'");
$Kullanici = $Sor->fetch()['Kullanici_ID'];
if (isset($_POST["Setsec"])) {
    $set = $_POST["Setsec"];
    $Say = $baglanti->query("SELECT COUNT(*) AS S_No FROM view_teklifler");
    $SNo = $Say->fetch()['S_No'];
    $SNo++;
    for ($i = 0; $i < count($set); $i++) {
        $Kaydet = $baglanti->prepare("INSERT INTO teklif_setler SET S_No= ?, Firma_ID= ?, Set_icerik_ID= ?");
        $Sonuc = $Kaydet->execute(array($SNo, $_POST["Firma"], $set[$i]));
    }

    $id = $baglanti->lastInsertId();

    $Kaydet = $baglanti->prepare("INSERT INTO teklifler SET Teklif_Set_ID= ?, Kullanici_ID= ?");
    $Sonuc = $Kaydet->execute(array($id, $Kullanici));
}
