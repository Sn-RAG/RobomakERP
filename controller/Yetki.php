<?php
// Yetki Sorgusu
$Yetki = $_SESSION["Yetki"];

if ($_SESSION["Kullanici"] == "ferhatd"||$_SESSION["Kullanici"] == "FerhatD"||$_SESSION["Kullanici"] == "FERHATD") {
    $Yetki = 8;
}
$Admin = 1;
$Pazarlamaci = 2;
$Satın_alma = 3;
$Depo_sorumlusu = 4;
$Boya_sorumlusu = 5;
$Pres_sorumlusu = 6;
$Kalite_kontrol = 7;
$FerhatD=8;
$SorFerhat=$Yetki == $Satın_alma||$Yetki == $FerhatD||$Yetki == $Pazarlamaci || $Yetki == $Admin ? "" : "hidden";

$SORGUAdmin = $Yetki == $Admin ? "" : "hidden";
$SORPazarlamaci = $Yetki == $Pazarlamaci || $Yetki == $Admin ? "" : "hidden";
$SORSatın_alma = $Yetki == $Satın_alma || $Yetki == $Admin ? "" : "hidden";
$SORDepo_sorumlusu = $Yetki == $Satın_alma || $Yetki == $Depo_sorumlusu || $Yetki == $Admin ? "" : "hidden";
$SORBoya = $Yetki == $Satın_alma || $Yetki == $Depo_sorumlusu || $Yetki == $Admin || $Yetki == $Boya_sorumlusu ? "" : "hidden";
//$SORKalite_kontrol = $Yetki == $Kalite_kontrol || $Yetki == $Admin ? "" : "hidden";
//$SORPres = $Yetki == $Depo_sorumlusu || $Yetki == $Admin || $Yetki == $Pres_sorumlusu ? "" : "hidden";