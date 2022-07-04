<?php
require __DIR__ . '/Db.php';
require __DIR__ . '/VTHataMesaji.php';

//--------------------------------Kullanıcı
if (isset($_GET['KullaniciSil'])) {
    $sil = $baglanti->query("DELETE FROM kullanici WHERE Kullanici_ID=" . strip_tags(htmlspecialchars(trim($_GET['KullaniciSil']))));
} //--------------------------------Setler
elseif (isset($_GET['UretimSetlerSil'])) {
    $Setid = strip_tags(htmlspecialchars(trim($_GET['Set_ID'])));
    try {
        $sorgu = $baglanti->query("DELETE FROM set_icerik WHERE Set_icerik_ID=" . strip_tags(htmlspecialchars(trim($_GET['UretimSetlerSil']))));
    if ($sorgu) {
        $sil = $baglanti->query("DELETE FROM set_urun WHERE Set_ID=" . $Setid);
        if ($sil) {
            $sil = $baglanti->query("DELETE FROM `set` WHERE Set_ID =" . $Setid);
            if ($sil) {
                $sil = $baglanti->query("DELETE FROM set_urun_icerik WHERE Set_ID =" . $Setid);
                if ($sil) {
                    $sil = $baglanti->query("DELETE FROM set_urunler WHERE Set_ID =" . $Setid);
                    if ($sil) {
                        $sil = $baglanti->query("DELETE FROM loglar WHERE Set_ID =" . $Setid);
                        if ($sil) {
                            $sil = $baglanti->query("DELETE FROM set_urunler_asama WHERE Set_ID =" . $Setid);
                        }
                    }
                }
            }
        }
    }
    } catch (\Throwable $th) {
        echo $SilHata;
    }

//--------------------------------Firmalar
} elseif (isset($_GET['FirmalarSil'])) {
    $sorgu = $baglanti->query("DELETE FROM firmalar WHERE Firma_ID=" . strip_tags(htmlspecialchars(trim($_GET['FirmalarSil']))));
    if ($sorgu) {
        $sorgu = $baglanti->query("DELETE FROM firma_adres WHERE Adres_ID=" . strip_tags(htmlspecialchars(trim($_GET['Adres_ID']))));
        if ($sorgu) {
            $sorgu = $baglanti->query("DELETE FROM firma_telefon WHERE Tel_ID=" . strip_tags(htmlspecialchars(trim($_GET['Tel_ID']))));
        }
    }

} //--------------------------------Sipariş GİDEN

elseif (isset($_GET['TeklifSil'])) {
    $sorgu = $baglanti->query("DELETE FROM teklifler WHERE Teklif_ID=" . strip_tags(htmlspecialchars(trim($_GET['TeklifSil']))));
    if ($sorgu) {
        $sorgu = $baglanti->query("DELETE FROM teklif_setler WHERE S_No=" . strip_tags(htmlspecialchars(trim($_GET['S_No']))));
    }
}//############################### Levha Sipariş

elseif (isset($_GET['LevhaSiparisSil'])) {
    $sorgu = $baglanti->query("DELETE FROM levha_siparis WHERE Levha_Siparis_ID =" . strip_tags(htmlspecialchars(trim($_GET['LevhaSiparisSil']))));
    if ($sorgu) {
        $sorgu = $baglanti->query("DELETE FROM levha_stok WHERE Levha_Stok_ID =" . strip_tags(htmlspecialchars(trim($_GET['LevhaStokID']))));
        if ($sorgu) {
            $sorgu = $baglanti->query("DELETE FROM siparis WHERE Siparis_ID =" . strip_tags(htmlspecialchars(trim($_GET['SiparisID']))));
            header("location:LevhaSiparisleri.php");
        }

    }

} //--------------------------------Levha Giden
elseif (isset($_GET['LevhaGidenSil'])) {
    $id = strip_tags(htmlspecialchars(trim($_GET['LevhaGidenSil'])));
    $sor = $baglanti->query("SELECT Levha_Stok_ID, Kullanilan_Adet, Kullanilan_Agirlik FROM levha_giden WHERE Levha_Giden_ID= " . $id);
    $Ekle = $sor->fetch();

    $Kaydet = $baglanti->prepare("UPDATE levha_gelen SET Stok_Adet=Stok_Adet+ ?, Stok_Agirlik=Stok_Agirlik+ ? WHERE Levha_Stok_ID= ?");
    $Kaydet->execute(array((int)$Ekle["Kullanilan_Adet"], (int)$Ekle["Kullanilan_Agirlik"], $Ekle["Levha_Stok_ID"]));
    if ($Kaydet->rowCount()) {
        $sorgu = $baglanti->query("DELETE FROM levha_giden WHERE Levha_Giden_ID =" . $id);
        header("location:LevhaSiparisleri.php");
    }


} //--------------------------------Levha Gelen

