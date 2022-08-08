<?php
$page = "Ürün Boya Bilgisi";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
$UrunID = (int)$_GET['Urun_ID'];
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title border-bottom mb-3"><?= $page ?></h5>
                <a href="../Urun/Urunler.php" class="btn btn-secondary bi-arrow-left-circle mb-2"> &nbsp Geri Dön</a>
                <a href="UrunBoyaBilgiEkle.php?Urun_ID=<?= $UrunID ?>" class="btn btn-primary bi-save mb-2"> &nbsp Yeni Kayıt</a>
            </div>
            <div class="card-body">
                <table class="table table-sm datatable">
                    <thead>
                        <tr>
                            <th>Urun Adı</th>
                            <th>Marka</th>
                            <th>Renk</th>
                            <th>İç - Astar</th>
                            <th>İç - Üst Kat</th>
                            <th>Dış - Astar</th>
                            <th>Dış - Üst Kat</th>
                            <th>&nbsp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sor = $baglanti->query("SELECT * FROM view_urun_boya_bilgi WHERE Urun_ID=" . $UrunID);
                        foreach ($sor as $s) {
                            $id = $s['Urun_Boya_Bilgi_ID'];
                            $Urun_ID = $s['Urun_ID'];
                            $R = $s['Renk'];
                        ?>
                            <tr>
                                <th hidden><?= $id ?></th>
                                <th hidden><?= $Urun_ID ?></th>
                                <td><?= $s['UrunAdi'] ?></td>
                                <td><?= $s['Marka'] ?></td>
                                <td><?= $R ?></td>
                                <td><?= $s['icAstar'] ?> gr</td>
                                <td><?= $s['icUstkat'] ?> gr</td>
                                <td><?= $s['DisAstar'] ?> gr</td>
                                <td><?= $s['DisUstkat'] ?> gr</td>
                                <td><a href="UrunBoyaBilgiDuzenle.php?id=<?= $id ?>&Urun_ID=<?= $Urun_ID ?>&Renk=<?= $R ?>" class="btn btn-sm btn-warning bi-pencil"> &nbsp Düzenle</a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
<?php
ob_end_flush();
require __DIR__ . '/../../controller/Footer.php';
?>