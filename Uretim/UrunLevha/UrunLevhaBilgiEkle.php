<?php
ob_start();
$page = "Levha Bilgisi Ekle";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Kayit.php';
$Urun_ID = (int)$_GET['Urun_ID'];
?>
    <main id="main" class="main">

        <section class="section">
            <div class="d-flex align-items-center justify-content-center min-vh-100">
                <div class="card col-sm-3">
                    <form class="needs-validation" method="post" novalidate>
                        <div class="card-body ">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= $page ?></h5>
                                <a href="UrunLevhaBilgi.php?Urun_ID=<?= $Urun_ID ?>">
                                    <button type="button" class="btn btn-secondary"><i
                                                class="bi bi-arrow-left me-1"></i> Geri
                                    </button>
                                </a>
                            </div>
                            <div class="modal-body">


                                <input type="hidden" name="Urun_ID" value="<?= $Urun_ID ?>"/>

                                <div class="row mb-3">

                                    <div class="form-floating mb-3">
                                        <select name="Tip" class="form-select" aria-label="Seçiniz"
                                                required>
                                            <option selected value="Daire">Daire</option>
                                            <option value="Kare">Kare</option>
                                            <option value="DikDörtgen">DikDörtgen</option>
                                        </select>
                                        <label for="sec">Tip</label>
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    <div class="form-floating">
                                        <input type="number" name="Cap" class="form-control" id="Cap"
                                               step="0.01" value="0.00" required>
                                        <label for="Cap">Çap</label>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="form-floating">
                                        <input type="number" name="Kalinlik" class="form-control" id="Kalinlik"
                                               step="0.01" value="0.00" required>
                                        <label for="Kalinlik">Kalınlık</label>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button name="UrunLevhaBilgiEkle" type="submit" class="btn btn-primary"><i
                                            class="bi bi-pencil me-1"></i> Kaydet
                                </button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </section>
    </main><!-- End #main -->
<?php
require __DIR__ . '/../../controller/Footer.php';
?>