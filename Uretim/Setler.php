<?php
$page = "Devam eden";
if (isset($_SESSION["Set_ID"])) {
    unset($_SESSION["Set_ID"]);
}
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Sil.php';
@$Sec = $_GET["Sec"];
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card">
                            <div class="yaz"></div>
                            <div class="card-body">
                                <h5 class="card-title"><?= $page ?></h5>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <a href="SetlerKayit.php<?=$Sec=="true"?'?Sec=true':"" ?>" class="btn btn-info me-3 bi-bricks">&nbsp Yeni Set</a>
                                        <a href="UrunTasarla/UrunTasarla.php<?=$Sec=="true"?'?Sec=true':"" ?>" class="btn btn-primary bi-hammer">&nbsp Ürün Tasarla</a>
                                    </div>
                                    <div class="col-md-6 justify-content-end d-flex">
                                        <button type="button" id="Sec" class="btn btn-success bi-check2 col-md-3" <?=$Sec=="true"?"":"hidden"?>>&nbsp Tamam</button>
                                    </div>
                                </div>
                                <hr>
                                <table class="table datatablem">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Set ID</th>
                                        <th>Set</th>
                                        <th>Durum</th>
                                        <th>&nbsp</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sorgu = $baglanti->query('SELECT Set_ID, SetAdi, Set_icerik_ID FROM view_uretim_setler INNER JOIN set_icerik ON view_uretim_setler.Set_Urun_ID = set_icerik.Set_Urun_ID');
                                    foreach ($sorgu as $sonuc) {
                                        $id = $sonuc['Set_icerik_ID'];
                                        $Set_ID = $sonuc['Set_ID'];
                                        $SetAdi = $sonuc['SetAdi'];
                                        ?>
                                        <tr>
                                            <td><?= $id ?></td>
                                            <td><?= $Set_ID ?></td>
                                            <td>
                                                <a href="SetKontrol/SetKontrol.php?SetAdi=<?= $SetAdi ?>&Set_ID=<?= $Set_ID ?>"
                                                   class="btn form-control text-start mt-1"><?= $SetAdi ?></a>
                                            </td>
                                            <td>
                                                <div class="progress mt-2" style="height: 25px;">
                                                    <div class="progress-bar" role="progressbar" style="width: 50%"
                                                         aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%
                                                    </div>
                                                </div>

                                            </td>

                                            <td>
                                                <?php if ($Sec=="true") {
                                                    echo "<div class='form-check'><input class='form-check-input' type='checkbox' id='Check$Set_ID' Seticerik='$id' value='$Set_ID'><label class='form-check-label fw-bold' for='Check$Set_ID'>SEÇ</label></div>";
                                                }else{
                                                    echo "<a href='Setler.php?UretimSetlerSil=$id&Set_ID=$Set_ID' class='bi-x-square btn btn-danger'></a>";
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
                {visible: false, targets: [0, 1]},
                {targets: 4, orderable: false}
            ],
            pageLength: 100,
            lengthMenu: [[25, 50, 100, -1],
                ['25 Adet', '50 Adet', '100 Adet', 'Tümü'],
            ],
        });

        //Seçilen Setleri array olarak sessiona post ediyoruz herşey bu sayfada

        $('#Sec').click(function (){
            var Setsec = [];
            $("input:checkbox:checked").map(function () {
                Setsec.push($(this).val());
            });
            var Seticerik = [];
            $("input:checkbox:checked").map(function () {
                Seticerik.push($(this).attr("Seticerik"));
            });
            $.ajax({
                type: "POST",
                url: "Setler.php",
                data: {'Setsec': Setsec,"Seticerik":Seticerik},
                error: function (xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function () {
                    window.location.assign("../Pazarlama/Teklifler/TeklifVer.php")
                }
            })
        });
    </script>
<?php
ob_end_flush();
require __DIR__ . '/../controller/Footer.php';

if (isset($_POST["Setsec"])){
    $_SESSION["Seticerik"]=$_POST["Seticerik"];
    $_SESSION["Setler"]=$_POST["Setsec"];
}
?>