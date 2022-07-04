<?php
/*Toplam Set içerik Adeti*/ $Toplam = $baglanti->query('SELECT SUM(Adet) AS Toplam FROM view_set_urun_sec WHERE Set_ID =' . $SetID)->fetch()["Toplam"];
//Levha
$Hesap = 0;
$a = 0;
$b = 0;
//Pres
$Prs = 0;
$e = 0;
//Yıkama
$Yika = 0;
$f = 0;
//Kumlama
$Kumla = 0;
$g = 0;
//Telleme
$Telle = 0;
$h = 0;
//Boyama
$Boya = 0;
$j = 0;
//Paketleme
$Paket = 0;
$k = 0;
@$mm = $baglanti->query("SELECT Kalinlik FROM set_icerik INNER JOIN set_urun_icerik ON set_icerik.Set_Urun_icerik_ID = set_urun_icerik.Set_Urun_icerik_ID WHERE set_urun_icerik.Set_ID =" . $SetID)->fetch()["Kalinlik"];

$sor = $baglanti->query("SELECT Urun_ID,Adet FROM view_set_urun_sec WHERE Set_ID=" . $SetID)->fetchAll();
foreach ($sor as $s) {
    $UrunID = $s["Urun_ID"];
    $Adet = $s["Adet"];
    //LEVHA TEDARİK
    $cap = $baglanti->query("SELECT Cap FROM urun_levha_bilgi INNER JOIN levha ON urun_levha_bilgi.Levha_ID = levha.Levha_ID WHERE Urun_ID =" . $UrunID . " AND  Kalinlik =" . $mm)->fetch()["Cap"];

    $a += ceil((($cap * $cap * $mm * (0.22)) / 1000) * $Adet); // Toplam tedarik edilecek levha

    $sorstok = $baglanti->query("SELECT Stok_Adet, Stok_Agirlik FROM levha_siparis INNER JOIN levha_gelen ON levha_siparis.Levha_Stok_ID = levha_gelen.Levha_Stok_ID INNER JOIN levha ON levha_siparis.Levha_ID = levha.Levha_ID WHERE Cap =" . $cap);
    if ($sorstok->rowCount()) {
        foreach ($sorstok as $stk) {
            $b += $stk["Stok_Agirlik"]; // Stokta olan levha
        }
    } //else echo "<br>Çap= $cap &nbsp Kalinlik= $mm > Stokta yok > <a href='../../SatinAlma/Siparis/LevhaSiparis.php?Kalinlik=$mm&Cap=$cap'>Sipariş</a>";

    //PRES
    $e += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Preslendi' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
    //Yıkama
    $f += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Yıkandı' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
    //Kumlama
    $g += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Kumlandı' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
    //Telleme
    $h += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Tellendi' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
    //Boyama
    $j += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Boyandı' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
    //Paketleme
    $k += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Paketlendi' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
}

//Yüzde Hesabı
if ($a <> null) { //Levha
    $Hesap = floor($b / ($a / 100));
    $Hesap = $Hesap > 100 ? 100 : $Hesap;
}
if ($e <> null) { //Pres
    $Prs = floor($e / ($Toplam / 100));
    $Prs = $Prs > 100 ? 100 : $Prs;
}
if ($f <> null) { //Yıkama
    $Yika = floor($f / ($Toplam / 100));
    $Yika = $Yika > 100 ? 100 : $Yika;
}
if ($g <> null) { //Kumlama
    $Kumla = floor($g / ($Toplam / 100));
    $Kumla = $Kumla > 100 ? 100 : $Kumla;
}
if ($h <> null) { //Teleme
    $Telle = floor($h / ($Toplam / 100));
    $Telle = $Telle > 100 ? 100 : $Telle;
}
if ($j <> null) { //Boyama
    $Boya = floor($j / ($Toplam / 100));
    $Boya = $Boya > 100 ? 100 : $Boya;
}
if ($k <> null) { //Paketleme
    $Paket = floor($k / ($Toplam / 100));
    $Paket = $Paket > 100 ? 100 : $Paket;
}
$SetYuzde = floor(($Hesap + $Prs + $Yika + $Kumla + $Telle + $Boya + $Paket) / 7);

                /*Yüzde Son*/
