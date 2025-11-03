<div class="container-fluid mt-4">
  <?php if ($this->session->flashdata('success')): ?>
    <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
  <?php endif; ?>

  <!-- Formulaire d'ajout -->
  <div class="card p-4 mb-4 shadow-sm">
    <h5><i class="bi bi-box"></i> Ajouter un produit</h5>
    <form action="<?= base_url('produit/add'); ?>" method="post" enctype="multipart/form-data">
      <div class="row g-3">
        <div class="col-md-6">
          <input type="text" name="name" class="form-control" placeholder="Nom du produit" required>
        </div>
        <div class="col-md-6">
          <select name="category_id" class="form-select" required>
            <option value="">-- Choisir une catégorie --</option>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat->id; ?>"><?= $cat->name; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-4">
          <input type="number" name="price" class="form-control" placeholder="Prix" required>
        </div>
        <div class="col-md-4">
          <input type="number" name="qte_stock" class="form-control" placeholder="Quantité en stock" required>
        </div>
        <div class="col-md-4">
          <input type="number" name="seuil_alert" class="form-control" placeholder="Seuil d’alerte" required>
        </div>
        <div class="col-md-12">
          <input type="file" name="photo" class="form-control">
        </div>
      </div>
      <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-plus-circle"></i> Ajouter</button>
    </form>
  </div>

  <!-- Recherche -->
  <form method="get" class="mb-3">
    <div class="input-group">
      <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" class="form-control" placeholder="Rechercher un produit...">
      <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
      <a href="<?= base_url('produit'); ?>" class="btn btn-outline-danger"><i class="bi bi-x-circle"></i></a>
    </div>
  </form>

  <!-- Liste -->
  <div class="card p-3 shadow-sm">
    <h5><i class="bi bi-list"></i> Liste des produits</h5>
    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Image</th>
            <th>Nom</th>
            <th>Catégorie</th>
            <th>Prix</th>
            <th>Stock</th>
            <th>Alerte</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($liste_produits)): ?>
            <?php foreach ($liste_produits as $p): ?>
              <tr>
                <td><?= $p->id; ?></td>
                <td>
                  <?php if ($p->photo): ?>
                    <img src="<?= base_url($p->photo); ?>" width="50" height="50" class="rounded">
                  <?php else: ?>
                    <span class="text-muted">Aucune</span>
                  <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($p->name); ?></td>
                <td><?= htmlspecialchars($p->categorie_name); ?></td>
                <td><?= number_format($p->price, 2); ?> Ar</td>
                <td><?= $p->qte_stock; ?></td>
                <td><?= $p->seuil_alert; ?></td>
                <td>
                  <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?= $p->id; ?>">
                    <i class="bi bi-pencil"></i>
                  </button>
                  <a href="<?= base_url('produit/delete/'.$p->id); ?>" onclick="return confirm('Supprimer ce produit ?');" class="btn btn-sm btn-danger">
                    <i class="bi bi-trash"></i>
                  </a>
                </td>
              </tr>

              <!-- Modal Edition -->
              <div class="modal fade" id="editModal<?= $p->id; ?>" tabindex="-1">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form action="<?= base_url('produit/edit/'.$p->id); ?>" method="post" enctype="multipart/form-data">
                      <div class="modal-header">
                        <h5 class="modal-title">Modifier produit</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>
                      <div class="modal-body">
                        <div class="mb-2">
                          <input type="text" name="name" value="<?= $p->name; ?>" class="form-control" required>
                        </div>
                        <div class="mb-2">
                          <select name="category_id" class="form-select" required>
                            <?php foreach ($categories as $cat): ?>
                              <option value="<?= $cat->id; ?>" <?= ($cat->id == $p->category_id) ? 'selected' : ''; ?>>
                                <?= $cat->name; ?>
                              </option>
                            <?php endforeach; ?>
                          </select>
                        </div>
                        <div class="mb-2">
                          <input type="number" name="price" value="<?= $p->price; ?>" class="form-control" required>
                        </div>
                        <div class="mb-2">
                          <input type="number" name="qte_stock" value="<?= $p->qte_stock; ?>" class="form-control" required>
                        </div>
                        <div class="mb-2">
                          <input type="number" name="seuil_alert" value="<?= $p->seuil_alert; ?>" class="form-control" required>
                        </div>
                        <div class="mb-2">
                          <input type="file" name="photo" class="form-control">
                          <?php if ($p->photo): ?>
                            <img src="<?= base_url($p->photo); ?>" width="60" class="mt-2 rounded">
                          <?php endif; ?>
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
            <tr><td colspan="8" class="text-center text-muted">Aucun produit trouvé.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    <div class="mt-3"><?= $pagination; ?></div>
  </div>
</div>