elseif (isset($_GET['LevhaGelenSil'])) {
    $id = strip_tags(htmlspecialchars(trim($_GET['LevhaGelenSil'])));
    $kntrl = strip_tags(htmlspecialchars(trim($_GET['LevhaGdnKntrl'])));

    if ($kntrl != "") {
        $sor = $baglanti->query("SELECT Levha_Stok_ID, Kullanilan_Adet, Kullanilan_Agirlik FROM levha_giden WHERE Levha_Giden_ID= " . $kntrl);
        if ($sor->rowCount()) {

            echo $Kullanilanvar;

        }
    } else {
        $sor = $baglanti->query("SELECT Levha_Stok_ID, Stok_Adet, Stok_Agirlik FROM levha_gelen WHERE Levha_Gelen_ID= " . $id);
        $Ekle = $sor->fetch();

        $Kaydet = $baglanti->prepare("UPDATE levha_stok SET Siparis_Adet=Siparis_Adet+ ?, Siparis_Agirlik=Siparis_Agirlik+ ? WHERE Levha_Stok_ID= ?");
        $Kaydet->execute(array((int)$Ekle["Stok_Adet"], (int)$Ekle["Stok_Agirlik"], $Ekle["Levha_Stok_ID"]));
        if ($Kaydet->rowCount()) {
            $sorgu = $baglanti->query("DELETE FROM levha_gelen WHERE Levha_Gelen_ID =" . $id);
        }
        header("location:LevhaSiparisleri.php");
    }


}//############################### Boya Sipariş

