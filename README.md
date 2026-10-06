# Wesley Proctor Enterprise website

PHP and static HTML, hosted at https://wesleyproctorenterprise.com/. This redesign uses the public live content retrieved October 6, 2026, with PHP handlers based on the freshly fetched `origin/main` (`e677d48`). Hosting-side PHP source still needs to be downloaded and reconciled after account recovery. See [deployment setup](docs/GODADDY-DEPLOYMENT.md).

## Preview

Run `php -S 127.0.0.1:4187 -t .` and open http://127.0.0.1:4187/. No application build is required. A preview PHP server is not a production server; bind it to loopback only.

## Edit and regenerate

Shared page structure lives in `scripts/render-site.py`; styles and interaction live in `assets/site.css` and `assets/site.js`. `scripts/content/live-content.json` is the captured public HTML content used to preserve the business wording. `scripts/content/handlers/` contains the origin/main PHP handlers with unused password strings removed. The renderer applies the documented input and delivery improvements when generating the public form pages.

Install the Python development dependency from `requirements-dev.txt` in an environment of your choice, then run `python3 scripts/render-site.py`. Generated HTML/PHP files are committed, so the host needs no Python or Node installation. To bring in new hosting source, compare it with the captured files before updating the renderer inputs.

## Verify

- `python3 scripts/check-site.py`: lint exactly the PHP files included in the deployment package. Unused legacy PHPMailer autoload files are excluded because they are incompatible with PHP 8.

- `python3 -m unittest discover -s tests -p 'test_*.py'`: real PHP handlers with a fake mailer, plus server-release backup/overlay tests in disposable directories. No real emails are sent.
- `node tests/browser-qa.cjs`: requires Playwright and a running loopback preview. For an existing installation, set `PLAYWRIGHT_MODULE_PATH`; optionally set `PLAYWRIGHT_EXECUTABLE_PATH`. The suite covers all 13 pages at 360, 768, and 1440px, mobile navigation, field labels, contrast, links, image loading, and an intercepted PayPal POST. No payment is sent.
- `python3 scripts/package-site.py --output /tmp/site.tar.gz`: runtime-only deployment archive. It excludes development files, old test endpoints, hosting backups, server logs, .htaccess, and SSL/ACME files.

## Deploy

`.github/workflows/site.yml` checks pull requests and main pushes. Deployment only runs from main after the repository variable `GODADDY_DEPLOY_ENABLED` is explicitly enabled and the confirmed hosting credentials/document root are configured. Backups are kept outside the served site; uploads preserve unrelated remote files and host-managed SSL settings. See [the setup and restoration instructions](docs/GODADDY-DEPLOYMENT.md).

Changes to the contact page replace unused French template details with verified business contact details. The calendar follows the current live “Coming Soon” page, rather than the repository’s test-account calendar. The nonprofit inquiry no longer asks for a Social Security number. The incomplete Stripe success endpoint and old generic test-inbox handler are outside the deployment package; remote cleanup must follow source reconciliation.
