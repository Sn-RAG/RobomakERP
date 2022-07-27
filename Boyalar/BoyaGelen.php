<?php
$page = "Gelen Boya";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/VTHataMesaji.php';

date_default_timezone_set('Europe/Istanbul');
$tarih = new DateTime("now");
$tarih = date("Y-m-d");
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title border-bottom mb-3"><?= $page ?></h5>
                <a href="<?= isset($_GET["Gecmis"]) ? "BoyaGelen.php" : "BoyaStok.php" ?>" class="btn btn-secondary bi-arrow-left-circle me-3 mb-1">&nbsp Geri Dön</a>
                <a href="BoyaGelen.php?Gecmis" class="btn btn-success bi-clock-history mb-1" <?= isset($_GET["Gecmis"]) ? "hidden" : "" ?>>&nbsp Geçmiş</a>
                <hr>
                <table class="table datatablem">
                    <thead>
                        <tr class="table-light">
                            <th>#</th>
                            <th>Boya_Siparis_ID</th>
                            <th>S.K.T</th>
                            <th>Marka</th>
                            <th>Renk</th>
                            <th>Seri</th>
                            <th>Kod</th>
                            <th>UT</th>
                            <th>Teslim Tarihi</th>
                            <th>Sipariş</th>
                            <th>Stok</th>
                            <th>&nbsp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (isset($_GET["Gecmis"])) {
                            $gor = "Siparis_Miktar=0";
                        } else {
                            $gor = "Siparis_Miktar>0";
                        }
                        $sorgu = $baglanti->query("SELECT * FROM view_siparis_boya WHERE " . $gor . "");
                        foreach ($sorgu as $sonuc) {
                            $Boya_Siparis_ID = $sonuc['Boya_Siparis_ID'];
                            $id = $sonuc['Boya_Stok_ID'];
                            $Boya_Tarih_ID = $sonuc['Boya_Tarih_ID'];
                            $Marka = $sonuc['Marka'];
                            $Renk = $sonuc['Renk'];
                            $Seri = $sonuc['Seri'];
                            $Kod = $sonuc['Kod'];
                            $UT = $sonuc['Uretim_T'];
                            $SKT = $sonuc['S_K_T'];
                            $Siparis_Miktar = $sonuc['Siparis_Miktar'];

                            $sorguS = $baglanti->query('SELECT SUM(Stok_Miktar) AS SumStok_Miktar, Teslim_Tarihi FROM boya_gelen WHERE Boya_Stok_ID=' . $id);
                            foreach ($sorguS as $sonuc2) {
                                $Stok_Miktar = $sonuc2['SumStok_Miktar'];
                                $T_Tarihi = $sonuc2['Teslim_Tarihi'];
                        ?>
                                <tr>
                                    <td><?= $id ?></td>
                                    <td><?= $Boya_Siparis_ID ?></td>
                                    <td><?= $Siparis_Miktar < 1 ? "<span class='text-black-50'>" . $SKT . "</span>" : $SKT ?></td>
                                    <td><?= $Siparis_Miktar < 1 ? "<span class='text-black-50'>" . $Marka . "</span>" : $Marka ?></td>
                                    <td><?= $Siparis_Miktar < 1 ? "<span class='text-black-50'>" . $Renk . "</span>" : $Renk ?></td>
                                    <td><?= $Siparis_Miktar < 1 ? "<span class='text-black-50'>" . $Seri . "</span>" : $Seri ?></td>
                                    <td><?= $Siparis_Miktar < 1 ? "<span class='text-black-50'>" . $Kod . "</span>" : $Kod ?></td>
                                    <td><?= $UT ?></td>
                                    <td><?= $Siparis_Miktar < 1 ? "<span class='text-black-50'>" . $T_Tarihi . "</span>" : $T_Tarihi ?></td>
                                    <td><?= $Siparis_Miktar < 1 ? "<span class='text-black-50'>Tamamlandı</span>" : $Siparis_Miktar . " Kg" ?></td>
                                    <td><?= $Stok_Miktar > 0 ? $Stok_Miktar . " Kg" : 0 . " Kg" ?></td>
                                    <td><?= $Siparis_Miktar < 1 ? "" : "<button type='button' class='btn btn-outline-primary bi-minecart' id='Gelen' data-bs-toggle='modal' data-bs-target='#Gelen$id'> Gelen</button>"; ?></td>
                                </tr>

                                <div class="modal fade" id="Gelen<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title"><?= $Siparis_Miktar == null ? 0 : $Siparis_Miktar ?> Kg Siparişten &nbsp
                                                    <i class="bi bi-arrow-right-circle "></i>
                                                    &nbsp <?= $Stok_Miktar == null ? 0 : $Stok_Miktar ?> Kg Geldi
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body row g-3">

                                                <input type="hidden" class="StokMiktar<?= $id ?>" value="<?= $Stok_Miktar > 0 ? $Stok_Miktar : 0 ?>" />

                                                <input type="hidden" class="SipMiktar<?= $id ?>" value="<?= $Siparis_Miktar > 0 ? $Siparis_Miktar : 0 ?>">

                                                <input type="hidden" class="Sipid<?= $id ?>" value="<?= $Boya_Siparis_ID ?>">

                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <input type="date" class="form-control focus temizle Uretim_T<?= $id ?>" value="<?= $UT ?>">
                                                        <label>Üretim Tarihi</label>
                                                        <div class="text-danger TarihHata Hata"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <input type="number" class="form-control temizle GirMiktar<?= $id ?>" required>
                                                        <label>Miktar</label>
                                                        <div class="text-danger MiktarHata Hata"></div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-floating">
                                                        <input type="date" class="form-control T_Tarihi<?= $id ?>" value="<?= $tarih ?>">
                                                        <label>Teslim Tarihi</label>
                                                    </div>
                                                </div>

                                                <div class="text-center">
                                                    <label class="form-check-label">
                                                        <input class="form-check-input TumuGeldi" type="checkbox" BoyaStokID="<?= $id ?>">
                                                        Tamamı Geldi
                                                    </label>
                                                </div>
                                                </form>
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" class="btn btn-success form-control Gelen" BoyaStokID="<?= $id ?>">Stoğa Ekle</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
<script>
    $('.datatablem').DataTable({
        order: [
            [11, 'DESC']
        ],
        responsive: true,
        columnDefs: [{
            "visible": false,
            "targets": [0, 1, 2, 8, 10]
        }, {
            targets: "_all",
            orderable: false
        }],
        pageLength: 100,
        lengthMenu: [
            [25, 50, 100, -1],
            ['25 Adet', '50 Adet', '100 Adet', 'Tümü']
        ],
    });
</script>
<?php
require __DIR__ . '/ajax.php';
require __DIR__ . '/../controller/Footer.php';
?>