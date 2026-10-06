#!/usr/bin/env python3
"""Package only website runtime files, never hosting backups or developer tools."""
import argparse
from pathlib import Path
import tarfile
import io
import json
import os
import re
import subprocess

ROOT = Path(__file__).resolve().parents[1]
PAGES = ['index.html', 'about.html', 'contact.html', 'calendar.html', 'courses-trainings.html',
         'products.html', 'payment.html', 'Nonprofit-Formation-Incorporation.php',
         'For-profit-Business-Formation.php', 'Consultation-Coaching.php',
         'Workshops-Trainings.php', 'speaking-engagement-form.php',
         'workshop-seminar-training-form.php', 'sitemap.xml',
         'Brian Westbrook Testimonial .png', 'Jumaine Jones Testimonial.png',
         'phpMailer/PHPMailer.php', 'phpMailer/Exception.php', 'phpMailer/SMTP.php']
DIRECTORIES = ['assets']

def files():
    paths = [ROOT / name for name in PAGES]
    for name in DIRECTORIES:
        folder = ROOT / name
        if folder.exists():
            paths += [p for p in folder.rglob('*') if p.is_file()]
    for path in sorted(set(paths)):
        if not path.exists():
            raise ValueError(f'Missing runtime file: {path.relative_to(ROOT)}')
        if path.is_symlink() or not path.resolve().is_relative_to(ROOT):
            raise ValueError('Runtime symlinks are not allowed')
        if path.name == '.DS_Store' or path.suffix in {'.log', '.map'}:
            continue
        yield path

def main():
    parser = argparse.ArgumentParser()
    parser.add_argument('--output', required=True)
    args = parser.parse_args()
    entries = list(files())
    revision = os.environ.get('GITHUB_SHA') or subprocess.check_output(['git', 'rev-parse', 'HEAD'], cwd=ROOT, text=True).strip()
    if not re.fullmatch(r'[a-f0-9]{40}|[a-f0-9]{64}', revision):
        raise ValueError('Invalid deployment revision')
    release = json.dumps({'commit': revision}).encode()
    with tarfile.open(args.output, 'w:gz') as archive:
        info = tarfile.TarInfo('assets/deployment.json')
        info.size = len(release)
        info.mode = 0o644
        archive.addfile(info, io.BytesIO(release))
        for path in entries:
            archive.add(path, arcname=str(path.relative_to(ROOT)), recursive=False)
    print(f'Packaged {len(entries)+1} runtime files. Hosting SSL settings and backups excluded.')

if __name__ == '__main__':
    main()
