<?php
ob_start();
$page = "Ana Sayfa";
require __DIR__ . '/controller/Header.php';
require __DIR__ . "/controller/Yetki.php";
?>
<main id="main" class="main">
    <section class="section">
        <div class="row">
            <h5>&nbsp</h5>
            <div class="col-md-2  mb-3" <?= $SORDepo_sorumlusu ?>>
                <a style="display: flex;background-color: #142135;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;" class="nav-link collapsed" href="Navigasyon/Stok.php">Stok<img src="assets\img\ConteinerLink\stock.svg"></a>
            </div>

            <div class="col-md-2 mb-3" <?= $SorFerhat ?>>
                <a class="nav-link collapsed" href="Navigasyon/Uretim.php" style="display: flex;background-color: #142135;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;">Üretim<img src="assets\img\ConteinerLink\uretim.svg"></a>
            </div>

            <div class="col-md-2 mb-3" <?= $SORPazarlamaci ?>>
                <a class="nav-link collapsed" href="Navigasyon/Pazarlama.php" style="display: flex;background-color: #142135;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;">Pazarlama<img src="assets\img\ConteinerLink\pazarlama.svg"></a>
            </div>

            <div class="col-md-2 mb-3" <?= $SORSatın_alma ?>>
                <a class="nav-link collapsed" href="Navigasyon/SatinAlma.php" style="display: flex;background-color: #142135;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;">Satın Alma<img src="assets\img\ConteinerLink\satinalma.svg"></a>
            </div>

            <div class="col-md-2 mb-3" <?= $SORPazarlamaci ?>>
                <a href="Firmalar/Firmalar.php" style="display: flex;background-color: #142135;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px;justify-content: center;align-items: center;justify-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: center;">Firmalar<img src="assets\img\ConteinerLink\firmalar.svg"></a>
            </div>

            <div class="col-md-2 mb-3" <?= $SORGUAdmin ?>>
                <a href="admin/index.php" style="border: 0 solid #ffffff00;display: flex;background-color: #4300c9;color: white;border-color: #ffffff00;height: 124px;margin-right: 15px; justify-content: center;align-items: center;flex-direction: column-reverse;flex-wrap: nowrap;align-content: stretch;">
                    Yönet
                    <svg width="35" height="35 " viewBox="0 0 118 118">
                        <defs>
                            <style type="text/css">
                                .fil0 {
                                    fill: url(#id0);
                                    fill-rule: nonzero
                                }
                            </style>
                            <linearGradient id="id0" gradientUnits="userSpaceOnUse" x1="59.54" y1="50.31" x2="63.63" y2="68.03">
                                <stop offset="0" style="stop-opacity:1; stop-color:#C5E6F3"></stop>
                                <stop offset="1" style="stop-opacity:1; stop-color:#F7C1FD"></stop>
                            </linearGradient>
                        </defs>
                        <g id="Layer_x0020_1">
                            <metadata id="CorelCorpID_0Corel-Layer"></metadata>
                            <path id="path6051" class="fil0" d="M65.84 6.13l0 0c-1.09,0 -1.97,0.88 -1.97,1.97l0 9.74c-4.22,0.91 -8.21,2.57 -11.83,4.92l-6.9 -6.9c-0.77,-0.77 -2.01,-0.77 -2.78,0l-7.47 7.47c-0.76,0.77 -0.76,2.01 0,2.78l6.7 6.7c-0.43,0.78 -0.91,1.53 -1.39,2.28l-6.3 0c-1.08,0 -1.96,0.88 -1.96,1.97l0 8.08c-3.45,0.77 -6.71,2.12 -9.68,4.02l-5.73 -5.73c-0.77,-0.76 -2.01,-0.76 -2.78,0l-6.34 6.35c-0.77,0.77 -0.77,2.01 0,2.78l5.72 5.73c-1.89,2.98 -3.25,6.23 -4.01,9.68l-8.1 0c-1.09,0 -1.97,0.88 -1.97,1.97l0 8.96c0,1.09 0.88,1.97 1.97,1.97l8.08 0c0.77,3.45 2.13,6.71 4.03,9.69l-5.73 5.72c-0.76,0.77 -0.76,2.01 0,2.78l6.35 6.35c0.77,0.77 2.01,0.77 2.78,0l5.72 -5.72c2.98,1.89 6.24,3.23 9.68,4l0 8.1c0,1.09 0.88,1.97 1.97,1.97l8.97 0c1.09,0 1.97,-0.88 1.97,-1.97l0 -8.09c3.45,-0.77 6.7,-2.11 9.68,-4.01l5.72 5.72c0.77,0.77 2.02,0.77 2.79,0l6.34 -6.35c0.28,-0.28 0.48,-0.65 0.55,-1.04l6.47 0c1.09,0 1.97,-0.88 1.97,-1.97l0 -9.74c4.22,-0.91 8.2,-2.57 11.82,-4.92l6.9 6.9c0.77,0.77 2.02,0.77 2.78,0l7.48 -7.46c0.77,-0.77 0.77,-2.02 0,-2.79l-6.9 -6.89c2.35,-3.62 3.99,-7.61 4.89,-11.83l9.76 0c1.09,0 1.97,-0.88 1.97,-1.97l0 -10.55c0,-1.09 -0.88,-1.97 -1.97,-1.97l-9.73 0c-0.91,-4.22 -2.57,-8.21 -4.92,-11.84l6.89 -6.89c0.77,-0.76 0.77,-2.01 0.01,-2.78l-7.48 -7.47c-0.76,-0.76 -2.01,-0.76 -2.78,0l-6.9 6.9c-3.62,-2.34 -7.6,-4 -11.82,-4.9l0 -9.76c0,-1.08 -0.88,-1.96 -1.97,-1.96l-10.55 0zm1.97 3.95l6.62 0 0 9.05c0,0.97 0.7,1.79 1.65,1.95 4.86,0.77 9.47,2.68 13.46,5.57 0.78,0.56 1.86,0.47 2.54,-0.21l6.39 -6.39 4.7 4.68 -6.41 6.39c-0.69,0.69 -0.77,1.77 -0.2,2.56 2.89,3.98 4.81,8.59 5.59,13.46 0.16,0.95 0.98,1.65 1.95,1.65l9.02 0 0 6.62 -9.05 0c-0.96,0 -1.79,0.7 -1.94,1.65 -0.78,4.86 -2.68,9.47 -5.56,13.46 -0.57,0.78 -0.48,1.86 0.2,2.55l6.4 6.39 -4.7 4.68 -6.39 -6.4c-0.68,-0.68 -1.75,-0.77 -2.54,-0.2 -3.98,2.89 -8.6,4.8 -13.46,5.59 -0.95,0.15 -1.65,0.98 -1.65,1.94l0 9.03 -7.25 0 -3.53 -3.53c1.9,-2.98 3.25,-6.24 4.01,-9.68l8.1 0c1.09,0 1.97,-0.88 1.97,-1.97l0 -6.64c8.47,-2.78 14.31,-10.56 14.59,-19.54 0.08,-0.21 0.11,-0.42 0.11,-0.64 0,-11.75 -9.56,-21.32 -21.31,-21.32 -9.89,0 -18.31,6.85 -20.62,16.27 -1.82,-0.8 -3.7,-1.45 -5.65,-1.88l0 -8.1c0,-0.43 -0.14,-0.84 -0.4,-1.19 0.49,-0.81 0.95,-1.63 1.38,-2.47 0.38,-0.76 0.23,-1.68 -0.37,-2.28l-6.39 -6.39 4.69 -4.69 6.4 6.4c0.68,0.68 1.76,0.77 2.54,0.2 3.98,-2.89 8.6,-4.81 13.46,-5.59 0.95,-0.16 1.65,-0.98 1.65,-1.95l0 -9.03zm3.31 24.63c9.62,0 17.37,7.77 17.37,17.39 0,7.4 -4.68,13.85 -11.53,16.3 -0.34,-0.27 -0.77,-0.41 -1.2,-0.41l-8.09 0c-0.77,-3.45 -2.12,-6.71 -4.02,-9.68l5.72 -5.73c0.78,-0.77 0.78,-2.02 0,-2.79l-6.34 -6.34c-0.77,-0.77 -2.02,-0.77 -2.78,0l-5.74 5.73c-0.13,-0.09 -0.28,-0.16 -0.42,-0.25 1.51,-8.2 8.6,-14.21 17.03,-14.21l0 -0.01zm-35.25 4.33l5.04 0 0 7.39c0,0.96 0.7,1.79 1.65,1.94 2.89,0.47 5.66,1.42 8.23,2.78 0.17,0.13 0.36,0.22 0.56,0.29 0.87,0.49 1.71,1.03 2.52,1.61 0.78,0.56 1.86,0.47 2.54,-0.22l5.23 -5.22 3.56 3.57 -5.22 5.22c-0.69,0.68 -0.78,1.76 -0.21,2.55 2.43,3.35 4.04,7.22 4.7,11.31 0.16,0.95 0.98,1.65 1.94,1.65l7.38 0 0 5.03 -7.39 0c-0.97,0 -1.79,0.71 -1.94,1.66 -0.66,4.09 -2.26,7.96 -4.68,11.31 -0.57,0.78 -0.48,1.86 0.2,2.55l4.78 4.78c0.12,0.15 0.25,0.29 0.41,0.41l0.03 0.04 -3.56 3.56 -5.23 -5.23c-0.68,-0.68 -1.76,-0.77 -2.54,-0.2 -3.35,2.43 -7.22,4.04 -11.31,4.7 -0.95,0.15 -1.65,0.98 -1.65,1.95l0 7.37 -5.04 0 0 -7.4c0,-0.96 -0.7,-1.78 -1.65,-1.93 -4.09,-0.66 -7.96,-2.26 -11.31,-4.68 -0.78,-0.57 -1.86,-0.48 -2.54,0.2l-5.23 5.23 -3.56 -3.57 5.22 -5.22c0.69,-0.68 0.77,-1.76 0.21,-2.54 -2.43,-3.35 -4.04,-7.23 -4.7,-11.31 -0.15,-0.96 -0.98,-1.67 -1.95,-1.67l-7.37 0 0 -5.03 7.39 0c0.96,0 1.79,-0.7 1.94,-1.65 0.66,-4.09 2.26,-7.97 4.68,-11.32 0.57,-0.78 0.48,-1.86 -0.2,-2.54l-5.22 -5.23 3.56 -3.56 5.23 5.23c0.68,0.68 1.76,0.76 2.54,0.2 3.35,-2.43 7.22,-4.04 11.31,-4.7 0.95,-0.16 1.65,-0.98 1.65,-1.94l0 -7.37zm2.52 16.99c-10.14,0 -18.41,8.27 -18.41,18.41 0,10.14 8.27,18.41 18.41,18.41 10.14,0 18.41,-8.27 18.41,-18.41 0,-10.14 -8.27,-18.41 -18.41,-18.41zm0 3.94c8.02,0 14.47,6.45 14.47,14.47 0,8.02 -6.45,14.47 -14.47,14.47 -8.02,0 -14.47,-6.45 -14.47,-14.47 0,-8.02 6.45,-14.47 14.47,-14.47z">
                            </path>
                        </g>
                    </svg>
                </a>
            </div>
            <div class="card">
                <div class="card-body m-3 p-3">
                    <h5>&nbsp</h5>
                    <div class="d-flex justify-content-between mb-4">
                        <h5>İşlem Takibi</h5>
                        <button class="btn btn-sm btn-primary bi-arrow-repeat yenile">&nbsp Yenile</button>
                        <button class="btn btn-sm btn-outline-danger bi-trash temizle">&nbsp Temizle</button>
                    </div>
                    <table class="table table-sm table-bordered small">
                        <thead>
                            <tr class="table-light">
                                <th>#</th>
                                <th>Kullanıcı</th>
                                <th>İşlem</th>
                                <th>Zaman</th>
                            </tr>
                        </thead>
                        <tbody class="loglar"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    $.Listele = function() {
        $.ajax({
            type: "POST",
            url: "postlog.php",
            data: {
                'Loglar': true,
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            },
            success: function(data) {
                $(".loglar").html(data);
            }
        })
    }

    $(function() {
        $.Listele();
    });

    $(".temizle").click(function() {
        $.ajax({
            type: "POST",
            url: "postlog.php",
            data: {
                'sil': true,
            },
            error: function(xhr) {
                alert('Hata: ' + xhr.responseText);
            },
            success: function() {
                $.Listele();
            }
        })
    });

    $(".yenile").click(function() {
        $.Listele();
    });
</script>
<?php
ob_end_flush();
require __DIR__ . '/controller/Footer.php';
?>