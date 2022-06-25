<?php
ob_start();
$page = "Boya Siparişleri";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Sil.php';
unset($_SESSION["Miktar"],$_SESSION["Boyalar"]);
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title"><?= $page ?></h5>
                            <hr>
                            <a href="<?=isset($_GET["Gecmis"])?"BoyaSiparisleri.php": "../../Navigasyon/SiparisEt.php"?>" class='btn btn-secondary bi-arrow-left-circle me-3 mb-1'>&nbsp Geri Dön</a>
                            <a href="BoyaSiparis.php" class="btn btn-primary bi-save me-3 mb-1" <?=isset($_GET["Gecmis"])?"hidden": ""?>>&nbsp Yeni Sipariş</a>
                            <a href="BoyaSiparisleri.php?Gecmis" class="btn btn-success bi-clock-history mb-1" <?=isset($_GET["Gecmis"])?"hidden": ""?>>&nbsp Sipariş Geçmişi</a>
                            <hr>
                            <table class="table datatablem">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#</th>
                                    <th>#</th>
                                    <th>Marka</th>
                                    <th>Renk</th>
                                    <th>Seri</th>
                                    <th>Ağırlık</th>
                                    <th>Sipariş Tarihi</th>
                                    <th>&nbsp</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($_GET["Gecmis"])){
                                    $isaret="<=";
                                }else{
                                    $isaret=">";
                                }
                                $sorgu = $baglanti->query("SELECT Boya_Siparis_ID,Boya_Stok_ID,Siparis_ID,Marka,Renk,Seri,Siparis_Miktar,S_Tarihi FROM view_siparis_boya WHERE Siparis_Miktar ".$isaret." 0");
                                foreach ($sorgu as $sonuc) {
                                    $id = $sonuc['Boya_Siparis_ID'];
                                    $Boya_Stok_ID = $sonuc['Boya_Stok_ID'];
                                    $Siparis_ID = $sonuc['Siparis_ID'];
                                    $Marka = $sonuc['Marka'];
                                    $Renk = $sonuc['Renk'];
                                    $Seri = $sonuc['Seri'];
                                    $Siparis_Miktar = $sonuc['Siparis_Miktar'];
                                    $S_Tarihi = $sonuc['S_Tarihi'];
                                    ?>
                                    <tr>
                                        <th><?= $id ?></th>
                                        <td><?= $Boya_Stok_ID ?></td>
                                        <th><?= $Siparis_ID ?></th>
                                        <td><?= $Marka ?></td>
                                        <td><?= $Renk ?></td>
                                        <td><?= $Seri ?></td>
                                        <td><?= $Siparis_Miktar . " Kg" ?></td>
                                        <td><?= $S_Tarihi ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#SecSil<?= $id ?>"><i
                                                        class="bi bi-x-square"></i>
                                            </button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="SecSil<?= $id ?>" tabindex="-1" aria-hidden="true"
                                         style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tarihe Göre Sil</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    echo "<H5 class='text-center'>KULLAN</H5>";
                                                    $sor = $baglanti->query('SELECT Boya_Giden_ID, Duzenleme_Tarihi FROM boya_giden WHERE Boya_Stok_ID=' . $Boya_Stok_ID);
                                                    foreach ($sor as $sonuc4) {

                                                        echo "<a href='BoyaSiparisleri.php?BoyaGidenSil=$sonuc4[Boya_Giden_ID]'><div class='form-floating mb-1'><button class='form-control btn-outline-danger'>$sonuc4[Duzenleme_Tarihi]</button><label>Kullanma Tarihi</label></div></a>";

                                                    }
                                                    echo "<h5 class='text-center'>STOK</h5>";
                                                    $sor3 = $baglanti->query('SELECT Boya_Giden_ID FROM boya_giden WHERE Boya_Stok_ID=' . $Boya_Stok_ID)->fetch();
                                                    @$kntrl = $sor3["Boya_Giden_ID"];
                                                    $sor2 = $baglanti->query('SELECT Boya_Gelen_ID, Duzenleme_Tarihi FROM boya_gelen WHERE Boya_Stok_ID=' . $Boya_Stok_ID);
                                                    foreach ($sor2 as $sonuc5) {

                                                        echo "<a href='BoyaSiparisleri.php?BoyaGelenSil=$sonuc5[Boya_Gelen_ID]&BoyaGdnKntrl=$kntrl'><div class='form-floating mb-1'><button class='form-control btn-outline-danger'>$sonuc5[Duzenleme_Tarihi]</button><label>Teslim Tarihi</label></div></a>";

                                                    }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="BoyaSiparisleri.php?Boya_Siparis_Sil=<?= $id ?>&Boya_Stok_ID=<?= $Boya_Stok_ID ?>&Siparis_ID=<?= $Siparis_ID ?>">
                                                        <button type="button"
                                                                class="btn btn-outline-danger form-control">Sipariş Sil
                                                        </button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <?php
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
    <script>
        $('.datatablem').DataTable({
            responsive: true,
            order: [[0, 'DESC']],
            columnDefs: [
                {responsivePriority:1, targets: -1},
                {"visible": false, "targets": [0, 1, 2]},
                {targets: 8, orderable: false}
            ],
            pageLength: 100,
            lengthMenu: [[25, 50, 100, -1],['25 Adet', '50 Adet', '100 Adet', 'Tümü']]
        });
    </script>
<?php
require __DIR__ . '/../../controller/Footer.php';
ob_end_flush();
?>