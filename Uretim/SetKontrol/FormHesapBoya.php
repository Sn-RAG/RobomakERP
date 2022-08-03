<?php
$page = "Boya Hesabı";
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
$id = (int)$_GET["id"];
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <title><?= $page ?></title>
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>S_NO</th>
                            <th>Ürünler</th>
                            <th>Adet</th>
                            <th>İç Astar</th>
                            <th>İç Boya</th>
                            <th>Dış Astar</th>
                            <th>Dış Boya</th>
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
                        $sorgu = $baglanti->query("SELECT Urun_ID,UrunAdi,Adet FROM view_set_urun_sec WHERE Set_ID =$id GROUP BY Urun_ID ORDER BY UrunAdi ASC");
                        foreach ($sorgu as $s) {
                            $Gr = $baglanti->query("SELECT icAstar,icUstkat,DisAstar,DisUstkat FROM view_urun_boya_bilgi WHERE Urun_ID=" . $s["Urun_ID"])->fetch();
                        ?>
                            <tr>
                                <td><?= $n++ ?></td>
                                <td><?= $s["UrunAdi"] ?></td>
                                <td><?= $s["Adet"] ?></td>
                                <td><?= $Gr["icAstar"] ?></td>
                                <td><?= $Gr["icUstkat"] ?></td>
                                <td><?= $Gr["DisAstar"] ?></td>
                                <td><?= $Gr["DisUstkat"] ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="7" class="text-center table-light">TOPLAM</th>
                        </tr>
                        <?php foreach ($Set as $s) {
                            $ic = $s["icBoya"];
                            $Dis = $s["DisBoya"];
                            $iR = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $ic)->fetch()["Renk"];
                            $dR = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $Dis)->fetch()["Renk"];
                            if ($ic <> $Dis) { ?>
                                <tr class="small">
                                    <td>
                                        <div class="d-flex justify-content-between"><span><b>İç Astar</b> &nbsp <?= $iR ?></span><?= @number_format($TicA[$ic]) ?> &nbsp gr</div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between"><span><b>İç Boya</b> &nbsp <?= $iR ?></span><?= @number_format($Tic[$ic]) ?> &nbsp gr</div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between"><span><b>Dış Astar</b> &nbsp <?= $dR ?></span><?= @number_format($TdisA[$Dis]) ?> &nbsp gr</div>
                                    </td>
                                    <td>
                                        <div class="d-flex justify-content-between"><span><b>Dış Boya</b> &nbsp <?= $dR ?></span><?= @number_format($Tdis[$Dis]) ?> &nbsp gr</div>
                                    </td>
                                </tr>
                            <?php } else {
                                if ($iR == "ŞEKER PEMBE") {
                                    $AstarAdi="ŞEKER PEMBE ASTAR";
                                }elseif($iR == "KREM"){
                                    $AstarAdi="KREM ASTAR";
                                }elseif($iR == "CAPUCİNO"){
                                    $AstarAdi="CAPPICINO ASTAR";
                                }else{
                                    $AstarAdi="SİYAH ASTAR";
                                } ?>
                                <tr class="small">
                                    <td colspan="4">
                                        <div class="d-flex justify-content-between"><span><b><?= $AstarAdi ?></b> &nbsp </span><?= @number_format($TicA[$ic] + $TdisA[$Dis]) ?> &nbsp gr</div>
                                    </td>
                                    <td colspan="3">
                                        <div class="d-flex justify-content-between"><span><b>Boya</b> &nbsp <?= $iR ?></span><?= @number_format($Tic[$ic] + $Tdis[$Dis]) ?> &nbsp gr</div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>

                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <h5 class="card-title">Set Adı: <?= $_GET["adi"] ?></h5>
                <button id="yazdir" class="btn btn-lg btn-primary" onclick="window.print()">Yazdır</button>
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

<?php
require __DIR__ . '/../../controller/Footer.php';
?>