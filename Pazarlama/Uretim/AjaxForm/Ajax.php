<?php
$Has = ".hasClass('btn-primary')";
?>
<script>
    var SNo = <?= $SNo ?>;
    $(function() {

        $("td").addClass("ortala"); //dikey ortalama

        $('.icRenk').prop("hidden", true);
        $('.DisRenk').prop("hidden", true);
        $.Listele = function() {
            var sayi = <?= json_encode($sayi) ?>;
            switch (true) {
                case $("#Pres") <?= $Has ?>:
                    Is = "Preslendi";
                    break;
                case $("#Telleme") <?= $Has ?>:
                    Is = "Tellendi";
                    break;
                case $("#Kumlama") <?= $Has ?>:
                    Is = "Kumlandı";
                    break;
                case $("#icBoyama") <?= $Has ?>:
                    Is = "İçi Boyandı";
                    break;
                case $("#DisBoyama") <?= $Has ?>:
                    Is = "Dışı Boyandı";
                    break;
                case $("#Paketleme") <?= $Has ?>:
                    Is = "Paketlendi";
                    break;
                case $("#Yikama") <?= $Has ?>:
                    Is = "Yıkandı";
                    break;
            }

            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'is': Is,
                    'SNo': SNo,
                    'sayi': sayi,
                    'Listele': true
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $(".UrunYaz").html(data);
                }
            });
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'SNo': SNo,
                    'imalat': true,
                    'is': Is,
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    $(".isDurum").html(data);
                }
            });
        }
        $.Listele();
    });

    //##### ########## ########## ########## ########## ########## ########## ########## ########## ########## ########## ########## #####

    $('.Ekle').click(function() {
        var SetID = [];
        var Uid = [];
        var no = [];
        var LevhaID = [];
        var deger = [];

        var iBoya = $(".icRenk").val();
        var dBoya = $(".DisRenk").val();

        var Tarih = $(".Tarih").val();
        $(".GDeger").map(function() {
            if ($(this).val() != "") {
                SetID.push($(this).attr("SetID"));
                no.push($(this).attr("no"));
                Uid.push($(this).attr("UrunID"));
                LevhaID.push($(this).attr("LevhaID"));
                deger.push($(this).val());
            }
        });
        for (let i = 0; i < no.length; i++) {
            var sum = 0;
            $(".Tadet" + no[i] + "").map(function() {
                sum += Number($(this).text());
            });
            if (Number($("#yazsayi" + no[i] + "").html()) + Number(deger[i]) > sum) {
                <?= $FazlaDeger ?>
                return $(".GDeger").val("");
            }
        }
        if (Number(deger) <= 0 || deger == "") {
            <?= $Gecersiz ?>
        } else {
            switch (true) {
                case $("#Pres") <?= $Has ?>:
                    H = "Pres";
                    break;
                case $("#Telleme") <?= $Has ?>:
                    H = "Telleme";
                    break;
                case $("#Kumlama") <?= $Has ?>:
                    H = "Kumlama";
                    break;
                case $("#icBoyama") <?= $Has ?>:
                    H = "icBoyama";
                    break;
                case $("#DisBoyama") <?= $Has ?>:
                    H = "DisBoyama";
                    break;
                case $("#Paketleme") <?= $Has ?>:
                    H = "Paketleme";
                    break;
                case $("#Yikama") <?= $Has ?>:
                    H = "Yıkama";
                    break;
            }
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'SNo': SNo,
                    'SetID': SetID,
                    'UrunID': Uid,
                    'Deger': deger,
                    'LevhaID': LevhaID,
                    'dBoya': dBoya,
                    'iBoya': iBoya,
                    'Hangisi': H,
                    'Tarih': Tarih,
                    'Ekle': true
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "StokYok") {
                        <?= $StokYok ?>
                    } else {
                        $.Listele();
                    }
                }
            })
        }
        $(".GDeger").val("");
    });
    $('.fire').click(function() {
        var SetID = $(".GDeger").attr("SetID");
        var Uid = [];
        var LevhaID = [];
        var deger = [];
        var Tarih = $(".Tarih").val();
        $(".GDeger").map(function() {
            if ($(this).val() != "") {
                Uid.push($(this).attr("UrunID"));
                LevhaID.push($(this).attr("LevhaID"));
                deger.push($(this).val());
            }
        });
        if (Number(deger) <= 0 || deger == "") {
            <?= $Gecersiz ?>
        } else {
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'FSetID': SetID,
                    'FUrunID': Uid,
                    'FDeger': deger,
                    'LevhaID': LevhaID,
                    'FTarih': Tarih
                },
                error: function(xhr) {
                    alert('Hata: ' + xhr.responseText);
                },
                success: function(data) {
                    if (data == "StokYok") {
                        <?= $StokYok ?>
                    } else {
                        $.Listele();
                    }
                }
            })
        }
        $(".GDeger").val("");
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
        $('.fire').prop("hidden", true);
        $('.icRenk').prop("hidden", true);
        $('.DisRenk').prop("hidden", true);

    });
    $("#Kumlama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", true);
        $('.icRenk').prop("hidden", true);
        $('.DisRenk').prop("hidden", true);
    });
    $("#icBoyama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", true);
        $('.icRenk').prop("hidden", false);
        $('.DisRenk').prop("hidden", true);
    });
    $("#DisBoyama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", true);
        $('.icRenk').prop("hidden", true);
        $('.DisRenk').prop("hidden", false);
    });
    $("#Paketleme").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", true);
        $('.icRenk').prop("hidden", true);
        $('.DisRenk').prop("hidden", true);
    });
    $("#Pres").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", false);
        $('.icRenk').prop("hidden", true);
        $('.DisRenk').prop("hidden", true);
    });
    $("#Yikama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", true);
        $('.icRenk').prop("hidden", true);
        $('.DisRenk').prop("hidden", true);
    });
</script>