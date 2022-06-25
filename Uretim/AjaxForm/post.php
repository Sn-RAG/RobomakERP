<?php
require __DIR__ . '/../../controller/Db.php';

session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];

if (isset($_POST['Sec'])) {

    $SetAdi = $_POST['SetAdi'];
    $Urun_IDler = $_POST["UrunIDler"];

    $Kalinlik = $_POST['Kalinlik'];
    $Kapak = $_POST["Kapak"];
    $Kulp = $_POST["Kulp"];

    $icBoyalar = $_POST["icBoyalar"];
    $DisBoyalar = $_POST["DisBoyalar"];
    $Adetler = $_POST["Adetler"];

    $SetKaydet = $baglanti->prepare("INSERT INTO `set` SET SetAdi= ?");
    $SonucSor = $SetKaydet->execute(array($SetAdi));
    $Set_ID = $baglanti->lastInsertId();

    $_SESSION["Set_ID"] = $Set_ID;

    for ($i = 0; $i < count($Urun_IDler); $i++) {
        $Kaydet = $baglanti->prepare("INSERT INTO set_urun SET Set_ID= ?, Urun_ID= ?");
        $Sonuc = $Kaydet->execute(array($Set_ID, $Urun_IDler[$i]));
    }

    $Set_Urun_ID = $baglanti->lastInsertId();
    for ($i = 0; $i < count($Adetler); $i++) {
        $Kaydet = $baglanti->prepare("INSERT INTO set_urun_icerik SET Set_ID= ?, Adet= ?, DisBoya= ?, icBoya= ?, Kapak= ?, Kulp= ?");
        $Sonuc = $Kaydet->execute(array($Set_ID, $Adetler[$i], $DisBoyalar[$i], $icBoyalar[$i], $Kapak, $Kulp));
    }

    $Set_Urun_icerik_ID = $baglanti->lastInsertId();

    $SetKaydet = $baglanti->prepare("INSERT INTO set_icerik SET Set_Urun_ID= ?, Set_Urun_icerik_ID= ?, Kalinlik= ?, Kullanici_ID= ?");
    $Sonuc = $SetKaydet->execute(array($Set_Urun_ID, $Set_Urun_icerik_ID, $Kalinlik, $Kullanici));
############################################
    // Düzenlemek için Kombinasyonu yapılan verinin bütün varyasyonlarını başka bir veri tabanına ekliyoruz sırf ürüne özel düzenlemeler gerçekleştirmek için
###############################################
    $baglanti->query("INSERT INTO set_urunler (Set_Urun_icerik_ID, Set_ID, Urun_ID, icBoya_ID, DisBoya_ID, Kulp_ID, Kapak_ID, Adet)
                                    SELECT set_urun_icerik.Set_Urun_icerik_ID, view_uretim_setler.Set_ID, view_uretim_setler.Urun_ID, icBoya, DisBoya, Kulp, Kapak, Adet FROM view_uretim_setler 
                                        INNER JOIN set_urun_icerik ON view_uretim_setler.Set_ID = set_urun_icerik.Set_ID INNER JOIN set_urun ON view_uretim_setler.Set_ID = set_urun.Set_ID 
                                    WHERE view_uretim_setler.Set_ID = " . $Set_ID . " GROUP BY set_urun_icerik.Set_Urun_icerik_ID, set_urun.Set_Urun_ID");

#############################################################################################################################################
}elseif (isset($_POST["SetAdiKontrol"])){
    $SetVarmi = $baglanti->prepare("SELECT * FROM `set` WHERE SetAdi=?");
    $SetVarmi->execute(array($_POST["SetAdiKontrol"]));
    if ($SetVarmi->rowCount()) {
        echo "Bu ada sahip set zaten var!";
    }else{
        //set adını tutuyoruz.ekle falan yapılırsa
        $_SESSION["SetAdi"]=$_POST["SetAdiKontrol"];
    }
}elseif (isset($_POST["UrunIDler"])){
    //Ürünleri tutuyoruz.ekle yapılırsa
    $_SESSION["UrunIDler"]=$_POST["UrunIDler"];
}
#############################################################################################################################################
elseif (isset($_POST["Listele"])) {

    ##########################################  KAYITTAN SONRA LİSTELE

    $sor = $baglanti->query("SELECT * FROM view_set_urun_sec WHERE Set_ID=" . (int)$_SESSION["Set_ID"]);
    foreach ($sor as $s) {
        ?>

        <button class="btn col-md-2 me-2" type="button" name="Urunler"
                Set_Urun_Duzenle_ID="<?= $s["Set_Urun_Duzenle_ID"] ?>">
            <div class="card2__body">
                <div class="card2__body-cover">
                    <img class="card2__body-cover-image"
                         src="../assets/img/Keksan/<?= $s["UrunFoto"] == "yok" || $s["UrunFoto"] == "" || $s["UrunFoto"] == null ? "" : $s["UrunFoto"] ?>">
                    <span class="card2__body-cover-checkbox">
                        <svg class="card2__body-cover-checkbox--svg" viewBox="0 0 12 10">
                            <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                        </svg>
                    </span>
                </div>
                <header class="card2__body-header">
                    <h2 class="card2__body-header-title"><?= $s["UrunAdi"] ?></h2>
                    <p class="card2__body-header-subtitle small">
                        <?php
                        $icBoya = $baglanti->query("SELECT Boya_ID, Renk FROM set_urunler INNER JOIN boya ON set_urunler.icBoya_ID = boya.Boya_ID WHERE Boya_ID=" . $s["icBoya_ID"] . " GROUP BY Renk");
                        foreach ($icBoya as $s1) {
                            echo "İç Boya:<input type='hidden' name='icrengi$s[Set_Urun_Duzenle_ID]' value='$s1[Boya_ID]'>";
                            echo $s1["Renk"] == "" ? "<code>Ayarlanmadı</code>" : "<code class='text-success small'>" . $s1["Renk"] . "</code><br>";
                        } ?>
                        Dış Boya:<input type='hidden' name='disrengi<?= $s["Set_Urun_Duzenle_ID"] ?>'
                                        value='<?= $s["Boya_ID"] ?>'>
                        <?= $s["DisRenk"] == "" ? "<code>Ayarlanmadı</code>" : "<code class='text-success small'>" . $s["DisRenk"] . "</code>" ?>
                        <br>

                        <input type='hidden' name='kapaki<?= $s["Set_Urun_Duzenle_ID"] ?>'
                               value='<?= $s["Kapak_ID"] ?>'>
                        Kapak:<?= $s["Kapak_ID"] == "" ? "<code>Ayarlanmadı</code>" : "<code class='text-success small'>" . $s["Kapak_ID"] . "</code>" ?>
                        <br>


                        <input type='hidden' name='kulpu<?= $s["Set_Urun_Duzenle_ID"] ?>'
                               value='<?= $s["Kulp_ID"] ?>'>
                        Kulp:<?= $s["KulpRenk"] == "" ? "<code>Ayarlanmadı</code>" : "<code class='text-success small'>" . $s["KulpCesidi"] . " > " . $s["KulpRenk"] . "</code>" ?>
                        <br>

                        <input type='hidden' name='adeti<?= $s["Set_Urun_Duzenle_ID"] ?>'
                               value='<?= $s["Adet"] ?>'>
                        Adet:<?= $s["Adet"] ?>

                    </p>
                </header>
            </div>
        </button>

        <?php
    }
    ?>
    <script>
        $("button[name=Urunler]").click(function () {
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