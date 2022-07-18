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
<style>
    .progress-bar {
        height: 25px;
    }

    .chat {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .panel-body {
        overflow-y: scroll;
        height: 400px;
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

<input id="SetID" type="hidden" value="<?= $SetID ?>">

<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div><a href="../Setler.php" class="bi-arrow-left btn btn-secondary"> &nbsp&nbsp Geri Dön</a></div>
                <h5 class='card-title text-center fs-5'><?= $_SESSION["SetAdi"] ?></h5>
                <div>
                    <button class="btn btn-primary dropdown-toggle" type="button" data-bs-toggle="dropdown"> Üretim Formları</button>
                    <ul class="dropdown-menu">
                        <li><a class="hover dropdown-item border-bottom" href="PresFormu.php?id=<?= $SetID ?>" target="_blank" rel="noreferrer noopener">Pres Formu</a></li>
                        <!--<li><a class="hover dropdown-item" href="BoyaFormu.php" target="_blank" rel="noreferrer noopener">Boya Formu</a></li>-->
                    </ul>
                </div>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-12">
                    <!-- Akordiyon -->
                    <div class="accordion accordion-flush" id="accordionExample">
                        <div class="accordion-item row mb-1">
                            <label class="col-md-2 fw-bold">Levha Tedarik</label>
                            <h2 class="col-md-10" type="button" data-bs-toggle="collapse" data-bs-target="#Levha">
                                <div class="progress-bar" style="font-size: 15px;width: <?= $Hesap <= 5 ? 5 : $Hesap ?>%;background: linear-gradient(to left, #009341 -112%, #3921ff 110%);"><?= $Hesap ?>%</div>
                            </h2>
                            <div id="Levha" class="accordion-collapse collapse">
                                <div class="accordion-body text-center">
                                    <label class="fw-bold">Stok KG</label>
                                    <canvas id="ChartLevha" style="max-height: 400px; display: block; box-sizing: border-box; height: 400px; width: 491px;" width="491" height="400"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item row mb-1">
                            <label class="col-md-2 fw-bold">Pres Aşaması</label>
                            <h2 class="col-md-10" type="button" data-bs-toggle="collapse" data-bs-target="#Prs">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Prs <= 5 ? 5 : $Prs ?>%;background: linear-gradient(to left, #004576 0%, #28047b 100%);font-size: 15px;"><?= $Prs ?>%</div>
                            </h2>
                            <div id="Prs" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <canvas id="ChartPres" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item row mb-1">
                            <label class="col-md-2 fw-bold">Yıkama Aşaması</label>
                            <h2 class="col-md-10" type="button" data-bs-toggle="collapse" data-bs-target="#Yika">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Yika <= 5 ? 5 : $Yika ?>%;background: linear-gradient(to left, #24e70c 0%, #2e9d00 100%);color: #ffffff;font-size: 15px;"><?= $Yika ?>%</div>
                            </h2>
                            <div id="Yika" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <canvas id="ChartYika" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item row mb-1">
                            <label class="col-md-2 fw-bold">Kumlama Aşaması</label>
                            <h2 class="col-md-10" type="button" data-bs-toggle="collapse" data-bs-target="#Kum">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Kumla <= 5 ? 5 : $Kumla ?>%;background: linear-gradient(to left, #b5861d 0%, #ff3a30 100%);font-size: 15px;"><?= $Kumla ?>%</div>
                            </h2>
                            <div id="Kum" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <canvas id="ChartKumla" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item row">
                            <label class="col-md-2 fw-bold">Telleme Aşaması</label>
                            <h2 class="col-md-10" type="button" data-bs-toggle="collapse" data-bs-target="#Tel">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Telle <= 5 ? 5 : $Telle ?>%;background: linear-gradient(to left, #0059ff 0%, #af7297 100%);font-size: 15px;"><?= $Telle ?>%</div>
                            </h2>
                            <div id="Tel" class="accordion-collapse collapse">
                                <div class="accordion-body">

                                    <canvas id="ChartTelle" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>

                                </div>
                            </div>
                        </div>

                        <div class="accordion-item row">
                            <label class="col-md-2 fw-bold">Boyama Aşaması</label>
                            <h2 class="col-md-10" type="button" data-bs-toggle="collapse" data-bs-target="#Boya">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Boya <= 5 ? 5 : $Boya ?>%;background: linear-gradient(to left, #9a11c7 0%, #7b27b0 100%);font-size: 15px;"><?= $Boya ?>%</div>
                            </h2>
                            <div id="Boya" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <canvas id="ChartBoya" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item row">
                            <label class="col-md-2 fw-bold">Paketleme Aşaması</label>
                            <h2 class="col-md-10" type="button" data-bs-toggle="collapse" data-bs-target="#Paket">
                                <div class="progress-bar" role="progressbar" style="width: <?= $Paket <= 5 ? 5 : $Paket ?>%;background: linear-gradient(to left, #24e70c 0%, #2e9d00 100%);color: #ffffff;font-size: 15px;"><?= $Paket ?>%</div>
                            </h2>
                            <div id="Paket" class="accordion-collapse collapse">
                                <div class="accordion-body">
                                    <canvas id="ChartPaket" style="max-height: 400px; display: block; box-sizing: border-box; height: 245px; width: 491px;" width="491" height="245"></canvas>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Akordiyon SON -->
                </div>
                <hr>
                <!-- Scroll Bar -->
                <div class="col-md-6">
                    <h5> &nbsp Detaylar</h5>
                    <div class="panel-body border-top border-start isDurum">
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

                    <table class="table table-sm table-bordered datatablem">
                        <thead>
                            <tr class="table-light">
                                <th>Ürünler</th>
                                <th>İmalat</th>
                                <th>
                                    <div class="form-floating"><input type="date" class="form-control Tarih" value="<?= $tarih ?>"><label>Tarih</label></div>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $Listele = $baglanti->query('SELECT Kategori_ID,Urun_ID,UrunAdi,KulpAdi,Model_Adi,TepeAdi,icBoya_ID,Levha_ID FROM view_set_urun_sec WHERE Set_ID = ' . $SetID . " GROUP BY Urun_ID")->fetchAll();
                            foreach ($sor as $s) {
                                $Uid = $s['Urun_ID'];
                            ?>
                                <tr>
                                    <td><?= $s['UrunAdi'] ?></td>
                                    <td class="text-center" id="yazsayi<?= $Uid ?>"></td>
                                    <td>
                                        <div class="input-group input-group-sm" id="hata<?= $Uid ?>"><input type="number" id="deger<?= $Uid ?>" SetID="<?= $SetID ?>" UrunID="<?= $Uid ?>" LevhaID="<?= $s['Levha_ID'] ?>" class="GDeger form-control form-control me-1"><button class="gir btn btn-primary bi-check me-1"></button><button class="fire btn btn-warning bi-dash"></button></div>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <table class="table table-sm table-bordered datatablem">
                        <thead>
                            <tr class="table-light">
                                <th>Ürünler</th>
                                <th>Kulp</th>
                                <th>Kapak</th>
                                <th>Tepe</th>
                                <th>Çap</th>
                                <th>Kalınlık</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $Urunler = [];
                            $UrunAdi = [];
                            $i = 0;
                            foreach ($Listele as $s) {
                                $Uid = $s['Urun_ID'];
                                $ad = $s['UrunAdi'];
                                $Urunler[$i] = $Uid;
                                $UrunAdi[$i] = $ad;
                                $i++;
                            ?>
                                <tr>
                                    <td><?= $ad ?></td>
                                    <td><?= $s['KulpAdi'] ?></td>
                                    <td><?= $s['Model_Adi'] ?></td>
                                    <td><?= $s['TepeAdi'] ?></td>
                                    <td><?= $baglanti->query("SELECT Cap FROM view_urun_levha_bilgi WHERE Levha_ID=" . $s['Levha_ID'] . " AND Urun_ID=" . $Uid)->fetch()["Cap"] ?> cm</td>
                                    <td><?= $baglanti->query("SELECT Kalinlik FROM view_urun_levha_bilgi WHERE Levha_ID=" . $s['Levha_ID'] . " AND Urun_ID=" . $Uid)->fetch()["Kalinlik"] ?> mm</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>&nbsp</th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th></th>
                                <th class="table-secondary">İç Boya</th>
                                <th class="table-secondary">Dış Boya</th>
                                <th class="table-secondary">Adet</th>
                                <th></th>
                                <th></th>
                            </tr>
                            <tr>
                                <td></td>
                                <td class="table-secondary"><?php
                                                            $sor = $baglanti->query('SELECT Renk FROM set_urun_icerik INNER JOIN boya ON set_urun_icerik.icBoya = boya.Boya_ID WHERE Set_ID =' . $SetID);
                                                            foreach ($sor as $s) {
                                                                echo $s['Renk'] . "<br>";
                                                            }
                                                            ?>
                                </td>
                                <td class="table-secondary"><?php
                                                            $sor = $baglanti->query('SELECT Renk FROM set_urun_icerik INNER JOIN boya ON set_urun_icerik.DisBoya = boya.Boya_ID WHERE Set_ID =' . $SetID);
                                                            foreach ($sor as $s) {
                                                                echo  $s['Renk'] . "<br>";
                                                            }
                                                            ?>
                                </td>
                                <td class="table-secondary"><?php
                                                            $sor = $baglanti->query('SELECT Adet FROM set_urun_icerik WHERE Set_ID =' . $SetID);
                                                            foreach ($sor as $s) {
                                                                echo  "<input class='Tadet' type='hidden' value='$s[Adet]'>" . $s['Adet'] . "<br>";
                                                            }
                                                            ?>
                                </td>
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