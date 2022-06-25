<?php
ob_start();
$page = "Ürün Tasarla";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Kayit.php';
require __DIR__ . '/../../controller/Sil.php';
require __DIR__ . '/AjaxForm/ajax.php';
@$Sec = $_GET["Sec"];
?>
<main id="main" class="main">
    <section class="section">
            <div class="card">
                <div class="row">
                    <!-- Ürün Bilgi -->
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="row py-3">
                                    <div class="col-md-5">
                                    <a href="../Setler.php<?=$Sec=="true"?'?Sec=true':"" ?>" class="bi bi-arrow-left me-1 btn btn-secondary">&nbsp Geri Dön</a>
                                    </div>
                                    <div class="col-md-7">
                                        <h5 class="modal-title"><?=$page?></h5>
                                    </div>
                                </h5>
                                <form class="row g-3 needs-validation" method="post" novalidate="">
                                    <div class="col-md-6">

                                        <h5 class="card-title"></h5>
                                        <!-- Ürün RESİM -->
                                        <div class="resim d-flex align-items-center justify-content-center mb-3">
                                            <img src='' width='250px' height='200px'>
                                        </div>
                                        <!-- Ürün RESİM SON -->

                                        <input type="hidden" value="" id="UrunID">

                                        <div class="col-md-12 text-center">
                                            <label>
                                                <input type="text" id="UrunAdi" name="UrunAdi" class="form-control mb-2"
                                                       autocomplete="off" placeholder="Ürün Adını Girin" required>
                                                <!--VERİ ARAMAK İÇİN grup-->
                                                <div class="input-group">
                                                    <ul class="dropdown-menu" id="UrunAdlari">
                                                    </ul>
                                                </div>
                                                <!--VERİ ARAMAK İÇİN grup SON-->
                                            </label>
                                            <h5 class="card-title"><code class="UrunGoster"></code></h5>
                                            <p class="small"></p>
                                        </div>

                                    </div>

                                    <div class="col-md-6">

                                        <div class="col-md-12">
                                            <label class="form-label">Çap</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                            class="bi bi-bar-chart-steps"></i></span>
                                                <select class="form-select" id="Cap" disabled
                                                        required>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label class="form-label">Kalınlık</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                            class="bi bi-bar-chart-steps"></i></span>
                                                <select class="form-select" id="Kalinlik" disabled
                                                        required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">İç Boya Astar</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                            class="bi bi-brush"></i></span>
                                                <select class="form-select combo" id="icAstar" disabled required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">İç Boya
                                                Üstkat</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                            class="bi bi-brush"></i></span>
                                                <select class="form-select combo" id="icUstkat" disabled required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Dış Boya Astar</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                            class="bi bi-brush"></i></span>
                                                <select class="form-select combo" id="DisAstar" disabled required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label class="form-label">Dış Boya Üstkat</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                            class="bi bi-brush"></i></span>
                                                <select class="form-select combo" id="DisUstkat" disabled required>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <label for="Kulp" class="form-label">Kulp</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                            class="bi bi-wrench"></i></span>
                                                <input type="text" class="form-control" id="Kulp" disabled
                                                       required="">
                                                <div class="invalid-feedback">
                                                    Kulpu Seç!
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12">
                                            <label for="Tepe" class="form-label">Tepe</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                            class="bi bi-wrench"></i></span>
                                                <input type="text" class="form-control" id="Tepe" disabled
                                                       required="">
                                                <div class="invalid-feedback">
                                                    Tepeyi Seç!
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" modal-footer">
                                                <button class="btn btn-primary" type="button" id="SeteEkle" disabled>
                                                    Sete Ekle <i class="bi bi-plus-circle-dotted"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- Ürün Bilgi SON-->
                    <!-- SET Bilgi -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                             <form class="needs-validation" method="post" novalidate>
                                    <h5 class="card-title text-center">Set Bilgileri</h5>

                                    <div class="col-md-12 mb-3">

                                        <input type="hidden" id="SetID" name="SetID">

                                        <div class="input-group has-validation">
                                                <span class="input-group-text"><i
                                                            class="bi bi-palette"></i></span>
                                            <input type="text" class="form-control" id="Set" disabled
                                                   required="">
                                            <!--VERİ ARAMAK İÇİN grup-->
                                            <div class="input-group">
                                                <ul class="dropdown-menu" id="SetAdlari">
                                                </ul>
                                            </div>
                                            <!--VERİ ARAMAK İÇİN grup SON-->
                                        </div>
                                    </div>
                                    <!--VERİ YAZ-->
                                    <div class="UrunYaz row"></div>
                                    <!--VERİ YAZ SON-->
                                    <div class="card-footer text-center">
                                        <button class="btn btn-primary" type="submit" id="SetKayit" name="YeniSetKayit" disabled>Seti
                                            Kaydet
                                        </button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                    <!-- SET Bilgi SON -->
                </div>
            </div>
    </section>
</main>
<?php
ob_end_flush();
require __DIR__ . '/../../controller/Footer.php';
?>
