<!doctype html><html><head><meta charset="utf-8"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fundamental-styles@0.25.0/dist/fundamental-styles.min.css"></head>
<body><main style="padding:16px">
<h2 class="fd-title fd-title--h4">Balance Sheet</h2>
<table class="fd-table" style="width:100%"><thead><tr><th>Type</th><th>Account</th><th style="text-align:right">Amount (₹)</th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?>
<tr class="fd-table__row"><td class="fd-table__cell"><?= esc($r['type_name']) ?></td><td class="fd-table__cell"><?= esc($r['account']) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['amount'],2) ?></td></tr>
<?php endforeach; ?>
</tbody></table>
</main></body></html>
