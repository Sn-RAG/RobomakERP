<div class="modal fade" id="UrunBilgi<?=$Sid?>" tabindex="-1">
    <div class="modal-dialog modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $Sadi ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <h5> Levha Hesabı</h5>
            <a href="HesapLevha.php?id=<?=$Sid?>&adet=<?=$Adet?>&adi=<?=$Sadi?>" class='btn btn-success mb-3'><?=$Sadi?> Levha Hesabı</a>
                <div class="row">
                    <?php
                    $Ad1 = $baglanti->query("SELECT Urun_ID FROM set_urun WHERE  Set_ID=" . $Sid);
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
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </div>
        </div>
    </div>
</div>