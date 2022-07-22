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
        $i++;
    } ?>
    <script>
        var Urunler = <?php echo json_encode($Urunler); ?>;
        <?php
        $Urn = count($Urunler);
        if ($HB == "Pres") { ?>
            var Pres = <?php echo json_encode($Pres); ?>;

            for (let i = 0; i < <?= $Urn ?>; i++) {
                $("#yazsayi" + Urunler[i] + "").html(Pres[i]);
            }

        <?php } elseif ($HB == "Telleme") { ?>
            var Telleme = <?php echo json_encode($Telleme); ?>;

            for (let i = 0; i < <?= $Urn ?>; i++) {
                $("#yazsayi" + Urunler[i] + "").html(Telleme[i]);
            }
        <?php } elseif ($HB == "Kumlama") { ?>
            var Kumlama = <?php echo json_encode($Kumlama); ?>;

            for (let i = 0; i < <?= $Urn ?>; i++) {
                $("#yazsayi" + Urunler[i] + "").html(Kumlama[i]);
            }
        <?php } elseif ($HB == "icBoyama") { ?>
            var icBoyama = <?php echo json_encode($icBoyama); ?>;

            for (let i = 0; i < <?= $Urn ?>; i++) {
                $("#yazsayi" + Urunler[i] + "").html(icBoyama[i]);
            }
        <?php } elseif ($HB == "DisBoyama") { ?>
            var DisBoyama = <?php echo json_encode($DisBoyama); ?>;

            for (let i = 0; i <= <?= $Urn ?>; i++) {
                $("#yazsayi" + Urunler[i] + "").html(DisBoyama[i]);
            }
        <?php } elseif ($HB == "Yıkama") { ?>
            var Yikama = <?php echo json_encode($Yikama); ?>;

            for (let i = 0; i < <?= $Urn ?>; i++) {
                $("#yazsayi" + Urunler[i] + "").html(Yikama[i]);
            }
        <?php } else { ?>
            var Paketle = <?php echo json_encode($Paketle); ?>;

            for (let i = 0; i < <?= $Urn ?>; i++) {
                $("#yazsayi" + Urunler[i] + "").html(Paketle[i]);
            }
        <?php } ?>
    </script>

