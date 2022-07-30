<?php
//require __DIR__ . '/controller/Db.php';
function logtut($k, $n)
{
    global $baglanti;
    $giris = $baglanti->prepare("INSERT INTO logtut SET Kul_ID= ?, Neis= ?");
    $giris->execute(array($k, $n));
}
