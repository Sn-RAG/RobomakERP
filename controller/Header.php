<?php
require __DIR__ . "/Link.php";
session_start();
if (!(isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "8388")) {
    header("location:" . $Link . "index.php");
}
require __DIR__ . "/Yetki.php";
if ($page != "Sipariş Listesi") {
    unset($_SESSION["Miktar"], $_SESSION["Boyalar"], $_SESSION["BAstar"], $_SESSION["BAstarm"], $_SESSION["BRenk"], $_SESSION["BRenkm"], $_SESSION["Levhalar"], $_SESSION["Adetler"]);
}
if ($page != "Firma Ekle" && $page != "Firma Düzenle" && $page != "Firmalar" && $page != "Yeni Set" && $page != "Boya Sipariş" && $page != "Levha Sipariş" && $page != "Tepe Sipariş" && $page != "Kulp Sipariş" && $page != "Kapak Sipariş" && $page != "Devam eden") {
    unset($_SESSION["Set_ID"], $_SESSION["SetAdi"], $_SESSION["UrunIDler"], $_SESSION["KulpSec"], $_SESSION["mmSec"], $_SESSION["KapakSec"], $_SESSION["KutuSec"], $_SESSION["TepeSec"]);
}
?>
<!DOCTYPE html>
<html lang="tr">

<!-- ======= Head ======= -->

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title><?= $page ?></title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="<?= $Link ?>assets/img/favicon.png" rel="icon">
    <link href="<?= $Link ?>assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Vendor CSS Files -->
    <link href="<?= $Link ?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= $Link ?>assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <link href="<?= $Link ?>assets/vendor/quill/quill.snow.css" rel="stylesheet">
    <link href="<?= $Link ?>assets/vendor/quill/quill.bubble.css" rel="stylesheet">
    <link href="<?= $Link ?>assets/vendor/datatables/datatables.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="<?= $Link ?>assets/css/style.css" rel="stylesheet">

    <!-- JQUERY -->
    <script src="<?= $Link ?>assets/vendor/datatables/datatables.min.js"></script>
    <!-- SweetAlert -->
    <script src="<?= $Link ?>assets/js/sweetalert2.all.min.js"></script>
</head> <!-- ======= Head SON ======= -->

