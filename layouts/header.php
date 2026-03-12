<?php
require_once __DIR__ . '../../config.php';
require_once __DIR__ . '../../includes/user.php';
$appName = env('APP_NAME','QR Maker Pro');
$user    = null;
try { $user = (new User())->current_user(); } catch (Throwable $e) { error_log('QRMaker Pro:'.$e->getMessage()); }
$userJson = $user ? json_encode(['id'=>$user['id'],'name'=>$user['name'],'email'=>$user['email']]) : 'null';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($appName) ?> — Beautiful QR Codes</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Fraunces:opsz,wght@9..144,700;9..144,900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style.css">
<style>

</style>
</head>
<body>

<div class="loader" id="loader"><div class="spinner" style="width:34px;height:34px;border-width:4px"></div></div>
<div class="toast-wrap" id="toasts"></div>
<div class="modal-bg hidden" id="modal-bg"><div class="modal" id="modal"></div></div>