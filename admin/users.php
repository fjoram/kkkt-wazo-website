<?php
require __DIR__ . '/inc.php';
require_login(); check_csrf();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        if ((int)$_POST['delete'] === (int)$_SESSION['uid']) flash('Huwezi kujifuta mwenyewe.', 'err');
        else { run('DELETE FROM users WHERE id=?', [(int)$_POST['delete']]); flash('Mtumiaji amefutwa.'); }
    } else {
        $u = trim((string)($_POST['username'] ?? '')); $p = (string)($_POST['password'] ?? '');
        if (strlen($u) < 3 || strlen($p) < 8) flash('Jina liwe na herufi 3+, nenosiri herufi 8+.', 'err');
        elseif (q1('SELECT id FROM users WHERE username=?', [$u])) flash('Jina hilo tayari linatumika.', 'err');
        else { run('INSERT INTO users (username, name, password_hash) VALUES (?,?,?)', [$u, trim((string)($_POST['name'] ?? '')), password_hash($p, PASSWORD_DEFAULT)]); flash('Mtumiaji ameongezwa.'); }
    }
    redirect('users.php');
}
admin_start('Watumiaji', 'more.php');
?>
<div class="ad-head"><h1>Watumiaji</h1><a class="ad-btn" href="more.php">← Rudi</a></div>
<div class="ad-card ad-table-wrap"><table class="ad-table"><thead><tr><th>Jina</th><th>Jina la mtumiaji</th><th></th></tr></thead><tbody>
<?php foreach (q('SELECT * FROM users ORDER BY id') as $u): ?>
<tr><td><?= e($u['name']) ?></td><td><?= e($u['username']) ?></td><td class="actions"><?php if ((int)$u['id'] !== (int)$_SESSION['uid']): ?><form method="post" data-confirm="Futa mtumiaji huyu?"><?= csrf_field() ?><input type="hidden" name="delete" value="<?= (int)$u['id'] ?>"><button class="ad-btn danger">Futa</button></form><?php else: ?><span class="muted">Wewe</span><?php endif; ?></td></tr>
<?php endforeach; ?>
</tbody></table></div>
<form method="post" class="ad-card ad-form narrow"><?= csrf_field() ?><h2>Ongeza mtumiaji</h2>
  <label>Jina<input name="name"></label><label>Jina la mtumiaji<input name="username" required></label>
  <label>Nenosiri<input type="password" name="password" required autocomplete="new-password"><small>Angalau herufi 8. Mpe mtumiaji, kisha abadilishe.</small></label>
  <button class="ad-btn primary">Ongeza</button></form>
<?php admin_end();
