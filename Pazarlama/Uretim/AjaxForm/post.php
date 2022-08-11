<?php
require __DIR__ . '/../../../controller/Db.php';
require __DIR__ . "/../../../logtut.php";
session_start();
$Has = ".hasClass('btn-primary')"; //Kısaltma
$Sor = $baglanti->query("SELECT Kullanici_ID FROM kullanici WHERE Kadi='$_SESSION[Kullanici]'");
$Kullanici = $Sor->fetch()['Kullanici_ID'];

if (isset($_POST['Listele'])) {
    $SNo = $_POST["SNo"];
    $Urunler = $_POST['Urunler'];
    $sayi = $_POST['sayi'];
    $say = count($sayi);

    $HB = $_POST['HangiButon'];
    $is = $_POST['is'];

    $Adetler = [];

    $sorgu = $baglanti->query("SELECT * FROM imalat INNER JOIN urun ON imalat.Urun_ID = urun.Urun_ID WHERE S_No=$SNo AND Yapilan_is='$is'");
    if ($sorgu->rowCount()) {
        foreach ($sorgu as $s) {
            for ($i = 0; $i < $say; $i++) {
                if ($Urunler[$i] == $s["Urun_ID"] & $_POST["Sidler"][$i] == $s["Set_ID"]) {
                    $Adetler[$i] = $s["Adet"];
                } else {
                    $Adetler[$i] = 0;
                }
            }
        } ?>
        <script>
            var sayi = <?= json_encode($sayi) ?>;
            var Adet = <?= json_encode($Adetler); ?>;

            <?php if ($HB == "Pres") { ?>
                for (let i = 0; i < <?= $say ?>; i++) {
                    $("#yazsayi" + sayi[i] + "").html(Adet[i]);
                }

            <?php } elseif ($HB == "Telleme") { ?>
                for (let i = 0; i < <?= $say ?>; i++) {
                    $("#yazsayi" + sayi[i] + "").html(Adet[i]);
                }
            <?php } elseif ($HB == "Kumlama") { ?>
                for (let i = 0; i < <?= $say ?>; i++) {
                    $("#yazsayi" + sayi[i] + "").html(Adet[i]);
                }
            <?php } elseif ($HB == "icBoyama") { ?>
                for (let i = 0; i < <?= $say ?>; i++) {
                    $("#yazsayi" + sayi[i] + "").html(Adet[i]);
                }
            <?php } elseif ($HB == "DisBoyama") { ?>
                for (let i = 0; i <= <?= $say ?>; i++) {
                    $("#yazsayi" + sayi[i] + "").html(Adet[i]);
                }
            <?php } elseif ($HB == "Yıkama") { ?>
                for (let i = 0; i < <?= $say ?>; i++) {
                    $("#yazsayi" + sayi[i] + "").html(Adet[i]);
                }
            <?php } else { ?>
                for (let i = 0; i < <?= $say ?>; i++) {
                    $("#yazsayi" + sayi[i] + "").html(Adet[i]);
                }
            <?php } ?>
        </script>

    <?php } else { ?>
        <script>
            var sayi = <?= json_encode($sayi) ?>;

            for (let i = 0; i < <?= $say ?>; i++) {
                $("#yazsayi" + sayi[i] + "").html(0);
            }
        </script>
    <?php }
    ###########################################################################################################################################################
} else if (isset($_POST["imalat"])) {
    $SNo = $_POST["SNo"];
    $is = $_POST['is'];
    ?>


    <table class="table table-sm border mb-1 imalat">
        <thead>
            <tr>
                <td colspan="5" class="text-center">DETAYLAR</td>
            </tr>
            <tr class="table-light">
                <th>Ürünler</th>
                <th>Adet</th>
                <th>İş</th>
                <th>Tarih</th>
                <th>&nbsp</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $fire = $is == "Preslendi" ? " OR Yapilan_is='Fire' AND S_No=$SNo" : "";
            $sorgu = $baglanti->query("SELECT * FROM imalat INNER JOIN urun ON imalat.Urun_ID = urun.Urun_ID WHERE S_No=$SNo AND Yapilan_is='$is' $fire ORDER BY Tarih");
            if ($sorgu->rowCount()) {
                foreach ($sorgu as $t) {
                    $adt = $t["Adet"];
                    $Trh = $t["Tarih"];
            ?>
                    <tr>
                        <td><?= $t["UrunAdi"] ?></td>
                        <td><?= $adt ?></td>
                        <td><?= $t["Yapilan_is"] ?></td>
                        <td><?= $Trh ?></td>
                        <td>
                            <button class="btn btn-sm btn-danger bi-trash Sil" type="button" id="<?= $t["id"] ?>"></button>
                        </td>
                    </tr>
            <?php }
            } ?>
        </tbody>
    </table>
    <script>
        $('.imalat').DataTable({
            order: 3,
            rowGroup: {
                dataSrc: [3]
            },
            responsive: true,
            columnDefs: [{
                    targets: '_all',
                    orderable: false
                },
                {
                    visible: false,
                    targets: [3]
                }
            ],
            scrollY: $("#Yuksek").height(),
            paging: false,
            bFilter: false,
            bInfo: false
        });
        $(".Sil").click(function() {
            id = $(this).attr("id");
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Sil': id,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function() {
                    $.Listele();
                }
            });
        });
    </script>
