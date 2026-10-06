#!/usr/bin/env python3
"""Lint the exact PHP runtime shipped to the host, including used mailer files."""
from pathlib import Path
import runpy
import subprocess
import sys
module = runpy.run_path(str(Path(__file__).with_name('package-site.py')))
files = [p for p in module['files']() if p.suffix == '.php']
failed = []
for path in files:
    result = subprocess.run(['php', '-l', str(path)], capture_output=True, text=True)
    if result.returncode:
        failed.append(str(path.relative_to(module['ROOT'])))
        print(result.stdout + result.stderr, file=sys.stderr)
if failed:
    raise SystemExit('PHP syntax failed: ' + ', '.join(failed))
print(f'PHP syntax passed for all {len(files)} deployed runtime files.')
