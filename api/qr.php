<?php
/*
 * QR Pro - Advanced QR Code Generator
 * https://adesho.la
 * Author: Adeshola A. (https://adesho.la/
 *
 * Copyright (c) 2025 Adeshola
 * Licensed under the MIT License
 */
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/user.php';
class qr
{

    public function generate(): void
    {

        //get env variables
        $api_url = env('QR_API_URL');

        //restrict access to this address only
        header("Access-Control-Allow-Origin: " . $api_url);
        header("Access-Control-Allow-Credentials: true");

        $db = new database(); // Ensure DB is initialized for session handling
        $Auth = new User();

        if (!isset($_GET['action'])) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'Action required']);
            exit;
        }

        $action = $_GET['action'] ?? '';

        if ($action === 'proxy') {
            $data = (string)($_GET['data'] ?? '');
            $size = max(100, min(600, (int)($_GET['size'] ?? 300)));
            $fg   = preg_replace('/[^a-fA-F0-9]/', '', ltrim($_GET['fg'] ?? '000000', '#'));
            $bg   = preg_replace('/[^a-fA-F0-9]/', '', ltrim($_GET['bg'] ?? 'ffffff', '#'));
            $ecc  = in_array($_GET['ecc'] ?? 'M', ['L', 'M', 'Q', 'H']) ? $_GET['ecc'] : 'M';
            $api  = env('QR_API', 'https://api.qrserver.com/v1/create-qr-code');
            $margin = max(0, min(8, (int)($_GET['margin'] ?? 2)));
           // $padding = max(0, min(100, (int)($_GET['padding'] ?? 16)));
            $url  = "$api/?data=" . urlencode($data) . "&size={$size}x{$size}&color={$fg}&bgcolor={$bg}&ecc={$ecc}&format=png&margin={$margin}";

            $ch = curl_init($url);
            curl_setopt_array($ch, [CURLOPT_RETURNTRANSFER => true, CURLOPT_FOLLOWLOCATION => true, CURLOPT_TIMEOUT => 8]);
            $img = curl_exec($ch);
            $ct  = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
            curl_close($ch);

            if ($img) {
                header("Content-Type: $ct");
                header('Cache-Control: public, max-age=86400');
                echo $img;
            } else {
                header("Location: $url");
            }
            exit;
        }

        header('Content-Type: application/json');

        $user = $Auth->current_user();
        if (!$user) {
            http_response_code(401);
            echo json_encode(['ok' => false, 'error' => 'Not authenticated']);
            exit;
        }

        if ($action === 'save' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $b       = json_decode(file_get_contents('php://input'), true) ?? [];
            $label   = substr(trim($b['label']   ?? 'Untitled'), 0, 200);
            $content = trim($b['content'] ?? '');
            $tmpl    = preg_replace('/[^a-z_]/', '', $b['template'] ?? 'classic');
            $fg      = preg_replace('/[^#a-fA-F0-9]/', '', $b['fg'] ?? '#000000');
            $bg      = preg_replace('/[^#a-fA-F0-9]/', '', $b['bg'] ?? '#ffffff');
            $size    = max(100, min(600, (int)($b['size'] ?? 300)));
            $ecc     = in_array($b['ecc'] ?? 'M', ['L', 'M', 'Q', 'H']) ? $b['ecc'] : 'M';
            $qr_url  = trim($b['qr_url'] ?? '');

            if (!$content) {
                echo json_encode(['ok' => false, 'error' => 'Content required']);
                exit;
            }

            $st = $db->db()->prepare('INSERT INTO qrcodes (user_id,label,content,template,fg_color,bg_color,size,ecc,qr_url) VALUES (?,?,?,?,?,?,?,?,?)');
            $st->execute([$user['id'], $label, $content, $tmpl, $fg, $bg, $size, $ecc, $qr_url]);
            echo json_encode(['ok' => true, 'id' => (int)$db->db()->lastInsertId()]);
            exit;
        }

        if ($action === 'list') {
            $st = $db->db()->prepare('SELECT * FROM qrcodes WHERE user_id = ? ORDER BY created_at DESC');
            $st->execute([$user['id']]);
            echo json_encode(['ok' => true, 'data' => $st->fetchAll()]);
            exit;
        }

        if ($action === 'delete' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $b  = json_decode(file_get_contents('php://input'), true) ?? [];
            $id = (int)($b['id'] ?? 0);
            $st = $db->db()->prepare('DELETE FROM qrcodes WHERE id = ? AND user_id = ?');
            $st->execute([$id, $user['id']]);
            echo json_encode(['ok' => true]);
            exit;
        }

        if ($action === 'delete_all' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $st = $db->db()->prepare('DELETE FROM qrcodes WHERE user_id = ?');
            $st->execute([$user['id']]);
            echo json_encode(['ok' => true]);
            exit;
        }
        

        http_response_code(404);
        echo json_encode(['ok' => false, 'error' => 'Unknown action']);
    }
}

$qr = new qr();
$qr->generate();
