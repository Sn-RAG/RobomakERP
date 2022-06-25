<?php
$page = "Boya Stok";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card-body">
                        <h5 class="card-title"><?= $page ?></h5>
                        <hr>
                        <a href="BoyaGelen.php" class="btn btn-outline-primary bi-strava me-3">&nbsp Sipariş Durumu
                        </a>
                        <a href="BoyaKullanilan.php" class="btn btn-outline-primary bi-tropical-storm">&nbsp Boya
                            Kullan
                        </a>
                        <hr>
                        <table class="table datatablem">
                            <thead>
                                <tr class="table-light">
                                    <th>#</th>
                                    <th>Marka</th>
                                    <th>Renk</th>
                                    <th>Seri</th>
                                    <th>Stok</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $sorgu = $baglanti->query('SELECT Boya_Stok_ID,Boya_ID,Marka,Renk,Seri FROM view_siparis_boya GROUP BY Boya_ID');
                                foreach ($sorgu as $sonuc) {
                                    $id = $sonuc['Boya_Stok_ID'];
                                    $Boya_ID = $sonuc['Boya_ID'];
                                    $Marka = $sonuc['Marka'];
                                    $Renk = $sonuc['Renk'];
                                    $Seri = $sonuc['Seri'];
                                    $sorguS = $baglanti->query('SELECT SUM( boya_gelen.Stok_Miktar ) AS Miktar FROM boya_siparis 
                                                                INNER JOIN boya_stok ON boya_siparis.Boya_Stok_ID = boya_stok.Boya_Stok_ID 
                                                                INNER JOIN boya_gelen ON boya_stok.Boya_Stok_ID = boya_gelen.Boya_Stok_ID WHERE boya_siparis.Boya_ID =' . $Boya_ID);
                                    foreach ($sorguS as $sonuc2) {
                                        $Stok_Miktar = $sonuc2['Miktar'];?>
                                        <tr>
                                            <th><?= $id ?></th>
                                            <td><?= $Marka ?></td>
                                            <td><?= $Renk ?></td>
                                            <td><?= $Seri ?></td>
                                            <td><?= $Stok_Miktar > 0 ? $Stok_Miktar . " Kg" : "<span class='text-warning fw-bold'>Tükendi</span>" ?></td>
                                        </tr>
                                <?php
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
        responsive: true,
        columnDefs: [{
            "visible": false,
            "targets": [0]
        }],
        pageLength: 100,
        lengthMenu: [
            [25, 50, 100, -1],
            ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
        ]
    });
</script>
<?php
require __DIR__ . '/../controller/Footer.php';
?>