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
                    <a href="<?= isset($_GET["Setler"]) ? "../../Uretim/SetlerKayit.php?SetKayit" : "../../Navigasyon/SiparisEt.php" ?>" class="btn btn-secondary  bi-arrow-left-circle"> Geri Dön</a>
                    <label class="text-danger fw-bold">Aynı kalınlıktaki ürünleri seçin!</label>
                    <button type="button" class="btn btn-primary bi-save" data-bs-toggle="modal" data-bs-target="#YeniLevha">&nbsp Yeni Levha</button>
                </div>
                <hr>
                <table class="table datatablem">
                    <thead>
                        <tr class="table-light">
                            <th>#</th>
                            <th><button type="button" class="btn btn-success bi-check-lg form-control LevhaSec">&nbsp Seç</button></th>
                            <th>Tip</th>
                            <th>Çap</th>
                            <th>Kalınlık</th>
                            <th>&nbsp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET["Kalinlik"])) {
                            $YonSiparis = " WHERE Kalinlik=" . (float)$_GET["Kalinlik"] . " AND Cap=" . (float)$_GET["Cap"];
                        } else {
                            $YonSiparis = "";
                        }
                        $sorgu = $baglanti->query("SELECT * FROM levha" . $YonSiparis);
                        foreach ($sorgu as $sonuc) {
                            $id = $sonuc['Levha_ID'];
                            $Tip = $sonuc['Tip'];
                            $Cap = $sonuc['Cap'];
                            $Kalinlik = $sonuc['Kalinlik'];
                        ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><label class="form-check-label" for="Check<?= $id ?>"><input class="form-check-input" type="checkbox" id="Check<?= $id ?>" value="<?= $id ?>"> Seç</label></td>
                                <td><?= $Tip ?></td>
                                <td><?= $Cap ?></td>
                                <td><?= $Kalinlik ?></td>
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
                                            <div class="input-group">
                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <select class="form-select" id="Tip<?= $id ?>">
                                                            <option selected value="<?= $Tip ?>"><?= $Tip ?></option>
                                                            <option value="Daire">Daire</option>
                                                            <option value="Kare">Kare</option>
                                                            <option value="Dikdörtgen">Dikdörtgen</option>
                                                        </select>
                                                        <label>Tip</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input type="number" step="0.1" value="<?= $Cap ?>" class="form-control" id="Cap<?= $id ?>">
                                                        <label>* Çap</label>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-floating">
                                                        <input type="number" step="0.01" value="<?= $Kalinlik ?>" class="form-control" id="Kalinlik<?= $id ?>">
                                                        <label>* Kalınlık</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-danger Hata"></div>
                                        </div>
                                        <div class="card-footer">
                                            <button type="button" class="btn btn-primary form-control LevhaDuzenle" LevhaID="<?= $id ?>">Düzenle</button>
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
        columnDefs: [{
                "visible": false,
                "targets": 0
            },
            {
                targets: [1, 5],
                orderable: false
            },
            {
                "width": "20%",
                "targets": 4
            }
        ],
        pageLength: 100,
        lengthMenu: [
            [25, 50, 100, -1],
            ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
        ]
    });
    $('.LevhaSec').click(function() {
        var Sec = [];
        $("input:checkbox:checked").map(function() {
            Sec.push($(this).val());
        });
        $.ajax({
            type: "POST",
            url: "LevhaSiparis.php",
            data: {
                'LevhaSec': Sec
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            },
            success: function() {
                window.location.assign("SiparisListesi.php")
            }
        })
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
                        <input type="number" id="Kalinlik" step="0.1" class="form-control">
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
if (isset($_POST["LevhaSec"])) {
    $_SESSION["Levhalar"] = $_POST["LevhaSec"];
}
?>