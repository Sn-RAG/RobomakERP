<?php
$page = "Devam eden";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Sil.php';
if (isset($_SESSION["Set_ID"])) {
    unset($_SESSION["Set_ID"], $_SESSION["SetAdi"], $_SESSION["UrunIDler"], $_SESSION["KulpSec"], $_SESSION["mmSec"], $_SESSION["KapakSec"], $_SESSION["KutuSec"], $_SESSION["TepeSec"]);
}
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $page ?></h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <a href="SetlerKayit.php<?= isset($_GET["Sec"]) ? '?Sec=true' : "" ?>" class="btn btn-info me-3 bi-bricks">&nbsp Yeni Set</a>
                        <a href="UrunTasarla/UrunTasarla.php<?= isset($_GET["Sec"]) ? '?Sec=true' : "" ?>" class="btn btn-primary bi-hammer">&nbsp Ürün Tasarla</a>
                    </div>
                    <div class="col-md-6 justify-content-end d-flex">
                        <button type="button" class="btn btn-success bi-check2 col-md-3 Sec" <?= isset($_GET["Sec"]) ? "" : "hidden" ?>>&nbsp Tamam</button>
                    </div>
                </div>
                <hr>
                <table class="table datatablem">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Set ID</th>
                            <th>Set</th>
                            <th><?= isset($_GET["Sec"]) ? "Adet" : "Durum" ?></th>
                            <th>&nbsp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sorgu = $baglanti->query('SELECT Set_ID, SetAdi, Set_icerik_ID FROM view_uretim_setler INNER JOIN set_icerik ON view_uretim_setler.Set_Urun_ID = set_icerik.Set_Urun_ID');
                        foreach ($sorgu as $sonuc) {
                            $id = $sonuc['Set_icerik_ID'];
                            $SetID = $sonuc['Set_ID'];
                            $SetAdi = $sonuc['SetAdi'];
                            require __DIR__ . '/SetKontrol/Yuzde.php';
                            @$SorYuzde = $SetYuzde == 100 ? "Yükleme Bekliyor" : $SetYuzde;
                        ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $SetID ?></td>
                                <?php if (isset($_GET["Sec"])) { ?>
                                    <td><?= $SetAdi ?></td>
                                    <td><input type="number" class="form-control Adet" placeholder="Adet"></td>
                                    <td>
                                        <div class='form-check'><input class='form-check-input' type='checkbox' id='Check<?= $id ?>' value='<?= $id ?>'><label class='form-check-label fw-bold' for='Check<?= $id ?>'>SEÇ</label></div>
                                    </td>
                                <?php } else { ?>
                                    <td><a href="SetKontrol/SetKontrol.php?SetAdi=<?= $SetAdi ?>&Set_ID=<?= $SetID ?>" class="btn btn-light form-control mt-1 fw-bold"><?= $SetAdi ?></a></td>
                                    <td>
                                        <div class="progress mt-2" style="height: 25px;">
                                            <div class="progress-bar" role="progressbar" style="width: <?= $SorYuzde <= 5 ? 5 : $SorYuzde ?>%"><?= $SorYuzde ?>%</div>
                                        </div>
                                    </td>
                                    <td class="text-center"><a href='Setler.php?UretimSetlerSil=<?= $id ?>&Set_ID=<?= $SetID ?>' class='bi-trash btn btn-danger'></a></td>
                            <?php }
                                echo "</tr>";
                            }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
<script>
    $('.datatablem').DataTable({
        responsive: true,
        columnDefs: [{
                visible: false,
                targets: [0, 1]
            },
            {
                targets: 4,
                orderable: false
            },
            {
                "width": "50%",
                "targets": 2
            },
            {
                "width": "10%",
                "targets": 4
            }
        ],
        pageLength: 100,
        lengthMenu: [
            [25, 50, 100, -1],
            ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
        ],
    });

    //Seçilen Setleri array olarak sessiona post ediyoruz herşey bu sayfada

    $('.Sec').click(function() {
        var Setsec = [];
        $("input:checkbox:checked").map(function() {
            Setsec.push($(this).val());
        });
        var Adet = $(".Adet").map(function() {
            if ($(this).val() != "") {
                return $(this).val();
            }
        }).get();
        console.log(Setsec);
        console.log(Adet);
        $.ajax({
            type: "POST",
            url: "Setler.php",
            data: {
                'Setsec': Setsec,
                'Adet': Adet
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            },
            success: function() {
                window.location.assign("../Pazarlama/Teklifler/TeklifVer.php")
            }
        })
    });
</script>
<?php
ob_end_flush();
require __DIR__ . '/../controller/Footer.php';

if (isset($_POST["Setsec"])) {
    $_SESSION["Setler"] = $_POST["Setsec"];
    $_SESSION["Adetler"] = $_POST["Adet"];
}
?>