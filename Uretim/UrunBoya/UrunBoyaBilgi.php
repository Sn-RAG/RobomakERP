<?php
$page = "Ürün Boya Bilgisi";
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
                            <a href="../Urun/Urunler.php">
                                <button type="button" class="btn btn-secondary"><i
                                            class="bi bi-arrow-left-circle me-1"></i> Geri Dön
                                </button>
                            </a>
                            <a href="UrunBoyaBilgiEkle.php?Urun_ID=<?= $UrunID ?>">
                                <button type="button" class="btn btn-primary"><i class="bi bi-save me-1"></i>
                                    Yeni Kayıt
                                </button>
                            </a>
                            <hr>
                            <table class="table table-borderless datatable">
                                <thead>
                                <tr>
                                    <th scope="col">Urun Adı</th>
                                    <th scope="col">Resim</th>
                                    <th scope="col">Boya Tipi</th>
                                    <th scope="col">İç - Astar</th>
                                    <th scope="col">İç - Üst Kat</th>
                                    <th scope="col">Dış - Astar</th>
                                    <th scope="col">Dış - Üst Kat</th>
                                    <th>&nbsp</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sorgu2 = $baglanti->query("SELECT * FROM view_urun_boya_bilgi WHERE Urun_ID=" . $UrunID);
                                $sorgu2->execute();
                                while ($sonuc = $sorgu2->fetch()) {
                                    $id = $sonuc['Urun_Boya_Bilgi_ID'];
                                    $Urun_ID = $sonuc['Urun_ID'];
                                    $UrunAdi = $sonuc['UrunAdi'];
                                    $UrunFoto = $sonuc['UrunFoto'];
                                    $BoyaTipi = $sonuc['BoyaTipi'];
                                    $icAstar = $sonuc['icAstar'];
                                    $icUstkat = $sonuc['icUstkat'];
                                    $DisAstar = $sonuc['DisAstar'];
                                    $DisUstkat = $sonuc['DisUstkat'];
                                    $Duzenleme_Tarihi = $sonuc['Duzenleme_Tarihi'];
                                    ?>
                                    <tr>
                                        <th hidden><?= $id ?></th>
                                        <th hidden><?= $Urun_ID ?></th>
                                        <td><?= $UrunAdi ?></td>
                                        <td><img src="../../assets/img/Keksan/<?= $UrunFoto ?>"></td>
                                        <td><?= $BoyaTipi ?></td>
                                        <td><?= $icAstar ?> gr</td>
                                        <td><?= $icUstkat ?> gr</td>
                                        <td><?= $DisAstar ?> gr</td>
                                        <td><?= $DisUstkat ?> gr</td>
                                        <td hidden><?= $Duzenleme_Tarihi ?></td>
                                        <td>
                                            <a href="UrunBoyaBilgiDuzenle.php?id=<?= $id ?>&Urun_ID=<?= $Urun_ID ?>">
                                                <button type="button" class="btn btn-warning">
                                                    <i class="bi bi-pencil me-1"></i>
                                                    Düzenle
                                                </button>
                                            </a>
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
require __DIR__ . '/../controller/Footer.php';
?>