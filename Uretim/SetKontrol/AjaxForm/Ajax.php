<?php
$Has = ".hasClass('btn-primary')";
?>
<script>
    $(function() {
        $.Listele = function() {
            var SetID = $("#SetID").val();
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
                    if (data != "") {
                        $(".isDurum").html(data);
                    } else {
                        $(".isDurum").html("<strong class='secondary-font'> İşlem: Başlamadı </strong><small class='text-muted bi-clock'></small>");
                    }
                }
            });
        }
        $.Listele();
    });
    //##### ########## ########## ########## ########## ########## ########## ########## ########## ########## ########## ########## #####
    $('.gir').click(function() {
        var Uid = $(this).attr("Urun_ID");
        var SetID = $(this).attr("Set_ID");
        var deger = $("#deger" + Uid + "").val();
        var Tarih = $(".Tarih").val();
        // if (Number($(".yazsayi" + Uid + "").html()) + Number(deger) >= Number($(".Tadet").val())) {
        /*<?= $FazlaDeger ?>*/
        // } else {
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
                    $.Listele();
                }
            })
        } else {
            if ($("#hata" + Uid + "").children("label").length == 0) {
                $("#hata" + Uid + "").append($('<label>').html("Değer Giriniz!").addClass("small text-danger"));
            }

        }
        //}
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
                    $(".temizle").val("");
                    $.Listele();
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
        $('.fire').prop("hidden", true);

    });
    $("#Kumlama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", true);
    });
    $("#icBoyama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", true);
    });
    $("#DisBoyama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", true);
    });
    $("#Paketleme").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", true);
    });
    $("#Pres").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", false);
    });
    $("#Yikama").click(function() {
        $.tmz();
        $(this).removeClass("btn-primary");
        $(this).removeClass("btn-outline-dark");
        $(this).addClass("btn-primary");
        $.Listele();
        $('.fire').prop("hidden", true);
    });
    //#################      ########################################      ########################################      #######################
    $('.datatablem').DataTable({
        responsive: true,
        order: false,
        columnDefs: [{
            targets: '_all',
            orderable: false
        }, {
            "width": "25%",
            "targets": [0, 1]
        }],
        paging: false,
        bFilter: false,
        bInfo: false
    });

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
    $.Gizle = function() {
        $('#ChartLevha').prop("hidden", true);
        $('#ChartPres').prop("hidden", true);
        $('#ChartYika').prop("hidden", true);
        $('#ChartKumla').prop("hidden", true);
        $('#ChartTelle').prop("hidden", true);
        $('#ChartBoya').prop("hidden", true);
        $('#ChartPaket').prop("hidden", true);
    };
    $(".col-md-6").click(function() {
        $.Gizle();
        $('.bos').prop("hidden", true);
    });

    function Levha() {
        <?php if ($CartLevha == null) { ?>
            $.Gizle();
            $("#bosl").html("<h5>Levha verisi yok</h5>");
            $('#bosl').prop("hidden", false);
        <?php } else { ?>
            $('#ChartLevha').prop("hidden", false);
            $('#ChartPres').prop("hidden", true);
            $('#ChartYika').prop("hidden", true);
            $('#ChartKumla').prop("hidden", true);
            $('#ChartTelle').prop("hidden", true);
            $('#ChartBoya').prop("hidden", true);
            $('#ChartPaket').prop("hidden", true);
            $('.bos').prop("hidden", true);
            CLevha.reset();
            CLevha.update();
        <?php } ?>
    }

    function Press() {
        <?php if ($CartPresT == null) { ?>
            $.Gizle();
            $("#bospr").html("<h5>Pres verisi yok</h5>");
            $('#bospr').prop("hidden", false);
        <?php } else { ?>
            $('#ChartLevha').prop("hidden", true);
            $('#ChartPres').prop("hidden", false);
            $('#ChartYika').prop("hidden", true);
            $('#ChartKumla').prop("hidden", true);
            $('#ChartTelle').prop("hidden", true);
            $('#ChartBoya').prop("hidden", true);
            $('#ChartPaket').prop("hidden", true);
            $('.bos').prop("hidden", true);
            CPres.reset();
            CPres.update();
        <?php } ?>
    }

    function Yika() {
        <?php if ($CartYikaT == null) { ?>
            $.Gizle();
            $("#bosy").html("<h5>Yıkama verisi yok</h5>");
            $('#bosy').prop("hidden", false);
        <?php } else { ?>
            $('#ChartLevha').prop("hidden", true);
            $('#ChartPres').prop("hidden", true);
            $('#ChartYika').prop("hidden", false);
            $('#ChartKumla').prop("hidden", true);
            $('#ChartTelle').prop("hidden", true);
            $('#ChartBoya').prop("hidden", true);
            $('#ChartPaket').prop("hidden", true);
            $('.bos').prop("hidden", true);
            CYika.reset();
            CYika.update();
        <?php } ?>
    }

    function Kumla() {
        <?php if ($CartKumlaT == null) { ?>
            $.Gizle();
            $("#bosk").html("<h5>Kumlama verisi yok</h5>");
            $('#bosk').prop("hidden", false);
        <?php } else { ?>
            $('#ChartLevha').prop("hidden", true);
            $('#ChartPres').prop("hidden", true);
            $('#ChartYika').prop("hidden", true);
            $('#ChartKumla').prop("hidden", false);
            $('#ChartTelle').prop("hidden", true);
            $('#ChartBoya').prop("hidden", true);
            $('#ChartPaket').prop("hidden", true);
            $('.bos').prop("hidden", true);
            CKumla.reset();
            CKumla.update();
        <?php } ?>
    }

    function Telle() {
        <?php if ($CartTelleT == null) { ?>
            $.Gizle();
            $("#bost").html("<h5>Telleme verisi yok</h5>");
            $('#bost').prop("hidden", false);
        <?php } else { ?>
            $('#ChartLevha').prop("hidden", true);
            $('#ChartPres').prop("hidden", true);
            $('#ChartYika').prop("hidden", true);
            $('#ChartKumla').prop("hidden", true);
            $('#ChartTelle').prop("hidden", false);
            $('#ChartBoya').prop("hidden", true);
            $('#ChartPaket').prop("hidden", true);
            $('.bos').prop("hidden", true);
            CTelle.reset();
            CTelle.update();
        <?php } ?>
    }

    function Boya() {
        <?php if ($CartBoyaT == null) { ?>
            $.Gizle();
            $("#bosb").html("<h5>Boyama verisi yok</h5>");
            $('#bosb').prop("hidden", false);
        <?php } else { ?>
            $('#ChartLevha').prop("hidden", true);
            $('#ChartPres').prop("hidden", true);
            $('#ChartYika').prop("hidden", true);
            $('#ChartKumla').prop("hidden", true);
            $('#ChartTelle').prop("hidden", true);
            $('#ChartBoya').prop("hidden", false);
            $('#ChartPaket').prop("hidden", true);
            $('.bos').prop("hidden", true);
            CBoya.reset();
            CBoya.update();
        <?php } ?>
    }

    function Paket() {
        <?php if ($CartPaketT == null) { ?>
            $.Gizle();
            $("#bosp").html("<h5>Paketleme verisi yok</h5>");
            $('#bosp').prop("hidden", false);
        <?php } else { ?>
            $('#ChartLevha').prop("hidden", true);
            $('#ChartPres').prop("hidden", true);
            $('#ChartYika').prop("hidden", true);
            $('#ChartKumla').prop("hidden", true);
            $('#ChartTelle').prop("hidden", true);
            $('#ChartBoya').prop("hidden", true);
            $('#ChartPaket').prop("hidden", false);
            $('.bos').prop("hidden", true);
            CPaket.reset();
            CPaket.update();
        <?php } ?>
    }
</script>