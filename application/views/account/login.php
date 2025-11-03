<div class="container">
  <div class="login-form mt-4 ">
    <div class="row">
      <div class="col-md-6">
        <img src="<?php echo base_url('assets/ccc.jpg');?>" alt="logo" class="img-fluid">
      </div>
      <div class="col-md-6 shadow-sm py-4 rounded-2 ">
        <h2 class="text-end auth me-2">Authentification</h2>
				<br>
        <p class="text-muted text-center">Réservé seulement pour l'administrateur.</p>

        <?php if($this->session->flashdata('error')): ?>
          <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
        <?php endif; ?>

        <form action="" method="post">
          <div class="mb-3">
						<br><br>
            <label>Email</label>
            <input type="email" name="email" class="form-control">
          </div>
          <div class="mb-3">
					<br>
            <label>Password</label>
            <input type="password" name="password" class="form-control">
          </div>
					<br>
          <div class="d-flex justify-content-between mb-3">
            <div>
              <input type="checkbox"> Remember
            </div>
            <div>
              <a href="<?php echo base_url('auth/forgot_password'); ?>" class="text-decoration-none">Mot de passe oublié?</a>
            </div>
          </div>
          <button type="submit" class="btn btn-dark w-100 btn-lg">Login</button>
        </form>
				<br><br>
      </div>
    </div>
  </div>
</div>
