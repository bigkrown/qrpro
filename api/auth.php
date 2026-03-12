<?php
require_once __DIR__ . '/../includes/db.php';
require_once dirname(__DIR__) . '/includes/user.php';
class auth
{
    private $db;
    private $auth;
    public function makeAuth()
    {
        $api_url = env('API_URL', '*');
        header("Access-Control-Allow-Origin: " . $api_url);
        header("Access-Control-Allow-Credentials: true");
        header('Content-Type: application/json');

        $this->db = new database();
        $this->auth = new User();

        $action = $_GET['action'] ?? '';

        if ($action === 'logout') {
            $this->auth->logout();
            echo json_encode(['ok' => true]);
            exit;
        }

        if ($action === 'me') {
            $u = $this->auth->current_user();
            echo json_encode($u ? ['ok' => true, 'user' => $u] : ['ok' => false]);
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['ok' => false, 'error' => 'POST required']);
            exit;
        }

        $body = json_decode(file_get_contents('php://input'), true) ?? [];

        if ($action === 'login') {
            $result = $this->auth->login($body['email'] ?? '', $body['password'] ?? '');
            if ($result['ok']) $result['user'] = $this->auth->current_user();
            echo json_encode($result);
            exit;
        }

        if ($action === 'register') {
            $result = $this->auth->register($body['name'] ?? '', $body['email'] ?? '', $body['password'] ?? '');
            if ($result['ok']) $result['user'] = $this->auth->current_user();
            echo json_encode($result);
            exit;
        }

        // Remaining actions require auth
        $user = $this->auth->current_user();
        if (!$user) {
            http_response_code(401);
            echo json_encode(['ok' => false, 'error' => 'Not authenticated']);
            exit;
        }

        if ($action === 'update_name') {
            $name = trim($body['name'] ?? '');
            if (strlen($name) < 2) {
                echo json_encode(['ok' => false, 'error' => 'Name too short']);
                exit;
            }
            $st = $this->db->db()->prepare('UPDATE users SET name = ? WHERE id = ?');
            $st->execute([substr($name, 0, 100), $user['id']]);
            echo json_encode(['ok' => true]);
            exit;
        }

        if ($action === 'change_password') {
            $current  = $body['current']  ?? '';
            $password = $body['password'] ?? '';
            if (strlen($password) < 6) {
                echo json_encode(['ok' => false, 'error' => 'New password must be at least 6 characters']);
                exit;
            }
            $st = $this->db->db()->prepare('SELECT password FROM users WHERE id = ?');
            $st->execute([$user['id']]);
            $row = $st->fetch();
            if (!$row || !password_verify($current, $row['password'])) {
                echo json_encode(['ok' => false, 'error' => 'Current password is incorrect']);
                exit;
            }
            $st2 = $this->db->db()->prepare('UPDATE users SET password = ? WHERE id = ?');
            $st2->execute([password_hash($password, PASSWORD_BCRYPT), $user['id']]);
            echo json_encode(['ok' => true]);
            exit;
        }

        http_response_code(404);
        echo json_encode(['ok' => false, 'error' => 'Unknown action']);
    }
}

$auth = new auth();
$auth->makeAuth();
