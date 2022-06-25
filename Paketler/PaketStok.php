<?php
$page = "Paket Stok";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title"><?= $page ?></h5>
                            <hr>
                            <a href="KutuKullanilanlar.php">
                                <button type="button" class="btn btn-primary"><i
                                            class="bi bi-tropical-storm me-1"></i>
                                    Kullanılan
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
                                    <th>&nbsp</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sorgu = $baglanti->query('SELECT * FROM view_siparis_kulp');
                                foreach ($sorgu as $sonuc) {
                                    $id = $sonuc['Kulp_Siprais_ID'];
                                    $Kalan_Siparis_Adet = $sonuc['Siparis_Adet'];
                                    $KulpAdi = $sonuc['KulpAdi'];
                                    $KulpCesidi = $sonuc['KulpCesidi'];
                                    $Renk = $sonuc['Renk'];
                                    $KulpFoto = $sonuc['KulpFoto'];
                                    $D_Tarihi = $sonuc['S_Tarihi'];
                                    ?>
                                    <tr>
                                        <th hidden><?= $id ?></th>
                                        <td><?= $KulpAdi ?></td>
                                        <td><?= $KulpCesidi ?></td>
                                        <td><?= $Renk ?></td>
                                        <td><?= $Kalan_Siparis_Adet ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-info"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#Bilgi<?= $id ?>"><i
                                                        class="bi bi-info-circle"></i>
                                            </button>

                                            <button type="button" class="btn btn-outline-primary" id="Gelen"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#Gelen<?= $id ?>"><i
                                                        class="bi bi-minecart"></i> Gelen
                                            </button>

                                            <button type="button" class="btn btn-outline-dark"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#Kullan<?= $id ?>"><i
                                                        class="bi bi-tropical-storm"></i> Kullan
                                            </button>
                                        </td>
                                    </tr>
                                    <?php
                                    require __DIR__ . '/Popups/PaketBilgi.php';
                                    require __DIR__ . '/Popups/PaketKullan.php';
                                    require __DIR__ . '/Popups/PaketGelen.php';
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
require __DIR__ . '/AjaxForm/Ajax.php';
ob_end_flush();
require __DIR__ . '/../controller/Footer.php';
?>