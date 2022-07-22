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
                            $Teslim_Tarihi = $sonuc['Teslim_Tarihi'];
                            $Firma = $sonuc['Firma'];
                            $Urun_ID = $sonuc['Urun_ID'];
                            $S_No = $sonuc['S_No'];
                        ?>
                            <tr>
                                <td><?= $Firma ?></td>
                                <td>
                                    <ol class='list-group list-group-numbered'>
                                        <?php
                                        $Ad = $baglanti->query("SELECT * FROM view_teklifler_set_listele WHERE S_No=" . $S_No);
                                        foreach ($Ad as $Adi) {
                                            $Sid = $Adi["Set_ID"];
                                            $Sadi = $Adi["SetAdi"];
                                            $Adet = $Adi['Adet'];
                                        ?>
                                            <li class='list-group-item d-flex justify-content-between align-items-start'>
                                                <div class='ms-2 me-auto small'>
                                                    <?= "<button class='btn btn-sm bg-light' data-bs-toggle='modal' data-bs-target='#UrunBilgi$Sid'>$Sadi</button>" ?>
                                                </div>
                                                <span class='badge bg-primary rounded-pill small'><?= $Adet ?> - Adet</span>
                                            </li>

                                            <div class="modal fade" id="UrunBilgi<?= $Sid ?>" tabindex="-1">
                                                <div class="modal-dialog modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?= $Sadi ?></h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <h5> Levha Hesabı</h5>
                                                            <a href="HesapLevha.php?id=<?= $Sid ?>&adet=<?= $Adet ?>&adi=<?= $Sadi ?>" class='btn btn-success mb-3'><?= $Sadi ?> Levha Hesabı</a>
                                                            <div class="row">
                                                                <?php
                                                                $Aa = $baglanti->query("SELECT UrunAdi, Aciklama FROM set_urun INNER JOIN urun ON set_urun.Urun_ID = urun.Urun_ID WHERE set_urun.Set_ID=" . $Sid);
                                                                foreach ($Aa as $A) { ?>
                                                                    <div class='col-md-6'>
                                                                        <div class='fw-bold'><?= $A["UrunAdi"] ?></div>
                                                                        <?= $A["Aciklama"] ?>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </ol>
                                </td>
                                <td><?= $Teslim_Tarihi ?></td>
                                <td>
                                    <button type="button" class="btn btn-info bi-info-circle" data-bs-toggle="modal" data-bs-target="#Bilgi<?= $id ?>">
                                    </button>
                                    <a href="Teklifler.php?TeklifSil=<?= $id ?>&S_No=<?= $S_No ?>" class="btn btn-danger bi-x-square">
                                    </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="Bilgi<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Bilgi</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <label for="inputText" class="col-sm-3 col-form-label">Firma Adı</label>
                                                <div class="col-sm-9">
                                                    <input value="<?= $Firma ?>" class="form-control" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Teslim Tarihi</label>
                                                <div class="col-sm-9">
                                                    <input value="<?= $Teslim_Tarihi ?>" class="form-control" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Yetkili Adı</label>
                                                <div class="col-sm-9">
                                                    <input value="<?= $sonuc['YetkiliAdi'] ?>" class="form-control" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Yetkili Telefon</label>
                                                <div class="col-sm-9">
                                                    <input value="<?= $sonuc['YetkiliAdi'] ?>" class="form-control" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Sipariş Açan Kullanıcı</label>
                                                <div class="col-sm-9">
                                                    <input value="<?= $sonuc['AdSoyad'] ?>" class="form-control" disabled>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label class="col-sm-3 col-form-label">Düzenleme Tarihi</label>
                                                <div class="col-sm-9">
                                                    <input value="<?= $sonuc['Duzenleme_Tarihi'] ?>" class="form-control" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
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