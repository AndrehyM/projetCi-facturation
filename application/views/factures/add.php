<div class="container-fluid mt-4">
  <div class="card p-3 shadow-sm">
    <h4>Créer une facture</h4>

    <?php if($this->session->flashdata('error')): ?>
      <div class="alert alert-danger"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <form method="post">
      <div class="row g-3 mb-3">
        <div class="col-md-6">
          <label>Client</label>
          <select name="client_id" class="form-select" required>
            <option value="">-- Choisir client --</option>
            <?php foreach($clients as $c): ?>
              <option value="<?= $c->id; ?>"><?= htmlspecialchars($c->name); ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-6">
          <label>Date</label>
          <input type="date" name="date_facture" class="form-control" value="<?= date('Y-m-d'); ?>" required>
        </div>
      </div>

      <h5>Produits</h5>
      <table class="table table-bordered" id="itemsTable">
        <thead>
          <tr>
            <th>Produit</th>
            <th>Quantité</th>
            <th>Prix unitaire</th>
            <th>Sous-total</th>
            <th><button type="button" class="btn btn-sm btn-success" onclick="addRow()">+</button></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>

      <div class="mb-3">
        <label>Total HT</label>
        <input type="text" id="totalHT" class="form-control" readonly>
      </div>

      <button type="submit" class="btn btn-primary">Valider et Créer Facture</button>
    </form>
  </div>
</div>

<script>
let products = <?php echo json_encode($products); ?>;
let rowIndex = 0;

function addRow(){
  let tbody = document.querySelector('#itemsTable tbody');
  let tr = document.createElement('tr');

  let options = products.map(p => `<option value="${p.id}" data-price="${p.price}">${p.name}</option>`).join('');
  tr.innerHTML = `
    <td>
      <select name="items[${rowIndex}][product_id]" class="form-select productSelect" required>${options}</select>
    </td>
    <td>
      <input type="number" name="items[${rowIndex}][quantity]" class="form-control quantity" value="1" min="1" required>
    </td>
    <td>
      <input type="text" class="form-control priceUnit" readonly>
      <input type="hidden" name="items[${rowIndex}][priceUnit]" class="hiddenPriceUnit">
    </td>
    <td>
      <input type="text" class="form-control subtotal" readonly>
    </td>
    <td>
      <button type="button" class="btn btn-sm btn-danger" onclick="this.closest('tr').remove(); updateTotal();">-</button>
    </td>
  `;
  tbody.appendChild(tr);
  updatePriceUnit(tr);

  tr.querySelector('.productSelect').addEventListener('change', () => updatePriceUnit(tr));
  tr.querySelector('.quantity').addEventListener('input', () => updateSubtotal(tr));

  rowIndex++;
}

function updatePriceUnit(row){
  let select = row.querySelector('.productSelect');
  let price = parseFloat(select.selectedOptions[0].dataset.price) || 0;
  row.querySelector('.priceUnit').value = price.toFixed(2);
  row.querySelector('.hiddenPriceUnit').value = price.toFixed(2);
  updateSubtotal(row);
}

function updateSubtotal(row){
  let qty = parseFloat(row.querySelector('.quantity').value) || 0;
  let price = parseFloat(row.querySelector('.priceUnit').value) || 0;
  row.querySelector('.subtotal').value = (qty * price).toFixed(2);
  updateTotal();
}

function updateTotal(){
  let total = 0;
  document.querySelectorAll('.subtotal').forEach(el => {
    total += parseFloat(el.value) || 0;
  });
  document.getElementById('totalHT').value = total.toFixed(2);
}
</script>
