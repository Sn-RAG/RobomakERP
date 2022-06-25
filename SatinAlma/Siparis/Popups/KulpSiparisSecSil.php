<div class="modal fade" id="SecSil<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tarihe Göre Sil</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php
                echo "<H5 class='text-center'>KULLAN</H5>";
                $sor = $baglanti->query('SELECT Kulp_Giden_ID, Duzenleme_Tarihi FROM kulp_giden WHERE Kulp_Stok_ID=' . $Kulp_Stok_ID);
                foreach ($sor as $sonuc4) {

                    echo "<a href='KulpSiparisleri.php?KulpGidenSil=$sonuc4[Kulp_Giden_ID]'><div class='form-floating mb-1'><button class='form-control btn-outline-danger'>$sonuc4[Duzenleme_Tarihi]</button><label>Kullanma Tarihi</label></div></a>";

                }
                echo "<h5 class='text-center'>STOK</h5>";
                $sor3 = $baglanti->query('SELECT Kulp_Giden_ID FROM kulp_giden WHERE Kulp_Stok_ID=' . $Kulp_Stok_ID)->fetch();
                @$kntrl = $sor3["Kulp_Giden_ID"];
                $sor2 = $baglanti->query('SELECT Kulp_Gelen_ID, Duzenleme_Tarihi FROM kulp_gelen WHERE Kulp_Stok_ID=' . $Kulp_Stok_ID);
                foreach ($sor2 as $sonuc5) {

                    echo "<a href='KulpSiparisleri.php?KulpGelenSil=$sonuc5[Kulp_Gelen_ID]&KulpGdnKntrl=$kntrl'><div class='form-floating mb-1'><button class='form-control btn-outline-danger'>$sonuc5[Duzenleme_Tarihi]</button><label>Teslim Tarihi</label></div></a>";

                }
                ?>
            </div>
            <div class="modal-footer">
                <a href="KulpSiparisleri.php?KulpSiparisSil=<?= $id ?>&Kulp_Stok_ID=<?= $Kulp_Stok_ID ?>&Siparis_ID=<?= $Siparis_ID ?>">
                    <button type="button" class="btn btn-outline-danger form-control">Sipariş Sil</button>
                </a>
            </div>
        </div>
    </div>
</div>