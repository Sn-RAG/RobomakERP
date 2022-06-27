<?php
$page = "Yazdir";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
$Kalinlik = $baglanti->query("SELECT Kalinlik FROM set_icerik INNER JOIN set_urun_icerik ON set_icerik.Set_Urun_icerik_ID = set_urun_icerik.Set_Urun_icerik_ID WHERE set_urun_icerik.Set_ID =" . $_SESSION["Set_ID"])->fetch()["Kalinlik"];
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <?php
            if (isset($_GET["Levha"])) { ?>
                <div class="col-xl-8">
                    <div class="col-6 d-flex align-items-between">
                        <p><?= $_SESSION["SetAdi"] ?> FİYAT LİSTESİ<br>
                            <span class="fw-bold">Kalınlık:
                                <?= $Kalinlik ?>
                            </span>
                        </p>
                    </div>
                    <table class="table table-sm small">
                        <thead>
                            <tr class="table-light">
                                <th>S_NO</th>
                                <th>Çap (cm)</th>
                                <th>Kalınlık</th>
                                <th>Ürün No</th>
                                <th>Sipariş Miktar (kg)</th>
                                <th>Termin</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 0;
                            $sor = $baglanti->query("SELECT * FROM view_set_urun_sec WHERE Set_ID=" . $_SESSION["Set_ID"]);
                            foreach ($sor as $s) {
                                $i++;
                            ?>
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?php
                                        $cap = $baglanti->query("SELECT Cap FROM view_urun_levha_bilgi WHERE Urun_ID=" . $sor["Urun_ID"]);
                                        foreach ($cap as $c) {echo $c["Cap"];}
                                        ?></td>
                                    <td><?= $Kalinlik ?></td>
                                    <td><?= $s["UrunAdi"] ?></td>
                                    <td>sipariş miktar</td>
                                    <td>Termin</td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            <?php } else { ?>
                <div class="row g-3 card-body">
                    <div class="col-6">
                        <p><br>KEKSAN ALÜMİNYUM MUTFAK EŞYALARI VE TEKSTİL FERHAT DALGAÇ<br>Aksu V.D.: 303
                            317 378 94<br>İstasyon Mahallesi İlahiyat Caddesi No: 8 Tel: +90 344 236 35 38<br>Dulkadiroğlu
                            /K.MARAŞ
                        </p>
                    </div>
                    <div class="col-6 d-flex align-items-center">
                        <p><?= $_SESSION["SetAdi"] ?> FİYAT LİSTESİ<br>
                            <span class="fw-bold">Kalınlık:
                                <?= $Kalinlik ?>
                            </span>
                        </p>
                    </div>
                    <div class="col-xl-8">
                        <table class="table table-sm small">
                            <thead>
                                <tr class="table-light">
                                    <th>Resim</th>
                                    <th>Ürün Özellikleri</th>
                                    <th>Kapak</th>
                                    <th>Kulp/Tepe</th>
                                    <th>Koli/Şirink<br>Adet</th>
                                    <th>Koli/M3</th>
                                    <th>Ölçü<br>Birim</th>
                                    <th>Ebad</th>
                                    <th>Adet</th>
                                    <th>Toplam Fiyat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-xl-4 py-4">
                        <table class="table table-sm small">
                            <thead>
                                <tr class="table-light">
                                    <th>Koli</th>
                                    <th>İçi</th>
                                    <th>M3</th>
                                    <th>T.M3</th>
                                    <th>Adet</th>
                                    <th>Fiyat</th>
                                    <th>Toplam</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="col-xl-8">
                        <table class="table table-bordered table-sm small">
                            <thead>
                                <tr>Maliyet Cetveli</tr>
                                <tr>
                                    <th>Çap</th>
                                    <th>Gramaj</th>
                                    <th>Al kg $</th>
                                    <th>Kulp/Tepe</th>
                                    <th>Koli/Şirink<br>Adet</th>
                                    <th>Koli/M3</th>
                                    <th>Ölçü<br>Birim</th>
                                    <th>Ebad</th>
                                    <th>Adet</th>
                                    <th>Toplam Fiyat</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                    <td>asd</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>

            <?php } ?>
        </div>
    </section>
</main>
<?php
require __DIR__ . '/../controller/Footer.php';
?>