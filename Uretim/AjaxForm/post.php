<?php
require __DIR__ . '/../../controller/Db.php';

session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];

if (isset($_POST['Sec'])) {
    $UIDler = $_POST["UrunIDler"];
    //Kapak Kulp ve Tepe idleri Kendi tablolarında olmayınca Listelenmiyor o yüzden yok adında kayıt kontrolü yapıcaz
    $Adetler = $_POST["Adetler"];

    $SetKaydet = $baglanti->prepare("INSERT INTO `set` SET SetAdi= ?");
    $SonucSor = $SetKaydet->execute(array($_POST['SetAdi']));
    $Set_ID = $baglanti->lastInsertId();

    $_SESSION["Set_ID"] = $Set_ID;

    for ($i = 0; $i < count($UIDler); $i++) {
        //Kapak Kulp ve Tepe idleri Kendi tablolarında olmayınca Listelenmiyor o yüzden yok adında kayıt kontrolü yapıcaz
    if ($_POST["Kapaklar"][$i]=="") {
        $sor=$baglanti->query("SELECT Kapak_ID FROM kapak WHERE Tip='Yok'");
        if($sor->rowCount()){
            $Kapak=$sor->fetch()["Kapak_ID"];
        }else{
            $k=$baglanti->prepare("INSERT INTO kapak SET Firma_ID=?, Tip=?, Kapak_No=?, Model_Adi=?");
            $k->execute(array(0,'Yok',0,'Yok'));
            $Kapak=$baglanti->lastInsertId();
        }
    }
    if ($_POST["Kulplar"][$i]=="") {
        $sor=$baglanti->query("SELECT Kulp_ID FROM kulp WHERE KulpAdi='Yok'");
        if($sor->rowCount()){
            $Kulp=$sor->fetch()["Kulp_ID"];
        }else{
            $k=$baglanti->prepare("INSERT INTO kulp SET Firma_ID=?, KulpAdi=?, KulpCesidi=?, Renk=?");
            $k->execute(array(0,'Yok','Yok','Yok'));
            $Kulp=$baglanti->lastInsertId();
        }
    }
    if ($_POST["Tepeler"][$i]=="") {
        $sor=$baglanti->query("SELECT Tepe_ID FROM tepe WHERE TepeAdi='Yok'");
        if($sor->rowCount()){
            $Tepe=$sor->fetch()["Tepe_ID"];
        }else{
            $k=$baglanti->prepare("INSERT INTO tepe SET Firma_ID=?, TepeAdi=?, TepeFoto=?");
            $k->execute(array(0,'Yok','Yok'));
            $Tepe=$baglanti->lastInsertId();
        }
    }
        $Kaydet = $baglanti->prepare("INSERT INTO set_urun SET Set_ID= ?, Urun_ID= ?, Levha_ID= ?, Kapak_ID= ?, Kulp_ID= ?, Tepe_ID= ?");
        $Sonuc = $Kaydet->execute(array($Set_ID, $UIDler[$i], $_POST['mmler'][$i], $Kapak, $Kulp, $Tepe));
    }

    $Set_Urun_ID = $baglanti->lastInsertId();
    for ($i = 0; $i < count($Adetler); $i++) {
        $Kaydet = $baglanti->prepare("INSERT INTO set_urun_icerik SET Set_ID= ?, Adet= ?, DisBoya= ?, icBoya= ?");
        $Sonuc = $Kaydet->execute(array($Set_ID, $Adetler[$i], $_POST["DisBoyalar"][$i], $_POST["icBoyalar"][$i]));
    }

    $Set_Urun_icerik_ID = $baglanti->lastInsertId();

    $SetKaydet = $baglanti->prepare("INSERT INTO set_icerik SET Set_Urun_ID= ?, Set_Urun_icerik_ID= ?, Kutu= ?, Kullanici_ID= ?");
    $Sonuc = $SetKaydet->execute(array($Set_Urun_ID, $Set_Urun_icerik_ID, $_POST["Kutu"], $Kullanici));
    ############################################
    // Düzenlemek için Kombinasyonu yapılan verinin bütün varyasyonlarını başka bir veri tabanına ekliyoruz sırf ürüne özel düzenlemeler gerçekleştirmek için
    ###############################################

    $baglanti->query("INSERT INTO set_urunler (Set_Urun_icerik_ID, Set_ID, Urun_ID, Levha_ID, icBoya_ID, DisBoya_ID, Kulp_ID, Kapak_ID, Tepe_ID, Adet) 
SELECT set_urun_icerik.Set_Urun_icerik_ID, set_urun.Set_ID, set_urun.Urun_ID, set_urun.Levha_ID, icBoya, DisBoya, Kulp_ID, Kapak_ID, Tepe_ID, Adet 
FROM view_uretim_setler 
INNER JOIN set_urun_icerik ON view_uretim_setler.Set_ID = set_urun_icerik.Set_ID 
INNER JOIN set_urun ON view_uretim_setler.Set_ID = set_urun.Set_ID 
WHERE view_uretim_setler.Set_ID = " . $Set_ID . " GROUP BY set_urun_icerik.Set_Urun_icerik_ID, set_urun.Set_Urun_ID");
    #############################################################################################################################################
} elseif (isset($_POST["SetAdiKontrol"])) {
    $SetVarmi = $baglanti->prepare("SELECT * FROM `set` WHERE SetAdi=?");
    $SetVarmi->execute(array($_POST["SetAdiKontrol"]));
    if ($SetVarmi->rowCount()) {
        echo "Bu ada sahip set zaten var!";
    } else {
        //set adını tutuyoruz.ekle falan yapılırsa
        $_SESSION["SetAdi"] = $_POST["SetAdiKontrol"];
    }
} elseif (isset($_POST["UrunIDler"])) {
    //Ürünleri tutuyoruz.ekle yapılırsa
    $_SESSION["UrunIDler"] = $_POST["UrunIDler"];
    $_SESSION["KulpSec"] = $_POST["KulpSec"];
    $_SESSION["KapakSec"] = $_POST["KapakSec"];
    $_SESSION["TepeSec"] = $_POST["TepeSec"];
}
#############################################################################################################################################
elseif (isset($_POST["Listele"])) {

    ##########################################  KAYITTAN SONRA LİSTELE

    $sor = $baglanti->query("SELECT * FROM view_set_urun_sec WHERE Set_ID=" . (int)$_SESSION["Set_ID"]);
    foreach ($sor as $s) {
        $s2 = $baglanti->query("SELECT * FROM urun WHERE Urun_ID=" . $s["Urun_ID"])->fetch();
?>
            <button class="btn col-md-2 me-2" type="button" name="Urunler" Set_Urun_Duzenle_ID="<?= $s["Set_Urun_Duzenle_ID"] ?>">
                <div class="card2__body">
                    <div class="card2__body-cover">
                        <img class="card2__body-cover-image" src="../assets/img/Keksan/<?= $s2["UrunFoto"] == "yok" || $s2["UrunFoto"] == "" || $s2["UrunFoto"] == null ? "" : $s2["UrunFoto"] ?>">
                        <span class="card2__body-cover-checkbox">
                            <svg class="card2__body-cover-checkbox--svg" viewBox="0 0 12 10">
                                <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                            </svg>
                        </span>
                    </div>
                    <header class="card2__body-header">
                        <h2 class="card2__body-header-title"><?= $s2["UrunAdi"] ?></h2>
                        <p class="card2__body-header-subtitle small">
                            <?php
                            $icBoya = $baglanti->query("SELECT Boya_ID, Renk FROM set_urunler INNER JOIN boya ON set_urunler.icBoya_ID = boya.Boya_ID WHERE Boya_ID=" . $s["icBoya_ID"] . " GROUP BY Renk")->fetch();
                                echo "İç Boya:<input type='hidden' name='icrengi$s[Set_Urun_Duzenle_ID]' value='$icBoya[Boya_ID]'>";
                                echo $icBoya["Renk"] == "" ? "<code>Ayarlanmadı</code>" : "<code class='text-success small'>" . $icBoya["Renk"] . "</code><br>";
                                ?>
                            Dış Boya:<input type='hidden' name='disrengi<?= $s["Set_Urun_Duzenle_ID"] ?>' value='<?= $s["Boya_ID"] ?>'>
                            <?= $s["DisRenk"] == "" ? "<code>Ayarlanmadı</code>" : "<code class='text-success small'>" . $s["DisRenk"] . "</code>" ?>
                            <br>

                            <input type='hidden' name='kapaki<?= $s["Set_Urun_Duzenle_ID"] ?>' value='<?= @$s["Kapak_ID"] ?>'>
                            Kapak:<?= $s["Kapak_ID"] == "" ? "<code>Ayarlanmadı</code>" : "<code class='text-success small'>" . $s["Kapak_ID"] . "</code>" ?>
                            <br>


                            <input type='hidden' name='kulpu<?= $s["Set_Urun_Duzenle_ID"] ?>' value='<?= @$s["Kulp_ID"] ?>'>
                            Kulp:<?= $s["KulpAdi"] == "" ? "<code>Ayarlanmadı</code>" : "<code class='text-success small'>" . $s["KulpAdi"] . "</code>" ?>
                            <br>

                            <input type='hidden' name='adeti<?= $s["Set_Urun_Duzenle_ID"] ?>' value='<?= $s["Adet"] ?>'>
                            Adet:<?= $s["Adet"] ?>

                        </p>
                    </header>
                </div>
            </button>

    <?php
    }
    ?>
    <script>
        $("button[name=Urunler]").click(function() {
            var ID = $(this).attr("Set_Urun_Duzenle_ID");
            var resim = $(this).children("div").children("div").children("img").attr("src");
            var Ad = $(this).children("div").children("header").children("h2").text();

            $("input[name=Set_Urun_Duzenle_ID]").val(ID);

            $(".resim").html("<img src=" + resim + " class='card-img-top'>");
            $(".baslik").text(Ad);
            $(".etkin").removeAttr('disabled', false);

            //######################################################## Düzenleme İçin
            var icrengi = $("input[name=icrengi" + ID + "]").val();
            var disrengi = $("input[name=disrengi" + ID + "]").val();
            var kapaki = $("input[name=kapaki" + ID + "]").val();
            var kulpu = $("input[name=kulpu" + ID + "]").val();
            var adeti = $("input[name=adeti" + ID + "]").val();

            $("select[name=icBoya]").val(icrengi);
            $("select[name=DisBoya]").val(disrengi);
            $("select[name=Kapak]").val(kapaki);
            $("select[name=Kulp]").val(kulpu);
            $("input[name=Adet]").val(adeti);

            //######################################################## Düzenleme İçin son
            $(this).children("div").children("div").children("img").css("filter", "none");

            $("button[name=Urunler]").attr("disabled", true);
            $("#icerikSec").attr("hidden", false);
        });
    </script>
<?php
} elseif (isset($_POST["Urunicerik"])) {
    $id = $_POST["Set_Urun_Duzenle_ID"];

    $icBoya = $_POST["UicBoya"];
    $DisBoya = $_POST["UDisBoya"];
    $Kapak = $_POST["UKapak"];
    $Kulp = $_POST["UKulp"];
    $Adet = $_POST["UAdet"];

    $icerik = $baglanti->prepare("UPDATE set_urunler SET Adet= ?, DisBoya_ID= ?, icBoya_ID= ?, Kapak_ID= ?, Kulp_ID= ? WHERE Set_Urun_Duzenle_ID= ?");
    $Doldur = $icerik->execute(array($Adet, $DisBoya, $icBoya, $Kapak, $Kulp, $id));
}
