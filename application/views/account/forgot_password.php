<div class="container">
  <div class="row justify-content-center mt-5">
    <div class="col-md-6">
      <p class="text-center">Récupération via email de votre mot de passe.</p>

      <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
      <?php elseif($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
      <?php endif; ?>

      <form method="post">
        <input type="email" name="email" class="form-control mb-3" placeholder="Entrez votre email">
        <button type="submit" class="btn btn-dark w-100">Réinitialiser</button>
      </form>
    </div>
  </div>
</div>
