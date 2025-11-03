<!-- Sidebar -->
<div id="sidebar" class="position-fixed shadow-sm">
    <div class="p-4">
      
			<img src="<?php echo base_url('/assets/logo.png'); ?>" alt="logo" height="100px" width="100px" class="img-fluid">
	  <hr>
      <ul class="nav flex-column">
        <li class="nav-item mb-2">
          <a class="nav-link active rounded-2" href="<?php echo base_url('admin/index');?>"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="<?php echo base_url('gestion_user/index');?>"><i class="bi bi-people me-2"></i> Utilisateurs</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="<?php echo base_url('Categorie/index');?>"><i class="bi bi-cart4 me-2"></i> Categories</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="<?php echo base_url('Produit/index');?>"><i class="bi bi-box-seam me-2"></i> Produits</a>
        </li>
				<li class="nav-item mb-2">
          <a class="nav-link" href="<?php echo base_url('Client/index');?>"><i class="bi bi-people   me-2"></i> clients</a>
        </li>
        <li class="nav-item mb-2">
          <a class="nav-link" href="<?php echo base_url('Factures/add');?>"><i class="bi bi-pen me-2"></i> creer Factures</a>
        </li>
		<li class="nav-item mb-2">
          <a class="nav-link" href="<?php echo base_url('Factures/index');?>"><i class="bi bi-receipt me-2"></i> Factures</a>
        </li>
        <li class="nav-item  mt-3">
          <a class="nav-link active text-white rounded-2" href="<?php echo base_url('auth/logout');?>"><i class="bi bi-box-arrow-right me-2"></i> Déconnexion</a>
        </li>
      </ul>
    </div>
  </div>

