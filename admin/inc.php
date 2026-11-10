<?php
/* Shared code for the admin area: login check, CSRF protection, layout, uploads. */
require dirname(__DIR__) . '/inc/bootstrap.php';
require dirname(__DIR__) . '/inc/layout.php';

session_set_cookie_params(['httponly' => true, 'samesite' => 'Lax', 'secure' => !empty($_SERVER['HTTPS'])]);
session_name('kkkt_admin');
session_start();

function is_logged_in(): bool { return !empty($_SESSION['uid']); }
function require_login(): void { if (!is_logged_in()) { header('Location: login.php'); exit; } }
function me(): array { return q1('SELECT id, username, name FROM users WHERE id=?', [$_SESSION['uid'] ?? 0]) ?? []; }

function csrf_token(): string { if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32)); return $_SESSION['csrf']; }
function csrf_field(): string { return '<input type="hidden" name="csrf" value="' . e(csrf_token()) . '">'; }
function check_csrf(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !hash_equals($_SESSION['csrf'] ?? '', (string)($_POST['csrf'] ?? ''))) {
        http_response_code(400); exit('Fomu imeisha muda wake. Rudi nyuma, onyesha ukurasa upya (refresh) na ujaribu tena.');
    }
}
function flash(?string $msg = null, string $type = 'ok'): array {
    if ($msg !== null) { $_SESSION['flash'][] = [$type, $msg]; return []; }
    $f = $_SESSION['flash'] ?? []; unset($_SESSION['flash']); return $f;
}
function redirect(string $to): void { header('Location: ' . $to); exit; }

/** Save an uploaded image: checks it is a real JPG/PNG/WebP, shrinks it to $max px and stores it as JPG. Returns the stored path. */
function save_upload(array $file, string $subdir, int $max = 1600): string {
    global $CONFIG;
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) throw new RuntimeException('Picha haikupakiwa (kosa la ' . (int)($file['error'] ?? 0) . ').');
    if ($file['size'] > 15 * 1024 * 1024) throw new RuntimeException('Picha ni kubwa mno (zaidi ya MB 15).');
    $info = @getimagesize($file['tmp_name']);
    $types = [IMAGETYPE_JPEG => 'imagecreatefromjpeg', IMAGETYPE_PNG => 'imagecreatefrompng', IMAGETYPE_WEBP => 'imagecreatefromwebp'];
    if (!$info || !isset($types[$info[2]])) throw new RuntimeException('Faili si picha ya JPG, PNG au WebP.');
    $src = $types[$info[2]]($file['tmp_name']);
    if (!$src) throw new RuntimeException('Picha imeshindwa kusomeka.');
    if ($info[2] === IMAGETYPE_JPEG && function_exists('exif_read_data')) {           // turn phone photos upright
        $o = (int)(@exif_read_data($file['tmp_name'])['Orientation'] ?? 1);
        if ($o === 3) $src = imagerotate($src, 180, 0); elseif ($o === 6) $src = imagerotate($src, -90, 0); elseif ($o === 8) $src = imagerotate($src, 90, 0);
    }
    [$w, $h] = [imagesx($src), imagesy($src)];
    $scale = min(1, $max / max($w, $h));
    $nw = (int)round($w * $scale); $nh = (int)round($h * $scale);
    $dst = imagecreatetruecolor($nw, $nh);
    imagefill($dst, 0, 0, imagecolorallocate($dst, 255, 255, 255));
    imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
    $dir = rtrim($CONFIG['upload_dir'], '/') . '/' . $subdir;
    if (!is_dir($dir) && !mkdir($dir, 0755, true)) throw new RuntimeException('Folda ya picha haiwezi kuandikwa: ' . $subdir);
    $name = date('Ymd') . '-' . bin2hex(random_bytes(6)) . '.jpg';
    if (!imagejpeg($dst, $dir . '/' . $name, 84)) throw new RuntimeException('Picha imeshindwa kuhifadhiwa.');
    return rtrim($CONFIG['upload_url'], '/') . '/' . $subdir . '/' . $name;
}
/** Delete a previously uploaded file (only files inside the uploads folder). */
function delete_upload(string $path): void {
    global $CONFIG;
    $prefix = rtrim($CONFIG['upload_url'], '/') . '/';
    if (strpos($path, $prefix) !== 0 || str_contains($path, '..')) return;
    $full = rtrim($CONFIG['upload_dir'], '/') . '/' . substr($path, strlen($prefix));
    if (is_file($full)) @unlink($full);
}

function admin_start(string $title, string $active = ''): void {
    $nav = ['index.php' => 'Mwanzo', 'edit.php?t=announcements' => 'Matangazo', 'edit.php?t=notices' => 'Kumbukumbu', 'edit.php?t=hymn_boards' => 'Nyimbo', 'edit.php?t=events' => 'Matukio',
            'edit.php?t=sermons' => 'Mahubiri', 'edit.php?t=albums' => 'Picha', 'edit.php?t=leaders' => 'Uongozi', 'more.php' => 'Zaidi', 'settings.php' => 'Mipangilio'];
    ?><!DOCTYPE html>
<html lang="sw">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="robots" content="noindex">
<title><?= e($title) ?> · Utawala · KKKT Wazo</title>
<link rel="stylesheet" href="admin.css">
</head>
<body>
<header class="ad-top">
  <a class="ad-brand" href="index.php">KKKT Wazo <small>Utawala</small></a>
  <nav class="ad-nav"><?php foreach ($nav as $href => $label): ?><a href="<?= e($href) ?>"<?= $active === $href ? ' class="on"' : '' ?>><?= e($label) ?></a><?php endforeach; ?></nav>
  <div class="ad-user"><a href="../index.php" target="_blank" rel="noopener">Ona tovuti ↗</a><a href="password.php">Nenosiri</a><a href="logout.php">Toka</a></div>
</header>
<main class="ad-main">
<?php foreach (flash() as [$t, $m]): ?><div class="ad-flash <?= e($t) ?>"><?= e($m) ?></div><?php endforeach; ?>
<?php
}
function admin_end(): void { ?>
</main>
<script>
document.querySelectorAll('form[data-confirm]').forEach(function(f){f.addEventListener('submit',function(e){if(!confirm(f.getAttribute('data-confirm')))e.preventDefault()})});
</script>
</body>
</html>
<?php }
