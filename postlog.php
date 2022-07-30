<?php
require __DIR__ . '/controller/Db.php';
if (isset($_POST["Loglar"])) {
    $sor = $baglanti->query('SELECT * FROM logtut INNER JOIN kullanici ON logtut.Kul_ID = kullanici.Kullanici_ID  ORDER BY id');
    foreach ($sor as $l) { ?>
        <tr>
            <td><?= $l["id"] ?></td>
            <td><?= $l["AdSoyad"] ?></td>
            <td><?= $l["Neis"] ?></td>
            <td><?= $l["Tarih"] ?></td>
        </tr>
<?php  }
}elseif (isset($_POST["sil"])) {
    $baglanti->query("DELETE FROM logtut");
    $baglanti->query("ALTER TABLE logtut AUTO_INCREMENT = 1");
}
