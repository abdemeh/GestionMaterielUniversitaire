<?php
// dashboard.php
session_start();
if (!isset($_SESSION['user_id'], $_SESSION['role']) || $_SESSION['role'] !== 'financier') {
    header('Location: login.html');
    exit;
}
require 'db.php';
$res = $mysqli->query("SELECT id, nom FROM ecoles ORDER BY nom");
if (!$res) {
    exit('Erreur lors de la récupération des écoles');
}
// Récupérer le nom du financier
$uid = (int)$_SESSION['user_id'];
$result = $mysqli->query("SELECT nom FROM utilisateurs WHERE id = $uid LIMIT 1");
if ($result && $row = $result->fetch_assoc()) {
    $user_name = htmlspecialchars($row['nom']);
} else {
    $user_name = 'Financier';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="style.css">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.png">
    <title>Tableau de bord - Financier</title>
</head>
<body>
   <!-- Login 9 - Bootstrap Brain Component -->
    <section class="bg-primary py-3 py-md-5 py-xl-8 d-flex align-items-center justify-content-center min-vh-100"> 
        <div class="container"> 
            <nav class="navbar navbar-expand-lg">
                <a class="navbar-brand" href="#">
                    <img class="img-fluid rounded" loading="lazy" src="assets/img/logo-light.png" width="500" alt="Logo">
                </a>
                
                <button class="btn btn-primary btn-lg">Accueil</button>
                <button id="logout" class="btn btn-primary btn-lg">Se déconnecter</button>
            </nav>
            <div class="row gy-4 align-items-center">
                <div class="col-12">
                    <div class="d-flex justify-content-center text-bg-primary">
                        <div class="col-12 col-xl-9">
                            <hr class="border-primary-subtle mb-4">
                        </div>
                    </div>
                </div>
                <div class="col-12 text-bg-primary">
                    <h2 class="h1 mb-4">Bienvenue <?php echo $user_name; ?>.</h2>
                    <p class="lead mb-5">Bienvenue dans votre tableau de bord.</p>
                </div>
            </div>
            <div class="card border-0 rounded-4">
                <div class="card-body p-3 p-md-4 p-xl-5 container-fluid">
                    <div id="summaryCards" class="row"></div>
                    <div class="row">
                        <div class="col-9">
                            <div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                    <label for="matiereSelect" class="form-label">Choisir Matière</label>
                                    <select id="matiereSelect" class="form-select">
                                        <option value="">Chargement…</option>
                                    </select>
                                    </div>
                                </div>
                                <div class="row mb-5">
                                    <div class="col">
                                        <canvas id="equipement_chart_par_matiere" height="100"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            
                            <div class="row mt-2">
                                    <div class="col">
                                    <label for="ecoleSelect" class="form-label">Choisir école</label>
                                    <select class="form-select" name="ecole_id" id="ecole_id">
                                        <?php while ($row = $res->fetch_assoc()): ?>
                                            <option value="<?= htmlspecialchars($row['id']) ?>">
                                            <?= htmlspecialchars($row['nom']) ?>
                                            </option>
                                        <?php endwhile; ?>
                                    </select>
                                    </div>
                                    <button id="downloadOne" class="btn btn-danger btn-lg mt-2">Télecharger rapport école</button>
                                    <button id="downloadAll" class="btn btn-success btn-lg mt-1">Télecharger tout le stock</button>
                                </div>
                        </div>
                    </div>
                    <div class="row">
                        <div>
                            <div class="col">
                                <table id="tableau_details" class="display table table-striped" style="width:100%">
                                    <thead>
                                    <tr>
                                        <th style="width:15%">École</th>
                                        <th style="width:10%">Matière</th>
                                        <th style="width:15%">Équipement</th>
                                        <th style="width:45%">Description</th>
                                        <th style="width:5%">Quantité</th>
                                        <th style="width:10%">Date MAJ</th>
                                    </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script src="https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js"></script>
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
$(function(){
    $(document).ready(function () {
    let detailsTable;

    // Vérifie si DataTable est déjà initialisé
    if (!$.fn.DataTable.isDataTable('#tableau_details')) {
        detailsTable = $('#tableau_details').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.5/i18n/fr-FR.json'
            }
        });
    } else {
        detailsTable = $('#tableau_details').DataTable();
    }

        // Chargement des données dès le lancement
        $.getJSON('get_details.php', function(rows) {
            detailsTable.clear().rows.add(rows).draw();
        });
    });

  // Logout
  $('#logout').click(()=> $.post('logout.php', ()=> location='login.html'));

  // 1. Charger et afficher les summary cards
  $.getJSON('get_summary.php', function(data){
    let html = '';
    data.forEach((card,i)=>{
      html += `
        <div class="col-md-4 col-xl-3">
            <div class="card bg-c-green order-card">
                <div class="card-block">
                        <h6 class="m-b-20">${card.label}</h6>
                        <h2 class="text-right"><i class="fa ${card.icon} f-left"></i></h2>
                        <h1 class="f-right">${card.count}</h1>
                </div>
            </div>
        </div>`;
    });
    $('#summaryCards').html(html);
  });

  // 2. Initialiser le chart
  const ctx = document.getElementById('equipement_chart_par_matiere');
  const chart = new Chart(ctx, {
    type: 'bar',
    data: { labels: [], datasets: [{ label:'Stock total', data:[], backgroundColor:'#0d6efd' }] },
    options: { responsive:true, scales:{ y:{ beginAtZero:true } } }
  });

  // 3. Remplir le select Matières
  $.getJSON('get_matieres_financier.php', function(mats){
    let sel = $('#matiereSelect').empty()
      .append('<option value="">Sélectionnez une matière</option>');
    mats.forEach(m=>{
      sel.append(`<option value="${m.id}">${m.nom}</option>`);
    });
  });

  // 4. DataTable pour le détail
  const detailsTable = $('#tableau_details').DataTable({
    columns: [
      { data: 'ecole' },
      { data: 'matiere' },
      { data: 'equipement' },
      { data: 'description' },
      { data: 'quantite' },
      { data: 'date_maj' }
    ]
  });

  // 5. Quand on change de matière → mettre à jour chart & table
  $('#matiereSelect').change(function(){
    const mid = this.value;
    if(!mid) return;

    // Chart
    $.getJSON('get_stats.php',{ matiere_id: mid }, function(stats){
      chart.data.labels = stats.map(s=>s.equipement);
      chart.data.datasets[0].data = stats.map(s=>s.total);
      chart.update();
    });

    // Détails Table
    //$.getJSON('get_details.php',{ matiere_id: mid }, function(rows){
      //detailsTable.clear().rows.add(rows).draw();
    //});
  });
});
</script>
</body>
</html>