<?php
$db = new SQLite3('db.sqlite');

$res = $db->query('select * from items');

while ($row = $res->fetchArray()) {
    echo "{$row['id']}  \n";
}