<?php
require __DIR__ . '/../../../controller/Db.php';

//                                              Kullanıcıya özel Set için

session_start();
$SorKullanici = $baglanti->prepare("SELECT * FROM kullanici WHERE Kadi= ?");
$SonucKul = $SorKullanici->execute(array($_SESSION["Kullanici"]));
$bakKul = $SorKullanici->fetch();
$Kullanici = $bakKul['Kullanici_ID'];


#######################################################################################################################################

//                                              Set Adlarını çek

if (isset($_POST['set'])) {
    $query = $baglanti->prepare('SELECT * FROM `set` WHERE SetAdi LIKE ? LIMIT 7');
    $query->execute(array('%' . $_POST['set'] . '%'));
    if ($query->rowCount()) {
        foreach ($query as $nt) {
            echo "<li class='hover text-center' id='$nt[Set_ID]'> $nt[SetAdi]</li>";
        }
    } else {
        echo "<li class='hover'> Set Bulunamadı</li>";
    }


    #######################################################################################################################################

    //                                          Fotoğrafı Çek

} elseif (isset($_POST['Foto'])) {
    $sor = $baglanti->query("SELECT UrunFoto  FROM view_urun_levha_bilgi WHERE  Urun_ID=" . (int)$_POST['Foto']);
    $bak = $sor->fetch();
    if ($sor->rowCount()) {
        echo "<img src='../../assets/img/Keksan/$bak[UrunFoto]' width='250px' height='200px'>";
    } else {
        echo "<img src='' width='250px' height='200px'>";
    }


    #######################################################################################################################################

    //                                          Ürün Ara

} elseif (isset($_POST['kelime'])) {
    $query = $baglanti->prepare('SELECT Kategori_ID, Urun_ID, UrunAdi FROM urun WHERE UrunAdi LIKE ? LIMIT 7');
    $query->execute(array('%' . $_POST['kelime'] . '%'));
    if ($query->rowCount()) {
        foreach ($query as $nt) {
            echo "<li class='hover text-center' Urun_ID='$nt[Urun_ID]'>$nt[UrunAdi]</li>";
        }
    } else {
        echo "<li class='hover'> Ürün Bulunamadı</li>";
    }


    #######################################################################################################################################

    //                                          Boya Bilgilerini çek


} elseif (isset($_POST['Boya'])) {
    $sor = $baglanti->query("SELECT * FROM urun_boya_bilgi WHERE  Urun_ID=" . (int)$_POST['Boya']);
    if ($sor->rowCount()) {
        foreach ($sor as $s) {
            echo "<option icAstar='$s[icAstar]' icUstkat='$s[icUstkat]' DisAstar='$s[DisAstar]' DisUstkat='$s[DisUstkat]' value='$s[BoyaTipi]'>$s[BoyaTipi]</option>";
        }
    } else {
        echo '<option>Renk Bulunamadı</option>';
    }

    #######################################################################################################################################

    //                                          Levha Bilgilerini çek


} elseif (isset($_POST['Capi'])) {
    $sor = $baglanti->query("SELECT DISTINCT Cap FROM view_urun_levha_bilgi WHERE  Urun_ID=" . (int)$_POST['Capi']);
    if ($sor->rowCount()) {
        foreach ($sor as $s) {
            echo "<option value='$s[Cap]'>$s[Cap]</option>";
        }
    } else {
        echo '<option>Kalınlık Bulunamadı</option>';
    }
} elseif (isset($_POST['Kalinlik'])) {
    $sor = $baglanti->query("SELECT DISTINCT Kalinlik FROM view_urun_levha_bilgi WHERE  Urun_ID=" . (int)$_POST['Kalinlik']);
    if ($sor->rowCount()) {
        foreach ($sor as $s) {
            echo "<option value='$s[Kalinlik]'>$s[Kalinlik]</option>";
        }
    } else {
        echo '<option>Kalınlık Bulunamadı</option>';
    }


    #######################################################################################################################################

    ////         //////////////                      Kayit işlemi


} elseif (isset($_POST['Kayit'])) {
    $UrunBilgi = $baglanti->prepare("INSERT INTO yeni_urun_bilgi SET 
    Kalinlik= ?, 
    Cap= ?, 
    Agirlik= ?, 
    icAstar= ?, 
    icUstkat= ?, 
    DisUstkat= ?, 
    DisAstar= ?, 
    Adet= ?");
    $UrunBilgi->execute(array(
        (float)$_POST['TKalinlik'],
        (float)$_POST['Cap'],
        (float)$_POST['Kg'],
        (float)$_POST['Kg_icAstar'],
        (float)$_POST['Kg_icUstkat'],
        (float)$_POST['Kg_DisUstkat'],
        (float)$_POST['Kg_DisAstar'],
        1
    ));
    $bid = $baglanti->lastInsertId();
    $kayit = $baglanti->prepare("INSERT INTO yeni_urun SET Urun_ID= ?, Yeni_Urun_Bilgi_ID= ?, Kullanici_ID= ?");
    $kayit->execute(array(
        (int)$_POST['UrunID'], $bid,
        $Kullanici
    ));




    ###############################################################################################################################################################################################

    //                                                  SET LİSTELE

} elseif (isset($_POST['SetListele'])) {

    $sec = $baglanti->query("SELECT * FROM view_yeni_urun WHERE Kullanici_ID=" . $Kullanici);

    if ($sec->rowCount()) {
        echo "<script>$('#Set').prop('disabled', false); $('#SetKayit').prop('disabled', false);</script>"; // Eğer içerik varsa buton etkinleşsin

        //////////////////////////////////////////////// Toplam Levha Listele

        echo "<div class='col-md-6 mb-3 fw-bold'>Toplam Levha<br>";
        $UrunKalinlik = $baglanti->query("SELECT Kalinlik, Adet, Carp_Agirlik FROM view_yeni_urun GROUP BY Kalinlik");
        foreach ($UrunKalinlik as $mm) {
            echo "<code class='fs-5'>$mm[Adet]</code>&nbsp;&nbsp;Adet :&nbsp;<code class='fs-5'>$mm[Kalinlik]</code>&nbsp;mm&nbsp;<code class='fs-5'><br>
" . number_format($mm['Carp_Agirlik']) . "</code>&nbsp;Kg<br>
<input type='hidden' value='$mm[Carp_Agirlik]' name='T_Kg'>";
        }
        echo "</div>";

        ///////////////////////////////////////////// Toplam Boya Listele

        $topla = $baglanti->query("SELECT ROUND(SUM(Carp_icAstar),2) AS icAstar, ROUND(SUM(Carp_icUstkat),2) AS icUstkat, ROUND(SUM(Carp_DisUstkat),2) AS DisUstkat,  ROUND(SUM(Carp_DisAstar),2) AS DisAstar FROM view_yeni_urun");
        $snc = $topla->fetch();
        $TiA = $snc["icAstar"];
        $TiU = $snc["icUstkat"];
        $TdA = $snc["DisAstar"];
        $TdU = $snc["DisUstkat"];
        echo "<div class='col-md-6 mb-3 fw-bold'>Toplam Boya<br>
İç Astar:&nbsp;&nbsp;<code class='fs-5'>$TiA</code>&nbsp;Kg<br>
İç Üstkat:&nbsp;&nbsp;<code class='fs-5'>$TiU</code>&nbsp;Kg<br>
Dış Astar:&nbsp;&nbsp;<code class='fs-5'>$TdA</code>&nbsp;Kg<br>
Dış Üstkat:&nbsp;&nbsp;<code class='fs-5'>$TdU</code>&nbsp;Kg</div>
<input type='hidden' value='$TiA' name='T_icAstar'>
<input type='hidden' value='$TiU' name='T_icUstKat'>
<input type='hidden' value='$TdA' name='T_DisAstar'>
<input type='hidden' value='$TdU' name='T_DisUtKat'>";

        ///////////////////////////////////////Tümünü Sil Butonu

        echo "<div class='modal-header fs-5'>Ürünler<a href='UrunTasarla.php?UrunTasarimiSil'><button type='button' class='btn btn-sm btn-outline-danger mb-3'>Tümünü Sil</button></a></div>";

        ////////////////////////////////////////////////////////////////////////////

        echo "<ol class='list-group list-group-numbered'>";
        foreach ($sec as $s) {
            echo "<li class='list-group-item d-flex justify-content-between align-items-start'>
<div class='fw-bold'> $s[UrunAdi] &nbsp <span class='badge bg-primary rounded-pill'>
<input type='number' name='Adet$s[Yeni_Urun_Bilgi_ID]' value='$s[Adet]'>
</span></div>
<span class='badge bg-danger-light rounded-pill'><a href='UrunTasarla.php?Yeni_Urun_Bilgi_ID=$s[Yeni_Urun_Bilgi_ID]'><button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></a></span>
</li>";

            // Döngü İçinde idye özel adet kaydı

            echo "<script>
        $(document).on('change', 'input[name=Adet$s[Yeni_Urun_Bilgi_ID]]', function () {
            var Adet = $(this).val();            
            $.ajax({
                    type: 'POST',
                    url: 'AjaxForm/post.php',
                    data: {
                        'Yeni_Urun_Bilgi_ID':$s[Yeni_Urun_Bilgi_ID],
                        'Adet': Adet,
                        'AdetKontrol':true,
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert('Hata: ' + xhr.responseText);
                    },
                    success: function (data) {
                        $('.UrunYaz').html(data);
                        $('input[name=Adet$s[Yeni_Urun_Bilgi_ID]]').val($s[Adet]);
                    }
                });
        });
</script>";
        }
        echo "</ol>";
    } else {
        echo '<h5>Ürün Yok</h5>';
    }


    ###############################################################################################################################################################################################

    //                                                      ADET GÜNCELLEME İŞLEMİ

} elseif (isset($_POST['AdetKontrol'])) {

    $Adet = $baglanti->prepare("UPDATE yeni_urun_bilgi SET Adet= ? WHERE Yeni_Urun_Bilgi_ID= ?");
    $Adet->execute(array((int)$_POST['Adet'], (int)$_POST['Yeni_Urun_Bilgi_ID']));

    echo "<script>$.SetListele();</script>";
}
