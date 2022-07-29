<?php
require __DIR__ . '/controller/Db.php';
if (isset($_POST["Loglar"])) {
    foreach ($baglanti->query("SELECT * FROM `log` ORDER BY id") as $l) {
        echo $l["Kul_ID"] . " &nbsp " . $l["Neis"] . " &nbsp " . $l["Tarih"];
    }
}
