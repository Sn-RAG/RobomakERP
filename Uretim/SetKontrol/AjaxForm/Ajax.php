<?php
$Has = ".hasClass('btn-primary')";
?>
<script>
    $(function() {
        $('.icRenk').prop("hidden", true);
        $('.DisRenk').prop("hidden", true);
        $.Listele = function() {
            var SetID = <?= $SetID ?>;
            var Urunler = <?= json_encode($Urunler) ?>;

            switch (true) {
                case $("#Pres") <?= $Has ?>:
                    Hangisi = "Pres";
                    Is = "Preslendi";
                    break;
                case $("#Telleme") <?= $Has ?>:
                    Hangisi = "Telleme";
                    Is = "Tellendi";
                    break;
                case $("#Kumlama") <?= $Has ?>:
                    Hangisi = "Kumlama";
                    Is = "Kumlandı";
                    break;
                case $("#icBoyama") <?= $Has ?>:
                    Hangisi = "icBoyama";
                    Is = "İçi Boyandı";
                    break;
                case $("#DisBoyama") <?= $Has ?>:
                    Hangisi = "DisBoyama";
                    Is = "Dışı Boyandı";
                    break;
                case $("#Paketleme") <?= $Has ?>:
                    Hangisi = "Paketleme";
                    Is = "Paketlendi";
                    break;
                case $("#Yikama") <?= $Has ?>:
                    Hangisi = "Yıkama";
                    Is = "Yıkandı";
                    break;
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
                    $(".UrunYaz").html(data);
                }
            });
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
                    $(".isDurum").html(data);
                }
            });
        }
        $.Listele();
    });

    //##### ########## ########## ########## ########## ########## ########## ########## ########## ########## ########## ########## #####

    $('.gir').click(function() {
        var SetID = $(".GDeger").attr("SetID");
        var Uid = [];
        var LevhaID = [];
        var deger = [];

        var iBoya = $(".icRenk").val();
        var dBoya = $(".DisRenk").val();

        var Tarih = $(".Tarih").val();
        $(".GDeger").map(function() {
            if ($(this).val() != "") {
                Uid.push($(this).attr("UrunID"));
                LevhaID.push($(this).attr("LevhaID"));
                deger.push($(this).val());
            }
        });
       /* for (let i = 0; i < Uid.length; i++) {
            var sum = 0;
            $(".Tadet" + Uid[i] + "").map(function() {
                sum += Number($(this).text());
            });
            if (Number($("#yazsayi" + Uid[i] + "").html()) + Number(deger[i]) > sum) {
                <?= $FazlaDeger ?>
                return $(".GDeger").val("");
            }
        }*/
        if (Number(deger) <= 0 || deger == "") {
            <?= $Gecersiz ?>
        } else {
            switch (true) {
                case $("#Pres") <?= $Has ?>:
                    Hangisi = "Pres";
                    break;
                case $("#Telleme") <?= $Has ?>:
                    Hangisi = "Telleme";
                    break;
                case $("#Kumlama") <?= $Has ?>:
                    Hangisi = "Kumlama";
                    break;
                case $("#icBoyama") <?= $Has ?>:
                    Hangisi = "icBoyama";
                    break;
                case $("#DisBoyama") <?= $Has ?>:
                    Hangisi = "DisBoyama";
                    break;
                case $("#Paketleme") <?= $Has ?>:
                    Hangisi = "Paketleme";
                    break;
                case $("#Yikama") <?= $Has ?>:
                    Hangisi = "Yıkama";
                    break;
            }
            $.ajax({
                type: "POST",
                url: "AjaxForm/post.php",
                data: {
                    'SetID': SetID,
                    'UrunID': Uid,
                    'Deger': deger,
                    'LevhaID': LevhaID,
                    'dBoya': dBoya,
                    'iBoya': iBoya,
                    'Hangisi': Hangisi,
                    'Tarih': Tarih
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
    //#################      ########################################      ########################################      #######################

    var live = document.getElementById("ChartLevha");
    const CLevha = new Chart(live, {
        type: 'doughnut',
        data: {
            labels: [<?php foreach ($UrunAdi as $u) echo '"' . $u . '",'; ?>],
            datasets: [{
                data: [<?php
                        $say = count($UrunAdi) - count($CartLevha);
                        foreach ($CartLevha as $l) {
                            echo $l . ',';
                        }
                        if ($say > 0) {
                            for ($i = 0; $i < $say; $i++) {
                                echo '0,';
                            }
                        }
                        ?>],
                backgroundColor: [<?php for ($i = 0; $i < count($UrunAdi); $i++) {
                                        $r = rand(0, 255);
                                        $g = rand(0, 255);
                                        $b = rand(0, 255);
                                        echo '"' . "rgb($r, $g, $b)" . '",';
                                    }
                                    ?>]
            }]
        }
    });
    var live = document.getElementById("ChartPres");
    const CPres = new Chart(live, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($CartPresT as $t) echo '"' . $t . '",'; ?>],
            datasets: [{
                label: 'Toplam',
                data: [<?php foreach ($CartPresA as $a) echo '"' . $a . '",'; ?>],
                backgroundColor: [<?php for ($i = 0; $i < count($CartPresT); $i++) {
                                        $r = rand(0, 255);
                                        $g = rand(0, 255);
                                        $b = rand(0, 255);
                                        echo '"' . "rgba($r, $g, $b, 0.2)" . '",';
                                    }
                                    ?>],
                borderColor: [<?php for ($i = 0; $i < count($CartPresT); $i++) {
                                    $r = rand(0, 255);
                                    $g = rand(0, 255);
                                    $b = rand(0, 255);
                                    echo '"' . "rgb($r, $g, $b)" . '",';
                                }
                                ?>],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var live = document.getElementById("ChartYika");
    const CYika = new Chart(live, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($CartYikaT as $t) echo '"' . $t . '",'; ?>],
            datasets: [{
                label: 'Toplam',
                data: [<?php foreach ($CartYikaA as $a) echo '"' . $a . '",'; ?>],
                backgroundColor: [<?php for ($i = 0; $i < count($CartYikaT); $i++) {
                                        $r = rand(0, 255);
                                        $g = rand(0, 255);
                                        $b = rand(0, 255);
                                        echo '"' . "rgba($r, $g, $b, 0.2)" . '",';
                                    }
                                    ?>],
                borderColor: [<?php for ($i = 0; $i < count($CartYikaT); $i++) {
                                    $r = rand(0, 255);
                                    $g = rand(0, 255);
                                    $b = rand(0, 255);
                                    echo '"' . "rgb($r, $g, $b)" . '",';
                                }
                                ?>],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    var live = document.getElementById("ChartKumla");
    const CKumla = new Chart(live, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($CartKumlaT as $t) echo '"' . $t . '",'; ?>],
            datasets: [{
                label: 'Toplam',
                data: [<?php foreach ($CartKumlaA as $a) echo '"' . $a . '",'; ?>],
                backgroundColor: [<?php for ($i = 0; $i < count($CartKumlaT); $i++) {
                                        $r = rand(0, 255);
                                        $g = rand(0, 255);
                                        $b = rand(0, 255);
                                        echo '"' . "rgba($r, $g, $b, 0.2)" . '",';
                                    }
                                    ?>],
                borderColor: [<?php for ($i = 0; $i < count($CartKumlaT); $i++) {
                                    $r = rand(0, 255);
                                    $g = rand(0, 255);
                                    $b = rand(0, 255);
                                    echo '"' . "rgb($r, $g, $b)" . '",';
                                }
                                ?>],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    var live = document.getElementById("ChartTelle");
    const CTelle = new Chart(live, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($CartTelleT as $t) echo '"' . $t . '",'; ?>],
            datasets: [{
                label: 'Toplam',
                data: [<?php foreach ($CartTelleA as $a) echo '"' . $a . '",'; ?>],
                backgroundColor: [<?php for ($i = 0; $i < count($CartTelleT); $i++) {
                                        $r = rand(0, 255);
                                        $g = rand(0, 255);
                                        $b = rand(0, 255);
                                        echo '"' . "rgba($r, $g, $b, 0.2)" . '",';
                                    }
                                    ?>],
                borderColor: [<?php for ($i = 0; $i < count($CartTelleT); $i++) {
                                    $r = rand(0, 255);
                                    $g = rand(0, 255);
                                    $b = rand(0, 255);
                                    echo '"' . "rgb($r, $g, $b)" . '",';
                                }
                                ?>],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var live = document.getElementById("ChartBoya");
    const CBoya = new Chart(live, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($CartBoyaT as $t) echo '"' . $t . '",'; ?>],
            datasets: [{
                label: 'Toplam',
                data: [<?php foreach ($CartBoyaA as $a) echo '"' . $a . '",'; ?>],
                backgroundColor: [<?php for ($i = 0; $i < count($CartBoyaT); $i++) {
                                        $r = rand(0, 255);
                                        $g = rand(0, 255);
                                        $b = rand(0, 255);
                                        echo '"' . "rgba($r, $g, $b, 0.2)" . '",';
                                    }
                                    ?>],
                borderColor: [<?php for ($i = 0; $i < count($CartBoyaT); $i++) {
                                    $r = rand(0, 255);
                                    $g = rand(0, 255);
                                    $b = rand(0, 255);
                                    echo '"' . "rgb($r, $g, $b)" . '",';
                                }
                                ?>],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    var live = document.getElementById("ChartPaket");
    const CPaket = new Chart(live, {
        type: 'bar',
        data: {
            labels: [<?php foreach ($CartPaketT as $t) echo '"' . $t . '",'; ?>],
            datasets: [{
                label: 'Toplam',
                data: [<?php foreach ($CartPaketA as $a) echo '"' . $a . '",'; ?>],
                backgroundColor: [<?php for ($i = 0; $i < count($CartPaketT); $i++) {
                                        $r = rand(0, 255);
                                        $g = rand(0, 255);
                                        $b = rand(0, 255);
                                        echo '"' . "rgba($r, $g, $b, 0.2)" . '",';
                                    }
                                    ?>],
                borderColor: [<?php for ($i = 0; $i < count($CartPaketT); $i++) {
                                    $r = rand(0, 255);
                                    $g = rand(0, 255);
                                    $b = rand(0, 255);
                                    echo '"' . "rgb($r, $g, $b)" . '",';
                                }
                                ?>],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    /////////////////////////////////////////////////////////////////////////////////////////////

    $('.datatablem').DataTable({
        responsive: true,
        order: false,
        columnDefs: [{
            targets: '_all',
            orderable: false
        }],
        paging: false,
        bFilter: false,
        bInfo: false
    });
</script>