<script>
    $(function() {
        $("body").click(function() {
            $(".UrunAdlari").text("");
            $("#UrunAdlari").removeClass('show');
        });

        //      Set Listele

        $.SetListele = function() {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'SetListele': true,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $(".UrunYaz").html(data);
                }
            });
        }

        $.SetListele();

        $("#Set").keyup(function() {
            var set = $(this).val();
            if (set.length > 1) {
                $.ajax({
                    type: "POST",
                    url: "AjaxForm/post.php",
                    data: {
                        'set': set,
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert('Hata: ' + xhr.responseText);
                    },
                    success: function(data) {
                        $("#SetAdlari").addClass('show');
                        $("#SetAdlari").html(data)
                    }
                });
            }
        });

        $("#SetAdlari").click(function() {
            var SetAdi = $(this).children("li").html();
            var SetID = $(this).children("li").attr("id");
            $("#Set").val(SetAdi);
            $("#SetID").val(SetID);
            $("#SetAdlari").removeClass('show');
        });

        //#######   ###########    #################    ###########      Ürün Ekle

        $("#SeteEkle").click(function() {
            var urun = $(".UrunGoster").text();
            $(".Urunler").html(urun);

            $('#Set').prop("disabled", false);
            $('#SetKayit').prop("disabled", false); //Set Kayıt butonu etkinleştir.

            //var Set_ID = $("#SetID").val();

            var UrunID = $("#UrunID").val();
            var Kalinlik = $("#Kalinlik").val();
            var Cap = $("#Cap").val();


            ///////////////////////////////////////////////////////////////            //Boya Gram

            //İÇ ASTAR GRAMAJ
            var icAstar = $("#icAstar").children('option:selected').attr('icAstar');

            // İÇ ÜSTKAT GRAMAJ
            var icUstkat = $("#icUstkat").children('option:selected').attr('icUstkat');

            //Dış ÜST KAT GRAMAJ
            var DisUstkat = $("#DisUstkat").children('option:selected').attr('DisUstkat');

            //Dış ASTAR KAT GRAMAJ
            var DisAstar = $("#DisAstar").children('option:selected').attr('DisAstar');

            //TOPLAM GRAM
            var Kg_icAstar = parseFloat(icAstar).toFixed(2);
            var Kg_icUstkat = parseFloat(icUstkat).toFixed(2);
            var Kg_DisUstkat = parseFloat(DisUstkat).toFixed(2);
            var Kg_DisAstar = parseFloat(DisAstar).toFixed(2);

            var KalinlikFormat = parseFloat(Kalinlik).toFixed(2);

            //          1 adet levha ağırlık hesabı

            var a = Cap * Cap * KalinlikFormat * (0.22);
            var Gram = a / 1000;

            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'UrunID': UrunID,
                    'TKalinlik': KalinlikFormat,
                    'Cap': Cap,
                    'Kg_icAstar': Kg_icAstar,
                    'Kg_icUstkat': Kg_icUstkat,
                    'Kg_DisUstkat': Kg_DisUstkat,
                    'Kg_DisAstar': Kg_DisAstar,
                    'Kg': Gram,
                    'Kayit': true,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $(".UrunYaz").html(data);
                }
            });

            $("#UrunAdi").val("");
            $(".combo").text("");
            $("#Kalinlik").text("");
            $("#Cap").text("");
            $("#Kulp").text("");
            $("#Tepe").text("");
            $(".resim").html("<img src='' width='250px' height='200px'>");

            $('.combo').prop("disabled", true);
            $('#Kalinlik').prop("disabled", true);
            $('#Cap').prop("disabled", true);
            $('#Kulp').prop("disabled", true);
            $('#Tepe').prop("disabled", true);
            $('#SeteEkle').prop("disabled", true);

            $.SetListele();
        });

        //////////////////////////////////////////////////////////////////////////

        //Ürün Ara
        $("#UrunAdi").keyup(function() {
            var kelime = $(this).val();
            if (kelime.length > 1) {
                $.ajax({
                    type: "POST",
                    url: "AjaxForm/post.php",
                    data: {
                        'kelime': kelime,
                    },
                    error: function(xhr, textStatus, errorThrown) {
                        alert('Hata: ' + xhr.responseText);
                    },
                    success: function(data) {
                        $("#UrunAdlari").addClass('show');
                        $("#UrunAdlari").html(data)
                    }
                });
            }
            $(".combo").text("");
            $("#Kalinlik").text("");
            $("#Cap").text("");
            $("#Kulp").text("");
            $("#Tepe").text("");
            $(".resim").html("<img src='' width='250px' height='200px'>");

            $('.combo').prop("disabled", true);
            $('#Kalinlik').prop("disabled", true);
            $('#Cap').prop("disabled", true);
            $('#Kulp').prop("disabled", true);
            $('#Tepe').prop("disabled", true);
            $('#SeteEkle').prop("disabled", true);
        });


        $(document).on("click", "#UrunAdlari li", function() {
            var UrunAdi = $(this).html();
            $(".UrunGoster").html(UrunAdi);
            $("#UrunAdlari").removeClass('show');

            var id = $(this).attr("Urun_ID");
            $("#UrunAdi").val(UrunAdi);
            $("#UrunID").val(id);


            //BOYALARI ÇEK
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Boya': id,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $(".combo").html(data);
                }
            });
            //Çap Çek
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Capi': id,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $("#Cap").html(data);
                }
            });
            //Kalınlık Çek
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Kalinlik': id,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $("#Kalinlik").html(data);
                }
            });

            //Resim Getir
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Foto': id,
                },
                error: function(xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $(".resim").html(data);
                }
            });
            $('.combo').prop("disabled", false);
            $('#Kalinlik').prop("disabled", false);
            $('#Cap').prop("disabled", false);
            $('#Kulp').prop("disabled", false);
            $('#Tepe').prop("disabled", false);
            $('#SeteEkle').prop("disabled", false);

        });
    });
</script>