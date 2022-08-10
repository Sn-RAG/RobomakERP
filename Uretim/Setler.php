<?php
$page = "Devam eden";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Sil.php';
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $page ?></h5>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <a href="SetlerKayit.php<?= isset($_GET["Sec"]) ? '?Sec=true' : "" ?>" class="btn btn-primary me-3 bi-save">&nbsp Yeni Set</a>
                        <!--<a href="UrunTasarla/UrunTasarla.php<?= isset($_GET["Sec"]) ? '?Sec=true' : "" ?>" class="btn btn-primary bi-hammer">&nbsp Ürün Tasarla</a>-->
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
                            <th><?= isset($_GET["Sec"]) ? "" : "Set" ?></th>
                            <th><?= isset($_GET["Sec"]) ? "Set" : "Durum" ?></th>
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
                            @$Yukleme = $SetYuzde == 100 ? "Yükleme Bekliyor" : $SetYuzde . "%";
                            @$Yuzde = $SetYuzde <= 5 ? 5 : $SetYuzde;

                        ?>
                            <tr>
                                <td><?= $id ?></td>
                                <td><?= $SetID ?></td>
                                <td><a href="SetKontrol/SetKontrol.php?SetAdi=<?= $SetAdi ?>&Set_ID=<?= $SetID ?>" class="btn btn-light form-control mt-1 fw-bold"><?= $SetAdi ?></a></td>
                                <td>
                                    <div class="progress mt-2" style="height: 25px;">
                                        <div class="progress-bar" role="progressbar" style="width: <?= $Yuzde ?>%"><?= $Yukleme ?></div>
                                    </div>
                                </td>
                                <td class="text-center"><a href='Setler.php?UretimSetlerSil=<?= $id ?>&Set_ID=<?= $SetID ?>' class='bi-trash btn btn-danger'></a></td>
                            </tr>
                        <?php } ?>
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
</script>
<?php
ob_end_flush();
require __DIR__ . '/../controller/Footer.php';
?>