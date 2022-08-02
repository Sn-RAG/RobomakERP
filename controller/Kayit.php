<?php
require __DIR__ . '/Db.php';
require __DIR__ . '/VTHataMesaji.php';
require __DIR__ . "/../logtut.php";

//--------------------------------Kullanici Kim

$Sor = $baglanti->query("SELECT Kullanici_ID FROM kullanici WHERE Kadi='$_SESSION[Kullanici]'");
$Kullanici = $Sor->fetch()['Kullanici_ID'];

//#######################################################################        ÜRÜN İŞLEMLERİ      ##########################################################################################
//---------------------------------------Ürün Kayıt
if (isset($_POST['UrunEkle'])) {
    $Resim = $_POST['UrunFoto'];
    $UrunAdi = $_POST['UrunAdi'];
    $Aciklama = $_POST['Aciklama'];
    $Kategori_ID = $_POST['Kategori_ID'];
    $Sorgu = $baglanti->prepare("SELECT UrunAdi FROM urun WHERE UrunAdi= ?");
    $Sorgu->execute(array($UrunAdi));
    $Sor = $Sorgu->fetch();
    echo $Kategori_ID;
    if ($Sorgu->rowCount() > 0) {
        echo $Kayitvar;
    } else {
        if ($Resim != "") {
            $Ekle = $baglanti->prepare("INSERT INTO urun SET Kategori_ID= ?, UrunAdi= ?, UrunFoto= ?, Aciklama= ?");
            $Ekle->execute(array($Kategori_ID, $UrunAdi, $Resim, $Aciklama));
            header("location:Urunler.php");
        } else {

            move_uploaded_file($_FILES['Resim']['tmp_name'], __DIR__ . '/../assets/img/Keksan/' . $_FILES["Resim"]['name']);
            $ResimYeni = $_FILES["Resim"]["name"];

            $Ekle = $baglanti->prepare("INSERT INTO urun SET Kategori_ID= ?, UrunAdi= ?, UrunFoto= ?, Aciklama= ?");
            $Ekle->execute(array($Kategori_ID, $UrunAdi, $ResimYeni, $Aciklama));
        }
    }
    logtut($Kullanici, "Ürün ekledi.");
}

//---------------------------------------Ürün Boya Bilgileri

if (isset($_POST['UrunBoyaBilgiEkle'])) {
    $Uid = $_POST['Urun_ID'];
    $Bid = $_POST["Bid"];

    $sor = $baglanti->query("SELECT * FROM urun_boya_bilgi WHERE Urun_ID=" . $Uid . " AND Boya_ID=" . $Bid);
    if ($sor->rowCount()) {
        echo $Kayitvar;
    } else {
        $Kaydet = $baglanti->prepare("INSERT INTO urun_boya_bilgi SET Urun_ID= ?, Boya_ID= ?, icAstar= ?, icUstkat= ?, DisAstar= ?, DisUstkat= ?, Kullanici_ID= ?");
        $SonucSor = $Kaydet->execute(array($Uid, $Bid, $_POST['icAstar'], $_POST['icUstkat'], $_POST['DisAstar'], $_POST['DisUstkat'], $Kullanici));
        header("location:UrunBoyaBilgi.php?Urun_ID=$Uid");
    }
    logtut($Kullanici, "Ürüne boya verisi ekledi.");
}
//---------------------------------------Ürün Levha Bilgileri

if (isset($_POST['UrunLevhaBilgiEkle'])) {
    $ID = $_POST['Urun_ID'];
    $T = $_POST['Tip'];
    $C = $_POST['Cap'];
    $K = $_POST['Kalinlik'];

    //-----------------------------------------------------Levha Varmı Yok mu Sorgu /// Yoksa ekle
    $Varmi = $baglanti->prepare("SELECT Levha_ID FROM levha WHERE Tip= ? AND Cap= ? AND Kalinlik= ?");
    $Varmi->execute(array($T, $C, $K));
    //--------------------------------------------------LEVHA VARMI SOR
    if ($Varmi->rowCount()) {
        $Kaydet = $baglanti->prepare("INSERT INTO urun_levha_bilgi SET Urun_ID= ?, Levha_ID= ?, Kullanici_ID= ?");
        $SonucSor = $Kaydet->execute(array($ID, $Varmi->fetch()['Levha_ID'], $Kullanici));
        header("location:UrunLevhaBilgi.php?Urun_ID=$ID");
    } else {
        //--------------------------------------------------LEVHA BİLGİSİ YOKSA EKLE
        $Kaydet = $baglanti->prepare("INSERT INTO levha SET Tip= ?, Cap= ?, Kalinlik= ?");
        $Kaydet->execute(array($T, $C, $K));
        $Yeniid = $baglanti->lastInsertId();
        $Kaydet = $baglanti->prepare("INSERT INTO urun_levha_bilgi SET Urun_ID= ?, Levha_ID= ?, Kullanici_ID= ?");
        $Kaydet->execute(array($ID, $Yeniid, $Kullanici));
        header("location:UrunLevhaBilgi.php?Urun_ID=$ID");
    }
    logtut($Kullanici, "Ürüne levha verisi ekledi.");
}

