<?php
$page = "Teklifler";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Sil.php';
unset($_SESSION["SeticerikID"], $_SESSION["Setler"], $_SESSION["FirmaID"], $_SESSION["FirmaAdi"], $_SESSION["SetAdi"]);
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= $page ?></h5>
                                <a href="TeklifVer.php">
                                    <button class="btn btn-primary">Teklif Ver</button>
                                </a>

                                <button class="btn btn-primary dropdown-toggle" type="button" id="dropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    Firmalar
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="dropdown">
                                    <li><a class="hover dropdown-item" href="../../Firmalar/Firmalar.php">Firmalar</a>
                                    </li>
                                    <li><a class="hover dropdown-item" href="../../Firmalar/FirmaEkle.php">Firma
                                            Ekle</a></li>
                                </ul>

                                <hr>

                                <table class="table table-bordered datatable">
                                    <thead>
                                    <tr class="table-light">
                                        <th scope="col">Firma</th>
                                        <th scope="col" class="text-center">Setler</th>
                                        <th scope="col">Teslim Tarihi</th>
                                        <th>&nbsp</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sorgu2 = $baglanti->query('SELECT * FROM view_teklifler');
                                    foreach ($sorgu2 as $sonuc) {
                                        $id = $sonuc['Teklif_ID'];
                                        $Firma_ID = $sonuc['Firma_ID'];
                                        $Teklif_Set_ID = $sonuc['Teklif_Set_ID'];
                                        $Uretim_Setler_ID = $sonuc['Set_icerik_ID'];
                                        $Set_ID = $sonuc['Set_ID'];
                                        $SetAdi = $sonuc['SetAdi'];
                                        $Adet = $sonuc['Adet'];
                                        $Teslim_Tarihi = $sonuc['Teslim_Tarihi'];
                                        $Firma = $sonuc['Firma'];
                                        $YetkiliAdi = $sonuc['YetkiliAdi'];
                                        $YetkiliTel = $sonuc['YetkiliTel'];
                                        $Urun_ID = $sonuc['Urun_ID'];
                                        $Kullanici_ID = $sonuc['Kullanici_ID'];
                                        $AdSoyad = $sonuc['AdSoyad'];
                                        $Duzenleme_Tarihi = $sonuc['Duzenleme_Tarihi'];
                                        $S_No = $sonuc['S_No'];
                                        ?>
                                        <tr>
                                            <th hidden><?= $id ?></th>
                                            <td hidden><?= $Firma_ID ?></td>
                                            <td hidden><?= $Teklif_Set_ID ?></td>
                                            <th hidden><?= $Uretim_Setler_ID ?></th>
                                            <td hidden><?= $Set_ID ?></td>
                                            <th hidden><?= $YetkiliAdi ?></th>
                                            <td hidden><?= $YetkiliTel ?></td>
                                            <td hidden><?= $Urun_ID ?></td>
                                            <td hidden><?= $Kullanici_ID ?></td>
                                            <td hidden><?= $AdSoyad ?></td>
                                            <td hidden><?= $Duzenleme_Tarihi ?></td>
                                            <td><?= $Firma ?></td>
                                            <td>
                                                <ol class='list-group list-group-numbered'>
                                                    <?php
                                                    $Ad = $baglanti->query("SELECT * FROM view_teklifler_set_listele WHERE S_No=" . $S_No);
                                                    foreach ($Ad as $Adi) {
                                                        ?>
                                                        <li class='list-group-item d-flex justify-content-between align-items-start'>
                                                            <div class='ms-2 me-auto small'>
                                                                <?= "<button class='btn btn-sm bg-light' data-bs-toggle='modal'
                                                        data-bs-target='#UrunBilgi$Adi[Set_ID]'>$Adi[SetAdi]</button>" ?>

                                                            </div>
                                                            <span class='badge bg-primary rounded-pill small'><?= $Adi['Adet'] ?> - Adet</span>
                                                        </li>
                                                        <?php
                                                        require __DIR__ . '/UrunBilgi.php';
                                                    } ?>
                                                </ol>
                                            </td>
                                            <td><?= $Teslim_Tarihi ?></td>
                                            <td>
                                                <button type="button" class="btn btn-info bi-info-circle" data-bs-toggle="modal"
                                                        data-bs-target="#Bilgi<?= $id ?>">
                                                </button>
                                                <a href="Teklifler.php?TeklifSil=<?= $id ?>&S_No=<?= $S_No ?>" class="btn btn-danger bi-x-square">
                                                </a>
                                            </td>
                                        </tr>
                                        <?php
                                        require __DIR__ . '/TeklifBilgi.php';
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
    </main><!-- End #main -->
<?php
ob_end_flush();
require __DIR__ . '/../../controller/Footer.php';
?>