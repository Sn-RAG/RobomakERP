<?php
$page = "Firma Düzenle";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Duzenle.php';
$Firma_ID = (int)$_GET['id'];
$Tel_ID = (int)$_GET['Tel_ID'];
$Adres_ID = (int)$_GET['Adres_ID'];
$sorgu = $baglanti->query("SELECT * FROM firmalar WHERE Firma_ID =" . $Firma_ID);
$SorF = $sorgu->fetch();
$sorgu = $baglanti->query("SELECT * FROM firma_telefon WHERE Tel_ID =" . $Tel_ID);
$SorT = $sorgu->fetch();
$sorgu = $baglanti->query("SELECT * FROM firma_adres WHERE Adres_ID =" . $Adres_ID);
$SorA = $sorgu->fetch();
?>
    <main id="main" class="main">

        <section class="section">
            <div class="d-flex align-items-center justify-content-center">
                <div class="card col-sm-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="modal-header">
                                <h5 class="modal-title"><?= $page ?></h5>
                                <a href="Firmalar.php" class="btn btn-secondary bi-arrow-left">&nbsp Geri Dön</a>
                            </div>
                            <form class="row g-3">

                                <input type="hidden" name="Firma_ID" value="<?= $Firma_ID ?>"/>
                                <input type="hidden" name="Tel_ID" value="<?= $Tel_ID ?>"/>
                                <input type="hidden" name="Adres_ID" value="<?= $Adres_ID ?>"/>

                                <div class="col-md-12">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="ad" placeholder="Firma Adı"
                                               value="<?= $SorF['Firma'] ?>"
                                               name="Firma" required>
                                        <label for="ad">* Firma Adı</label>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="vd" placeholder="V.D" name="VD"
                                               value="<?= $SorF['VD'] ?>">
                                        <label for="vd">Vergi Dairesi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="vno" placeholder="Vergi No"
                                               value="<?= $SorF['Vergi_No'] ?>"
                                               name="Vergi_No">
                                        <label for="vno">Vergi No</label>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-floating">
                                        <textarea name="Adres_1" class="form-control" placeholder="1. Adres" id="Adres"
                                                  style="height: 100px;"><?= $SorA['Adres_1'] ?></textarea>
                                        <label for="Adres">1. Adres</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating">
                                        <textarea name="Adres_2" class="form-control" placeholder="2. Adres" id="Adres2"
                                                  style="height: 100px;"><?= $SorA['Adres_2'] ?></textarea>
                                        <label for="Adres2">2. Adres</label>
                                    </div>
                                </div>

                                <div class="col-md-5">
                                    <div class="col-md-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="Ulke" placeholder="Ülke"
                                                   value="<?= $SorA['Ulke'] ?>"
                                                   name="Ulke">
                                            <label for="Ulke">Ülke</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="Sehir" placeholder="Şehir"
                                               value="<?= $SorA['Sehir'] ?>"
                                               name="Sehir">
                                        <label for="Sehir">Şehir</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="PK" placeholder="P.Kodu"
                                               value="<?= $SorA['Posta_Kodu'] ?>"
                                               name="Posta_Kodu">
                                        <label for="PK">Posta K.</label>
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="Tel" placeholder="Telefon"
                                               value="<?= (int)$SorT['Tel_No'] ?>"
                                               name="Tel_No">
                                        <label for="Tel">Telefon</label>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <select class="form-select" id="Tel_Tip" aria-label="Hat Tipi" name="Tel_Tip">
                                            <option selected value="<?= $SorT['Tel_Tip'] ?>"><?php
                                                if ($SorT['Tel_Tip'] == "GSM") {
                                                    echo "GSM";
                                                } else echo "Sabit";
                                                ?></option>
                                            <option value="Sabit">Sabit</option>
                                            <option value="GSM">GSM</option>
                                        </select>
                                        <label for="Tel_Tip">Hat Tipi</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="email" class="form-control" id="Email" placeholder="E Posta"
                                               value="<?= $SorF['E_Posta'] ?>" name="E_Posta">
                                        <label for="Email">E Posta</label>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="Web" placeholder="Web Sitesi"
                                               value="<?= $SorF['Web_Sitesi'] ?>"
                                               name="Web_Sitesi">
                                        <label for="Web">Web Sitesi</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="Yadi" placeholder="Yetkili Adı"
                                               value="<?= $SorF['YetkiliAdi'] ?>"
                                               name="YetkiliAdi">
                                        <label for="Yadi">Yetkili Adı</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-floating">
                                        <input type="number" class="form-control" id="Ytel"
                                               value="<?= $SorF['YetkiliTel'] ?>"
                                               placeholder="Yetkili Telefon" name="YetkiliTel">
                                        <label for="Ytel">Yetkili Telefon</label>
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea name="Aciklama" class="form-control" placeholder="Açıklama"
                                                  id="aciklama"
                                                  style="height: 100px;"><?= $SorF['Aciklama'] ?></textarea>
                                        <label for="aciklama">Açıklama</label>
                                    </div>
                                </div>

                                <?php
                                if ($_POST) {
                                    echo '<div class="text-center bg-info text-dark fs-4">Firma Eklendi</div>';
                                }
                                ?>

                                <div class="text-center">
                                    <button name="FirmaDuzenle" type="submit" class="btn btn-primary"><i
                                                class="bi bi-pencil me-1"></i> Düzenle
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