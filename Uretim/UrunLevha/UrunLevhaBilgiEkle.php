<?php
ob_start();
$page = "Levha Bilgisi Ekle";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Kayit.php';
$Uid = (int)$_GET['Urun_ID'];
?>
<main id="main" class="main">

    <section class="section">
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="card col-sm-3">
                <div class="card-body ">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $page ?></h5>
                        <a href="UrunLevhaBilgi.php?Urun_ID=<?= $Uid ?>" class="btn btn-secondary bi-arrow-left me-1">&nbsp Geri Dön</a>
                    </div>
                    <form class="modal-body row g-3 needs-validation" method="post" novalidate>
                        <input type="hidden" name="Urun_ID" value="<?= $Uid ?>" />

                        <div class="form-floating mb-3">
                            <select name="Tip" class="form-select" aria-label="Seçiniz" required>
                                <option selected value="Daire">Daire</option>
                                <option value="Kare">Kare</option>
                                <option value="DikDörtgen">DikDörtgen</option>
                            </select>
                            <label>Tip</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" name="Cap" class="form-control" id="Cap" step="0.01" value="0.00" required>
                            <label>Çap</label>
                        </div>

                        <div hidden class="form-floating dikdortgen">
                            <input type="number" name="Cap2" class="form-control" id="Cap" step="0.01" value="0.00">
                            <label>2. Çap</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" name="Kalinlik" class="form-control" id="Kalinlik" step="0.01" value="0.00" required>
                            <label>Kalınlık</label>
                        </div>
                        <button name="UrunLevhaBilgiEkle" type="submit" class="btn btn-primary bi-pencil">&nbsp Kaydet</button>
                    </form>

                </div>
            </div>
    </section>
</main>
<script>
    $("select").change(function() {
        if ($(this).val() == "DikDörtgen") {
            $(".dikdortgen").prop("hidden", false);
        } else {
            $(".dikdortgen").prop("hidden", true);
        }
    });
</script>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>