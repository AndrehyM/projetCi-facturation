<div class="container-fluid mt-4">
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php elseif ($this->session->flashdata('error')): ?>
        <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <!-- Formulaire d'ajout -->
    <div class="card p-4 mb-4 shadow-sm">
        <h5><i class="bi bi-person-plus"></i> Ajouter un utilisateur</h5>
        <form action="<?= base_url('gestion_user/add'); ?>" method="post">
            <div class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="username" class="form-control" placeholder="Nom d'utilisateur" required>
                </div>
                <div class="col-md-4">
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                <div class="col-md-4">
                    <input type="password" name="password" class="form-control" placeholder="Mot de passe" required>
                </div>
                <div class="col-md-4 mt-2">
                    <select name="role" class="form-select" required>
                        <option value="">-- Choisir un rôle --</option>
                        <option value="admin">Admin</option>
                        <option value="gerant">Gérant</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary mt-3"><i class="bi bi-plus-circle"></i> Ajouter</button>
        </form>
    </div>

    <!-- Recherche -->
    <form method="get" class="mb-3">
        <div class="input-group">
            <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" class="form-control" placeholder="Rechercher un utilisateur...">
            <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
            <a href="<?= base_url('gestion_user'); ?>" class="btn btn-outline-danger"><i class="bi bi-x-circle"></i></a>
        </div>
    </form>

    <!-- Liste -->
    <div class="card p-3 shadow-sm">
        <h5><i class="bi bi-list"></i> Liste des utilisateurs</h5>
        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(!empty($liste_utilisateurs)): ?>
                        <?php foreach($liste_utilisateurs as $u): ?>
                        <tr>
                            <td><?= $u->id; ?></td>
                            <td><?= htmlspecialchars($u->username); ?></td>
                            <td><?= htmlspecialchars($u->email); ?></td>
                            <td><?= ucfirst($u->role); ?></td>
                            <td>
                                <a href="<?= base_url('gestion_user/delete/'.$u->id); ?>" onclick="return confirm('Supprimer cet utilisateur ?');" class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center text-muted">Aucun utilisateur trouvé.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
            <div class="mt-3"><?= $pagination; ?></div>
        </div>
    </div>
</div>
