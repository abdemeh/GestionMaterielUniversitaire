<?php
// get_all_details.php
header('Content-Type: application/json');
require 'db.php';

$sql = "
  SELECT ec.nom      AS ecole,
         m.nom       AS matiere,
         eq.titre    AS equipement,
         se.quantite,
         se.date_maj
    FROM stock_ecole se
    JOIN ecoles ec             ON ec.id    = se.ecole_id
    JOIN equipements eq        ON eq.id    = se.equipement_id
    JOIN matieres_equipements me
      ON me.equipement_id = eq.id
    JOIN matieres m            ON m.id     = me.matiere_id
   ORDER BY ec.nom, m.nom, eq.titre
";
$res = $mysqli->query($sql);
$out = [];
while ($r = $res->fetch_assoc()) {
    $out[] = $r;
}
echo json_encode($out);
