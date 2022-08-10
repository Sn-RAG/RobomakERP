<?php
$page = "Firmalar";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Sil.php';
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card recent-sales overflow-auto">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><?= $page ?></h5>
                            <hr>
                            <a href="FirmaEkle.php" class="btn btn-primary bi-save">&nbsp Yeni Firma</a>
                            <hr>
                            <table class="table table-borderless datatablem">
                                <thead>
                                    <tr>
                                        <th>Firma</th>
                                        <th>V.D</th>
                                        <th>Vergi_No</th>
                                        <th>Ülke</th>
                                        <th>Şehir</th>
                                        <th>&nbsp</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $sorgu = $baglanti->query('SELECT * FROM view_firmalar');
                                    foreach ($sorgu as $s) {
                                        $id = $s['Firma_ID'];
                                        $Adres_ID = $s['Adres_ID'];
                                        $Tel_ID = $s['Tel_ID'];
                                    ?>
                                        <tr>
                                            <td><?= $s['Firma'] ?></td>
                                            <td><?= $s['VD'] ?></td>
                                            <td><?= $s['Vergi_No'] ?></td>
                                            <td><?= $s['Ulke'] ?></td>
                                            <td><?= $s['Sehir'] ?></td>
                                            <td>
                                                <?= "<a href='FirmaDuzenle.php?id=$id&Adres_ID=$Adres_ID&Tel_ID=$Tel_ID' class='btn btn-warning bi-pencil-square'></a>
                                                <a href='Firmalar.php?FirmalarSil=$id&Adres_ID=$Adres_ID&Tel_ID=$Tel_ID' class='btn btn-danger bi-x-square'></a>" ?>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    $('.datatablem').DataTable({
        responsive: true,
        pageLength: 100,
        lengthMenu: [
            [25, 50, 100, -1],
            ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
        ]
    });
</script>
<?php
require __DIR__ . '/../controller/Footer.php';
ob_end_flush();
?>