<script>
    $('.modal').on('shown.bs.modal', function () {
        $(".temizle").val("");
        $('.Hata').html("");
        $('.focus').focus();
        $(".TumuGeldi").prop('checked', false);
        $(".TumunuKullan").prop('checked', false);
    });
    $(function () {
        $(".TumuGeldi").on("click", function () {
            var n = $(".TumuGeldi:checked").length;
            var ID = $(this).attr("BoyaStokID");
            var SipMiktar = $('.SipMiktar' + ID + '').val();
            if (n === 1) {
                $('.GirMiktar' + ID + '').val(SipMiktar);
            } else {
                $('.GirMiktar' + ID + '').val("");
            }
        });

        $(".TumunuKullan").on("click", function () {
            var n = $(".TumunuKullan:checked").length;
            var ID = $(this).attr("BoyaStokID");
            var StokMiktar = $('.KStokMiktar' + ID + '').val();
            if (n === 1) {
                $('.KGirMiktar' + ID + '').val(StokMiktar);
            } else {
                $('.KGirMiktar' + ID + '').val("");
            }
        });

        //Kayıt

        $('.Gelen').click(function () {

            var ID = $(this).attr("BoyaStokID");

            var Sipid = $('.Sipid' + ID + '').val();
            var StokMiktar = $('.StokMiktar' + ID + '').val();
            var GirMiktar = $('.GirMiktar' + ID + '').val();
            var T_Tarihi = $('.T_Tarihi' + ID + '').val();

            var Uretim_T = $('.Uretim_T' + ID + '').val();
            var SipMiktar = $('.SipMiktar' + ID + '').val();

            if (GirMiktar == "") {
                $('.MiktarHata').html("Miktar boş bırakılamaz!");
            } else if (Uretim_T == "" || Uretim_T == null) {
                $('.TarihHata').html("Üretim tarihi boş bırakılamaz!");
            } else if (Number(SipMiktar) <= 0) {
                <?=$SiparisTamam?>
            } else if (Number(GirMiktar) > Number(SipMiktar)) {
                <?=$FazlaDeger?>
            } else {
                $.ajax({
                    type: "POST",
                    url: "post.php",
                    data: {
                        'Sipid': Sipid,
                        'BoyaStokID': ID,
                        'Uretim_T': Uretim_T,
                        'SipMiktar': SipMiktar,
                        'GirMiktar': GirMiktar,
                        'StokMiktar': StokMiktar,
                        'T_Tarihi': T_Tarihi,
                        'Gelen': true,
                    },
                    error: function (xhr) {
                        alert('Hata: ' + xhr.responseText);
                    },
                    success: function () {
                        window.location.assign("BoyaGelen.php")
                    }
                })
            }
        });

//          Kullan

        $(".Kullan").click(function () {
            var ID = $(this).attr("BoyaStokID");
            var KStokMiktar = $('.KStokMiktar' + ID + '').val();
            var K_Miktar = $('.K_Miktar' + ID + '').val();
            var KGirMiktar = $('.KGirMiktar' + ID + '').val();
            var Kullanma_T = $('.Kullanma_T' + ID + '').val();
            if (KGirMiktar == "") {
                $('.KMiktarHata').html("Miktar boş bırakılamaz!");
            } else if (Number(KStokMiktar) <= 0 || Number(KGirMiktar) > Number(KStokMiktar)) {
                <?=$FazlaDeger?>
            } else {
                $.ajax({
                    type: "POST",
                    url: "post.php",
                    data: {
                        'KBoyaStokID': ID,
                        'KStokMiktar': KStokMiktar,
                        'K_Miktar': K_Miktar,
                        'KGirMiktar': KGirMiktar,
                        'Kullanma_T': Kullanma_T,
                        'Kullan': true,
                    },
                    error: function (xhr, textStatus, errorThrown) {
                        alert('Hata: ' + xhr.responseText);
                    },
                    success: function () {
                        window.location.assign("BoyaKullanilan.php")
                    }
                })
            }
        });

        $('.iade').click(function (){
            var ID=$(this).attr("id");
            var Miktar=$('.KGirMiktar' + ID + '').val();
            $.ajax({
                type: 'POST',
                url: "post.php",
                data: {'StkID': ID, 'iMiktar': Miktar},
                error: function (xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function () {
                    window.location.assign("BoyaKullanilan.php");
                }
            })
        });

        $('.Emanet').click(function (){
            var ID=$(this).attr("id");
            var Miktar=$('.KGirMiktar' + ID + '').val();
            $.ajax({
                type: 'POST',
                url: "post.php",
                data: {'EStkID': ID, 'EMiktar': Miktar},
                error: function (xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function () {
                    window.location.assign("BoyaKullanilan.php");
                }
            })
        });
    });
</script>