<?php } else if (isset($_POST["Sil"])) {
    $id = $_POST["Sil"];
    $s = $baglanti->query("SELECT * FROM imalat WHERE id=" . $id)->fetch();
    $is = $s["Yapilan_is"];
    $baglanti->query("DELETE FROM imalat WHERE id=" . $id . " AND Yapilan_is='$is'");
    logtut($Kullanici, "$is sildi.");

    ######################################################################################################################################################
} elseif (isset($_POST['Ekle'])) {
    $SNo = $_POST['SNo'];
    $SetID = $_POST['SetID'];
    $UrunID = $_POST['UrunID'];
    $H = $_POST['Hangisi'];
    $KT = $_POST['Tarih'];

    $Levha = 0;

    $iBoya = $_POST['iBoya'];
    $dBoya = $_POST['dBoya'];

    $Deger = $_POST['Deger'];

    if ($H == "Pres") {
        $Levha = $_POST['LevhaID'];
        $Is = "Preslendi";
    } elseif ($H == "Telleme") {
        $Is = "Tellendi";
    } elseif ($H == "Kumlama") {
        $Is = "Kumlandı";
    } elseif ($H == "icBoyama") {
        $Is = "İçi Boyandı";
    } elseif ($H == "DisBoyama") {
        $Is = "Dışı Boyandı";
    } elseif ($H == "Yıkama") {
        $Is = "Yıkandı";
    } else {
        $Is = "Paketlendi";
    }
    for ($i = 0; $i < count($UrunID); $i++) {
        if ($Is == "Preslendi") {
            /*if (LStokDus($Deger[$i], $KT, $Kullanici, $UrunID[$i], $SetID, $Levha[$i]) === 0) {
                echo "StokYok";
                return;
            }*/
        } elseif ($Is == "İçi Boyandı") {
            /* if (BStokDus($Deger[$i], $KT, $Kullanici, $UrunID[$i], $SetID, $iBoya) === 0) {
                echo "StokYok";
                return;
            } else {*/
            $Boya = $iBoya;
            // }
        } elseif ($Is == "Dışı Boyandı") {
            /*if (BStokDus($Deger[$i], $KT, $Kullanici, $UrunID[$i], $SetID, $dBoya) === 0) {
                echo "StokYok";
                return;
            } else {*/
            $Boya = $dBoya;
            // }
        }

        $Boya = 0;

        $kaydet = $baglanti->prepare("INSERT INTO imalat SET S_No= ?,Set_ID= ?,Urun_ID= ?,Levha_ID= ?,Boya_ID= ?,Yapilan_is= ?,Adet= ?,Tarih= ?");
        $kaydet->execute(array($SNo, $SetID[$i], $UrunID[$i], is_array($Levha) ? $Levha[$i] : $Levha, $Boya, $Is, $Deger[$i], $KT));
    }

    /*LOG KAYDI*/

    logtut($Kullanici, "$Is kaydetti.");

    /*LOG KAYDI SON*/

    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########

} elseif (isset($_POST['FDeger'])) {
    $SetID = $_POST['FSetID'];
    $UrunID = $_POST['FUrunID'];
    $Lid = $_POST['LevhaID'];
    $Deger = $_POST['FDeger'];
    date_default_timezone_set('Europe/Istanbul');
    $tarih = new DateTime("now");
    $tarih = date("Y-m-d");
    for ($i = 0; $i < count($UrunID); $i++) {
        /* if (LStokDus($Deger[$i], $tarih, $Kullanici, $UrunID[$i], $SetID, $Lid[$i]) === 0) {
            echo "StokYok";
        } else {*/
        $kaydet = $baglanti->prepare("INSERT INTO set_urunler_asama_akis SET Set_ID= ?,Urun_ID= ?,Levha_ID=?,Yapilan_is= ?,Adet= ?, Tarih= ?");
        $kaydet->execute(array($SetID, $UrunID[$i], $Lid[$i], "Fire", $Deger[$i], $_POST['FTarih']));
        //}
    }
    /*LOG KAYDI*/
    logtut($Kullanici, "$SetID numaralı sette Fire kaydetti.");

    /*LOG KAYDI SON*/
    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########

}
/////////////////////////////////////////////////////////////////////////////////// Fire ve Preslenenlerde stok Miktarını ayarlamak için

