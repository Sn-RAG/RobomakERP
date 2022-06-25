<?php
$page = "Set Düzenle";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Duzenle.php';
$Setler_ID = (int)$_GET['id'];
$Set_ID = (int)$_GET['Set_ID'];
$SetAdi = $_GET['SetAdi'];
?>

    <link href="../assets/css/cbox.css" rel="stylesheet">

    <main id="main" class="main">

        <section class="section">
            <div class="d-flex align-items-center justify-content-center">
                <div class="card col-sm-12">
                    <form method="post" class="needs-validation" novalidate>
                        <div class="card-header">
                            <h5 class="modal-title text-black mb-3"><?= $page ?></h5>
                            <div class="col-md-4 mb-3">
                                <div class="form-floating">
                                    <input type="text" name="SetAdi" class="form-control" placeholder="* Set Adı"
                                           required>
                                    <label for="ad">* Set Adı</label>
                                </div>
                            </div>
                            <div class="text-center">
                                <button name="SetDuzenle" type="submit" class="btn btn-primary col-sm-2">Seç</button>
                            </div>
                        </div>
                        <div class="modal-body">
                            <?php
                            $sorgu = $baglanti->query("SELECT * FROM kategori");
                            foreach ($sorgu as $sonuc) {
                                ?>
                                <div class="accordion accordion-flush col-md-12"
                                     id="accordion<?= $sonuc['Kategori_ID'] ?>">
                                    <div class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#flush-<?= $sonuc['Kategori_ID'] ?>"
                                                    aria-expanded="false" aria-controls="flush-collapseOne">
                                                <?= $sonuc['Kategori_Adi'] ?>
                                            </button>
                                        </h2>
                                        <div id="flush-<?= $sonuc['Kategori_ID'] ?>"
                                             class="accordion-collapse collapse show"
                                             data-bs-parent="#accordion<?= $sonuc['Kategori_ID'] ?>">
                                            <div class="row">
                                                <?php
                                                $sorgu2 = $baglanti->query("SELECT * FROM urun WHERE Kategori_ID=" . $sonuc['Kategori_ID']);
                                                foreach ($sorgu2 as $sonuc2) {
                                                    $Urun_ID = $sonuc2['Urun_ID'];
                                                    $UrunAdi = $sonuc2['UrunAdi'];
                                                    $UrunFoto = $sonuc2['UrunFoto'];
                                                    $Aciklama = $sonuc2['Aciklama'];
                                                    ?>
                                                    <label class="row g-3 col-md-2" for="<?= $Urun_ID ?>">
                                                        <input class="card__input" type="checkbox"
                                                               id="<?= $Urun_ID ?>"
                                                               value="<?= $Urun_ID ?>"
                                                               name="UrunIDler[]" <?php

                                                        $Ad1 = $baglanti->prepare("SELECT Urun_ID FROM set_urun WHERE  Set_ID= ?");
                                                        $Ad1->execute(array($Set_ID));
                                                        foreach ($Ad1 as $Adi1) {
                                                            $Ad2 = $baglanti->prepare("SELECT Urun_ID FROM urun WHERE  Urun_ID= ?");
                                                            $Ad2->execute(array($Adi1['Urun_ID']));
                                                            foreach ($Ad2 as $Adi2) {
                                                                if ($Adi2['Urun_ID'] == $Urun_ID) echo "checked";
                                                            }
                                                        }
                                                        ?>/>
                                                        <div class="card__body">
                                                            <div class="card__body-cover">
                                                                <img class="card__body-cover-image"
                                                                     src="../assets/img/Keksan/<?= $UrunFoto ?>"/>
                                                                <span class="card__body-cover-checkbox">
                                                                        <svg class="card__body-cover-checkbox--svg"
                                                                             viewBox="0 0 12 10">
                                                                            <polyline
                                                                                    points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                        </svg>
                                                                    </span>
                                                            </div>
                                                            <header class="card__body-header">
                                                                <h2 class="card__body-header-title"><?= $UrunAdi ?></h2>
                                                                <p class="card__body-header-subtitle"><?= $Aciklama ?></p>
                                                            </header>
                                                        </div>
                                                    </label>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="card-footer text-center">
                            <button name="SetDuzenle" type="submit" class="btn btn-primary col-sm-2">Seç
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
<?php
ob_end_flush();
require __DIR__ . '/../controller/Footer.php';
?>