<?php
$page = "Set Kontrol";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
$SNo = strip_tags(htmlspecialchars((int)$_GET['SNo']));
$Setler = $baglanti->query("SELECT Set_ID, SetAdi FROM teklif_setler INNER JOIN set_icerik ON teklif_setler.Set_icerik_ID = set_icerik.Set_icerik_ID INNER JOIN view_uretim_setler ON set_icerik.Set_Urun_ID = view_uretim_setler.Set_Urun_ID WHERE S_No=" . $SNo)->fetchAll();
$FAdi = $_GET["adi"];
foreach ($Setler as $s) {
    $SetID = $s["Set_ID"];
    require __DIR__ . '/Yuzde.php';
}
date_default_timezone_set('Europe/Istanbul');
$tarih = new DateTime("now");
$tarih = date("Y-m-d");
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div><a href="../Setler.php" class="bi-arrow-left btn btn-secondary">&nbsp Geri Dön</a></div>
                <h5 class='card-title text-center fs-5'><?= $FAdi ?></h5>
            </div>
            <div class="card-body row g-3">
                <div class="col-md-12 text-center">
                    <button class="mb-3 me-2 btn btn-primary t" id="Pres">Pres</button>
                    <button class="mb-3 me-2 btn btn-outline-dark t" id="Yikama">Yıkama</button>
                    <button class="mb-3 me-2 btn btn-outline-dark t" id="Kumlama">Kumlama</button>
                    <button class="mb-3 me-2 btn btn-outline-dark t" id="Telleme">Telleme</button>
                    <button class="mb-3 me-2 btn btn-outline-dark t" id="icBoyama">İç Boya</button>
                    <button class="mb-3 me-2 btn btn-outline-dark t" id="DisBoyama">Dış Boya</button>
                    <button class="mb-3 me-2 btn btn-outline-dark t" id="Paketleme">Paketleme</button>
                </div>

                <!-- Scroll Tablo -->
                <div class="col-md-6 border mb-3">
                    <div class="isDurum mb-1">
                    </div>
                </div>
                <!-- Scroll Tablo SON -->

                <div class="col-md-6 border mb-3">
                    <div class="col-md-12">
                        <div class="mb-2"></div>
                        <div class="d-flex justify-content-end mb-1">
                            <select class="form-select form-select-sm bg-light me-2 icRenk">
                                <option value="">* İç Renk Seçin</option>
                                <?php
                                $RS = $baglanti->query('SELECT DISTINCT icBoya_ID FROM view_set_urun_sec WHERE Set_ID = ' . $SetID);
                                foreach ($RS as $k) {
                                    $ir = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $k["icBoya_ID"])->fetch()["Renk"];
                                    echo "<option value='$k[icBoya_ID]'>$ir</option>";
                                }
                                ?>
                            </select>

                            <select class="form-select form-select-sm bg-light me-2 DisRenk">
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
                            <button class="Ekle btn btn-primary bi-check me-1"></button>
                            <button class="Fire btn btn-warning bi-dash"></button>
                        </div>
                    </div>
                    <table class="table table-sm table-bordered mb-1 datatablem" id="Yuksek">
                        <tbody>
                            <?php
                            $sayi = [];
                            $i = 0;

                            $sor = [];
                            $SetBilgi = [];
                            $UrunBilgi = [];
                            foreach ($Setler as $s) {
                                $SetID = $s["Set_ID"];
                                $SetBilgi[$i] = $baglanti->query('SELECT DISTINCT SetAdi, Adet, icBoya_ID, DisBoya_ID FROM view_set_urun_sec WHERE Set_ID = ' . $SetID)->fetchAll();
                                $UrunBilgi[$i] = $baglanti->query('SELECT * FROM view_set_urun_sec WHERE Set_ID = ' . $SetID . " ORDER BY Urun_ID")->fetchAll();
                                $sor[$i] = $baglanti->query('SELECT * FROM view_set_urun_sec WHERE Set_ID = ' . $SetID . " GROUP BY Urun_ID")->fetchAll();
                                $i++;
                            }
                            $ii = 0;
                            for ($i = 0; $i < count($sor); $i++) { ?>
                                <tr class="table-primary text-center">
                                    <th colspan="3"><?= $sor[$i][$i]['SetAdi'] ?></th>
                                </tr>
                                <tr class="table-light">
                                    <th>Ürünler</th>
                                    <th class="text-center">İmalat</th>
                                    <th>&nbsp</th>
                                </tr>
                                <?php foreach ($sor[$i] as $s) {
                                    $Sid = $s['Set_ID'];
                                    $Uid = $s['Urun_ID'];
                                    $ad = $s['UrunAdi'];

                                    $no = $Sid . $Uid;

                                    $sayi[$ii] = $no;
                                    $ii++;
                                ?>
                                    <tr>
                                        <td><?= $ad ?></td>
                                        <td class="text-center" id="yazsayi<?= $no ?>"></td>
                                        <td>
                                            <input type="number" no="<?= $no ?>" SetID="<?= $s['Set_ID'] ?>" UrunID="<?= $s['Urun_ID'] ?>" LevhaID="<?= $s['Levha_ID'] ?>" iBoya="<?= $s['icBoya_ID'] ?>" dBoya="<?= $s['DisBoya_ID'] ?>" class="GDeger form-control form-control-sm me-1" placeholder="Adet">
                                        </td>
                                    </tr>
                            <?php }
                            } ?>
                        </tbody>
                    </table>
                </div>

                <div class="col-md-12">
                    <table class="table table-sm small table-bordered">
                        <tbody>
                            <tr class="table-primary text-center">
                                <th colspan="6">DETAYLAR</th>
                            </tr>
                            <tr>
                                <td colspan="6">&nbsp</td>
                            </tr>
                            <?php for ($i = 0; $i < count($sor); $i++) { ?>
                                <tr class="table-light text-center">
                                    <th colspan="6" class="text-danger"><?= $sor[$i][$i]['SetAdi'] ?></th>
                                </tr>
                                <tr class="table-light">
                                    <th>Ürünler</th>
                                    <th>Kulp</th>
                                    <th>Kapak</th>
                                    <th>Tepe</th>
                                    <th>Çap</th>
                                    <th>Kalınlık</th>
                                </tr>
                                <?php foreach ($sor[$i] as $s) {
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
                                } ?>
                                <tr>
                                    <td colspan="6">&nbsp</td>
                                </tr>
                            <?php } ?>
                            <tr class="table-primary text-center">
                                <th colspan="6">SET BOYA BİLGİ</th>
                            </tr>
                            <?php for ($i = 0; $i < count($SetBilgi); $i++) { ?>
                                <tr>
                                    <td colspan="6">&nbsp</td>
                                </tr>
                                <tr class="table-light text-center">
                                    <th colspan="6" class="text-danger"><?= $SetBilgi[$i][$i]['SetAdi'] ?></th>
                                </tr>
                                <tr class="table-light">
                                    <th rowspan="<?= count($SetBilgi[$i]) + 1 ?>"></th>
                                    <th>İç Boya</th>
                                    <th>Dış Boya</th>
                                    <th>Adet</th>
                                    <th colspan="2" rowspan="<?= count($SetBilgi[$i]) + 1 ?>"></th>
                                </tr>
                                <?php foreach ($SetBilgi[$i] as $s) { ?>
                                    <tr>
                                        <td><?= $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $s["icBoya_ID"])->fetch()["Renk"] ?></td>
                                        <td><?= $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $s["DisBoya_ID"])->fetch()["Renk"] ?></td>
                                        <td><?= $s['Adet'] ?></td>
                                    </tr>
                            <?php }
                            } ?>
                            <tr>
                                <td colspan="6">&nbsp</td>
                            </tr>
                            <tr class="table-primary text-center">
                                <th colspan="6">ÜRÜN BOYA BİLGİ</th>
                            </tr>
                            <?php for ($i = 0; $i < count($UrunBilgi); $i++) { ?>
                                <tr>
                                    <td colspan="6">&nbsp</td>
                                </tr>
                                <tr class="table-light text-center">
                                    <th colspan="6" class="text-danger"><?= $UrunBilgi[$i][$i]['SetAdi'] ?></th>
                                </tr>
                                <tr class="table-light">
                                    <th rowspan="<?= count($UrunBilgi[$i]) + 1 ?>"></th>
                                    <th>Ürünler</th>
                                    <th>İç Boya</th>
                                    <th>Dış Boya</th>
                                    <th>Adet</th>
                                    <th rowspan="<?= count($UrunBilgi[$i]) + 1 ?>"></th>
                                </tr>
                                <?php foreach ($UrunBilgi[$i] as $b) { ?>
                                    <tr>
                                        <td><?= $b["UrunAdi"] ?></td>
                                        <td><?= $b["DisRenk"] ?></td>
                                        <td><?= $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $b["icBoya_ID"])->fetch()["Renk"] ?></td>
                                        <td class='Tadet<?= $b["Set_ID"] . $b["Urun_ID"] ?>'><?= $b["Adet"] ?></td>
                                    </tr>
                            <?php }
                            } ?>
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