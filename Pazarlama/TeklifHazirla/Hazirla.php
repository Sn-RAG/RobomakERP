<?php
ob_start();
$page = "Teklif Hazırla";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';

//Diğer sayfalarda verileri çekip sessionda kalıcı şekilde saklıyoruz

if (isset($_GET["FirmaID"])) {
    $_SESSION["FirmaID"] = $_GET["FirmaID"];
    $_SESSION["FirmaAdi"] = $_GET["FirmaAdi"];
}
$fsor = isset($_SESSION["FirmaID"]) ? "Değiştir" : "Firma Seç";
$ssor = isset($_SESSION["Setler"]) ? "Değiştir" : "Set Seç";
$Fdegis = "<a href='../../Firmalar/Firmalar.php?Sec' class='btn btn-outline-secondary'>" . $fsor . "</a>";
$Sdegis = "<a href='../../Uretim/Setler.php?Sec' class='btn btn-outline-secondary'>" . $ssor . "</a>";
if (isset($_SESSION["Setler"])) {
    $Say = count($_SESSION["Setler"]);
}
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <br>
                <div class="d-flex justify-content-between">
                    <a href="Hazir.php" class="btn btn-secondary bi-arrow-left">&nbsp Geri Dön</a>
                    <h5><?= $page ?></h5>
                    <button class="btn btn-primary bi-card-checklist Kaydet"> &nbsp Kaydet</button>
                </div>

                <hr>

                <div class="d-flex justify-content-between">
                    <div class="border-end col-6 d-flex justify-content-center">
                        <div class="col-11">
                            <a href="../../Firmalar/FirmaEkle.php" class="btn btn-sm btn-outline-primary bi-save-fill">&nbsp Yeni Firma</a>
                            <table class="table table-sm tablom">
                                <thead>
                                    <tr>
                                        <th>&nbsp</th>
                                        <th class="text-center">Firma</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($baglanti->query('SELECT Firma_ID,Firma FROM view_firmalar') as $s) {
                                        $id = $s['Firma_ID'];
                                    ?>
                                        <tr>
                                            <td>
                                                <label class='form-check-label' for='Radio<?= $id ?>'><input name="Firma" class='form-check-input' type='radio' id='Radio<?= $id ?>' value='<?= $id ?>'> &nbsp Seç</label>
                                            </td>
                                            <td class="text-center"><?= $s['Firma'] ?></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="border-start col-6 d-flex justify-content-center">
                        <div class="col-11">
                            <a href="../../Uretim/SetlerKayit.php" class="btn btn-sm btn-outline-primary bi-save-fill">&nbsp Yeni Set</a>
                            <table class="table table-sm tablom">
                                <thead>
                                    <tr>
                                        <th>&nbsp</th>
                                        <th class="text-center">Set</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($baglanti->query('SELECT Set_ID, SetAdi, Set_icerik_ID FROM view_uretim_setler INNER JOIN set_icerik ON view_uretim_setler.Set_Urun_ID = set_icerik.Set_Urun_ID') as $sonuc) {
                                        $id = $sonuc['Set_icerik_ID'];
                                        $SetID = $sonuc['Set_ID'];
                                        $SetAdi = $sonuc['SetAdi'];
                                    ?>
                                        <tr>
                                            <td>
                                                <label class='form-check-label' for='Check<?= $id ?>'><input class='form-check-input' type='checkbox' id='Check<?= $id ?>' value='<?= $id ?>'> &nbsp Seç</label>
                                            </td>
                                            <td><button class='btn btn-sm bg-light form-control form-control-sm' data-bs-toggle='modal' data-bs-target='#UrunBilgi<?= $SetID ?>'><?= $SetAdi ?></button></td>

                                            <div class="modal fade" id="UrunBilgi<?= $SetID ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?= $SetAdi ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <b>Ürünler</b>
                                                            <?php foreach ($baglanti->query("SELECT DISTINCT UrunAdi,Levha_ID FROM view_set_urun_sec WHERE Set_ID=$SetID ORDER BY Urun_ID") as $A) { ?>
                                                                <span class='border-bottom d-flex justify-content-between'><?= "<span>" . $A["UrunAdi"] . "</span>" . $baglanti->query("SELECT Kalinlik FROM levha WHERE Levha_ID=" . $A["Levha_ID"])->fetch()["Kalinlik"] . " mm" ?></span>
                                                            <?php } ?>
                                                            <hr>
                                                            <div class="d-flex justify-content-between border-bottom border-dark"><b>İç Boya</b><b>Dış Boya</b><b>ADET</b></div>
                                                            <?php foreach ($baglanti->query('SELECT DISTINCT Adet, icBoya_ID, DisRenk FROM view_set_urun_sec WHERE Set_ID = ' . $SetID) as $s) {
                                                                $icRenk = $baglanti->query('SELECT Renk FROM boya WHERE Boya_ID =' . $s["icBoya_ID"])->fetch()["Renk"];
                                                            ?>
                                                                <span class='border-bottom d-flex justify-content-between'><?= "<span>" . $icRenk . "</span><span>" .  $s["DisRenk"] . "</span><span>" . $s['Adet'] . "</span>" ?></span>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="yaz"></div>
    </section>
</main>
<script>
    $(function() {
        $("td").addClass("ortala");
    });
    $(".Kaydet").click(function() {
        var Setsec = [];
        $("input:checkbox:checked").map(function() {
            Setsec.push($(this).val());
        });
        var Firma = $("input:radio:checked").val();

        $.ajax({
            type: "POST",
            url: "post.php",
            data: {
                'Setsec': Setsec,
                'Firma': Firma
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            },
            success: function(data) {
                $(".yaz").html(data);
                //window.location.assign("Hazir.php")
            }
        })
    });
</script>
<?php require __DIR__ . '/../../controller/Footer.php'; ?>