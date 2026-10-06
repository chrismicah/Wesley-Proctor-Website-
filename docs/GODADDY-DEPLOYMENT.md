# GoDaddy connection and deployment

The live site is https://wesleyproctorenterprise.com/. Observed October 6, 2026: HTTPS responds 200, HTTP redirects to HTTPS, A record is 72.167.67.26, and nameservers are ns67/ns68.domaincontrol.com. These records indicate GoDaddy DNS; confirm the hosting subscription in the account before configuring deployment. The repository and current homepage differ.

## Recover account access

1. Search your likely inboxes for GoDaddy receipts and this domain. This repository contains no GoDaddy account email or deployment credentials.
2. Use [Retrieve Username](https://sso.godaddy.com/account/retrieve) with the account email and domain. GoDaddy sends a verification code to that email.
3. Use [Reset Password](https://sso.godaddy.com/account/reset) after retrieving the username. Do not put account passwords in this repository or chat.
4. If you cannot access the email, use [GoDaddy account recovery](https://www.godaddy.com/help/regain-access-to-my-domain-or-my-godaddy-account-4043).
5. In My Products, verify **Web Hosting (cPanel)**, not only domain registration. Open Manage > cPanel and check Domains for the exact document root. Do not assume the root is public_html: this copy includes addon-domain directories.

## One-time hosting setup

Enable SSH in the GoDaddy hosting dashboard: Settings > SSH access > Manage. In cPanel > SSH Access, import and authorize a dedicated deployment public key. Keep its private key in GitHub environment secrets, never Git. Confirm key-based SSH works from a terminal and identify the server's actual host key through a trusted connection. `ssh-keyscan` alone does not authenticate a server.

The account must provide SSH, bash, tar, and a PHP CLI matching the web PHP version. Only the three namespaced PHPMailer files used by the current service forms are packaged; the unused legacy autoloader is incompatible with PHP 8 and is excluded. If SSH key authentication is unavailable for the plan, stop here and adapt deployment to its confirmed supported transport. This workflow does not use GoDaddy's DNS API: a DNS API key does not upload PHP files.

Create GitHub environment **godaddy-production**, restrict it to main, and add:

| Type | Name | Value |
| --- | --- | --- |
| Secret | GODADDY_HOST | Confirmed hosting IP/hostname |
| Secret | GODADDY_USER | cPanel username |
| Secret | GODADDY_SSH_KEY | Dedicated private deployment key |
| Secret | GODADDY_KNOWN_HOSTS | Trusted SSH known_hosts line for that host, port 22 |
| Environment variable | GODADDY_PATH | Confirmed absolute document root, e.g. /home/USERNAME/public_html |
| Repository variable | GODADDY_DEPLOY_ENABLED | Leave unset until the first deployment is ready; set to true to enable |

Once enabled, pushes/merges to main run PHP checks, package the runtime files, and deploy. Pull requests only check the site. Manual runs also deploy main only. Concurrent deploys queue, and active uploads are not canceled.

Every release is staged and PHP-linted on the server before upload. The existing document root is backed up outside the public directory to `~/.wpe-deploy/RELEASE/before.tar.gz`. Only runtime files are overlaid; the workflow never deletes remote files, overwrites .htaccess, or touches SSL/ACME settings. The subsequent HTTP checks fail the workflow if key routes are unavailable or the live assets/deployment.json does not match the deployed Git commit. Deployments are an overlay, not atomic; a visitor can briefly see mixed assets during upload. HTTP failures do not automatically roll back.

## Before first production deployment

- Compare and back up the actual live directory, including any files not tracked here.
- Verify the PayPal button belongs to the business. The four current buttons share one existing hosted_button_id; no pricing was invented or payment made.
- Configure and verify the real inquiry mailbox. The current forms use the host’s existing local SMTP service. Delivery has not been verified.
- Rotate the old mailbox password previously hardcoded in the public repository. Removing it from current code does not remove it from Git history.
- Review the local redesign at desktop and mobile sizes.
- Confirm the host has room for a full document-root backup. Keep backups private and periodically remove only reviewed old releases.

## Source reconciliation and inquiry delivery

The public HTML was retrieved directly from the live site on October 6. The PHP handlers are based on the freshly fetched origin/main (e677d48), since an HTTP GET returns rendered HTML, not server-side source. After account recovery, download the actual PHP source and compare it before enabling deployment. Preserve any server-only settings and reconcile legitimate changes.

The six live service form routes retain their questionnaire wording, non-sensitive field names, and recipient `form@wesleyproctorenterprise.com`. They still use the existing host-local SMTP transport on port 25. The sender is now a domain-owned address, with the visitor address as Reply-To. Unused hardcoded password strings were removed. A real server-side send and inbox receipt are required before claiming delivery works. No real messages were sent during local testing. The nonprofit public form no longer collects or emails a Social Security number.

The old `send_form_mail.php` test-inbox handler and placeholder Stripe `success.php` are not used by the redesigned forms and are excluded from deployment. Existing remote copies are not deleted. They need a separate production cleanup after the live source is retrieved.

## Restore a backup

Disable GODADDY_DEPLOY_ENABLED and wait for any active deployment to finish. Download and inspect the selected private backup. Restore it to the confirmed document root using `tar -xzf ~/.wpe-deploy/RELEASE/before.tar.gz -C /home/USERNAME/DOCUMENT_ROOT`. This overlays the original files; files introduced by a release remain until individually reviewed and removed. Then verify HTTPS and the key pages. Do not extract a backup into an unverified path.

References: [GoDaddy SSH setup](https://www.godaddy.com/help/enable-ssh-for-my-web-hosting-cpanel-account-16102), [GitHub deployment environments and concurrency](https://docs.github.com/en/actions/how-tos/deploy/configure-and-manage-deployments/control-deployments).
