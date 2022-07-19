<?php
$page = "Levha Hesabı";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
$id = (int)$_GET["id"];
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <div class="mb-3 py-3">
                    <button type="button" id="yazdir" class="btn btn-primary bi-printer mb-1">&nbsp Yazdır</button>
                </div>

                <h5 class="card-title">Set Adı: <?= $_SESSION["SetAdi"] ?></h5>
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
                            $i = 1;
                            $Topla = 0;
                            $sor = $baglanti->query("SELECT Urun_ID, UrunAdi, Levha_ID, SUM(Adet) AS Adet FROM view_set_urun_sec WHERE Set_ID =" . $id . " GROUP BY Urun_ID");
                            foreach ($sor as $s) {
                                $l = $baglanti->query("SELECT Cap,Kalinlik FROM urun_levha_bilgi INNER JOIN levha ON urun_levha_bilgi.Levha_ID = levha.Levha_ID WHERE Urun_ID =" . $s["Urun_ID"] . " AND levha.Levha_ID =" . $s["Levha_ID"]);
                                if ($l->rowCount()) {
                                    $q = $l->fetch();
                                    $c = $q["Cap"];
                                    $k = $q["Kalinlik"];
                                    $AdetKg = ceil((($c * $c * $k * (0.22)) / 1000) * $s["Adet"]);
                                    $Topla += $AdetKg;
                            ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= $c ?></td>
                                        <td><?= $k ?></td>
                                        <td><?= $s["UrunAdi"] ?></td>
                                        <td><?= $AdetKg ?></td>
                                        <td></td>
                                    </tr>
                            <?php } else {
                                    echo "<script>" . $UrunLevhaYok . "</script>";
                                }
                            } ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>Toplam= <?= $Topla ?> Kg</td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
<style>
    @media print {
        body * {
            visibility: hidden;
        }

        .yazdir * {
            visibility: visible;
        }
    }
</style>

<script>
    $("#yazdir").click(function() {
        window.print();
    });
</script>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>