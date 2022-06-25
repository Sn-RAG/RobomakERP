<script>
    $(function () {
        $(document).on("click", "body", function () {
        });

        $("input[name=TGeldi]").on("click", function () {
            var n = $("input[name=TGeldi]:checked").length;
            var ID = $(this).attr("KulpStokID");
            var SipAdet = $('input[name=SipAdet' + ID + ']').val();
            if (n === 1) {
                $('input[name=GirAdet' + ID + ']').val(SipAdet);
            } else {
                $('input[name=GirAdet' + ID + ']').val("");
            }
        });

        $("input[name=TKullan]").on("click", function () {
            var n = $("input[name=TKullan]:checked").length;
            var ID = $(this).attr("KulpStokID");
            var StokAdet = $('input[name=KStokAdet' + ID + ']').val();
            if (n === 1) {
                $('input[name=KGirAdet' + ID + ']').val(StokAdet);
            } else {
                $('input[name=KGirAdet' + ID + ']').val("");
            }
        });

        //Kayıt

        $('button[name=Gelen]').click(function () {

            var ID = $(this).attr("KulpStokID");

            var Sipid = $('input[name=Sipid' + ID + ']').val();
            var StokAdet = $('input[name=StokAdet' + ID + ']').val();
            var GirAdet = $('input[name=GirAdet' + ID + ']').val();
            var T_Tarihi = $('input[name=T_Tarihi' + ID + ']').val();

            var SipAdet = $('input[name=SipAdet' + ID + ']').val();



                if (Number(SipAdet) <= 0) {
                    <?=$SiparisTamam?>
                } else {
                $.ajax({
                    type: "POST",
                    url: "AjaxForm/post.php",
                    data: {
                        'Sipid': Sipid,
                        'KulpStokID': ID,
                        'SipAdet': SipAdet,
                        'GirAdet': GirAdet,
                        'StokAdet': StokAdet,
                        'T_Tarihi': T_Tarihi,
                        'StokEkle': true,
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert('Hata: ' + xhr.responseText);
                    },
                    success: function () {
                        window.location.assign("KulpStok.php")
                    }
                })
            }
        });

//          Kullan

        $("button[name=Kullan]").click(function () {
            var ID = $(this).attr("KulpStokID");
            var StokAdet = $('input[name=KStokAdet' + ID + ']').val();
            var K_Adet = $('input[name=K_Adet' + ID + ']').val();
            var GirAdet = $('input[name=KGirAdet' + ID + ']').val();
            var Kullanma_T = $('input[name=Kullanma_T' + ID + ']').val();

            if (Number(StokAdet) <= 0) {
                <?=$StokDegerdenFazla?>
            } else {
                $.ajax({
                    type: "POST",
                    url: "AjaxForm/post.php",
                    data: {
                        'KulpStokID': ID,
                        'StokAdet': StokAdet,
                        'K_Adet': K_Adet,
                        'GirAdet': GirAdet,
                        'Kullanma_T': Kullanma_T,
                        'KulpKullan': true,
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert('Hata: ' + xhr.responseText);
                    },
                    success: function () {
                        window.location.assign("KulpKullanilanlar.php")
                    }
                })
            }

        });
    });
</script>