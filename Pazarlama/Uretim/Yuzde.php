<?php
$Toplam = $baglanti->query('SELECT SUM(Adet) AS Toplam FROM view_set_urun_sec WHERE Set_ID =' . $SetID)->fetch()["Toplam"];
//Levha
$CartLevha = [];
$LevhaTed = 0;
$i = 0;
$Hesap = 0;
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
$p = 0;
$sor = $baglanti->query("SELECT Urun_ID, UrunAdi, Levha_ID, SUM(Adet) AS Adet FROM view_set_urun_sec WHERE Set_ID =" . $SetID . " GROUP BY Urun_ID")->fetchAll();
foreach ($sor as $s) {
    $UrunID = $s["Urun_ID"];
    $l = $baglanti->query("SELECT Cap,Kalinlik FROM urun_levha_bilgi INNER JOIN levha ON urun_levha_bilgi.Levha_ID = levha.Levha_ID WHERE Urun_ID =" . $s["Urun_ID"] . " AND levha.Levha_ID =" . $s["Levha_ID"]);
    if ($l->rowCount()) {
        $q = $l->fetch();
        $c = $q["Cap"];
        $k = $q["Kalinlik"];
        $a = $s["Adet"];
        $sorstok = $baglanti->query("SELECT levha.Levha_ID AS LevhaID, SUM(Stok_Adet) AS Adt FROM levha_siparis INNER JOIN levha_gelen ON levha_siparis.Levha_Stok_ID = levha_gelen.Levha_Stok_ID INNER JOIN levha ON levha_siparis.Levha_ID = levha.Levha_ID WHERE Stok_Adet>0 AND Stok_Agirlik>0 AND levha.Levha_ID =" . $s["Levha_ID"]);
        if ($sorstok->rowCount()) {
            foreach ($sorstok as $stk) {
                $b = $stk["Adt"]; // Stokta olan levha
                $i++;
                $CartLevha[$i] = $b;

                //PRES
                $pr = $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Preslendi' AND Set_ID=" . $SetID . " AND Levha_ID=" . $stk["LevhaID"])->fetch()["Toplam"];
                $tt = floor(($b + $pr) / ($a / 100));
                $LevhaTed += $tt > 99 ? 100 : $tt;
            }
        }
    }
    //PRES
    $e += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Preslendi' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
    //Yıkama
    $f += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Yıkandı' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
    //Kumlama
    $g += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Kumlandı' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
    //Telleme
    $h += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Tellendi' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
    //Paketleme
    $p += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='Paketlendi' AND Set_ID=" . $SetID . " AND Urun_ID=" . $UrunID)->fetch()["Toplam"];
}
//Boyama
$j += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Yapilan_is='İçi Boyandı' AND Set_ID=$SetID OR Set_ID=$SetID AND Yapilan_is='Dışı Boyandı'")->fetch()["Toplam"];


////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//PRES
$CartPresA = [];
$CartPresT = [];
$i = 0;
$Cart = $baglanti->query("SELECT SUM(Adet) AS Tadet, Tarih FROM set_urunler_asama_akis WHERE Yapilan_is='Preslendi' AND Set_ID=" . $SetID);
if ($Cart->rowCount()) {
    foreach ($Cart as $cc) {
        $CartPresA[$i] = $cc["Tadet"];
        $CartPresT[$i] = $cc["Tarih"];
        $i++;
    }
}

//Yıkama
$CartYikaA = [];
$CartYikaT = [];
$Cart = $baglanti->query("SELECT SUM(Adet) AS Tadet, Tarih FROM set_urunler_asama_akis WHERE Yapilan_is='Yıkandı' AND Set_ID=" . $SetID . " GROUP BY Tarih");
if ($Cart->rowCount()) {
    foreach ($Cart as $cc) {
        $CartYikaA[$i] = $cc["Tadet"];
        $CartYikaT[$i] = $cc["Tarih"];
        $i++;
    }
}

//Kumlama
$CartKumlaA = [];
$CartKumlaT = [];
$Cart = $baglanti->query("SELECT SUM(Adet) AS Tadet, Tarih FROM set_urunler_asama_akis WHERE Yapilan_is='Kumlandı' AND Set_ID=" . $SetID . " GROUP BY Tarih");
if ($Cart->rowCount()) {
    foreach ($Cart as $cc) {
        $CartKumlaA[$i] = $cc["Tadet"];
        $CartKumlaT[$i] = $cc["Tarih"];
        $i++;
    }
}

//Telleme
$CartTelleA = [];
$CartTelleT = [];
$Cart = $baglanti->query("SELECT SUM(Adet) AS Tadet, Tarih FROM set_urunler_asama_akis WHERE Yapilan_is='Tellendi' AND Set_ID=" . $SetID . " GROUP BY Tarih");
if ($Cart->rowCount()) {
    foreach ($Cart as $cc) {
        $CartTelleA[$i] = $cc["Tadet"];
        $CartTelleT[$i] = $cc["Tarih"];
        $i++;
    }
}

//Boyama
$CartBoyaA = [];
$CartBoyaT = [];
$Cart = $baglanti->query("SELECT SUM(Adet) AS Tadet, Tarih FROM set_urunler_asama_akis WHERE Yapilan_is='İçi Boyandı' AND Set_ID=" . $SetID . " OR Set_ID=" . $SetID . " AND Yapilan_is='Dışı Boyandı' GROUP BY Tarih");
if ($Cart->rowCount()) {
    foreach ($Cart as $cc) {
        $CartBoyaA[$i] = $cc["Tadet"];
        $CartBoyaT[$i] = $cc["Tarih"];
        $i++;
    }
}
//Paketleme
$CartPaketA = [];
$CartPaketT = [];
$Cart = $baglanti->query("SELECT SUM(Adet) AS Tadet, Tarih FROM set_urunler_asama_akis WHERE Yapilan_is='Paketlendi' AND Set_ID=" . $SetID . " GROUP BY Tarih");
if ($Cart->rowCount()) {
    foreach ($Cart as $cc) {
        $CartPaketA[$i] = $cc["Tadet"];
        $CartPaketT[$i] = $cc["Tarih"];
        $i++;
    }
}
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

//Yüzde Hesabı

$Hesap = floor($LevhaTed / count($sor));

$Prs = floor($e / ($Toplam / 100));
$Prs = $Prs > 99 ? 100 : $Prs;

$Yika = floor($f / ($Toplam / 100));
$Yika = $Yika > 99 ? 100 : $Yika;

$Kumla = floor($g / ($Toplam / 100));
$Kumla = $Kumla > 99 ? 100 : $Kumla;

$Telle = floor($h / ($Toplam / 100));
$Telle = $Telle > 99 ? 100 : $Telle;

$Boya = floor(($j / 2) / ($Toplam / 100));
$Boya = $Boya > 99 ? 100 : $Boya;

$Paket = floor($p / ($Toplam / 100));
$Paket = $Paket > 99 ? 100 : $Paket;

$pr = ($Prs * 40) / 100;
$kk = ($Kumla * 20) / 100;
$tt = ($Telle * 20) / 100;
$bb = ($Boya * 10) / 100;
$pk = ($Paket * 10) / 100;

$SetYuzde = floor($pr + $kk + $tt + $bb + $pk);
