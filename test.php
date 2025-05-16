<?php
// index.php
require 'db.php';

$res = $mysqli->query("SELECT id, nom FROM ecoles ORDER BY nom");
if (!$res) {
    exit('Erreur lors de la récupération des écoles');
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Exporter le stock par école (AJAX)</title>
</head>
<body>
  <h1>Exporter le stock</h1>
  <form id="downloadForm">
    <label for="ecole_id">Choisissez une école :</label>
    <select name="ecole_id" id="ecole_id">
      <?php while ($row = $res->fetch_assoc()): ?>
        <option value="<?= htmlspecialchars($row['id']) ?>">
          <?= htmlspecialchars($row['nom']) ?>
        </option>
      <?php endwhile; ?>
    </select>
    <button type="submit" id="downloadOne">Télécharger CSV école</button>
    <button type="button" id="downloadAll">Télécharger CSV toutes écoles</button>
  </form>

  <script>
  function downloadCSV(url) {
    fetch(url)
      .then(resp => {
        if (!resp.ok) throw new Error('Erreur réseau');
        const dispo = resp.headers.get('Content-Disposition') || '';
        let filename = 'stock.csv';
        const m = dispo.match(/filename="([^"]+)"/);
        if (m) filename = m[1];
        return resp.blob().then(blob => ({blob, filename}));
      })
      .then(({blob, filename}) => {
        const url = URL.createObjectURL(blob);
        const a = document.createElement('a');
        a.href = url; a.download = filename;
        document.body.appendChild(a);
        a.click();
        a.remove();
        URL.revokeObjectURL(url);
      })
      .catch(e => alert(e.message));
  }

  document.getElementById('downloadOne').addEventListener('click', e => {
    e.preventDefault();
    const id = document.getElementById('ecole_id').value;
    downloadCSV('download.php?ecole_id=' + encodeURIComponent(id));
  });

  document.getElementById('downloadAll').addEventListener('click', () => {
    downloadCSV('download.php?ecole_id=all');
  });
  </script>
</body>
</html>
