# QRMAKER PRO

**A self-hosted QR code generator with custom branding, templates, logo overlays, and a personal library.**

Built with plain PHP and vanilla JavaScript. No framework. No Composer. No build step. Drop it on any shared hosting and it works.

---

## Screenshots

> https://www.adesho.la/uploads/1773355147605-Screenshot_2026_03_12_223239.png

---

## Features

- **Live preview** — debounced 300ms preview updates as you type
- **6 templates** — Classic, Rounded, Sharp, Shadow, Bordered, Elegant
- **Colour controls** — 8 presets + custom foreground/background colour pickers with synced hex inputs
- **Padding** — adjustable quiet zone padding (0–80px)
- **Output resolution** — 100px up to 2000px for print-quality exports
- **Logo overlay** — upload PNG, SVG, or JPG with configurable size and background style
- **6 content types** — URL, Email, Phone, SMS, WiFi, Text
- **Export formats** — PNG (custom size), SVG, PDF (A4 / Letter / square), browser print
- **User accounts** — register, login, saved library, change name/password
- **Settings** — default template, size, ECC level persisted to localStorage
- **Security** — Apache `.htaccess` with hotlink protection, security headers, dotfile blocking, attack signature filtering

---

## Requirements

| Requirement | Notes |
|---|---|
| PHP | 7.4 or higher |
| Extensions | `pdo_sqlite`, `curl` (standard on most hosts) |
| Web server | Apache (for `.htaccess`) or PHP built-in server for local dev |

---

## Quick Start

```bash
# 1. Clone the repo
git clone https://github.com/bigkrown/qrpro.git
cd qrpro

# 2. The .env is already included and works out of the box.
#    Edit it if you want to change APP_NAME or APP_URL.

# 3. Start the PHP built-in server
php -S localhost:8080
```

Open `http://localhost:8080` — the SQLite database is created automatically on first load.

---

## Deployment

### Shared Hosting (cPanel, Plesk, etc.)

1. Upload the entire `qrpro/` folder to your `public_html` directory (or a subdirectory)
2. Make sure `storage/` is writable by the web server: `chmod 755 storage/`
3. Edit `.env` — set `APP_URL` to your domain and `APP_ENV=production`, `APP_DEBUG=false`
4. Visit your URL — the database creates itself on first request

### Apache VirtualHost

```apache
<VirtualHost *:80>
    ServerName qrpro.yourdomain.com
    DocumentRoot /var/www/qrpro
    <Directory /var/www/qrpro>
        AllowOverride All
        Require all granted
    </Directory>
</VirtualHost>
```

> Enable `mod_rewrite` and `mod_headers` for full `.htaccess` support:
> ```bash
> sudo a2enmod rewrite headers expires
> sudo systemctl restart apache2
> ```

### Nginx

Nginx does not read `.htaccess`. Replicate the rules in your server block:

```nginx
server {
    listen 80;
    server_name qrpro.yourdomain.com;
    root /var/www/qrpro;
    index index.php;

    # Block sensitive paths
    location ~ ^/(\.env|storage|includes) {
        deny all;
        return 403;
    }

    # PHP
    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # SPA fallback
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }
}
```

---

## Configuration

All config lives in `.env` at the project root.

```env
APP_NAME="QRMAKER PRO"       # Display name shown in the browser tab and nav
APP_ENV=production        # development | production
APP_DEBUG=false           # true = PHP errors shown; false = errors suppressed
APP_URL=https://yourdomain.com

SESSION_NAME=qrpro_session
SESSION_LIFETIME=86400    # Session duration in seconds (default: 24 hours)

QR_API=https://api.qrserver.com/v1/create-qr-code  # QR generation API (free, no key required)
```

> **Never commit `.env` to version control.** It is listed in `.gitignore` by default. The `.env.example` file is safe to commit.

---

## Project Structure

```
qrpro/
├── .env                    ← Local config (gitignored)
├── .env.example            ← Config template (safe to commit)
├── .gitignore
├── .htaccess               ← Apache security: hotlinks, headers, dotfile blocking
├── index.php               ← Entire frontend SPA + PHP bootstrap
├── README.md
│
├── api/
│   ├── auth.php            ← login / register / logout / me / update_name / change_password
│   └── qr.php              ← QR proxy + save / list / delete / delete_all
│
├── includes/
│   ├── .htaccess           ← Blocks direct web access to source files
│   ├── env.php             ← .env loader + env() helper
│   ├── db.php              ← SQLite PDO singleton, auto-creates schema
│   └── auth.php            ← Session auth functions
│
└── storage/
    ├── .gitkeep
    ├── .htaccess           ← Blocks all web access + disables PHP execution
    └── qrpro.db          ← SQLite database (auto-created, gitignored)
```

