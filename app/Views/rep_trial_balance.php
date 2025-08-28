<!doctype html><html><head><meta charset="utf-8"><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fundamental-styles@0.25.0/dist/fundamental-styles.min.css"><style>.tight .fd-table__cell{padding:.25rem .5rem}</style></head>
<body><main style="padding:16px">
<h2 class="fd-title fd-title--h4">Trial Balance</h2>
<table class="fd-table tight" style="width:100%"><thead><tr><th>Code</th><th>Account</th><th>Type</th><th class="fd-table__cell fd-table__cell--fit-content">Debit</th><th class="fd-table__cell fd-table__cell--fit-content">Credit</th></tr></thead>
<tbody>
<?php foreach($rows as $r): ?>
<tr class="fd-table__row"><td class="fd-table__cell"><?= esc($r['code']) ?></td><td class="fd-table__cell"><?= esc($r['name']) ?></td><td class="fd-table__cell"><?= esc($r['type_name']) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['total_debit'],2) ?></td><td class="fd-table__cell" style="text-align:right"><?= number_format($r['total_credit'],2) ?></td></tr>
<?php endforeach; ?>
</tbody></table>
</main></body></html>
