<?php
ob_start();
$page = "Ürün Düzenle";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Duzenle.php';
require __DIR__ . '/../../controller/Kayit.php';
$Urun_ID = strip_tags(htmlspecialchars(trim($_GET['Urun_ID'])));
$UrunAdi = strip_tags(htmlspecialchars(trim($_GET['UrunAdi'])));
@$UrunFoto = strip_tags(htmlspecialchars(trim($_GET['UrunFoto'])));
@$Aciklama = strip_tags(htmlspecialchars(trim($_GET['Aciklama'])));
$Kategori_ID= strip_tags(htmlspecialchars(trim($_GET['Kategori_ID'])));
$KategoriAdi = strip_tags(htmlspecialchars(trim($_GET['KategoriAdi'])));
require __DIR__ . '/ResimSec.php';
?>
    <main id="main" class="main">

        <section class="section">
            <div class="d-flex align-items-center justify-content-center min-vh-100">
                <div class="card col-sm-4">
                    <form class="needs-validation" id="formum" method="post" enctype="multipart/form-data"
                          novalidate>
                        <div class="card-body ">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= $page ?></h5>

                                <a href="Urunler.php">
                                    <button type="button" class="btn btn-secondary"><i
                                                class="bi bi-arrow-left me-1"></i> Geri
                                    </button>
                                </a>
                            </div>
                            <br class="modal-body">
                            <input type="hidden" name="Urun_ID" value="<?= $Urun_ID ?>"/>
                            <input type="hidden" name="UrunFoto" value="<?= $UrunFoto ?>"/>
                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <input type="text" name="UrunAdi" value="<?= $UrunAdi ?>"
                                           class="form-control" placeholder="Ürün Adı">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                        <textarea name="Aciklama" class="form-control" placeholder="Ürün Hakkında"
                                                  style="height: 100px;"><?= $Aciklama ?></textarea>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <select name="Kategori_ID" class="form-select">
                                        <option value="<?= $Kategori_ID ?>"><?= $KategoriAdi ?></option>
                                        <?php
                                        //combobax kategori
                                        $sorgu = $baglanti->query("SELECT * FROM kategori");
                                        foreach ($sorgu as $sor) {
                                            ?>
                                            <option value="<?= $sor['Kategori_ID'] ?>"><?= $sor['Kategori_Adi'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-12">
                                    <button type="button" class="form-control btn-outline-dark"
                                            data-bs-toggle="modal"
                                            data-bs-target="#ResimSec"><i
                                                class="bi bi-image me-1"></i> Resim Seç
                                    </button>
                                </div>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button name="UrunDuzenle" type="submit" class="btn btn-primary"><i
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