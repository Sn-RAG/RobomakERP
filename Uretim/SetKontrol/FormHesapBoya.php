<?php
$page = "Boya Hesabı";
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
                                <th>Ürünler</th>
                                <th>İç Boya</th>
                                <th>Dış Boya</th>
                                <th>Adet</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $Tic = 0;
                            $TDis = 0;
                            $n = 1;
                            $QUERY = $baglanti->query("SELECT Urun_ID,UrunAdi,icBoya_ID,DisRenk,Adet FROM view_set_urun_sec WHERE Set_ID =$id ORDER BY UrunAdi");
                            foreach ($QUERY as $bb) {
                                $ic = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $bb["icBoya_ID"])->fetch()["Renk"];

                                $sor = $baglanti->query("SELECT icAstar,icUstkat,DisAstar,DisUstkat FROM view_urun_boya_bilgi WHERE Urun_ID = " . $bb["Urun_ID"] . " AND BoyaTipi='$ic'");
                                if ($sor->rowCount()) {
                                    foreach ($sor as $b) {
                                        //toplam boya
                                        $icsum = $b["icAstar"] += $b["icUstkat"];
                                        $Tic += $icsum;
                                        $dissum = $b["DisAstar"] += $b["DisUstkat"];
                                        $TDis += $dissum;
                            ?>
                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td><?= $bb["UrunAdi"] ?></td>
                                            <td><?= $ic . " &nbsp <b>" . $icsum . " Kg</b>" ?></td>
                                            <td><?= $bb["DisRenk"] . " &nbsp <b>" . $dissum . " Kg</b>" ?></td>
                                            <td><?= $bb["Adet"] ?></td>
                                        </tr>
                            <?php }
                                } else {
                                    echo "<script>" . $BoyaBilgisiYok . "</script>";
                                }
                            }  ?>
                            <tr>
                                <td></td>
                                <td></td>
                                <td>(Astar Dahil)Toplam İç Boya= <?= $Tic ?> Kg</td>
                                <td>(Astar Dahil)Toplam Dış Boya= <?= $TDis ?> Kg</td>
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