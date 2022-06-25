<div class="modal fade" id="Kullan<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $Stok_Adet == null ? 0 : $Stok_Adet ?> Adet Stoktan &nbsp
                    <i class="bi bi-tropical-storm "></i>
                    &nbsp <?= $K_Adet == null ? 0 : $K_Adet ?> Adet Kullanıldı</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body row g-3">
                <input type="hidden" name="KStokAdet<?= $id ?>" value="<?= $Stok_Adet > 0 ? $Stok_Adet : 0 ?>"/>

                <input type="hidden" name="K_Adet<?= $id ?>" value="<?= $K_Adet > 0 ? $K_Adet : 0 ?>">



                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="number" name="KGirAdet<?= $id ?>" class="form-control"
                               required>
                        <label>Adet</label>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="date" name="Kullanma_T<?= $id ?>" class="form-control"
                               value="<?php
                               date_default_timezone_set('Europe/Istanbul');
                               $tarih = new DateTime("now");
                               $tarih = date("Y-m-d");
                               echo $tarih;
                               ?>" required>
                        <label for="t">Kullanma Tarihi</label>
                    </div>
                </div>

                <div class="text-center">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="TKullan" KulpStokID="<?= $id ?>">
                        Tümünü Kullan
                    </label>
                </div>

            </div>
            <div class="card-footer">
                <button type="button" name="Kullan" class="btn btn-success form-control"
                        KulpStokID="<?= $id ?>">Kullan
                </button>
            </div>
        </div>
    </div>
</div>