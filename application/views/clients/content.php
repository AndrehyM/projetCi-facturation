<div class="container-fluid mt-4">

  
  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
  <?php endif; ?>

 
  <div class="card p-4 mb-4 shadow-sm">
    <h5><i class="bi bi-person-plus"></i> Ajouter un client</h5>
    <form action="<?= base_url('client/add'); ?>" method="post">
      <div class="row g-3">
        <div class="col-md-4">
          <input type="text" name="name" class="form-control" placeholder="Nom du client" required>
        </div>
        <div class="col-md-4">
          <input type="email" name="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="col-md-4">
          <input type="text" name="phone" class="form-control" placeholder="Téléphone" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-plus-circle"></i> Ajouter</button>
    </form>
  </div>

 
  <form method="get" class="mb-3">
    <div class="input-group">
      <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" class="form-control" placeholder="Rechercher un client...">
      <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
      <a href="<?= base_url('client'); ?>" class="btn btn-outline-danger"><i class="bi bi-x-circle"></i></a>
    </div>
  </form>

  <div class="card p-3 shadow-sm">
    <h5><i class="bi bi-list"></i> Liste des clients</h5>
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Nom</th>
            <th>Email</th>
            <th>Téléphone</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($clients)): ?>
            <?php foreach ($clients as $c): ?>
              <tr>
                <td><?= $c->id; ?></td>
                <td><?= htmlspecialchars($c->name); ?></td>
                <td><?= htmlspecialchars($c->email); ?></td>
                <td><?= htmlspecialchars($c->phone); ?></td>
                <td>
                  <a href="<?= base_url('client/delete/'.$c->id); ?>" onclick="return confirm('Supprimer ce client ?');" class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="5" class="text-center text-muted">Aucun client trouvé.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3"><?= $pagination; ?></div>
  </div>

</div>
