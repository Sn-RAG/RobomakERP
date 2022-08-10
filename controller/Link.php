<?php
//Klasör ve içindeki klasörlerin erişimi için üst dizin erişim linki
$Link = $page != "Ana Sayfa" ?

    ($page == "Ürünler" || $page == "Ürün Tasarla" || $page == "Yeni Ürün" || $page == "Ürün Düzenle" || $page == "Levha Bilgisi Ekle" || $page == "Levha Bilgisi Düzenle" || $page == "Boya Bilgisi Ekle" || $page == "Boya Bilgisi Düzenle" || $page == "Ürün Levha Bilgisi" || $page == "Ürün Boya Bilgisi" ||
        $page == "Set Kontrol" || $page == "Preshane Üretim Formu" || $page == "Boyahane Üretim Formu" || $page == "Levha Hesabı" || $page == "Boya Hesabı" || $page == "Sipariş" || $page == "Sipariş Listesi" || $page == "Kulp Sipariş" || $page == "Tepe Sipariş" || $page == "Kapak Sipariş" || $page == "Boya Sipariş" || $page == "Levha Sipariş" || $page == "Boya Siparişleri" || $page == "Kulp Siparişleri" || $page == "Levha Siparişleri" || $page == "Satış Yap" || $page == "Hazır Teklifler" || $page == "Teklif Hazırla" || $page == "Teklif" || $page == "Ret" || $page == "Onay" ? "../../" : "../")

    : "";
