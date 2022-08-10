<?php
ob_start();
session_start();
$page = "Boya Hesabı";
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
@$id = (int)$_GET["id"];
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <title><?= $page ?></title>
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/vendor/datatables/datatables.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../../assets/css/style.css" rel="stylesheet">

    <!-- JQUERY -->
    <script src="../../assets/vendor/datatables/datatables.min.js"></script>
    <!-- SweetAlert -->
    <script src="../../assets/js/sweetalert2.all.min.js"></script>
</head>

<body style="background-color:white;">
    <div class="card">
        <div class="card-body">
            <br>
            <div class="yazdir">
                <table class="table table-sm small table-bordered">
                    <thead>
                        <tr>
                            <th>S_NO</th>
                            <th>Ürünler</th>
                            <th>Adet</th>
                            <th>İç Astar</th>
                            <th>İç Üstkat</th>
                            <th>Dış Astar</th>
                            <th>Dış Üstkat</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Hesap
                        $Tic = [];
                        $Tdis = [];
                        $TicA = [];
                        $TdisA = [];
                        $Set = $baglanti->query('SELECT Adet, icBoya, DisBoya FROM set_urun_icerik WHERE Set_ID = ' . $id)->fetchAll();
                        $QUERY = $baglanti->query("SELECT Urun_ID,icBoya_ID,DisBoya_ID,Adet FROM view_set_urun_sec WHERE Set_ID =$id");
                        foreach ($QUERY as $b) {
                            $Uid = $b["Urun_ID"];
                            $Adt = $b["Adet"];
                            $icID = $b["icBoya_ID"];
                            $disID = $b["DisBoya_ID"];

                            $icBoya = $baglanti->query("SELECT icAstar,icUstkat FROM urun_boya_bilgi WHERE Urun_ID = $Uid AND Boya_ID=$icID");
                            $disBoya = $baglanti->query("SELECT DisAstar,DisUstkat FROM urun_boya_bilgi WHERE Urun_ID =$Uid AND Boya_ID=$disID");

                            if ($icBoya->rowCount() && $disBoya->rowCount()) {
                                //toplam ic boya
                                foreach ($icBoya as $b) {
                                    @$TicA[$icID] += $b["icAstar"] * $Adt;
                                    @$Tic[$icID] += $b["icUstkat"] * $Adt;
                                }
                                //toplam dış boya
                                foreach ($disBoya as $b) {
                                    @$TdisA[$disID] += $b["DisAstar"] * $Adt;
                                    @$Tdis[$disID] += $b["DisUstkat"]  * $Adt;
                                }
                            } else {
                                echo "<script>" . $BoyaBilgisiYok . "</script>";
                            }
                        }

                        ######################// Ürün Listele

                        $n = 1;
                        $sorgu = $baglanti->query("SELECT Urun_ID,UrunAdi,Adet FROM view_set_urun_sec WHERE Set_ID =$id GROUP BY Urun_ID ORDER BY Adet,UrunAdi");
                        foreach ($sorgu as $s) {
                            $Gr = $baglanti->query("SELECT icAstar,icUstkat,DisAstar,DisUstkat FROM view_urun_boya_bilgi WHERE Urun_ID=" . $s["Urun_ID"])->fetch();
                        ?>
                            <tr>
                                <td><?= $n++ ?></td>
                                <td><?= $s["UrunAdi"] ?></td>
                                <td><?= $s["Adet"] ?></td>
                                <td><?= $Gr["icAstar"] ?> &nbsp gr</td>
                                <td><?= $Gr["icUstkat"] ?> &nbsp gr</td>
                                <td><?= $Gr["DisAstar"] ?> &nbsp gr</td>
                                <td><?= $Gr["DisUstkat"] ?> &nbsp gr</td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="7" class="text-center table-light">TOPLAM</th>
                        </tr>
                        <?php
                        $i = 0;
                        $renk = [];
                        $renkm = [];
                        $b = [];
                        foreach ($Set as $s) {
                            $ic = $s["icBoya"];
                            $Dis = $s["DisBoya"];
                            $iR = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $ic)->fetch()["Renk"];
                            $dR = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $Dis)->fetch()["Renk"];
                            if ($iR == "ŞEKER PEMBE") {
                                $icAstarAdi = "ŞEKER PEMBE ASTAR";
                            } elseif ($iR == "KREM") {
                                $icAstarAdi = "KREM ASTAR";
                            } elseif ($iR == "CAPUCİNO") {
                                $icAstarAdi = "CAPPICINO ASTAR";
                            } else {
                                $icAstarAdi = "SİYAH ASTAR";
                            }
                            if ($dR == "ŞEKER PEMBE") {
                                $disAstarAdi = "ŞEKER PEMBE ASTAR";
                            } elseif ($dR == "KREM") {
                                $disAstarAdi = "KREM ASTAR";
                            } elseif ($dR == "CAPUCİNO") {
                                $disAstarAdi = "CAPPICINO ASTAR";
                            } else {
                                $disAstarAdi = "SİYAH ASTAR";
                            }
                            if ($ic <> $Dis) {
                                @$b[$icAstarAdi] += $TicA[$ic];
                                @$b[$disAstarAdi] += $TdisA[$Dis];
                                $renk[$i] = $iR;
                                $renk[$i] = $dR;
                                $renkm[$i] = $Tic[$ic];
                                $renkm[$i] = $Tdis[$Dis];
                        ?>
                                <tr>
                                    <td>
                                        <div class="d">İç Astar &nbsp<span><?= $icAstarAdi ?></span><code><?= $TicA[$ic] / 1000 ?> kg</code></div>
                                    </td>
                                    <td>
                                        <div class="d">İç Üstkat<span><?= $iR ?></span><code><?= $Tic[$ic] / 1000 ?> kg</code></div>
                                    </td>
                                    <td>
                                        <div class="d">Dış Astar &nbsp<span><?= $disAstarAdi ?></span><code><?= $TdisA[$Dis] / 1000 ?> kg</code></div>
                                    </td>
                                    <td colspan="4">
                                        <div class="d">Dış Üstkat<span><?= $dR ?></span><code><?= $Tdis[$Dis] / 1000 ?> kg</code></div>
                                    </td>
                                </tr>
                            <?php } else {
                                @$b[$icAstarAdi] += $TicA[$ic] + $TdisA[$Dis];
                                $renk[$i] = $iR;
                                @$renkm[$i] = $Tic[$ic] + $Tdis[$Dis]; ?>
                                <tr>
                                    <td colspan="3">
                                        <div class="d">İç ve Dış Astar &nbsp<span><?= $icAstarAdi ?></span><code><?= @($TicA[$ic] + $TdisA[$Dis]) / 1000 ?> kg</code></div>
                                    </td>
                                    <td colspan="4">
                                        <div class="d">İç ve Dış Üstkat &nbsp<span><?= $iR ?></span><code><?= @($Tic[$ic] + $Tdis[$Dis]) / 1000 ?> kg</code></div>
                                    </td>
                                </tr>
                        <?php }
                            $i++;
                        } ?>
                        <tr>
                            <th colspan="7" class="text-center table-light">GENEL TOPLAM</th>
                        </tr>
                        <tr>
                            <?php for ($i = 0; $i < count($renk); $i++) { ?>
                                <td>
                                    <div class="d"><?= $renk[$i] ?><code><?= ceil($renkm[$i] / 1000) ?> kg</code></div>
                                </td>
                            <?php } ?>
                            <td colspan="<?= count($renk) < 7 ? 7 - count($renk) : count($renk) ?>"></td>
                        </tr>
                        <tr>
                            <?php
                            $i = 0;
                            $Astar = [];
                            $Astarm = [];
                            if (array_key_exists('CAPPICINO ASTAR', $b)) {
                                $Astar[$i] = "CAPPICINO";
                                $Astarm[$i] = ceil($b["CAPPICINO ASTAR"] / 1000);
                            ?>
                                <td>
                                    <div class="d">CAPPICINO ASTAR<code><?= $Astarm[$i] ?> kg</code></div>
                                </td>
                            <?php
                                $i++;
                            }
                            if (array_key_exists('KREM ASTAR', $b)) {
                                $Astar[$i] = "KREM";
                                $Astarm[$i] = ceil($b["KREM ASTAR"] / 1000); ?>
                                <td>
                                    <div class="d">KREM ASTAR<code><?= $Astarm[$i] ?> kg</code></div>
                                </td>
                            <?php
                                $i++;
                            }
                            if (array_key_exists('ŞEKER PEMBE ASTAR', $b)) {
                                $Astar[$i] = "ŞEKER PEMBE";
                                $Astarm[$i] = ceil($b["ŞEKER PEMBE ASTAR"] / 1000); ?>
                                <td>
                                    <div class="d">ŞEKER PEMBE ASTAR<code><?= $Astarm[$i] ?> kg</code></div>
                                </td>
                            <?php
                                $i++;
                            }
                            if (array_key_exists('SİYAH ASTAR', $b)) {
                                $Astar[$i] = "SİYAH";
                                $Astarm[$i] = ceil($b["SİYAH ASTAR"] / 1000) ?>
                                <td>
                                    <div class="d">SİYAH ASTAR<code><?= $Astarm[$i] ?> kg</code></div>
                                </td>
                            <?php
                                $i++;
                            }
                            ?>
                            <td colspan="<?= count($b) < 7 ? 7 - count($b) : count($b) ?>"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <h5 class="card-title">Set Adı: <?= $_GET["adi"] ?></h5>
                <button class="bi-printer" onclick="window.print()">&nbsp Yazdır</button>
                &nbsp
                <button id="Siparis" class="bi-file-text">&nbsp Sipariş</button>
            </div>
        </div>
    </div>
</body>

</html>
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .yazdir * {
            visibility: visible;
        }
    }
</style>
<script>
    $(function() {
        $(".d-flex").addClass("small");
        $("button").addClass("btn btn-primary");
        $(".d").addClass("d-flex justify-content-between");
    });
    $("#Siparis").click(function() {
        $.ajax({
            type: "POST",
            url: "FormHesapBoya.php",
            data: {
                'Siparis': true,
                'BAstar': <?= json_encode($Astar) ?>,
                'BAstarm': <?= json_encode($Astarm) ?>,
                'BRenk': <?= json_encode($renk) ?>,
                'BRenkm': <?= json_encode($renkm) ?>
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            },
            success: function() {
                window.location.assign("../../SatinAlma/Siparis/SiparisListesi.php");
            }
        })
    });
</script>
<?php
if (isset($_POST["Siparis"])) {
    $_SESSION["BAstar"] = $_POST["BAstar"];
    $_SESSION["BAstarm"] = $_POST["BAstarm"];
    $_SESSION["BRenk"] = $_POST["BRenk"];
    $_SESSION["BRenkm"] = $_POST["BRenkm"];
    $_SESSION["Boyalar"] = true;
}
?>