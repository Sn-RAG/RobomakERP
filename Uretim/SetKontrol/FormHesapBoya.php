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
                        $i = 0;
                        $TicUstkat = 0;
                        $TicAstar = 0;
                        $TDisUstkat = 0;
                        $TDisAstar = 0;

                        $icUstkat = [];
                        $icAstar = [];
                        $DisUstkat = [];
                        $DisAstar = [];

                        $Set = $baglanti->query('SELECT Adet, icBoya, DisBoya FROM set_urun_icerik WHERE Set_ID = ' . $id)->fetchAll();
                        $QUERY = $baglanti->query("SELECT Urun_ID,icBoya_ID,DisBoya_ID,Adet FROM view_set_urun_sec WHERE Set_ID =$id");
                        foreach ($QUERY as $b) {
                            $Uid = $b["Urun_ID"];
                            $Adet = $b["Adet"];
                            $icID = $b["icBoya_ID"];
                            $disID = $b["DisBoya_ID"];

                            $icBoya = $baglanti->query("SELECT icAstar,icUstkat FROM urun_boya_bilgi WHERE Urun_ID = $Uid AND Boya_ID=$icID");
                            $disBoya = $baglanti->query("SELECT DisAstar,DisUstkat FROM urun_boya_bilgi WHERE Urun_ID =$Uid AND Boya_ID=$disID");

                            if ($icBoya->rowCount() && $disBoya->rowCount()) {
                                //toplam ic boya
                                foreach ($icBoya as $bb) {
                                    $TicUstkat += $bb["icUstkat"] * $Adet;
                                    $TicAstar += $bb["icAstar"] * $Adet;
                                    $icUstkat[$i] = $bb["icUstkat"];
                                    $icAstar[$i] = $bb["icAstar"];
                                }
                                //toplam dış boya
                                foreach ($disBoya as $bb) {
                                    $TDisUstkat += $bb["DisUstkat"] * $Adet;
                                    $TDisAstar += $bb["DisAstar"] * $Adet;
                                    $DisUstkat[$i] = $bb["DisUstkat"];
                                    $DisAstar[$i] = $bb["DisAstar"];
                                }
                                $i++;
                            } else {
                                echo "<script>" . $BoyaBilgisiYok . "</script>";
                            }
                        }

                        ######################// Ürün Listele

                        $n = 1;
                        $sorgu = $baglanti->query("SELECT UrunAdi,Adet FROM view_set_urun_sec WHERE Set_ID =$id GROUP BY Urun_ID ORDER BY UrunAdi ASC");
                        foreach ($sorgu as $s) {
                            $icID = $b["icBoya_ID"];
                            $disID = $b["DisBoya_ID"];
                        ?>
                            <tr>
                                <td><?= $n++ ?></td>
                                <td><?= $s["UrunAdi"] ?></td>
                                <td><?= $s["Adet"] ?></td>
                                <!--<td><?= $icAstar[$i] ?></td>
                                <td><?= $icUstkat[$i] ?></td>
                                <td><?= $DisAstar[$i] ?></td>
                                <td><?= $DisUstkat[$i] ?></td>-->
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
                        <?php for ($i = 0; $i < count($Set); $i++) {

                            $ic = $Set[$i]["icBoya"];
                            $Dis = $Set[$i]["DisBoya"];
                            $iR = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $ic)->fetch()["Renk"];
                            $dR = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $Dis)->fetch()["Renk"];

                        ?>
                            <tr>
                                <td>
                                    <div class="d-flex justify-content-between ic"><span><?= $iR ?></span> Toplam= &nbsp <?= @number_format($Toplamic[$ic]) ?> &nbsp gr</div>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-between dis"><span><?= $dR ?></span> Toplam= &nbsp <?= @number_format($Toplamdis[$Dis]) ?> &nbsp gr</div>
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
    $(function() {
        $(".ic").map(function() {
            if ($(this).text() != "") {
                Uid.push($(this).attr("UrunID"));
                LevhaID.push($(this).attr("LevhaID"));
                deger.push($(this).val());
            }
        });
        $(".dis").map(function() {
            if ($(this).val() != "") {

            }
        });
    });
</script>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>