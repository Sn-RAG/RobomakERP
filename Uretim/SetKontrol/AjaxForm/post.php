<?php
require __DIR__ . '/../../../controller/Db.php';
session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];

if (isset($_POST['Listele'])) {

    $HB=$_POST['HangiButon'];

    $sorgu = $baglanti->query('SELECT Set_ID, urun.Urun_ID, UrunAdi, icBoyanan, DisBoyanan, Preslenen, Tellenen, Kumlanan, Paketlenen,Yikanan FROM set_urunler_asama INNER JOIN urun ON set_urunler_asama.Urun_ID = urun.Urun_ID WHERE Set_ID = ' . $_POST['Listele']);
    foreach ($sorgu as $s) { ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <input type="number" class="form-control-sm gir" Urun_ID="<?= $s["Urun_ID"] ?>" Set_ID="<?= $s["Set_ID"] ?>" style="width: 100px;">
            <?= $s["UrunAdi"] ?>
            <span class="badge bg-secondary rounded-pill"><?php
                if ($HB == "Pres") {
                    $P=$s["Preslenen"];
                    echo $P==""?0:$P;
                } elseif ($HB == "Telleme") {
                    $T=$s["Tellenen"];
                    echo $T==""?0:$T;
                } elseif ($HB == "Kumlama") {
                    $K=$s["Kumlanan"];
                    echo $K==""?0:$K;
                } elseif ($HB == "icBoyama") {
                    $Bi=$s["icBoyanan"];
                    echo $Bi==""?0:$Bi;
                } elseif ($HB == "DisBoyama") {
                    $Bi=$s["DisBoyanan"];
                    echo $Bi==""?0:$Bi;
                } elseif ($HB == "Yıkama") {
                    $Y=$s["Yikanan"];
                    echo $Y==""?0:$Y;
                } else {
                    $P=$s["Paketlenen"];
                    echo $P==""?0:$P;
                }
                ?>
            </span>
        </li>
    <?php }
    // Kısaltma
    $Has=".hasClass('btn-primary')";

    ?>
    <script>
        $('.gir').change(function () {
            var UrunID = $(this).attr("Urun_ID");
            var SetID = $(this).attr("Set_ID");
            var deger = $(this).val();
            var Hangisi = "";
            if ($("#Pres").hasClass("btn-primary")) {
                Hangisi = "Pres";
            } else if ($("#Telleme")<?=$Has?>) {
                Hangisi = "Telleme";
            } else if ($("#Kumlama")<?=$Has?>) {
                Hangisi = "Kumlama";
            } else if ($("#icBoyama")<?=$Has?>) {
                Hangisi = "icBoyama";
            }else if ($("#DisBoyama")<?=$Has?>) {
                Hangisi = "DisBoyama";
            } else if ($("#Paketleme")<?=$Has?>) {
                Hangisi = "Paketleme";
            }else if ($("#Yikama")<?=$Has?>) {
                Hangisi = "Yıkama";
            }
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'SetID':SetID,
                    'UrunID': UrunID,
                    'Deger': deger,
                    'Hangisi': Hangisi,
                },
                error: function (xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function () {
                    $.Listele();
                    $(".gir").val("");
                }
            })
        });
    </script>
    <?php
} elseif (isset($_POST['Deger'])) {
    $SetID=$_POST['SetID'];
    $UrunID=$_POST['UrunID'];
    $H=$_POST['Hangisi'];
$Deger=$_POST['Deger'];
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
    }elseif ($H == "Yıkama") {
        $Ekle = "Yikanan";
        $Is = "Yıkandı";
    } else {
        $Ekle = "Paketlenen";
        $Is = "Paketlendi";
    }

    //Adet Bilgisine göre hareket Et
    /*$sorgu = $baglanti->query("SELECT Urun_ID,set_urunler.Adet FROM set_urun_icerik INNER JOIN set_urunler ON set_urun_icerik.Set_ID = set_urunler.Set_ID WHERE set_urun_icerik.Set_ID ='$SetID' AND Urun_ID='$UrunID' GROUP BY set_urun_icerik.Set_Urun_icerik_ID");*/

    $ekle = $baglanti->query("SELECT " . $Ekle . " FROM set_urunler_asama WHERE Urun_ID = " . $UrunID)->fetch()[$Ekle];

    $guncelle = $baglanti->prepare("UPDATE set_urunler_asama SET ".$Ekle."= ? WHERE Urun_ID=?");
    $guncelle->execute(array($Deger+$ekle,$UrunID));

    $kaydet = $baglanti->prepare("INSERT INTO loglar SET Set_ID= ?,Urun_ID= ?,Yapilan_is= ?,Adet= ?");
    $kaydet->execute(array($SetID,$UrunID,$Is,$Deger));

    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########

}elseif (isset($_POST["isDurum"])){
    $sorgu = $baglanti->query("SELECT Set_ID, UrunAdi, Yapilan_is, Adet, Tarih FROM loglar INNER JOIN urun ON loglar.Urun_ID = urun.Urun_ID WHERE Set_ID =" .$_POST['isDurum']." AND Yapilan_is='$_POST[Is]'");
    if ($sorgu->rowCount()){
        foreach ($sorgu as $s){
            echo "<small class='text-muted bi-clock'> $s[Tarih] </small><small>$s[Adet] Adet $s[UrunAdi] $s[Yapilan_is].</small><br>";
        }
    }else{
        echo"<strong class='secondary-font'> İşlem: Başlamadı </strong><small class='text-muted bi-clock'></small>";
    }
}
