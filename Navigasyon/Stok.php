<?php
$page = "Stok";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . "/../controller/Link.php";
?>
<main id="main" class="main">
    <section class='section'>
        <div class="row">
            <h5>&nbsp</h5>
            <div class='col-md-2'>
                <a href='<?= $Link ?>Boyalar/BoyaStok.php'>
                    <button class='form-control btn-outline-success' style='border-color: #ffffff00;background-color: #6d0ccd;color: azure;border: 0 solid #ffffff00;display: flex;height: 124px;margin-right: 15px; justify-content: center;align-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: stretch;'>
                        <img src='<?= $Link ?>assets/img/ConteinerLink/BoyaStok.svg'> Boya Stok
                    </button>
                </a>
            </div>
    </section>
</main>
<script>
    $(function() {
        $(".Stok").removeClass("collapsed");
        $("#Stok").addClass("show");
    });
</script>
<?php
require __DIR__ . '/../controller/Footer.php';
?>