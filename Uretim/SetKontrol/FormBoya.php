<?php
$page = "Boyahane Üretim Formu";
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Header.php';
$SetID = (int)$_GET["id"];
$Boyalar = $baglanti->query('SELECT DisBoya_ID, Renk AS icRenk FROM set_urunler INNER JOIN boya ON set_urunler.icBoya_ID = boya.Boya_ID WHERE Set_ID = ' . $SetID . " GROUP BY icBoya_ID, DisBoya_ID")->fetchAll();
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <button id="yazdir" class="btn btn-primary m-5">Yazdır</button>
                <div class="yazdir">
                    <div class="d-flex border border-dark m-1 mb-5 text-black">
                        <h5 class="p-2 flex-fill col-md-4 card-text border-end m-0 text-center"> &nbsp BOYAHANE ÜRETİM FORMU &nbsp </h5>
                        <h5 class="p-2 flex-fill col-md-2 card-text border-end m-0 text-center"> &nbsp FİRMA &nbsp </h5>
                        <h5 class="p-2 flex-fill col-md-6 card-text text-center"> &nbsp <?= $_SESSION["SetAdi"] ?> &nbsp </h5>
                    </div>
                    <table class="table table-sm table-bordered text-center">
                        <thead>
                            <tr>
                                <th rowspan="2" colspan="2"></th>
                                <th rowspan="2" style="vertical-align: middle; text-align:center;">TOPLAM</th>
                                <?php
                                for ($i = 0; $i < count($Boyalar); $i++) {
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
                                for ($i = 0; $i < count($Boyalar); $i++) {
                                    echo "<th colspan='2'>ADET</th>";
                                }
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $Listele = $baglanti->query('SELECT urun.Urun_ID,UrunAdi, SUM(Adet) AS Adet FROM set_urunler INNER JOIN urun ON set_urunler.Urun_ID = urun.Urun_ID WHERE Set_ID = ' . $SetID . " GROUP BY set_urunler.Urun_ID");
                            foreach ($Listele as $s) {
                                $Uid = $s["Urun_ID"] ?>
                                <tr>
                                    <th><?= $i++ ?></th>
                                    <td><?= $s["UrunAdi"] ?></td>
                                    <td><?= $s["Adet"] ?></td>
                                    <?php
                                    for ($i = 0; $i < count($Boyalar); $i++) {
                                        echo "<td colspan='2'></td>";
                                    }
                                    ?>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
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
<?php require __DIR__ . '/../../controller/Footer.php'; ?>