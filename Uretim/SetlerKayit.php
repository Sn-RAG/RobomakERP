<?php
ob_start();
$page = "Yeni Set";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Kayit.php';
if (!$_GET){unset($_SESSION["Set_ID"],$_SESSION["SetAdi"],$_SESSION["UrunIDler"],$_SESSION["KulpSec"],$_SESSION["KapakSec"],$_SESSION["KalinlikSec"],$_SESSION["KutuSec"],$_SESSION["TepeSec"]);}

?>
    <!-- Stil Dosyası Başka Yerde çağarınca bütün tasarıma etki ediyor-->
    <link href="../assets/css/cbox.css" rel="stylesheet">


    <style>
        :root {
            --prm-color: #0381ff;
            --prm-gray: #f9f9f9;
        }

        /* CSS */
        .steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            position: relative;
        }

        .step-button {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            border: none;
            background-color: var(--prm-gray);
            transition: .4s;
        }

        .step-button[aria-expanded="true"] {
            width: 60px;
            height: 60px;
            background-color: var(--prm-color);
            color: #fff;
        }

        .step-item {
            z-index: 10;
            text-align: center;
        }

        #progress {
            -webkit-appearance: none;
            position: absolute;
            width: 95%;
            z-index: 5;
            height: 10px;
            margin-left: 18px;
            margin-bottom: 18px;
        }

        /* to customize progress bar */
        #progress::-webkit-progress-value {
            background-color: var(--prm-color);
            transition: .5s ease;
        }

        #progress::-webkit-progress-bar {
            background-color: var(--prm-gray);

        }

    </style>

    <main id="main" class="main">
        <section class="section">
            <div class="card col-sm-12">
                <div class="card-body">

                    <h5></h5>
                    <div class="py-3 mb-2">
                        <a href="Setler.php"
                           class="bi-arrow-left btn col-md-2 btn-secondary"> &nbsp;&nbsp;Geri
                            Dön</a>
                    </div>

                    <div class="container">
                        <div class="accordion" id="accordionExample">
                            <div class="steps row">
                                <progress id="progress" value="0" max="100"></progress>
                                <div class="step-item col-md-1">
                                    <button id="bir" class="step-button text-center" type="button"
                                            data-bs-toggle="collapse"
                                            data-bs-target="#collapsebir" aria-expanded="true"
                                            aria-controls="collapsebir">
                                        1
                                    </button>
                                    <div class="step-title">
                                        Set Adı
                                    </div>
                                </div>
                                <div class="step-item col-md-1">
                                    <button id="iki" class="step-button text-center collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseiki"
                                            aria-expanded="false" aria-controls="collapseiki">
                                        2
                                    </button>
                                    <div class="step-title">
                                        Ürün Seçimi
                                    </div>
                                </div>
                                <div class="step-item col-md-1">
                                    <button id="bes" class="step-button text-center collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsebes"
                                            aria-expanded="false" aria-controls="collapsebes">
                                        3
                                    </button>
                                    <div class="step-title">
                                        Kulp Seç
                                    </div>
                                </div>
                                <div class="step-item col-md-1">
                                    <button id="alti" class="step-button text-center collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsealti"
                                            aria-expanded="false" aria-controls="collapsealti">
                                        4
                                    </button>
                                    <div class="step-title">
                                        Kapak Seç
                                    </div>
                                </div>

                                <div class="step-item col-md-1">
                                    <button id="yedi" class="step-button text-center collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseyedi"
                                            aria-expanded="false" aria-controls="collapseyedi">
                                        5
                                    </button>
                                    <div class="step-title">
                                        Tepe Seç
                                    </div>
                                </div>
                                <div class="step-item col-md-1">
                                    <button id="sekiz" class="step-button text-center collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsesekiz"
                                            aria-expanded="false" aria-controls="collapsesekiz">
                                        6
                                    </button>
                                    <div class="step-title">
                                        Seçimler
                                    </div>
                                </div>

                                <div class="step-item col-md-1">
                                    <button id="dort" class="step-button text-center collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapsedort"
                                            aria-expanded="false" aria-controls="collapsedort">
                                        7
                                    </button>
                                    <div class="step-title">
                                        Set içeriği
                                    </div>
                                </div>
                                <div class="step-item col-md-1">
                                    <button id="uc" class="step-button text-center collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseuc"
                                            aria-expanded="false" aria-controls="collapseuc">
                                        8
                                    </button>
                                    <div class="step-title">
                                        Ürün Ayarla
                                    </div>
                                </div>
                            </div>

                            <div class="Sirala">
                                <div class="card s1">
                                    <div id="collapsebir" class="collapse show" aria-labelledby="headingOne"
                                         data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="row mb-3 py-3">
                                                <div class="col-md-4">
                                                    <input type="text" id="SetAdi" class="form-control" value="<?=isset($_SESSION["SetAdi"])?$_SESSION["SetAdi"]:""?>"
                                                           placeholder="Set Adı">
                                                </div>
                                                <div class="col-md-8">
                                                    <button id="Set" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri</button>
                                                </div>
                                                <label id="SetAdiKontrol" class="text-danger"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card s2">
                                    <div id="collapseiki" class="collapse" aria-labelledby="headingiki" data-bs-parent="#accordionExample">

                                        <div class="card-body">
                                            <div class="d-flex justify-content-between mb-2 py-2">
                                                <button id="GeriSetAdi" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                                                <label id="UrunBos" class="text-danger"></label>
                                                <button id="UrunSec" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri</button>
                                            </div>
                                            <div class="text-center"><a href="Urun/UrunEkle.php?Setler" type="button" class="btn bg-primary-light btn-outline-dark">&nbsp Ürün Ekle</a></div>
                                            <?php
                                            $sorgu = $baglanti->query("SELECT * FROM kategori");
                                            foreach ($sorgu as $sonuc) {
                                                ?>
                                                <div class="accordion accordion-flush col-md-12"
                                                     id="accordion<?=$sonuc['Kategori_ID']?>">
                                                    <div class="accordion-item">
                                                        <h2 class="accordion-header"><button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-<?=$sonuc['Kategori_ID']?>" aria-expanded="false"><?=$sonuc['Kategori_Adi']?></button></h2>
                                                        <div id="flush-<?=$sonuc['Kategori_ID']?>" class="accordion-collapse collapse show" data-bs-parent="#accordion<?= $sonuc['Kategori_ID'] ?>">
                                                            <div class="row">
                                                                <?php $sorgu2=$baglanti->query("SELECT * FROM urun WHERE Kategori_ID=".$sonuc['Kategori_ID']);
                                                                foreach ($sorgu2 as $sonuc2) {
                                                                    $ID = $sonuc2['Urun_ID'];
                                                                    $Foto=$sonuc2['UrunFoto'];?>
                                                                    <label class="row mb-3 col-md-3" for="<?= $ID ?>">
                                                                        <input class="card2__input" type="checkbox" id="<?= $ID ?>" value="<?= $ID ?>" name="UrunIDler[]" <?php if (isset($_SESSION["UrunIDler"])){foreach ($_SESSION["UrunIDler"] as $A) {if ($A == $ID){echo "checked";}}}?>>
                                                                        <div class="card2__body"><div class="card2__body-cover">
                                                                            <img class="card2__body-cover-image" src="../assets/img/Keksan/<?=$Foto=="yok"||$Foto==""||$Foto==null?"":$Foto?>">
                                                                            <span class="card2__body-cover-checkbox"><svg class="card2__body-cover-checkbox--svg" viewBox="0 0 12 10"><polyline points="1.5 6 4.5 9 10.5 1"></polyline></svg></span></div>
                                                                            <header class="card2__body-header">
                                                                                <h2 class="card2__body-header-title"><?= $sonuc2['UrunAdi'] ?></h2>
                                                                                <p class="card2__body-header-subtitle"></p>
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
                                    </div>
                                </div>

                                <div class="card s3">
                                    <div id="collapsebes" class="collapse" aria-labelledby="headingbes"
                                         data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between py-2">

                                                <button id="GeriUrunSec" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <select id='Kulp' class='form-select etkin'>
                                                            <option value="">Kulp Seç</option>
                                                            <?php $kulp=$baglanti->query("SELECT Kulp_ID, KulpAdi FROM kulp GROUP BY KulpAdi")->fetchAll();
                                                            foreach ($kulp as $s){?>
                                                                <option <?=isset($_SESSION["KulpSec"])?($_SESSION["KulpSec"]==$s["Kulp_ID"]?"selected":""):""?> value="<?=$s["Kulp_ID"]?>"><?=$s["KulpAdi"]?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <a href="../SatinAlma/Siparis/KulpSiparis.php?Setler" type="button" class="input-group-text bi-chevron-left bg-primary-light btn-outline-dark">&nbsp Ekle</a>
                                                    </div>
                                                </div>
                                                <button id="KulpSec" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri </button>

                                            </div>
                                            <label class="text-danger text-center col-md-12 KulpSecmedin"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card s4">
                                    <div id="collapsealti" class="collapse" aria-labelledby="headingalti"
                                         data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between py-2">

                                                <button id="GeriKulpSec" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <select id='Kapak' class='form-select etkin'>
                                                            <option value="">Kapak Seç</option>
                                                            <?php $kapak=$baglanti->query("SELECT Kapak_ID, Model_Adi FROM kapak GROUP BY Model_Adi")->fetchAll();
                                                            foreach ($kapak as $s){ ?>
                                                                <option <?=isset($_SESSION["KapakSec"])?($_SESSION["KapakSec"]==$s["Kapak_ID"]?"selected":""):""?> value="<?=$s["Kapak_ID"]?>"><?=$s["Model_Adi"]?></option>
                                                            <?php }?>
                                                        </select>
                                                        <a href="../SatinAlma/Siparis/KapakSiparis.php?Setler" type="button" class="input-group-text bi-chevron-left bg-primary-light btn-outline-dark">&nbsp Ekle</a>
                                                    </div>
                                                </div>
                                                <button id="KapakSec" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri </button>

                                            </div>
                                            <label class="text-danger text-center col-md-12 KapakSecmedin"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card s5">
                                    <div id="collapseyedi" class="collapse" aria-labelledby="headingyedi"
                                         data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between py-2">

                                                <button id="GeriKapakSec" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <select id='Tepe' class='form-select etkin'>
                                                            <option value="">Tepe Seç</option>
                                                            <?php $Tepe=$baglanti->query("SELECT Tepe_ID, TepeAdi FROM tepe GROUP BY TepeAdi")->fetchAll();
                                                            foreach ($Tepe as $s) { ?>
                                                            <option <?=isset($_SESSION["TepeSec"])?($_SESSION["TepeSec"]==$s["Tepe_ID"]?"selected":""):""?> value="<?=$s["Tepe_ID"]?>"><?=$s["TepeAdi"]?></option>
                                                            <?php }?>
                                                        </select>
                                                        <a href="../SatinAlma/Siparis/TepeSiparis.php?Setler" type="button" class="input-group-text bi-chevron-left bg-primary-light btn-outline-dark">&nbsp Ekle</a>
                                                    </div>
                                                </div>
                                                <button id="TepeSec" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri </button>

                                            </div>
                                            <label class="text-danger text-center col-md-12 KulpSecmedin"></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="card s6">
                                    <div id="collapsesekiz" class="collapse" aria-labelledby="headingsekiz"
                                         data-bs-parent="#accordionExample">
                                        <div class="card-body row">
                                            <div class="d-flex justify-content-between py-2">
                                                <button id="GeriTepeSec" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
                                                <label class="text-danger text-center col-md-10 SecimlerHata"></label>
                                                <button id="Secimler" type="button" class="btn btn-primary bi-arrow-right"> &nbsp İleri </button>
                                            </div>
                                            <div class="d-flex justify-content-center py-2">
                                                <div class="col-md-4 me-3">
                                                    <div class="input-group">
                                                        <select id='Kutu' class='form-select etkin'>
                                                            <?php
                                                            @$Kutu=$_SESSION["KutuSec"];
                                                            if (isset($Kutu)){?>
                                                                <option value='<?=$Kutu?>'><?=$Kutu?></option>
                                                                <option value='Sarı kutu'>Sarı kutu</option>
                                                                <option value='Ofset kutu'>Ofset kutu</option>
                                                            <?php }else{ ?>
                                                                <option value=''>* Kutu Seç</option>
                                                                <option value='Sarı kutu'>Sarı kutu</option>
                                                                <option value='Ofset kutu'>Ofset kutu</option>
                                                            <?php }?>
                                                        </select>
                                                        <a href="../SatinAlma/Siparis/KutuSiparis.php?Setler" type="button" class="input-group-text bi-chevron-left bg-primary-light btn-outline-dark">&nbsp Ekle</a>
                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <select id='Kalinlik' class='form-select'>
                                                            <option value="">* Kalınlık Seç</option>
                                                            <?php $Kalinlik = $baglanti->query("SELECT DISTINCT Kalinlik FROM levha ORDER BY Kalinlik ASC");
                                                            foreach ($Kalinlik as $s){ ?>
                                                            <option <?=isset($_SESSION["KalinlikSec"])?($_SESSION["KalinlikSec"]==$s["Kalinlik"]?"selected":""):""?> value="<?=$s["Kalinlik"]?>"><?=$s["Kalinlik"]?></option>
                                                            <?php }?>
                                                        </select>
                                                        <a href="../SatinAlma/Siparis/LevhaSiparis.php?Setler" type="button" class="input-group-text bi-chevron-left bg-primary-light btn-outline-dark">&nbsp Ekle</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card s7">
                                    <div id="collapsedort" class="collapse" aria-labelledby="headingdort"
                                         data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between py-2">
                                                <button id="GeriSecimler" type="button" class="btn btn-secondary bi-arrow-left"> &nbsp Geri</button>
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
                                                                foreach ($boya as $s){ ?>
                                                                <option <?=isset($_SESSION["icBoyaSec"])?($_SESSION["icBoyaSec"]==$s["Boya_ID"]?"selected":""):""?> value="<?=$s["Boya_ID"]?>"><?=$s["Renk"]?></option>
                                                                <?php }?>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <select name='DisBoyalar' class='form-select DisBoyalar'>
                                                                <option value=''>* Dış Boya Seç</option>
                                                                <?php foreach ($boya as $s){ ?>
                                                                    <option <?=isset($_SESSION["DisBoyaSec"])?($_SESSION["DisBoyaSec"]==$s["Boya_ID"]?"selected":""):""?> value="<?=$s["Boya_ID"]?>"><?=$s["Renk"]?></option>
                                                                <?php }?>
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
                                    </div>
                                </div>

                                <div class="card s8">
                                    <div id="collapseuc" class="collapse" aria-labelledby="headingThree"
                                         data-bs-parent="#accordionExample">
                                        <div class="card-body">
                                            <div class='py-3'>
                                                <div class='row g-0'>
                                                    <div class='col-md-3 resim'></div>

                                                    <input type="hidden" name="Set_Urun_Duzenle_ID">
                                                    <div class='col-md-8'>
                                                        <div class='card-body'><h5 class='card-title text-center baslik'>
                                                                &nbsp</h5>
                                                            <div class="card-text text-center row">

                                                                <div class="col-md-3 py-3">
                                                                    <label>İç Renk</label>
                                                                    <select name='icBoya' class='form-select etkin'
                                                                            disabled>
                                                                        <option></option>
                                                                        <?php foreach ($boya as $s){echo"<option value='$s[Boya_ID]'>$s[Renk]</option>";}?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-3 py-3">
                                                                    <label>Dış Renk</label>
                                                                    <select name='DisBoya' class='form-select etkin'
                                                                            disabled>
                                                                        <option></option>
                                                                        <?php
                                                                        foreach ($boya as $s){echo "<option value='$s[Boya_ID]'>$s[Renk]</option>";}?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-3 py-3">
                                                                    <label>Kapak</label>
                                                                    <select name='Kapak' class='form-select etkin'
                                                                            disabled>
                                                                        <option></option>
                                                                        <?php foreach ($kapak as $s){echo "<option value='$s[Kapak_ID]'>$s[Model_Adi]</option>";}?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-3 py-3">
                                                                    <label>Kulp</label>
                                                                    <select name='Kulp' class='form-select etkin' disabled>
                                                                        <option></option>
                                                                        <?php foreach ($kulp as $s) {echo "<option value='$s[Kulp_ID]'>$s[KulpAdi]</option>";}?>
                                                                    </select>
                                                                </div>

                                                                <div class="col-md-12 d-flex justify-content-end">
                                                                    <button id="icerikSec" type="button"
                                                                            class="btn btn-success me-3 etkin" hidden
                                                                            disabled>Ürün Düzenle
                                                                    </button>
                                                                    <a href="Yazdir.php?SetAdi=<?=@$_SESSION["SetAdi"]?>" class="btn col-md-2 btn-primary me-3">Kaydet</a>
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
                                            </div>
                                        </div>
                                        <div class="card-footer UrunleriGoster"></div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
require __DIR__ . "/AjaxForm/Ajax.php";
require __DIR__ . '/../controller/Footer.php';
?>