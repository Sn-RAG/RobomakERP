<?php
require __DIR__ . '/controller/Db.php';
if (isset($_POST["Loglar"])) {
    $i = 1;
    $sor = $baglanti->query('SELECT * FROM logtut INNER JOIN kullanici ON logtut.Kul_ID = kullanici.Kullanici_ID  ORDER BY id DESC');
    foreach ($sor as $l) { ?>
        <tr>
            <td><?= $i++ ?></td>
            <td><?= $l["AdSoyad"] ?></td>
            <td><?= $l["Neis"] ?></td>
            <td><?= $l["Tarih"] ?></td>
        </tr>
<?php  }
} elseif (isset($_POST["sil"])) {
    $baglanti->query("DELETE FROM logtut");
    $baglanti->query("ALTER TABLE logtut AUTO_INCREMENT = 1");
}
