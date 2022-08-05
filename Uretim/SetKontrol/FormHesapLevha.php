<?php
session_start();
$page = "Levha Hesabı";
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';
$id = (int)$_GET["id"];
?>
<!DOCTYPE html>
<html lang="tr">

<head>
    <title><?= $page ?></title>
    <link href="../../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="../../assets/vendor/datatables/datatables.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../../assets/css/style.css" rel="stylesheet">

    <!-- JQUERY -->
    <script src="../../assets/vendor/datatables/datatables.min.js"></script>
    <!-- SweetAlert -->
    <script src="../../assets/js/sweetalert2.all.min.js"></script>
</head>

<body style="background-color:white;">
    <div class="card">
        <div class="card-body">
            <br>
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
                        $say = 0;
                        $Levhalar = [];

                        $sor = $baglanti->query("SELECT Urun_ID, UrunAdi, Levha_ID, SUM(Adet) AS Adet FROM view_set_urun_sec WHERE Set_ID =" . $id . " GROUP BY Urun_ID");
                        foreach ($sor as $s) {
                            $l = $baglanti->query("SELECT Cap,Cap2,Kalinlik FROM urun_levha_bilgi INNER JOIN levha ON urun_levha_bilgi.Levha_ID = levha.Levha_ID WHERE Urun_ID =" . $s["Urun_ID"] . " AND levha.Levha_ID =" . $s["Levha_ID"]);
                            if ($l->rowCount()) {
                                $Levhalar[$say] = $s["Levha_ID"];
                                $say++;
                                $q = $l->fetch();
                                $c = $q["Cap"];
                                $c2 = $q["Cap2"];
                                $k = $q["Kalinlik"];
                                //GRİLL HESAPLA 
                                $sor = $baglanti->query("SELECT * FROM urun WHERE Urun_ID=" . $s["Urun_ID"] . " AND UrunAdi LIKE '%Gril%'")->rowCount();
                                // KÖŞELİ HESAPLAMA
                                $cl = $baglanti->query("SELECT * FROM urun WHERE Urun_ID=" . $s["Urun_ID"] . " AND UrunAdi LIKE '%Köşeli%'")->rowCount();
                                if ($cl) {
                                    $etk = true;
                                    $adt = $s["Adet"];
                                    $Fire = ceil(($s["Adet"] * 5) / 100);
                                    $adt += $Fire;
                                    //KÖŞELİ HESAPLAMA SON
                                } elseif ($sor) {
                                    $etk = true;
                                    $adt = $s["Adet"];
                                    $Fire = ceil(($s["Adet"] * 5) / 100);
                                    $adt += $Fire;
                                } else {
                                    $etk = false;
                                    $AdetKg = ceil((($c * $c * $k * (0.22)) / 1000) * $s["Adet"]);

                                    $Fire = ceil((ceil((($c * $c * $k * (0.22)) / 1000) * $s["Adet"]) * 5) / 100);
                                    $AdetKg += $Fire;
                                }
                                @$yaz = $etk == false ? $AdetKg : $adt . " Adet";
                                @$Topla += $AdetKg;
                                $bak = $c2 <> null ? " &nbsp <i class='bi-dash-lg'></i> &nbsp " . $c2." cm" : ""; ?>
                                <tr>
                                    <td><?= $i++ ?></td>
                                    <td><?= $c." cm " . $bak ?></td>
                                    <td><?= $k." mm" ?></td>
                                    <td><?= $s["UrunAdi"] ?></td>
                                    <td><?= $yaz ?></td>
                                    <td></td>
                                </tr>
                        <?php } else {
                                echo "<script>" . $UrunLevhaYok . "</script>";
                            }
                        } ?>
                        <tr>
                            <td colspan="4"></td>
                            <td>Toplam= <?= $Topla ?> Kg</td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="text-center">
                <h5 class="card-title">Set Adı: <?= $_GET["adi"] ?> <code class="fs-5">+ %5 Fire</code></h5>
                <button class="bi-printer" onclick="window.print()">&nbsp Yazdır</button>
                &nbsp
                <button id="Siparis" class="bi-file-text">&nbsp Sipariş</button>
            </div>
        </div>
    </div>
</body>

</html>
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
    $(function() {
        $("button").addClass("btn btn-primary");
    });
    $("#Siparis").click(function() {
        $.ajax({
            type: "POST",
            url: "FormHesapLevha.php",
            data: {
                'Levhalar': <?= json_encode($Levhalar) ?>
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            },
            success: function() {
                window.location.assign("../../SatinAlma/Siparis/SiparisListesi.php");
            }
        })
    });
</script>
<?php
if (isset($_POST["Levhalar"])) {
    $_SESSION["Levhalar"] = $_POST["Levhalar"];
}
?>