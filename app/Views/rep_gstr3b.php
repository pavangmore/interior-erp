<!doctype html><html><head><meta charset="utf-8"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fundamental-styles@0.25.0/dist/fundamental-styles.min.css"></head>
<body><main style="padding:16px">
<h2 class="fd-title fd-title--h4">GSTR‑3B Summary (Outward)</h2>
<table class="fd-table" style="width:100%"><thead><tr><th>Period</th><th>Taxable</th><th>CGST</th><th>SGST</th><th>IGST</th><th>Grand Total</th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?>
<tr class="fd-table__row"><td class="fd-table__cell"><?= esc($r['tax_period']) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['taxable'],2) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['cgst'],2) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['sgst'],2) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['igst'],2) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['outward'],2) ?></td></tr>
<?php endforeach; ?>
</tbody></table>
</main></body></html>
