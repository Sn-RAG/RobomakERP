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
            <div class="card col-sm-4">
                <div class="card-body ">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $page ?></h5>
                        <a href="UrunLevhaBilgi.php?Urun_ID=<?= $Uid ?>" class="btn btn-secondary bi-arrow-left me-1">&nbsp Geri Dön</a>
                    </div>
                    <form class="modal-body row g-3 needs-validation" method="post" novalidate>
                        <input type="hidden" name="Urun_ID" value="<?= $Uid ?>" />

                        <select name="Tip" class="form-select Tip" aria-label="Seçiniz" required>
                            <option value="">Tip Seç</option>
                            <option value="Daire">Daire</option>
                            <option value="Kare">Kare</option>
                            <option value="DikDörtgen">DikDörtgen</option>
                        </select>

                        <select name="Cap" class="form-select" required>
                            <option value="">Çap Seç</option>
                            <?php foreach ($baglanti->query('SELECT DISTINCT Cap FROM levha') as $s) {
                                echo "<option $sec value='$s[Cap]'>$s[Cap]</option>";
                            } ?>
                        </select>

                        <select hidden name="Cap2" class="form-select dd">
                            <option value="">2. Çap Seç</option>
                            <?php foreach ($baglanti->query('SELECT DISTINCT Cap2 FROM levha WHERE Cap2<>""') as $s) {
                                echo "<option $sec value='$s[Cap2]'>$s[Cap2]</option>";
                            } ?>
                        </select>

                        <select name="Kalinlik" class="form-select" required>
                            <option value="">* Kalınlık Seç</option>
                            <?php foreach ($baglanti->query('SELECT DISTINCT Kalinlik FROM levha') as $s) {
                                echo "<option $sec value='$s[Kalinlik]'>$s[Kalinlik]</option>";
                            } ?>
                        </select>
                        <button name="UrunLevhaBilgiEkle" type="submit" class="btn btn-primary bi-pencil">&nbsp Kaydet</button>
                    </form>

                </div>
            </div>
    </section>
</main>
<script>
    $(".Tip").change(function() {
        if ($(this).val() == "DikDörtgen") {
            $(".dd").prop("hidden", false);
        } else {
            $(".dd").prop("hidden", true);
        }
    });
</script>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>