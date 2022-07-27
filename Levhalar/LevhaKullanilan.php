<?php
$page = "Kullanılan Levha";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/VTHataMesaji.php';
?>
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title border-bottom mb-3"><?= $page ?></h5>
                <a href="LevhaStok.php" class="btn btn-secondary bi-arrow-left-circle">&nbsp Geri Dön</a>
                <hr>
                <table class="table datatablem">
                    <thead>
                        <tr class="table-light">
                            <th>#</th>
                            <th>Levha_ID</th>
                            <th>Tip</th>
                            <th>Çap</th>
                            <th>Kalınlık</th>
                            <th>Sipariş</th>
                            <th>Stok Ağırlık</th>
                            <th>Kullanılan</th>
                            <th>Kulanma Tarihi</th>
                            <th>&nbsp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sorgu = $baglanti->query('SELECT Levha_Stok_ID,Levha_ID,Tip,Cap,Kalinlik,Siparis_Adet,Siparis_Agirlik FROM view_siparis_levha');
                        foreach ($sorgu as $sonuc) {
                            $id = $sonuc['Levha_Stok_ID'];
                            $Levha_ID = $sonuc['Levha_ID'];
                            $Tip = $sonuc['Tip'];
                            $Cap = $sonuc['Cap'];
                            $Kalinlik = $sonuc['Kalinlik'];
                            $Siparis_Adet = $sonuc['Siparis_Adet'];
                            $Siparis_Agirlik = $sonuc['Siparis_Agirlik'];

                            $sorguS = $baglanti->query('SELECT SUM(Stok_Adet) AS Adet,SUM(Stok_Agirlik) AS Agirlik FROM levha_gelen WHERE Levha_Stok_ID=' . $id);
                            foreach ($sorguS as $sonuc2) {
                                $Stok_Agirlik = $sonuc2['Agirlik'];
                                $Stok_Adet = $sonuc2['Adet'];

                                $sorguK = $baglanti->query('SELECT SUM(Kullanilan_Adet) AS Adet,SUM(Kullanilan_Agirlik) AS Agirlik FROM levha_giden WHERE Levha_Stok_ID=' . $id);
                                foreach ($sorguK as $sonuc3) {
                                    $K_Agirlik = $sonuc3['Agirlik'];
                                    $K_Adet = $sonuc3['Adet'];
                        ?>
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><?= $Levha_ID ?></td>
                                        <td><?= $Stok_Agirlik < 1 ? "<span class='text-black-50'>" . $Tip . "</span>" : $Tip ?></td>
                                        <td><?= $Stok_Agirlik < 1 ? "<span class='text-black-50'>" . $Cap . "</span>" : $Cap ?></td>
                                        <td><?= $Stok_Agirlik < 1 ? "<span class='text-black-50'>" . $Kalinlik . "</span>" : $Kalinlik ?></td>
                                        <td><?= $Siparis_Agirlik . " - " . $Siparis_Adet ?></td>
                                        <td><?= $Stok_Agirlik . " - " . $Stok_Adet ?></td>
                                        <td><?= $Stok_Agirlik > 0 ? ($K_Agirlik == null ? "Geldi" : $K_Agirlik . " Kg Kullanıldı") : ($Siparis_Agirlik > 0 ? "<span class='text-black-50'>Sipariş Edildi</span>" : "<span class='text-black-50'>Tükendi</span>");
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                            $sorguK = $baglanti->query('SELECT Gidis_Tarihi FROM levha_giden WHERE Levha_Stok_ID=' . $id);
                                            foreach ($sorguK as $sonuc3) {
                                                echo $Stok_Agirlik < 1 ? "<span class='text-black-50'>" . $sonuc3["Gidis_Tarihi"] . "</span><br>" : $sonuc3["Gidis_Tarihi"] . "<br>";
                                            }
                                            ?>
                                        </td>
                                        <td><?= $Stok_Agirlik < 1 ? "" : "<button type='button' class='btn btn-outline-dark bi-tropical-storm' id='Kullan' data-bs-toggle='modal' data-bs-target='#Kullan$id'> Kullan</button>"; ?></td>
                                    </tr>
                                    <!-- Modal -->
                                    <div class="modal fade" id="Kullan<?= $id ?>" name="kullan">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title"><?= $Stok_Agirlik == null ? 0 : $Stok_Agirlik ?>
                                                        Kg Stoktan &nbsp
                                                        <i class="bi bi-tropical-storm "></i>
                                                        &nbsp <?= $K_Agirlik == null ? 0 : $K_Agirlik ?> Kg
                                                        Kullanıldı
                                                    </h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>

                                                <div class="modal-body row g-3">

                                                    <div class="col-md-4" hidden>
                                                        <div class="form-floating">
                                                            <input class="form-control" value="<?= $Tip ?>" readonly>
                                                            <label>Tip</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4" hidden>
                                                        <div class="form-floating">
                                                            <input class="form-control Cap<?= $id ?>" value="<?= $Cap ?>" readonly>
                                                            <label>Çap</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4" hidden>
                                                        <div class="form-floating">
                                                            <input class="form-control Kalinlik<?= $id ?>" value="<?= $Kalinlik ?>" readonly>
                                                            <label>Kalınlık</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-floating">
                                                            <input type="number" class="form-control temizle GirAdet<?= $id ?>" readonly>
                                                            <label>Adet</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-floating">
                                                            <input type="number" class="form-control focus temizle GirAgirlikk" id="GirAgirlik<?= $id ?>" levhastokid="<?= $id ?>">
                                                            <label>Ağırlık</label>
                                                        </div>
                                                        <div class="Hata text-danger py-1"></div>
                                                    </div>

                                                    <div class="col-md-12">
                                                        <div class="form-floating">
                                                            <input type="date" class="form-control KTarihi<?= $id ?>" value="<?php
                                                                                                                                date_default_timezone_set('Europe/Istanbul');
                                                                                                                                $tarih = new DateTime("now");
                                                                                                                                $tarih = date("Y-m-d");
                                                                                                                                echo $tarih;
                                                                                                                                ?>" required>
                                                            <label>Tarih</label>
                                                        </div>
                                                    </div>

                                                    <div class="text-center">
                                                        <label class="form-check-label">
                                                            <input class="form-check-input TumunuKullan" type="checkbox" id="<?= $id ?>">
                                                            Tümünü Kullan
                                                        </label>
                                                    </div>

                                                    <input type="hidden" class="StokAgirlik<?= $id ?>" value="<?= $Stok_Agirlik > 0 ? $Stok_Agirlik : 0 ?>" />

                                                    <input type="hidden" class="StokAdet<?= $id ?>" value="<?= $Stok_Adet > 0 ? $Stok_Adet : 0 ?>" />
                                                    <input type="hidden" class="KAdet<?= $id ?>" value="<?= $K_Adet > 0 ? $K_Adet : 0 ?>" />
                                                    <input type="hidden" class="KAgirlik<?= $id ?>" value="<?= $K_Agirlik > 0 ? $K_Agirlik : 0 ?>" />
                                                </div>
                                                <div class="card-footer">
                                                    <button type="button" class="btn btn-primary form-control Kullan" levhastokid="<?= $id ?>">Kullan
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal SON -->
                        <?php }
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
<script>
    $('.datatablem').DataTable({
        order: [
            [9, 'DESC']
        ],
        responsive: true,
        columnDefs: [{
                "visible": false,
                "targets": [0, 1, 5, 6, 8]
            },
            {
                targets: "_all",
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