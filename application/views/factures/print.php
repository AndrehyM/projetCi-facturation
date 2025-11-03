<!DOCTYPE html>
<html>
<head>
    <title>Facture <?= $facture->numfacture; ?></title>
    <link href="<?php echo base_url('bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('bootstrap/icon/bootstrap-icons/bootstrap-icons.min.css'); ?>" rel="stylesheet">
    <style>
        @media print {
            .no-print { display: none; }
        }
        body {
            font-size: 14px;
            font-family: 'Segoe UI', sans-serif;
        }
        .facture-box {
            border: 1px solid #ccc;
            padding: 30px;
            margin-top: 20px;
            background-color: #fff;
			border-radius:5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }
        .totaux {
            margin-top: 20px;
            text-align: right;
        }
        .signature {
            margin-top: 60px;
            text-align: right;
        }
        .remerciement {
            margin-top: 40px;
            text-align: center;
            font-style: italic;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container facture-box">
        <h3 class="text-center mb-4">Facture N° <?= $facture->numfacture; ?></h3>

        <div class="row mb-3">
            <div class="col-md-6">
                <p><strong>Client :</strong> <?= htmlspecialchars($facture->client_name); ?></p>
            </div>
            <div class="col-md-6 text-end">
                <p><strong>Date :</strong> <?= $facture->date_facture; ?></p>
            </div>
        </div>

        <table>
            <thead>
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
                        <td><?= number_format($item->priceUnit,2); ?> Ar</td>
                        <td><?= number_format($item->subtotal,2); ?> Ar</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="totaux">
            <p><strong>Total HT :</strong> <?= number_format($facture->total_HT,2); ?> Ar</p>
            <p><strong>Total TTC :</strong> <?= number_format($facture->total_TTC,2); ?> Ar</p>
        </div>

        <div class="signature">
            <p>Signature</p>
            <p>Andrehy mivonona</p>
        </div>

        <div class="remerciement">
            <p>Merci de nous faire confiance.</p>
        </div>

        <div class="mt-4 no-print">
            <button class="btn btn-success" onclick="window.print()"><i class="bi bi-printer"></i></button>
            <a href="<?= site_url('factures'); ?>" class="btn btn-secondary"><i class="bi bi-arrow-left"></i></a>
        </div>
    </div>
</body>
</html>
