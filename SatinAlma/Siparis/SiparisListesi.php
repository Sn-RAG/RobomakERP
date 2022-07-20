<?php
ob_start();
$page = "Sipariş Listesi";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Kayit.php';
require __DIR__ . '/../../controller/VTHataMesaji.php';

date_default_timezone_set('Europe/Istanbul');
$tarih = new DateTime("now");
$tarih = date("Y-m-d");
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
                            <a href="<?= isset($_SESSION["Boyalar"]) ? "BoyaSiparis.php" : (isset($_SESSION["Levhalar"]) ? "LevhaSiparis.php" : "") ?>" class="btn btn-secondary bi-arrow-left-circle"> Geri Dön</a>
                            <div class="d-flex" <?= isset($_GET["YazdirBoya"]) ? "hidden" : "" ?>>
                                <label for="inputDate" class="col-form-label me-2">Sipariş Tarihi</label>
                                <div class="">
                                    <input type="date" class="form-control tarih" value="<?= $tarih ?>">
                                </div>
                            </div>
                        </div>
                        <hr>
                        <?php if (isset($_SESSION["Boyalar"])) { ?>
                            <table class="table BoyaTablo">
                                <thead>
                                    <tr>
                                        <?= isset($_GET["YazdirBoya"]) ? "" : "<th>#</th>" ?>
                                        <th>Marka</th>
                                        <th>Renk</th>
                                        <th>Seri</th>
                                        <th>Kod</th>
                                        <?= isset($_GET["YazdirBoya"]) ? "" : "<th><button type='button' class='btn btn-primary bi-calendar-minus form-control BoyaSiparisEt'>&nbsp Sipariş</button></th>" ?>
                                        <?= isset($_GET["YazdirBoya"]) ? "<th>Miktar</th>" : "" ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $S = $_SESSION["Boyalar"];

                                    for ($i = 0; $i < count($S); $i++) {
                                        $sr = $baglanti->query('SELECT * FROM boya WHERE Boya_ID=' . $S[$i]);
                                        foreach ($sr as $sn) { ?>
                                            <tr>
                                                <?= isset($_GET["YazdirBoya"]) ? "" : "<td><?= $sn[Boya_ID] ?></td>" ?>
                                                <td><?= $sn['Marka'] ?></td>
                                                <td><?= $sn['Renk'] ?></td>
                                                <td><?= $sn['Seri'] ?></td>
                                                <td><?= $sn['Kod'] ?></td>
                                                <?= isset($_GET["YazdirBoya"]) ? "" : "<td><input type='number' class='form-control Miktar' placeholder='Miktar Giriniz'></td>" ?>
                                                <?= isset($_GET["YazdirBoya"]) ? "<td>" . $_SESSION["Miktar"][$i] . "</td>" : "" ?>
                                            </tr>
                                    <?php
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        <?php } elseif (isset($_SESSION["Levhalar"])) { ?>
                            <table class="table LevhaTablo">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tip</th>
                                        <th>Çap</th>
                                        <th>Kalınlık</th>
                                        <th><button type='button' class='btn btn-primary bi-calendar-minus form-control LevhaSiparisEt'>&nbsp Sipariş</button></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $S = $_SESSION["Levhalar"];

                                    for ($i = 0; $i < count($S); $i++) {
                                        $sr = $baglanti->query('SELECT * FROM levha WHERE Levha_ID=' . $S[$i]);
                                        foreach ($sr as $sn) {
                                            $id = $sn["Levha_ID"]; ?>
                                            <tr>
                                                <td><?= $id ?></td>
                                                <td><?= $sn['Tip'] ?></td>
                                                <td id="Cap<?= $id ?>"><?= $sn['Cap'] ?></td>
                                                <td id="Kalinlik<?= $id ?>"><?= $sn['Kalinlik'] ?></td>
                                                <td class="d-flex"><label class="me-2 small"><b id="Agirlik<?= $id ?>" class="Agirlik">0</b> Kg</label><input type='number' class='form-control Adet' id="Adet<?= $id ?>" LevhaID='<?= $id ?>' placeholder='Adet Giriniz'></td>
                                            </tr>
                                    <?php
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                        <div class="yaz"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    <?php
    if (isset($_GET["YazdirBoya"])) {
        echo "$('.BoyaTablo').DataTable({
            dom: 'Bfrtip',
            buttons: ['excel', 'pdf', 'print'],
            bFilter:false,
            responsive: true
        });";
    } else {
        echo "$('.BoyaTablo').DataTable({
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
    $('.LevhaTablo').DataTable({
        responsive: true,
        columnDefs: [{
                'visible': false,
                'targets': 0
            },
            {
                targets: '_all',
                orderable: false
            },
            {
                'width': '25%',
                'targets': 4
            }
        ],
        paging: false,
        bFilter: false,
    });
</script>
<?php
require __DIR__ . '/AjaxForm/Ajax.php';
require __DIR__ . '/../../controller/Footer.php';
if (isset($_POST["Miktar"])) {
    $_SESSION["Miktar"]  = $_POST["Miktar"];
}
?>