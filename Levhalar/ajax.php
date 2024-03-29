<SCRIPT>
    $('.modal').on('shown.bs.modal', function() {
        $(".temizle").val("");
        $('.Hata').html("");
        $('.focus').focus();
        $(".TumuGeldi").prop('checked', false);
        $(".TumunuKullan").prop('checked', false);
    });

    //Hesap İşlemi
    $(".GirAgirlik").keyup(function() {
        var ID = $(this).attr("levhastokid");
        var a = $('.Cap' + ID + '').val();
        var b = $('.Kalinlik' + ID + '').val();
        var GirAgirlik = $('#GirAgirlik' + ID + '').val();
        var Kg = Math.ceil(GirAgirlik / ((a * a * b * (0.22)) / 1000));
        $('.GirAdet' + ID + '').val(Kg);
    });
    $('.Gelen').click(function() {
        var ID = $(this).attr("levhastokid");
        var LevhaID = $('.LevhaID' + ID + '').val();
        var GirAgirlik = $('#GirAgirlik' + ID + '').val();
        var GirAdet = $('.GirAdet' + ID + '').val();
        var T_Tarihi = $('.T_Tarihi' + ID + '').val();

        /*Tamamlandı mı?*/
        var Tamam = 0;
        if ($(".Tamamlandi:checked").length === 1) {
            Tamam = 1;
        }
        /*SON*/
        
        if (GirAgirlik == "") {
            $('.Hata').html("Ağırlık boş bırakılamaz!");
        } else {
            $.ajax({
                type: "POST",
                url: "post.php",
                data: {
                    'Levha_Stok_ID': ID,
                    'T_Tarihi': T_Tarihi,
                    'LevhaID': LevhaID,
                    'GirAgirlik': GirAgirlik,
                    'GirAdet': GirAdet,
                    'StokEkle': true,
                    'Tamam': Tamam
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function() {
                    window.location.assign("LevhaStok.php")
                }
            })
        }
    });

    //####################################################################################################################


    //        Kullan Kayıt
    $(".TumunuKullan").on("click", function() {
        var ID = $(this).attr("id");
        var StokAgirlik = $('.StokAgirlik' + ID + '').val();
        var StokAdet = $('.StokAdet' + ID + '').val();
        if ($(".TumunuKullan:checked").length === 1) {
            $('#GirAgirlik' + ID + '').val(StokAgirlik);
            $('.GirAdet' + ID + '').val(StokAdet);
        } else {
            $('.GirAdet' + ID + '').val("");
            $('#GirAgirlik' + ID + '').val("");
        }
    });

    //Hesap işlemi
    $(".GirAgirlikk").keyup(function() {
        var ID = $(this).attr("levhastokid");
        var a = $('.Cap' + ID + '').val();
        var b = $('.Kalinlik' + ID + '').val();
        var c = a * a * b * (0.22);
        var GirAgirlik = $('#GirAgirlik' + ID + '').val();
        var Kg = GirAgirlik / (c / 1000);
        $('.GirAdet' + ID + '').val(Math.ceil(Kg));
        var StokAdet = $('.StokAdet' + ID + '').val();
        var StokAgirlik = $('.StokAgirlik' + ID + '').val();
        var GirAdet = $('.GirAdet' + ID + '').val();
        if (Number(StokAdet) < Number(GirAdet)) {
            $('.GirAdet' + ID + '').val(StokAdet);
        }
        if (Number(GirAgirlik) > Number(StokAgirlik)) {
            $('#GirAgirlik' + ID + '').val(StokAgirlik);
            $('.Hata').html("Ağırlığın tamamı girildi!");
        }
    });


    $('.Kullan').click(function() {
        var ID = $(this).attr("levhastokid");
        var KTarihi = $('.KTarihi' + ID + '').val();
        var StokAgirlik = $('.StokAgirlik' + ID + '').val();
        var StokAdet = $('.StokAdet' + ID + '').val();
        var KAdet = $('.KAdet' + ID + '').val();
        var KAgirlik = $('.KAgirlik' + ID + '').val();
        var GirAgirlik = $('#GirAgirlik' + ID + '').val();
        var GirAdet = $('.GirAdet' + ID + '').val();

        if (GirAgirlik == "") {
            $('.Hata').html("Ağırlık boş bırakılamaz!");
        } else if (Number(StokAgirlik) == 0) {
            <?= $SiparisTamam ?>
        } else {
            $.ajax({
                type: "POST",
                url: "post.php",
                data: {
                    'LevhaStokID': ID,
                    'KTarihi': KTarihi,
                    'KStokAdet': StokAdet,
                    'KStokAgirlik': StokAgirlik,
                    'KAdet': KAdet,
                    'KAgirlik': KAgirlik,
                    'KGirAgirlik': GirAgirlik,
                    'KGirAdet': GirAdet,
                    'Kullan': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function() {
                    window.location.assign("LevhaKullanilan.php");
                }
            })
        }
    });
</SCRIPT>