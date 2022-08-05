<?php
$page = "Ürün Levha Bilgisi";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
$UrunID = (int)$_GET['Urun_ID'];
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card recent-sales overflow-auto">

                    <div class="card-body">
                        <h5 class="card-title"><?= $page ?></h5>
                        <hr>
                        <a href="../Urun/Urunler.php" class="btn btn-secondary bi-arrow-left me-1">&nbsp Geri Dön</a>
                        <a href="UrunLevhaBilgiEkle.php?Urun_ID=<?= $UrunID ?>" class="btn btn-primary bi-save">&nbsp Yeni Kayıt</a>
                        <hr>
                        <table class="table datatable">
                            <thead>
                                <tr>
                                    <th>Urun Adı</th>
                                    <th>Resim</th>
                                    <th>Tip</th>
                                    <th>Çap</th>
                                    <th>Kalınlık</th>
                                    <th>&nbsp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sorgu2 = $baglanti->query("SELECT * FROM view_urun_levha_bilgi WHERE Urun_ID=" . $UrunID);
                                foreach ($sorgu2 as $s) {
                                    $id = $s['Urun_Levha_Bilgi_ID'];
                                    $Levha_ID = $s['Levha_ID'];
                                    //Köşeli mi?
                                    $bak = $s['Cap2'] <> null ? " &nbsp <i class='bi-dash-lg'></i> &nbsp " . $s['Cap2'] . " cm" : "";
                                ?>
                                    <tr>
                                        <th hidden><?= $id ?></th>
                                        <td><?= $s['UrunAdi'] ?></td>
                                        <td><img src="../../assets/img/Keksan/<?= $s['UrunFoto'] ?>" width="100" height="50"></td>
                                        <td><?= $s['Tip'] ?></td>
                                        <td><?= $s['Cap'] . " cm " . $bak ?></td>
                                        <td><?= $s['Kalinlik'] ?> mm</td>
                                        <td>
                                            <a href="UrunLevhaBilgiDuzenle.php?id=<?= $id ?>&Urun_ID=<?= $UrunID ?>&Levha_ID=<?= $Levha_ID ?>" class="btn btn-warning bi-pencil">&nbsp Düzenle</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->

                    </div>
                </div>

            </div>
        </div>
    </section>
</main><!-- End #main -->

<?php
ob_end_flush();
require __DIR__ . '/../../controller/Footer.php';
?>