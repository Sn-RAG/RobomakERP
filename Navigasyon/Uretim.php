<?php
$page = "Uretim";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . "/../controller/Link.php";
?>
<main id="main" class="main">
    <section class='section'>
        <div class="row">
            <h5>&nbsp</h5>
            <div class='col-md-2 me-3 mb-3'><a href='<?= $Link ?>Uretim/Setler.php'>
                    <button class='form-control btn-outline-success' style='background-color: #0010a3;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;display: flex;flex-direction: column-reverse;flex-wrap: wrap;align-content: center;justify-content: center;align-items: center;'>
                        Devam eden <img src='<?= $Link ?>assets/img/ConteinerLink/sets.svg'></button>
                </a></div>
            <div class='col-md-2' style='margin-right: 15px;'><a href='<?= $Link ?>Uretim/Urun/Urunler.php'>
                    <button class='form-control btn-outline-success' style='display: flex;background-color: #1f0946;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;'>
                        Ürünler <img src='<?= $Link ?>assets/img/ConteinerLink/products.svg'></button>
                </a></div>
        </div>
    </section>
</main>
<script>
    $(function() {
        $(".Uretim").removeClass("collapsed");
        $("#Uretim").addClass("show");
    });
</script>
<?php
require __DIR__ . '/../controller/Footer.php';
?>