<?php
$Has = ".hasClass('btn-primary')";
?>
<script>
    $(function() {
        var SetID = $("#SetID").val();
        $.Listele = function() {
            var Urunler = <?php echo json_encode($Urunler); ?>;

            if ($("#Pres") <?= $Has ?>) {
                Hangisi = "Pres";
                Is = "Preslendi";
            } else if ($("#Telleme") <?= $Has ?>) {
                Hangisi = "Telleme";
                Is = "Tellendi";
            } else if ($("#Kumlama") <?= $Has ?>) {
                Hangisi = "Kumlama";
                Is = "Kumlandı";
            } else if ($("#icBoyama") <?= $Has ?>) {
                Hangisi = "icBoyama";
                Is = "Boyandı";
            } else if ($("#DisBoyama") <?= $Has ?>) {
                Hangisi = "DisBoyama";
                Is = "Boyandı";
            } else if ($("#Paketleme") <?= $Has ?>) {
                Hangisi = "Paketleme";
                Is = "Paketlendi";
            } else if ($("#Yikama") <?= $Has ?>) {
                Hangisi = "Yıkama";
                Is = "Yıkandı";
            }
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'Listele': SetID,
                    'HangiButon': Hangisi,
                    'Urunler': Urunler
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    //$(".yazsayi" + Uid + "").html(data);
                    $(".UrunYaz").html(data);
                }
            })
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'isDurum': SetID,
                    'Is': Is,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data != "") {
                        $(".isDurum").html(data);
                    } else {
                        $(".isDurum").html("<strong class='secondary-font'> İşlem: Başlamadı </strong><small class='text-muted bi-clock'></small>");
                    }
                }
            })
        }
        $.Listele();
    });
    //##### ########## ########## ########## ########## ########## ########## ########## ########## ########## ########## ########## #####
    $('.gir').click(function() {
        var Uid = $(this).attr("Urun_ID");
        var SetID = $(this).attr("Set_ID");
        var deger = $("#deger" + Uid + "").val();
        var Tarih = $(".Tarih").val();
        if (deger != "" & Number(deger) != 0) {
            if ($("#Pres") <?= $Has ?>) {
                Hangisi = "Pres";
            } else if ($("#Telleme") <?= $Has ?>) {
                Hangisi = "Telleme";
            } else if ($("#Kumlama") <?= $Has ?>) {
                Hangisi = "Kumlama";
            } else if ($("#icBoyama") <?= $Has ?>) {
                Hangisi = "icBoyama";
            } else if ($("#DisBoyama") <?= $Has ?>) {
                Hangisi = "DisBoyama";
            } else if ($("#Paketleme") <?= $Has ?>) {
                Hangisi = "Paketleme";
            } else if ($("#Yikama") <?= $Has ?>) {
                Hangisi = "Yıkama";
            }

            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'SetID': SetID,
                    'UrunID': Uid,
                    'Deger': deger,
                    'Hangisi': Hangisi,
                    'Tarih': Tarih
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $(".yazsayi" + Uid + "").html(data);
                    $(".temizle").val("");
                }
            })
        } else {
            if ($("#hata" + Uid + "").children("label").length == 0) {
                $("#hata" + Uid + "").append($('<label>').html("Değer Giriniz!").addClass("small text-danger"));
            }

        }
    });
    $('.fire').click(function() {
        var Uid = $(this).attr("Urun_ID");
        var SetID = $(this).attr("Set_ID");
        var deger = $("#deger" + Uid + "").val();
        var Tarih = $(".Tarih").val();
        var Hangisi = "";
        if (deger != "" & Number(deger) != 0) {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'FSetID': SetID,
                    'FUrunID': Uid,
                    'FDeger': deger,
                    'FTarih': Tarih
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function() {
                    $.Listele();
                    $(".temizle").val("");
                }
            })
        } else {
            if ($("#hata" + Uid + "").children("label").length == 0) {
                $("#hata" + Uid + "").append($('<label>').html("Değer Giriniz!").addClass("small text-danger"));
            }

        }
    });

    //###################################################################################################################################################

    $.tmz = function() {
        $(".t").removeClass("btn-primary");
        $(".t").addClass("btn-outline-dark");
    }

    $("#Telleme").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden",true);

    });
    $("#Kumlama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden",true);
    });
    $("#icBoyama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden",true);
    });
    $("#DisBoyama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden",true);
    });
    $("#Paketleme").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden",true);
    });
    $("#Pres").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden",false);
    });
    $("#Yikama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden",true);
    });
</script>