---

## API Endpoints

### Authentication — `api/auth.php`

| Action | Method | Body | Description |
|---|---|---|---|
| `login` | POST | `{email, password}` | Sign in, returns user object |
| `register` | POST | `{name, email, password}` | Create account |
| `logout` | GET | — | Destroy session |
| `me` | GET | — | Returns current user or `{ok: false}` |
| `update_name` | POST | `{name}` | Update display name |
| `change_password` | POST | `{current, password}` | Change password |

### QR Codes — `api/qr.php`

| Action | Method | Params / Body | Description |
|---|---|---|---|
| `proxy` | GET | `data, size, fg, bg, ecc, margin` | Proxy to QR API, returns `image/png` |
| `save` | POST | `{label, content, template, fg, bg, size, ecc, qr_url}` | Save QR to library |
| `list` | GET | — | List saved QR codes for current user |
| `delete` | POST | `{id}` | Delete one QR code |
| `delete_all` | POST | — | Delete entire library |

---

## Database Schema

```sql
CREATE TABLE users (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    name       TEXT    NOT NULL,
    email      TEXT    NOT NULL UNIQUE,
    password   TEXT    NOT NULL,              -- bcrypt hash
    created_at TEXT    NOT NULL DEFAULT (datetime('now'))
);

CREATE TABLE qrcodes (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id    INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
    label      TEXT    NOT NULL DEFAULT 'Untitled',
    content    TEXT    NOT NULL,
    template   TEXT    NOT NULL DEFAULT 'classic',
    fg_color   TEXT    NOT NULL DEFAULT '#000000',
    bg_color   TEXT    NOT NULL DEFAULT '#ffffff',
    size       INTEGER NOT NULL DEFAULT 300,
    ecc        TEXT    NOT NULL DEFAULT 'M',
    qr_url     TEXT    NOT NULL,              -- base64 PNG data URI
    created_at TEXT    NOT NULL DEFAULT (datetime('now'))
);
```

The schema is created automatically by `includes/db.php` on first connection. There are no migrations to run.

---

## Security

The root `.htaccess` provides multiple layers of protection:

| Protection | Detail |
|---|---|
| Dotfile blocking | `.env`, `.git`, and all dotfiles return 403 |
| Directory blocking | `includes/` and `storage/` denied at rewrite level |
| Hotlink protection | Images only load from your own domain |
| Security headers | `X-Frame-Options`, `X-Content-Type-Options`, `CSP`, `Referrer-Policy`, `Permissions-Policy` |
| API cache prevention | All `/api/` responses are `no-store, no-cache` |
| Attack filtering | SQL injection, path traversal (`../`), null bytes blocked |
| Method restriction | Only GET, POST, HEAD, OPTIONS permitted |
| Fingerprint stripping | `X-Powered-By` and `Server` headers removed |

`storage/.htaccess` additionally disables PHP execution inside the storage directory.

---

## How It Works

QRPRO is a single-page app with hash-based routing (`#home`, `#generate`, `#saved`, `#settings`, `#about`). There are no page reloads.

**QR generation** goes through a PHP proxy (`api/qr.php?action=proxy`) to avoid browser CORS issues with the external QR API. All parameters are validated and sanitised before forwarding.

**Canvas rendering** powers everything visual. The live preview, logo compositing, and all export formats (PNG, SVG, PDF, print) are built from the same `buildFullCanvas()` function — what you see in the preview is exactly what gets exported.

**Auth** uses bcrypt-hashed passwords and PHP sessions. `session_regenerate_id(true)` is called on login and registration to prevent session fixation attacks.

**Preferences** (default template, size, ECC) are stored in `localStorage` under the key `qrmaker_pro_prefs` and applied on every page load — no database round-trip needed.

---

## Local Development

```bash
# Start dev server
php -S localhost:8080

# View PHP errors (already on in default .env)
php -S localhost:8080 2>&1

# Inspect the database
sqlite3 storage/qrmaker_pro.db ".tables"
sqlite3 storage/qrmaker_pro.db "SELECT id, name, email FROM users;"

# Reset everything
rm storage/qrmaker_pro.db
```

---

## Contributing

Pull requests are welcome. For large changes, open an issue first.

1. Fork the repo
2. Create a branch: `git checkout -b feature/my-feature`
3. Commit your changes
4. Push and open a pull request

Please keep the zero-dependency philosophy intact — no Composer packages, no npm build steps.

---

## License

MIT — see [LICENSE](LICENSE) for details.

---

Built by [Shola Adewale](https://adesho.la)
