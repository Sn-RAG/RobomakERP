<?php
$kisa="document.querySelector";
@$Urunler=$_GET["Urunler"];
@$Kulp=$_GET["Kulp"];
@$Kapak=$_GET["Kapak"];
@$Tepe=$_GET["Tepe"];
@$Secimler=$_GET["Secimler"];
@$Seticerigi=$_GET["Seticerigi"];
$SorAc=isset($Urunler)?"iki":(isset($Kulp)?"bes":(isset($Kapak)?"alti":(isset($Tepe)?"yedi":(isset($Secimler)?"sekiz":(isset($Seticerigi)?"dort":"")))));
$SorSira=isset($Urunler)?"s2":(isset($Kulp)?"s3":(isset($Kapak)?"s4":(isset($Tepe)?"s5":(isset($Secimler)?"s6":(isset($Seticerigi)?"s7":"")))));
?>
<script>
    $(function () {
        $.Listele = function () {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Listele': true,
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function (data) {
                    $(".UrunleriGoster").html(data);
                }
            })
        }
        <?=isset($_SESSION["Set_ID"]) ? "$.Listele();" : "" ?>

        //##################################################### form input ekle
        $(document).on('click', '.input-ekle', function (e) {
            var DisBoyalar = [];
            $("select.DisBoyalar").each(function (i, sel) {
                var selectedVal = $(sel).val();
                DisBoyalar.push(selectedVal);
            });
            if (DisBoyalar.length > 5) {
                $(".input-ekle").prop("disabled", true)
                $("#SetTamam").prop("disabled", true)
            }
            var clone, examsList;
            e.preventDefault();
            examsList = $('.inputlar');
            clone = examsList.children('.form-group:first').clone(true);
            clone.append($('<button>').addClass('btn col-md-1 btn-danger bi-trash input-sil'));
            return examsList.append(clone);
        });
        $(document).on('click', '.input-sil', function (e) {
            var DisBoyalar = [];
            $("select.DisBoyalar").each(function (i, sel) {
                var selectedVal = $(sel).val();
                DisBoyalar.push(selectedVal);
            });
            if (DisBoyalar.length <= 8) {// O anki değeri geriden geldiği için
                $(".input-ekle").prop("disabled", false)
                $("#SetTamam").prop("disabled", false)
            }
            e.preventDefault();
            return $(this).parent().remove();
        });


        /*$("#bir").attr("disabled", "");
        $("#iki").attr("disabled", "");
        $("#uc").attr("disabled", "");
        $("#dort").attr("disabled", "");
        $("#bes").attr("disabled", "");
        $("#alti").attr("disabled", "");
        $("#yedi").attr("disabled", "");
        $("#sekiz").attr("disabled", "");*/

//#####    ########    ##########    ########    ##########    ########    ##########    ########    ##########    ########    ##########    ########    #####
        // Yapılan iş Bu kısımda navigasyonlarda veriyi hem kaybetmemek hem kaldığı yerden devam etmesi için


        $.Sirala=function (deneme,abc){
            var ustDiv = <?=$kisa?>(".Sirala");
            ustDiv.insertBefore(deneme, abc);
        };
        $.Urunler=function () {
            $("#bir").addClass('collapsed');
            $("#collapsebir").removeClass('show');
            $("#bir").removeAttr("aria-expanded")

            $("#<?=$SorAc?>").removeClass('collapsed');
            $("#collapse<?=$SorAc?>").addClass('show');
            $("#<?=$SorAc?>").attr('aria-expanded', true);

            //Sıralama
            var a = <?=$kisa?>(".<?=$SorSira?>");
            var b = <?=$kisa?>(".s1");
            $.Sirala(a,b);
        }
        <?=$_GET?"$.Urunler();":""?>
    });
