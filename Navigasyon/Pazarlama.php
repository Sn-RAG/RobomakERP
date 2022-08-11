<?php
$page = "Pazarlama";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . "/../controller/Link.php";
?>
<main id="main" class="main">
    <section class='section'>
        <div class="row">
            <h5>&nbsp</h5>
            <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>Pazarlama/TeklifHazirla/Hazir.php'>
                    <button class='form-control btn-outline-success' style='border: 0 solid #ffffff00;display: flex;background-color: #123b74;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px; justify-content: center;align-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: stretch;'>
                        Teklif Hazırla <img src='<?= $Link ?>assets/img/ConteinerLink/sell.svg'></button>
                </a></div>
            <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>Pazarlama/MaaliyetDuzenle.php'>
                    <button class='form-control btn-outline-success' style='background-color: #122b48;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;display: flex;flex-direction: column-reverse;flex-wrap: wrap;align-content: center;justify-content: center;align-items: center;'>
                        Maaliyet Düzenle <img src='<?= $Link ?>assets/img/ConteinerLink/maaliyetduzenle.svg'>
                    </button>
                </a></div>
            <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>Pazarlama/OnayGonder.php'>
                    <button class='form-control btn-outline-success' style='display: flex;background-color: #e31d58;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;align-content: center;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;'>
                        Onay İçin Gönder<img src='<?= $Link ?>assets/img/ConteinerLink/onayicin.svg'></button>
                </a></div>
            <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>Pazarlama/KonteynirHesapla.php'>
                    <button class='form-control btn-outline-success' style='display: flex;background-color: #8d1313;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;'>
                        Konteyner Hesapla<img src='<?= $Link ?>assets/img/ConteinerLink/container.svg'></button>
                </a></div>
            <div class='col-md-2 me-3 mb-3'>
                <a href='<?= $Link ?>Pazarlama/TeklifHazirla.php'>
                    <button class='form-control btn-outline-success' style='background-color: #454b62;color: #ffffff;border-color: #ffffff00;height: 62px;margin-right: 15px;display: flex;flex-direction: row;flex-wrap: nowrap;align-content: center;align-items: center;justify-content: center;'>
                        Teklif Hazırla <img src='<?= $Link ?>assets/img/ConteinerLink/editoffer.svg'></button>
                </a>
                <a href='<?= $Link ?>Pazarlama/TeklifHazirla/Hazir.php?Teklif&h' style='color: #f9f9fd;'>
                    <button class='form-control btn-outline-success' style='background-color: #14b5ed;color: white;border-color: #ffffff00;height: 62px;margin-right: 15px;display: flex;flex-wrap: wrap;flex-direction: row;align-content: center;justify-content: space-around;align-items: center;'>
                        Teklifler <img src='<?= $Link ?>assets/img/ConteinerLink/offer.svg'></button>
                </a>
            </div>
        </div>
    </section>
</main>
<script>
    $(function() {
        $(".Pazarlama").removeClass("collapsed");
        $("#Pazarlama").addClass("show");
    });
</script>
<?php
require __DIR__ . '/../controller/Footer.php';
?>