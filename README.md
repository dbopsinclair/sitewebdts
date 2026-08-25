# Elite-US Website

Source code for the Elite-US corporate website (formerly Dynamic Technologie Systems).

## Main files

- `index.html` — public website
- `assets/i18n/fr.json` — French translations
- `assets/i18n/en.json` — English translations
- `send_email.php` — contact form endpoint
- `image_descriptif.png` — website image asset

## Local execution (XAMPP)

Place the repository in the XAMPP `htdocs` directory and open it through Apache, for example:

`http://localhost/sitewebelite-us/`

The contact form requires PHP mail configuration on the server.

## Repository hygiene

Local editor history folders (`.history`, `.lh`) are intentionally excluded from version control. Environment files and local secrets must not be committed.

## Development workflow

Changes should be prepared on feature branches, reviewed, then merged into `main` after validation.
