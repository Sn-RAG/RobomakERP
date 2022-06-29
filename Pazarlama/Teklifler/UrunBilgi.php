<div class="modal fade" id="UrunBilgi<?= $Adi['Set_ID'] ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $Adi['SetAdi'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                    $Ad1 = $baglanti->query("SELECT Urun_ID FROM set_urun WHERE  Set_ID=" . $Adi['Set_ID']);
                    foreach ($Ad1 as $Adi1) {

                        $Ad2 = $baglanti->query("SELECT UrunAdi, Aciklama FROM urun WHERE Urun_ID=" . $Adi1['Urun_ID']);
                        foreach ($Ad2 as $Adi2) {
                            echo "<div class='col-md-6'>
                            <div class='fw-bold'>$Adi2[UrunAdi]</div>
                            $Adi2[Aciklama]
                        </div>
                        ";
                        }
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
                
            </div>
        </div>
    </div>

</div>

<!--?php
$page = "Yazdir";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
$Kalinlik = $baglanti->query("SELECT Kalinlik FROM set_icerik INNER JOIN set_urun_icerik ON set_icerik.Set_Urun_icerik_ID = set_urun_icerik.Set_Urun_icerik_ID WHERE set_urun_icerik.Set_ID =" . $_SESSION["Set_ID"])->fetch()["Kalinlik"];
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
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
        </div>
    </section>
</main>

<style>@media print { body * {visibility: hidden;}.yazdir * {visibility: visible;}}</style>

<script>
$("#yazdir").click(function(){
    window.print();
});
</script>
-->