
    <!-- Cards -->
    <div class="row g-3">
      <div class="col-md-4">
        <div class="card p-3">
          <div class="d-flex align-items-center">
            <i class="bi bi-cart4 fs-1 text-primary me-3"></i>
            <div>
              <h5>Catégories</h5>
              <h3><?php echo $total_categories; ?></h3>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <div class="d-flex align-items-center">
            <i class="bi bi-people fs-1 text-success me-3"></i>
            <div>
              <h5>Utilisateurs</h5>
              <h3><?php echo $total_users; ?></h3>
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card p-3">
          <div class="d-flex align-items-center">
            <i class="bi bi-people fs-1 text-warning me-3"></i>
            <div>
              <h5>Clients</h5>
              <h3><?php echo $total_clients; ?></h3>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Chart -->
    <div class="card mt-4 p-4">
      <h5>Représentation Graphiques </h5>
      <canvas id="myChart" height="500px"  class="card-body"></canvas>
    </div>

    <!-- Table -->
    <div class="card mt-4 p-3">
      <h5>Liste des Utilisateurs</h5>
      <div class="table-responsive">
        <input class="form-control mb-2" id="searchInput" type="text" placeholder="Recherche...">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
			        <td><?php echo "<input type=\"checkbox\"/>"; ?></td>
              <th>ID</th>
							<th>Nom</th>
              <th>Email</th>
              <th>Rôle</th>
            </tr>
          </thead>
          <tbody id="userTable">
		  <?php foreach ($liste_utilisateurs as $user) :  ?>
            <tr>
			  <td><?php echo "<input type=\"checkbox\"/>"; ?></td>
              <td><?php echo $user->id; ?></td>
							<td><?php echo $user->username; ?></td>
              <td><?php echo $user->email; ?></td>
              <td><?php echo $user->role; ?></td>
              
            </tr>
            
			<?php endforeach; ?>
            <!-- Ajouter d'autres lignes ici -->
          </tbody>
        </table>
      </div>
    </div>

  </div>
 
  <script src="<?php echo base_url('bootstrap/chart/Chart.min.js');?>"></script>		

<!-- Chart.js Script -->
<script>
  const ctx = document.getElementById('myChart').getContext('2d');
  const myChart = new Chart(ctx, {
	type: 'line',
	data: {
		labels:["Utilisateurs","Clients","Categories","Produits"],
	  datasets: [{
		label: 'Nombres total',
		data: [<?php echo $users;?>, <?php echo $clients;?>, <?php echo $categories;?>, <?php echo $produits;?>],
		borderColor: 'rgba(54, 162, 235, 1)',
		backgroundColor: 'rgba(54, 162, 235, 0.2)',
		tension: 0.3,
		fill: true
	  }]
	},
	options: {
	  responsive: true,
	  plugins: {
		legend: {
		  display: false
		}
	  },
	  scales: {
		y: {
		  beginAtZero: true
		}
	  }
	}
  });


</script>

