<?php
$page = "Kulp Stok";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/VTHataMesaji.php';
?>
     <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title"><?= $page ?></h5>
                            <hr>
                            <a href="KulpKullanilanlar.php">
                                <button type="button" class="btn btn-primary"><i class="bi bi-tropical-storm me-1"></i>Kullanılan
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
                                    $id = $sonuc['Kulp_Stok_ID'];
                                    $Kulp_Siparis_ID = $sonuc['Kulp_Siparis_ID'];
                                    $Siparis_Adet = $sonuc['Siparis_Adet'];
                                    $KulpAdi = $sonuc['KulpAdi'];
                                    $KulpCesidi = $sonuc['KulpCesidi'];
                                    $Renk = $sonuc['Renk'];
                                    $KulpFoto = $sonuc['KulpFoto'];
                                    $D_Tarihi = $sonuc['S_Tarihi'];

                                    $sorguS = $baglanti->query('SELECT SUM(Stok_Adet) AS SumStok_Adet FROM kulp_gelen WHERE Kulp_Stok_ID=' . $id);
                                    foreach ($sorguS as $sonuc2) {
                                        $Stok_Adet = $sonuc2['SumStok_Adet'];

                                        $sorguK = $baglanti->query('SELECT SUM(Kullanilan_Adet) AS SumKullanilan_Adet FROM kulp_giden WHERE Kulp_Stok_ID=' . $id);
                                        foreach ($sorguK as $sonuc3) {
                                            $K_Adet = $sonuc3['SumKullanilan_Adet'];
                                            ?>
                                            <tr>
                                                <th hidden><?= $id ?></th>
                                                <th hidden><?= $Kulp_Siparis_ID ?></th>
                                                <td><?= $KulpAdi ?></td>
                                                <td><?= $KulpCesidi ?></td>
                                                <td><?= $Renk ?></td>
                                                <td><?= $Siparis_Adet ?></td>
                                                <td>
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
                                            require __DIR__ . '/Popups/KulpKullan.php';
                                            require __DIR__ . '/Popups/KulpGelen.php';
                                        }
                                    }
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