<?php
$Kisalt=".hasClass('btn-primary')";
?>
<script>
    $(function () {
        var SetID=$("#SetID").val();
        $.Listele = function () {
            var Hangisi = "";
            var Is = "";
            if ($("#Pres")<?=$Kisalt?>) {
                Hangisi = "Pres";
                Is = "Preslendi";
            } else if ($("#Telleme")<?=$Kisalt?>) {
                Hangisi = "Telleme";
                Is = "Tellendi";
            } else if ($("#Kumlama")<?=$Kisalt?>) {
                Hangisi = "Kumlama";
                Is = "Kumlandı";
            } else if ($("#icBoyama")<?=$Kisalt?>) {
                Hangisi = "icBoyama";
                Is = "Boyandı";
            }else if ($("#DisBoyama")<?=$Kisalt?>) {
                Hangisi = "DisBoyama";
                Is = "Boyandı";
            } else if ($("#Paketleme")<?=$Kisalt?>) {
                Hangisi = "Paketleme";
                Is = "Paketlendi";
            }else if ($("#Yikama")<?=$Kisalt?>) {
                Hangisi = "Yıkama";
                Is = "Yıkandı";
            }
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Listele': SetID,
                    'HangiButon':Hangisi,
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function (data) {
                    $(".UrunYaz").html(data);
                }
            });
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'isDurum': SetID,
                    'Is':Is,
                },
                error: function (xhr, textStatus, errorThrown) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function (data) {
                    $(".isDurum").html(data);
                }
            });
        }
        $.Listele();
    });
    //##### ########## ########## ########## ########## ########## ########## ########## ########## ########## ########## ########## #####

    $.tmz = function () {
        $(".t").removeClass("btn-primary");
        $(".t").addClass("btn-outline-dark");
    }
    $.Spinekle=function (){
        $(".Spinekle").children("div").remove();
        $(".Spinekle").prepend($('<div>').addClass('spinner-border text-secondary'));
    }

    $("#Telleme").click(function () {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Spinekle();
        $(".Islem").html(" İşlem: Telleme ");
        $(".Sonuc").html(" 30d önce ");
        $(".UrunAdet").html("1 Adet 18 Derin Tencere Tellendi.");
        $.Listele();

    });
    $("#Kumlama").click(function () {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Spinekle();
        $(".Islem").html(" İşlem: Kumlama ");
        $(".Sonuc").html(" 30d önce ");
        $(".UrunAdet").html("1 Adet 18 Derin Tencere Kumlandı.");
        $.Listele();
    });
    $("#icBoyama").click(function () {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Spinekle();
        $(".Islem").html(" İşlem: Boyama ");
        $(".Sonuc").html(" 30d önce ");
        $(".UrunAdet").html("1 Adet 18 Derin Tencere Boyandı.");
        $.Listele();
    });
    $("#DisBoyama").click(function () {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Spinekle();
        $(".Islem").html(" İşlem: Boyama ");
        $(".Sonuc").html(" 30d önce ");
        $(".UrunAdet").html("1 Adet 18 Derin Tencere Boyandı.");
        $.Listele();
    });
    $("#Paketleme").click(function () {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Spinekle();
        $(".Islem").html(" İşlem: Paketleme ");
        $(".Sonuc").html(" 30d önce ");
        $(".UrunAdet").html("1 Adet 18 Derin Tencere Paketlendi.");
        $.Listele();
    });
    $("#Pres").click(function () {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Spinekle();
        $(".Islem").html(" İşlem: Pres ");
        $(".Sonuc").html(" 30d önce ");
        $(".UrunAdet").html("1 Adet 18 Derin Tencere Preslendi.");
        $.Listele();
    });
    $("#Yikama").click(function () {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Spinekle();
        $(".Islem").html(" İşlem: Yıkama ");
        $(".Sonuc").html(" 30d önce ");
        $(".UrunAdet").html("1 Adet 18 Derin Tencere Yıkandı.");
        $.Listele();
    });
</script>