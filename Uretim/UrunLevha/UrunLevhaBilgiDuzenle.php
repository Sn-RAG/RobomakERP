<?php
ob_start();
$page = "Levha Bilgisi Düzenle";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Duzenle.php';
$Urun_ID = (int)$_GET['Urun_ID'];
$Levha_ID = (int)$_GET['Levha_ID'];
$sorgu = $baglanti->query("SELECT * FROM levha WHERE Levha_ID =" . $Levha_ID);
$SLevha = $sorgu->fetch();
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
                                <input type="hidden" name="Levha_ID" value="<?= $Levha_ID ?>"/>

                                <div class="row mb-3">

                                    <div class="form-floating mb-3">
                                        <select name="Tip" class="form-select" aria-label="Seçiniz"
                                                required>
                                            <option selected value="<?= $SLevha['Tip'] ?>"><?php
                                                $B = $SLevha['Tip'];
                                                if ($B == "Daire") {
                                                    echo "Daire";
                                                } elseif ($B == "Kare") {
                                                    echo "Kare";
                                                } else echo "DikDörtgen";
                                                ?></option>
                                            <option value="Kare">Kare</option>
                                            <option value="Kare">DikDörtgen</option>
                                        </select>
                                        <label for="sec">Tip</label>
                                    </div>
                                </div>

                                <div class="row mb-3">

                                    <div class="form-floating">
                                        <input type="number" name="Cap" class="form-control" id="Cap"
                                               step="0.01" value="<?= $SLevha['Cap'] ?>" required>
                                        <label for="Cap">Çap</label>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="form-floating">
                                        <input type="number" name="Kalinlik" class="form-control" id="Kalinlik"
                                               step="0.01" value="<?= $SLevha['Kalinlik'] ?>" required>
                                        <label for="Kalinlik">Kalınlık</label>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button name="UrunLevhaBilgiDuzenle" type="submit" class="btn btn-primary"><i
                                            class="bi bi-pencil me-1"></i> Düzenle
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