//#####    ########    ##########    ########    ##########    ########    ##########    ########    ##########    ########    ##########    ########    #####

    $("#Set").click(function () {

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
                error: function (xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function (data) {
                    $("#SetAdiKontrol").html(data);
                    if (data == "") {
                        $("#bir").addClass('collapsed');
                        $("#collapsebir").removeClass('show');
                        $("#bir").removeAttr("aria-expanded")

                        $("#iki").removeClass('collapsed');
                        $("#collapseiki").addClass('show');
                        $("#iki").attr('aria-expanded', true);

                        var a = <?=$kisa?>(".s1");
                        var b = <?=$kisa?>(".s8");
                        $.Sirala(a,b);
                    }
                }
            })
        }
    });

    //#####################################################

    $("#UrunSec").click(function () {
        var UrunIDler = [];
        $(".UrunSecim:checked").map(function () {UrunIDler.push($(this).val());});

        if(UrunIDler==""){
            $("#UrunBos").html("Ürün Seçmediniz!");
        }else{
            $("#UrunBos").html("");
            $("#iki").addClass('collapsed');
            $("#collapseiki").removeClass('show');
            $("#iki").removeAttr("aria-expanded")

            $("#bes").removeClass('collapsed');
            $("#collapsebes").addClass('show');
            $("#bes").attr('aria-expanded', true);

            var a = <?=$kisa?>(".s2");
            var b = <?=$kisa?>(".s8");
            $.Sirala(a,b);

            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {'UrunIDler': UrunIDler}
            })
        }
    });
    $("#GeriSetAdi").click(function () {
        $("#iki").addClass('collapsed');
        $("#collapseiki").removeClass('show');
        $("#iki").removeAttr("aria-expanded")

        $("#bir").removeClass('collapsed');
        $("#collapsebir").addClass('show');
        $("#bir").attr('aria-expanded', true);

        var a = <?=$kisa?>(".s1");
        var b = <?=$kisa?>(".s2");
        $.Sirala(a,b);
    });
    //#####################################################
    $("#KulpSec").click(function () {

        var Kulp = $("#Kulp").val();

        if (Kulp == "") {
            $(".KulpSecmedin").html("Kulp Seçmediniz!");
        } else {
            $(".KulpSecmedin").html("");
            $("#bes").addClass('collapsed');
            $("#collapsebes").removeClass('show');
            $("#bes").removeAttr("aria-expanded");

            $("#alti").removeClass('collapsed');
            $("#collapsealti").addClass('show');
            $("#alti").attr('aria-expanded', true);

            var a = <?=$kisa?>(".s3");
            var b = <?=$kisa?>(".s8");
            $.Sirala(a,b);

            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {'KulpSec': Kulp}
            })
        }
    });
    $("#KapakSec").click(function () {

        var Kapak = $("#Kapak").val();

        if (Kapak == "") {
            $(".KapakSecmedin").html("Kapak Seçmediniz!");
        } else {
            $(".KapakSecmedin").html("");
            $("#alti").addClass('collapsed');
            $("#collapsealti").removeClass('show');
            $("#alti").removeAttr("aria-expanded");


            $("#yedi").removeClass('collapsed');
            $("#collapseyedi").addClass('show');
            $("#yedi").attr('aria-expanded', true);

            var a = <?=$kisa?>(".s4");
            var b = <?=$kisa?>(".s8");
            $.Sirala(a,b);

            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {'KapakSec': Kapak}
            })
        }
    });
    $("#TepeSec").click(function () {

        var Tepe = $("#Tepe").val();

        if (Tepe == "") {
            $(".TepeSecmedin").html("Tepe Seçmediniz!");
        } else {
            $(".TepeSecmedin").html("");
            $("#yedi").addClass('collapsed');
            $("#collapseyedi").removeClass('show');
            $("#yedi").removeAttr("aria-expanded");

            $("#sekiz").removeClass('collapsed');
            $("#collapsesekiz").addClass('show');
            $("#sekiz").attr('aria-expanded', true);

            var a = <?=$kisa?>(".s5");
            var b = <?=$kisa?>(".s8");
            $.Sirala(a,b);

            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {'TepeSec': Tepe}
            })
        }
    });
    $("#Secimler").click(function () {

        var Kutu = $("#Kutu").val();
        var Kalinlik = $("#Kalinlik").val();

        if (Kutu == ""||Kalinlik == "") {
            $(".SecimlerHata").html("* Zorunlu alanları seçmediniz!");
        } else {
            $(".SecimlerHata").html("");
            $("#sekiz").addClass('collapsed');
            $("#collapsesekiz").removeClass('show');
            $("#sekiz").removeAttr("aria-expanded");


            $("#dort").removeClass('collapsed');
            $("#collapsedort").addClass('show');
            $("#dort").attr('aria-expanded', true);

            var a = <?=$kisa?>(".s6");
            var b = <?=$kisa?>(".s8");
            $.Sirala(a,b);
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {'KutuSec': Kutu,'KalinlikSec': Kalinlik}
            })
        }
    });
    $("#GeriSecimler").click(function () {
        $("#dort").addClass('collapsed');
        $("#collapsedort").removeClass('show');
        $("#dort").removeAttr("aria-expanded")

        $("#sekiz").removeClass('collapsed');
        $("#collapsesekiz").addClass('show');
        $("#sekiz").attr('aria-expanded', true);

        //Sıralama
        var a = <?=$kisa?>(".s6");
        var b = <?=$kisa?>(".s7");
        $.Sirala(a,b);
    });
    $("#GeriTepeSec").click(function () {
        $("#sekiz").addClass('collapsed');
        $("#collapsesekiz").removeClass('show');
        $("#sekiz").removeAttr("aria-expanded")

        $("#yedi").removeClass('collapsed');
        $("#collapseyedi").addClass('show');
        $("#yedi").attr('aria-expanded', true);

        //Sıralama
        var a = <?=$kisa?>(".s5");
        var b = <?=$kisa?>(".s6");
        $.Sirala(a,b);
    });
    $("#GeriKapakSec").click(function () {
        $("#yedi").addClass('collapsed');
        $("#collapseyedi").removeClass('show');
        $("#yedi").removeAttr("aria-expanded")

        $("#alti").removeClass('collapsed');
        $("#collapsealti").addClass('show');
        $("#alti").attr('aria-expanded', true);

        //Sıralama
        var a = <?=$kisa?>(".s4");
        var b = <?=$kisa?>(".s5");
        $.Sirala(a,b);
    });
    $("#GeriUrunSec").click(function () {
        $("#bes").addClass('collapsed');
        $("#collapsebes").removeClass('show');
        $("#bes").removeAttr("aria-expanded")

        $("#iki").removeClass('collapsed');
        $("#collapseiki").addClass('show');
        $("#iki").attr('aria-expanded', true);

        //Sıralama
        var a = <?=$kisa?>(".s2");
        var b = <?=$kisa?>(".s3");
        $.Sirala(a,b);
    });
    //#####################################################
    $("#GeriKulpSec").click(function () {
        $("#alti").addClass('collapsed');
        $("#collapsealti").removeClass('show');
        $("#alti").removeAttr("aria-expanded")

        $("#bes").removeClass('collapsed');
        $("#collapsebes").addClass('show');
        $("#bes").attr('aria-expanded', true);

        //Sıralama
        var a = <?=$kisa?>(".s3");
        var b = <?=$kisa?>(".s4");
        $.Sirala(a,b);
    });

    $(".UrunSecim").on("click", function () {
        var ID = $(this).attr("id");
        var mm=$(".kal"+ID+"").val();//Tıkladığım kalınlık
        var mmler = [];
        var UrunIDler = [];
        $(".UrunSecim:checked").map(function () {
            $(".kal"+$(this).val()+"").map(function () {
                mmler.push($(this).val());
            });
        });
        //Seçili olan kalınlıklar ve tıkladığımızı karşılaştırıyoruz
        $.each(mmler,function(i, sel){
            if (sel != mm){
                //$(".kal"+sel[i]+"").prop('checked',false);
                <?=$Baska?>
            }
        });
    });

    $("#SetTamam").click(function () {

        var SetAdi = $("#SetAdi").val();
        var Kalinlik = $("#Kalinlik").val();
        var Kapak = $("#Kapak").val();
        var Kulp = $("#Kulp").val();
        var Tepe = $("#Tepe").val();
        var Kutu = $("#Kutu").val();


        var UrunIDler = [];
        $(".UrunSecim:checked").map(function () {
            UrunIDler.push($(this).val());
        });

        var Adetler = [];
        $("input.Adetler").each(function (i, sel) {
            var selectedVal = $(sel).val();
            Adetler.push(selectedVal);
        });

        var icBoyalar = [];
        $("select.icBoyalar").each(function (i, sel) {
            var selectedVal = $(sel).val();
            icBoyalar.push(selectedVal);
        });

        var DisBoyalar = [];
        $("select.DisBoyalar").each(function (i, sel) {
            var selectedVal = $(sel).val();
            DisBoyalar.push(selectedVal);
        });

        for (let i = 0; i < DisBoyalar.length; i++) {
            if (DisBoyalar[i] == '' || icBoyalar[i] == '' || Adetler[i] == '' || Kalinlik == "" || Kapak == "") {
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
                                'SetAdi': $.trim(SetAdi),
                                'Kalinlik': Kalinlik,
                                'Kapak': Kapak,
                                'Kulp': Kulp,
                                'Tepe': Tepe,
                                'Kutu': Kutu,
                                'icBoyalar': icBoyalar,
                                'DisBoyalar': DisBoyalar,
                                'Adetler': Adetler,
                                'Sec': true,
                            },
                            error: function (xhr, textStatus, errorThrown) {
                                alert('Hata: ' + xhr.responseText);
                            },
                            success: function () {
                                $.Listele();
                            }
                        })
                        $("#dort").addClass('collapsed');
                        $("#collapsedort").removeClass('show');
                        $("#dort").removeAttr("aria-expanded")


                        $("#uc").removeClass('collapsed');
                        $("#collapseuc").addClass('show');
                        $("#uc").attr('aria-expanded', true);

                        var a = <?=$kisa?>(".s8");
                        var b = <?=$kisa?>(".s7");
                        $.Sirala(a,b);

                    } else if (result.isDenied) {
                        $(".Fazlainput").html("");
                    }
                })
            }
        }
    });


    //#####################################################
    $("#icerikSec").click(function () {
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
                error: function (xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function (data) {
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

</script>