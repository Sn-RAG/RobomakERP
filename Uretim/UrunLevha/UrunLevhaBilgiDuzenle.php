<?php
ob_start();
$page = "Levha Bilgisi Düzenle";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Duzenle.php';
$ID = (int)$_GET['id'];
$Urun_ID = (int)$_GET['Urun_ID'];
$Lid = (int)$_GET['Levha_ID'];
$sor = $baglanti->query("SELECT * FROM levha WHERE Levha_ID=$Lid")->fetch();
?>
<main id="main" class="main">
    <section class="section">
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="card col-sm-4">
                <div class="card-body ">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $page ?></h5>
                        <a href="UrunLevhaBilgi.php?Urun_ID=<?= $Urun_ID ?>" class="btn btn-secondary bi-arrow-left">&nbsp Geri</a>
                    </div>
                    <form class="modal-body row g-3 needs-validation" method="post" novalidate>
                        <input type="hidden" name="Urun_Levha_Bilgi_ID" value="<?= $ID ?>">
                        <input type="hidden" name="Urun_ID" value="<?= $Urun_ID ?>" />
                        <input type="hidden" name="Levha_ID" value="<?= $Lid ?>" />

                        <div class="form-floating">
                            <select name="Tip" class="form-select tip" required>
                                <?php foreach ($baglanti->query("SELECT DISTINCT Tip FROM levha") as $s) {
                                    $sec = $s["Tip"] == $sor["Tip"] ? "selected" : "";
                                    echo "<option $sec value='$s[Tip]'>$s[Tip]</option>";
                                } ?>
                            </select>
                            <label>Tip</label>
                        </div>

                        <div class="form-floating">
                            <select name="Cap" class="form-select" required>
                                <?php foreach ($baglanti->query('SELECT DISTINCT Cap FROM levha') as $s) {
                                    $sec = $s["Cap"] == $sor["Cap"] ? "selected" : "";
                                    echo "<option $sec value='$s[Cap]'>$s[Cap]</option>";
                                } ?>
                            </select>
                            <label>Çap</label>
                        </div>

                        <div class="form-floating dd">
                            <select name="Cap2" class="form-select" required>
                                <?php foreach ($baglanti->query('SELECT DISTINCT Cap2 FROM levha WHERE Cap2<>""') as $s) {
                                    $sec = $s["Cap2"] == $sor["Cap2"] ? "selected" : "";
                                    echo "<option $sec value='$s[Cap2]'>$s[Cap2]</option>";
                                } ?>
                            </select>
                            <label>Çap 2</label>
                        </div>

                        <div class="form-floating">
                            <select name="Kalinlik" class="form-select" required>
                                <?php foreach ($baglanti->query('SELECT DISTINCT Kalinlik FROM levha') as $s) {
                                    $sec = $s["Kalinlik"] == $sor["Kalinlik"] ? "selected" : "";
                                    echo "<option $sec value='$s[Kalinlik]'>$s[Kalinlik]</option>";
                                } ?>
                            </select>
                            <label>Kalınlık</label>
                        </div>
                        <button name="UrunLevhaBilgiDuzenle" type="submit" class="btn btn-primary bi-pencil">&nbsp Düzenle</button>
                    </form>

                </div>
            </div>
    </section>
</main>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>
<script>
    $(function() {
        $(".tip option:selected").map(function() {
            if ($(this).val() == "DikDörtgen") {
                $(".dd").prop("hidden", false);
            } else {
                $(".dd").prop("hidden", true);
            }
        });
    });
    $(".tip").change(function() {
        if ($(this).val() == "DikDörtgen") {
            $(".dd").prop("hidden", false);
        } else {
            $(".dd").prop("hidden", true);
        }
    });
</script>