<?php } elseif (isset($_POST['Deger'])) {
    $SetID = $_POST['SetID'];
    $UrunID = $_POST['UrunID'];
    $H = $_POST['Hangisi'];
    $K_Tarihi = $_POST['Tarih'];
    $Levha = $_POST['LevhaID'];

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
        $Is = "İçi Boyandı";
    } elseif ($H == "DisBoyama") {
        $Ekle = "DisBoyanan";
        $Is = "Dışı Boyandı";
    } elseif ($H == "Yıkama") {
        $Ekle = "Yikanan";
        $Is = "Yıkandı";
    } else {
        $Ekle = "Paketlenen";
        $Is = "Paketlendi";
    }
    for ($i = 0; $i < count($UrunID); $i++) {
        $tpl = $baglanti->query("SELECT " . $Ekle . " FROM set_urunler_asama WHERE Urun_ID = " . $UrunID[$i] . " AND Set_ID=" . $SetID)->fetch()[$Ekle];
        $sum = $Deger[$i] + $tpl;
        if ($Is == "Preslendi") {
            if (StokDus($Deger[$i], $K_Tarihi, $Kullanici, $UrunID[$i], $SetID, $Levha[$i]) === 0) {
                echo "StokYok";
            } else {
                $guncelle = $baglanti->prepare("UPDATE set_urunler_asama SET " . $Ekle . "= ? WHERE Urun_ID=? AND Set_ID=?");
                $guncelle->execute(array($sum, $UrunID[$i], $SetID));
                echo $sum; //Anlık Post Ajax.
                $kaydet = $baglanti->prepare("INSERT INTO set_urunler_asama_akis SET Set_ID= ?,Urun_ID= ?,Levha_ID= ?,Yapilan_is= ?,Adet= ?, Tarih= ?");
                $kaydet->execute(array($SetID, $UrunID[$i], $Levha[$i], $Is, $Deger[$i], $K_Tarihi));
            }
        } else {
            $guncelle = $baglanti->prepare("UPDATE set_urunler_asama SET " . $Ekle . "= ? WHERE Urun_ID=? AND Set_ID=?");
            $guncelle->execute(array($sum, $UrunID[$i], $SetID));
            echo $sum; //Anlık Post Ajax.
            $kaydet = $baglanti->prepare("INSERT INTO set_urunler_asama_akis SET Set_ID= ?,Urun_ID= ?,Levha_ID= ?,Yapilan_is= ?,Adet= ?, Tarih= ?");
            $kaydet->execute(array($SetID, $UrunID[$i], $Levha[$i], $Is, $Deger[$i], $K_Tarihi));
        }
    }
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
        if (StokDus($Deger[$i], $tarih, $Kullanici, $UrunID[$i], $SetID, $Lid[$i]) === 0) {
            echo "StokYok";
        } else {
            $kaydet = $baglanti->prepare("INSERT INTO set_urunler_asama_akis SET Set_ID= ?,Urun_ID= ?,Levha_ID=?,Yapilan_is= ?,Adet= ?, Tarih= ?");
            $kaydet->execute(array($SetID, $UrunID[$i], $Lid[$i], "Fire", $Deger[$i], $_POST['FTarih']));
        }
    }
    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########    ##########

} elseif (isset($_POST["isDurum"])) {
    $is = $_POST["Is"];
    $id = $_POST['isDurum']; ?>
    <table class="table table-sm table-responsive Tablois">
        <thead>
            <tr class="table-light">
                <th>Ürünler</th>
                <th>Adet</th>
                <th>İş</th>
                <th>Tarih</th>
                <th>&nbsp</th>
            </tr>
        </thead>
        <tbody><?php
                $isne = $is == "Preslendi" ? " OR Yapilan_is='Fire' AND set_urunler_asama_akis.Set_ID =" . $id . "" : "";
                $sorgu = $baglanti->query("SELECT ID, urun.Urun_ID, Levha_ID, UrunAdi, Yapilan_is, Adet, Tarih FROM set_urunler_asama_akis INNER JOIN urun ON set_urunler_asama_akis.Urun_ID = urun.Urun_ID WHERE Set_ID =" . $id . " AND Yapilan_is='$is'" . $isne . " ORDER BY Tarih");
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
                        <button class="btn btn-sm btn-danger bi-trash Sil" type="button" id="<?= $t["ID"] ?>" UrunID="<?= $t["Urun_ID"] ?>" Adet="<?= $adt ?>" LevhaID="<?= $t["Levha_ID"] ?>" is="<?= $t["Yapilan_is"] ?>" Tarih="<?= $Trh ?>"></button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <script>
        $('.Tablois').DataTable({
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
            scrollY: 400,
            paging: false,
            bFilter: false,
            bInfo: false
        });
        $(".Sil").click(function() {
            id = $(this).attr("id");
            UrunID = $(this).attr("UrunID");
            LevhaID = $(this).attr("LevhaID");
            is = $(this).attr("is");
            Adet = $(this).attr("Adet");
            Tarih = $(this).attr("Tarih");
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'GirSil': true,
                    'id': id,
                    'SetID': <?= $id ?>,
                    'UrunID': UrunID,
                    'LevhaID': LevhaID,
                    'is': is,
                    'Tarih': Tarih,
                    'Adet': Adet
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $(".isDurum").html(data);
                    $.Listele();
                }
            });
        });
    </script>
