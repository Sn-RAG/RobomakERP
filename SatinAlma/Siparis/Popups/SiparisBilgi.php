<div class="modal fade" id="SiparisBilgi<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bilgi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <?php
            if ($Siparis == "Levha") {
                require __DIR__ . "/static/Levha.php";
            }
            ?>
        </div>
    </div>
</div>