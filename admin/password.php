<?php
require __DIR__ . '/inc.php';
require_login(); check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $row = q1('SELECT * FROM users WHERE id=?', [$_SESSION['uid']]);
    $new = (string)($_POST['new'] ?? '');
    if (!$row || !password_verify((string)($_POST['current'] ?? ''), $row['password_hash'])) flash('Nenosiri la sasa si sahihi.', 'err');
    elseif (strlen($new) < 8) flash('Nenosiri jipya liwe na herufi 8 au zaidi.', 'err');
    elseif ($new !== ($_POST['new2'] ?? '')) flash('Nenosiri mpya hazilingani.', 'err');
    else { run('UPDATE users SET password_hash=? WHERE id=?', [password_hash($new, PASSWORD_DEFAULT), $row['id']]); flash('Nenosiri limebadilishwa.'); }
    redirect('password.php');
}
admin_start('Nenosiri');
?>
<h1>Badilisha nenosiri</h1>
<form method="post" class="ad-card ad-form narrow">
  <?= csrf_field() ?>
  <label>Nenosiri la sasa<input type="password" name="current" required autocomplete="current-password"></label>
  <label>Nenosiri jipya<input type="password" name="new" required autocomplete="new-password"><small>Angalau herufi 8.</small></label>
  <label>Rudia nenosiri jipya<input type="password" name="new2" required autocomplete="new-password"></label>
  <button class="ad-btn primary">Hifadhi</button>
</form>
<?php admin_end();
