<?php
// get_matieres_financier.php
header('Content-Type: application/json');
require 'db.php';

$res = $mysqli->query("SELECT id, nom FROM matieres ORDER BY nom");
$out = [];
while ($r = $res->fetch_assoc()) {
    $out[] = $r;
}
echo json_encode($out);
