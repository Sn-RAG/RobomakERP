<div class="modal fade" id="ResimSec" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Resim Seç</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php

                    $dizin = "../../assets/img/Keksan";
                    $tutucu = opendir($dizin);
                    while ($dosya = readdir($tutucu)) {
                        if (is_file($dizin . "/" . $dosya))
                            $resim[] = $dosya;
                    }
                    closedir($tutucu);

                    $limit = 1000; //Bir sayfada gösterilecek resim sayısı
                    $toplam = count($resim);
                    if ($limit > $toplam) $limit = $toplam;

                    for ($i = 0; $i < $limit; $i++) {

                        if ($page == "Yeni Ürün") {
                            $link = "UrunEkle.php?UrunFoto=$resim[$i]";
                        } else {
                            $link = "UrunDuzenle.php?Urun_ID=$Urun_ID&UrunFoto=$resim[$i]&UrunAdi=$UrunAdi&Aciklama=$Aciklama&Kategori_ID=$Kategori_ID&KategoriAdi=$KategoriAdi&UrunAdi=$UrunAdi";
                        }

                        echo "<div class='col-md-3 mb-1 m-md-1 img-thumbnail'><a href='$link'><img src='$dizin/$resim[$i]' width='100' height='100' border='0'></a></div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>