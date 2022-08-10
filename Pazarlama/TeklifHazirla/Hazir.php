<?php
ob_start();
$tn = isset($_GET["h"]) ? "hidden" : "";
$gizle = "hidden";
$gizle2 = "hidden";
$gizle3 = "hidden";
$gizle4 = "hidden";
$geri = "";
if (isset($_GET["Teklif"])) {
    $t = "1 AND Onay=0";
    $page = "Teklif";
    $gizle2 = "";
} elseif (isset($_GET["Ret"])) {
    $t = 2;
    $gizle3 = "";
    $page = "Ret";
} elseif (isset($_GET["Onay"])) {
    $t = "1 AND Onay=1";
    $gizle4 = "";
    $page = "Onay";
} else {
    $t = 0;
    $page = "Hazır Teklifler";
    $gizle = "";
}
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Sil.php';
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $page ?></h5>
                <div <?= $gizle ?>>
                    <a href="Hazirla.php" class="btn btn-primary me-3 bi-briefcase">&nbsp Teklif Hazırla</a>

                    <button class="btn btn-primary dropdown-toggle me-3 bi-globe" type="button" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false">&nbsp Firmalar</button>
                    <ul class="dropdown-menu" aria-labelledby="dropdown">
                        <li><a class="hover dropdown-item" href="../../Firmalar/Firmalar.php">Firmalar</a></li>
                        <li><a class="hover dropdown-item" href="../../Firmalar/FirmaEkle.php">Firma Ekle</a></li>
                    </ul>
                    <a href="Hazir.php?Teklif" class="btn btn-success bi-book me-3">&nbsp Teklif</a>
                    <a href="Hazir.php?Ret" class="btn btn-warning bi-dash-circle me-3">&nbsp Ret</a>
                    <a href="Hazir.php?Onay" class="btn btn-info bi-card-checklist">&nbsp Onay</a>
                </div>

                <a <?= $gizle == "hidden" ? "" : "hidden" ?> href='Hazir.php' class='btn btn-secondary bi-arrow-left me-3'>&nbsp Geri Dön</a>

                <hr>

                <table class="table datatablem">
                    <thead>
                        <tr class="table-light">
                            <th>Firma</th>
                            <th class="text-center">Setler</th>
                            <th>&nbsp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sorgu2 = $baglanti->query('SELECT * FROM view_teklifler WHERE Teklif=' . $t);
                        foreach ($sorgu2 as $sonuc) {
                            $id = $sonuc['Teklif_ID'];
                            $Firma = $sonuc['Firma'];
                            $SNo = $sonuc['S_No'];
                        ?>
                            <tr>
                                <td><?= $Firma ?></td>
                                <td>
                                    <?php
                                    $Adi = $baglanti->query("SELECT Set_ID, SetAdi FROM teklif_setler INNER JOIN set_icerik ON teklif_setler.Set_icerik_ID = set_icerik.Set_icerik_ID INNER JOIN view_uretim_setler ON set_icerik.Set_Urun_ID = view_uretim_setler.Set_Urun_ID WHERE S_No=" . $SNo);
                                    foreach ($Adi as $Ad) {
                                        $Sid = $Ad["Set_ID"];
                                        $Sadi = $Ad["SetAdi"];
                                    ?>
                                        <button class='btn btn-sm bg-light form-control border mb-1' data-bs-toggle='modal' data-bs-target='#UrunBilgi<?= $Sid ?>'><?= $Sadi ?></button>

                                        <div class="modal fade" id="UrunBilgi<?= $Sid ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><?= $Sadi ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <a href="../../Uretim/SetKontrol/FormHesapLevha.php?id=<?= $Sid ?>&adi=<?= $Sadi ?>" class='btn btn-secondary btn-sm me-3'>Levha Hesabı</a>
                                                        <a href="../../Uretim/SetKontrol/FormHesapBoya.php?id=<?= $Sid ?>&adi=<?= $Sadi ?>" class='btn btn-secondary btn-sm'>Boya Hesabı</a>

                                                        <hr>

                                                        <b>Ürünler</b>
                                                        <?php foreach ($baglanti->query("SELECT DISTINCT UrunAdi,Levha_ID FROM view_set_urun_sec WHERE Set_ID=$Sid ORDER BY Urun_ID") as $A) { ?>
                                                            <span class='border-bottom d-flex justify-content-between'><?= "<span>" . $A["UrunAdi"] . "</span>" . $baglanti->query("SELECT Kalinlik FROM levha WHERE Levha_ID=" . $A["Levha_ID"])->fetch()["Kalinlik"] . " mm" ?></span>
                                                        <?php } ?>
                                                        <hr>
                                                        <div class="d-flex justify-content-between border-bottom border-dark"><b>İç Boya</b><b>Dış Boya</b><b>ADET</b></div>
                                                        <?php foreach ($baglanti->query('SELECT DISTINCT Adet, icBoya_ID, DisRenk FROM view_set_urun_sec WHERE Set_ID = ' . $Sid) as $s) { ?>
                                                            <span class='border-bottom d-flex justify-content-between'>
                                                                <span><?= $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $s["icBoya_ID"])->fetch()["Renk"] . "</span><span>" .  $s["DisRenk"] . "</span><span>" . $s['Adet'] ?>
                                                                </span>
                                                            </span>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td>
                                    <a <?= $gizle3 ?> href='Hazir.php?TeklifVer=<?= $id ?>' class='btn btn-info bi-back btn-sm'>&nbsp Geri Al</a>
                                    <a <?= $gizle4 ?> href='Hazir.php?OnayGeri=<?= $id ?>' class='btn btn-info bi-back btn-sm'>&nbsp Geri Al</a>
                                    <div <?= $gizle2 ?>>
                                        <a href='Hazir.php?Onayla=<?= $id ?>' class='btn btn-primary bi-check-lg btn-sm'>&nbsp Onayla</a>
                                        <a href='Hazir.php?Reddet=<?= $id ?>' class='btn btn-danger bi-x-lg btn-sm'>&nbsp Reddet</a>
                                    </div>
                                    <div <?= $gizle ?>>
                                        <a href='Hazir.php?TeklifVer=<?= $id ?>' class='btn btn-success bi-check-lg btn-sm'>&nbsp Teklif Ver</a>
                                        <a href="Hazir.php?TeklifSil=<?= $id ?>&S_No=<?= $SNo ?>" class="btn btn-danger bi-x-square btn-sm"></a>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
<script>
    $(function() {
        $("td").addClass("ortala");
    });
    $('.datatablem').DataTable({
        responsive: true,
        columnDefs: [{
            targets: [0],
            orderable: false
        }],
        pageLength: 100,
        lengthMenu: [
            [25, 50, 100, -1],
            ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
        ]
    });
</script>
<?php
require __DIR__ . '/../../controller/Footer.php';
if (isset($_GET["TeklifVer"])) {
    $id = strip_tags(htmlspecialchars(trim($_GET['TeklifVer'])));
    $Teklif = $baglanti->prepare("UPDATE teklifler SET Teklif= ? WHERE Teklif_ID= ?");
    $Teklif->execute(array(1, $id));
    header("location:Hazir.php?Teklif");
} elseif (isset($_GET["Onayla"])) {
    $id = strip_tags(htmlspecialchars(trim($_GET['Onayla'])));
    $Teklif = $baglanti->prepare("UPDATE teklifler SET Onay= ? WHERE Teklif_ID= ?");
    $Teklif->execute(array(1, $id));
    header("location:Hazir.php?Onay");
} elseif (isset($_GET["OnayGeri"])) {
    $id = strip_tags(htmlspecialchars(trim($_GET['OnayGeri'])));
    $Teklif = $baglanti->prepare("UPDATE teklifler SET Onay= ? WHERE Teklif_ID= ?");
    $Teklif->execute(array(0, $id));
    header("location:Hazir.php?Teklif");
} elseif (isset($_GET["Reddet"])) {
    $id = strip_tags(htmlspecialchars(trim($_GET['Reddet'])));
    $Teklif = $baglanti->prepare("UPDATE teklifler SET Teklif= ? WHERE Teklif_ID= ?");
    $Teklif->execute(array(2, $id));
    header("location:Hazir.php?Ret");
}
?>