<?php
$page = "Set Kontrol";
require __DIR__ . '/../../controller/Header.php';
require __DIR__ . '/../../controller/Db.php';
$_SESSION["SetAdi"] = $_GET['SetAdi'];
$SetID = $_GET['Set_ID'];
/*Toplam Set içerik Adeti*/ $Toplam = $baglanti->query('SELECT SUM(Adet) AS Toplam FROM view_set_urun_sec WHERE Set_ID =' . $SetID)->fetch()["Toplam"];

if ($baglanti->query("SELECT  Set_ID FROM set_urunler_asama WHERE Set_ID = " . $SetID)->rowCount()<=0){
    $baglanti->query("INSERT INTO set_urunler_asama ( Set_ID, Urun_ID ) SELECT Set_ID,Urun_ID FROM view_uretim_setler WHERE Set_ID =  " . $SetID);
}

//Levha
$Hesap=0;
$a=0;
$b=0;
//Pres
$Prs=0;
$e=0;
//Yıkama
$Yika=0;
$f=0;
//Kumlama
$Kumla=0;
$g=0;
//Telleme
$Telle=0;
$h=0;
//Boyama
$Boya=0;
$j=0;
//Paketleme
$Paket=0;
$k=0;
?>
<input id="SetID" type="hidden" value="<?=$SetID?>">
<main id="main" class="main">
    <section class="section">
        <div class="card">
            <div class="card-header">
                <a href="../Setler.php" class="bi-arrow-left btn col-md-2 btn-secondary"> &nbsp&nbsp Geri Dön</a>
            </div>
            <div class="card-body">
                <h5 class='card-title text-center fs-5'><?=$_SESSION["SetAdi"]?></h5>
                <div class="card-text mb-3 fw-bold">Toplam Ürün= <?=$Toplam?> Adet</div>
                <?php
                @$mm = $baglanti->query("SELECT Kalinlik FROM set_icerik INNER JOIN set_urun_icerik ON set_icerik.Set_Urun_icerik_ID = set_urun_icerik.Set_Urun_icerik_ID WHERE set_urun_icerik.Set_ID =" .$SetID)->fetch()["Kalinlik"];

                $sor = $baglanti->query("SELECT Urun_ID,Adet FROM view_set_urun_sec WHERE Set_ID=".$SetID)->fetchAll();
                foreach ($sor as $s) {
                    $UrunID=$s["Urun_ID"];
                    $Adet=$s["Adet"];
                    //LEVHA TEDARİK
                    $cap = $baglanti->query("SELECT Cap FROM urun_levha_bilgi INNER JOIN levha ON urun_levha_bilgi.Levha_ID = levha.Levha_ID WHERE Urun_ID =" .$UrunID." AND  Kalinlik =".$mm)->fetch()["Cap"];
                    
                    $a += ceil((($cap*$cap*$mm*(0.22))/1000)*$Adet);// Toplam tedarik edilecek levha

                    $sorstok = $baglanti->query("SELECT Stok_Adet, Stok_Agirlik FROM levha_siparis INNER JOIN levha_gelen ON levha_siparis.Levha_Stok_ID = levha_gelen.Levha_Stok_ID INNER JOIN levha ON levha_siparis.Levha_ID = levha.Levha_ID WHERE Cap =".$cap);
                    if($sorstok->rowCount()){
                        foreach ($sorstok as $stk) {
                            $b += $stk["Stok_Agirlik"];// Stokta olan levha
                        }
                    }//else echo "<br>Çap= $cap &nbsp Kalinlik= $mm > Stokta yok > <a href='../../SatinAlma/Siparis/LevhaSiparis.php?Kalinlik=$mm&Cap=$cap'>Sipariş</a>";

                    //PRES
                    $e += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM loglar WHERE Yapilan_is='Preslendi' AND Set_ID=".$SetID." AND Urun_ID=".$UrunID)->fetch()["Toplam"];
                    //Yıkama
                    $f += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM loglar WHERE Yapilan_is='Yıkandı' AND Set_ID=".$SetID." AND Urun_ID=".$UrunID)->fetch()["Toplam"];
                    //Kumlama
                    $g += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM loglar WHERE Yapilan_is='Kumlandı' AND Set_ID=".$SetID." AND Urun_ID=".$UrunID)->fetch()["Toplam"];
                    //Telleme
                    $h += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM loglar WHERE Yapilan_is='Tellendi' AND Set_ID=".$SetID." AND Urun_ID=".$UrunID)->fetch()["Toplam"];
                    //Boyama
                    $j += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM loglar WHERE Yapilan_is='Boyandı' AND Set_ID=".$SetID." AND Urun_ID=".$UrunID)->fetch()["Toplam"];
                    //Paketleme
                    $k += $baglanti->query("SELECT SUM(Adet) AS Toplam FROM loglar WHERE Yapilan_is='Paketlendi' AND Set_ID=".$SetID." AND Urun_ID=".$UrunID)->fetch()["Toplam"];
                }

                //Yüzde Hesabı
                if($a<>null){//Levha
                    $Hesap=floor($b / ($a / 100));
                    $Hesap=$Hesap>100?100:$Hesap;
                }
                if($e<>null){//Pres
                    $Prs=floor($e / ($Toplam / 100));
                    $Prs=$Prs>100?100:$Prs;
                }
                if($f<>null){//Yıkama
                    $Yika=floor($f / ($Toplam / 100));
                    $Yika=$Yika>100?100:$Yika;
                }
                if($g<>null){//Kumlama
                    $Kumla=floor($g / ($Toplam / 100));
                    $Kumla=$Kumla>100?100:$Kumla;
                }
                if($h<>null){//Teleme
                    $Telle=floor($h / ($Toplam / 100));
                    $Telle=$Telle>100?100:$Telle;
                }
                if($j<>null){//Boyama
                    $Boya=floor($j / ($Toplam / 100));
                    $Boya=$Boya>100?100:$Boya;
                }
                if($k<>null){//Paketleme
                    $Paket=floor($k / ($Toplam / 100));
                    $Paket=$Paket>100?100:$Paket;
                }
                $_SESSION["SetYuzde"]=floor(($Hesap+$Prs+$Yika+$Kumla+$Telle+$Boya+$Paket)/7);
                /*Yüzde Son*/
                ?>
                
                <div class="row mb-3 g-3">

                    <div class="col-md-6">

                    <div style="margin-top: -1px;padding-top: 22px;">
                        <label style="font-weight: 600;">Levha Tedarik</label>
                        <div class="progress mt-1" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" style="font-size: 15px;width: <?=$Hesap?>%;background: linear-gradient(to left, #009341 -112%, #3921ff 110%);"><?=$Hesap?>%
                            </div>
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: 600;">Pres Aşaması</label>
                        <div class="progress mt-1" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" style="width: <?=$Prs?>%;background: linear-gradient(to left, #004576 0%, #28047b 100%);font-size: 15px;"><?=$Prs?>%
                            </div>
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: 600;">Yıkama Aşaması</label>
                        <div class="progress mt-1" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" style="width: <?=$Yika?>%;background: linear-gradient(to left, #24e70c 0%, #2e9d00 100%);color: #ffffff;font-size: 15px;"><?=$Yika?>%
                            </div>
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: 600;">Kumlama Aşaması</label>
                        <div class="progress mt-1" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" style="width: <?=$Kumla?>%;background: linear-gradient(to left, #b5861d 0%, #ff3a30 100%);font-size: 15px;"><?=$Kumla?>%
                            </div>
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: 600;">Telleme Aşaması</label>
                        <div class="progress mt-1" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" style="width: <?=$Telle?>%;background: linear-gradient(to left, #0059ff 0%, #af7297 100%);font-size: 15px;"><?=$Telle?>%
                            </div>
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: 600;">Boyama Aşaması</label>
                        <div class="progress mt-1" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" style="width: <?=$Boya?>%;background: linear-gradient(to left, #9a11c7 0%, #7b27b0 100%);font-size: 15px;"><?=$Boya?>%
                            </div>
                        </div>
                    </div>

                    <div>
                        <label style="font-weight: 600;">Paketleme Aşaması</label>
                        <div class="progress mt-1" style="height: 25px;">
                            <div class="progress-bar" role="progressbar" style="width: <?=$Paket?>%;background: linear-gradient(to left, #24e70c 0%, #2e9d00 100%);color: #ffffff;font-size: 15px;"><?=$Paket?>%
                            </div>
                        </div>
                    </div>
                </div>

                    <div class="col-md-6">
                        <h5 class="mb-5"></h5>
                        <table class="table datatablem">
                            <thead>
                            <tr class="table-light">
                                <th>Ürünler</th>
                                <th>Kulp</th>
                                <th>Kapak</th>
                                <th>İç Boya</th>
                                <th>Dış Boya</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><?php
                                    $sorgu = $baglanti->query('SELECT UrunAdi FROM view_uretim_setler WHERE Set_ID = ' . $SetID);
                                    foreach ($sorgu as $sonuc) {echo $sonuc['UrunAdi'] . "<br>";}
                                    ?>
                                </td>
                                <td><?php
                                    $sorgu = $baglanti->query('SELECT DISTINCT KulpAdi,KulpCesidi FROM set_urun_icerik INNER JOIN kulp ON set_urun_icerik.Kulp = kulp.Kulp_ID WHERE Set_ID =' . $SetID);
                                    foreach ($sorgu as $sonuc) {echo $sonuc['KulpAdi']."<br>";}
                                    ?></td>

                                <td><?php
                                    $sorgu = $baglanti->query('SELECT DISTINCT Tip, Model_Adi FROM set_urun_icerik INNER JOIN kapak ON set_urun_icerik.Kapak = kapak.Kapak_ID WHERE Set_ID =' . $SetID);
                                    foreach ($sorgu as $sonuc) {echo $sonuc['Model_Adi'] . "<br>";}
                                    ?>
                                </td>
                                <td><?php
                                    $sorgu = $baglanti->query('SELECT Renk FROM set_urun_icerik INNER JOIN boya ON set_urun_icerik.icBoya = boya.Boya_ID WHERE Set_ID =' . $SetID);
                                    foreach ($sorgu as $sonuc) {echo $sonuc['Renk'] . "<br>";}
                                    ?>
                                </td>
                                <td><?php
                                    $sorgu = $baglanti->query('SELECT Renk FROM set_urun_icerik INNER JOIN boya ON set_urun_icerik.DisBoya = boya.Boya_ID WHERE Set_ID =' . $SetID);
                                    foreach ($sorgu as $sonuc) {echo  $sonuc['Renk'] . "<br>";}
                                    ?>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <!-- Scroll Bar -->
                    <style>
                        .chat {
                            list-style: none;
                            margin: 0;
                            padding: 0;
                        }
                        .panel-body {
                            overflow-y: scroll;
                            height: 350px;
                        }
                        ::-webkit-scrollbar-track {
                            background-color: #F5F5F5;
                        }
                        ::-webkit-scrollbar {
                            width: 12px;
                            background-color: #F5F5F5;
                        }
                        ::-webkit-scrollbar-thumb {
                            background-color: #555;
                        }
                    </style>
                    <div class="panel panel-primary col-md-6 mb-3">
                        <div class="panel-heading mb-3">
                            <span class="fw-bold"> &nbsp Detaylar</span>
                        </div>
                        <div class="panel-body">
                            <ul class="chat">
                                <li class="isDurum"></li>
                            </ul>
                        </div>
                    </div>
                    <!-- Scroll Bar SON -->
                    <div class="col-md-6">
                        <div class="input-group-sm">
                            <button class="mb-3 me-2 btn btn-primary t" id="Pres">Pres</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="Yikama">Yıkama</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="Kumlama">Kumlama</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="Telleme">Telleme</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="icBoyama">İç Boya</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="DisBoyama">Dış Boya</button>
                            <button class="mb-3 me-2 btn btn-outline-dark t" id="Paketleme">Paketleme</button>
                        </div>
                        <div class="col-md-12 d-flex justify-content-end mb-3">
                            <label class="col-sm-2 col-form-label">Tarih</label>
                            <div class="col-md-4">
                                <input type="date" class="form-control Tarih" value="<?php date_default_timezone_set('Europe/Istanbul'); $tarih = new DateTime("now"); $tarih = date("Y-m-d"); echo $tarih;?>">
                            </div>
                        </div>
                        <ul class="list-group UrunYaz">
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<script>
    $('.datatablem').DataTable({
        responsive: true,
        columnDefs: [{targets: '_all', orderable: false}],
        paging:false,
        bFilter:false,
        bInfo : false,
    });
</script>
<?php
require __DIR__ . '/AjaxForm/Ajax.php';
?>
<script src="../../assets/vendor/bootstrap/js/bootstrap.min.js"></script>
