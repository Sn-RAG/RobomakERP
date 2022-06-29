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
                <div class="card-body">
                    <div class="d-flex align-items-between mb-3 py-3">
                        <h5><?= $_SESSION["SetAdi"] ?> Adlı Setin Levha Hesabı<br></h5>
                    </div>
                    <button id="yazdir" class="btn btn-primary">Yazdır</button>
                    <div class="yazdir">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
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
                                $Topla=0;
                                $sor = $baglanti->query("SELECT Urun_ID,Adet FROM view_set_urun_sec WHERE Set_ID=" . $_SESSION["Set_ID"]);
                                foreach ($sor as $s) {
                                    $i++;
                                    $sor2 = $baglanti->query("SELECT * FROM urun WHERE Urun_ID=" . $s["Urun_ID"]);
                                    foreach ($sor2 as $s2) {
                                        $cap = $baglanti->query("SELECT Cap FROM urun_levha_bilgi INNER JOIN levha ON urun_levha_bilgi.Levha_ID = levha.Levha_ID WHERE Urun_ID =" . $s["Urun_ID"]." AND Kalinlik =".$Kalinlik)->fetch()["Cap"];
                                       $AdetKg=ceil((($cap*$cap*$Kalinlik*(0.22))/1000)*$s["Adet"]);
                                       $Topla+=$AdetKg;
                                ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$cap?></td>
                                        <td><?=$Kalinlik?></td>
                                        <td><?=$s2["UrunAdi"]?></td>
                                        <td><?=$AdetKg?></td>
                                        <td></td>
                                    </tr>
                                <?php }}?>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>Toplam= <?=$Topla?> Kg</td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <style>@media print { body * {visibility: hidden;}.yazdir * {visibility: visible;}}</style>
                <script>
                    $("#yazdir").click(function(){
                        window.print();
                    });
                </script>
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