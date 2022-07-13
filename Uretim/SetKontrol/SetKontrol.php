<?php
$page = "Set Kontrol";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
$_SESSION["SetAdi"] = $_GET['SetAdi'];
$SetID = $_GET['Set_ID'];
if ($baglanti->query("SELECT  Set_ID FROM set_urunler_asama WHERE Set_ID = " . $SetID)->rowCount() <= 0) {
    $baglanti->query("INSERT INTO set_urunler_asama ( Set_ID, Urun_ID ) SELECT Set_ID,Urun_ID FROM view_uretim_setler WHERE Set_ID =  " . $SetID);
}
date_default_timezone_set('Europe/Istanbul');
$tarih = new DateTime("now");
$tarih = date("Y-m-d");
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
            <div class="card-body row">
                <div class="col-md-12">
                    <h1></h1>
                    <div class="row mb-3" onclick="Levha()">
                        <label class="col-md-2 fw-bold">Levha Tedarik</label>
                        <div class="col-md-10">
                        <div class="progress mt-1" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" style="font-size: 15px;width: <?= $Hesap ?>%;background: linear-gradient(to left, #009341 -112%, #3921ff 110%);"><?= $Hesap ?>%
                            </div>
                        </div>
                        </div>
                        <canvas hidden id="ChartLevha" style="max-height: 400px; display: block; box-sizing: border-box; height: 400px; width: 491px;" width="491" height="400"></canvas>
                        <code id="bosl" class="bos" hidden></code>
                    </div>

                    <div class="row mb-3" onclick="Press()">
                        <label class="col-md-2 fw-bold">Pres Aşaması</label>
                        <div class="col-md-10">
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Prs ?>%;background: linear-gradient(to left, #004576 0%, #28047b 100%);font-size: 15px;"><?= $Prs ?>%
                                </div>
                            </div>
                        </div>
                        <canvas hidden id="ChartPres" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                        <code id="bospr" class="bos" hidden></code>
                    </div>

                    <div class="row mb-3" onclick="Yika()">
                        <label class="col-md-2 fw-bold">Yıkama Aşaması</label>
                        <div class="col-md-10">
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Yika ?>%;background: linear-gradient(to left, #24e70c 0%, #2e9d00 100%);color: #ffffff;font-size: 15px;"><?= $Yika ?>%
                                </div>
                            </div>
                        </div>
                        <canvas hidden id="ChartYika" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                        <code id="bosy" class="bos" hidden></code>
                    </div>

                    <div class="row mb-3" onclick="Kumla()">
                        <label class="col-md-2 fw-bold">Kumlama Aşaması</label>
                        <div class="col-md-10">
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Kumla ?>%;background: linear-gradient(to left, #b5861d 0%, #ff3a30 100%);font-size: 15px;"><?= $Kumla ?>%
                                </div>
                            </div>
                        </div>
                        <canvas hidden id="ChartKumla" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                        <code id="bosk" class="bos" hidden></code>
                    </div>

                    <div class="row mb-3" onclick="Telle()">
                        <label class="col-md-2 fw-bold">Telleme Aşaması</label>
                        <div class="col-md-10">
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Telle ?>%;background: linear-gradient(to left, #0059ff 0%, #af7297 100%);font-size: 15px;"><?= $Telle ?>%
                                </div>
                            </div>
                        </div>
                        <canvas hidden id="ChartTelle" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                        <code id="bost" class="bos" hidden></code>
                    </div>

                    <div class="row mb-3" onclick="Boya()">
                        <label class="col-md-2 fw-bold">Boyama Aşaması</label>
                        <div class="col-md-10">
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Boya ?>%;background: linear-gradient(to left, #9a11c7 0%, #7b27b0 100%);font-size: 15px;"><?= $Boya ?>%
                                </div>
                            </div>
                        </div>
                        <canvas hidden id="ChartBoya" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                        <code id="bosb" class="bos" hidden></code>
                    </div>

                    <div class="row mb-3" onclick="Paket()">
                        <label class="col-md-2 fw-bold">Paketleme Aşaması</label>
                        <div class="col-md-10">
                            <div class="progress mt-1" style="height: 25px;">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Paket ?>%;background: linear-gradient(to left, #24e70c 0%, #2e9d00 100%);color: #ffffff;font-size: 15px;"><?= $Paket ?>%
                                </div>
                            </div>
                        </div>
                        <canvas hidden id="ChartPaket" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                        <code id="bosp" class="bos" hidden></code>
                    </div>
                    <h5></h5>
                </div>
                <hr>
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
                <div class="col-md-6">
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

                    <table class="table  table-bordered datatablem">
                        <thead>
                            <tr class="table-light">
                                <th>Ürünler</th>
                                <th>Kulp</th>
                                <th>Kapak</th>
                                <th>Tepe</th>
                                <th>İmalat</th>
                                <th>
                                    <div class="form-floating"><input type="date" class="form-control Tarih" value="<?= $tarih ?>"><label>Tarih</label></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $Urunler = [];
                            $UrunAdi = [];
                            $i = 0;
                            $sor = $baglanti->query('SELECT Kategori_ID,Urun_ID,UrunAdi,KulpAdi,Model_Adi,TepeAdi,icBoya_ID FROM view_set_urun_sec WHERE Set_ID = ' . $SetID . " GROUP BY Urun_ID ORDER BY Kategori_ID ASC");
                            foreach ($sor as $s) {
                                $Uid = $s['Urun_ID'];
                                $ad = $s['UrunAdi'];
                                $i++;
                                $Urunler[$i] = $Uid;
                                $UrunAdi[$i] = $ad;
                            ?>
                                <tr>
                                    <td><?= $ad ?></td>
                                    <td><?= $s['KulpAdi'] ?></td>
                                    <td><?= $s['Model_Adi'] ?></td>
                                    <td><?= $s['TepeAdi'] ?></td>
                                    <td class="fw-bold fs-6 yazsayi<?= $Uid ?>"></td>
                                    <td>
                                        <div class="btn-group input-group-sm"><input id="deger<?= $Uid ?>" class="temizle form-control me-1"><button class="gir btn btn-primary bi-check me-1" Urun_ID="<?= $Uid ?>" Set_ID="<?= $SetID ?>"></button><button class="fire btn btn-warning bi-dash" Urun_ID="<?= $Uid ?>" Set_ID="<?= $SetID ?>"></button></div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr class="table-primary">
                                <th>İç Boya</th>
                                <th>Dış Boya</th>
                                <th>Adet</th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td><?php
                                    $sor = $baglanti->query('SELECT Renk FROM set_urun_icerik INNER JOIN boya ON set_urun_icerik.icBoya = boya.Boya_ID WHERE Set_ID =' . $SetID);
                                    foreach ($sor as $s) {
                                        echo $s['Renk'] . "<br>";
                                    }
                                    ?>
                                </td>
                                <td><?php
                                    $sor = $baglanti->query('SELECT Renk FROM set_urun_icerik INNER JOIN boya ON set_urun_icerik.DisBoya = boya.Boya_ID WHERE Set_ID =' . $SetID);
                                    foreach ($sor as $s) {
                                        echo  $s['Renk'] . "<br>";
                                    }
                                    ?>
                                </td>
                                <td><?php
                                    $sor = $baglanti->query('SELECT Adet FROM set_urun_icerik WHERE Set_ID =' . $SetID);
                                    foreach ($sor as $s) {
                                        echo  "<input class='Tadet' type='hidden' value='$s[Adet]'>" . $s['Adet'] . "<br>";
                                    }
                                    ?></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>
    </section>
</main>
<div class="UrunYaz"></div>
<?php
require __DIR__ . '/../../controller/Footer.php';
require __DIR__ . '/AjaxForm/Ajax.php';
?>