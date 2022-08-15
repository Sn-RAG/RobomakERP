<?php
$page = "TYK Formu";
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
$SetID = (int)$_GET["id"];
?>
<html>

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
                <div class="d-flex mb-3">
                    <div class="flex-fill col-md-4"><img src="../../assets/img/yazdir.jpg"></div>
                    <div class="flex-fill col-md-8 d-flex align-items-center text-center border border-dark">
                        <h5 class="flex-fill card-title">TYK FORMU</h5>
                    </div>
                </div>
                <div class="d-flex border border-dark mb-3 text-black">
                    <h5 class="p-2 card-text border-end m-0 text-center"> &nbsp FİRMA &nbsp </h5>
                    <h5 class="p-2 flex-fill card-text text-center"> &nbsp <?= $_GET["adi"] ?> &nbsp </h5>
                </div>
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr class="table-light">
                            <th>SIRA NO</th>
                            <th>ÜRÜN ADI</th>
                            <th>ADET</th>
                            <th>TELLEME</th>
                            <th>YIKAMA</th>
                            <th>KUMLAMA</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        $Listele = $baglanti->query("SELECT urun.Urun_ID, UrunAdi, SUM( Adet ) AS tpl, levha.Levha_ID, levha.Cap, levha.Kalinlik FROM set_urunler INNER JOIN urun ON set_urunler.Urun_ID = urun.Urun_ID INNER JOIN levha ON set_urunler.Levha_ID = levha.Levha_ID WHERE Set_ID = $SetID GROUP BY set_urunler.Urun_ID ORDER BY urun.Urun_ID ASC");
                        foreach ($Listele as $s) {
                            $C = $baglanti->query("SELECT Cap FROM view_urun_levha_bilgi WHERE Levha_ID=" . $s['Levha_ID'] . " AND Urun_ID=" . $s['Urun_ID']);
                            if ($C->rowCount()) { ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $s["UrunAdi"] ?></td>
                                    <td><?= $s["tpl"] ?></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                        <?php } else {
                                echo "<script>" . $UrunLevhaYok . "</script>";
                            }
                        } ?>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <button id="yazdir" class="btn btn-lg btn-primary bi-printer">&nbsp Yazdır</button>
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