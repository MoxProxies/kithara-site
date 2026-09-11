# Kithara marketing site

Laravel 13 site for Kithara, the Android audiobook player: landing page, contact form, Terms & Conditions and Privacy Policy.

## Pages

| Route      | View                                | Notes                                       |
|------------|-------------------------------------|---------------------------------------------|
| `/`        | `resources/views/home.blade.php`    | Landing page                                |
| `/contact` | `resources/views/contact.blade.php` | Form → `ContactController` → `ContactMessage` mailable |
| `/terms`   | `resources/views/legal/terms.blade.php`   | Uses the shared `layouts/legal` chrome |
| `/privacy` | `resources/views/legal/privacy.blade.php` | Uses the shared `layouts/legal` chrome |
| `/pro`, `/audiobookshelf`, `/transcripts`, `/formats`, `/android-auto`, `/sync-protocol` | `resources/views/guides/` | One page per search intent, on the shared `layouts/guide` chrome with breadcrumb schema |
| `/changelog`, `/changelog.xml` | `guides/changelog.blade.php`, `crawlers/changelog-feed.blade.php` | Both read `resources/changelog/releases.php` |
| `/how-to/...` | `resources/views/howto/` | How-to articles with HowTo schema; every ffmpeg command was run against a generated file before publishing |
| `/compare/...` | `resources/views/compare/` | Comparison pages against Smart AudioBook Player, the Audiobookshelf app and Audible |
| `/sitemap.xml`, `/robots.txt`, `/llms.txt` | `resources/views/crawlers/` | Generated, so they carry the deployed host |

Styles live in `resources/css/app.css` (plain CSS, no Tailwind) and are bundled by Vite.

## Local development

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
npm run build      # or `npm run dev` for hot reload
php artisan serve
```

Contact form emails go to the log (`storage/logs/laravel.log`) by default (`MAIL_MAILER=log`).

Run the tests with `php artisan test`.

## Site settings (`.env`)

All company-specific details are read from `.env` via `config/kithara.php`, so nothing needs editing in the views:

```dotenv
KITHARA_COMPANY_NAME="Charitou Multimedia Solutions Inc."  # legal entity shown in T&Cs, privacy, footer
KITHARA_COMPANY_ADDRESS=                            # optional; leave empty until you have a real mailing address
KITHARA_PROVINCE=Ontario                            # province whose law governs the T&Cs
KITHARA_SUPPORT_EMAIL=support@example.com           # public support address
KITHARA_CONTACT_TO=hello@example.com                # where contact form submissions are sent
KITHARA_PLAY_LIVE=false                             # false: "coming soon" pills instead of store buttons
KITHARA_PLAY_STORE_URL=#                            # Google Play link, used once KITHARA_PLAY_LIVE=true
```

The "Last updated" date on the legal pages is set in `config/kithara.php`.

## SEO and structured data

- `resources/views/partials/schema.blade.php`: Organization, WebSite and SoftwareApplication JSON-LD on every page. The Play Store `installUrl` appears once `KITHARA_PLAY_LIVE=true`.
- `resources/views/partials/faq.blade.php`: the FAQ section and its `FAQPage` JSON-LD come from one array. Edit the questions there and both update.
- `resources/docs/sync-protocol.md` is the site copy of the app repo's `docs/kithara-sync-protocol.md`, rendered with `Str::markdown()`. Re-copy it when the spec changes.
- `public/img/og.png` is the 1200x630 share image, cropped from the Play feature graphic in the app repo (`store/feature-graphic-1024x500.png`).
- Fonts are self-hosted from `resources/fonts/` (woff2, Latin subset) through the Vite plugin's `local()` provider in `vite.config.js`, so no visitor data goes to a font CDN and the build needs no network. Only the above-the-fold weights are preloaded.
- After the first deploy, submit `https://kithara-app.com/sitemap.xml` in Google Search Console and Bing Webmaster Tools, and set `expose_php = Off` in Forge's PHP settings to drop the `X-Powered-By` header.

## Deploying on Laravel Forge

The site needs no database. Sessions and cache use the `file` driver, the contact form sends mail synchronously, and there are no migrations.

1. **Create the site** on your Forge server (PHP 8.4, project type "Laravel"), pointing the web directory at `/public`.
2. **Connect the repository** and enable Quick Deploy. Use this deploy script. It differs from the Forge default in two ways: it builds the Vite assets, and it does **not** run `php artisan migrate` (the shared `forge` database on a Forge server often already holds another site's tables, which makes the default migrate step fail):

   ```bash
   cd /home/forge/your-site.com
   git pull origin $FORGE_SITE_BRANCH
   $FORGE_COMPOSER install --no-dev --no-interaction --prefer-dist --optimize-autoloader
   npm ci && npm run build
   ( flock -w 10 9 || exit 1
       echo 'Restarting FPM...'; sudo -S service $FORGE_PHP_FPM reload ) 9>/tmp/fpmlock
   $FORGE_PHP artisan optimize
   ```

3. **Environment**: in the site's *Environment* tab, set at least:

   ```dotenv
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://your-site.com
   APP_KEY=                 # run `php artisan key:generate --show` locally and paste
   SESSION_DRIVER=file
   CACHE_STORE=file
   QUEUE_CONNECTION=sync
   ```

   plus the `KITHARA_*` values above.

4. **Mail**: configure a real mailer so contact submissions are delivered, e.g. for Postmark / Resend / SES / SMTP:

   ```dotenv
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.postmarkapp.com
   MAIL_PORT=587
   MAIL_USERNAME=...
   MAIL_PASSWORD=...
   MAIL_FROM_ADDRESS=noreply@your-site.com
   MAIL_FROM_NAME="Kithara"
   ```

   `MAIL_FROM_ADDRESS` should be on a domain you've verified with your mail provider; replies go to the sender via `Reply-To`.

5. **SSL**: issue a Let's Encrypt certificate from the site's *SSL* tab.

The contact and notify-me endpoints are rate-limited to 5 submissions per minute per IP and have a honeypot field to deter bots.

## Releasing a new version

Add an entry to the top of `resources/changelog/releases.php` (version, date, status, summary, changes). The changelog page, the RSS feed and the `softwareVersion` in the structured data pick it up on deploy. Set `status` to `released` and fill in `date` when the build is live on Google Play; until then it shows as "coming soon" with no date.

## Launch day

While `KITHARA_PLAY_LIVE=false`, the download band collects email addresses into `storage/app/private/notify-list.csv`. When the Play listing is approved:

1. Set `KITHARA_PLAY_LIVE=true` and the real `KITHARA_PLAY_STORE_URL` in Forge, then deploy.
2. Check the email looks right: `php artisan kithara:announce-launch --preview=you@example.com`
3. See who is on the list: `php artisan kithara:announce-launch --dry-run`
4. Send it: `php artisan kithara:announce-launch` (add `--force` to skip the prompt).

A clean run deletes the list, which is what the privacy policy promises. If any sends fail, only those addresses are kept and a second run retries them. Brevo's free tier caps at 300 emails a day; split a bigger list across days by running the command again the next day.
