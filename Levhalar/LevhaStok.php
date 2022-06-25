<?php
$page = "Levha Stok";
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
                            <a href="LevhaGelen.php" class="btn btn-outline-primary bi-strava me-3">&nbsp Sipariş Durumu
                            </a>
                            <a href="LevhaKullanilan.php" class="btn btn-outline-primary bi-tropical-storm">&nbsp Levha
                                Kullan
                            </a>
                            <hr>
                            <table class="table datatablem">
                                <thead>
                                <tr class="table-light">
                                    <th>#</th>
                                    <th>Tip</th>
                                    <th>Çap</th>
                                    <th>Kalınlık</th>
                                    <th>Stok Adet</th>
                                    <th>Stok Ağırlık</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sorgu = $baglanti->query('SELECT Levha_Stok_ID,Levha_ID,Tip,Cap,Kalinlik,Siparis_Adet,Siparis_Agirlik FROM view_siparis_levha GROUP BY Levha_ID');
                                foreach ($sorgu as $sonuc) {
                                    $id = $sonuc['Levha_Stok_ID'];
                                    $Levha_ID = $sonuc['Levha_ID'];
                                    $Tip = $sonuc['Tip'];
                                    $Cap = $sonuc['Cap'];
                                    $Kalinlik = $sonuc['Kalinlik'];
                                    $Siparis_Adet = $sonuc['Siparis_Adet'];
                                    $Siparis_Agirlik = $sonuc['Siparis_Agirlik'];

                                    $sorguS = $baglanti->query('SELECT SUM( Stok_Adet ) AS SumStok_Adet, SUM( Stok_Agirlik ) AS SumStok_Agirlik FROM levha_siparis 
                                                                        INNER JOIN levha_stok ON levha_siparis.Levha_Stok_ID = levha_stok.Levha_Stok_ID
                                                                        INNER JOIN levha_gelen ON levha_stok.Levha_Stok_ID = levha_gelen.Levha_Stok_ID WHERE Levha_ID =' . $Levha_ID);
                                    foreach ($sorguS as $sonuc2) {
                                        $Stok_Adet = $sonuc2['SumStok_Adet'];
                                        $Stok_Agirlik = $sonuc2['SumStok_Agirlik'];
                                        ?>
                                        <tr>
                                            <td><?= $id ?></td>
                                            <td><?= $Tip ?></td>
                                            <td><?= $Cap ?></td>
                                            <td><?= $Kalinlik ?></td>
                                            <td><?= $Stok_Agirlik > 0 ? $Stok_Agirlik . " Kg" : 0 . " Kg" ?></td>
                                            <td><?= $Stok_Adet > 0 ? $Stok_Adet . " Kg" : 0 . " Kg" ?></td>
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
            columnDefs: [
                {"visible": false, "targets": 0}
            ],
            pageLength: 100,
            lengthMenu: [[25, 50, 100, -1],
                ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
            ]
        });
    </script>
<?php
ob_end_flush();
require __DIR__ . '/../controller/Footer.php';
?>