<!doctype html><html><head><meta charset="utf-8"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fundamental-styles@0.25.0/dist/fundamental-styles.min.css"></head>
<body><main style="padding:16px">
<h2 class="fd-title fd-title--h4">GSTR‑1 (B2B extract)</h2>
<table class="fd-table" style="width:100%"><thead><tr><th>Receiver GSTIN</th><th>Invoice No</th><th>Date</th><th>Taxable</th><th>CGST+SGST</th><th>IGST</th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?>
<tr class="fd-table__row"><td class="fd-table__cell"><?= esc($r['receiver_gstin']) ?></td><td class="fd-table__cell"><?= esc($r['invoice_no']) ?></td><td class="fd-table__cell"><?= esc($r['invoice_date']) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['taxable_value'],2) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['intrastate_tax'],2) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['interstate_tax'],2) ?></td></tr>
<?php endforeach; ?>
</tbody></table>
</main></body></html>