<body>
    <!-- ======= Header ======= -->
    <header id="header" class="header fixed-top d-flex align-items-center">

        <div class="d-flex align-items-center justify-content-between">
            <i class="bi bi-list toggle-sidebar-btn"></i>
            <a class="logo d-flex align-items-center">
                <span class="d-none d-lg-block">RobomakERP</span>
            </a>
        </div>

        <nav class="header-nav ms-auto">
            <ul class="d-flex align-items-center">

                <a class="nav-link collapsed" href="<?= $Link ?>Cikis.php">
                    <button type="button" class="btn btn-warning ">Oturumu Kapat</button>
                </a>
            </ul>
        </nav>

    </header><!-- Header SON -->


    <!-- ======= Sidebar ======= -->
    <aside id="sidebar" class="sidebar">

        <ul class="sidebar-nav" id="sidebar-nav">

            <li class="nav-item">
                <a class="nav-link <?= $page == "Ana Sayfa" ? "" : "collapsed" ?>" href="<?= $Link ?>Anasayfa.php">
                    <i class="bi bi-grid"></i>
                    <span>Ana Sayfa</span>
                </a>
            </li>
            <li class="nav-item" <?= $SORGUAdmin ?>>
                <a class="nav-link <?= $page == "Yönet" ? "" : "collapsed" ?>" href="<?= $Link ?>admin/index.php">
                    <i class="bi bi-gear"></i>
                    <span>Yönet</span>
                </a>
            </li>

            <li class="nav-item" <?= $SORPazarlamaci ?>>
                <a class="nav-link <?= $page == "Firmalar" ? "" : "collapsed" ?>" href="<?= $Link ?>Firmalar/Firmalar.php">
                    <i class="bi bi-globe"></i>
                    <span>Firmalar</span>
                </a>
            </li>

            <li class="nav-item" <?= $SORBoya ?>>
                <a class="Stok nav-link collapsed" href="<?= $Link ?>Navigasyon/Stok.php">
                    <i class="bi bi-stack"></i><span>Stok</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Stok" class="nav-content collapse <?= $page == "Boya Stok" || $page == "Levha Stok" || $page == "Kapak Stok" || $page == "Kulp Stok" || $page == "Paket Stok" ? "show" : "" ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= $Link ?>Boyalar/BoyaStok.php" class="<?= $page == "Boya Stok" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Boya Stok</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>Levhalar/LevhaStok.php" class="<?= $page == "Levha Stok" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Levha Stok</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>Kapaklar/KapakStok.php" class="<?= $page == "Kapak Stok" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Kapak Stok</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>Kulplar/KulpStok.php" class="<?= $page == "Kulp Stok" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Kulp Stok</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>Paketler/PaketStok.php" class="<?= $page == "Paket Stok" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Paket Stok</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item" <?= $SorFerhat ?>>
                <a class="Uretim nav-link collapsed" href="<?= $Link ?>Navigasyon/Uretim.php">
                    <i class="bi bi-minecart-loaded"></i><span>Üretim</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Uretim" class="nav-content collapse <?= $page == "Set Oluştur" || $page == "Devam eden" || $page == "Ürünler" || $page == "Ürün Boya Bilgisi" || $page == "Ürün Levha Bilgisi" ? "show" : "" ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= $Link ?>Uretim/Setler.php" class="<?= $page == "Devam eden" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Devam eden</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>Uretim/Urun/Urunler.php" class="<?= $page == "Ürünler" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Ürünler</span>
                        </a>
                    </li>
                </ul>
            </li>

            <li class="nav-item" <?= $SORPazarlamaci ?>>
                <a class="Pazarlama nav-link collapsed" href="<?= $Link ?>Navigasyon/Pazarlama.php">
                    <i class="bi bi-truck"></i><span>Pazarlama</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="Pazarlama" class="nav-content collapse <?= $page == "Satış" || $page == "Konteynır Hesapla" || $page == "Maaliyet Düzenle" || $page == "Ret" || $page == "Onay" || $page == "Hazır Teklifler" || $page == "Teklif" ? "show" : "" ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= $Link ?>Pazarlama/TeklifHazirla/Hazir.php" class="<?= $page == "Hazır Teklifler" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Teklif Hazırla</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>Pazarlama/KonteynirHesapla.php" class="<?= $page == "Konteynır Hesapla" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Konteynır Hesapla</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>Pazarlama/MaaliyetDuzenle.php" class="<?= $page == "Maaliyet Düzenle" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Maaliyet Düzenle</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>Pazarlama/TeklifHazirla/Hazir.php?Ret&h" class="<?= $page == "Ret" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Reddedilenler</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>Pazarlama/TeklifHazirla/Hazir.php?Onay&h" class="<?= $page == "Onay" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Onaylananlar</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>Pazarlama/TeklifHazirla/Hazir.php?Teklif&h" class="<?= $page == "Teklif" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Teklifler</span>
                        </a>
                    </li>
                </ul>
            </li>


            <li class="nav-item" <?= $SORSatın_alma ?>>
                <a class="SatinAlma nav-link collapsed" href="<?= $Link ?>Navigasyon/SatinAlma.php">
                    <i class="bi bi-credit-card"></i><span>Satın Alma</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="SatinAlma" class="nav-content collapse <?= $page == "Sipariş" || $page == "Sipariş Et" || $page == "Çalışılan Firmalar" || $page == "Fiyat Teklifleri" || $page == "Gelen Sipariş Listesi"
                                                                    || $page == "Görüşülen Firmalar" || $page == "Operasyonlar" || $page == "Üretim İhtiyaçları" || $page == "Bekleyen Siparişler" || $page == "Verilen Siparişler" ? "show" : "" ?>" data-bs-parent="#sidebar-nav">
                    <li>
                        <a href="<?= $Link ?>Navigasyon/SiparisEt.php" class="<?= $page == "Sipariş" || $page == "Sipariş Et" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Sipariş</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>SatinAlma/CalisilanFirmalar.php" class="<?= $page == "Çalışılan Firmalar" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Çalışılan Firmalar</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>SatinAlma/FiyatTeklifleri.php" class="<?= $page == "Fiyat Teklifleri" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Fiyat Teklifleri</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>SatinAlma/GelenSiparisListesi.php" class="<?= $page == "Gelen Sipariş Listesi" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Gelen Sipariş Listesi</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>SatinAlma/GorusulenFirmalar.php" class="<?= $page == "Görüşülen Firmalar" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Görüşülen Firmalar</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>SatinAlma/Operasyonlar.php" class="<?= $page == "Operasyonlar" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Operasyonlar</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>SatinAlma/UretimIhtiyaclari.php" class="<?= $page == "Üretim İhtiyaçları" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Üretim İhtiyaçları</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>SatinAlma/BekleyenSiparisler.php" class="<?= $page == "Bekleyen Siparişler" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Bekleyen Siparişler</span>
                        </a>
                    </li>
                    <li>
                        <a href="<?= $Link ?>SatinAlma/VerilenSiparisler.php" class="<?= $page == "Verilen Siparişler" ? "active" : "" ?>">
                            <i class="bi bi-circle"></i></i><span>Verilen Siparişler</span>
                        </a>
                    </li>
                </ul>
            </li>

        </ul>

    </aside>