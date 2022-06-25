<?php
ob_start();
$page = "Firma Ekle";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Kayit.php';
$Sec = $_GET["Sec"];
?>
    <main id="main" class="main">

        <section class="section">
            <div class="d-flex align-items-center justify-content-center">
                <div class="card col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= $page ?></h5>
                                <a href="Firmalar.php<?=$Sec=="true"?'?Sec=true':"" ?>">
                                    <button type="button" class="btn btn-secondary"><i
                                                class="bi bi-arrow-left me-1"></i> Geri
                                    </button>
                                </a>
                            </div>
                            <form class="row g-3" method="post">

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ad" placeholder="Firma Adı"
                                               name="Firma" required>
                                        <label for="ad">* Firma Adı</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="vd" placeholder="V.D" name="VD">
                                        <label for="vd">Vergi Dairesi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="vno" placeholder="Vergi No"
                                               name="Vergi_No">
                                        <label for="vno">Vergi No</label>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-floating">
                                        <textarea name="Adres_1" class="form-control" placeholder="1. Adres" id="Adres_1"
                                                  style="height: 100px;"></textarea>
                                        <label for="Adres_1">1. Adres</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <textarea name="Adres_2" class="form-control" placeholder="2. Adres" id="Adres_2"
                                                  style="height: 100px;"></textarea>
                                        <label for="Adres_2">2. Adres</label>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="Ulke" placeholder="Ülke"
                                                   name="Ulke">
                                            <label for="Ulke">Ülke</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="Sehir" placeholder="Şehir"
                                               name="Sehir">
                                        <label for="Sehir">Şehir</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="PK" placeholder="Posta Kodu"
                                               name="Posta_Kodu">
                                        <label for="PK">Posta Kodu</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="Tel" placeholder="Telefon"
                                               name="Tel_No">
                                        <label for="Tel">Telefon</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="Tel_Tip" aria-label="Hat Tipi" name="Tel_Tip">
                                            <option selected value="Sabit">Sabit</option>
                                            <option value="GSM">GSM</option>
                                        </select>
                                        <label for="Tel_Tip">Hat Tipi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="Email" placeholder="E Posta"
                                               name="E_Posta">
                                        <label for="Email">E Posta</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="Web" placeholder="Web Sitesi"
                                               name="Web_Sitesi">
                                        <label for="Web">Web Sitesi</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="Yadi" placeholder="Yetkili Adı"
                                               name="YetkiliAdi">
                                        <label for="Yadi">Yetkili Adı</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="Ytel"
                                               placeholder="Yetkili Telefon" name="YetkiliTel">
                                        <label for="Ytel">Yetkili Telefon</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="Aciklama" class="form-control" placeholder="Açıklama"
                                                  id="aciklama"
                                                  style="height: 100px;"></textarea>
                                        <label for="aciklama">Açıklama</label>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button name="FirmaEkle" type="submit" class="btn btn-primary"><i
                                                class="bi bi-save2 me-1"></i> Kaydet
                                    </button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main><!-- End #main -->
<?php
require __DIR__ . '/../controller/Footer.php';
?>