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
                <a href="LevhaStok.php" class="btn btn-secondary bi-arrow-left-circle">&nbsp Geri Dön</a>
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
                            <th>Stok Ağırlık</th>
                            <th>Stok Adet</th>
                            <th>Teslim Tarihi</th>
                            <th>&nbsp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sorgu = $baglanti->query('SELECT * FROM view_siparis_levha');
                        foreach ($sorgu as $sonuc) {
                            $id = $sonuc['Levha_Stok_ID'];
                            $Levha_ID = $sonuc['Levha_ID'];
                            $Tip = $sonuc['Tip'];
                            $Cap = $sonuc['Cap'];
                            $mm = $sonuc['Kalinlik'];
                            $Sip_Adt = $sonuc['Siparis_Adet'];
                            $Sip_kg = $sonuc['Siparis_Agirlik'];

                            $sorguS = $baglanti->query('SELECT SUM(Stok_Adet) AS Adet,SUM(Stok_Agirlik) AS Agirlik, Teslim_Tarihi FROM levha_gelen WHERE Levha_Stok_ID=' . $id);
                            foreach ($sorguS as $sonuc2) {
                                $Stok_kg = $sonuc2['Agirlik'];
                                $Stok_Adt = $sonuc2['Adet'];
                                $TT = $sonuc2['Teslim_Tarihi'];
                        ?>
                                <tr>
                                    <td><?= $id ?></td>
                                    <td><?= $Levha_ID ?></td>
                                    <td><?= $Sip_Adt < 1 ? "<span class='text-black-50'>" . $Tip . "</span>" : $Tip ?></td>
                                    <td><?= $Sip_Adt < 1 ? "<span class='text-black-50'>" . $Cap . "</span>" : $Cap ?></td>
                                    <td><?= $Sip_Adt < 1 ? "<span class='text-black-50'>" . $mm . "</span>" : $mm ?></td>
                                    <td><?= $Sip_kg < 1 ? "<span class='text-black-50'>Tamamlandı</span>" : $Sip_kg . " Kg <i class='bi-dash-lg'></i> " . $Sip_Adt . " Adet" ?></td>
                                    <td><?= $Stok_kg > 0 ? $Stok_kg . " Kg" : 0 . " Kg" ?></td>
                                    <td><?= $Stok_Adt > 0 ? $Stok_Adt . " Kg" : 0 . " Kg" ?></td>
                                    <td><?= $Sip_Adt < 1 ? "<span class='text-black-50'>" . $TT . "</span>" : $TT ?></td>
                                    <td><?= $Sip_Adt < 1 ? "" : "<button type='button' class='btn btn-outline-primary bi-minecart' id='Gelen' data-bs-toggle='modal' data-bs-target='#Gelen$id'> Gelen</button>"; ?></td>
                                </tr>
                                <!-- Modal -->
                                <div class="modal fade" id="Gelen<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= $Sip_kg == null ? 0 : $Sip_kg ?>
                                                    Kg Siparişten &nbsp
                                                    <i class="bi bi-arrow-right-circle "></i>
                                                    &nbsp <?= $Stok_kg == null ? 0 : $Stok_kg ?> Kg
                                                    Geldi
                                                </h5>
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
                                                    <label class="form-check-label"><input class="form-check-input TumuGeldi" type="checkbox" id="<?= $id ?>">Tamamı Geldi</label>
                                                </div>

                                                <input type="hidden" class="SipAgirlik<?= $id ?>" value="<?= $Sip_kg > 0 ? $Sip_kg : 0 ?>" />

                                                <input type="hidden" class="SipAdet<?= $id ?>" value="<?= $Sip_Adt > 0 ? $Sip_Adt : 0 ?>" />

                                                <input type="hidden" class="Stok_Agirlik<?= $id ?>" value="<?= $Stok_kg > 0 ? $Stok_kg : 0 ?>" />
                                                <input type="hidden" class="Stok_Adet<?= $id ?>" value="<?= $Stok_Adt > 0 ? $Stok_Adt : 0 ?>" />
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
            [9, 'DESC']
        ],
        responsive: true,
        columnDefs: [{
                "visible": false,
                "targets": [0, 1, 6, 7]
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