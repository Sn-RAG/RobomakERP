<div class="modal fade" id="Gelen<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><?= $Siparis_Adet == null ? 0 : $Siparis_Adet ?> Adet Siparişten &nbsp
                    <i class="bi bi-arrow-right-circle "></i>
                    &nbsp <?= $Stok_Adet == null ? 0 : $Stok_Adet ?> Adet Geldi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row g-3">
                <input type="hidden" name="StokAdet<?= $id ?>"
                       value="<?= $Stok_Adet > 0 ? $Stok_Adet : 0 ?>"/>

                <input type="hidden" name="SipAdet<?= $id ?>"
                       value="<?= $Siparis_Adet > 0 ? $Siparis_Adet : 0 ?>">

                <input type="hidden" name="Sipid<?= $id ?>" value="<?= $Kulp_Siparis_ID ?>">


                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="number" name="GirAdet<?= $id ?>" class="form-control"
                               required>
                        <label>Adet</label>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-floating">
                        <input type="date" name="T_Tarihi<?= $id ?>" class="form-control"
                               value="<?php
                               date_default_timezone_set('Europe/Istanbul');
                               $tarih = new DateTime("now");
                               $tarih = date("Y-m-d");
                               echo $tarih;
                               ?>" required>
                        <label for="t">Teslim Tarihi</label>
                    </div>
                </div>

                <div class="text-center">
                    <label class="form-check-label">
                        <input class="form-check-input" type="checkbox" name="TGeldi" KulpStokID="<?= $id ?>">
                        Tamamı Geldi
                    </label>
                </div>
                </form>
            </div>
            <div class="card-footer">
                <button type="button" name="Gelen" class="btn btn-success form-control"
                        KulpStokID="<?= $id ?>">Stoğa Ekle
                </button>
            </div>
        </div>
    </div>
</div>