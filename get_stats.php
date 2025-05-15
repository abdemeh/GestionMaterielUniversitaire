<?php
// get_stats.php
header('Content-Type: application/json');
require 'db.php';

$mid = (int)($_GET['matiere_id'] ?? 0);
$sql = "
  SELECT e.titre AS equipement,
         COALESCE(SUM(se.quantite),0) AS total
    FROM matieres_equipements me
    JOIN equipements e ON e.id = me.equipement_id
    LEFT JOIN stock_ecole se ON se.equipement_id = e.id
   WHERE me.matiere_id = $mid
   GROUP BY e.titre
   ORDER BY e.titre
";
$res = $mysqli->query($sql);
$out = [];
while ($r = $res->fetch_assoc()) {
    $out[] = $r;
}
echo json_encode($out);
