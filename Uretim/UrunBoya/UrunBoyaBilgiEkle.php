<?php
ob_start();
$page = "Boya Bilgisi Ekle";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Kayit.php';
$Urun_ID = (int)$_GET['Urun_ID'];
?>
<main id="main" class="main">

    <section class="section">
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="card col-sm-4">
                <div class="card-body ">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $page ?></h5>
                        <a href="UrunBoyaBilgi.php?Urun_ID=<?= $Urun_ID ?>" class="btn btn-secondary bi-arrow-left">Geri</a>
                    </div>

                    <form class="row g-3 needs-validation" novalidate="" method="post">

                        <input type="hidden" name="Urun_ID" value="<?= $Urun_ID ?>" />

                        <div class="form-floating">
                            <input type="text" name="Marka" value="" class="form-control" required>
                            <label>Marka</label>
                        </div>

                        <div class="form-floating">
                            <input type="text" name="Renk" value="" class="form-control" required>
                            <label>Renk</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" name="icAstar" class="form-control" id="1" step="0.1" value="0.0" required>
                            <label for="1">İç - Astar</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" name="icUstkat" class="form-control" id="2" step="0.1" value="0.0" required>
                            <label for="2">İç - Üst Kat</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" name="DisAstar" class="form-control" id="3" step="0.1" value="0.0" required>
                            <label for="3">Dış - Astar</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" name="DisUstkat" class="form-control" id="4" step="0.1" value="0.0" required>
                            <label for="4">Dış - Üst Kat</label>
                        </div>
                        <button name="UrunBoyaBilgiEkle" type="submit" class="btn btn-primary bi-save2"> &nbsp Kaydet</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
</main>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>