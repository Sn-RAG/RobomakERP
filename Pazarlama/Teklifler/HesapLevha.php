<?php
$page = "Levha Hesabı";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
$id=(int)$_GET["id"];
$Adet=(int)$_GET["adet"];//Set
$Ad=$_GET["adi"];//Setadı
$mm = $baglanti->query("SELECT Kalinlik FROM set_icerik INNER JOIN set_urun_icerik ON set_icerik.Set_Urun_icerik_ID = set_urun_icerik.Set_Urun_icerik_ID WHERE set_urun_icerik.Set_ID =" .$id)->fetch()["Kalinlik"];
?>
    <main id="main" class="main">
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="mb-3 py-3">
                        <a href="Teklifler.php" class="btn btn-secondary bi-arrow-left-circle me-3 mb-1">&nbsp Geri Dön</a>
                        <button type="button" id="yazdir" class="btn btn-primary bi-printer mb-1">&nbsp Yazdır</button>
                    </div>

                    <h5 class="card-title">Set Adı: <?=$Ad?> &nbsp Set Miktarı= <?=$Adet?></h5>
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
                                $sor = $baglanti->query("SELECT Urun_ID,Adet FROM view_set_urun_sec WHERE Set_ID=".$id);
                                foreach ($sor as $s) {
                                    $i++;
                                    $sor2 = $baglanti->query("SELECT * FROM urun WHERE Urun_ID=" . $s["Urun_ID"]);
                                    foreach ($sor2 as $s2) {
                                        $cap = $baglanti->query("SELECT Cap FROM urun_levha_bilgi INNER JOIN levha ON urun_levha_bilgi.Levha_ID = levha.Levha_ID WHERE Urun_ID =" . $s["Urun_ID"]." AND  Kalinlik =".$mm)->fetch()["Cap"];
                                        
                                        $AdetKg=ceil((($cap*$cap*$mm*(0.22))/1000)*$Adet*$s["Adet"]);
                                        $Topla+=$AdetKg;
                                ?>
                                    <tr>
                                        <td><?=$i?></td>
                                        <td><?=$cap?></td>
                                        <td><?=$mm?></td>
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
            </div>
        </section>
    </main>
<style>@media print { body * {visibility: hidden;}.yazdir * {visibility: visible;}}</style>

<script>
$("#yazdir").click(function(){
    window.print();
});
</script>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>