<?php
$page = "Teklifler";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Sil.php';
unset($_SESSION["SeticerikID"], $_SESSION["Setler"], $_SESSION["FirmaID"], $_SESSION["FirmaAdi"], $_SESSION["SetAdi"]);
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title"><?= $page ?></h5>
                <a href="TeklifVer.php" class="btn btn-primary">Teklif Ver</a>

                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown" data-bs-toggle="dropdown" aria-expanded="false"> Firmalar</button>
                <ul class="dropdown-menu" aria-labelledby="dropdown">
                    <li><a class="hover dropdown-item" href="../../Firmalar/Firmalar.php">Firmalar</a></li>
                    <li><a class="hover dropdown-item" href="../../Firmalar/FirmaEkle.php">Firma Ekle</a></li>
                </ul>

                <hr>

                <table class="table datatablem">
                    <thead>
                        <tr class="table-light">
                            <th>Firma</th>
                            <th class="text-center">Setler</th>
                            <th>Teslim Tarihi</th>
                            <th>&nbsp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sorgu2 = $baglanti->query('SELECT * FROM view_teklifler');
                        foreach ($sorgu2 as $sonuc) {
                            $id = $sonuc['Teklif_ID'];
                            $TT = $sonuc['Teslim_Tarihi'];
                            $Firma = $sonuc['Firma'];
                            $SNo = $sonuc['S_No'];
                        ?>
                            <tr>
                                <td><?= $Firma ?></td>
                                <td>
                                    <?php
                                    $Adi = $baglanti->query("SELECT Set_ID, SetAdi, Adet FROM teklif_setler INNER JOIN set_icerik ON teklif_setler.Set_icerik_ID = set_icerik.Set_icerik_ID INNER JOIN view_uretim_setler ON set_icerik.Set_Urun_ID = view_uretim_setler.Set_Urun_ID WHERE S_No=" . $SNo);
                                    foreach ($Adi as $Ad) {
                                        $Sid = $Ad["Set_ID"];
                                        $Sadi = $Ad["SetAdi"];
                                        $Adet = $Ad['Adet'];
                                    ?>
                                        <li class='d-flex justify-content-between'>
                                            <div class='col-md-10'>
                                                <button class='btn btn-sm bg-light form-control' data-bs-toggle='modal' data-bs-target='#UrunBilgi<?= $Sid ?>'><?= $Sadi ?></button>
                                            </div>
                                            <small class="bg-light d-flex align-items-center"> &nbsp <?= $Adet ?> - Adet &nbsp </small>
                                        </li>

                                        <div class="modal fade" id="UrunBilgi<?= $Sid ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><?= $Sadi ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <a href="HesapLevha.php?id=<?= $Sid ?>&adet=<?= $Adet ?>&adi=<?= $Sadi ?>" class='btn btn-success btn-sm'>Levha Hesabı</a>

                                                        <hr>

                                                        <b>Ürünler</b>
                                                        <?php foreach ($baglanti->query("SELECT DISTINCT UrunAdi,Levha_ID FROM view_set_urun_sec WHERE Set_ID=" . $Sid) as $A) { ?>
                                                            <span class='border-bottom d-flex justify-content-between'><?= "<span>" . $A["UrunAdi"] . "</span>" . $baglanti->query("SELECT Kalinlik FROM levha WHERE Levha_ID=" . $A["Levha_ID"])->fetch()["Kalinlik"] . " mm" ?></span>
                                                        <?php } ?>
                                                        <hr>
                                                        <div class="d-flex justify-content-between border-bottom border-dark"><b>İç Boya</b><b>Dış Boya</b><b>ADET</b></div>
                                                        <?php foreach ($baglanti->query('SELECT DISTINCT Adet, icBoya_ID, DisRenk FROM view_set_urun_sec WHERE Set_ID = ' . $Sid) as $s) { ?>
                                                            <span class='border-bottom d-flex justify-content-between'><span><?= $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $s["icBoya_ID"])->fetch()["Renk"] . "</span><span>" .  $s["DisRenk"] . "</span><span>" . $s['Adet'] ?></span></span>
                                                            <?php } ?>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </td>
                                <td><?= $TT ?></td>
                                <td>
                                    <a href="Teklifler.php?TeklifSil=<?= $id ?>&S_No=<?= $SNo ?>" class="btn btn-danger bi-x-square btn-sm"></a>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main><!-- End #main -->
<script>
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
ob_end_flush();
require __DIR__ . '/../../controller/Footer.php';
?>