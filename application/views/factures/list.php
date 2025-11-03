<div class="container-fluid mt-4">
  <div class="card p-3 shadow-sm">
    <h4>Liste des factures</h4>

    <?php if($this->session->flashdata('success')): ?>
      <div class="alert alert-success"><?= $this->session->flashdata('success'); ?></div>
    <?php endif; ?>

    <form method="get" class="mb-3">
      <div class="input-group">
        <input type="text" name="search" value="<?= htmlspecialchars($search); ?>" class="form-control" placeholder="Rechercher facture ou client...">
        <button type="submit" class="btn btn-primary"><i class="bi bi-search"></i></button>
        <a href="<?= base_url('factures'); ?>" class="btn btn-outline-danger"><i class="bi bi-x-circle"></i></a>
      </div>
    </form>

    <div class="table-responsive">
      <table class="table table-striped align-middle">
        <thead>
          <tr>
            <th>#</th>
            <th>Numéro</th>
            <th>Client</th>
            <th>Date</th>
            <th>Total HT</th>
            <th>Total TTC</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if(!empty($factures)): ?>
            <?php foreach($factures as $f): ?>
              <tr>
                <td><?= $f->id; ?></td>
                <td><?= $f->numfacture; ?></td>
                <td><?= htmlspecialchars($f->client_name); ?></td>
                <td><?= $f->date_facture; ?></td>
                <td><?= number_format($f->total_HT,2); ?> Ar</td>
                <td><?= number_format($f->total_TTC,2); ?> Ar</td>
                <td>
                  <a href="<?= base_url('factures/view/'.$f->id); ?>" class="btn btn-sm btn-primary"><i class="bi bi-eye"></i></a>
									<a href="<?= base_url('factures/pdf/'.$f->id); ?>" class="btn btn-sm btn-danger" title="Exporter en PDF">
                  <i class="bi bi-file-earmark-pdf"></i>
                  </a>

                  <a href="<?= base_url('factures/delete/'.$f->id); ?>" class="btn btn-sm btn-danger" onclick="return confirm('Supprimer cette facture ?')"><i class="bi bi-trash"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr><td colspan="7" class="text-center text-muted">Aucune facture trouvée.</td></tr>
          <?php endif; ?>
        </tbody>
      </table>
      <div class="mt-3"><?= $pagination; ?></div>
    </div>
  </div>
</div>
