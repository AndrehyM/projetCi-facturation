<div class="container-fluid mt-4">
<div class="card p-3 shadow-sm">
    <h3>Liste des factures</h3>

    <div class="row mb-3">
        <div class="col-md-4">
            <form method="get" action="">
                <input type="text" name="search" value="<?= isset($search)?$search:'' ?>" class="form-control" placeholder="Rechercher facture...">
            </form>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Numéro</th>
                    <th>Client</th>
                    <th>Date</th>
                    <th>Total HT</th>
                    <th>Total TTC</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($factures as $f) : ?>
                <tr>
                    <td><?= $f->id ?></td>
                    <td><?= $f->numfacture ?></td>
                    <td><?= $f->client_name ?></td>
                    <td><?= $f->date_facture ?></td>
                    <td><?= number_format($f->total_HT,2) ?> €</td>
                    <td><?= number_format($f->total_TTC,2) ?> €</td>
                    <td>
                        <a href="<?= site_url('factures/view/'.$f->id) ?>" class="btn btn-sm btn-info"><i class="bi bi-eye"></i></a>
                        <a href="<?= site_url('factures/pdf/'.$f->id) ?>" class="btn btn-sm btn-success"><i class="bi bi-file-earmark-pdf"></i></a>
                        <a href="<?= site_url('factures/delete/'.$f->id) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette facture ?')"><i class="bi bi-trash"></i></a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="mt-2"><?= $pagination ?></div>
</div>
</div>
