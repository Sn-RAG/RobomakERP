<?php
ob_start();
$page = "Kulp Siparişleri";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Sil.php';
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $page ?></h5>
                                <hr>
                                <a href="Siparis.php">
                                    <button type="button" class="btn btn-secondary"><i
                                                class="bi bi-arrow-left-circle me-1"></i>Geri Dön
                                    </button>
                                </a>
                                <a href="KulpSiparis.php">
                                    <button type="button" class="btn btn-primary"><i class="bi bi-save me-1"></i>
                                        Yeni Sipariş
                                    </button>
                                </a>
                                <hr>
                                <table class="table table-borderless datatable">
                                    <thead>
                                    <tr>
                                        <th>Kulp Adı</th>
                                        <th>Kulp Çeşidi</th>
                                        <th>Renk</th>
                                        <th>Adet</th>
                                        <th>Tarih</th>
                                        <th>&nbsp</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sorgu = $baglanti->query('SELECT * FROM view_siparis_kulp');
                                    foreach ($sorgu as $sonuc) {
                                        $id = $sonuc['Kulp_Siparis_ID'];
                                        $Siparis_ID = $sonuc['Siparis_ID'];
                                        $Kulp_Stok_ID = $sonuc['Kulp_Stok_ID'];
                                        $Kalan_Siparis_Adet = $sonuc['Siparis_Adet'];
                                        $Siparis_Adet = $sonuc['Siparis_Adet'];
                                        $S_Tarihi = $sonuc['S_Tarihi'];
                                        $Kulp_ID = $sonuc['Kulp_ID'];
                                        $Firma_ID = $sonuc['Firma_ID'];
                                        $KulpAdi = $sonuc['KulpAdi'];
                                        $KulpCesidi = $sonuc['KulpCesidi'];
                                        $Renk = $sonuc['Renk'];
                                        $KulpFoto = $sonuc['KulpFoto'];
                                        $D_Tarihi = $sonuc['S_Tarihi'];
                                        ?>
                                        <tr>
                                            <th hidden><?= $id ?></th>
                                            <td hidden><?= $Kulp_Stok_ID ?></td>
                                            <td hidden><?= $Kulp_ID ?></td>
                                            <th hidden><?= $Siparis_ID ?></th>
                                            <th hidden><?= $Firma_ID ?></th>
                                            <th hidden><?= $D_Tarihi ?></th>
                                            <td><?= $KulpAdi ?></td>
                                            <td><?= $KulpCesidi ?></td>
                                            <td><?= $Renk ?></td>
                                            <td><?= $Siparis_Adet ?></td>
                                            <td><?= $S_Tarihi ?></td>
                                            <td>
                                                <button type="button" class="btn btn-outline-info"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#Bilgi<?= $id ?>"><i
                                                            class="bi bi-info-circle"></i>
                                                </button>

                                                <button type="button" class="btn btn-outline-warning"><i
                                                            class="bi bi-pencil-square"></i>
                                                </button>

                                                <button type="button" class="btn btn-outline-danger"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#SecSil<?= $id ?>"><i
                                                            class="bi bi-x-square"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                        require __DIR__ . '/Popups/KulpSiparisSecSil.php';
                                    }
                                    ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
require __DIR__ . '/../../controller/Footer.php';
ob_end_flush();
?>