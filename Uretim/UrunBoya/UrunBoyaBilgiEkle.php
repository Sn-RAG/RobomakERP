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
                <div class="card col-sm-3">
                    <form class="needs-validation" method="post" novalidate>
                        <div class="card-body ">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= $page ?></h5>
                                <a href="UrunBoyaBilgi.php?Urun_ID=<?= $Urun_ID ?>">
                                    <button type="button" class="btn btn-secondary"><i
                                                class="bi bi-arrow-left me-1"></i> Geri
                                    </button>
                                </a>
                            </div>
                            <div class="modal-body">


                                <input type="hidden" name="Urun_ID" value="<?= $Urun_ID ?>"/>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <input type="text" name="BoyaTipi" value="" class="form-control" placeholder="Boya Tipi" required>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="icAstar" class="form-control" id="1"
                                               step="0.1" value="0.0" required>
                                        <label for="1">İç - Astar</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="icUstkat" class="form-control" id="2"
                                               step="0.1" value="0.0" required>
                                        <label for="2">İç - Üst Kat</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="DisAstar" class="form-control" id="3"
                                               step="0.1" value="0.0" required>
                                        <label for="3">Dış - Astar</label>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="form-floating mb-3">
                                        <input type="number" name="DisUstkat" class="form-control" id="4"
                                               step="0.1" value="0.0" required>
                                        <label for="4">Dış - Üst Kat</label>
                                    </div>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button name="UrunBoyaBilgiEkle" type="submit" class="btn btn-primary"><i
                                            class="bi bi-save2 me-1"></i> Kaydet
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