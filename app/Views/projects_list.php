<!doctype html><html><head>
<meta charset="utf-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fundamental-styles@0.25.0/dist/fundamental-styles.min.css"/>
<style>
  body{font-family:system-ui,Segoe UI,Inter,Arial;color:#222}
  .shell{display:grid;grid-template-columns:240px 1fr;min-height:100vh}
  aside{border-right:1px solid #eee;padding:12px}
  main{padding:16px}
  .tight .fd-table__cell{padding:.25rem .5rem}
</style>
</head><body>
<div class="shell">
  <aside>
    <h3 class="fd-title fd-title--h5">ERP</h3>
    <nav class="fd-list fd-list--navigation">
      <a class="fd-list__item is-selected" href="/projects">Projects</a>
      <a class="fd-list__item" href="#">Materials</a>
      <a class="fd-list__item" href="#">Procurement</a>
      <a class="fd-list__item" href="#">Inventory</a>
      <a class="fd-list__item" href="#">Finance</a>
      <a class="fd-list__item" href="#">Clients</a>
      <a class="fd-list__item" href="/reports/trial-balance">Trial Balance</a>
    </nav>
  </aside>
  <main>
    <div class="fd-toolbar fd-toolbar--clear">
      <div class="fd-toolbar__left"><h2 class="fd-title fd-title--h4">Projects</h2></div>
      <div class="fd-toolbar__right">
        <input class="fd-input" placeholder="Search" id="q"/>
        <button class="fd-button fd-button--emphasized" onclick="createProj()">New Project</button>
      </div>
    </div>
    <table class="fd-table fd-table--no-horizontal-borders tight" style="width:100%">
      <thead class="fd-table__header"><tr class="fd-table__row">
        <th class="fd-table__cell">Code</th>
        <th class="fd-table__cell">Name</th>
        <th class="fd-table__cell">Client</th>
        <th class="fd-table__cell">Status</th>
        <th class="fd-table__cell">Start</th>
      </tr></thead>
      <tbody class="fd-table__body" id="rows"></tbody>
    </table>
  </main>
</div>
<script>
async function load(){
  const res = await fetch('/api/projects');
  const data = await res.json();
  const rows = document.getElementById('rows');
  rows.innerHTML = (data||[]).map(p=>`<tr class='fd-table__row'>
    <td class='fd-table__cell'>${p.code||''}</td>
    <td class='fd-table__cell'><a href='/projects/${p.id}'>${p.name}</a></td>
    <td class='fd-table__cell'>${p.client_name||''}</td>
    <td class='fd-table__cell'>${p.status}</td>
    <td class='fd-table__cell'>${p.start_date||''}</td>
  </tr>`).join('');
}
async function createProj(){
  const name = prompt('Project name?');
  if(!name) return;
  await fetch('/api/projects',{method:'POST',headers:{'Content-Type':'application/json'},body:JSON.stringify({name, client_id:1, status:'planning'})});
  load();
}
load();
</script>
</body></html>
