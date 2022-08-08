<?php
ob_start();
$page = "Yeni Set";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Kayit.php';
?>
<link href="../assets/css/cbox.css" rel="stylesheet">
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <a href="Setler.php" class="bi-arrow-left btn btn-secondary m-3">&nbsp Geri Dön</a>
                <hr>
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

                        <div class="row border-top">
                            <div class="col-md-4 py-3 mb-3">
                                <input type="text" id="SetAdi" class="form-control" value="<?= isset($_SESSION["SetAdi"]) ? $_SESSION["SetAdi"] : "" ?>" placeholder="Set Adı">
                            </div>
                            <div class="col-md-4 py-4 mb-3 text-end">
                                <label id="SetAdiKontrol" class="text-danger"></label>
                            </div>
                            <div class="col-md-4 d-flex justify-content-end py-3 mb-3">
                                <button id="ileriUrun" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri</button>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="Urun">
                        <div class="border-top">
                            <div class="d-flex justify-content-between py-3">
                                <button id="GeriSetAdi" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                                <label id="UrunBos" class="text-danger"></label>
                                <button id="ileriKutu" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri</button>
                            </div>
                            <div class="text-center"><a href="Urun/UrunEkle.php?Setler" type="button" class="btn bg-primary-light btn-outline-dark">&nbsp Ürün Ekle</a></div>
                            <?php
                            $kapak = $baglanti->query("SELECT Kapak_ID, Model_Adi FROM kapak GROUP BY Model_Adi")->fetchAll();
                            $Tepe = $baglanti->query("SELECT Tepe_ID, TepeAdi FROM tepe GROUP BY TepeAdi")->fetchAll();
                            $kulp = $baglanti->query("SELECT Kulp_ID, KulpAdi FROM kulp GROUP BY KulpAdi")->fetchAll();
                            $u = 0;
                            $m = 0;
                            $kl = 0;
                            $kp = 0;
                            $t = 0;
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
                                                    $urun = false;
                                                    $ID = $sonuc2['Urun_ID'];
                                                    $Foto = $sonuc2['UrunFoto']; ?>
                                                    <label class="row mb-3 col-md-3" for="<?= $ID ?>">
                                                        <input class="card2__input UrunSecim" type="checkbox" id="<?= $ID ?>" name="UrunIDler[]" <?php if (isset($_SESSION["UrunIDler"])) {
                                                                                                                                                        if (array_key_exists($u, $_SESSION["UrunIDler"])) {
                                                                                                                                                            if ($_SESSION["UrunIDler"][$u] == $ID) {
                                                                                                                                                                echo "checked";
                                                                                                                                                                $u++;
                                                                                                                                                                $urun = true;
                                                                                                                                                            }
                                                                                                                                                        }
                                                                                                                                                    } ?>>
                                                        <div class="card2__body">
                                                            <div class="row">
                                                                <div class="col-md-7">
                                                                    <div class="card2__body-cover">
                                                                        <img class="card2__body-cover-image" src="../assets/img/Keksan/<?= $Foto == "yok" || $Foto == "" || $Foto == null ? "fotoyok.jpg" : $Foto ?>">
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
                                                                                <div class="input-group-sm">
                                                                                    <select class='form-select mb-2 mm' id="kal<?= $ID ?>" urunid="<?= $ID ?>">
                                                                                        <option value="">Kalınlık Seç</option>
                                                                                        <?php
                                                                                        $Levha = $baglanti->query("SELECT Levha_ID,Kalinlik FROM view_urun_levha_bilgi WHERE Urun_ID =" . $ID);
                                                                                        if ($urun == true) {
                                                                                            foreach ($Levha as $s) {
                                                                                                echo "<option ";
                                                                                                if ($_SESSION["mmSec"][$m] == $s["Levha_ID"]) {
                                                                                                    echo "selected";
                                                                                                }
                                                                                                echo " value='$s[Levha_ID]'>$s[Kalinlik] mm</option>";
                                                                                            }
                                                                                            $m++;
                                                                                        } else {
                                                                                            foreach ($Levha as $s) {
                                                                                                echo "<option value='$s[Levha_ID]'>$s[Kalinlik]</option>";
                                                                                            }
                                                                                        } ?>
                                                                                    </select>
                                                                                    <a href="../SatinAlma/Siparis/LevhaSiparis.php?Setler" type="button" class="input-group-text bg-primary-light text-center">Ekle</a>
                                                                                </div>
                                                                            </ul>
                                                                        </div>

                                                                        <div class="btn-group">
                                                                            <button class="btn btn-outline-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">Kulp</button>
                                                                            <ul class="dropdown-menu card-body py-3">
                                                                                <div class="input-group-sm">
                                                                                    <select id='Kulp<?= $ID ?>' urunid="<?= $ID ?>" class='form-select mb-2 Kulp'>
                                                                                        <option value="">Kulp Seç</option>
                                                                                        <?php
                                                                                        if ($urun == true) {
                                                                                            if (array_key_exists($kl, $_SESSION["KulpSec"])) {
                                                                                                foreach ($kulp as $s) {
                                                                                                    echo "<option ";
                                                                                                    if ($_SESSION["KulpSec"][$kl] == $s["Kulp_ID"]) {
                                                                                                        echo "selected ";
                                                                                                    }
                                                                                                    echo "value='$s[Kulp_ID]'>$s[KulpAdi]</option>";
                                                                                                }
                                                                                                $kl++;
                                                                                            }
                                                                                        } else {
                                                                                            foreach ($kulp as $s) {
                                                                                                echo "<option value='$s[Kulp_ID]'>$s[KulpAdi]</option>";
                                                                                            }
                                                                                        } ?>
                                                                                    </select>
                                                                                    <a href="../SatinAlma/Siparis/KulpSiparis.php?Setler" type="button" class="input-group-text bg-primary-light text-center">Ekle</a>
                                                                                </div>
                                                                            </ul>
                                                                        </div>

                                                                        <div class="btn-group">
                                                                            <button class="btn btn-outline-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">Tepe</button>
                                                                            <ul class="dropdown-menu card-body py-3">
                                                                                <div class="input-group-sm">
                                                                                    <select id='Tepe<?= $ID ?>' urunid="<?= $ID ?>" class='form-select mb-2 Tepe'>
                                                                                        <option value="">Tepe Seç</option>
                                                                                        <?php
                                                                                        if ($urun == true) {
                                                                                            if (array_key_exists($t, $_SESSION["TepeSec"])) {
                                                                                                foreach ($Tepe as $s) {
                                                                                                    echo "<option ";
                                                                                                    if ($_SESSION["TepeSec"][$t] == $s["Tepe_ID"]) {
                                                                                                        echo "selected";
                                                                                                    }
                                                                                                    echo " value='$s[Tepe_ID]'>$s[TepeAdi]</option>";
                                                                                                }
                                                                                                $t++;
                                                                                            }
                                                                                        } else {
                                                                                            foreach ($Tepe as $s) {
                                                                                                echo "<option value='$s[Tepe_ID]'>$s[TepeAdi]</option>";
                                                                                            }
                                                                                        } ?>
                                                                                    </select>
                                                                                    <a href="../SatinAlma/Siparis/TepeSiparis.php?Setler" type="button" class="input-group-text bg-primary-light text-center">Ekle</a>
                                                                                </div>
                                                                            </ul>
                                                                        </div>

                                                                        <div class="btn-group">
                                                                            <button class="btn btn-outline-primary dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">Kapak</button>
                                                                            <ul class="dropdown-menu card-body py-3">
                                                                                <div class="input-group-sm">
                                                                                    <select id='Kapak<?= $ID ?>' urunid="<?= $ID ?>" class='form-select mb-2 Kapak'>
                                                                                        <option value="">Kapak Seç</option>
                                                                                        <?php
                                                                                        if ($urun == true) {
                                                                                            if (array_key_exists($kp, $_SESSION["KapakSec"])) {
                                                                                                foreach ($kapak as $s) {
                                                                                                    echo "<option ";
                                                                                                    if ($_SESSION["KapakSec"][$kp] == $s["Kapak_ID"]) {
                                                                                                        echo "selected";
                                                                                                    }
                                                                                                    echo " value='$s[Kapak_ID]'>$s[Model_Adi]</option>";
                                                                                                }
                                                                                                $kp++;
                                                                                            }
                                                                                        } else {
                                                                                            foreach ($kapak as $s) {
                                                                                                echo "<option value='$s[Kapak_ID]'>$s[Model_Adi]</option>";
                                                                                            }
                                                                                        } ?>
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
                                                                        <code id="mmy<?= $ID ?>"></code>
                                                                        <code id="Kulpy<?= $ID ?>"></code>
                                                                        <code id="Tepey<?= $ID ?>"></code>
                                                                        <code id="Kapaky<?= $ID ?>"></code>
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
                    </div>
                    <div class="tab-pane fade" id="Kutuuu">

                        <div class="row border-top">
                            <div class="d-flex justify-content-between py-3">
                                <button id="GeriUrun" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                                <label class="text-danger text-center col-md-10 KutuHata"></label>
                                <button id="ileriRenkler" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri </button>
                            </div>
                            <div class="d-flex justify-content-center py-2">
                                <div class="col-md-4 me-3">
                                    <div class="input-group">
                                        <select id='Kutu' class='form-select etkin'>
                                            <option value=''>* Kutu Seç</option>
                                            <option value='Sarı kutu'>Sarı kutu</option>
                                            <option value='Ofset kutu'>Ofset kutu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Renk">
                        <div class="border-top">
                            <div class="d-flex justify-content-between mb-3 py-3">
                                <button id="GeriKutu" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                                <a href="../SatinAlma/Siparis/BoyaSiparis.php?Setler" class="btn btn-outline-dark bi-brush"> &nbsp Boya Ekle</a>
                                <div class="text-danger Fazlainput"></div>
                                <button id="SetTamam" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri</button>
                            </div>
                            <div class="mb-3">
                                <div class="inputlar">
                                    <div class="form-group border-bottom border-dark mb-3">
                                        <div class="mb-3"></div>
                                        <div class="d-flex align-items-center mb-3">

                                            <div class="input-group me-1">
                                                <select class='form-select icM'>
                                                    <option value=''>* İç Boya Marka Seç</option>
                                                    <?php
                                                    $Marka = $baglanti->query("SELECT DISTINCT Marka FROM boya")->fetchAll();
                                                    foreach ($Marka as $s) {
                                                        echo "<option value='$s[Marka]'>$s[Marka]</option>";
                                                    } ?>
                                                </select>
                                                <select class='form-select icBoyalar' id="icBoya" disabled>
                                                </select>
                                            </div>

                                            <i class="bi bi-dash-lg me-1"></i>

                                            <div class="input-group">
                                                <select class='form-select icD'>
                                                    <option value=''>* Dış Boya Marka Seç</option>
                                                    <?php foreach ($Marka as $s) {
                                                        echo "<option value='$s[Marka]'>$s[Marka]</option>";
                                                    } ?>
                                                </select>
                                                <select class='form-select DisBoyalar' id="DisBoya" disabled>
                                                </select>
                                            </div>
                                        </div>

                                        <div>
                                            <div>
                                                <div class="d-flex mb-3">

                                                    <select class='form-select me-3 Kircil'>
                                                        <option value=''>Kırçıl Seç</option>
                                                        <?php $kircil = $baglanti->query("SELECT Boya_ID, Renk FROM boya WHERE Seri='Kırçıl' GROUP BY Renk")->fetchAll();
                                                        foreach ($kircil as $s) {
                                                            echo "<option value='$s[Boya_ID]'>$s[Renk]</option>";
                                                        } ?>
                                                    </select>

                                                    <select class='form-select me-3 Kircill'>
                                                        <option value=''>Kırçıl Seç</option>
                                                        <?php foreach ($kircil as $s) {
                                                            echo "<option value='$s[Boya_ID]'>$s[Renk]</option>";
                                                        } ?>
                                                    </select>

                                                    <input type="number" name="Adetler" class="form-control Adetler me-3" placeholder="* Adet gir">

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-success mb-3 input-ekle bi-plus-lg"></button>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="Liste">
                        <div class='row g-0 border-top'>
                            <div class='col-md-3 resim'></div>

                            <input type="hidden" name="Set_Urun_Duzenle_ID">
                            <div class='col-md-8'>
                                <div class='card-body'>
                                    <h5 class='card-title text-center baslik'>&nbsp</h5>
                                    <div class="row">

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
                                            <a href="SetKontrol/FormHesapLevha.php?id=<?= isset($_SESSION["Set_ID"]) ? $_SESSION["Set_ID"] : "" ?>&adi=<?= isset($_SESSION["SetAdi"]) ? $_SESSION["SetAdi"] : "" ?>" class="btn col-md-2 btn-primary me-3" target="_blank" rel="noreferrer noopener">Levha Hesapla</a>
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