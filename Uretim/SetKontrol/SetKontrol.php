<?php
$page = "Set Kontrol";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
$_SESSION["SetAdi"] = $_GET['SetAdi'];
$SetID = $_GET['Set_ID'];
if ($baglanti->query("SELECT  Set_ID FROM set_urunler_asama WHERE Set_ID = " . $SetID)->rowCount() <= 0) {
    $baglanti->query("INSERT INTO set_urunler_asama ( Set_ID, Urun_ID ) SELECT Set_ID,Urun_ID FROM view_uretim_setler WHERE Set_ID =  " . $SetID);
}
require __DIR__ . '/Yuzde.php';
?>
<input id="SetID" type="hidden" value="<?= $SetID ?>">
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex">
                <div class="col-md-2"><a href="../Setler.php" class="bi-arrow-left btn btn-secondary"> &nbsp&nbsp Geri Dön</a></div>
                <h5 class='card-title text-center col-md-8 fs-5'><?= $_SESSION["SetAdi"] ?></h5>
            </div>
            <div class="card-body">
                <div class="row mb-3 g-3">

                    <div class="col-md-6">

                        <div style="margin-top: -1px;padding-top: 22px;">
                            <label style="font-weight: 600;">Levha Tedarik</label>
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="font-size: 15px;width: <?= $Hesap ?>%;background: linear-gradient(to left, #009341 -112%, #3921ff 110%);"><?= $Hesap ?>%
                                </div>
                            </div>
                        </div>

                        <div>
                            <label style="font-weight: 600;">Pres Aşaması</label>
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Prs ?>%;background: linear-gradient(to left, #004576 0%, #28047b 100%);font-size: 15px;"><?= $Prs ?>%
                                </div>
                            </div>
                        </div>

                        <div>
                            <label style="font-weight: 600;">Yıkama Aşaması</label>
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Yika ?>%;background: linear-gradient(to left, #24e70c 0%, #2e9d00 100%);color: #ffffff;font-size: 15px;"><?= $Yika ?>%
                                </div>
                            </div>
                        </div>

                        <div>
                            <label style="font-weight: 600;">Kumlama Aşaması</label>
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Kumla ?>%;background: linear-gradient(to left, #b5861d 0%, #ff3a30 100%);font-size: 15px;"><?= $Kumla ?>%
                                </div>
                            </div>
                        </div>

                        <div>
                            <label style="font-weight: 600;">Telleme Aşaması</label>
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Telle ?>%;background: linear-gradient(to left, #0059ff 0%, #af7297 100%);font-size: 15px;"><?= $Telle ?>%
                                </div>
                            </div>
                        </div>

                        <div>
                            <label style="font-weight: 600;">Boyama Aşaması</label>
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Boya ?>%;background: linear-gradient(to left, #9a11c7 0%, #7b27b0 100%);font-size: 15px;"><?= $Boya ?>%
                                </div>
                            </div>
                        </div>

                        <div>
                            <label style="font-weight: 600;">Paketleme Aşaması</label>
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Paket ?>%;background: linear-gradient(to left, #24e70c 0%, #2e9d00 100%);color: #ffffff;font-size: 15px;"><?= $Paket ?>%
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <h5 class="mb-5"></h5>
                        <table class="table table-bordered datatablem">
                            <thead>
                                <tr class="table-light">
                                    <th>Ürünler</th>
                                    <th>Kulp</th>
                                    <th>Kapak</th>
                                    <th>Tepe</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sor = $baglanti->query('SELECT Kategori_ID,UrunAdi,KulpAdi,Model_Adi,TepeAdi,icBoya_ID FROM view_set_urun_sec WHERE Set_ID = ' . $SetID . " ORDER BY Kategori_ID ASC");
                                foreach ($sor as $s) { ?>
                                    <tr>
                                        <td><?= $s['UrunAdi'] ?></td>
                                        <td><?= $s['KulpAdi'] ?></td>
                                        <td><?= $s['Model_Adi'] ?></td>
                                        <td><?= $s['TepeAdi'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th class="table-primary">İç Boya</th>
                                    <th class="table-success">Dış Boya</th>
                                    <th class="table-warning">Adet</th>
                                    <th></th>
                                </tr>
                                <tr>
                                    <td><?php
                                        $sor = $baglanti->query('SELECT Renk FROM set_urun_icerik INNER JOIN boya ON set_urun_icerik.icBoya = boya.Boya_ID WHERE Set_ID =' . $SetID);
                                        foreach ($sor as $s) {
                                            echo $s['Renk']."<br>";
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        $sor = $baglanti->query('SELECT Renk FROM set_urun_icerik INNER JOIN boya ON set_urun_icerik.DisBoya = boya.Boya_ID WHERE Set_ID =' . $SetID);
                                        foreach ($sor as $s) {
                                            echo  $s['Renk']."<br>";
                                        }
                                        ?>
                                    </td>
                                    <td><?php
                                        $sor = $baglanti->query('SELECT Adet FROM set_urun_icerik WHERE Set_ID =' . $SetID);
                                        foreach ($sor as $s) {
                                            echo  $s['Adet']."<br>";
                                        }
                                        ?></td>
                                    <td></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                </div>
                <hr>
                <div class="row">

                    <!-- Scroll Bar -->
                    <style>
                        .chat {
                            list-style: none;
                            margin: 0;
                            padding: 0;
                        }

                        .panel-body {
                            overflow-y: scroll;
                            height: 350px;
                        }

                        ::-webkit-scrollbar-track {
                            background-color: #F5F5F5;
                        }

                        ::-webkit-scrollbar {
                            width: 12px;
                            background-color: #F5F5F5;
                        }

                        ::-webkit-scrollbar-thumb {
                            background-color: #555;
                        }
                    </style>
                    <div class="col-md-6 mb-3">
                        <h5> &nbsp Detaylar</h5>
                        <div class="panel-body border">
                            <ul class="chat m-2">
                                <li class="isDurum"></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Scroll Bar SON -->

                    <div class="col-md-6">
                        <div class="input-group-sm">
                            <button class="mb-3 me-2 btn btn-primary t" id="Pres">Pres</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="Yikama">Yıkama</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="Kumlama">Kumlama</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="Telleme">Telleme</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="icBoyama">İç Boya</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="DisBoyama">Dış Boya</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="Paketleme">Paketleme</button>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end mb-3">
                            <label class="col-sm-2 col-form-label">Tarih</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control Tarih" value="<?php date_default_timezone_set('Europe/Istanbul');
                                                                                        $tarih = new DateTime("now");
                                                                                        $tarih = date("Y-m-d");
                                                                                        echo $tarih; ?>">
                            </div>
                        </div>
                        <ul class="list-group">
                            <?php
                            $Urunler = [];
                            $i = 0;
                            $sorgu = $baglanti->query('SELECT urun.Urun_ID AS UrunID, UrunAdi, icBoyanan, DisBoyanan, Preslenen, Tellenen, Kumlanan, Paketlenen,Yikanan FROM set_urunler_asama INNER JOIN urun ON set_urunler_asama.Urun_ID = urun.Urun_ID WHERE Set_ID = ' . $SetID);
                            foreach ($sorgu as $s) {
                                $i++;
                                $Uid = $s["UrunID"];
                                $Urunler[$i] = $Uid;
                            ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div id="hata">
                                        <input type="number" id="deger<?= $Uid ?>" class="form-control-sm me-1 mb-2 temizle">
                                        <button class="gir btn btn-sm bi-check-lg btn-primary" Urun_ID="<?= $Uid ?>" Set_ID="<?= $SetID ?>"></button>
                                        <button class="fire btn btn-sm bi-dash-lg btn-warning" Urun_ID="<?= $Uid ?>" Set_ID="<?= $SetID ?>"></button>
                                    </div>
                                    <?= $s["UrunAdi"] ?>
                                    <span class="badge bg-light text-black fs-6 yazsayi<?= $Uid ?>"></span>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="UrunYaz"></div>
<script>
    $('.datatablem').DataTable({
        responsive: true,
        order: false,
        columnDefs: [{
            targets: '_all',
            orderable: false
        }],
        paging: false,
        bFilter: false,
        bInfo: false
    });
</script>
<?php
require __DIR__ . '/AjaxForm/Ajax.php';
?>
<script src="../../assets/vendor/bootstrap/js/bootstrap.min.js"></script>