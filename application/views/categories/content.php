<div class="container-fluid mt-4">

  <!-- ✅ Messages Flash -->
  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
  <?php elseif ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
  <?php endif; ?>

  <!-- ✅ Formulaire d’ajout -->
  <div class="card p-4 mb-4 shadow-sm">
    <h5 class="mb-3"><i class="bi bi-plus-circle"></i> Ajouter une catégorie</h5>
    <form action="<?= base_url('categorie/add'); ?>" method="post">
      <div class="row g-3">
        <div class="col-md-12">
          <input type="text" name="name" class="form-control" placeholder="Nom de la catégorie" required>
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-save"></i> Enregistrer</button>
    </form>
  </div>

  <!-- ✅ Recherche -->
  <form method="get" class="mb-3">
    <div class="input-group">
      <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" class="form-control" placeholder="Rechercher une catégorie...">
      <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
      <a href="<?= base_url('categorie'); ?>" class="btn btn-outline-danger"><i class="bi bi-x-circle"></i></a>
    </div>
  </form>

  <!-- ✅ Liste + Pagination -->
  <div class="card p-3 shadow-sm">
    <h5 class="mb-3"><i class="bi bi-list"></i> Liste des catégories</h5>
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Nom</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($liste_categories)): ?>
            <?php foreach ($liste_categories as $cat): ?>
              <tr>
                <td><?= $cat->id; ?></td>
                <td><?= htmlspecialchars($cat->name); ?></td>
                <td class="text-center">
                  <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $cat->id; ?>">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <a href="<?= base_url('categorie/delete/'.$cat->id); ?>" onclick="return confirm('Supprimer cette catégorie ?');" class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>

              <!-- 🔹 Modal Edition -->
              <div class="modal fade" id="editModal<?= $cat->id; ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="<?= base_url('categorie/edit/'.$cat->id); ?>" method="post">
                      <div class="modal-header">
                        <h5 class="modal-title">Modifier la catégorie</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-3">
                          <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($cat->name); ?>" required>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fermer</button>
                        <button type="submit" class="btn btn-primary">Enregistrer</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="3" class="text-center text-muted">Aucune catégorie trouvée.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- ✅ Pagination -->
    <div class="mt-3">
      <?= $pagination; ?>
    </div>
  </div>
</div>
