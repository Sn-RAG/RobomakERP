<script>
    $(function() {
        $.Secilenler = function() {
            var str = "";
            $(".mm option:selected").each(function() {
                var txt = $(this).text();
                if (txt != "Kalınlık Seç") {
                    str += txt + " ";
                }
            });

            var id = [];
            $(".UrunSecim:checked").map(function() {
                var h = Number($(this).attr("id"));
                id.push(h);
            });
            for (let i = 0; i < id.length; i++) {
                $("#mmy" + id[i] + "").html($("#kal" + id[i] + " option:selected").text());
                $("#Kulpy" + id[i] + "").html($("#Kulp" + id[i] + " option:selected").text());
                $("#Tepey" + id[i] + "").html($("#Tepe" + id[i] + " option:selected").text());
                $("#Kapaky" + id[i] + "").html($("#Kapak" + id[i] + " option:selected").text());
            }
        }
        $.Secilenler();
        $.Listele = function() {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Listele': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $(".UrunleriGoster").html(data);
                }
            })
        }

        /* Kalınlık Kulp Tepe ve Kapak eklemede Setkayıt. 
        Set oluşturulmuş ve sayfa yenileniyorsa Set_ID ile kaldığı yerden devam etme kontrolü.*/

        <?php if (isset($_GET["SetKayit"])) { ?>
            $("#Setadii").removeClass("active");
            $("#ad").removeClass("active show");
            $("#Urunn").addClass("active");
            $("#Urun").addClass("active show");
        <?php } elseif (isset($_SESSION["Set_ID"])) { ?>
            $("#Setadii").removeClass("active");
            $("#ad").removeClass("active show");
            $("#Listee").addClass("active");
            $("#Liste").addClass("active show");
            $.Listele();
        <?php } elseif (isset($_GET["Boya"])) { ?>
            $("#Setadii").removeClass("active");
            $("#ad").removeClass("active show");
            $("#Renkk").addClass("active");
            $("#Renk").addClass("active show");
        <?php } ?>

        //####################################### Form input ekle


        $(document).on('click', '.input-ekle', function(e) {
            var DisBoyalar = [];
            $(".DisBoyalar").map(function() {
                DisBoyalar.push($(this).val());
            });
            if (DisBoyalar.length > 5) {
                $(".input-ekle").prop("disabled", true)
            }
            var clone, examsList;
            e.preventDefault();
            examsList = $('.inputlar');
            clone = examsList.children('.form-group:first').clone(true);
            clone.children("div").children("div").children("div").append($('<button>').addClass('btn btn-danger bi-trash input-sil'));
            if (DisBoyalar.length > 0) {
                $(".input-sil").prop("disabled", false);
            }

            clone.children("div").children("div").find("#icBoya").prop("disabled",true);
            clone.children("div").children("div").find("#DisBoya").prop("disabled",true);

            return examsList.append(clone);

        });
        $(document).on('click', '.input-sil', function(e) {
            var DisBoyalar = [];
            $(".DisBoyalar").map(function() {
                DisBoyalar.push($(this).val());
            });
            if (DisBoyalar.length == 7) {
                $(".input-ekle").prop("disabled", false);
            }
            e.preventDefault();
            return $(this).parent("div").parent("div").parent("div").parent("div").remove();
        });
        $("#Setadii").prop("disabled", true);
        $("#Urunn").prop("disabled", true);
        $("#Kutuu").prop("disabled", true);
        $("#Renkk").prop("disabled", true);
        $("#Listee").prop("disabled", true);
    });

    $(".icM").change(function() {
        var v = $(this).val();

        const icBoya = $(this).parent("div").parent("div").find("#icBoya");

        if (v != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Marka': v,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    icBoya.html(data);
                    icBoya.prop("disabled", false);
                }
            })
        } else {
            icBoya.prop("disabled", true);
        }
    });

    $(".icD").change(function() {
        var v = $(this).val();

        const DisBoya = $(this).parent("div").parent("div").find("#DisBoya");

        if (v != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Marka': v,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    DisBoya.html(data);
                    DisBoya.prop("disabled", false);
                }
            })
        } else {
            DisBoya.prop("disabled", true);
        }
    });

    $("#ileriUrun").click(function() {
        var SetAdi = $("#SetAdi").val();
        if (SetAdi == "") {
            $("#SetAdiKontrol").html("Set Adı Boş Bırakılamaz!");
        } else {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'SetAdiKontrol': $.trim(SetAdi).toString(),
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $("#SetAdiKontrol").html(data);
                    if (data == "") {
                        $("#Setadii").removeClass("active");
                        $("#ad").removeClass("active show");
                        $("#Urunn").addClass("active");
                        $("#Urun").addClass("active show");
                    }
                }
            })
        }
    });

    $("#GeriSetAdi").click(function() {
        $("#Setadii").addClass("active");
        $("#ad").addClass("active show");
        $("#Urunn").removeClass("active");
        $("#Urun").removeClass("active show");
    });

    $("#ileriKutu").click(function() {
        var Kapaklar = [];
        var Tepeler = [];
        var Kulplar = [];
        var mmler = [];
        var UrunIDler = [];
        $(".UrunSecim:checked").map(function() {
            var h = Number($(this).attr("id"));
            UrunIDler.push(h);
            mmler.push($("#kal" + h + "").val());
            Kapaklar.push($("#Kapak" + h + "").val());
            Tepeler.push($("#Tepe" + h + "").val());
            Kulplar.push($("#Kulp" + h + "").val());
        });

        if (UrunIDler == "") {
            $("#UrunBos").html("Ürün Seçmediniz!");
        } else {
            for (let i = 0; i < mmler.length; i++) {
                if (mmler[i] == "") {
                    return $("#UrunBos").html("Ürün kalınlığı boş bırakılamaz!");
                }
            }
            $("#UrunBos").html("");
            $("#Urunn").removeClass("active");
            $("#Urun").removeClass("active show");
            $("#Kutuu").addClass("active");
            $("#Kutuuu").addClass("active show");

            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'UrunIDler': UrunIDler,
                    'mmSec': mmler,
                    'KulpSec': Kulplar,
                    'KapakSec': Kapaklar,
                    'TepeSec': Tepeler,
                }
            })
        }
    });

    $("#GeriUrun").click(function() {
        $("#Urunn").addClass("active");
        $("#Urun").addClass("active show");
        $("#Kutuu").removeClass("active");
        $("#Kutuuu").removeClass("active show");
    });

    $("#ileriRenkler").click(function() {
        if ($("#Kutu").val() == "") {
            $(".KutuHata").text("Kutu seçimi yapmadınız");
        } else {
            $("#Kutuu").removeClass("active");
            $("#Kutuuu").removeClass("active show");
            $("#Renkk").addClass("active");
            $("#Renk").addClass("active show");
            $(".KutuHata").text("");
        }
    });

    $("#GeriKutu").click(function() {
        $("#Kutuu").addClass("active");
        $("#Kutuuu").addClass("active show");
        $("#Renkk").removeClass("active");
        $("#Renk").removeClass("active show");
    });

    $("#SetTamam").click(function() {

        var SetAdi = $("#SetAdi").val();
        var Kutu = $("#Kutu").val();

        var Kapaklar = [];
        var Tepeler = [];
        var Kulplar = [];
        var mmler = [];
        var UrunIDler = [];
        var Adetler = [];
        var icBoyalar = [];
        var DisBoyalar = [];
        var Kircil = [];
        var Kircill = [];
        $(".UrunSecim:checked").map(function() {
            var h = Number($(this).attr("id"));
            UrunIDler.push(h);
            mmler.push($("#kal" + h + "").val());
            Kapaklar.push($("#Kapak" + h + "").val());
            Tepeler.push($("#Tepe" + h + "").val());
            Kulplar.push($("#Kulp" + h + "").val());
        });

        $(".Adetler").each(function(i, sel) {
            Adetler.push($(this).val());
        });
        $(".icBoyalar").map(function() {
            icBoyalar.push($(this).val());
        });
        $(".DisBoyalar").map(function() {
            DisBoyalar.push($(this).val());
        });
        $(".Kircil").map(function() {
            Kircil.push($(this).val());
        });
        $(".Kircill").map(function() {
            Kircill.push($(this).val());
        });
        for (let i = 0; i < DisBoyalar.length; i++) {
            if (DisBoyalar[i] == '' || icBoyalar[i] == '' || Adetler[i] == '') {
                $(".Fazlainput").text("* Zorunlu alanları doldurun!");
            } else if (i == DisBoyalar.length - 1) {
                Swal.fire({
                    title: 'Set oluşturulacak devam edilsin mi?',
                    showDenyButton: true,
                    confirmButtonText: 'Evet',
                    denyButtonText: `Hayır`,
                    allowOutsideClick: false
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "AjaxForm/post.php",
                            data: {
                                'UrunIDler': UrunIDler,
                                'mmler': mmler,
                                'SetAdi': $.trim(SetAdi),
                                'Kapaklar': Kapaklar,
                                'Kulplar': Kulplar,
                                'Tepeler': Tepeler,
                                'Kutu': Kutu,
                                'icBoyalar': icBoyalar,
                                'DisBoyalar': DisBoyalar,
                                'Kircil': Kircil,
                                'Kircill': Kircill,
                                'Adetler': Adetler,
                                'SetTamam': true,
                            },
                            error: function(xhr) {
                                alert('Hata: ' + xhr.responseText);
                            },
                            success: function() {
                                window.location.reload();
                            }
                        })

                        $("#Renkk").removeClass("active");
                        $("#Renk").removeClass("active show");
                        $("#Listee").addClass("active");
                        $("#Liste").addClass("active show");

                    } else if (result.isDenied) {
                        $(".Fazlainput").html("");
                    }
                })
            }
        }
    });

    //#####################################################

    $("#icerikSec").click(function() {
        var Set_Urun_Duzenle_ID = $("input[name=Set_Urun_Duzenle_ID]").val();

        if (Set_Urun_Duzenle_ID != "" || Set_Urun_Duzenle_ID != null) {

            var Adet = $("input[name=Adet]").val();

            var icBoya = $("select[name=icBoya]").val();
            var DisBoya = $("select[name=DisBoya]").val();
            var Kapak = $("select[name=Kapak]").val();
            var Kulp = $("select[name=Kulp]").val();

            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Set_Urun_Duzenle_ID': Set_Urun_Duzenle_ID,
                    'UAdet': Adet,
                    'UicBoya': icBoya,
                    'UDisBoya': DisBoya,
                    'UKapak': Kapak,
                    'UKulp': Kulp,
                    'Urunicerik': true,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $.Listele();
                }
            })
        }
        $("button[name=SetKaydet]").removeAttr('disabled', "");
        $("input[name=Set_Urun_Duzenle_ID]").val("");
        $("input[name=Adet]").val("");
        $("select[name=icBoya]").val("");
        $("select[name=DisBoya]").val("");
        $("select[name=Kapak]").val("");
        $("select[name=Kulp]").val("");
        $("button[name=Urunler]").attr("disabled", false);
    });

    // Seçilenleri ürünün altında göster
    $.drkapat = function() {
        $(".dropdown-toggle").removeClass("show");
        $(".dropdown-menu").removeClass("show");
    };
    $(".mm").change(function() {
        var id = $(this).attr("urunid");
        $("#mmy" + id + "").html($("#kal" + id + " option:selected").text());
        $.drkapat();
    });

    $(".Kulp").change(function() {
        var id = $(this).attr("urunid");
        $("#Kulpy" + id + "").html($("#Kulp" + id + " option:selected").text());
        $.drkapat();
    });

    $(".Tepe").change(function() {
        var id = $(this).attr("urunid");
        $("#Tepey" + id + "").html($("#Tepe" + id + " option:selected").text());
        $.drkapat();
    });

    $(".Kapak").change(function() {
        var id = $(this).attr("urunid");
        $("#Kapaky" + id + "").html($("#Kapak" + id + " option:selected").text());
        $.drkapat();
    });
</script>