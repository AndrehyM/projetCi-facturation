<div class="container-fluid mt-4">
  <div class="card p-4 shadow-sm border-0">
    <div class="d-flex justify-content-between align-items-center mb-3">
      <h3 class="mb-0"> Facture N° <?= $facture->numfacture; ?></h3>
      <span class="text-muted"><strong>Date :</strong> <?= date('d/m/Y', strtotime($facture->date_facture)); ?></span>
    </div>

    <div class="mb-3">
      <p><strong>Client :</strong> <?= htmlspecialchars($facture->client_name); ?></p>
    </div>

    <table class="table table-bordered table-striped">
      <thead class="table-light">
        <tr>
          <th>Produit</th>
          <th>Quantité</th>
          <th>Prix unitaire</th>
          <th>Sous-total</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($facture->items as $item): ?>
        <tr>
          <td><?= htmlspecialchars($item->product_name); ?></td>
          <td><?= $item->quantity; ?></td>
          <td><?= number_format($item->priceUnit, 2); ?> Ar</td>
          <td><?= number_format($item->subtotal, 2); ?> Ar</td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div class="row mt-4">
      <div class="col-md-6"></div>
      <div class="col-md-6 text-end">
        <p><strong>Total HT :</strong> <?= number_format($facture->total_HT, 2); ?> Ar</p>
        <p><strong>Total TTC :</strong> <?= number_format($facture->total_TTC, 2); ?> Ar</p>
      </div>
    </div>

    <div class="row mt-5">
      <div class="col-md-6">
        <a href="<?= site_url('factures/print/'.$facture->id); ?>" class="btn btn-outline-primary">
          <i class="bi bi-printer"></i> Imprimer
        </a>
      </div>
      <div class="col-md-6 text-end">
        <a href="<?= base_url('factures/pdf/'.$facture->id); ?>" class="btn btn-danger">
          <i class="bi bi-file-earmark-pdf"></i> Exporter en PDF
        </a>
      </div>
    </div>

    <div class="mt-5 text-end">
      <p><strong>Signature</strong></p>
      <p>__________________________</p>
    </div>

    <div class="mt-4 text-center text-muted fst-italic">
      <p>Merci de nous faire confiance.</p>
    </div>
  </div>
</div>
