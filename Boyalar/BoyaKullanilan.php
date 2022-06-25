<?php
$page = "Boya Kullan";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/VTHataMesaji.php';
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title"><?= $page ?></h5>
                        <hr>
                        <a href="BoyaStok.php" class="btn btn-secondary bi-arrow-left-circle">&nbsp Geri Dön</a>
                        <hr>
                        <table class="table datatablem">
                            <thead>
                                <tr class="table-light">
                                    <th>#</th>
                                    <th>Marka</th>
                                    <th>Renk</th>
                                    <th>Seri</th>
                                    <th>UT</th>
                                    <th>Sipariş</th>
                                    <th>Stok</th>
                                    <th>Kulanma Tarihi</th>
                                    <th>Kullanılan</th>
                                    <th>&nbsp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sorgu = $baglanti->query('SELECT Boya_Stok_ID,Marka,Renk,Seri,Kod,Uretim_T,Siparis_Miktar,Agirlik FROM view_siparis_boya WHERE Agirlik>Siparis_Miktar OR Siparis_Miktar=0');
                                foreach ($sorgu as $sonuc) {
                                    $id = $sonuc['Boya_Stok_ID'];
                                    $Marka = $sonuc['Marka'];
                                    $Renk = $sonuc['Renk'];
                                    $Seri = $sonuc['Seri'];
                                    $UT = $sonuc['Uretim_T'];
                                    $Siparis_Miktar = $sonuc['Siparis_Miktar'];
                                    $sorguS = $baglanti->query('SELECT SUM(Stok_Miktar) AS SumStok_Miktar FROM boya_gelen WHERE Boya_Stok_ID=' . $id);
                                    foreach ($sorguS as $sonuc2) {
                                        $Stok_Miktar = $sonuc2['SumStok_Miktar'];
                                        $sorguT = $baglanti->query('SELECT SUM(Kullanilan_Miktar) AS SumKullanilan_Miktar FROM boya_giden WHERE Boya_Stok_ID=' . $id);
                                        foreach ($sorguT as $sonuc3) {
                                            $K_Miktar = $sonuc3["SumKullanilan_Miktar"];?>
                                            <tr>
                                                <td><?= $id ?></td>
                                                <td><?= $Stok_Miktar < 1 ? "<span class='text-black-50'>" . $Marka . "</span>" : $Marka ?></td>
                                                <td><?= $Stok_Miktar < 1 ? "<span class='text-black-50'>" . $Renk . "</span>" : $Renk ?></td>
                                                <td><?= $Stok_Miktar < 1 ? "<span class='text-black-50'>" . $Seri . "</span>" : $Seri ?></td>
                                                <td><?= $UT ?></td>
                                                <td><?= $Siparis_Miktar ?></td>
                                                <td><?= $Stok_Miktar ?></td>
                                                <td><?php
                                                    $sorguT = $baglanti->query('SELECT Gidis_Tarihi FROM boya_giden WHERE Boya_Stok_ID=' . $id);
                                                    foreach ($sorguT as $sonuc3) {
                                                        echo $Stok_Miktar < 1 ? "<span class='text-black-50'>" . $sonuc3["Gidis_Tarihi"] . "</span><br>" : $sonuc3["Gidis_Tarihi"] . "<br>";
                                                    } ?>
                                                </td>
                                                <td><?= $Stok_Miktar > 0 ? ($K_Miktar == null ? "Geldi" : $K_Miktar . " Kg Kullanıldı") : ($Siparis_Miktar > 0 ? "<span class='text-black-50'>Sipariş Edildi</span>" : "<span class='text-black-50'>Tükendi</span>");
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($Stok_Miktar > 0) {
                                                        echo "<button type='button' class='btn btn-outline-dark bi-tropical-storm'
                                                            data-bs-toggle='modal'
                                                            data-bs-target='#Kullan$id'> Kullan</button>";
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <div class="modal fade" id="Kullan<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"><?= $Stok_Miktar == null ? 0 : $Stok_Miktar ?>
                                                                Kg Stoktan &nbsp
                                                                <i class="bi bi-tropical-storm "></i>
                                                                &nbsp <?= $K_Miktar == null ? 0 : $K_Miktar ?> Kg
                                                                Kullanıldı
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <div class="modal-body row g-3">
                                                            <input type="hidden" class="KStokMiktar<?= $id ?>" value="<?= $Stok_Miktar > 0 ? $Stok_Miktar : 0 ?>" />

                                                            <input type="hidden" class="K_Miktar<?= $id ?>" value="<?= $K_Miktar > 0 ? $K_Miktar : 0 ?>">

                                                            <div class="col-md-12">
                                                                <div class="form-floating">
                                                                    <input type="number" class="form-control" value="<?= $sonuc['Kod'] ?>" disabled>
                                                                    <label>Kod</label>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-floating">
                                                                    <input type="number" class="form-control focus KGirMiktar<?= $id ?>">
                                                                    <label>Miktar</label>
                                                                    <div class="text-danger KMiktarHata<?= $id ?>"></div>
                                                                </div>
                                                            </div>

                                                            <div class="col-md-12">
                                                                <div class="form-floating">
                                                                    <input type="date" class="form-control Kullanma_T<?= $id ?>" value="<?php
                                                                                                                                        date_default_timezone_set('Europe/Istanbul');
                                                                                                                                        $tarih = new DateTime("now");
                                                                                                                                        $tarih = date("Y-m-d");
                                                                                                                                        echo $tarih;
                                                                                                                                        ?>" required>
                                                                    <label for="t">Kullanma Tarihi</label>
                                                                </div>
                                                            </div>

                                                            <div class="text-center">
                                                                <label class="form-check-label">
                                                                    <input class="form-check-input TumunuKullan" type="checkbox" BoyaStokID="<?= $id ?>">
                                                                    Tümünü Kullan
                                                                </label>
                                                            </div>

                                                        </div>
                                                        <div class="card-footer">
                                                            <button type="button" class="btn btn-success form-control Kullan" BoyaStokID="<?= $id ?>">Kullan
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                <?php
                                        }
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    $('.datatablem').DataTable({
        order: [
            [9, 'ASC']
        ],
        responsive: true,
        columnDefs: [{
                "visible": false,
                "targets": [0, 4, 5, 6, 7]
            },
            {
                targets: 9,
                orderable: false
            },
        ],
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