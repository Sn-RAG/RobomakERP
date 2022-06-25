<?php
require __DIR__ . '/Db.php';
require __DIR__ . '/VTHataMesaji.php';

//--------------------------------Kullanici Kim

$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];

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
}

//---------------------------------------Ürün Boya Bilgileri

if (isset($_POST['UrunBoyaBilgiEkle'])) {
    $Urun_ID = $_POST['Urun_ID'];
    $BoyaTipi = $_POST['BoyaTipi'];
    $İcAstar = $_POST['icAstar'];
    $icUstkat = $_POST['icUstkat'];
    $DisAstar = $_POST['DisAstar'];
    $DisUstkat = $_POST['DisUstkat'];
    $SetVarmi = $baglanti->prepare("SELECT BoyaTipi FROM urun_boya_bilgi WHERE Urun_ID= ?");
    $SonucSor = $SetVarmi->execute(array($Urun_ID));
    $bak = $SetVarmi->fetch();
    if ($BoyaTipi == $bak['BoyaTipi']) {
        echo $Kayitvar;
    } else {
        $Kaydet = $baglanti->prepare("INSERT INTO urun_boya_bilgi SET Urun_ID= ?, BoyaTipi= ?, icAstar= ?, icUstkat= ?, DisAstar= ?, DisUstkat= ?, Kullanici_ID= ?");
        $SonucSor = $Kaydet->execute(array($Urun_ID, $BoyaTipi, $İcAstar, $icUstkat, $DisAstar, $DisUstkat, $Kullanici));
        header("location:UrunBoyaBilgi.php?Urun_ID=$Urun_ID");
    }
}
//---------------------------------------Ürün Levha Bilgileri

if (isset($_POST['UrunLevhaBilgiEkle'])) {
    $Urun_ID = $_POST['Urun_ID'];
    $Tip = $_POST['Tip'];
    $Cap = $_POST['Cap'];
    $Kalinlik = $_POST['Kalinlik'];

//-----------------------------------------------------Levha Varmı Yok mu Sorgu /// Yoksa ekle
    $LevhaVarmi = $baglanti->prepare("SELECT Levha_ID FROM levha WHERE Tip= ? AND Cap= ? AND Kalinlik= ?");
    $Sor = $LevhaVarmi->execute(array($Tip, $Cap, $Kalinlik));
    $bak = $LevhaVarmi->fetch();
//--------------------------------------------------LEVHA VARMI SOR
    if ($LevhaVarmi->rowCount() > 0) {
        $Kaydet = $baglanti->prepare("INSERT INTO urun_levha_bilgi SET Urun_ID= ?, Levha_ID= ?, Kullanici_ID= ?");
        $SonucSor = $Kaydet->execute(array($Urun_ID, $bak['Levha_ID'], $Kullanici));
        header("location:UrunLevhaBilgi.php?Urun_ID=$Urun_ID");

    } else {
//--------------------------------------------------LEVHA BİLGİSİ YOKSA EKLE
        $Kaydet = $baglanti->prepare("INSERT INTO levha SET Tip= ?, Cap= ?, Kalinlik= ?");
        $Kaydet->execute(array($Tip, $Cap, $Kalinlik));
        $Yeniid = $baglanti->lastInsertId();
        $Kaydet = $baglanti->prepare("INSERT INTO urun_levha_bilgi SET Urun_ID= ?, Levha_ID= ?, Kullanici_ID= ?");
        $Kaydet->execute(array($Urun_ID, $Yeniid, $Kullanici));
        header("location:UrunLevhaBilgi.php?Urun_ID=$Urun_ID");
    }
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
    if ($_GET["Sec"]=="true"){
        header("location:Firmalar.php?Sec=true");
    }else{
        header("location:Firmalar.php");
    }
}

//#######################################################################        SİPARİŞ İŞLEMLERİ      ##########################################################################################
//---------------------------------------Sipariş GİDEN Ekle
if (isset($_POST['Teklifver'])) {
    $Firma_ID = $_POST['Firma_ID'];
    $Teslim_Tarihi = $_POST['Teslim_Tarihi'];

    $Say = $baglanti->query("SELECT COUNT(*) AS S_No FROM view_teklifler");
    $SNo = $Say->fetch()['S_No'];
    $SNo++;


    for ($i = 0; $i < count($Setler_IDler); $i++) {
        $Kaydet = $baglanti->prepare("INSERT INTO teklif_setler SET S_No= ?, Firma_ID= ?, Uretim_Setler_ID= ?, Adet= ?");
        $Sonuc = $Kaydet->execute(array($SNo, $Firma_ID, $Setler_IDler[$i], $Adetler[$i]));
    }

    $id = $baglanti->lastInsertId();

    $Kaydet = $baglanti->prepare("INSERT INTO teklifler SET Teklif_Set_ID= ?, Teslim_Tarihi= ?, Kullanici_ID= ?");
    $Sonuc = $Kaydet->execute(array($id, $Teslim_Tarihi, $Kullanici));
    header("location:Teklifler.php");
}

########################################   Kulp Sipariş Ekle

