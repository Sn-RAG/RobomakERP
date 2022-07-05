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
                            <a href="../Urun/Urunler.php">
                                <button type="button" class="btn btn-secondary"><i
                                        class="bi bi-arrow-left-circle me-1"></i> Geri Dön
                                </button>
                            </a>
                            <a href="UrunLevhaBilgiEkle.php?Urun_ID=<?= $UrunID ?>">
                                <button type="button" class="btn btn-primary"><i class="bi bi-save me-1"></i>
                                    Yeni Kayıt
                                </button>
                            </a>
                            <hr>
                            <table class="table datatable">
                                <thead>
                                <tr>
                                    <th scope="col">Urun Adı</th>
                                    <th scope="col">Resim</th>
                                    <th scope="col">Tip</th>
                                    <th scope="col">Çap</th>
                                    <th scope="col">Kalınlık</th>
                                    <th>&nbsp</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sorgu2 = $baglanti->query("SELECT * FROM view_urun_levha_bilgi WHERE Urun_ID=" . $UrunID);
                                $sorgu2->execute();
                                while ($sonuc = $sorgu2->fetch()) {
                                    $id = $sonuc['Urun_Levha_Bilgi_ID'];
                                    $Urun_ID = $sonuc['Urun_ID'];
                                    $Levha_ID = $sonuc['Levha_ID'];
                                    $UrunAdi = $sonuc['UrunAdi'];
                                    $UrunFoto = $sonuc['UrunFoto'];
                                    $Tip = $sonuc['Tip'];
                                    $Cap = $sonuc['Cap'];
                                    $Kalinlik = $sonuc['Kalinlik'];
                                    $Duzenleme_Tarihi = $sonuc['Duzenleme_Tarihi'];
                                    ?>
                                    <tr>
                                        <th hidden><?= $id ?></th>
                                        <th hidden><?= $Urun_ID ?></th>
                                        <th hidden><?= $Levha_ID ?></th>
                                        <td><?= $UrunAdi ?></td>
                                        <td><img src="../../assets/img/Keksan/<?= $UrunFoto ?>" width="100" height="50"></td>
                                        <td><?= $Tip ?></td>
                                        <td><?= $Cap ?> cm</td>
                                        <td><?= $Kalinlik ?> mm</td>
                                        <td hidden><?= $Duzenleme_Tarihi ?></td>
                                        <td>
                                            <a href="UrunLevhaBilgiDuzenle.php?id=<?= $id ?>&Urun_ID=<?= $Urun_ID ?>&Levha_ID=<?= $Levha_ID ?>">
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
require __DIR__ . '/../../controller/Footer.php';
?>