<?php
$page = "Kullanılan Kapaklar";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/AjaxForm/ajax.php';
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title"><?= $page ?></h5>
                            <hr>
                            <a href="KulpStok.php">
                                <button type="button" class="btn btn-secondary"><i
                                            class="bi bi-arrow-left-circle me-1"></i> Geri Dön
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
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sorgu = $baglanti->query('SELECT * FROM view_siparis_kulp');
                                foreach ($sorgu as $sonuc) {
                                    $id = $sonuc['Kulp_Stok_ID'];
                                    $Kulp_ID = $sonuc['Kulp_ID'];
                                    $Siparis_Adet = $sonuc['Siparis_Adet'];
                                    $KulpAdi = $sonuc['KulpAdi'];
                                    $KulpCesidi = $sonuc['KulpCesidi'];
                                    $Renk = $sonuc['Renk'];
                                    ?>
                                    <tr>
                                        <th hidden><?= $id ?></th>
                                        <td hidden><?= $Kulp_ID ?></td>
                                        <td><?= $KulpAdi ?></td>
                                        <td><?= $KulpCesidi ?></td>
                                        <td><?= $Renk ?></td>
                                        <td><?php
                                            $sorguK = $baglanti->query('SELECT SUM(Kullanilan_Adet) AS SumKullanilan_Adet FROM kulp_giden WHERE Kulp_Stok_ID=' . $id);
                                            foreach ($sorguK as $sonuc3) {
                                                echo $sonuc3['SumKullanilan_Adet'] == null ? 0 : $sonuc3['SumKullanilan_Adet'];
                                            } ?></td>
                                    </tr>
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

<?php
require __DIR__ . '/../controller/Footer.php';
?>