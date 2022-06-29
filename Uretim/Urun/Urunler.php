<?php
$page = "Ürünler";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card recent-sales overflow-auto">

                    <div class="card-body">
                        <h5 class="card-title"><?= $page ?></h5>
                        <hr>
                        <a href="UrunEkle.php" class="btn btn-primary bi-save">&nbsp Yeni Kayıt</a>
                        <hr>
                        <table class="table table-bordered datatablem">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>#</th>
                                    <th>Kategori Adı</th>
                                    <th>Ürun Adı</th>
                                    <th>Ürün Hakkında</th>
                                    <th>&nbsp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sorgu = $baglanti->query("SELECT kategori.*,urun.* FROM urun INNER JOIN kategori ON urun.Kategori_ID = kategori.Kategori_ID ORDER BY Kategori_Adi ASC");
                                foreach ($sorgu as $sonuc) {
                                    $Urun_ID = $sonuc['Urun_ID'];
                                    $Kategori_ID = $sonuc['Kategori_ID'];
                                    $Kategori_Adi = $sonuc['Kategori_Adi'];
                                    $UrunAdi = $sonuc['UrunAdi'];
                                    $UrunFoto = $sonuc['UrunFoto'];
                                    $Aciklama = $sonuc['Aciklama'];
                                ?>
                                    <tr>
                                        <th><?= $Urun_ID ?></th>
                                        <th><?= $Kategori_ID ?></th>
                                        <th><?= $Kategori_Adi ?></th>
                                        <td><?= $UrunAdi ?></td>
                                        <td><?= $Aciklama ?></td>
                                        <td>
                                            <a href="../UrunLevha/UrunLevhaBilgi.php?Urun_ID=<?= $Urun_ID ?>">
                                                <button type="button" class="btn btn-info"><i class="bi bi-disc"></i> Levha Bilgisi
                                                </button>
                                            </a>
                                            <a href="../UrunBoya/UrunBoyaBilgi.php?Urun_ID=<?= $Urun_ID ?>">
                                                <button type="button" class="btn btn-info">Boya Bilgisi <i class="bi bi-brush"></i>
                                                </button>
                                            </a>
                                            <a href="UrunDuzenle.php?Urun_ID=<?= $Urun_ID ?>&Kategori_ID=<?= $Kategori_ID ?>&KategoriAdi=<?= $Kategori_Adi ?>&UrunFoto=<?= $UrunFoto ?>&UrunAdi=<?= $UrunAdi ?>&Aciklama=<?= $Aciklama ?>">
                                                <button type="button" class="btn btn-warning"><i class="bi bi-pencil-square"></i></button>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
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
        rowGroup: {
            dataSrc: [2]
        },
        responsive: true,
        columnDefs: [{
            "visible": false,
            "targets": [0, 1, 2]
        }, {
            "targets": 5,
            orderable: false
        }, {
            "width": "30%",
            "targets": 5
        }],
        pageLength: 100,
        lengthMenu: [
            [25, 50, 100, -1],
            ['25 Adet', '50 Adet', '100 Adet', 'Tümü']
        ],

    });
</script>
<?php
ob_end_flush();
require __DIR__ . '/../../controller/Footer.php';
?>