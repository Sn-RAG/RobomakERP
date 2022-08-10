<?php
$page = "Yönet";
require __DIR__ . '/../controller/Header.php';
require __DIR__ . '/../controller/Db.php';
require __DIR__ . '/../controller/Sil.php';
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <div class="col-lg-12">

                <div class="card recent-sales overflow-auto">

                    <div class="card-body">
                        <h5 class="card-title"><?= $page ?></h5>
                        <hr>
                        <button type="button" class="btn btn-primary bi-save" data-bs-toggle="modal" data-bs-target="#Ekle">&nbsp Ekle</button>
                        <hr>
                        <table class="table table-sm datatable">
                            <thead>
                            <tr>
                                <th>Kullanıcı Adı</th>
                                <th>Ad Soyad</th>
                                <th>Telefon</th>
                                <th>Aktif mi?</th>
                                <th>Yetki</th>
                                <th>&nbsp</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            $sorgu = $baglanti->query("SELECT * FROM kullanici");
                            foreach ($sorgu as $sonuc) {
                                $id = $sonuc['Kullanici_ID'];
                                $Kadi = $sonuc['Kadi'];
                                $Sifre = $sonuc['Sifre'];
                                $AdSoyad = $sonuc['AdSoyad'];
                                $Telefon = $sonuc['Telefon'];
                                $Aktifmi = $sonuc['Aktifmi'];
                                $Yetki = $sonuc['Yetki'];
                                ?>
                                <tr>
                                    <th hidden><?= $id ?></th>
                                    <td><?= $Kadi ?></td>
                                    <td hidden><?= $Sifre ?></td>
                                    <td><?= $AdSoyad ?></td>
                                    <td><?= $Telefon ?></td>
                                    <td><?= $Aktifmi == 1 ? "<span class='text-success'>Aktif" : "<span class='text-warning'>Aktif Değil" ?></span></td>
                                    <td><?= $Yetki == 1 ? "Yönetici" : "Kullanıcı"  ?></td>
                                    <td>
                                        <a href="index.php?KullaniciSil=<?= $id ?>" class="btn btn-sm btn-danger bi-trash"></a>
                                    </td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="Yaz"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<div class="modal fade" id="Ekle" tabindex="-1" data-bs-backdrop="false" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Kullanıcı Ekle</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation row g-3" id="formum" method="post" novalidate>

                        <div class="col-md-12">
                            <input type="text" id="Kadi" class="form-control" placeholder="Kullanıcı Adı"
                                   required>
                        </div>

                        <div class="col-md-12">
                            <input type="text" id="Sifre" class="form-control" placeholder="Şifre" required>
                        </div>

                        <div class="col-md-12">
                            <input type="text" id="AdSoyad" class="form-control" placeholder="Ad Soyad" required>
                        </div>

                        <div class="col-md-12">
                            <input type="tel" id="Telefon" class="form-control" placeholder="Telefon" required>
                        </div>


                        <div class="col-md-12">
                            <select class="form-select Yetki" aria-label="Seçiniz">
                                <option selected value="1">Yönetici</option>
                                <option value="2">Pazarlamacı</option>
                                <option value="3">Satın Alma</option>
                                <option value="4">Depo sorumlusu</option>
                                <option value="5">Boya sorumlusu</option>
                                <option value="6">Pres sorumlusu</option>
                                <option value="7">Kalite kontrol</option>
                            </select>
                        </div>

                        <div class="col-md-3"></div>

                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" name="Aktifmi" type="radio" id="1" value="1" checked>
                                <label class="form-check-label small" for="1">
                                    Aktif
                                </label>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" name="Aktifmi" type="radio" id="2" value="0">
                                <label class="form-check-label small" for="2">
                                    Aktif Değil
                                </label>
                            </div>
                        </div>
                    <div class="card-footer">
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary bi-save2">&nbsp Kaydet</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(function(){
        $("td").addClass("ortala");
    });
    $("#formum").submit(function (){
        var Aktifmi=$("input[name=Aktifmi]:checked").val();
        var Yetki=$(".Yetki").val();
        var Telefon=$("#Telefon").val();
        var AdSoyad=$("#AdSoyad").val();
        var Sifre=$("#Sifre").val();
        var Kadi=$("#Kadi").val();
        $.ajax({
            type: "POST",
            url: "index.php",
            data: {
                'Aktifmi': Aktifmi,
                'Yetki': $.trim(Yetki),
                'Telefon': $.trim(Telefon),
                'AdSoyad': $.trim(AdSoyad),
                'Sifre': $.trim(Sifre),
                'Kadi': $.trim(Kadi),
                'KullaniciEkle':true,
            },
            error: function (xhr, textStatus, errorThrown) {
                alert('Hata: ' + xhr.responseText);
            },
            success: function () {
                window.location.assign('index.php')
            }
        })
    });
</script>
<?php
require __DIR__ . '/../controller/Footer.php';
if (isset($_POST['KullaniciEkle'])) {
    $Kadi = $_POST['Kadi'];
    $Sifre = md5("88" . $_POST['Sifre'] . "83");
    $AdSoyad = $_POST['AdSoyad'];
    $Telefon = $_POST['Telefon'];
    $Yetki = $_POST['Yetki'];
    $Aktifmi = $_POST['Aktifmi'];

    $Kayit = $baglanti->prepare("INSERT INTO kullanici SET Kadi=?, Sifre=?, AdSoyad=?, Telefon=?, Aktifmi=?, Yetki=?");
    $Sonuc = $Kayit->execute(array($Kadi, $Sifre, $AdSoyad, $Telefon, $Aktifmi, $Yetki));
}
?>
