<?php
require __DIR__ . '/../../../controller/Db.php';
require __DIR__ . "/../../../logtut.php";
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
    $KT = $_POST['Tarih'];

    $Levha = $_POST['LevhaID'];

    $iBoya = $_POST['iBoya'];
    $dBoya = $_POST['dBoya'];

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
            if (LStokDus($Deger[$i], $KT, $Kullanici, $UrunID[$i], $SetID, $Levha[$i]) === 0) {
                echo "StokYok";
                return;
            }
        } elseif ($Is == "İçi Boyandı") {
            if (BStokDus($Deger[$i], $KT, $Kullanici, $UrunID[$i], $SetID, $iBoya) === 0) {
                echo "StokYok";
                return;
            } else {
                $Boya = $iBoya;
            }
        } elseif ($Is == "Dışı Boyandı") {
            if (BStokDus($Deger[$i], $KT, $Kullanici, $UrunID[$i], $SetID, $dBoya) === 0) {
                echo "StokYok";
                return;
            } else {
                $Boya = $dBoya;
            }
        }
        $guncelle = $baglanti->prepare("UPDATE set_urunler_asama SET " . $Ekle . "= ? WHERE Urun_ID=? AND Set_ID=?");
        $guncelle->execute(array($sum, $UrunID[$i], $SetID));
        $kaydet = $baglanti->prepare("INSERT INTO set_urunler_asama_akis SET Set_ID= ?,Urun_ID= ?,Levha_ID= ?,Boya_ID= ?,Yapilan_is= ?,Adet= ?, Tarih= ?");
        $kaydet->execute(array($SetID, $UrunID[$i], $Levha[$i], $Boya, $Is, $Deger[$i], $KT));
        echo $sum; //Anlık Post Ajax.
    }
    
/*LOG KAYDI*/

logtut($Kullanici, "$SetID numaralı sette $Ekle kaydetti.");

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
        if (LStokDus($Deger[$i], $tarih, $Kullanici, $UrunID[$i], $SetID, $Lid[$i]) === 0) {
            echo "StokYok";
        } else {
            $kaydet = $baglanti->prepare("INSERT INTO set_urunler_asama_akis SET Set_ID= ?,Urun_ID= ?,Levha_ID=?,Yapilan_is= ?,Adet= ?, Tarih= ?");
            $kaydet->execute(array($SetID, $UrunID[$i], $Lid[$i], "Fire", $Deger[$i], $_POST['FTarih']));
        }
    }
    /*LOG KAYDI*/
    logtut($Kullanici, "$SetID numaralı sette Fire kaydetti.");
    
    /*LOG KAYDI SON*/
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
                $sorgu = $baglanti->query("SELECT ID, urun.Urun_ID, Levha_ID, Boya_ID, UrunAdi, Yapilan_is, Adet, Tarih FROM set_urunler_asama_akis INNER JOIN urun ON set_urunler_asama_akis.Urun_ID = urun.Urun_ID WHERE Set_ID =" . $id . " AND Yapilan_is='$is'" . $isne . " ORDER BY Tarih");
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
                        <button class="btn btn-sm btn-danger bi-trash Sil" type="button" id="<?= $t["ID"] ?>" UrunID="<?= $t["Urun_ID"] ?>" Adet="<?= $adt ?>" LevhaID="<?= $t["Levha_ID"] ?>" BoyaID="<?= $t["Boya_ID"] ?>" is="<?= $t["Yapilan_is"] ?>" Tarih="<?= $Trh ?>"></button>
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
            BoyaID = $(this).attr("BoyaID");
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
                    'BoyaID': BoyaID,
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
    $Bid = $_POST["BoyaID"];
    $is = $_POST["is"];
    $Adet = $_POST["Adet"];
    $KT = $_POST["Tarih"];
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
        $Giden->execute(array($Adet, $Kg, $Lsid, $Sid, $Uid, "$KT"));
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

    if ($is == "İçi Boyandı" || $is == "Dışı Boyandı") {
        $Stok = $baglanti->prepare("UPDATE boya_gelen SET  Stok_Miktar= Stok_Miktar+? WHERE Boya_ID= ?");
        $Stok->execute(array($Adet, $Bid));

        $Giden = $baglanti->prepare("UPDATE boya_giden SET Kullanilan_Miktar= Kullanilan_Miktar-? WHERE Gidis_Tarihi=? AND UrunID= ? AND SetID= ? AND BoyaID= ?");
        $Giden->execute(array($Adet, "$KT", $Uid, $Sid, $Bid));
        $baglanti->query("DELETE FROM boya_giden WHERE Kullanilan_Miktar <= 0");
    }

    $baglanti->query("DELETE FROM set_urunler_asama_akis WHERE ID =" . $_POST["id"] . " AND Yapilan_is='$is'");
    $Adet = $baglanti->query("SELECT " . $Ne . " FROM set_urunler_asama WHERE Urun_ID = " . $Uid . " AND Set_ID=" . $Sid)->fetch()[$Ne];
    $Adet -= $_POST["Adet"];
    if ($Adet >= 0) {
        $guncelle = $baglanti->prepare("UPDATE set_urunler_asama SET " . $Ne . "= ? WHERE Urun_ID=? AND Set_ID=?");
        $guncelle->execute(array($Adet, $Uid, $Sid));
    }
    
logtut($Kullanici, "$Sid numaralı setten $Ne sildi.");

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
