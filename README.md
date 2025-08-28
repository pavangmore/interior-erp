# Interior ERP (CodeIgniter 4) — App Bundle

This bundle contains the **app/** code for an Interior Designer ERP with **Fiori-style UI**, **Inventory/Procurement**, and **Accounting + GST/TDS (India 2025)**.

> Use with a standard CodeIgniter 4 skeleton (Composer). This bundle excludes vendor/ and framework files for size reasons.

## Quick Setup

```bash
# 1) Prepare a fresh CI4 project (or use this repo root after composer install)
composer create-project codeigniter4/appstarter interior-erp
cd interior-erp

# 2) Copy the contents of this bundle into your project root, overwriting app/, public/, etc.
# If you downloaded the zip directly, extract it, then copy its files over.

# 3) Configure .env (uncomment vars) — at least baseURL and DB
cp .env.example .env
# edit .env, set:
# app.baseURL = 'http://localhost:8080/'
# database.default.hostname = 127.0.0.1
# database.default.database = interior_erp
# database.default.username = root
# database.default.password = ''
# database.default.DBDriver = MySQLi

# 4) Install dependencies (if needed)
composer install

# 5) Create database `interior_erp` (or whichever you set in .env)

# 6) Migrate & seed
php spark migrate
php spark db:seed InitialSeeder
php spark db:seed FinanceSeeder2025

# 7) Run
php spark serve
# open http://localhost:8080/projects (UI)
# Reports: /reports/trial-balance, /reports/pnl, /reports/balance-sheet, /reports/gstr1, /reports/gstr3b
```

## Notes
- CI4 version: compatible with 4.4.x/4.5.x. Ensure PHP >= 8.1.
- Database: MySQL 8+ or MariaDB 10.6+.
- Views use **fundamental-styles** via CDN for a Fiori-like compact table layout.
- 3D design preview via `<model-viewer>` (GLB/GLTF).

## Modules
- CRM (clients), Projects + Milestones
- Materials, Inventory (Stock Ledger), Procurement (PO, GRN)
- Finance (Invoices, Receipts)
- **Accounting:** Chart of Accounts, Journal, Posting services, TB/P&L/BS, GST reports
