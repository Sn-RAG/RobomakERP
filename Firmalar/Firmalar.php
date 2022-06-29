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
                                <a href="FirmaEkle.php<?=isset($_GET["Sec"])?'?Sec=true':""?>">
                                    <button type="button" class="btn btn-primary"><i class="bi bi-save me-1"></i>
                                        Yeni Firma
                                    </button>
                                </a>
                                <hr>
                                <table class="table table-borderless datatablem">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>#</th>
                                        <th>#</th>
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
                                    foreach ($sorgu as $sonuc) {
                                        $id = $sonuc['Firma_ID'];
                                        $Adres_ID = $sonuc['Adres_ID'];
                                        $Tel_ID = $sonuc['Tel_ID'];
                                        $Firma = $sonuc['Firma'];
                                        $VD = $sonuc['VD'];
                                        $Vergi_No = $sonuc['Vergi_No'];
                                        $Ulke = $sonuc['Ulke'];
                                        $Sehir = $sonuc['Sehir'];
                                        ?>
                                        <tr>
                                            <th><?= $id ?></th>
                                            <td><?= $Adres_ID ?></td>
                                            <td><?= $Tel_ID ?></td>
                                            <td><?= $Firma ?></td>
                                            <td><?= $VD ?></td>
                                            <td><?= $Vergi_No ?></td>
                                            <td><?= $Ulke ?></td>
                                            <td><?= $Sehir ?></td>
                                            <td>
                                                <?php if (isset($_GET["Sec"])) {
                                                    echo "<a href='../Pazarlama/Teklifler/TeklifVer.php?FirmaID=$id&FirmaAdi=$Firma' class='btn btn-success bi-check-lg'> Seç</a>";
                                                }else{
                                                    echo "<a href='FirmaDuzenle.php?id=$id&Adres_ID=$Adres_ID&Tel_ID=$Tel_ID' class='btn btn-warning bi-pencil-square'></a>
                                                <a href='Firmalar.php?FirmalarSil=$id&Adres_ID=$Adres_ID&Tel_ID=$Tel_ID' class='btn btn-danger bi-x-square'></a>";
                                                }
                                                ?>
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
            </div>
        </section>
    </main>
    <script>
        $('.datatablem').DataTable({
            responsive: true,
            columnDefs: [
                {"visible": false, "targets": [0, 1, 2]}
            ],
            pageLength: 100,
            lengthMenu: [[25, 50, 100, -1],
                ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
            ]
        });
    </script>
<?php
require __DIR__ . '/../controller/Footer.php';
ob_end_flush();
?>