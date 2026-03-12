# QR Maker Pro

QR code generator with user accounts, templates, and saved library.

**Stack:** PHP 7.4+ · SQLite · Vanilla JS

---

## Setup

```
qr_amker_pro/
├── .env               ← your config (copy from .env.example)
├── index.php          ← the app
├── includes/
│   ├── env.php        ← .env loader
│   ├── db.php         ← SQLite connection + auto schema
│   └── auth.php       ← login / register / logout
|   |
│   └── bootstrap.php  ← bootstrap
├── api/
│   ├── auth.php       ← auth endpoint
│   └── qr.php         ← QR proxy + save/list/delete
└── storage/           ← auto-created, holds qrmaker_pro.db
```

--
**Demo**

**1. Copy the env file**
```bash
cp .env.example .env
```

**2. Edit `.env`** — change `APP_NAME` if you like, everything else works as-is.

**3. Drop the folder on any PHP host** (shared hosting, XAMPP, MAMP, Laragon, etc.)

That's it. The SQLite database is created automatically at `storage/qrmaker_pro.db` on first load.

---

## Requirements

- PHP 7.4+ with `pdo_sqlite` and `curl` extensions (standard on most hosts)
- A web server that can serve PHP files

## Local dev

```bash
php -S localhost:8080
```
Open `http://localhost:8080`


---

**Author:**
Shola Adewale
https://adesho.la
