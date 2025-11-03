<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>


<div id="content">
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light mb-4 rounded-2">
      <div class="container-fluid">
			<p class="p-2 mt-2">Bienvenue, <?php echo $username; ?> </p>
        <div class="d-flex ms-auto align-items-center">
				
          <div class="me-4 position-relative">
            <i class="bi bi-person fs-5 me-2"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger " style="font-size:8px;" ><?php echo  $username; ?></span>
          </div>
		  <div>
            
          </div>
          <img src="<?php echo base_url('/assets/tet.jpg'); ?>" alt="Avatar" class="avatar me-3 img-fluid">
          <div>
            <span><?php echo  $role; ?></span>
          </div>
        </div>
      </div>
    </nav>
