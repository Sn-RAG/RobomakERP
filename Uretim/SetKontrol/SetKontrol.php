<?php
$page = "Set Kontrol";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
@$SetAdi = $_GET['SetAdi'];
@$SetID = (int)$_GET['Set_ID'];
if ($baglanti->query("SELECT  Set_ID FROM set_urunler_asama WHERE Set_ID = " . $SetID)->rowCount() < 1) {
    $baglanti->query("INSERT INTO set_urunler_asama ( Set_ID, Urun_ID ) SELECT Set_ID,Urun_ID FROM view_uretim_setler WHERE Set_ID = $SetID ORDER BY Urun_ID");
}
date_default_timezone_set('Europe/Istanbul');
$tarih = new DateTime("now");
$tarih = date("Y-m-d");
require __DIR__ . '/Yuzde.php';
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div><a href="../Setler.php" class="bi-arrow-left btn btn-secondary"> &nbsp&nbsp Geri Dön</a></div>
                <h5 class='card-title text-center fs-5'><?= $SetAdi ?></h5>
                <div>
                    <div class="btn-group btn-group-sm">
                        <a class="btn btn-outline-dark" href="FormHesapBoya.php?id=<?= $SetID ?>&adi=<?= $SetAdi ?>" target="_blank" rel="noreferrer noopener">Boya Hesapla</a>
                        <a class="btn btn-outline-dark" href="FormHesapLevha.php?id=<?= $SetID ?>&adi=<?= $SetAdi ?>" target="_blank" rel="noreferrer noopener">Levha Hesapla</a>
                        <a class="btn btn-outline-dark" href="FormPres.php?id=<?= $SetID ?>&adi=<?= $SetAdi ?>" target="_blank" rel="noreferrer noopener">Preshane Formu</a>
                        <a class="btn btn-outline-dark" href="FormBoya.php?id=<?= $SetID ?>&adi=<?= $SetAdi ?>" target="_blank" rel="noreferrer noopener">Boyahane Formu</a>
                    </div>
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
                <!-- Scroll Tablo -->
                <div class="col-md-6 mb-3">
                    <h5> &nbsp Detaylar</h5>
                    <div class="border isDurum">
                    </div>
                </div>
                <!-- Scroll Tablo SON -->

                <div class="col-md-6 mb-3">
                    <div class="input-group-sm col-md-12">
                        <button class="mb-3 me-2 btn btn-primary t" id="Pres">Pres</button>
                        <button class="mb-3 me-2 btn btn-outline-dark t" id="Yikama">Yıkama</button>
                        <button class="mb-3 me-2 btn btn-outline-dark t" id="Kumlama">Kumlama</button>
                        <button class="mb-3 me-2 btn btn-outline-dark t" id="Telleme">Telleme</button>
                        <button class="mb-3 me-2 btn btn-outline-dark t" id="icBoyama">İç Boya</button>
                        <button class="mb-3 me-2 btn btn-outline-dark t" id="DisBoyama">Dış Boya</button>
                        <button class="mb-3 me-2 btn btn-outline-dark t" id="Paketleme">Paketleme</button>
                    </div>
                    <div class="col-md-12">
                        <div class="input-group input-group-sm d-flex justify-content-end">

                            <select class="form-select bg-light me-2 icRenk">
                                <option value="">* İç Renk Seçin</option>
                                <?php
                                $RS = $baglanti->query('SELECT DISTINCT icBoya_ID FROM view_set_urun_sec WHERE Set_ID = ' . $SetID);
                                foreach ($RS as $k) {
                                    $ir = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $k["icBoya_ID"])->fetch()["Renk"];
                                    echo "<option value='$k[icBoya_ID]'>$ir</option>";
                                }
                                ?>
                            </select>

                            <select class="form-select bg-light me-2 DisRenk">
                                <option value="">* Dış Renk Seçin</option>
                                <?php
                                $RS = $baglanti->query('SELECT DISTINCT DisBoya_ID,DisRenk,DisMarka FROM view_set_urun_sec WHERE Set_ID = ' . $SetID);
                                foreach ($RS as $k) {
                                    echo "<option value='$k[DisBoya_ID]'>$k[DisRenk]</option>";
                                }
                                ?>
                            </select>

                            <label class="col-form-label me-2">Tarih</label>
                            <div class="me-1"><input type="date" class="form-control Tarih" value="<?= $tarih ?>"></div>
                            <button class="gir btn btn-primary bi-check me-1"></button>
                            <button class="fire btn btn-warning bi-dash"></button>
                        </div>
                    </div>
                    <table class="table table-sm table-bordered datatablem">
                        <thead>
                            <tr class="table-light">
                                <th>Ürünler</th>
                                <th>İmalat</th>
                                <th>&nbsp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $Urunler = [];
                            $UrunAdi = [];
                            $i = 0;
                            $sor = $baglanti->query('SELECT Kategori_ID,Urun_ID,UrunAdi,KulpAdi,Model_Adi,TepeAdi,icBoya_ID,DisBoya_ID,DisRenk,DisMarka,Adet,Levha_ID FROM view_set_urun_sec WHERE Set_ID = ' . $SetID . " GROUP BY Urun_ID")->fetchAll();
                            foreach ($sor as $s) {
                                $Uid = $s['Urun_ID'];
                                $ad = $s['UrunAdi'];
                                $Urunler[$i] = $Uid;
                                $UrunAdi[$i] = $ad;
                                $i++;
                            ?>
                                <tr>
                                    <td><?= $ad ?></td>
                                    <td class="text-center" id="yazsayi<?= $Uid ?>"></td>
                                    <td>
                                        <input type="number" SetID="<?= $SetID ?>" UrunID="<?= $Uid ?>" LevhaID="<?= $s['Levha_ID'] ?>" iBoya="<?= $s['icBoya_ID'] ?>" dBoya="<?= $s['DisBoya_ID'] ?>" class="GDeger form-control form-control-sm me-1" placeholder="Adet">
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-12">
                    <h5 class="card-title text-center">SET DETAY</h5>
                    <table class="table table-sm small table-bordered table-responsive">
                        <tbody>
                            <tr class="table-light">
                                <th>Ürünler</th>
                                <th>Kulp</th>
                                <th>Kapak</th>
                                <th>Tepe</th>
                                <th>Çap</th>
                                <th>Kalınlık</th>
                            </tr>
                            <?php
                            foreach ($sor as $s) {
                                $Uid = $s['Urun_ID'];
                                $ad = $s['UrunAdi'];
                                $C = $baglanti->query("SELECT Cap FROM view_urun_levha_bilgi WHERE Levha_ID=" . $s['Levha_ID'] . " AND Urun_ID=" . $Uid);
                                if ($C->rowCount()) {
                            ?>
                                    <tr>
                                        <td><?= $ad ?></td>
                                        <td><?= $s['KulpAdi'] ?></td>
                                        <td><?= $s['Model_Adi'] ?></td>
                                        <td><?= $s['TepeAdi'] ?></td>
                                        <td><?= $C->fetch()["Cap"] ?> cm</td>
                                        <td><?= $baglanti->query("SELECT Kalinlik FROM view_urun_levha_bilgi WHERE Levha_ID=" . $s['Levha_ID'] . " AND Urun_ID=" . $Uid)->fetch()["Kalinlik"] ?> mm</td>
                                    </tr>
                            <?php } else {
                                    echo "<script>" . $UrunLevhaYok . "</script>";
                                }
                            }
                            $SetBilgi = $baglanti->query('SELECT Adet, icBoya, DisBoya FROM set_urun_icerik WHERE Set_ID = ' . $SetID)->fetchAll();
                            $UrunBilgi = $baglanti->query('SELECT UrunAdi,icBoya_ID,DisRenk,Adet FROM view_set_urun_sec WHERE Set_ID = ' . $SetID . " ORDER BY UrunAdi")->fetchAll();
                            ?>
                            <tr class="table-light text-center">
                                <th colspan="6">SET BOYA BİLGİ</th>
                            </tr>
                            <tr>
                                <th rowspan="<?= count($SetBilgi) + 1 ?>"></th>
                                <th>İç Boya</th>
                                <th>Dış Boya</th>
                                <th>Adet</th>
                                <th colspan="2" rowspan="<?= count($SetBilgi) + 1 ?>"></th>
                            </tr>
                            <?php
                            foreach ($SetBilgi as $s) { ?>
                                <tr>
                                    <td><?= $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $s["icBoya"])->fetch()["Renk"] ?></td>
                                    <td><?= $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $s["DisBoya"])->fetch()["Renk"] ?></td>
                                    <td><input class='Tadet' type='hidden' value='<?= $s['Adet'] ?>'><?= $s['Adet'] ?></td>
                                </tr>
                            <?php } ?>
                            <tr class="table-light text-center">
                                <th colspan="6">ÜRÜN BOYA BİLGİ</th>
                            </tr>
                            <tr>
                                <th>Ürünler</th>
                                <th>İç Boya</th>
                                <th>Dış Boya</th>
                                <th>Adet</th>
                                <th colspan="2" rowspan="<?= count($UrunBilgi) + 1 ?>"></th>
                            </tr>
                            <?php foreach ($UrunBilgi as $b) { ?>
                                <tr>
                                    <td><?= $b["UrunAdi"] ?></td>
                                    <td><?= $b["DisRenk"] ?></td>
                                    <td><?= $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $b["icBoya_ID"])->fetch()["Renk"] ?></td>
                                    <td><?= $b["Adet"] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
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