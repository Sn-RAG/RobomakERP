<?php
ob_start();
$page = "Levha Sipariş";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Kayit.php';
?>
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?= $page ?></h5>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <a href="../../Navigasyon/SiparisEt.php" class="btn btn-secondary  bi-arrow-left-circle"> Geri Dön</a>
                        <button type="button" class="btn btn-primary bi-save" data-bs-toggle="modal" data-bs-target="#YeniLevha">&nbsp Yeni Levha</button>
                    </div>
                    <hr>
                    <table class="table datatablem">
                        <thead>
                        <tr class="table-light">
                            <th>#</th>
                            <th>Tip</th>
                            <th>Çap</th>
                            <th>Kalınlık</th>
                            <th>&nbsp</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(isset($_GET["Kalinlik"])){
                            $YonSiparis=" WHERE Kalinlik=".(float)$_GET["Kalinlik"]." AND Cap=".(float)$_GET["Cap"];
                        }else{$YonSiparis="";}
                        $sorgu = $baglanti->query("SELECT * FROM levha".$YonSiparis);
                        foreach ($sorgu as $sonuc) {
                            $id = $sonuc['Levha_ID'];
                            $Tip = $sonuc['Tip'];
                            $Cap = $sonuc['Cap'];
                            $Kalinlik = $sonuc['Kalinlik'];
                            ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $Tip ?></td>
                                <td><?= $Cap ?></td>
                                <td><?= $Kalinlik ?></td>
                                <td>
                                    <button type="button" class="btn btn-outline-primary bi-cart4" data-bs-toggle="modal" data-bs-target="#Siparis<?= $id ?>"> Sipariş</button>
                                </td>
                            </tr>

                            <div class="modal fade" id="Siparis<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Yeni Sipariş</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body row g-3">

                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <select class="form-select Tip<?= $id ?>" disabled>
                                                        <option value="<?= $Tip ?>"><?= $Tip ?></option>
                                                    </select>
                                                    <label>Tip</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="text" value="<?= $Kalinlik ?>" class="form-control Kalinlik<?= $id ?>" readonly>
                                                    <label>* Kalınlık</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="text" value="<?= $Cap ?>" class="form-control Cap<?= $id ?>" readonly>
                                                    <label>* Çap</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control focus temizle Adet" id="Adet<?= $id ?>" LevhaID="<?= $id ?>">
                                                    <label>* Adet</label>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="number" class="form-control temizle Agirlik<?= $id ?>" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <select class="form-select" disabled>
                                                    <option value="Kg">Kg</option>
                                                    <option value="Gram">Gram</option>
                                                    <option value="Ton">Ton</option>
                                                </select>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="date"
                                                            class="form-control STarihi<?= $id ?>"
                                                            value="<?php
                                                            date_default_timezone_set('Europe/Istanbul');
                                                            $tarih = new DateTime("now");
                                                            $tarih = date("Y-m-d");
                                                            echo $tarih;
                                                            ?>">
                                                    <label>Sipariş Tarihi</label>
                                                </div>
                                            </div>

                                            <div class="text-danger Hata"></div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary form-control LevhaSiparis" LevhaID="<?= $id ?>">Sipariş Et</button>
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
        </section>
    </main>
    <script>
        $('.datatablem').DataTable({
            responsive: true,
            columnDefs: [
                {"visible": false, "targets": 0},
                {targets: 4, orderable: false},
                {"width": "20%", "targets": 4}
            ],
            pageLength: 100,
            lengthMenu: [[25, 50, 100, -1],
                ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
            ]
        });
    </script>

    <div class="modal fade" id="YeniLevha" tabindex="-1" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Levha Ekle</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">

                    <div class="col-md-12">
                        <div class="form-floating">
                            <select id="Firma" class="form-select">
                                <option value=""></option>
                                <?php
                                $query = $baglanti->query("SELECT Firma_ID, Firma FROM firmalar");
                                foreach ($query as $s) {
                                    echo "<option value='$s[Firma_ID]'>$s[Firma]</option>";
                                }
                                ?>
                            </select>
                            <label>Çalışılan Firma</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating">
                            <select id="Tip" class="form-select">
                                <option value="Daire">Daire</option>
                                <option value="Kare">Kare</option>
                                <option value="Dikdörtgen">Dikdörtgen</option>
                            </select>
                            <label>Tip</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="number" id="Cap" step="0.01" class="form-control">
                            <label>* Çap</label>
                        </div>
                    </div>
                    
                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="number" id="Kalinlik" step="0.01" class="form-control">
                            <label>* Kalınlık</label>
                        </div>
                    </div>

                    
                    <div class="text-danger Hata"></div>
                </div>
                <div class="card-footer">
                    <button type="button" id="LevhaEkle" class="btn btn-primary form-control">
                        Ekle
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php
require __DIR__ . '/AjaxForm/Ajax.php';
require __DIR__ . '/../../controller/Footer.php';
?>