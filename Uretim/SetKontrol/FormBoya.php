<?php
$page = "Boyahane Üretim Formu";
require __DIR__ . '/../../controller/Db.php';
$SetID = (int)$_GET["id"];
$Boyalar = $baglanti->query('SELECT DisBoya_ID, Renk AS icRenk FROM set_urunler INNER JOIN boya ON set_urunler.icBoya_ID = boya.Boya_ID WHERE Set_ID = ' . $SetID . " GROUP BY icBoya_ID, DisBoya_ID")->fetchAll();
$Say = count($Boyalar);
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
                <div class="d-flex border border-dark mb-3">
                    <h5 class="p-2 flex-fill col-md-4 card-text border-end m-0 text-center"> &nbsp BOYAHANE ÜRETİM FORMU &nbsp </h5>
                    <h5 class="p-2 flex-fill col-md-2 card-text border-end m-0 text-center"> &nbsp FİRMA &nbsp </h5>
                    <h5 class="p-2 flex-fill col-md-6 card-text text-center"> &nbsp <?= $_GET["adi"] ?> &nbsp </h5>
                </div>
                <table class="table table-sm table-bordered text-center">
                    <thead>
                        <tr>
                            <th rowspan="2" colspan="2"></th>
                            <th rowspan="2" style="vertical-align: middle; text-align:center;">TOPLAM</th>
                            <?php
                            for ($i = 0; $i < $Say; $i++) {
                                echo "<th>İç Renk<th>Dış Renk</th></th>";
                            }
                            ?>
                        </tr>
                        <tr>
                            <?php
                            foreach ($Boyalar as $I) { ?>
                                <th><?= $I["icRenk"] ?>
                                    <?php
                                    foreach ($baglanti->query('SELECT Renk AS DisRenk FROM boya WHERE Boya_ID = ' . $I["DisBoya_ID"]) as $D) {
                                        echo "<th>" . $D["DisRenk"] . "</th>";
                                    }
                                    ?>
                                </th>
                            <?php } ?>
                        </tr>
                        <tr>
                            <th>SIRA NO</th>
                            <th>ÜRÜN ADI</th>
                            <th>ADET</th>
                            <?php
                            for ($i = 0; $i < $Say; $i++) {
                                echo "<th colspan='2'>ADET</th>";
                            }
                            ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $ii = 1;
                        $Listele = $baglanti->query('SELECT urun.Urun_ID,UrunAdi, SUM(Adet) AS tpl,Adet FROM set_urunler INNER JOIN urun ON set_urunler.Urun_ID = urun.Urun_ID WHERE Set_ID = ' . $SetID . " GROUP BY set_urunler.Urun_ID ORDER BY Adet ASC");
                        foreach ($Listele as $s) {
                            $Uid = $s["Urun_ID"] ?>
                            <tr>
                                <th><?= $ii++ ?></th>
                                <td><?= $s["UrunAdi"] ?></td>
                                <td><?= $s["tpl"] ?></td>
                                <?php
                                for ($i = 0; $i < $Say; $i++) {
                                    echo "<td colspan='2'>$s[Adet]</td>";
                                }
                                ?>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
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