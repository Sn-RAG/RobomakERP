<div class="modal-body">

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Tip</label>
        <div class="col-sm-9">
            <input value="<?= $Tip ?>" class="form-control" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Çap</label>
        <div class="col-sm-9">
            <input value="<?= $Cap ?> cm" class="form-control" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Kalınlık</label>
        <div class="col-sm-9">
            <input value="<?= $Kalinlik ?> mm" class="form-control" disabled>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9">
            <span disabled><?= $Siparis_Adet . " Adet" ?><i
                        class="bi bi-arrow-right-circle-fill btn-lg"></i>Gelen <?= $Stok_Adet == "" ? "0 Adet" : $Stok_Adet . " Adet" ?></span>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label"></label>
        <div class="col-sm-9"><span disabled><?= $Siparis_Agirlik ?> Kg<i
                        class="bi bi-arrow-right-circle-fill btn-lg"></i> Gelen <?= $Stok_Agirlik == "" ? 0 : $Stok_Agirlik ?> Kg</span>
        </div>
    </div>

    <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Düzenleme Tarihi</label>
        <div class="col-sm-9">
            <input value="<?= $D_Tarihi ?>" class="form-control" disabled>
        </div>
    </div>

</div>