<?php
ob_start();
$page = "Boya Sipariş";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Kayit.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';

unset($_SESSION["Miktar"],$_SESSION["Boyalar"]);
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title"><?= $page ?></h5>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <a href="../../Navigasyon/SiparisEt.php" class="btn btn-secondary  bi-arrow-left-circle"> Geri Dön</a>
                                <button type="button" class="btn btn-primary bi-save" data-bs-toggle="modal" data-bs-target="#YeniBoya"> Yeni Boya</button>
                            </div>
                            <hr>
                            <table class="table datatablem">
                                <thead>
                                <tr class="table-light">
                                    <th>#</th>
                                    <th><button type="button" class="btn btn-success bi-check-lg form-control Sec">&nbsp Seç</button></th>
                                    <th>Marka</th>
                                    <th>Renk</th>
                                    <th>Seri</th>
                                    <th>Kod</th>
                                    <th>&nbsp</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $sorgu = $baglanti->query('SELECT * FROM boya')->fetchAll();
                                foreach ($sorgu as $sonuc) {
                                    $id = $sonuc['Boya_ID'];
                                    $Marka = $sonuc['Marka'];
                                    $Renk = $sonuc['Renk'];
                                    $Seri = $sonuc['Seri'];
                                    $Kod = $sonuc['Kod'];
                                    ?>
                                    <tr>
                                        <td><?= $id ?></td>
                                        <td><div class="form-check"><input class="form-check-input" type="checkbox" id="Check<?= $id ?>" value="<?= $id ?>"><label class="form-check-label" for="Check<?= $id ?>">Seç</label></div></td>
                                        <td><?= $Marka ?></td>
                                        <td><?= $Renk ?></td>
                                        <td><?= $Seri ?></td>
                                        <td><?= $Kod ?></td>
                                        <td>
                                            <!--<button type="button" class="btn btn-outline-primary bi-cart4 Siparis" id="<?= $id ?>" data-bs-toggle="modal" data-bs-target="#Siparis<?= $id ?>">&nbsp Sipariş</button>-->
                                            <button type="button" class="btn btn-outline-warning bi-pencil-fill Duzenle" id="<?= $id ?>" data-bs-toggle="modal" data-bs-target="#Siparis<?= $id ?>">&nbsp Düzenle</button>
                                        </td>
                                    </tr>
                                    <div class="modal fade" id="Siparis<?= $id ?>" tabindex="-1"
                                         aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Yeni Sipariş</h5>
                                                    <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body row g-3">

                                                    <div class="col-md-12">
                                                        <div class="form-floating">
                                                            <input type="text" id="Marka<?= $id ?>"
                                                                   value="<?= $Marka ?>"
                                                                   class="form-control">
                                                            <label>* Marka</label>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-4">
                                                        <div class="form-floating">
                                                            <input type="text" id="Renk<?= $id ?>"
                                                                   value="<?= $Renk ?>"
                                                                   class="form-control">
                                                            <label>* Renk</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-floating">
                                                            <select id="Seri<?= $id ?>" class="form-select">
                                                                <option value="<?= $Seri ?>"><?= $Seri ?></option>
                                                                <option value="Astar">Astar</option>
                                                                <option value="Üst Kat">Üst Kat</option>
                                                                <option value="Kırçıl">Kırçıl</option>
                                                                <option value="Toz Boya">Toz Boya</option>
                                                                <option value="Tek Kat">Tek Kat</option>
                                                            </select>
                                                            <label for="sec">Seri</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-floating">
                                                            <input type="text" id="Kod<?= $id ?>" value="<?= $Kod ?>"
                                                                   class="form-control">
                                                            <label>* Kod</label>
                                                        </div>
                                                    </div>
                                                    <div class="text-danger Hata"></div>
                                                </div>
                                                <div class="card-footer">
                                                    <button type="button" class="btn btn-warning form-control BoyaDuzenle" BoyaID="<?= $id ?>"> Düzenle</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
            responsive: true,
            columnDefs: [
                {"visible": false, "targets": [0,5]},
                {targets: [1,6], orderable: false},
                { "width": "20%", "targets": 6 }
            ],
            pageLength: 100,
            lengthMenu: [[25, 50, 100, -1],
                ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
            ]
        });
        $('.Sec').click(function (){
            var Sec = [];
            $("input:checkbox:checked").map(function () {
                Sec.push($(this).val());
            });
            $.ajax({
                type: "POST",
                url: "BoyaSiparis.php",
                data: {'Sec': Sec},
                error: function (xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function () {
                    window.location.assign("SiparisListesi.php")
                }
            })
        });
    </script>

    <div class="modal fade" id="YeniBoya" tabindex="-1"
         aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Yeni Boya Ekle</h5>
                    <button type="button" class="btn-close"
                            data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body row g-3">

                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" id="Marka" class="form-control focus temizle">
                            <label>* Marka</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" id="Renk"
                                   class="form-control temizle"
                                   required>
                            <label>* Renk</label>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <div class="form-floating">
                            <select class="form-select Seri">
                                <option value="Astar">Astar</option>
                                <option value="Üst Kat">Üst Kat</option>
                                <option value="Kırçıl">Kırçıl</option>
                                <option value="Toz Boya">Toz Boya</option>
                                <option value="Tek Kat">Tek Kat</option>
                                <option value="Silikon">Silikon</option>
                            </select>
                            <label>Seri</label>
                        </div>
                    </div>


                    <div class="col-md-12">
                        <div class="form-floating">
                            <input type="text" id="Kod" class="form-control temizle">
                            <label>* Kod</label>
                        </div>
                    </div>
                    <div class="text-danger Hata"></div>
                </div>
                <div class="card-footer">
                    <button type="button" id="BoyaEkle"
                            class="btn btn-primary form-control">
                        Ekle
                    </button>
                </div>
            </div>
        </div>
    </div>
<?php
require __DIR__ . '/AjaxForm/Ajax.php';
require __DIR__ . '/../../controller/Footer.php';
if (isset($_POST["Sec"])){
    $_SESSION["Boyalar"]=$_POST["Sec"];
}
?>