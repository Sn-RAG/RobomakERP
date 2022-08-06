<?php
ob_start();
$page = "Levha Sipariş";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Kayit.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
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
                    <button type="button" class="btn btn-primary bi-save" data-bs-toggle="modal" data-bs-target="#Yeni">&nbsp Yeni Levha</button>
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
                        foreach ($sorgu as $s) {
                            $id = $s['Levha_ID'];
                            $Tip = $s['Tip'];
                            $Cap = $s['Cap'];
                            $Cap2 = $s['Cap2'];
                            $Kalinlik = $s['Kalinlik'];
                            //Köşeli mi?
                            $bak = $s['Cap2'] <> null ? " &nbsp <i class='bi-dash-lg'></i> &nbsp " . $s['Cap2'] . " cm" : "";
                        ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><label class="form-check-label" for="Check<?= $id ?>"><input class="form-check-input" type="checkbox" id="Check<?= $id ?>" value="<?= $id ?>"> Seç</label></td>
                                <td><?= $Tip ?></td>
                                <td><?= $Cap . " cm " . $bak ?></td>
                                <td><?= $Kalinlik ?> mm</td>
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
                                            <div class="form-floating">
                                                <select id="Firma<?= $id ?>" class="form-select focus">
                                                    <option value=""></option>
                                                    <?php
                                                    $query = $baglanti->query("SELECT Firma_ID, Firma FROM firmalar");
                                                    foreach ($query as $s) { ?>
                                                        <option <?= $s["Firma_ID"] == $s['Firma_ID'] ? "selected" : "" ?> value='<?= $s["Firma_ID"] ?>'><?= $s["Firma"] ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label>Çalışılan Firma</label>
                                            </div>
                                            <div class="form-floating flex-fill">
                                                <select class="form-select Tip" id="Tip<?= $id ?>">
                                                    <?php foreach ($baglanti->query("SELECT DISTINCT Tip FROM levha") as $s) {
                                                        $sec = $s["Tip"] == $Tip ? "selected" : "";
                                                        echo "<option $sec value='$s[Tip]'>$s[Tip]</option>";
                                                    } ?>
                                                </select>
                                                <label>Tip</label>
                                            </div>

                                            <div class="form-floating ">
                                                <input type="number" step="0.01" value="<?= $Kalinlik ?>" class="form-control" id="Kalinlik<?= $id ?>">
                                                <label>* Kalınlık</label>
                                            </div>

                                            <div class="d-flex">
                                                <div class="form-floating flex-fill">
                                                    <input type="number" step="0.1" value="<?= $Cap ?>" class="form-control" id="Cap<?= $id ?>">
                                                    <label>* Çap</label>
                                                </div>

                                                <div class="form-floating flex-fill dd" <?= $Tip == "DikDörtgen" ? "" : "hidden" ?>>
                                                    <input type="number" step="0.1" value="<?= $Cap2 ?>" class="form-control" id="Cap2<?= $id ?>">
                                                    <label>2. Çap</label>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary form-control LevhaDuzenle" LevhaID="<?= $id ?>">Düzenle</button>
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
                targets: "_all",
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

<div class="modal fade" id="Yeni" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row g-3">

                <div class="col-md-12">
                    <div class="form-floating">
                        <select id="Firma" class="form-select focus">
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

                <div class="form-floating">
                    <select id="Tip" class="form-select Tip">
                        <option value="Daire">Daire</option>
                        <option value="Kare">Kare</option>
                        <option value="DikDörtgen">DikDörtgen</option>
                    </select>
                    <label>Tip</label>
                </div>

                <div class="form-floating">
                    <input type="number" id="Kalinlik" step="0.1" class="form-control">
                    <label>* Kalınlık</label>
                </div>
                <div class="d-flex">
                    <div class="form-floating  flex-fill">
                        <input type="number" id="Cap" step="0.01" class="form-control">
                        <label>* Çap</label>
                    </div>

                    <div hidden class="form-floating  flex-fill dd">
                        <input type="number" id="Cap2" step="0.01" class="form-control">
                        <label>Çap2</label>
                    </div>
                </div>

                <button id="YeniLevha" type="button" class="btn btn-primary form-control">Ekle</button>
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