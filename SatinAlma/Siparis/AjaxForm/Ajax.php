<SCRIPT>
    $(function() {
        <?php if (isset($_GET["Setler"]) || isset($_GET["Ekle"])) { ?>
            $("#Yeni").modal("show");
        <?php } elseif (isset($_SESSION["Adetler"])) { ?>
            //Hesap İşlemi
            $(".Adet").map(function() {
                var id = $(this).attr("LevhaID");
                var a = parseFloat($("#Hesap" + id + "").text());
                var b = $("#Adet" + id + "").val();
                var Kg = Math.ceil((a * b) / 1000);
                $("#Agirlik" + id + "").text(Kg);
            });
        <?php } ?>
    });

    $(".Tip").change(function() {
        if ($(this).val() == "DikDörtgen") {
            $(".dd").prop("hidden", false);
        } else {
            $(".dd").prop("hidden", true);
        }
    });

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
        if (Marka != "" && Renk != "" && Kod != "") {
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
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "var") {
                        <?= $Kayitvar ?>
                    } else {
                        window.location.assign("LevhaSiparis.php");
                    }
                }
            })
        } else {
            <?= $Gecersiz ?>
        }
    });
    // Boya Düzenle
    $('.BoyaDuzenle').click(function() {
        var ID = $(this).attr("BoyaID");
        var Marka = $("#Marka" + ID + "").val();
        var Renk = $("#Renk" + ID + "").val();
        var Seri = $("#Seri" + ID + "").val();
        var Kod = $("#Kod" + ID + "").val();

        if (Marka != "" && Renk != "" && Kod != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'BoyaID': ID,
                    'Marka': $.trim(Marka),
                    'Renk': $.trim(Renk),
                    'Seri': $.trim(Seri),
                    'Kod': $.trim(Kod),
                    'BoyaDuzenle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "var") {
                        <?= $Kayitvar ?>
                    } else {
                        window.location.assign("LevhaSiparis.php");
                    }
                }
            })
        } else {
            <?= $Gecersiz ?>
        }
    });

    // Boya Sipariş
    $(".sil").click(function() {
        $(this).parent("td").parent("tr").remove();
    });

    $('.BoyaSiparisEt').click(function() {
        var Miktar = [];
        var Boyalar = [];
        $(".Miktar").map(function() {
            Miktar.push($(this).val());
            Boyalar.push(Number($(this).attr("id")));
        });

        var STarihi = $(".tarih").val();

        for (let i = 0; i < Miktar.length; i++) {
            if (STarihi == "" || Miktar[i] <= 0) {
                <?= $Gecersiz ?>
                return;
            }
        }

        $.ajax({
            type: 'POST',
            url: 'SiparisListesi.php',
            data: {
                'Miktar': Miktar,
                'Boyalar': Boyalar
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
                'S_Tarihi': STarihi,
                'BoyaSiparis': true,
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            }
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


    $("#YeniLevha").click(function() {
        var Firma = $("#Firma").val();
        var Tip = $("#Tip").val();
        var Cap = $("#Cap").val();
        var Cap2 = $("#Cap2").val();
        var Kalinlik = $("#Kalinlik").val();
        if (Cap != "" && Kalinlik != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'LevhaFirma': Firma,
                    'Tip': Tip,
                    'Cap': Cap,
                    'Cap2': Cap2,
                    'Kalinlik': Kalinlik,
                    'LevhaEkle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "var") {
                        <?= $Kayitvar ?>
                    } else {
                        window.location.assign("LevhaSiparis.php");
                    }
                }
            })
        } else {
            <?= $Gecersiz ?>
        }
    });

    $('.LevhaDuzenle').click(function() {
        var ID = $(this).attr("LevhaID");
        var Firma = $("#Firma" + ID + "").val();
        var Tip = $("#Tip" + ID + "").val();
        var Cap = $("#Cap" + ID + "").val();
        var Cap2 = $("#Cap2" + ID + "").val();
        var Kalinlik = $("#Kalinlik" + ID + "").val();
        if (Cap != "" && Kalinlik != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'ID': ID,
                    'LevhaFirma': Firma,
                    'Tip': Tip,
                    'Cap': Cap,
                    'Cap2': Cap2,
                    'Kalinlik': Kalinlik,
                    'LevhaDuzenle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "var") {
                        <?= $Kayitvar ?>
                    } else {
                        window.location.assign("LevhaSiparis.php");
                    }
                }
            })
        } else {
            <?= $Gecersiz ?>
        }
    });

    //Hesap İşlemi
    $(".Adet").change(function() {
        var id = $(this).attr("LevhaID");
        var a = parseFloat($("#Hesap" + id + "").text());
        var b = $("#Adet" + id + "").val();
        var Kg = Math.ceil((a * b) / 1000);
        $("#Agirlik" + id + "").text(Kg);
    });

    $(".LevhaSiparisEt").click(function() {
        var STarihi = $(".tarih").val();
        var Adet = [];
        var Agirlik = [];
        $("input.Adet").map(function() {
            Adet.push($(this).val());
        });
        $(".Agirlik").map(function() {
            Agirlik.push(Number($(this).text()));
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

    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               KULP              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

    $("#YeniKulp").click(function() {
        var Firma = $("#Firma").val();
        var Adi = $("#Adi").val();
        var Cesit = $("#Cesit").val();
        var Renk = $("#Renk").val();
        if (Adi != "" && Cesit != "" && Renk != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Firma': Firma,
                    'Adi': $.trim(Adi),
                    'Cesit': $.trim(Cesit),
                    'Renk': $.trim(Renk),
                    'KulpEkle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "var") {
                        <?= $Kayitvar ?>
                    } else {
                        window.location.assign("KulpSiparis.php");
                    }
                }
            })
        } else {
            <?= $Gecersiz ?>
        }
    });

    $('.KulpDuzenle').click(function() {
        var ID = $(this).attr("KulpID");
        var Firma = $("#Firma" + ID + "").val();
        var Adi = $("#Adi" + ID + "").val();
        var Cesit = $("#Cesit" + ID + "").val();
        var Renk = $("#Renk" + ID + "").val();
        if (Adi != "" && Cesit != "" && Renk != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'ID': ID,
                    'Firma': Firma,
                    'Adi': $.trim(Adi),
                    'Cesit': $.trim(Cesit),
                    'Renk': $.trim(Renk),
                    'KulpDuzenle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "var") {
                        <?= $Kayitvar ?>
                    } else {
                        window.location.assign("KulpSiparis.php");
                    }
                }
            })
        } else {
            <?= $Gecersiz ?>
        }
    });

    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               KAPAK              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

    $("#YeniKapak").click(function() {
        var Firma = $("#Firma").val();
        var Adi = $("#Adi").val();
        if (Adi != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Firma': Firma,
                    'Adi': $.trim(Adi),
                    'KapakEkle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "var") {
                        <?= $Kayitvar ?>
                    } else {
                        window.location.assign("KapakSiparis.php");
                    }
                }
            })
        } else {
            <?= $Gecersiz ?>
        }
    });

    $('.KapakDuzenle').click(function() {
        var ID = $(this).attr("KapakID");
        var Firma = $("#Firma" + ID + "").val();
        var Adi = $("#Adi" + ID + "").val();
        if (Adi != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'ID': ID,
                    'Firma': Firma,
                    'Adi': $.trim(Adi),
                    'KapakDuzenle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "var") {
                        <?= $Kayitvar ?>
                    } else {
                        window.location.assign("KapakSiparis.php");
                    }
                }
            })
        } else {
            <?= $Gecersiz ?>
        }
    });

    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########
    //##########      ####################      ###################               TEPE              ####################      ####################      ####################      ##########
    //##########      ####################      ####################      ####################      ####################      ####################      ####################      ##########

    $("#YeniTepe").click(function() {
        var Firma = $("#Firma").val();
        var Adi = $("#Adi").val();
        if (Adi != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Firma': Firma,
                    'Adi': $.trim(Adi),
                    'TepeEkle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "var") {
                        <?= $Kayitvar ?>
                    } else {
                        window.location.assign("TepeSiparis.php");
                    }
                }
            })
        } else {
            <?= $Gecersiz ?>
        }
    });

    $('.TepeDuzenle').click(function() {
        var ID = $(this).attr("TepeID");
        var Firma = $("#Firma" + ID + "").val();
        var Adi = $("#Adi" + ID + "").val();
        if (Adi != "") {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'ID': ID,
                    'Firma': Firma,
                    'Adi': $.trim(Adi),
                    'TepeDuzenle': true,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "var") {
                        <?= $Kayitvar ?>
                    } else {
                        window.location.assign("TepeSiparis.php");
                    }
                }
            })
        } else {
            <?= $Gecersiz ?>
        }
    });
</SCRIPT>