<?php
}
if (isset($_POST["GirSil"])) {
    $Sid = $_POST["SetID"];
    $Uid = $_POST["UrunID"];
    $Lid = $_POST["LevhaID"];
    $is = $_POST["is"];
    $Adet = $_POST["Adet"];
    if ($is == "Preslendi" || $is == "Fire") {
        $Ne = "Preslenen";

        $Lsid = $baglanti->query("SELECT Levha_Stok_ID FROM levha_giden WHERE SetID=" . $Sid . " AND UrunID=" . $Uid . " AND LevhaID=" . $Lid)->fetch()["Levha_Stok_ID"];
        $Hsp = $baglanti->query("SELECT Cap, Kalinlik FROM levha WHERE Levha_ID=" . $Lid)->fetch();
        $Cap = $Hsp["Cap"];
        $Kalinlik = $Hsp["Kalinlik"];
        //Hesap
        $Kg = ceil((($Cap * $Cap * $Kalinlik * (0.22)) * $Adet) / 1000);

        $Stok = $baglanti->prepare("UPDATE levha_gelen SET Stok_Adet=Stok_Adet+ ?, Stok_Agirlik=Stok_Agirlik+ ? WHERE Levha_Stok_ID= ?");
        $Stok->execute(array($Adet, $Kg, $Lsid));

        $Giden = $baglanti->prepare("UPDATE levha_giden SET Kullanilan_Adet=Kullanilan_Adet- ?, Kullanilan_Agirlik=Kullanilan_Agirlik- ? WHERE Levha_Stok_ID= ? AND SetID= ? AND UrunID= ? AND Gidis_Tarihi= ?");
        $Giden->execute(array($Adet, $Kg, $Lsid, $Sid, $Uid, "$_POST[Tarih]"));
        $baglanti->query("DELETE FROM levha_giden WHERE Kullanilan_Adet<=0 OR Kullanilan_Agirlik<=0");
    } elseif ($is == "Tellendi") {
        $Ne = "Tellenen";
    } elseif ($is == "Kumlandı") {
        $Ne = "Kumlanan";
    } elseif ($is == "İçi Boyandı") {
        $Ne = "icBoyanan";
    } elseif ($is == "Dışı Boyandı") {
        $Ne = "DisBoyanan";
    } elseif ($is == "Yıkandı") {
        $Ne = "Yikanan";
    } elseif ($is == "Paketlendi") {
        $Ne = "Paketlenen";
    }

    $baglanti->query("DELETE FROM set_urunler_asama_akis WHERE ID =" . $_POST["id"] . " AND Yapilan_is='$is'");
    $Adet = $baglanti->query("SELECT " . $Ne . " FROM set_urunler_asama WHERE Urun_ID = " . $Uid . " AND Set_ID=" . $Sid)->fetch()[$Ne];
    $Adet -= $_POST["Adet"];
    if ($Adet >= 0) {
        $guncelle = $baglanti->prepare("UPDATE set_urunler_asama SET " . $Ne . "= ? WHERE Urun_ID=? AND Set_ID=?");
        $guncelle->execute(array($Adet, $Uid, $Sid));
    }
}
/////////////////////////////////////////////////////////////////////////////////// Fire ve Preslenenlerde stok Miktarını ayarlamak için

function StokDus($Deger, $K_Tarihi, $Kullanici, $UrunID, $SetID, $Lid)
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

        if ($baglanti->query("SELECT Levha_Stok_ID FROM levha_giden WHERE Gidis_Tarihi='$K_Tarihi' AND Levha_Stok_ID=" . $Stokid . " AND SetID=" . $SetID . " AND UrunID=" . $UrunID . " AND LevhaID=" . $Lid)->rowCount()) {
            $Kaydet = $baglanti->prepare("UPDATE levha_giden SET Kullanilan_Adet=Kullanilan_Adet+?, Kullanilan_Agirlik=Kullanilan_Agirlik+?, Gidis_Tarihi= ?, Kullanici_ID= ? WHERE Levha_Stok_ID= ? AND Gidis_Tarihi= ? AND SetID= ? AND UrunID= ? AND LevhaID=?");
            $Kaydet->execute(array($Deger, $GAgirlik, $K_Tarihi, $Kullanici, $Stokid, "$K_Tarihi", $SetID, $UrunID, $Lid));
        } else {
            $Kaydet = $baglanti->prepare("INSERT INTO levha_giden SET Levha_Stok_ID= ?, Kullanilan_Adet= ?, Kullanilan_Agirlik= ?, Gidis_Tarihi= ?, Kullanici_ID= ?, UrunID= ?, SetID= ?, LevhaID=?");
            $Kaydet->execute(array($Stokid, $Deger, $GAgirlik, $K_Tarihi, $Kullanici, $UrunID, $SetID, $Lid));
        }
    } else {
        return 0;
    }
}
