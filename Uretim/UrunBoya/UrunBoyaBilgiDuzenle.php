<?php
ob_start();
$page = "Boya Bilgisi Düzenle";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Duzenle.php';
$Urun_ID = (int)$_GET['Urun_ID'];
$id = (int)$_GET['id'];
$sorgu = $baglanti->query("SELECT * FROM urun_boya_bilgi WHERE Urun_Boya_Bilgi_ID =" . $id);
$Sor = $sorgu->fetch();
?>
<main id="main" class="main">

    <section class="section">
        <div class="d-flex align-items-center justify-content-center min-vh-100">
            <div class="card col-sm-3">
                <div class="card-body ">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $page ?></h5>
                        <a href="UrunBoyaBilgi.php?Urun_ID=<?= $Urun_ID ?>">
                            <button type="button" class="btn btn-secondary"><i class="bi bi-arrow-left me-1"></i> Geri
                            </button>
                        </a>
                    </div>

                    <form class="row g-3 needs-validation" novalidate="" method="post">
                        <input type="hidden" name="Urun_ID" value="<?= $Urun_ID ?>" />
                        <input type="hidden" name="Urun_Boya_Bilgi_ID" value="<?= $id ?>" />

                        <div class="form-floating">
                            <input type="text" name="Marka" value="<?= $Sor['Marka'] ?>" class="form-control" required>
                            <label>Marka</label>
                        </div>

                        <div class="form-floating">
                            <input type="text" name="Renk" value="<?= $Sor['Renk'] ?>" class="form-control" required>
                            <label>Renk</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" name="icAstar" class="form-control" id="1" step="0.1" value="<?= $Sor['icAstar'] ?>" required>
                            <label for="1">İç - Astar</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" name="icUstkat" class="form-control" id="2" step="0.1" value="<?= $Sor['icUstkat'] ?>" required>
                            <label for="2">İç - Üst Kat</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" name="DisAstar" class="form-control" id="3" step="0.1" value="<?= $Sor['DisAstar'] ?>" required>
                            <label for="3">Dış - Astar</label>
                        </div>

                        <div class="form-floating">
                            <input type="number" name="DisUstkat" class="form-control" id="4" step="0.1" value="<?= $Sor['DisUstkat'] ?>" required>
                            <label for="4">Dış - Üst Kat</label>
                        </div>
                        <button name="UrunBoyaBilgiDuzenle" type="submit" class="btn btn-primary bi-pencil"> &nbsp Düzenle</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
</main>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>