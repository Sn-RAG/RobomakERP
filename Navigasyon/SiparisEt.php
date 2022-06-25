<?php
$page = "Sipariş Et";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . "/../controller/Link.php";
?>
    <main id="main" class="main">
        <section class='section'>
            <div class='row py-3'>

                <!-- Sipariş Et -->

                <div class="col-md-12 row mb-3 g-3">

                    <div class='col-md-2'>
                        <a href='<?= $Link ?>SatinAlma/Siparis/BoyaSiparis.php' class="form-control btn-outline-success " style="border-color: #;background-color: #5d7088;color: azure;border: 0 solid #ffffff00;display: flex;height: 124px;margin-right: 15px; justify-content: center;align-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: stretch;">Boya Sipariş<img src="<?= $Link ?>assets/img/ConteinerLink/boyasiparis.svg" style="
      width: 35px;
  "></a>
                    </div>

                    <div class='col-md-2'>
                        <a href='<?= $Link ?>SatinAlma/Siparis/LevhaSiparis.php' class="form-control btn-outline-success " style="border-color: #;background-color: #5d7088;color: azure;border: 0 solid #ffffff00;display: flex;height: 124px;margin-right: 15px; justify-content: center;align-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: stretch;"> Levha Sipariş<img src="<?= $Link ?>assets/img/ConteinerLink/levhasiparis.svg" style="
                                      width: 35px;
                                  "></a>
                    </div>

                    <div class='col-md-2'>
                        <a href='<?= $Link ?>SatinAlma/Siparis/BoyaSiparisleri.php' class="form-control btn-outline-success " style="border-color: #;background-color: #0042e3;color: azure;border: 0 solid #ffffff00;display: flex;height: 124px;margin-right: 15px; justify-content: center;align-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: stretch;">Boya Sipariş Takibi<img src="<?= $Link ?>assets/img/ConteinerLink/boyasiparisleri.svg" style="
                                      width: 35px;
                                  "></a>
                    </div>

                    <div class='col-md-2'>
                        <a href='<?= $Link ?>SatinAlma/Siparis/LevhaSiparisleri.php' class="form-control btn-outline-success " style="border-color: #;background-color: #20008f;color: azure;border: 0 solid #ffffff00;display: flex;height: 124px;margin-right: 15px; justify-content: center;align-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: stretch;">Levha Sipariş Takibi <img src="<?= $Link ?>assets/img/ConteinerLink/levhasiparisleri.svg" style="
                                      width: 35px;
                                  "></a>
                    </div>

                </div>
                <!-- Sipariş Listele SON -->
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