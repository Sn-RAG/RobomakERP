<?php
$page = "Kapak Stok";
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
                            <a href="KapakKullanilanlar.php">
                                <button type="button" class="btn btn-primary"><i
                                            class="bi bi-tropical-storm me-1"></i>
                                    Kullanılan
                                </button>
                            </a>
                            <hr>
                            <table class="table table-borderless datatable">
                                <thead>
                                <tr>
                                    <th>Tip</th>
                                    <th>Kapak No</th>
                                    <th>Model Adı</th>
                                    <th>Adet</th>
                                    <th>&nbsp</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php

                                $sorgu = $baglanti->query('SELECT Kapak_Stok_ID, Tip, Kapak_No, Model_Adi, Siparis_Adet FROM view_siparis_kapak');
                                foreach ($sorgu as $sonuc) {
                                    $id = $sonuc['Kapak_Stok_ID'];
                                    $Tip = $sonuc['Tip'];
                                    $Kapak_No = $sonuc['Kapak_No'];
                                    $Model_Adi = $sonuc['Model_Adi'];
                                    $Siparis_Adet = $sonuc['Siparis_Adet'];
                                    ?>
                                    <tr>
                                        <th hidden><?= $id ?></th>
                                        <td><?= $Tip ?></td>
                                        <td><?= $Kapak_No ?></td>
                                        <td><?= $Siparis_Adet ?></td>
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
                                    require __DIR__ . '/Popups/KapakBilgi.php';
                                    require __DIR__ . '/Popups/KapakKullan.php';
                                    require __DIR__ . '/Popups/KapakGelen.php';
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