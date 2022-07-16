<script>
    $(function() {
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
        <?= isset($_SESSION["Set_ID"]) ? "$.Listele();" : "" ?>

        //##################################################### form input ekle
        $(document).on('click', '.input-ekle', function(e) {
            var DisBoyalar = [];
            $("select.DisBoyalar").each(function(i, sel) {
                var selectedVal = $(sel).val();
                DisBoyalar.push(selectedVal);
            });
            if (DisBoyalar.length > 5) {
                $(".input-ekle").prop("disabled", true)
            }
            var clone, examsList;
            e.preventDefault();
            examsList = $('.inputlar');
            clone = examsList.children('.form-group:first').clone(true);
            clone.append($('<button>').addClass('btn col-md-1 btn-danger bi-trash input-sil'));
            return examsList.append(clone);
        });
        $(document).on('click', '.input-sil', function(e) {
            var DisBoyalar = [];
            $("select.DisBoyalar").each(function(i, sel) {
                var selectedVal = $(sel).val();
                DisBoyalar.push(selectedVal);
            });
            if (DisBoyalar.length <= 8) { // O anki değeri geriden geldiği için
                $(".input-ekle").prop("disabled", false);
            }
            e.preventDefault();
            return $(this).parent().remove();
        });
        $("#Setadii").prop("disabled", true);
        $("#Urunn").prop("disabled", true);
        $("#Kutuu").prop("disabled", true);
        $("#Renkk").prop("disabled", true);
        $("#Listee").prop("disabled", true);
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
            var h = $(this).val();
            UrunIDler.push(h);
            mmler.push($("#kal" + h + "").val());
            Kapaklar.push($("#Kapak" + h + "").val());
            Tepeler.push($("#Tepe" + h + "").val());
            Kulplar.push($("#Kulp" + h + "").val());
        });

        if (UrunIDler == "") {
            $("#UrunBos").html("Ürün Seçmediniz!");
        } else {
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
        $("#Kutuu").removeClass("active");
        $("#Kutuuu").removeClass("active show");
        $("#Renkk").addClass("active");
        $("#Renk").addClass("active show");
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
        $(".UrunSecim:checked").map(function() {
            var h = $(this).val();
            UrunIDler.push(h);
            mmler.push($("#kal" + h + "").val());
            Kapaklar.push($("#Kapak" + h + "").val());
            Tepeler.push($("#Tepe" + h + "").val());
            Kulplar.push($("#Kulp" + h + "").val());
        });

        $(".Adetler").each(function(i, sel) {
            Adetler.push($(sel).val());
        });
        $(".icBoyalar").each(function(i, sel) {
            icBoyalar.push($(sel).val());
        });
        $(".DisBoyalar").each(function(i, sel) {
            DisBoyalar.push($(sel).val());
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
                                'Adetler': Adetler,
                                'Sec': true,
                            },
                            error: function(xhr) {
                                alert('Hata: ' + xhr.responseText);
                            },
                            success: function() {
                                $.Listele();
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

    $(".mm").change(function() {
        var id=$(this).attr("urunid");
        $("#mmy" + id + "").html($("#kal" + id + " option:selected").text());
    });

    $(".Kulp").change(function() {
        var id=$(this).attr("urunid");
        $("#Kulpy" + id + "").html($("#Kulp" + id + " option:selected").text());
    });

    $(".Tepe").change(function() {
        var id=$(this).attr("urunid");
        $("#Tepey" + id + "").html($("#Tepe" + id + " option:selected").text());
    });

    $(".Kapak").change(function() {
        var id=$(this).attr("urunid");
        $("#Kapaky" + id + "").html($("#Kapak" + id + " option:selected").text());
    });
</script>