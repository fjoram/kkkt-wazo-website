<?php
require __DIR__ . '/inc.php';
check_csrf();
$firstRun = (int)(q1('SELECT COUNT(*) c FROM users')['c'] ?? 0) === 0;
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim((string)($_POST['username'] ?? '')); $p = (string)($_POST['password'] ?? '');
    if ($firstRun) {
        if (strlen($u) < 3 || strlen($p) < 8) $error = 'Jina liwe na herufi 3 au zaidi, na nenosiri herufi 8 au zaidi.';
        elseif ($p !== ($_POST['password2'] ?? '')) $error = 'Nenosiri mbili hazilingani.';
        else {
            run('INSERT INTO users (username, name, password_hash) VALUES (?,?,?)', [$u, trim((string)($_POST['name'] ?? '')), password_hash($p, PASSWORD_DEFAULT)]);
            session_regenerate_id(true); $_SESSION['uid'] = (int)db()->lastInsertId();
            flash('Karibu! Akaunti ya msimamizi imeundwa.'); redirect('index.php');
        }
    } else {
        $row = q1('SELECT * FROM users WHERE username=?', [$u]);
        if ($row && password_verify($p, $row['password_hash'])) {
            session_regenerate_id(true); $_SESSION['uid'] = (int)$row['id']; redirect('index.php');
        }
        usleep(800000); $error = 'Jina au nenosiri si sahihi.';
    }
}
?><!DOCTYPE html>
<html lang="sw"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="robots" content="noindex">
<title>Ingia · Utawala · KKKT Wazo</title><link rel="stylesheet" href="admin.css"></head>
<body class="ad-login">
<form method="post" class="ad-card login-card">
  <?= csrf_field() ?>
  <div class="login-mark">✝</div>
  <h1>KKKT Usharika wa Wazo</h1>
  <p class="muted"><?= $firstRun ? 'Unda akaunti ya kwanza ya msimamizi wa tovuti.' : 'Ingia kusimamia tovuti.' ?></p>
  <?php if ($error): ?><div class="ad-flash err"><?= e($error) ?></div><?php endif; ?>
  <?php if ($firstRun): ?><label>Jina lako<input name="name" autocomplete="name"></label><?php endif; ?>
  <label>Jina la mtumiaji<input name="username" required autocomplete="username" value="<?= e($_POST['username'] ?? '') ?>"></label>
  <label>Nenosiri<input type="password" name="password" required autocomplete="<?= $firstRun ? 'new-password' : 'current-password' ?>"></label>
  <?php if ($firstRun): ?><label>Rudia nenosiri<input type="password" name="password2" required autocomplete="new-password"></label><?php endif; ?>
  <button class="ad-btn primary" type="submit"><?= $firstRun ? 'Unda akaunti' : 'Ingia' ?></button>
</form>
</body></html>
