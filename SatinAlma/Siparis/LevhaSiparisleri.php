<?php
ob_start();
$page = "Levha Siparişleri";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Sil.php';
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title"><?= $page ?></h5>
                            <hr>
                            <a href="../../Navigasyon/SiparisEt.php">
                                <button type="button" class="btn btn-secondary"><i
                                            class="bi bi-arrow-left-circle me-1"></i>Geri Dön
                                </button>
                            </a>
                            <a href="LevhaSiparis.php">
                                <button type="button" class="btn btn-primary"><i class="bi bi-save me-1"></i>
                                    Yeni Sipariş
                                </button>
                            </a>
                            <hr>
                            <table class="table datatablem">
                                <thead>
                                <tr class="table-light">
                                    <th>#</th>
                                    <th>#</th>
                                    <th>#</th>
                                    <th>Tip</th>
                                    <th>Çap</th>
                                    <th>Kalınlık</th>
                                    <th>Ağırlık</th>
                                    <th>Adet</th>
                                    <th>Sipariş Tarihi</th>
                                    <th>&nbsp</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sorgu = $baglanti->query('SELECT Levha_Siparis_ID,Levha_Stok_ID,Siparis_ID,Tip,Cap,Kalinlik,Siparis_Adet,Siparis_Agirlik,S_Tarihi FROM view_siparis_levha');
                                foreach ($sorgu as $sonuc) {
                                    $id = $sonuc['Levha_Siparis_ID'];
                                    $Levha_Stok_ID = $sonuc['Levha_Stok_ID'];
                                    $Siparis_ID = $sonuc['Siparis_ID'];
                                    $Tip = $sonuc['Tip'];
                                    $Cap = $sonuc['Cap'];
                                    $Kalinlik = $sonuc['Kalinlik'];
                                    $Siparis_Adet = $sonuc['Siparis_Adet'];
                                    $Siparis_Agirlik = $sonuc['Siparis_Agirlik'];
                                    $S_Tarihi = $sonuc['S_Tarihi'];
                                    ?>
                                    <tr>
                                        <th><?= $id ?></th>
                                        <td><?= $Levha_Stok_ID ?></td>
                                        <td><?= $Siparis_ID ?></td>
                                        <td><?= $Tip ?></td>
                                        <td><?= $Cap ?> cm</td>
                                        <td><?= $Kalinlik ?> mm</td>
                                        <td><?= $Siparis_Agirlik ?> Kg</td>
                                        <td><?= $Siparis_Adet ?> Adet</td>
                                        <td><?= $S_Tarihi ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-danger bi-x-square" data-bs-toggle="modal" data-bs-target="#SecSil<?= $id ?>">
                                            </button>
                                        </td>
                                    </tr>

                                    <!-- Modal -->
                                    <div class="modal fade" id="SecSil<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Tarihe Göre Sil</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <?php
                                                    echo "<H5 class='text-center'>KULLAN</H5>";
                                                    $sor = $baglanti->query('SELECT Levha_Giden_ID, Duzenleme_Tarihi FROM levha_giden WHERE Levha_Stok_ID=' . $Levha_Stok_ID);
                                                    foreach ($sor as $sonuc1) {

                                                        echo "<a href='LevhaSiparisleri.php?LevhaGidenSil=$sonuc1[Levha_Giden_ID]'><div class='form-floating mb-1'><button class='form-control btn-outline-danger'>$sonuc1[Duzenleme_Tarihi]</button><label>Kullanma Tarihi</label></div></a>";

                                                    }
                                                    echo "<h5 class='text-center'>STOK</h5>";
                                                    $sor3 = $baglanti->query('SELECT Levha_Giden_ID FROM levha_giden WHERE Levha_Stok_ID=' . $Levha_Stok_ID)->fetch();
                                                    @$kntrl = $sor3["Levha_Giden_ID"];
                                                    $sor2 = $baglanti->query('SELECT Levha_Gelen_ID, Duzenleme_Tarihi FROM levha_gelen WHERE Levha_Stok_ID=' . $Levha_Stok_ID);
                                                    foreach ($sor2 as $sonuc2) {

                                                        echo "<a href='LevhaSiparisleri.php?LevhaGelenSil=$sonuc2[Levha_Gelen_ID]&LevhaGdnKntrl=$kntrl'><div class='form-floating mb-1'><button class='form-control btn-outline-danger'>$sonuc2[Duzenleme_Tarihi]</button><label>Teslim Tarihi</label></div></a>";

                                                    }
                                                    ?>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="LevhaSiparisleri.php?LevhaSiparisSil=<?= $id ?>&LevhaStokID=<?= $Levha_Stok_ID ?>&SiparisID=<?= $Siparis_ID ?>">
                                                        <button type="button" class="btn btn-outline-danger form-control">Sipariş Sil</button>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal SON-->
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
            columnDefs: [
                {responsivePriority:1, targets: -1},
                {"visible": false, "targets": [0, 1, 2]},
                {targets: 9, orderable: false},
            ],
            pageLength: 100,
            lengthMenu: [[25, 50, 100, -1],['25 Adet', '50 Adet', '100 Adet', 'Tümü']]
        });
    </script>
<?php
require __DIR__ . '/../../controller/Footer.php';
ob_end_flush();
?>