//#######################################################################        FİRMA İŞLEMLERİ      ##########################################################################################
//---------------------------------------FİRMA Ekle
if (isset($_POST['FirmaEkle'])) {
    $Ulke = $_POST['Ulke'];
    $Sehir = $_POST['Sehir'];
    $Adres_1 = $_POST['Adres_1'];
    $Adres_2 = $_POST['Adres_2'];
    $Posta_Kodu = $_POST['Posta_Kodu'];

    $Tel_Tip = $_POST['Tel_Tip'];
    $Tel_No = $_POST['Tel_No'];

    $Firma = $_POST['Firma'];
    $VD = $_POST['VD'];
    $Vergi_No = $_POST['Vergi_No'];
    $E_Posta = $_POST['E_Posta'];
    $Web_Sitesi = $_POST['Web_Sitesi'];
    $Aciklama = $_POST['Aciklama'];
    $YetkiliAdi = $_POST['YetkiliAdi'];
    $YetkiliTel = $_POST['YetkiliTel'];

    $SetKaydet = $baglanti->prepare("INSERT INTO firma_adres SET Ulke= ?, Sehir= ?, Adres_1= ?, Adres_2= ?, Posta_Kodu= ?");
    $Sonuc = $SetKaydet->execute(array($Ulke, $Sehir, $Adres_1, $Adres_2, $Posta_Kodu));
    if ($Sonuc) {
        $Adres_ID = $baglanti->lastInsertId();
        $SetKaydet = $baglanti->prepare("INSERT INTO firma_telefon SET Tel_Tip= ?, Tel_No= ?");
        $Sonuc = $SetKaydet->execute(array($Tel_Tip, $Tel_No));
        if ($Sonuc) {
            $Tel_ID = $baglanti->lastInsertId();
            $FirmaKaydet = $baglanti->prepare("INSERT INTO firmalar SET Firma= ?, VD= ?, Vergi_No= ?, Adres_ID= ?, Tel_ID= ?, E_Posta= ?, Web_Sitesi= ?, Aciklama= ?, YetkiliAdi= ?, YetkiliTel= ?, Kullanici_ID= ?");
            $Sonuc = $FirmaKaydet->execute(array($Firma, $VD, $Vergi_No, $Adres_ID, $Tel_ID, $E_Posta, $Web_Sitesi, $Aciklama, $YetkiliAdi, $YetkiliTel, $Kullanici));
        }
    }
    if ($_GET["Sec"] == "true") {
        header("location:Firmalar.php?Sec=true");
    } else {
        header("location:Firmalar.php");
    }
    logtut($Kullanici, "firma ekledi.");
}

//#######################################################################        SİPARİŞ İŞLEMLERİ      ##########################################################################################
//---------------------------------------Sipariş GİDEN Ekle
if (isset($_POST['Teklifver'])) {
    if (isset($_SESSION["Setler"]) || isset($_SESSION["Adetler"]) || isset($_SESSION["FirmaID"])) {
        $Say = $baglanti->query("SELECT COUNT(*) AS S_No FROM view_teklifler");
        $SNo = $Say->fetch()['S_No'];
        $SNo++;
        for ($i = 0; $i < count($_SESSION["Setler"]); $i++) {
            $Kaydet = $baglanti->prepare("INSERT INTO teklif_setler SET S_No= ?, Firma_ID= ?, Set_icerik_ID= ?, Adet= ?");
            $Sonuc = $Kaydet->execute(array($SNo, $_SESSION["FirmaID"], $_SESSION["Setler"][$i], $_SESSION["Adetler"][$i]));
        }

        $id = $baglanti->lastInsertId();

        $Kaydet = $baglanti->prepare("INSERT INTO teklifler SET Teklif_Set_ID= ?, Teslim_Tarihi= ?, Kullanici_ID= ?");
        $Sonuc = $Kaydet->execute(array($id, $_POST['Teslim_Tarihi'], $Kullanici));
        unset($_SESSION["Setler"], $_SESSION["Adetler"], $_SESSION["FirmaID"]);
        header("location:Teklifler.php");
    } else {
        echo $DbHata;
    }
}
