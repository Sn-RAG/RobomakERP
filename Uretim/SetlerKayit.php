<?php
ob_start();
$page = "Yeni Set";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Kayit.php';
if (!$_GET) {
    unset($_SESSION["SetAdi"], $_SESSION["UrunIDler"], $_SESSION["KulpSec"], $_SESSION["KapakSec"], $_SESSION["KutuSec"], $_SESSION["TepeSec"]);
}
$kapak = $baglanti->query("SELECT Kapak_ID, Model_Adi FROM kapak GROUP BY Model_Adi")->fetchAll();
$Tepe = $baglanti->query("SELECT Tepe_ID, TepeAdi FROM tepe GROUP BY TepeAdi")->fetchAll();
$kulp = $baglanti->query("SELECT Kulp_ID, KulpAdi FROM kulp GROUP BY KulpAdi")->fetchAll();
?>
<link href="../assets/css/cbox.css" rel="stylesheet">
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
            <div class="col-md-2 m-3"><a href="Setler.php" class="bi-arrow-left btn btn-secondary"> &nbsp;&nbsp; Geri Dön</a></div>
                <!-- Pills Tabs -->
                <ul class="nav nav-pills mb-3 steps">
                    <progress id="progress" value="0" max="100"></progress>
                    <li class="nav-item step-item">
                        <button id="Setadii" class="nav-link step-button rounded-pill active" data-bs-toggle="pill" data-bs-target="#ad" type="button">1</button>
                        <div class="step-title">Set Adı</div>
                    </li>
                    <li class="nav-item step-item">
                        <button id="Urunn" class="nav-link step-button rounded-pill" data-bs-toggle="pill" data-bs-target="#Urun" type="button">2</button>
                        <div class="step-title">Ürün</div>
                    </li>
                    <li class="nav-item step-item">
                        <button id="Kutuu" class="nav-link step-button rounded-pill" data-bs-toggle="pill" data-bs-target="#Kutuuu" type="button">3</button>
                        <div class="step-title">Kutu</div>
                    </li>
                    <li class="nav-item step-item">
                        <button id="Renkk" class="nav-link step-button rounded-pill" data-bs-toggle="pill" data-bs-target="#Renk" type="button">4</button>
                        <div class="step-title">Renk</div>
                    </li>
                    <li class="nav-item step-item">
                        <button id="Listee" class="nav-link step-button rounded-pill" data-bs-toggle="pill" data-bs-target="#Liste" type="button">5</button>
                        <div class="step-title">Listele</div>
                    </li>
                </ul>

                <div class="tab-content">

                    <div class="tab-pane fade active show" id="ad">

                        <div class="row">
                            <div class="col-md-4">
                                <input type="text" id="SetAdi" class="form-control" value="<?= isset($_SESSION["SetAdi"]) ? $_SESSION["SetAdi"] : "" ?>" placeholder="Set Adı">
                            </div>
                            <div class="col-md-8">
                                <button id="ileriUrun" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri</button>
                            </div>
                            <label id="SetAdiKontrol" class="text-danger"></label>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="Urun">

                        <div class="d-flex justify-content-between mb-2 py-2">
                            <button id="GeriSetAdi" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                            <label id="UrunBos" class="text-danger"></label>
                            <button id="ileriKutu" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri</button>
                        </div>
                        <div class="text-center"><a href="Urun/UrunEkle.php?Setler" type="button" class="btn bg-primary-light btn-outline-dark">&nbsp Ürün Ekle</a></div>
                        <?php
                        $sorgu = $baglanti->query("SELECT * FROM kategori");
                        foreach ($sorgu as $sonuc) {
                        ?>
                            <div class="accordion accordion-flush col-md-12" id="accordion<?= $sonuc['Kategori_ID'] ?>">
                                <div class="accordion-item">
                                    <h2 class="accordion-header d-grid gap-2 mt-3"><button class="collapsed btn btn-light mb-1 fw-bold text-start" type="button" data-bs-toggle="collapse" data-bs-target="#flush-<?= $sonuc['Kategori_ID'] ?>" aria-expanded="false"><?= $sonuc['Kategori_Adi'] ?></button></h2>
                                    <div id="flush-<?= $sonuc['Kategori_ID'] ?>" class="accordion-collapse collapse" data-bs-parent="#accordion<?= $sonuc['Kategori_ID'] ?>">
                                        <div class="row">
                                            <?php $sorgu2 = $baglanti->query("SELECT * FROM urun WHERE Kategori_ID=" . $sonuc['Kategori_ID']);
                                            foreach ($sorgu2 as $sonuc2) {
                                                $ID = $sonuc2['Urun_ID'];
                                                $Foto = $sonuc2['UrunFoto']; ?>
                                                <label class="row mb-3 col-md-3" for="<?= $ID ?>">
                                                    <input class="card2__input UrunSecim" type="checkbox" id="<?= $ID ?>" value="<?= $ID ?>" name="UrunIDler[]" <?php if (isset($_SESSION["UrunIDler"])) {
                                                                                                                                                                    foreach ($_SESSION["UrunIDler"] as $A) {
                                                                                                                                                                        if ($A == $ID) {
                                                                                                                                                                            echo "checked";
                                                                                                                                                                        }
                                                                                                                                                                    }
                                                                                                                                                                } ?>>
                                                    <div class="card2__body">
                                                        <div class="row">
                                                            <div class="col-md-7">
                                                                <div class="card2__body-cover">
                                                                    <img class="card2__body-cover-image" src="../assets/img/Keksan/<?= $Foto == "yok" || $Foto == "" || $Foto == null ? "" : $Foto ?>">
                                                                    <span class="card2__body-cover-checkbox"><svg class="card2__body-cover-checkbox--svg" viewBox="0 0 12 10">
                                                                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                                        </svg></span>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-5">
                                                                <div class="row g-3 col-md-4">
                                                                    <h5></h5>
                                                                    <div class="btn-group">
                                                                        <button class="btn btn-outline-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">Kalınlık</button>
                                                                        <ul class="dropdown-menu card-body py-3">
                                                                            <select class='kal<?= $ID ?> form-select form-select-sm mm' id="Kalinlik" urunid="<?= $ID ?>"><?php foreach ($baglanti->query("SELECT levha.Levha_ID AS Lid,Kalinlik FROM urun_levha_bilgi INNER JOIN levha ON urun_levha_bilgi.Levha_ID = levha.Levha_ID WHERE Urun_ID =" . $ID) as $K) {
                                                                                                                                            echo "<option value='$K[Lid]'>$K[Kalinlik] mm</option>";
                                                                                                                                        } ?>
                                                                            </select>
                                                                        </ul>
                                                                    </div>

                                                                    <div class="btn-group">
                                                                        <button class="btn btn-outline-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">Kulp</button>
                                                                        <ul class="dropdown-menu card-body py-3">
                                                                            <div class="input-group-sm">
                                                                                <select id='Kulp<?= $ID ?>' class='form-select etkin mb-2'>
                                                                                    <option value="">Kulp Seç</option>
                                                                                    <?php
                                                                                    foreach ($kulp as $s) { ?>
                                                                                        <option <?= isset($_SESSION["KulpSec"]) ? ($_SESSION["KulpSec"] == $s["Kulp_ID"] ? "selected" : "") : "" ?> value="<?= $s["Kulp_ID"] ?>"><?= $s["KulpAdi"] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <a href="../SatinAlma/Siparis/KulpSiparis.php?Setler" type="button" class="input-group-text bg-primary-light text-center">Ekle</a>
                                                                            </div>
                                                                        </ul>
                                                                    </div>

                                                                    <div class="btn-group">
                                                                        <button class="btn btn-outline-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">Tepe</button>
                                                                        <ul class="dropdown-menu card-body py-3">
                                                                            <div class="input-group-sm">
                                                                                <select id='Tepe<?= $ID ?>' class='form-select etkin mb-2'>
                                                                                    <option value="">Tepe Seç</option>
                                                                                    <?php 
                                                                                    foreach ($Tepe as $s) { ?>
                                                                                        <option <?= isset($_SESSION["TepeSec"]) ? ($_SESSION["TepeSec"] == $s["Tepe_ID"] ? "selected" : "") : "" ?> value="<?= $s["Tepe_ID"] ?>"><?= $s["TepeAdi"] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <a href="../SatinAlma/Siparis/TepeSiparis.php?Setler" type="button" class="input-group-text bg-primary-light text-center">Ekle</a>
                                                                            </div>
                                                                        </ul>
                                                                    </div>

                                                                    <div class="btn-group">
                                                                        <button class="btn btn-outline-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">Kapak</button>
                                                                        <ul class="dropdown-menu card-body py-3">
                                                                            <div class="input-group-sm">
                                                                                <select id='Kapak<?= $ID ?>' urunid="<?= $ID ?>" class='form-select etkin mb-2 Kapak'>
                                                                                    <option value="">Kapak Seç</option>
                                                                                    <?php 
                                                                                    foreach ($kapak as $s) { ?>
                                                                                        <option <?= isset($_SESSION["KapakSec"]) ? ($_SESSION["KapakSec"] == $s["Kapak_ID"] ? "selected" : "") : "" ?> value="<?= $s["Kapak_ID"] ?>"><?= $s["Model_Adi"] ?></option>
                                                                                    <?php } ?>
                                                                                </select>
                                                                                <a href="../SatinAlma/Siparis/KapakSiparis.php?Setler" type="button" class="input-group-text bg-primary-light text-center">Ekle</a>
                                                                            </div>
                                                                        </ul>
                                                                    </div>

                                                                </div>
                                                            </div>
                                                            <header class="card2__body-header">
                                                                <h2 class="card2__body-header-title"><?= $sonuc2['UrunAdi'] ?></h2>
                                                                <p class="card2__body-header-subtitle row">
                                                                    <code id="mm<?= $ID ?>"></code>
                                                                    <code id="Kulp<?= $ID ?>"></code>
                                                                    <code id="Tepe<?= $ID ?>"></code>
                                                                    <code id="Kapak<?= $ID ?>"></code>
                                                                </p>
                                                            </header>
                                                        </div>

                                                    </div>
                                                </label>
                                            <?php } ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="tab-pane fade" id="Kutuuu">

                        <div class="row">
                            <div class="d-flex justify-content-between py-2">
                                <button id="GeriUrun" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                                <label class="text-danger text-center col-md-10 SecimlerHata"></label>
                                <button id="ileriRenkler" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri </button>
                            </div>
                            <div class="d-flex justify-content-center py-2">
                                <div class="col-md-4 me-3">
                                    <div class="input-group">
                                        <select id='Kutu' class='form-select etkin'>
                                            <?php
                                            @$Kutu = $_SESSION["KutuSec"];
                                            if (isset($Kutu)) { ?>
                                                <option value='<?= $Kutu ?>'><?= $Kutu ?></option>
                                                <option value='Sarı kutu'>Sarı kutu</option>
                                                <option value='Ofset kutu'>Ofset kutu</option>
                                            <?php } else { ?>
                                                <option value=''>* Kutu Seç</option>
                                                <option value='Sarı kutu'>Sarı kutu</option>
                                                <option value='Ofset kutu'>Ofset kutu</option>
                                            <?php } ?>
                                        </select>
                                        <a href="../SatinAlma/Siparis/KutuSiparis.php?Setler" type="button" class="input-group-text bi-chevron-left bg-primary-light btn-outline-dark">&nbsp Ekle</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Renk">

                        <div class="d-flex justify-content-between py-2">
                            <button id="GeriKutu" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                            <a href="../SatinAlma/Siparis/BoyaSiparis.php?Setler" class="btn btn-outline-dark bi-brush"> &nbsp Boya Ekle</a>
                            <div class="text-danger Fazlainput"></div>
                            <button id="SetTamam" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri</button>
                        </div>
                        <div class="py-3">
                            <div class="inputlar">
                                <div class="form-group row g-3 mb-3">
                                    <div class="col-md-4">
                                        <select name='icBoyalar' class='form-select icBoyalar'>
                                            <option value=''>* İç Boya Seç</option>
                                            <?php $boya = $baglanti->query("SELECT Boya_ID, Renk FROM boya GROUP BY Renk")->fetchAll();
                                            foreach ($boya as $s) { ?>
                                                <option <?= isset($_SESSION["icBoyaSec"]) ? ($_SESSION["icBoyaSec"] == $s["Boya_ID"] ? "selected" : "") : "" ?> value="<?= $s["Boya_ID"] ?>"><?= $s["Renk"] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <select name='DisBoyalar' class='form-select DisBoyalar'>
                                            <option value=''>* Dış Boya Seç</option>
                                            <?php foreach ($boya as $s) { ?>
                                                <option <?= isset($_SESSION["DisBoyaSec"]) ? ($_SESSION["DisBoyaSec"] == $s["Boya_ID"] ? "selected" : "") : "" ?> value="<?= $s["Boya_ID"] ?>"><?= $s["Renk"] ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="Adetler" class="form-control Adetler" placeholder="* Adet gir">
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-success mb-3 input-ekle bi-plus-lg"></button>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="Liste">
                        <div class='row g-0'>
                            <div class='col-md-3 resim'></div>

                            <input type="hidden" name="Set_Urun_Duzenle_ID">
                            <div class='col-md-8'>
                                <div class='card-body'>
                                    <h5 class='card-title text-center baslik'>
                                        &nbsp</h5>
                                    <div class="card-text text-center row">

                                        <div class="col-md-3 py-3">
                                            <label>İç Renk</label>
                                            <select name='icBoya' class='form-select etkin' disabled>
                                                <option></option>
                                                <?php foreach ($boya as $s) {
                                                    echo "<option value='$s[Boya_ID]'>$s[Renk]</option>";
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3 py-3">
                                            <label>Dış Renk</label>
                                            <select name='DisBoya' class='form-select etkin' disabled>
                                                <option></option>
                                                <?php
                                                foreach ($boya as $s) {
                                                    echo "<option value='$s[Boya_ID]'>$s[Renk]</option>";
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3 py-3">
                                            <label>Kapak</label>
                                            <select name='Kapak' class='form-select etkin' disabled>
                                                <option></option>
                                                <?php foreach ($kapak as $s) {
                                                    echo "<option value='$s[Kapak_ID]'>$s[Model_Adi]</option>";
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-3 py-3">
                                            <label>Kulp</label>
                                            <select name='Kulp' class='form-select etkin' disabled>
                                                <option></option>
                                                <?php foreach ($kulp as $s) {
                                                    echo "<option value='$s[Kulp_ID]'>$s[KulpAdi]</option>";
                                                } ?>
                                            </select>
                                        </div>

                                        <div class="col-md-12 d-flex justify-content-end">
                                            <button id="icerikSec" type="button" class="btn btn-success me-3 etkin" hidden disabled>Ürün Düzenle</button>
                                            <a href="Setler.php" class="btn col-md-2 btn-primary me-3">Kaydet</a>
                                            <a href="Yazdir.php?Levha" class="btn col-md-2 btn-primary me-3">Levha Hesapla</a>
                                            <div class="col-md-3 row me-3">
                                                <label class="col-sm-4 col-form-label">Adet</label>
                                                <div class="col-sm-8">
                                                    <input type="number" name="Adet" class="form-control etkin" disabled>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer UrunleriGoster"></div>
                    </div>
                </div><!-- End Pills Tabs -->
            </div>
        </div>
    </section>
</main>
<?php
require __DIR__ . "/AjaxForm/Ajax.php";
require __DIR__ . '/../controller/Footer.php';
?>