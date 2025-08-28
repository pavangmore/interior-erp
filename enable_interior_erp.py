#!/usr/bin/env python3
"""
Enable Interior ERP (CI4) — one-shot setup runner.

What it does:
  • Validates PHP/Composer
  • Ensures writable & uploads dirs
  • Installs composer deps (if vendor/ missing)
  • Runs migrations + seeders (InitialSeeder, FinanceSeeder2025)
  • Prints routes and (optionally) starts the dev server

Usage:
  python3 enable_interior_erp.py --path /path/to/ci4/project
  python3 enable_interior_erp.py --path . --start-server --port 8080
"""

import argparse
import os
import sys
import subprocess
import shutil

def which(cmd: str) -> bool:
    return shutil.which(cmd) is not None

def run(cmd, cwd, env=None) -> int:
    print(f"\n$ {' '.join(cmd)}")
    proc = subprocess.Popen(cmd, cwd=cwd, stdout=subprocess.PIPE, stderr=subprocess.STDOUT, text=True, env=env)
    for line in proc.stdout:
        print(line, end='')
    return proc.wait()

def parse_env(env_path: str) -> dict:
    data = {}
    if not os.path.exists(env_path):
        return data
    with open(env_path, 'r', encoding='utf-8', errors='ignore') as f:
        for raw in f:
            line = raw.strip()
            if not line or line.startswith('#'):
                continue
            if '=' in line:
                k, v = line.split('=', 1)
                k = k.strip()
                v = v.strip().strip('\"').strip(\"'\")
                data[k] = v
    return data

def ensure_dirs(root: str):
    dirs = [
        'writable', 'writable/cache', 'writable/logs', 'writable/uploads',
        'public/uploads'
    ]
    for d in dirs:
        os.makedirs(os.path.join(root, d), exist_ok=True)
    # best-effort permissions on *nix
    try:
        os.chmod(os.path.join(root, 'writable'), 0o775)
    except Exception:
        pass

def validate_structure(root: str):
    required = [
        ('app', True),
        ('public', True),
        ('app/Config/Routes.php', True),
    ]
    missing = []
    for path, must_exist in required:
        if must_exist and not os.path.exists(os.path.join(root, path)):
            missing.append(path)
    if missing:
        print('❌ Missing required paths under project root:', ', '.join(missing))
        print('Make sure you point --path to the CI4 project that already contains the ERP bundle.')
        sys.exit(1)

def main():
    parser = argparse.ArgumentParser(description='Enable Interior ERP (CI4) — migrations, seeders, optional server.')
    parser.add_argument('--path', default='.', help='Path to CI4 project root (contains app/, public/, vendor/ etc.)')
    parser.add_argument('--skip-composer', action='store_true', help='Skip composer install step')
    parser.add_argument('--start-server', action='store_true', help='Start php spark serve after setup')
    parser.add_argument('--port', type=int, default=8080, help='Port for php spark serve (default 8080)')
    args = parser.parse_args()

    root = os.path.abspath(args.path)
    print('→ CI4 root:', root)

    validate_structure(root)

    if not which('php'):
        print('❌ PHP CLI not found in PATH. Please install PHP 8.1+ and try again.')
        sys.exit(1)

    if not args.skip_composer and not which('composer'):
        print('⚠️  Composer not found; continuing with --skip-composer.')
        args.skip_composer = True

    env_path = os.path.join(root, '.env')
    env = parse_env(env_path)
    print('→ Base URL:', env.get('app.baseURL', '(not set)'))
    print('→ DB Host:', env.get('database.default.hostname', '(not set)'))
    print('→ DB Name:', env.get('database.default.database', '(not set)'))
    print('→ DB User:', env.get('database.default.username', '(not set)'))

    ensure_dirs(root)

    # Composer install if vendor/ missing
    vendor_dir = os.path.join(root, 'vendor')
    if not args.skip_composer and not os.path.isdir(vendor_dir):
        code = run(['composer', 'install'], cwd=root)
        if code != 0:
            print('❌ composer install failed. Fix errors and retry, or pass --skip-composer if vendor/ already present.')
            sys.exit(code)

    # Update namespaces (composer script usually handles this)
    # Safe to attempt; ignore failures silently
    if os.path.isdir(vendor_dir):
        try:
            run(['php', 'spark', 'namespaces:update'], cwd=root)
        except Exception:
            pass

    # Migrations
    code = run(['php', 'spark', 'migrate', '--all'], cwd=root)
    if code != 0:
        print('❌ Migrations failed. Inspect output above.')
        sys.exit(code)

    # Seeders
    for seeder in ['InitialSeeder', 'FinanceSeeder2025']:
        code = run(['php', 'spark', 'db:seed', seeder], cwd=root)
        if code != 0:
            print(f'❌ Seeding {seeder} failed.')
            sys.exit(code)

    # Show available routes for sanity
    run(['php', 'spark', 'routes'], cwd=root)

    print('\\n✅ Interior ERP is enabled.')
    print('   Try these URLs after starting the server:')
    print('     • /projects')
    print('     • /reports/trial-balance')
    print('     • /reports/pnl')
    print('     • /reports/balance-sheet')
    print('     • /reports/gstr1')
    print('     • /reports/gstr3b')

    if args.start_server:
        print(f'→ Starting CI4 dev server on http://localhost:{args.port} (Ctrl+C to stop)')
        run(['php', 'spark', 'serve', '--port', str(args.port)], cwd=root)

if __name__ == '__main__':
    main()
