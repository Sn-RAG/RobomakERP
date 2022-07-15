<?php
require __DIR__ . '/../../../controller/Db.php';
session_start();
$Has = ".hasClass('btn-primary')"; //Kısaltma
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];
if (isset($_POST['Listele'])) {
    $Urunler = $_POST['Urunler'];
    $HB = $_POST['HangiButon'];

    $Pres = [];
    $Telleme = [];
    $Kumlama = [];
    $icBoyama = [];
    $DisBoyama = [];
    $Yikama = [];
    $Paketle = [];
    $i = 0;
    $sorgu = $baglanti->query('SELECT icBoyanan, DisBoyanan, Preslenen, Tellenen, Kumlanan, Paketlenen,Yikanan FROM set_urunler_asama INNER JOIN urun ON set_urunler_asama.Urun_ID = urun.Urun_ID WHERE Set_ID = ' . $_POST['Listele']);
    foreach ($sorgu as $s) {
        $i++;
        if ($HB == "Pres") {
            $p = $s["Preslenen"];
            $Pres[$i] = $p == null ? 0 : $p;
        } elseif ($HB == "Telleme") {
            $T = $s["Tellenen"];
            $Telleme[$i] = $T == null ? 0 : $T;
        } elseif ($HB == "Kumlama") {
            $K =  $s["Kumlanan"];
            $Kumlama[$i] =  $K == null ? 0 : $K;
        } elseif ($HB == "icBoyama") {
            $ic = $s["icBoyanan"];
            $icBoyama[$i] =  $ic == null ? 0 : $ic;
        } elseif ($HB == "DisBoyama") {
            $Dis = $s["DisBoyanan"];
            $DisBoyama[$i] =  $Dis == null ? 0 : $Dis;
        } elseif ($HB == "Yıkama") {
            $Y = $s["Yikanan"];
            $Yikama[$i] =  $Y == null ? 0 : $Y;
        } else {
            $P = $s["Paketlenen"];
            $Paketle[$i] =  $P == null ? 0 : $P;
        }
    } ?>
    <script>
        var Urunler = <?php echo json_encode($Urunler); ?>;
        <?php
        $Urn = count($Urunler);
        if ($HB == "Pres") { ?>
            var Pres = <?php echo json_encode($Pres); ?>;

            for (let i = 1; i <= <?= $Urn ?>; i++) {
                $(".yazsayi" + Urunler[i] + "").html(Pres[i]);
            }

        <?php } elseif ($HB == "Telleme") { ?>
            var Telleme = <?php echo json_encode($Telleme); ?>;

            for (let i = 1; i <= <?= $Urn ?>; i++) {
                $(".yazsayi" + Urunler[i] + "").html(Telleme[i]);
            }
        <?php } elseif ($HB == "Kumlama") { ?>
            var Kumlama = <?php echo json_encode($Kumlama); ?>;

            for (let i = 1; i <= <?= $Urn ?>; i++) {
                $(".yazsayi" + Urunler[i] + "").html(Kumlama[i]);
            }
        <?php } elseif ($HB == "icBoyama") { ?>
            var icBoyama = <?php echo json_encode($icBoyama); ?>;

            for (let i = 1; i <= <?= $Urn ?>; i++) {
                $(".yazsayi" + Urunler[i] + "").html(icBoyama[i]);
            }
        <?php } elseif ($HB == "DisBoyama") { ?>
            var DisBoyama = <?php echo json_encode($DisBoyama); ?>;

            for (let i = 1; i <= <?= $Urn ?>; i++) {
                $(".yazsayi" + Urunler[i] + "").html(DisBoyama[i]);
            }
        <?php } elseif ($HB == "Yıkama") { ?>
            var Yikama = <?php echo json_encode($Yikama); ?>;

            for (let i = 1; i <= <?= $Urn ?>; i++) {
                $(".yazsayi" + Urunler[i] + "").html(Yikama[i]);
            }
        <?php } else { ?>
            var Paketle = <?php echo json_encode($Paketle); ?>;

            for (let i = 1; i <= <?= $Urn ?>; i++) {
                $(".yazsayi" + Urunler[i] + "").html(Paketle[i]);
            }
        <?php } ?>
    </script>

<?php } elseif (isset($_POST['Deger'])) {
    $SetID = $_POST['SetID'];
    $UrunID = $_POST['UrunID'];
    $H = $_POST['Hangisi'];
    $K_Tarihi = $_POST['Tarih'];

    $Deger = $_POST['Deger'];

    if ($H == "Pres") {
        $Ekle = "Preslenen";
        $Is = "Preslendi";
    } elseif ($H == "Telleme") {
        $Ekle = "Tellenen";
        $Is = "Tellendi";
    } elseif ($H == "Kumlama") {
        $Ekle = "Kumlanan";
        $Is = "Kumlandı";
    } elseif ($H == "icBoyama") {
        $Ekle = "icBoyanan";
        $Is = "Boyandı";
    } elseif ($H == "DisBoyama") {
        $Ekle = "DisBoyanan";
        $Is = "Boyandı";
    } elseif ($H == "Yıkama") {
        $Ekle = "Yikanan";
        $Is = "Yıkandı";
    } else {
        $Ekle = "Paketlenen";
        $Is = "Paketlendi";
    }

    $tpl = $baglanti->query("SELECT " . $Ekle . " FROM set_urunler_asama WHERE Urun_ID = " . $UrunID . " AND Set_ID=" . $SetID)->fetch()[$Ekle];
    $sum = $Deger + $tpl;
    $guncelle = $baglanti->prepare("UPDATE set_urunler_asama SET " . $Ekle . "= ? WHERE Urun_ID=? AND Set_ID=?");
    $guncelle->execute(array($sum, $UrunID, $SetID));
    echo $sum; //Anlık Post Ajax.
    $kaydet = $baglanti->prepare("INSERT INTO set_urunler_asama_akis SET Set_ID= ?,Urun_ID= ?,Yapilan_is= ?,Adet= ?, Tarih= ?");
    $kaydet->execute(array($SetID, $UrunID, $Is, $Deger, $K_Tarihi));
    if ($Is == "Preslendi") {
        StokDus($Deger, $K_Tarihi, $Kullanici);
    }
    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########

} elseif (isset($_POST['FDeger'])) {
    $Deger = $_POST['FDeger'];
    $Lid = $_POST['LevhaID'];
    date_default_timezone_set('Europe/Istanbul');
    $tarih = new DateTime("now");
    $tarih = date("Y-m-d");
    $kaydet = $baglanti->prepare("INSERT INTO set_urunler_asama_akis SET Set_ID= ?,Urun_ID= ?,Yapilan_is= ?,Adet= ?, Tarih= ?");
    $kaydet->execute(array($_POST['FSetID'], $_POST['FUrunID'], "Fire", $Deger, $_POST['FTarih']));
    StokDus($Deger, $tarih, $Kullanici);

    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########

} elseif (isset($_POST["isDurum"])) {
    $is = $_POST["Is"];
    $id = $_POST['isDurum'];
    $Tsorgu = $baglanti->query("SELECT Tarih FROM set_urunler_asama_akis INNER JOIN urun ON set_urunler_asama_akis.Urun_ID = urun.Urun_ID WHERE Set_ID =" . $_POST['isDurum'] . " GROUP BY Tarih");
    if ($Tsorgu->rowCount()) {
        foreach ($Tsorgu as $t) {
            $Firegor = $is == "Preslendi" ? "  OR Tarih='$t[Tarih]' AND Yapilan_is='Fire' AND Set_ID =" . $id : "";
            $sorgu = $baglanti->query("SELECT Set_ID, UrunAdi, Yapilan_is, Adet FROM set_urunler_asama_akis INNER JOIN urun ON set_urunler_asama_akis.Urun_ID = urun.Urun_ID WHERE Tarih='$t[Tarih]' AND Set_ID =" . $id . " AND Yapilan_is='$is' " . $Firegor);
            if ($sorgu->rowCount()) {
                $SumFire=$baglanti->query("SELECT SUM(Adet) AS Toplam FROM set_urunler_asama_akis WHERE Tarih='$t[Tarih]' AND Yapilan_is='Fire' AND Set_ID =" . $id)->fetch()["Toplam"];
                $srou=$SumFire<>null?$SumFire:0;
                echo "<p class='text-primary bi-clock py-3 mb-0 text-center'> $t[Tarih] <label class='text-black small'> Toplam Fire= " . $srou . "</label></p>";
            }
            foreach ($sorgu as $s) {
                if ($s["Adet"] > 0) {
                    echo "<small class='col-md-6 border-end'>$s[Adet] Adet $s[UrunAdi] $s[Yapilan_is].</small><br>";
                } else {
                    echo "<small class='text-danger'>$s[Adet] Adet $s[UrunAdi]</small><br>";
                }
            }
        }
    }
}