elseif (isset($_GET['Boya_Siparis_Sil'])) {
    $sorgu = $baglanti->query("DELETE FROM boya_siparis WHERE Boya_Siparis_ID=" . strip_tags(htmlspecialchars(trim($_GET['Boya_Siparis_Sil']))));
    if ($sorgu) {
        $sorgu = $baglanti->query("DELETE FROM boya_stok WHERE Boya_Stok_ID =" . strip_tags(htmlspecialchars(trim($_GET['Boya_Stok_ID']))));
        if ($sorgu) {
            $sorgu = $baglanti->query("DELETE FROM siparis WHERE Siparis_ID =" . strip_tags(htmlspecialchars(trim($_GET['Siparis_ID']))));
            header("location:BoyaSiparisleri.php");
        }
    }
} //--------------------------------Boya Giden
elseif (isset($_GET['BoyaGidenSil'])) {

    $id = strip_tags(htmlspecialchars(trim($_GET['BoyaGidenSil'])));
    $sor = $baglanti->query("SELECT Boya_Stok_ID, Kullanilan_Miktar FROM boya_giden WHERE Boya_Giden_ID= " . $id);
    $Ekle = $sor->fetch();

    $Kaydet = $baglanti->prepare("UPDATE boya_gelen SET Stok_Miktar=Stok_Miktar+ ? WHERE Boya_Stok_ID= ?");
    $Kaydet->execute(array((int)$Ekle["Kullanilan_Miktar"], $Ekle["Boya_Stok_ID"]));
    if ($Kaydet->rowCount()) {
        $sorgu = $baglanti->query("DELETE FROM boya_giden WHERE Boya_Giden_ID=" . $id);
        header("location:BoyaSiparisleri.php");
    }
} //--------------------------------Boya Gelen
elseif (isset($_GET['BoyaGelenSil'])) {

    $id = strip_tags(htmlspecialchars(trim($_GET['BoyaGelenSil'])));
    $kntrl = strip_tags(htmlspecialchars(trim($_GET['BoyaGdnKntrl'])));

    if ($kntrl != "") {
        $sor = $baglanti->query("SELECT Boya_Stok_ID, Kullanilan_Miktar FROM boya_giden WHERE Boya_Giden_ID= " . $kntrl);
        if ($sor->rowCount()) {

            echo $Kullanilanvar;
        }
    } else {
        $sor = $baglanti->query("SELECT Boya_Stok_ID, Stok_Miktar FROM boya_gelen WHERE Boya_Gelen_ID= " . $id);
        $Ekle = $sor->fetch();

        $Kaydet = $baglanti->prepare("UPDATE boya_stok SET Siparis_Miktar= Siparis_Miktar+ ? WHERE Boya_Stok_ID= ?");
        $Kaydet->execute(array((int)$Ekle["Stok_Miktar"], $Ekle["Boya_Stok_ID"]));
        if ($Kaydet->rowCount()) {
            $sorgu = $baglanti->query("DELETE FROM boya_gelen WHERE Boya_Gelen_ID=" . $id);
            header("location:BoyaSiparisleri.php");
        }
    }


}//############################### Kulp Sipariş
elseif (isset($_GET['KulpSiparisSil'])) {

    $sorgu = $baglanti->query("DELETE FROM kulp_siparis WHERE Kulp_Siparis_ID =" . strip_tags(htmlspecialchars(trim($_GET['KulpSiparisSil']))));
    if ($sorgu) {
        $sorgu = $baglanti->query("DELETE FROM kulp_stok WHERE Kulp_Stok_ID =" . strip_tags(htmlspecialchars(trim($_GET['Kulp_Stok_ID']))));
        if ($sorgu) {
            $sorgu = $baglanti->query("DELETE FROM siparis WHERE Siparis_ID =" . strip_tags(htmlspecialchars(trim($_GET['Siparis_ID']))));
        }
    }

}//--------------------------------Kulp Gelen
elseif (isset($_GET['KulpGelenSil'])) {
    $id = strip_tags(htmlspecialchars(trim($_GET['KulpGelenSil'])));
    $kntrl = strip_tags(htmlspecialchars(trim($_GET['KulpGdnKntrl'])));

    if ($kntrl != "") {
        $sor = $baglanti->query("SELECT Kulp_Stok_ID, Kullanilan_Adet FROM kulp_giden WHERE Kulp_Giden_ID=" . $kntrl);
        if ($sor->rowCount()) {

            echo $Kullanilanvar;
        }
    } else {
        $sor = $baglanti->query("SELECT Kulp_Stok_ID, Stok_Adet FROM kulp_gelen WHERE Kulp_Gelen_ID= " . $id);
        $Ekle = $sor->fetch();

        $Kaydet = $baglanti->prepare("UPDATE kulp_stok SET Siparis_Adet= Siparis_Adet+ ? WHERE Kulp_Stok_ID= ?");
        $Kaydet->execute(array((int)$Ekle["Stok_Adet"], $Ekle["Kulp_Stok_ID"]));
        if ($Kaydet->rowCount()) {
            $sorgu = $baglanti->query("DELETE FROM kulp_gelen WHERE Kulp_Gelen_ID=" . $id);
            header("location:KulpSiparisleri.php");
        }
    }
}//--------------------------------Kulp Giden
elseif (isset($_GET['KulpGidenSil'])) {

    $id = strip_tags(htmlspecialchars(trim($_GET['KulpGidenSil'])));
    $sor = $baglanti->query("SELECT Kulp_Stok_ID, Kullanilan_Adet FROM kulp_giden WHERE Kulp_Giden_ID= " . $id);
    $Ekle = $sor->fetch();

    $Kaydet = $baglanti->prepare("UPDATE kulp_gelen SET Stok_Adet=Stok_Adet+ ? WHERE Kulp_Stok_ID= ?");
    $Kaydet->execute(array((int)$Ekle["Kullanilan_Adet"], $Ekle["Kulp_Stok_ID"]));
    if ($Kaydet->rowCount()) {
        $sorgu = $baglanti->query("DELETE FROM kulp_giden WHERE Kulp_Giden_ID=" . $id);
        header("location:KulpSiparisleri.php");
    }

}//############################### Kapak Sipariş
elseif (isset($_GET['KapakSiparisSil'])) {

}//--------------------------------Kapak Gelen
elseif (isset($_GET['KapakGelenSil'])) {

}//--------------------------------Kapak Giden
elseif (isset($_GET['KapakGidenSil'])) {

} ########################################################################
elseif (isset($_GET['UrunTasarimiSil'])) {
    $sorgu = $baglanti->query("DELETE FROM yeni_urun");
    if ($sorgu->rowCount()) {
        $baglanti->query("DELETE FROM yeni_urun_bilgi");
    }
    header("location:../../Uretim/UrunTasarla/UrunTasarla.php");


} elseif (isset($_GET['Yeni_Urun_Bilgi_ID'])) {


    $id = strip_tags(htmlspecialchars(trim($_GET['Yeni_Urun_Bilgi_ID'])));
    $sorgu = $baglanti->query("DELETE FROM yeni_urun WHERE Yeni_Urun_Bilgi_ID=" . $id);
    if ($sorgu->rowCount()) {
        $baglanti->query("DELETE FROM yeni_urun_bilgi WHERE Yeni_Urun_Bilgi_ID=" . $id);
    }
    header("location:../../Uretim/UrunTasarla/UrunTasarla.php");


} elseif (isset($_GET['YeniSetLevhaTumSil'])) {

    $sorgu = $baglanti->query("DELETE FROM yeniset_levha");
    header("location:Anasayfa.php");

} elseif (isset($_GET['YeniSetLevhaSil'])) {

    $sorgu = $baglanti->query("DELETE FROM yeniset_levha WHERE YeniSet_Levha_ID=" . strip_tags(htmlspecialchars(trim($_GET['YeniSetLevhaSil']))));
    header("location:Anasayfa.php");
}