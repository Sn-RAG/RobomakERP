<?php
$page = "Satın Alma";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . "/../controller/Link.php";
?>
    <main id="main" class="main">
        <section class='section'>
            <div class='row py-5'>
                <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>Navigasyon/SiparisEt.php'>
                        <button class='form-control btn-outline-success'
                                style='border: 0 solid #ffffff00;display: flex;background-color: #0d3d62;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px; justify-content: center;align-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: stretch;'>
                            Sipariş<img src='<?= $Link ?>assets/img/ConteinerLink/siparis.svg'></button>
                    </a></div>
                <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>SatinAlma/GorusulenFirmalar.php'>
                        <button class='form-control btn-outline-success' class='form-control btn-outline-success'
                                style='display: flex;background-color: #140c6a;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;'>
                            Görüşülen Firmalar <img src='<?= $Link ?>assets/img/ConteinerLink/gorusulenfirmalar.svg'>
                        </button>
                    </a></div>
                <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>SatinAlma/UretimIhtiyaclari.php'>
                        <button class='form-control btn-outline-success'
                                style='display: flex;background-color: #3518b9;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;'>
                            Üretim İhtiyaçları<img src='<?= $Link ?>assets/img/ConteinerLink/uretimihtiyaclari.svg'>
                        </button>
                    </a></div>
                <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>SatinAlma/Operasyonlar.php'>
                        <button class='form-control btn-outline-success'
                                style='display: flex;background-color: #601c7e;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;'>
                            Operasyonlar<img src='<?= $Link ?>assets/img/ConteinerLink/operasyonlar.svg'></button>
                    </a></div>
                <div class='col-md-2 mb-3'><a href='<?= $Link ?>SatinAlma/FiyatTeklifleri.php'>
                        <button class='form-control btn-outline-success'
                                style='display: flex;background-color: #12956e;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;align-content: center;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;'>
                            Fiyat Teklifleri<img src='<?= $Link ?>assets/img/ConteinerLink/fiyatteklifleri.svg'>
                        </button>
                    </a></div>

                <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>SatinAlma/CalisilanFirmalar.php'>
                        <button class='form-control btn-outline-success'
                                style='background-color: #0063a3;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;display: flex;flex-direction: column-reverse;flex-wrap: wrap;align-content: center;justify-content: center;align-items: center;'>
                            Çalışılan Firmalar <img src='<?= $Link ?>assets/img/ConteinerLink/companies.svg'></button>
                    </a></div>
                <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>SatinAlma/GelenSiparisListesi.php'>
                        <button class='form-control btn-outline-success'
                                style='display: flex;background-color: #434e64;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;'>
                            Gelen Siparis Listesi<img
                                    src='<?= $Link ?>assets/img/ConteinerLink/gelensiparislistesi.svg'></button>
                    </a></div>
                <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>SatinAlma/BekleyenSiparisler.php'>
                        <button class='form-control btn-outline-success'
                                style='display: flex;background-color: #2a3756;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;'>
                            Bekleyen Siparişler<img src='<?= $Link ?>assets/img/ConteinerLink/bekleyensiparisler.svg'>
                        </button>
                    </a></div>
                <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>SatinAlma/VerilenSiparisler.php'>
                        <button class='form-control btn-outline-success'
                                style='display: flex;background-color: #2a62bf;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;'>
                            Verilen Siparişler<img src='<?= $Link ?>assets/img/ConteinerLink/verilensiparisler.svg'>
                        </button>
                    </a></div>
            </div>
        </section>
    </main>
    <script>
        $(function () {
            $(".SatinAlma").removeClass("collapsed");
            $("#SatinAlma").addClass("show");
        });
    </script>
<?php
require __DIR__ . '/../controller/Footer.php';
?>