if (isset($_POST['KulpSiparis'])) {
    $TFirma = 1;//$_POST['TFirma'];
    $KulpAdi = $_POST['KulpAdi'];
    $Cesit = $_POST['Cesit'];
    $KulpRenk = $_POST['KulpRenk'];
    $Adet = $_POST['Adet'];

    $S_Tarihi = $_POST['S_Tarihi'];

    $Varmi = $baglanti->prepare("SELECT Kulp_ID FROM kulp WHERE KulpAdi= ? AND KulpCesidi= ? AND Renk= ?");
    $Varmi->execute(array($KulpAdi, $Cesit, $KulpRenk));

    if ($Varmi->rowCount()) {
        $Kulp_ID = $Varmi->fetch()['Kulp_ID'];
    } else {
        // Değilse yeni Kulp ekle
        $Kaydet = $baglanti->prepare("INSERT INTO kulp SET Firma_ID= ?, KulpAdi= ?, KulpCesidi= ?, Renk= ?");
        $Kaydet->execute(array($TFirma, $KulpAdi, $Cesit, $KulpRenk));
        $Kulp_ID = $baglanti->lastInsertId();
    }

    $Siparis = $baglanti->prepare("INSERT INTO siparis SET Siparis= ?, Adet= ?, Agirlik= ?, S_Tarihi= ?, Kullanici_ID= ?");
    $Siparis->execute(array("Kulp", $Adet, 0, $S_Tarihi, $Kullanici));
    $Siparis_ID = $baglanti->lastInsertId();

//--------------------------STOĞA EKLE
    $StokKaydet = $baglanti->prepare("INSERT INTO kulp_stok SET Siparis_Adet= ?");
    $StokKaydet->execute(array($Adet));
    $StokID = $baglanti->lastInsertId();

    $siparisKaydet = $baglanti->prepare("INSERT INTO kulp_siparis SET Siparis_ID= ?, Kulp_Stok_ID= ?, Kulp_ID= ?");
    $siparisKaydet->execute(array((int)$Siparis_ID, (int)$StokID, (int)$Kulp_ID));

    header("location:Siparis.php");

}


//#######################################################################        SET İŞLEMLERİ      ##########################################################################################

//-------------------------------------------------------------------------SET İşlemleri
//                                      SetYeni Kayıt

if (isset($_POST['YeniSetKayit'])) {
    $SetID = $_POST['SetID'];

    $T_Kg = round($_POST['T_Kg']);

    $T_icAstar = $_POST['T_icAstar'];
    $T_icUstKat = $_POST['T_icUstKat'];
    $T_DisAstar = $_POST['T_DisAstar'];
    $T_DisUtKat = $_POST['T_DisUtKat'];


//                                                            Levha Sipariş Kontrolü


    $Urun = $baglanti->query("SELECT Urun_ID, Adet, Kalinlik, Cap FROM yeniset_gram");
    foreach ($Urun as $Urunler) {

        $UrunID = $Urunler['Urun_ID'];
        $Kalinlik = $Urunler['Kalinlik'];
        $Cap = $Urunler['Cap'];
        $Adet = $Urunler['Adet'];

        $Sr = $baglanti->query("SELECT view_siparis_levha.Urun_ID, levha_stok.Siparis_Adet+levha_gelen.Stok_Adet AS ToplamAdet, levha_stok.Siparis_Agirlik+levha_gelen.Stok_Agirlik AS ToplamKg, yeniset.Adet, yeniset.Kg FROM view_siparis_levha 
        INNER JOIN yeniset ON view_siparis_levha.Urun_ID = yeniset.Urun_ID
        INNER JOIN levha_stok ON view_siparis_levha.Levha_Stok_ID = levha_stok.Levha_Stok_ID
        INNER JOIN levha_gelen ON view_siparis_levha.Levha_Stok_ID = levha_gelen.Levha_Stok_ID
        WHERE view_siparis_levha.Urun_ID=" . $UrunID);
        if ($Sr->rowCount()) {
            foreach ($Sr as $SrU) {
                $UrunKg = round($SrU['Kg']);
                $UrunAdet = $SrU['Adet'];
                $StokKg = $SrU['ToplamKg'];
                $StokAdet = $SrU['ToplamAdet'];

// Ürünün Levhası Stokta Yeteri Kadar Var

                if ($UrunKg <= $StokKg & $UrunAdet <= $StokAdet) {
                    $sumKG = $StokKg - $UrunKg;
                    $sumAdet = $StokAdet - $UrunAdet;

                    $Kaydet = $baglanti->prepare("INSERT INTO yeniset_levha SET Urun_ID= ?, Kg= ?, Adet= ?");
                    $Kaydet->execute(array($UrunID, $sumKG, $sumAdet));

// Ürünün Levhası Stokta Az Miktarda Var

                } else {
                    $sumKG_Eksik = $StokKg - $UrunKg;
                    $sumAdet_Eksik = $StokAdet - $UrunAdet;

                    $Kaydet = $baglanti->prepare("INSERT INTO yeniset_levha SET Urun_ID= ?, Kg= ?, Adet= ?");
                    $Kaydet->execute(array($UrunID, $sumKG_Eksik, $sumAdet_Eksik));
                }
            }

// Ürünün Levhası Stokta Hiç Yok

        } else {
            $sum = $Cap * $Cap * $Kalinlik * 0.22;
            $Kg = $Adet * $sum / 1000;
            $Kg = round($Kg) * -1;
            $Adet *= -1;
            $Kaydet = $baglanti->prepare("INSERT INTO yeniset_levha SET Urun_ID= ?, Kg= ?, Adet= ?");
            $Kaydet->execute(array($UrunID, $Kg, $Adet));
        }
    }
}