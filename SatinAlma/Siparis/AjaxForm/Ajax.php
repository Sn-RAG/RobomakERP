<SCRIPT>
    $('.modal').on('shown.bs.modal', function() {
        $(".temizle").val("");
        $('.Hata').html("");
        $('.focus').focus();
    });
    //EKLE Boya
    $("#BoyaEkle").click(function() {
        var Marka = $("#Marka").val();
        var Renk = $("#Renk").val();
        var Seri = $(".Seri").val();
        var Kod = $("#Kod").val();
        if (Marka == "" || Renk == "" || Kod == "") {
            $(".Hata").html("* Zorunlu alanlar boş bırakılamaz!");
        } else {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Marka': $.trim(Marka),
                    'Renk': $.trim(Renk),
                    'Seri': $.trim(Seri),
                    'Kod': $.trim(Kod),
                    'BoyaEkle': true,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "") {
                        window.location.assign("BoyaSiparis.php")
                    } else {
                        <?= $Kayitvarr ?>
                    }
                }
            })
        }
    });
    // Boya Düzenle
    $('.BoyaDuzenle').click(function() {
        var ID = $(this).attr("BoyaID");
        var Marka = $("#Marka" + ID + "").val();
        var Renk = $("#Renk" + ID + "").val();
        var Seri = $("#Seri" + ID + "").val();
        var Kod = $("#Kod" + ID + "").val();

        if (Marka == "" || Renk == "" || Kod == "") {
            $(".Hata").html("* Zorunlu alanlar boş bırakılamaz!");
        } else {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'DBoyaID': ID,
                    'DMarka': $.trim(Marka),
                    'DRenk': $.trim(Renk),
                    'DSeri': $.trim(Seri),
                    'DKod': $.trim(Kod),
                    'BoyaDuzenle': true,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function() {
                    window.location.assign("BoyaSiparis.php")
                }
            })
        }
    });

    // Boya Sipariş

    $('.BoyaSiparisEt').click(function() {
        var Miktar = [];
        $("input.Miktar").each(function(i, sel) {
            var selectedVal = $(sel).val();
            Miktar.push(selectedVal);
        });
        var S_Tarihi = $(".tarih").val();
        $.ajax({
            type: 'POST',
            url: 'SiparisListesi.php',
            data: {
                'Miktar': Miktar,
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            }
        })

        //Kayıt İşlemi
        $.ajax({
            type: 'POST',
            url: "AjaxForm/post.php",
            data: {
                'S_Tarihi': S_Tarihi,
                'BoyaSiparis': true,
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            },
            success: function() {}
        })

        Swal.fire({
            title: 'Baskı ve önizleme için listelensin mi?',
            showDenyButton: true,
            confirmButtonText: 'Evet',
            denyButtonText: `Hayır`,
            allowOutsideClick: false
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.assign('SiparisListesi.php?YazdirBoya')
            } else if (result.isDenied) {
                window.location.assign('BoyaSiparisleri.php')
            }
        })
    });

    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               LEVHA              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

    //LEVHA Sipariş

    $("#LevhaEkle").click(function() {
        var Firma = $("#Firma").val();
        var Tip = $("#Tip").val();
        var Cap = $("#Cap").val();
        var Kalinlik = $("#Kalinlik").val();
        if (Cap == "" || Kalinlik == "") {
            $(".Hata").html("* Zorunlu alanlar boş bırakılamaz!");
        } else {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'LevhaFirma': Firma,
                    'Tip': Tip,
                    'Cap': Cap,
                    'Kalinlik': Kalinlik,
                    'LevhaEkle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function() {
                    window.location.assign("LevhaSiparis.php")
                }
            })
        }
    });

    $('.LevhaDuzenle').click(function() {
        var ID = $(this).attr("LevhaID");
        var Firma = $("#Firma" + ID + "").val();
        var Tip = $("#Tip" + ID + "").val();
        var Cap = $("#Cap" + ID + "").val();
        var Kalinlik = $("#Kalinlik" + ID + "").val();
        if (Cap == "" || Kalinlik == "") {
            $(".Hata").html("* Zorunlu alanlar boş bırakılamaz!");
        } else {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'ID': ID,
                    'LevhaFirma': Firma,
                    'Tip': Tip,
                    'Cap': Cap,
                    'Kalinlik': Kalinlik,
                    'LevhaDuzenle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function() {
                    window.location.assign("LevhaSiparis.php")
                }
            })
        }
    });

    //Hesap İşlemi
    $(".Adet").change(function() {
        var id = $(this).attr("LevhaID");
        var a = parseFloat($("#Cap" + id + "").text());
        var b = parseFloat($("#Kalinlik" + id + "").text());
        var d = $("#Adet" + id + "").val();
        var Kg = Math.ceil(((a * a * b * (0.22)) * d) / 1000);
        $("#Agirlik" + id + "").text(Kg);
    });

    $(".LevhaSiparisEt").click(function() {
        var STarihi = $(".tarih").val();
        var Adet = [];
        var Agirlik = [];
        $("input.Adet").each(function(i, sel) {
            var Val = $(sel).val();
            Adet.push(Val);
        });
        $(".Agirlik").each(function(i, sel) {
            var Val = Number($(sel).text());
            Agirlik.push(Val);
        });

        for (let i = 0; i < Adet.length; i++) {
            if (STarihi == "" || Adet[i] == "") {
                <?= $Gecersiz ?>
                return;
            }
        }
        $.ajax({
            type: "POST",
            url: "AjaxForm/post.php",
            data: {
                'STarihi': STarihi,
                'Agirlik': Agirlik,
                'Adet': Adet,
                'LevhaSiparis': true,
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            },
            success: function() {
                window.location.assign("LevhaSiparisleri.php")
            }
        })
    });
</SCRIPT>