/////////////////////////////////////////////////////////////////////////////////// Fire ve Preslenenlerde stok Miktarını ayarlamak için

function StokDus($Deger, $K_Tarihi, $Kullanici)
{
    global $baglanti;
    foreach ($baglanti->query("SELECT Levha_Stok_ID, Cap, Kalinlik FROM view_siparis_levha WHERE Levha_ID=" . $_POST['LevhaID']) as $V) {
        foreach ($baglanti->query("SELECT SUM(Stok_Adet) AS Adet,SUM(Stok_Agirlik) AS Agirlik FROM levha_gelen WHERE Levha_Stok_ID=" . $V["Levha_Stok_ID"]) as $c) {

            $Stokid = $V["Levha_Stok_ID"];
            $Cap = $V["Cap"];
            $Kalinlik = $V["Kalinlik"];

            //Stok
            $St_Adet = $c["Adet"];
            $St_Agirlik = $c["Agirlik"];

            foreach ($baglanti->query("SELECT SUM(Kullanilan_Adet) AS Adet,SUM(Kullanilan_Agirlik) AS Agirlik FROM levha_giden WHERE Levha_Stok_ID=" . $V["Levha_Stok_ID"]) as $k) {
                //Kullanılan
                $KAdet = $k["Adet"];
                $KAgirlik = $k["Agirlik"];
            }
        }
    }

    //Hesap
    $GAgirlik = ceil((($Cap * $Cap * $Kalinlik * (0.22)) * $Deger) / 1000);

    $TplMevcutAdet = $Deger + $KAdet;
    $TplMevcutAgirlik = $GAgirlik + $KAgirlik;

    $Say = $baglanti->query("SELECT COUNT(Levha_Stok_ID) AS a FROM levha_gelen WHERE Levha_Stok_ID=" . $Stokid)->fetch()["a"];
    if ($Say > 1) {
        $TplAdet = ($St_Adet - $Deger) / $Say;
        $TplAgirlik = ($St_Agirlik - $GAgirlik) / $Say;
    } else {
        $TplAdet = $St_Adet - $Deger;
        $TplAgirlik = $St_Agirlik - $GAgirlik;
    }
    $StokKaydet = $baglanti->prepare("UPDATE levha_gelen SET  Stok_Adet= ?, Stok_Agirlik= ? WHERE Levha_Stok_ID= ?");
    $StokKaydet->execute(array($TplAdet, $TplAgirlik, $Stokid));

    if ($baglanti->query("SELECT Levha_Stok_ID FROM levha_giden WHERE Levha_Stok_ID=" . $Stokid)->rowCount()) {

        if ($baglanti->query("SELECT Gidis_Tarihi FROM levha_giden WHERE Gidis_Tarihi='$K_Tarihi'")->rowCount()) {

            $Kaydet = $baglanti->prepare("UPDATE levha_giden SET Levha_Stok_ID= ?, Kullanilan_Adet=Kullanilan_Adet+?, Kullanilan_Agirlik=Kullanilan_Agirlik+?, Gidis_Tarihi= ?, Kullanici_ID= ? WHERE Levha_Stok_ID= ? AND Gidis_Tarihi= ?");
            $Kaydet->execute(array($Stokid, $Deger, $GAgirlik, $K_Tarihi, $Kullanici, $Stokid, "$K_Tarihi"));
        } else {
            $Kaydet = $baglanti->prepare("INSERT INTO levha_giden SET Levha_Stok_ID= ?, Kullanilan_Adet= ?, Kullanilan_Agirlik= ?, Gidis_Tarihi= ?, Kullanici_ID= ?");
            $Kaydet->execute(array($Stokid, $Deger, $GAgirlik, $K_Tarihi, $Kullanici));
        }
    } else {
        $Kaydet = $baglanti->prepare("INSERT INTO levha_giden SET Levha_Stok_ID= ?, Kullanilan_Adet= ?, Kullanilan_Agirlik= ?, Gidis_Tarihi= ?, Kullanici_ID= ?");
        $Kaydet->execute(array($Stokid, $TplMevcutAdet, $TplMevcutAgirlik, $K_Tarihi, $Kullanici));
    }
}
