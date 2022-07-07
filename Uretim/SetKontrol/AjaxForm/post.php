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

    $kaydet = $baglanti->prepare("INSERT INTO set_urunler_asama_akis SET Set_ID= ?,Urun_ID= ?,Yapilan_is= ?,Adet= ?, Tarih= ?");
    $kaydet->execute(array($SetID, $UrunID, $Is, $Deger, $_POST['Tarih']));
    echo $sum;
    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########

} elseif (isset($_POST['FDeger'])) {
    $SetID = $_POST['FSetID'];
    $UrunID = $_POST['FUrunID'];
    $Deger = $_POST['FDeger'];

    $kaydet = $baglanti->prepare("INSERT INTO set_urunler_asama_akis SET Set_ID= ?,Urun_ID= ?,Yapilan_is= ?,Adet= ?, Tarih= ?");
    $kaydet->execute(array($SetID, $UrunID, "Fire", $Deger, $_POST['FTarih']));

    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########

} elseif (isset($_POST["isDurum"])) {
    $is = $_POST["Is"];
    $id=$_POST['isDurum'];
    $sor = $is == "Preslendi" ? "  OR Yapilan_is='Fire' AND Set_ID =" . $id : "";
    $Tsorgu = $baglanti->query("SELECT Tarih FROM set_urunler_asama_akis INNER JOIN urun ON set_urunler_asama_akis.Urun_ID = urun.Urun_ID WHERE Set_ID =" . $_POST['isDurum'] . " GROUP BY Tarih");
    if ($Tsorgu->rowCount()) {
        foreach ($Tsorgu as $t) {
            $sorgu = $baglanti->query("SELECT Set_ID, UrunAdi, Yapilan_is, Adet FROM set_urunler_asama_akis INNER JOIN urun ON set_urunler_asama_akis.Urun_ID = urun.Urun_ID WHERE Tarih='$t[Tarih]' AND Set_ID =" . $id . " AND Yapilan_is='$is' " . $sor);
            if ($sorgu->rowCount()) {
                echo "<strong class='text-primary bi-clock'> $t[Tarih] </strong><br>";
            }
            foreach ($sorgu as $s) {
                if ($s["Adet"] > 0) {
                    echo "<small>$s[Adet] Adet $s[UrunAdi] $s[Yapilan_is].</small><br>";
                } else {
                    echo "<small class='text-danger'>$s[Adet] Adet $s[UrunAdi]</small><br>";
                }
            }
        }
    }
}
