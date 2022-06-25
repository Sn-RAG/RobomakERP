<?php
ob_start();
$page = "Yeni Ürün";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Kayit.php';
@$UrunFoto = $_GET['UrunFoto'];
require __DIR__ . '/ResimSec.php';
?>
    <main id="main" class="main">

        <section class="section">
            <div class="d-flex align-items-center justify-content-center min-vh-100">
                <div class="card col-sm-4">
                    <form action="" class="needs-validation" id="formum" method="post" enctype="multipart/form-data"
                          novalidate>
                        <div class="card-body ">
                            <div class="modal-header">
                                <h5 class="modal-title"><?=$page?></h5>
                                <a href="<?=isset($_GET['Setler'])?"../SetlerKayit.php?Urunler":"Urunler.php"?>" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</a>
                            </div>
                            <div class="modal-body">

                                <input type="hidden" name="UrunFoto" value="<?= $UrunFoto ?>"/>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <input type="text" name="UrunAdi" value=""
                                               class="form-control" <?= isset($UrunFoto) == "" ? "disabled" : "" ?>
                                               placeholder="Ürün Adı" required>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <textarea name="Aciklama" class="form-control"
                                                  placeholder="Ürün Hakkında" <?= isset($UrunFoto) == "" ? "disabled" : "" ?>
                                                  style="height: 100px;"></textarea>
                                    </div>
                                </div>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <select name="Kategori_ID"
                                                class="form-select" <?= isset($UrunFoto) == "" ? "disabled" : "" ?>>
                                            <?php
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

                                <label class="mb-3">Yeni Resim Yükle</label>

                                <div class="row mb-3">
                                    <div class="col-sm-12">
                                        <input class="form-control" type="file" id="formFile"
                                               name="Resim" <?= isset($UrunFoto) != "" ? "disabled" : "" ?>>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button name="UrunEkle" type="submit" class="btn btn-primary"><i
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