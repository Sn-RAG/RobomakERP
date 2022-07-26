<?php
$page = "Preshane Üretim Formu";
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
$SetID = (int)$_GET["id"];
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <button id="yazdir" class="btn btn-primary m-5">Yazdır</button>
                <div class="yazdir">
                    <div class="d-flex m-1 mb-5">
                        <div class="flex-fill col-md-4"><img src="../../assets/img/yazdir.jpg"></div>
                        <div class="flex-fill col-md-8 d-flex align-items-center text-center border border-dark">
                            <h5 class="flex-fill card-title">PRESHANE ÜRETİM FORMU</h5>
                        </div>
                    </div>
                    <div class="d-flex border border-dark m-1 mb-5 text-black">
                        <h5 class="p-2 card-text border-end m-0 text-center"> &nbsp FİRMA &nbsp </h5>
                        <h5 class="p-2 flex-fill card-text text-center"> &nbsp <?= $_GET["adi"] ?> &nbsp </h5>
                    </div>
                    <table class="table table-sm table-bordered">
                        <thead>
                            <tr class="table-light">
                                <th>SIRA NO</th>
                                <th>ÜRÜN ADI</th>
                                <th>LEVHA ÇAP</th>
                                <th>KALINLIK</th>
                                <th>ADET</th>
                                <th>MÜHÜR</th>
                                <th>DUDAK</th>
                                <th>1. EL PRES</th>
                                <th>2. EL PRES</th>
                                <th>3. EL PRES</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            $Listele = $baglanti->query('SELECT Kategori_ID,Urun_ID,UrunAdi,KulpAdi,Model_Adi,TepeAdi,icBoya_ID,Levha_ID FROM view_set_urun_sec WHERE Set_ID = ' . $SetID . " GROUP BY Urun_ID ORDER BY Kategori_ID ASC");
                            foreach ($Listele as $s) {
                                $Uid = $s["Urun_ID"];
                                $C = $baglanti->query("SELECT Cap FROM view_urun_levha_bilgi WHERE Levha_ID=" . $s['Levha_ID'] . " AND Urun_ID=" . $Uid);
                                if ($C->rowCount()) {
                            ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $s["UrunAdi"] ?></td>
                                        <td><?= $C->fetch()["Cap"] ?> cm</td>
                                        <td><?= $baglanti->query("SELECT Kalinlik FROM view_urun_levha_bilgi WHERE Levha_ID=" . $s['Levha_ID'] . " AND Urun_ID=" . $Uid)->fetch()["Kalinlik"] ?> mm</td>
                                        <td><?= $baglanti->query('SELECT SUM(Adet) AS Adet FROM set_urun_icerik WHERE Set_ID =' . $SetID)->fetch()["Adet"] ?></td>
                                        <td></td>
                                        <td></td>
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