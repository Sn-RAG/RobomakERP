<?php
ob_start();
$page = "Kapak Sipariş";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Kayit.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';

?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title"><?= $page ?></h5>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <a href="<?= isset($_GET["Setler"]) ? "../../Uretim/SetlerKayit.php?SetKayit" : "../../Navigasyon/SiparisEt.php" ?>" class="btn btn-secondary  bi-arrow-left-circle"> Geri Dön</a>
                            <button type="button" class="btn btn-primary bi-save" data-bs-toggle="modal" data-bs-target="#Yeni"> Yeni Kapak</button>
                        </div>
                        <hr>
                        <table class="table datatablem">
                            <thead>
                                <tr class="table-light">
                                    <th>#</th>
                                    <th><button type="button" class="btn btn-success bi-check-lg form-control Sec">&nbsp Seç</button></th>
                                    <th>Adı</th>
                                    <th>&nbsp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sorgu = $baglanti->query('SELECT * FROM kapak');
                                foreach ($sorgu as $sonuc) {
                                    $id = $sonuc['Kapak_ID'];
                                    $MA = $sonuc['Model_Adi'];
                                ?>
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td>
                                            <div class="form-check"><input class="form-check-input" type="checkbox" id="Check<?= $id ?>" value="<?= $id ?>"><label class="form-check-label" for="Check<?= $id ?>">Seç</label></div>
                                        </td>
                                        <td><?= $MA ?></td>
                                        <td>
                                            <button type="button" class="btn btn-outline-warning bi-pencil-fill" data-bs-toggle="modal" data-bs-target="#Duzenle<?= $id ?>">&nbsp Düzenle</button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="Duzenle<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Düzenle</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <form KapakID="<?= $id ?>" class="KapakDuzenle">
                                                    <div class="modal-body row g-3">
                                                        <div class="col-md-12">
                                                            <div class="form-floating">
                                                                <select id="Firma<?= $id ?>" class="form-select">
                                                                    <option value=""></option>
                                                                    <?php
                                                                    $query = $baglanti->query("SELECT Firma_ID, Firma FROM firmalar");
                                                                    foreach ($query as $s) { ?>
                                                                        <option <?= $s["Firma_ID"] == $sonuc['Firma_ID'] ? "selected" : "" ?> value='<?= $s["Firma_ID"] ?>'><?= $s["Firma"] ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <label>Çalışılan Firma</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-floating">
                                                                <input type='text' id='Adi<?= $id ?>' value="<?= $MA ?>" class='form-control'>
                                                                <label>* Adı</label>
                                                            </div>
                                                        </div>

                                                        <button type="submit" class="btn btn-warning form-control">Düzenle</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php } ?>
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
        columnDefs: [{
                "visible": false,
                "targets": 0
            },
            {
                targets: "_all",
                orderable: false
            },
            {
                "width": "20%",
                "targets": 3
            }
        ],
        pageLength: 100,
        lengthMenu: [
            [25, 50, 100, -1],
            ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
        ]
    });
</script>

<div class="modal fade" id="Yeni" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="YeniKapak" class="modal-body needs-validation row g-3" novalidate>
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
                        <input type='text' id='Adi' class='form-control' required>
                        <label>* Adı</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary form-control">Ekle</button>
            </form>
        </div>
    </div>
</div>
<?php
require __DIR__ . '/AjaxForm/Ajax.php';
require __DIR__ . '/../../controller/Footer.php';
?>