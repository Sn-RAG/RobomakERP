<div class="modal fade" id="Bilgi<?= $id ?>" tabindex="-1" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Bilgi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form class="needs-validation" id="formum" method="post" novalidate>
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="inputText" class="col-sm-3 col-form-label">Firma Adı</label>
                        <div class="col-sm-9">
                            <input value="<?= $Firma ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Teslim Tarihi</label>
                        <div class="col-sm-9">
                            <input value="<?= $Teslim_Tarihi ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Yetkili Adı</label>
                        <div class="col-sm-9">
                            <input value="<?= $YetkiliAdi ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Yetkili Telefon</label>
                        <div class="col-sm-9">
                            <input value="<?= $YetkiliTel ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Sipariş Açan Kullanıcı</label>
                        <div class="col-sm-9">
                            <input value="<?= $AdSoyad ?>" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-3 col-form-label">Düzenleme Tarihi</label>
                        <div class="col-sm-9">
                            <input value="<?= $Duzenleme_Tarihi ?>" class="form-control" disabled>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kapat</button>
                </div>
            </form>

        </div>
    </div>
</div><!-- End Disabled Backdrop Modal-->