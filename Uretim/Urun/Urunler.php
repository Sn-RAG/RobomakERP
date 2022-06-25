<?php
$page = "Ürünler";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">

                    <div class="card recent-sales overflow-auto">

                        <div class="card-body">
                            <h5 class="card-title"><?= $page ?></h5>
                            <hr>
                            <a href="UrunEkle.php">
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#Sec"><i class="bi bi-save me-1"></i>
                                    Yeni Kayıt
                                </button>
                            </a>
                            <hr>
                            <table class="table table-borderless datatable">
                                <thead>
                                <tr>
                                    <th scope="col">Kategori Adı</th>
                                    <th scope="col">Ürun Adı</th>
                                    <th scope="col">Fotoğraf</th>
                                    <th scope="col">Ürün Hakkında</th>
                                    <th>&nbsp</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sorgu = $baglanti->query("SELECT * FROM urun ORDER BY Kategori_ID ASC ");
                                foreach ($sorgu as $sonuc) {
                                    $Urun_ID = $sonuc['Urun_ID'];
                                    $Kategori_ID = $sonuc['Kategori_ID'];
                                    $UrunAdi = $sonuc['UrunAdi'];
                                    $UrunFoto = $sonuc['UrunFoto'];
                                    $Aciklama = $sonuc['Aciklama'];
                                    $sorgu2 = $baglanti->query("SELECT * FROM kategori WHERE Kategori_ID=" . $Kategori_ID);
                                    foreach ($sorgu2 as $sonuc2) {
                                        $Kategori_Adi = $sonuc2['Kategori_Adi'];
                                        ?>
                                        <tr>
                                            <th hidden><?= $Urun_ID ?></th>
                                            <th hidden><?= $Kategori_ID ?></th>
                                            <th><?= $Kategori_Adi ?></th>
                                            <td><?= $UrunAdi ?></td>
                                            <td>
                                                <img src="<?= $UrunFoto == "yok" ? "" : "../../assets/img/Keksan/" . $UrunFoto ?>">
                                            </td>
                                            <td><?= $Aciklama ?></td>
                                            <td>
                                                <a href="../UrunLevha/UrunLevhaBilgi.php?Urun_ID=<?= $Urun_ID ?>">
                                                    <button type="button" class="btn btn-info"><i
                                                                class="bi bi-disc"></i> Levha Bilgisi
                                                    </button>
                                                </a>
                                                <a href="../UrunBoya/UrunBoyaBilgi.php?Urun_ID=<?= $Urun_ID ?>">
                                                    <button type="button" class="btn btn-info">Boya Bilgisi <i
                                                                class="bi bi-brush"></i>
                                                    </button>
                                                </a>
                                                <a href="UrunDuzenle.php?Urun_ID=<?= $Urun_ID ?>&Kategori_ID=<?= $Kategori_ID ?>&KategoriAdi=<?= $Kategori_Adi ?>&UrunFoto=<?= $UrunFoto ?>&UrunAdi=<?= $UrunAdi ?>&Aciklama=<?= $Aciklama ?>">
                                                    <button type="button" class="btn btn-warning"><i
                                                                class="bi bi-pencil-square"></i></button>
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                    }
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