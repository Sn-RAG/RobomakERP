<?php
ob_start();
$page = "Sipariş Listesi";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Kayit.php';
?>
    <main id="main" class="main">
        <section class="section">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card recent-sales overflow-auto">
                        <div class="card-body">
                            <h5 class="card-title"><?= $page ?></h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-6">
                            <a href="BoyaSiparis.php" class="btn btn-secondary bi-arrow-left-circle"> Geri Dön</a>
                                </div>
                            <div class="row col-md-6" <?=isset($_GET["Yazdir"])?"hidden":""?>>
                                <label for="inputDate" class="col-sm-6 col-form-label text-end">Sipariş Tarihi</label>
                                <div class="col-sm-6">
                                    <input type="date" class="form-control tarih" value="<?php
                                    date_default_timezone_set('Europe/Istanbul');
                                    $tarih = new DateTime("now");
                                    $tarih = date("Y-m-d");
                                    echo $tarih;
                                    ?>">
                                </div>
                            </div>
                            </div>
                            <hr>
                            <table class="table datatablem">
                                <thead>
                                <tr>
                                    <?=isset($_GET["Yazdir"])?"":"<th>#</th>"?>
                                    <th>Marka</th>
                                    <th>Renk</th>
                                    <th>Seri</th>
                                    <th>Kod</th>
                                    <?=isset($_GET["Yazdir"])?"":"<th><button type='button' class='btn btn-primary bi-calendar-minus form-control BoyaSiparisEt'>&nbsp Sipariş</button></th>"?>
                                    <?=isset($_GET["Yazdir"])?"<th>Miktar</th>":""?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if (isset($_SESSION["Boyalar"])) {
                                    $S=count($_SESSION["Boyalar"]);

                                    for( $i=0; $i<$S; $i++ ){
                                        $sorgu = $baglanti->query('SELECT * FROM boya WHERE Boya_ID=' . $_SESSION["Boyalar"][$i]);
                                        foreach ($sorgu as $sonuc) {
                                            $id = $sonuc['Boya_ID'];
                                            $Marka = $sonuc['Marka'];
                                            $Renk = $sonuc['Renk'];
                                            $Seri = $sonuc['Seri'];
                                            $Kod = $sonuc['Kod'];
                                            ?>
                                            <tr>
                                                 <?=isset($_GET["Yazdir"])?"":"<td><?= $id ?></td>"?>
                                                <td><?= $Marka ?></td>
                                                <td><?= $Renk ?></td>
                                                <td><?= $Seri ?></td>
                                                <td><?= $Kod ?></td>
                                                <?=isset($_GET["Yazdir"])?"":"<td><input type='number' class='form-control Miktar' placeholder='Miktar Giriniz'></td>"?>
                                                <?=isset($_GET["Yazdir"])?"<td>".$_SESSION["Miktar"][$i]."</td>":""?>
                                            </tr>
                                            <?php
                                        }
                                    }
                                }
                                ?>
                                </tbody>
                            </table>
                            <div class="yaz"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <script>
        <?php
        if (isset($_GET["Yazdir"])){
            echo "$('.datatablem').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel', 'pdf', 'print'],
            bFilter:false,
            responsive: true
        });";
        }else{
            echo "$('.datatablem').DataTable({
            responsive: true,
            columnDefs: [
                {'visible': false, 'targets': 0},
                {targets: '_all', orderable: false},
                {'width': '20%', 'targets': 5}
            ],
            paging:false,
            bFilter:false,
        });";
        }
        ?>
    </script>
<?php
require __DIR__ . '/AjaxForm/Ajax.php';
require __DIR__ . '/../../controller/Footer.php';
if (isset($_POST["Miktar"])){
    $_SESSION["Miktar"]  =$_POST["Miktar"];
}
?>