function LStokDus($Deger, $KT, $Kullanici, $UrunID, $SetID, $Lid)
{
    global $baglanti;
    if ($baglanti->query("SELECT Levha_Stok_ID FROM view_siparis_levha WHERE Levha_ID=" . $Lid)->rowCount()) {
        $V = $baglanti->query("SELECT Levha_Stok_ID, Cap, Kalinlik FROM view_siparis_levha WHERE Levha_ID=" . $Lid . " GROUP BY Levha_ID")->fetch();
        $Stokid = $V["Levha_Stok_ID"];
        $Cap = $V["Cap"];
        $Kalinlik = $V["Kalinlik"];

        //Stok
        $c = $baglanti->query("SELECT SUM(Stok_Adet) AS Adet,SUM(Stok_Agirlik) AS Agirlik FROM levha_gelen WHERE Levha_Stok_ID=" . $Stokid)->fetch();
        $St_Adet = $c["Adet"];
        $St_Agirlik = $c["Agirlik"];

        //Hesap
        $GAgirlik = ceil((($Cap * $Cap * $Kalinlik * (0.22)) * $Deger) / 1000);

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

        if ($baglanti->query("SELECT Levha_Stok_ID FROM levha_giden WHERE Gidis_Tarihi='$KT' AND Levha_Stok_ID=" . $Stokid . " AND SetID=" . $SetID . " AND UrunID=" . $UrunID . " AND LevhaID=" . $Lid)->rowCount()) {
            $Kaydet = $baglanti->prepare("UPDATE levha_giden SET Kullanilan_Adet=Kullanilan_Adet+?, Kullanilan_Agirlik=Kullanilan_Agirlik+?, Gidis_Tarihi= ?, Kullanici_ID= ? WHERE Levha_Stok_ID= ? AND Gidis_Tarihi= ? AND SetID= ? AND UrunID= ? AND LevhaID=?");
            $Kaydet->execute(array($Deger, $GAgirlik, $KT, $Kullanici, $Stokid, "$KT", $SetID, $UrunID, $Lid));
        } else {
            $Kaydet = $baglanti->prepare("INSERT INTO levha_giden SET Levha_Stok_ID= ?, Kullanilan_Adet= ?, Kullanilan_Agirlik= ?, Gidis_Tarihi= ?, Kullanici_ID= ?, UrunID= ?, SetID= ?, LevhaID=?");
            $Kaydet->execute(array($Stokid, $Deger, $GAgirlik, $KT, $Kullanici, $UrunID, $SetID, $Lid));
        }
    } else {
        return 0;
    }
}
function BStokDus($Deger, $KT, $Kullanici, $Uid, $Sid, $Bid)
{
    global $baglanti;

    $V = $baglanti->query("SELECT Boya_Stok_ID AS id FROM boya_gelen WHERE Stok_Miktar > 0 AND Boya_ID=" . $Bid . " GROUP BY Boya_ID");
    if ($V->rowCount()) {
        $Stokid = $V->fetch()["id"];

        $StokKaydet = $baglanti->prepare("UPDATE boya_gelen SET  Stok_Miktar= Stok_Miktar-? WHERE Boya_ID= ?");
        $StokKaydet->execute(array($Deger, $Bid));

        if ($baglanti->query("SELECT * FROM boya_giden WHERE Gidis_Tarihi='$KT' AND BoyaID=" . $Bid)->rowCount()) {
            $Kaydet = $baglanti->prepare("UPDATE boya_giden SET Kullanilan_Miktar= Kullanilan_Miktar+?, Gidis_Tarihi= ?, Kullanici_ID= ? WHERE Gidis_Tarihi=? AND UrunID= ? AND SetID= ? AND BoyaID= ?");
            $Kaydet->execute(array($Deger, $KT, $Kullanici, "$KT", $Uid, $Sid, $Bid));
        } else {
            $Kaydet = $baglanti->prepare("INSERT INTO boya_giden SET Boya_Stok_ID= ?, Kullanilan_Miktar= ?, Gidis_Tarihi= ?, Kullanici_ID= ?, UrunID= ? ,SetID= ?, BoyaID= ?");
            $Kaydet->execute(array($Stokid, $Deger, $KT, $Kullanici, $Uid, $Sid, $Bid));
        }
    } else {
        return 0;
    }
}
