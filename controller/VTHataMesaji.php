<?php
$DbHata = "<script>
        Swal.fire({
        icon: 'error',
        title: 'Hata!',
        text: 'Lütfen girişleri kontrol et!',
        confirmButtonText: 'Tamam',
        })
        </script>";

$FazlaDeger = "Swal.fire({
        icon: 'warning',
        title: 'Fazla Değer!',
        text: 'Toplam değerden fazla!',
        confirmButtonText: 'Tamam',
    });";

$Gecersiz = "Swal.fire({
        icon: 'warning',
        title: 'Geçersiz ya da boş değer!',
        text: 'Negatif ya da boş değer kaydedemezsiniz.',
        confirmButtonText: 'Tamam',
    });";
$StokYok = "Swal.fire({
        icon: 'error',
        title: 'Stok yok!',
        text: 'Yeni sipariş açın.',
        confirmButtonText: 'Tamam',
    });";
$BoyaBilgisiYok = "Swal.fire({
        icon: 'error',
        title: 'Boya Bilgisi yok!',
        text: 'Ürün boya bilgilerini kontrol edin.',
        confirmButtonText: 'Tamam',
    });";
$UrunLevhaYok = "Swal.fire({
        icon: 'error',
        title: 'Bazı Ürünlerin levha bilgisi yok!',
        text: 'Ürünlerin bilgilerini kontrol edin ve seti yeniden oluşturun.',
        confirmButtonText: 'Tamam',
    });";
$Kayitvar = "<script>Swal.fire({
        icon: 'error',
        title: 'Kayıt zaten mevcut!',
        text: 'Var olan Kaydı oluşturamazsın!',
        confirmButtonText: 'Tamam',
    })</script>";
$SilHata = "<script>Swal.fire({
        icon: 'error',
        title: 'Teklif verilen Set silinemez!',
        confirmButtonText: 'Tamam',
    })</script>";
$KayitAcilmamis = "<script>Swal.fire({
        icon: 'warning',
        title: 'Ürün Kaydedilmemiş!',
        text: 'Yöneticinizle iletişime geçin!',
        confirmButtonText: 'Tamam',
    })</script>";


$Kullanilanvar = "<script>Swal.fire({
        icon: 'warning',
        title: 'Stoktan Kullanılmış!',
        text: 'Stoğu Silmek için önce kullanılan miktarları kaldırın!',
        confirmButtonText: 'Tamam',
    })</script>";

$SiparisTamam = "Swal.fire({
        icon: 'warning',
        title: 'Sipariş Tamamlandı!',
        text: 'Sipariş Edilen Miktarın Tamamı Stokta!',
        confirmButtonText: 'Tamam',
    })";
$Kayitvarr = "Swal.fire({
        icon: 'error',
        title: 'Kayıt zaten mevcut!',
        text: 'Var olan Kaydı oluşturamazsın!',
        confirmButtonText: 'Tamam',
    })";
$Baska = "Swal.fire({
        icon: 'error',
        title: 'Kalınlık Farklı Olamaz!',
        text: 'Seçimi Kaldırın!',
        confirmButtonText: 'Tamam',
    })";
