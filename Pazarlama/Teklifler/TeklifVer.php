<?php
ob_start();
$page = "Satış Yap";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
require __DIR__ . '/../../controller/Kayit.php';

//Diğer sayfalarda verileri çekip sessionda kalıcı şekilde saklıyoruz

if (isset($_GET["FirmaID"])) {
    $_SESSION["FirmaID"] = $_GET["FirmaID"];
    $_SESSION["FirmaAdi"] = $_GET["FirmaAdi"];
}
$fsor = isset($_SESSION["FirmaID"]) ? "Değiştir" : "Firma Seç";
$ssor = isset($_SESSION["Setler"]) ? "Değiştir" : "Set Seç";
$Fdegis = "<a href='../../Firmalar/Firmalar.php?Sec=true' class='btn btn-outline-secondary'>" . $fsor . "</a>";
$Sdegis = "<a href='../../Uretim/Setler.php?Sec=true' class='btn btn-outline-secondary'>" . $ssor . "</a>";
if (isset($_SESSION["Setler"])){

    $Say=count($_SESSION["Setler"]);
}
?>
    <main id="main" class="main">
        <section class="section">
            <div class="d-flex align-items-center justify-content-center min-vh-100">
                <div class="card col-sm-4">
                    <div class="card-body">
                        <div class="modal-header">
                            <h5 class="modal-title"><?= $page ?></h5>
                            <a href="Teklifler.php">
                                <button type="button" class="btn btn-secondary"><i
                                            class="bi bi-arrow-left me-1"></i> Geri
                                </button>
                            </a>
                        </div>
                        <form class="row g-3" method="post">
                            <h5></h5>
                            <?= isset($_SESSION["FirmaID"]) ? "<div class='input-group'><input type='button' class='form-control btn' value='$_SESSION[FirmaAdi]'>$Fdegis</div>" : $Fdegis ?>

                            <?= isset($_SESSION["Setler"]) ? "<div class='input-group'><input type='button' class='form-control btn' value='@$Say Set Seçildi'>$Sdegis</div>" : $Sdegis ?>

                            <div class="col-md-12">
                                <label>Teslim Tarihi</label>
                                <input type="date" class="form-control" name="Teslim_Tarihi">
                            </div>
                            <div class="text-center">
                                <button name="Teklifver" type="submit" class="btn btn-primary bi-save"> Kaydet
                                </button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </main>
<?php
require __DIR__ . '/../../controller/Footer.php';
?>