<?php
$page = "Pres";
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
                    <div class="veri"></div>
                        <h5 class="card-title"><?= $page ?></h5>
                        <hr>
                        <div class="d-flex justify-content-start">
                            <a href="LevhaStok.php" class="btn btn-secondary bi-arrow-left-circle me-3">&nbsp Geri Dön</a>
                            <div class="col-md-4">
                                <select class="form-select" id="SetSec">
                                    <option value=""> * Seçiniz</option>
                                    <?php
                                    $q=$baglanti->query("SELECT * FROM `set`");
                                    foreach ($q as $e) {
                                        echo"<option value='$e[Set_ID]'>$e[SetAdi]</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <hr>
                        <table class="table datatablem">
                            <thead>
                                <tr class="table-light">
                                    <th>#</th>
                                    <th>Ürün</th>
                                    <th>Preslenen</th>
                                    <th>&nbsp</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                date_default_timezone_set('Europe/Istanbul');
                                $tarih = new DateTime("now");
                                $tarih = date("Y-m-d");
                                $Stok_Adet=0;
                                $a=isset($_GET["SetID"])?"$_GET[SetID]":0;
                                $sorgu = $baglanti->query('SELECT urun.Urun_ID AS UrunID,UrunAdi, Preslenen FROM set_urunler_asama INNER JOIN urun ON set_urunler_asama.Urun_ID = urun.Urun_ID WHERE Set_ID = '.$a);
                                if ($sorgu->rowCount()) {
                                    foreach ($sorgu as $sonuc) {
                                        $id = $sonuc['UrunID'];
                                        $UrunAdi = $sonuc['UrunAdi'];
                                        $Preslenen = $sonuc['Preslenen'];
                                ?>
                                        <tr>
                                            <td><?=$id?></td>
                                            <td><?=$UrunAdi?></td>
                                            <td><?=$Preslenen?></td>
                                            <td><button type='button' class='btn btn-outline-dark bi-tropical-storm' id='Kullan' data-bs-toggle='modal' data-bs-target='#Kullan<?=$id?>'> Kullan</button></td>
                                        </tr>
                                        <!-- Modal -->
                                        <div class="modal fade" id="Kullan<?=$id?>">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"><?=$Stok_Adet?> Adet Stok</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>

                                                    <div class="modal-body row g-3">

                                                        <div class="col-md-12">
                                                            <div class="form-floating">
                                                                <input type="number" class="form-control temizle GirAdet<?=$id?>">
                                                                <label>Adet</label>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-12">
                                                            <div class="form-floating">
                                                                <input type="date" class="form-control KTarihi<?= $id ?>" value="<?=$tarih?>">
                                                                <label>Tarih</label>
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="card-footer">
                                                        <button type="button" class="btn btn-primary form-control Kullan" levhastokid="<?=$id?>">Kaydet</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Modal SON -->
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
        order: [
            [3, 'DESC']
        ],
        responsive: true,
        columnDefs: [{
                "visible": false,
                "targets": 0
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
    $("#SetSec").change(function(){
        window.location.assign("SetPres.php?SetID="+$(this).val()+"");
    });
</script>
<?php
require __DIR__ . '/../controller/Footer.php';
?>