<div class="modal fade" id="UrunBilgi<?= $Adi['Set_ID'] ?>" tabindex="-1">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $Adi['SetAdi'] ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card-subtitle">Ürünler</div>
                <hr>
                <div class="row">
                    <?php
                    $Ad1 = $baglanti->query("SELECT Urun_ID FROM set_urun WHERE  Set_ID=" . $Adi['Set_ID']);
                    foreach ($Ad1 as $Adi1) {

                        $Ad2 = $baglanti->query("SELECT UrunAdi, Aciklama FROM urun WHERE Urun_ID=" . $Adi1['Urun_ID']);
                        foreach ($Ad2 as $Adi2) {
                            echo "<div class='col-md-6'>
                            <div class='fw-bold'>$Adi2[UrunAdi]</div>
                            $Adi2[Aciklama]
                        </div>
                        ";
                        }
                    }
                    ?></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div><!-- End Modal Dialog Scrollable-->

</div>