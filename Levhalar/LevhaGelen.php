<?php
$page = "Gelen Levha";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/VTHataMesaji.php';
date_default_timezone_set('Europe/Istanbul');
$tarih = new DateTime("now");
$tarih = date("Y-m-d");
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title border-bottom mb-3"><?= $page ?></h5>
                <a href="<?= isset($_GET["Gecmis"]) ? "LevhaGelen.php" : "LevhaStok.php" ?>" class="btn btn-secondary bi-arrow-left-circle me-3 mb-1">&nbsp Geri Dön</a>
                <a href="LevhaGelen.php?Gecmis" class="btn btn-success bi-clock-history mb-1" <?= isset($_GET["Gecmis"]) ? "hidden" : "" ?>>&nbsp Geçmiş</a>
                <hr>
                <table class="table datatablem">
                    <thead>
                        <tr class="table-light">
                            <th>#</th>
                            <th>Levha_ID</th>
                            <th>Tip</th>
                            <th>Çap</th>
                            <th>Kalınlık</th>
                            <th>Sipariş</th>
                            <th>&nbsp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET["Gecmis"])) {
                            $g = 1;
                        } else {
                            $g = 0;
                        }

                        $span = "<span class='text-black-50'>";
                        $sorgu = $baglanti->query("SELECT *,SUM( Siparis_Adet ) AS Adet, SUM( Siparis_Agirlik ) AS Agirlik FROM view_siparis_levha WHERE Durum=" . $g . " GROUP BY Levha_ID");
                        foreach ($sorgu as $s) {
                            $id = $s['Levha_Stok_ID'];
                            $Levha_ID = $s['Levha_ID'];
                            $Tip = $s['Tip'];
                            $Cap = $s['Cap'];
                            $mm = $s['Kalinlik'];
                            $d = $s['Durum'];
                            $Sip_kg = $s['Agirlik'];
                            $Sip_Adt = $s['Adet'];
                        ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $Levha_ID ?></td>
                                <td><?= $d > 0 ? $span . $Tip . "</span>" : $Tip ?></td>
                                <td><?= $d > 0 ? $span . $Cap . "</span>" : $Cap ?></td>
                                <td><?= $d > 0 ? $span . $mm . "</span>" : $mm ?></td>
                                <td><?= $d > 0 ? $span . "Tamamlandı</span>" : $Sip_kg . " Kg <i class='bi-dash-lg'></i> " . $Sip_Adt . " Adet" ?></td>
                                <td><?= $d > 0 ? "" : "<button type='button' class='btn btn-outline-primary bi-minecart' id='Gelen' data-bs-toggle='modal' data-bs-target='#Gelen$id'> Gelen</button>"; ?></td>
                            </tr>
                            <!-- Modal -->
                            <div class="modal fade" id="Gelen<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body row g-3">

                                            <div class="col-md-4" hidden>
                                                <div class="form-floating">
                                                    <input class="form-control" value="<?= $Tip ?>" readonly>
                                                    <label>Tip</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4" hidden>
                                                <div class="form-floating">
                                                    <input class="form-control Cap<?= $id ?>" value="<?= $Cap ?>" readonly>
                                                    <label>Çap</label>
                                                </div>
                                            </div>
                                            <div class="col-md-4" hidden>
                                                <div class="form-floating">
                                                    <input class="form-control Kalinlik<?= $id ?>" value="<?= $mm ?>" readonly>
                                                    <label>Kalınlık</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="number" class="temizle form-control GirAdet<?= $id ?>" readonly>
                                                    <label>Adet</label>
                                                </div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="number" class="form-control focus temizle GirAgirlik" id="GirAgirlik<?= $id ?>" levhastokid="<?= $id ?>">
                                                    <label>Ağırlık</label>
                                                </div>
                                                <div class="Hata text-danger py-1"></div>
                                            </div>

                                            <div class="col-md-12">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control T_Tarihi<?= $id ?>" value="<?= $tarih ?>">
                                                    <label>Tarih</label>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <label class="form-check-label"><input class="form-check-input Tamamlandi" type="checkbox" id="<?= $id ?>"> Tamamlandı</label>
                                            </div>

                                            <input type="hidden" class="LevhaID<?= $id ?>" value="<?= $Levha_ID ?>" />
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" levhastokid="<?= $id ?>" class="Gelen btn btn-outline-success form-control">Stoğa
                                                Ekle
                                            </button>
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
        order: [
            [6, 'DESC']
        ],
        responsive: true,
        columnDefs: [{
                "visible": false,
                "targets": [0, 1]
            },
            {
                targets: "_all",
                orderable: false
            },
        ],
        pageLength: 100,
        lengthMenu: [
            [25, 50, 100, -1],
            ['25 Adet', '50 Adet', '100 Adet', 'Tümü']
        ],
    });
</script>
<?php
require __DIR__ . '/ajax.php';
require __DIR__ . '/../controller/Footer.php';
?>