<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Giriş</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Vendor CSS Files -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="assets/css/style.css" rel="stylesheet">
    <!-- SWİT ALERT -->
    <script src="assets/js/sweetalert2.all.min.js"></script>
</head>

<body>
<main>
    <div class="container">

        <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

                        <div class="d-flex justify-content-center py-4">
                            <a class="logo d-flex align-items-center w-auto">
                                <span class="d-none d-lg-block">RobomakERP</span>
                            </a>
                        </div><!-- End Logo -->

                        <div class="card mb-3">

                            <div class="card-body">

                                <div class="pt-4 pb-2">
                                    <h5 class="card-title text-center pb-0 fs-4">Hesabınıza Giriş Yapın</h5>
                                    <p class="text-center small">Giriş yapmak için kullanıcı adınızı ve şifrenizi
                                        girin</p>
                                </div>


                                <?php
                                ob_start();
                                session_start();
                                require __DIR__ . '/controller/Db.php';

                                $Admin = 1;
                                $Pazarlamaci = 2;
                                $Satin_alma = 3;
                                $Depo_sorumlusu = 4;
                                $Boya_sorumlusu = 5;
                                $Pres_sorumlusu = 6;
                                $Kalite_kontrol = 7;


                                //LİNK KONTROLÜ OTURUM VARSA OTURUMU KAPATMADAN GİRİŞ EKRANINA DÖNEMEZ
                                if (isset($_SESSION["Oturum"]) && $_SESSION["Oturum"] == "8388") {
                                    header("location:Anasayfa.php");
                                } elseif (isset($_COOKIE["Keksan"])) {
                                    $goster = $baglanti->prepare("SELECT Kadi, Yetki FROM kullanici WHERE Aktifmi= 1");
                                    $goster->execute();
                                    while ($Snc = $goster->fetch()) {
                                        if ($_COOKIE["Keksan"] == md5("Keksan" . $Snc["Kadi"] . "Keksan")) {
                                            $_SESSION["Kullanici"] = $Snc["Kadi"];
                                            $_SESSION["Oturum"] = "8388";
                                            $_SESSION["Yetki"] = $Snc["Yetki"];
                                            header("location:Anasayfa.php");
                                        }
                                    }
                                }


                                if ($_POST) {
                                    $Kadi = $_POST["Kadi"];
                                    $Sifre = $_POST["Sifre"];
                                }
                                //Sifreyi if in dışında tanımlamayı unutma
                                //echo md5("88" . "Kadir" . "83");
                                ?>
                                <form class="row g-3 needs-validation" novalidate action="index.php" method="post">

                                    <div class="col-12">
                                        <label for="yourUsername" class="form-label">Kullanıcı Adı</label>
                                        <div class="input-group has-validation">
                                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                                            <input type="text" name="Kadi" value="<?= @$Kadi ?>"
                                                   class="form-control" required>
                                            <div class="invalid-feedback">Lütfen Kullanıcı Adınızı Giriniz!</div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Şifre</label>
                                        <input type="password" name="Sifre" class="form-control"
                                               required>
                                        <div class="invalid-feedback">Lütfen Şifrenizi Giriniz!</div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="true" id="tik"
                                                   name="Hatirla" checked>
                                            <label class="form-check-label" for="tik">Beni Hatırla</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <input name="giris" class="btn btn-primary w-100" type="submit" value="Giriş"/>
                                    </div>
                                </form>
                                <?php
                                if ($_POST) {
                                    $goster = $baglanti->prepare("SELECT Sifre, Yetki FROM kullanici WHERE Kadi= ? AND Aktifmi= 1");
                                    $goster->execute(array($Kadi));
                                    $Snc = $goster->fetch();
                                    if (md5("88" . $Sifre . "83") == $Snc["Sifre"]) {
                                        $_SESSION["Kullanici"] = $Kadi;
                                        $_SESSION["Oturum"] = "8388";
                                        $_SESSION["Yetki"] = $Snc["Yetki"];

                                        if (isset($_POST['Hatirla'])) {
                                            setcookie("Keksan", md5("Keksan" . $Kadi . "Keksan"), time() + (60 * 60 * 24 * 7));
                                        }
                                        header("location:Anasayfa.php");
                                    } else {
                                        echo "<script>Swal.fire({
                                                      icon: 'error',
                                                      title: 'Hatalı Giriş...',
                                                      text: 'Kullanıcı adı ya da şifre hatalı!',
                                                      confirmButtonText: 'Tamam',
                                                    })</script>";
                                    }
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>

    </div>
</main><!-- End #main -->
<!-- Vendor JS Files -->
<script src="assets/vendor/tinymce/tinymce.min.js"></script>

<!-- Template Main JS File -->
<script src="assets/js/main.js"></script>
</body>

</html>
