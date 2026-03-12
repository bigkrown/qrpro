<?php
// User management class
require_once __DIR__ . '/db.php';
class User
{

    private $db;
    public function __construct()
    {

        if (session_status() === PHP_SESSION_NONE) {
            session_name(env('SESSION_NAME', 'qrmaker_pro_session'));
            session_set_cookie_params([
                'lifetime' => (int) env('SESSION_LIFETIME', 86400),
                'path'     => '/',
                'httponly' => true,
                'samesite' => 'Lax',
            ]);
            session_start();
        }

        $this->db = new database(); // Ensure DB is initialized for session handling
    }
  
    public function current_user(): ?array
    {
        if (empty($_SESSION['user_id'])) return null;
        $st = $this->db->db()->prepare('SELECT id, name, email FROM users WHERE id = ? LIMIT 1');
        $st->execute([$_SESSION['user_id']]);
        return $st->fetch() ?: null;
    }

    public function login(string $email, string $password): array
    {
        $st = $this->db->db()->prepare('SELECT * FROM users WHERE email = ? LIMIT 1');
        $st->execute([strtolower(trim($email))]);
        $user = $st->fetch();

        if (!$user || !password_verify($password, $user['password'])) {
            return ['ok' => false, 'error' => 'Invalid email or password.'];
        }

        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        return ['ok' => true];
    }

    public function register(string $name, string $email, string $password): array
    {
        $email = strtolower(trim($email));

        if (strlen(trim($name)) < 2)            return ['ok' => false, 'error' => 'Name must be at least 2 characters.'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return ['ok' => false, 'error' => 'Invalid email address.'];
        if (strlen($password) < 6)              return ['ok' => false, 'error' => 'Password must be at least 6 characters.'];

        $check = $this->db->db()->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
        $check->execute([$email]);
        if ($check->fetch()) return ['ok' => false, 'error' => 'Email already registered.'];

        $st = $this->db->db()->prepare('INSERT INTO users (name, email, password) VALUES (?, ?, ?)');
        $st->execute([trim($name), $email, password_hash($password, PASSWORD_BCRYPT)]);

        session_regenerate_id(true);
        $_SESSION['user_id'] = (int) $this->db->db()->lastInsertId();
        return ['ok' => true];
    }


    public function changePassword($current,$password){
        
    }

    public function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }
}
