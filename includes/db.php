<?php
require_once __DIR__ . '/env.php';

class database
{
    public function db(): PDO
    {
        static $pdo = null;
        if ($pdo !== null) return $pdo;

        $storageDir = dirname(__DIR__) . '/storage';
        if (!is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }
        $path = $storageDir . '/qrmaker_pro.db';

        $pdo = new PDO('sqlite:' . $path, null, null, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        // Enable WAL mode for better concurrency
        $pdo->exec('PRAGMA journal_mode=WAL');
        $pdo->exec('PRAGMA foreign_keys=ON');

        // Create tables if they don't exist yet
        $pdo->exec("
            CREATE TABLE IF NOT EXISTS users (
                id         INTEGER PRIMARY KEY AUTOINCREMENT,
                name       TEXT    NOT NULL,
                email      TEXT    NOT NULL UNIQUE,
                password   TEXT    NOT NULL,
                created_at TEXT    NOT NULL DEFAULT (datetime('now'))
            );

            CREATE TABLE IF NOT EXISTS qrcodes (
                id         INTEGER PRIMARY KEY AUTOINCREMENT,
                user_id    INTEGER NOT NULL REFERENCES users(id) ON DELETE CASCADE,
                label      TEXT    NOT NULL DEFAULT 'Untitled',
                content    TEXT    NOT NULL,
                template   TEXT    NOT NULL DEFAULT 'classic',
                fg_color   TEXT    NOT NULL DEFAULT '#000000',
                bg_color   TEXT    NOT NULL DEFAULT '#ffffff',
                size       INTEGER NOT NULL DEFAULT 300,
                ecc        TEXT    NOT NULL DEFAULT 'M',
                qr_url     TEXT    NOT NULL,
                created_at TEXT    NOT NULL DEFAULT (datetime('now'))
            );
        ");

        return $pdo;
    }
}
