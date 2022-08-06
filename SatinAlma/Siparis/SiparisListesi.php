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

                                    if (isset($_SESSION["BRenk"])) {
                                        $r = $_SESSION["BRenk"];
                                        $a = $_SESSION["BAstar"];
                                        for ($i = 0; $i < count($r); $i++) {
                                            $ss = $baglanti->query("SELECT * FROM boya WHERE Renk='" . @$r[$i] . "' AND Seri='ÜST KAT' OR Seri='ASTAR' AND Renk='" . @$a[$i] . "'");
                                            foreach ($ss as $s) {
                                                $id = $s["Boya_ID"];
                                                $seri = $s['Seri']; ?>
                                                <tr>
                                                    <td><button class="btn btn-danger bi-x-lg sil"></button></td>
                                                    <td><?= $s['Marka'] ?></td>
                                                    <td><?= $s['Renk'] ?></td>
                                                    <td><?= $seri ?></td>
                                                    <td><?= $s['Kod'] ?></td>
                                                    <td>
                                                        <div class="input-group"><input type='number' id="<?= $id ?>" class='form-control Miktar' value="<?= $seri == "ASTAR" ? $_SESSION["BAstarm"][$i] : ceil($_SESSION["BRenkm"][$i] / 1000) ?>" placeholder='Miktar Giriniz'><span class="input-group-text"> &nbsp KG &nbsp </span></div>
                                                    </td>
                                                </tr>
                                            <?php }
                                        }
                                    } else {
                                        $b = $_SESSION["Boyalar"];
                                        for ($i = 0; $i < count($b); $i++) {
                                            $sn = $baglanti->query('SELECT * FROM boya WHERE Boya_ID=' . $b[$i])->fetch(); ?>
                                            <tr>
                                                <?= isset($_GET["YazdirBoya"]) ? "" : "<td><?= $sn[Boya_ID] ?></td>" ?>
                                                <td><?= $sn['Marka'] ?></td>
                                                <td><?= $sn['Renk'] ?></td>
                                                <td><?= $sn['Seri'] ?></td>
                                                <td><?= $sn['Kod'] ?></td>
                                                <?= isset($_GET["YazdirBoya"]) ? "" : "<td><div class='input-group'><input type='number' class='form-control Miktar' placeholder='Miktar Giriniz'><span class='input-group-text'> &nbsp KG &nbsp </span></div></td>" ?>
                                                <?= isset($_GET["YazdirBoya"]) ? "<td>" . $_SESSION["Miktar"][$i] . "</td>" : "" ?>
                                            </tr>
                                    <?php }
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
                                    $l = $_SESSION["Levhalar"];
                                    for ($i = 0; $i < count($l); $i++) {
                                        $sn = $baglanti->query('SELECT * FROM levha WHERE Levha_ID=' . $l[$i])->fetch();
                                        $id = $sn["Levha_ID"];
                                        //Köşeli mi?
                                        $bak = $sn['Cap2'] <> null ? " &nbsp <i class='bi-dash-lg'></i> &nbsp " . $sn['Cap2'] . " cm" : "";
                                        $cap = $sn['Cap2'] <> null ? $sn['Cap2'] : $sn['Cap']; //Hesap
                                    ?>
                                        <tr>
                                            <td><?= $id ?></td>
                                            <td><?= $sn['Tip'] ?></td>
                                            <td><?= $sn['Cap'] . $bak ?>
                                                <!--HESAP-->
                                                <i hidden id="Hesap<?= $id ?>"><?= $sn['Cap'] * $cap * $sn['Kalinlik'] * (0.22) ?></i>
                                                <!--HESAP SON-->
                                            </td>
                                            <td><?= $sn['Kalinlik'] ?></td>
                                            <td><div class="d-flex"><div class="col-md-6"><label class="me-2 small"><b id="Agirlik<?= $id ?>" class="Agirlik">0</b> Kg</label></div><div class="col-md-6"><input type='number' class='form-control Adet' id="Adet<?= $id ?>" value="<?= $_SESSION["Adetler"] ?>" LevhaID='<?= $id ?>' placeholder='Adet Giriniz'></td></div></div>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    <?php if (isset($_SESSION["Boyalar"])) {
        if (isset($_GET["YazdirBoya"])) { ?>
            $('.BoyaTablo').DataTable({
                dom: 'Bfrtip',
                buttons: ['excel', 'pdf', 'print'],
                bFilter: false,
                responsive: true
            });
        <?php } else { ?>
            $('.BoyaTablo').DataTable({
                responsive: true,
                columnDefs: [{
                        targets: '_all',
                        orderable: false
                    },
                    {
                        'width': '20%',
                        'targets': 5
                    },
                    <?php if (!(isset($_SESSION["BRenk"]))) {
                        echo "{'visible': false,
                        'targets': 0}";
                    } ?>
                ],
                paging: false,
                bFilter: false,
            });
        <?php }
    } elseif (isset($_SESSION["Levhalar"])) { ?>
        $('.LevhaTablo').DataTable({
            responsive: true,
            order: false,
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
    <?php } ?>
</script>
<?php
require __DIR__ . '/AjaxForm/Ajax.php';
require __DIR__ . '/../../controller/Footer.php';
if (isset($_POST["Miktar"])) {
    $_SESSION["Miktar"] = $_POST["Miktar"];
    $_SESSION["Boyalar"] = $_POST["Boyalar"];
}
?>