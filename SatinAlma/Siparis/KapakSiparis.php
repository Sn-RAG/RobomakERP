<?php
ob_start();
$page = "Kapak Sipariş";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Kayit.php';
?>
    <main id="main" class="main">
        <section class="section">
            <div class="d-flex align-items-center justify-content-center min-vh-100">
                <div class="card col-sm-4">
                    <form class="needs-validation" method="post" novalidate>
                        <div class="modal-header mb-3">
                            <h5 class="modal-title"><?= $page ?></h5>
                            <a href="<?=isset($_GET["Setler"])?"../../Uretim/SetlerKayit.php?SetKayit":"../../Navigasyon/SiparisEt.php"?>" class="btn btn-secondary bi-arrow-left">&nbsp Geri Dön</a>
                        </div>
                        <div class="card-body row g-3">

                            <div class="col-md-12">
                                <label>Tip</label>
                                <select name='Tip' class='form-select' id='Tip'>
                                    <option selected value='Daire'>Daire</option>
                                    <option value='Kare'>Kare</option>
                                    <option value='Dikdörtgen'>Dikdörtgen</option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <label>Kapak_No</label>
                                <input type='text' name='Kapak_No' class='form-control'>
                                <!--VERİ ARAMAK İÇİN grup-->
                                <div class="input-group">
                                    <ul class="dropdown-menu" id="Kapak_Nolari">
                                    </ul>
                                </div>
                                <!--VERİ ARAMAK İÇİN grup SON-->
                            </div>

                            <div class="col-md-12">
                                <label>Model_Adi</label>
                                <input type='text' name='Model_Adi' class='form-control'><!--VERİ ARAMAK İÇİN grup-->
                                <div class="input-group">
                                    <ul class="dropdown-menu" id="Model_Adlari">
                                    </ul>
                                </div>
                                <!--VERİ ARAMAK İÇİN grup SON-->
                            </div>

                            <div class="col-md-12">
                                <label>Adet</label>
                                <input type="number" name="Adet" class="form-control"
                                       required>
                            </div>

                            <div class="col-md-12">
                                <div class="form-floating">
                                    <input type="date" name="S_Tarihi" class="form-control" id="trhs" value="<?php
                                    date_default_timezone_set('Europe/Istanbul');
                                    $tarih = new DateTime("now");
                                    $tarih = date("Y-m-d");
                                    echo $tarih;
                                    ?>" required>
                                    <label for="trhs">Sipariş Tarihi</label>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <div class="text-center">
                                <button name="KapakSiparis" type="submit" class="btn btn-primary"><i
                                            class="bi bi-save2 me-1"></i>Kaydet
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </main>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>