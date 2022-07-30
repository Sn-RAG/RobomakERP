<?php
$page = "Boya Hesabı";
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
$id = (int)$_GET["id"];
?>
<html>

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
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        //Hesap
                        $Toplamic = [];
                        $Toplamdis = [];
                        $Set = $baglanti->query('SELECT Adet, icBoya, DisBoya FROM set_urun_icerik WHERE Set_ID = ' . $id)->fetchAll();
                        $QUERY = $baglanti->query("SELECT Urun_ID,icBoya_ID,DisRenk,Adet FROM view_set_urun_sec WHERE Set_ID =$id");
                        foreach ($QUERY as $b) {
                            $Uid = $b["Urun_ID"];
                            $Adet = $b["Adet"];
                            $icRenk = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $b["icBoya_ID"])->fetch()["Renk"];
                            $disRenk = $b["DisRenk"];

                            $icBoya = $baglanti->query("SELECT icAstar,icUstkat FROM view_urun_boya_bilgi WHERE Urun_ID = " . $Uid . " AND Renk='$icRenk'");
                            $disBoya = $baglanti->query("SELECT DisAstar,DisUstkat FROM view_urun_boya_bilgi WHERE Urun_ID = " . $Uid . " AND Renk='$disRenk'");

                            if ($icBoya->rowCount() && $disBoya->rowCount()) {
                                //toplam ic boya
                                foreach ($icBoya as $bb) {
                                    $ic = (($bb["icAstar"] + $bb["icUstkat"]) / 1000) * $Adet;
                                    @$Toplamic["$icRenk"] += $ic; // Boyaya özel toplam
                                }

                                //toplam dış boya
                                foreach ($disBoya as $bb) {
                                    $dis = (($bb["DisAstar"] + $bb["DisUstkat"]) / 1000) * $Adet;
                                    @$Toplamdis["$disRenk"] += $dis; // Boyaya özel toplam
                                }
                            } else {
                                echo "<script>" . $BoyaBilgisiYok . "</script>";
                            }
                        }

                        ######################// Ürün Listele

                        $n = 1;
                        $sorgu = $baglanti->query("SELECT UrunAdi,Adet FROM view_set_urun_sec WHERE Set_ID =$id GROUP BY Urun_ID ORDER BY UrunAdi ASC");
                        foreach ($sorgu as $s) {
                        ?>
                            <tr>
                                <td><?= $n++ ?></td>
                                <td><?= $s["UrunAdi"] ?></td>
                                <td><?= $s["Adet"] ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <th colspan="3" class="text-center table-light">TOPLAM</th>
                        </tr>
                        <tr>
                            <th>İç Boya</th>
                            <th>Dış Boya</th>
                            <th rowspan="<?= count($Set) + 1 ?>"></th>
                        </tr>
                        <?php foreach ($Set as $s) {
                            $iR = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $s["icBoya"])->fetch()["Renk"];
                            $dR = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $s["DisBoya"])->fetch()["Renk"];
                        ?>
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-between"><span><?= $iR ?></span> Toplam= <?= @$Toplamic["$iR"] ?> Kg</div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between"><span><?= $dR ?></span> Toplam= <?= @$Toplamdis["$dR"] ?> Kg</div>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
            </div>

            <div class="text-center">
                <h5 class="card-title">Set Adı: <?= $_GET["adi"] ?></h5>
                <button id="yazdir" class="btn btn-lg btn-primary">Yazdır</button>
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
    $("#yazdir").click(function() {
        window.print();
    });
</script>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>