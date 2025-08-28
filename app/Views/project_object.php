<!doctype html><html><head>
<meta charset="utf-8"/><meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fundamental-styles@0.25.0/dist/fundamental-styles.min.css"/>
<style>body{font-family:system-ui,Segoe UI,Inter,Arial;color:#222}main{padding:16px}</style>
<script type="module" src="https://unpkg.com/@google/model-viewer/dist/model-viewer.min.js"></script>
</head><body>
<main>
  <a class="fd-button" href="/projects">← Back</a>
  <h2 class="fd-title fd-title--h4">Project: <?= esc($project->name ?? 'Unknown') ?></h2>
  <div class="fd-panel"><div class="fd-panel__body">
    <div class="fd-form-item"><label class="fd-form-label">Client</label><div><?= esc($project->client_name ?? '-') ?></div></div>
    <div class="fd-form-item"><label class="fd-form-label">Status</label><div><?= esc($project->status ?? '-') ?></div></div>
  </div></div>

  <h3 class="fd-title fd-title--h5" style="margin-top:16px">Milestones</h3>
  <table class="fd-table fd-table--no-horizontal-borders" style="width:100%">
    <thead class="fd-table__header"><tr class="fd-table__row">
      <th class="fd-table__cell">Name</th>
      <th class="fd-table__cell">Due</th>
      <th class="fd-table__cell">Amount (₹)</th>
      <th class="fd-table__cell">Status</th>
    </tr></thead>
    <tbody class="fd-table__body">
      <?php foreach(($milestones??[]) as $m): ?>
        <tr class="fd-table__row">
          <td class="fd-table__cell"><?= esc($m['name']) ?></td>
          <td class="fd-table__cell"><?= esc($m['due_date']) ?></td>
          <td class="fd-table__cell" style="text-align:right"><?= number_format($m['amount'],2) ?></td>
          <td class="fd-table__cell"><?= esc($m['status']) ?></td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>

  <h3 class="fd-title fd-title--h5" style="margin-top:16px">Design Preview</h3>
  <model-viewer src="/uploads/sample.glb" camera-controls auto-rotate style="width:100%;height:420px"></model-viewer>
</main>
</body></html>
