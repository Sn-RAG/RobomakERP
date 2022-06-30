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
    foreach ($sorgu as $s) {
        $Uid=$s["Urun_ID"]
        ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <div>
                <input type="number" id="deger<?=$Uid?>" class="form-control-sm me-1">
                <button class="gir btn btn-sm bi-check-lg btn-primary" Urun_ID="<?=$Uid?>" Set_ID="<?= $s["Set_ID"] ?>"></button>
            </div>

            <?=$s["UrunAdi"]?>
            
            <span class="badge bg-secondary rounded-pill"><?php
                if ($HB == "Pres") {
                    $Pr=$s["Preslenen"];
                    echo $Pr==""?0:$Pr;
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
        $('.gir').click(function () {
            var Uid = $(this).attr("Urun_ID");
            var SetID = $(this).attr("Set_ID");
            var deger = $("#deger"+Uid+"").val();
            var Hangisi = "";
            if(deger!=""){
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
                        'UrunID': Uid,
                        'Deger': deger,
                        'Hangisi': Hangisi,
                    },
                    error: function (xhr) {
                        alert('Hata: ' + xhr.responseText);
                    },
                    success: function () {
                        window.location.assign("SetKontrol.php?SetAdi="+"<?=$_SESSION["SetAdi"]?>"+"&Set_ID="+SetID+"");
                    }
                })
            }else{
                $("#deger"+Uid+"").attr("placeholder","Değer Giriniz!");
            }
        });
    </script>

    <style>
        ::placeholder {
        color: red;
        opacity: 1; /* Firefox */
        }

        :-ms-input-placeholder { /* Internet Explorer 10-11 */
        color: red;
        }

        ::-ms-input-placeholder { /* Microsoft Edge */
        color: red;
        }
    </style>

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

    $ekle = $baglanti->query("SELECT " . $Ekle . " FROM set_urunler_asama WHERE Urun_ID = " . $UrunID)->fetch()[$Ekle];

    $guncelle = $baglanti->prepare("UPDATE set_urunler_asama SET ".$Ekle."= ? WHERE Urun_ID=?");
    $guncelle->execute(array($Deger+$ekle,$UrunID));

    $kaydet = $baglanti->prepare("INSERT INTO loglar SET Set_ID= ?,Urun_ID= ?,Yapilan_is= ?,Adet= ?");
    $kaydet->execute(array($SetID,$UrunID,$Is,$Deger));

    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########

}elseif (isset($_POST["isDurum"])){
    $Tsorgu = $baglanti->query("SELECT Tarih FROM loglar INNER JOIN urun ON loglar.Urun_ID = urun.Urun_ID WHERE Set_ID =" .$_POST['isDurum']." GROUP BY Tarih");
    if ($Tsorgu->rowCount()){
        foreach ($Tsorgu as $t){
            echo"<strong class='text-primary bi-clock'> $t[Tarih] </strong><br>";
        $sorgu = $baglanti->query("SELECT Set_ID, UrunAdi, Yapilan_is, Adet FROM loglar INNER JOIN urun ON loglar.Urun_ID = urun.Urun_ID WHERE Tarih='$t[Tarih]' AND Set_ID =" .$_POST['isDurum']." AND Yapilan_is='$_POST[Is]'");
        foreach ($sorgu as $s){
            echo "<small>$s[Adet] Adet $s[UrunAdi] $s[Yapilan_is].</small><br>";
        }
    }
    }else{
        echo"<strong class='secondary-font'> İşlem: Başlamadı </strong><small class='text-muted bi-clock'></small>";
    }
}