<?php
require __DIR__ . '/inc.php';
require_login(); check_csrf();
$aid = (int)($_GET['album'] ?? 0);
$album = q1('SELECT * FROM albums WHERE id=?', [$aid]);
if (!$album) { http_response_code(404); exit('Albamu haipo.'); }
$self = 'photos.php?album=' . $aid;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $act = $_POST['act'] ?? '';
    if ($act === 'upload') {
        $files = $_FILES['photos'] ?? null; $ok = 0;
        $next = (int)(q1('SELECT COALESCE(MAX(sort),0) m FROM photos WHERE album_id=?', [$aid])['m']) + 1;
        if ($files && is_array($files['name'])) {
            foreach ($files['name'] as $i => $n) {
                if ($n === '') continue;
                $f = ['name' => $n, 'tmp_name' => $files['tmp_name'][$i], 'error' => $files['error'][$i], 'size' => $files['size'][$i]];
                try { $path = save_upload($f, 'albums/' . $aid); run('INSERT INTO photos (album_id, path, sort) VALUES (?,?,?)', [$aid, $path, $next++]); $ok++; }
                catch (RuntimeException $ex) { flash($n . ': ' . $ex->getMessage(), 'err'); }
            }
        }
        if ($ok) flash("Picha $ok zimepakiwa.");
        // remove sample frames once real photos exist
        if ($ok && !empty($_POST['drop_samples'])) run("DELETE FROM photos WHERE album_id=? AND path LIKE 'ikoni:%'", [$aid]);
    } elseif ($act === 'save') {
        foreach ((array)($_POST['cap_sw'] ?? []) as $pid => $v) {
            run('UPDATE photos SET caption_sw=?, caption_en=?, sort=? WHERE id=? AND album_id=?',
                [trim((string)$v), trim((string)($_POST['cap_en'][$pid] ?? '')), (int)($_POST['sort'][$pid] ?? 0), (int)$pid, $aid]);
        }
        flash('Maelezo ya picha yamehifadhiwa.');
    } elseif ($act === 'delete') {
        $p = q1('SELECT * FROM photos WHERE id=? AND album_id=?', [(int)$_POST['pid'], $aid]);
        if ($p) { delete_upload($p['path']); run('DELETE FROM photos WHERE id=?', [$p['id']]); flash('Picha imefutwa.'); }
    } elseif ($act === 'cover') {
        $min = (int)(q1('SELECT COALESCE(MIN(sort),0) m FROM photos WHERE album_id=?', [$aid])['m']) - 1;
        run('UPDATE photos SET sort=? WHERE id=? AND album_id=?', [$min, (int)$_POST['pid'], $aid]);
        flash('Jalada limebadilishwa.');
    }
    redirect($self);
}
$photos = q('SELECT * FROM photos WHERE album_id=? ORDER BY sort, id', [$aid]);
$samples = count(array_filter($photos, fn($p) => str_starts_with($p['path'], 'ikoni:')));
admin_start('Picha · ' . $album['title_sw'], 'edit.php?t=albums');
?>
<div class="ad-head"><h1><?= e($album['title_sw']) ?> <small class="muted"><?= e(dshort($album['album_date'])) ?></small></h1><a class="ad-btn" href="edit.php?t=albums">← Albamu zote</a></div>

<form method="post" enctype="multipart/form-data" class="ad-card upload-box">
  <?= csrf_field() ?><input type="hidden" name="act" value="upload">
  <h2>Pakia picha</h2>
  <p class="muted">Chagua picha moja au nyingi (JPG, PNG au WebP). Zitapunguzwa ukubwa zenyewe ili tovuti iwe nyepesi.</p>
  <input type="file" name="photos[]" multiple accept="image/jpeg,image/png,image/webp" required>
  <?php if ($samples): ?><label class="check"><input type="checkbox" name="drop_samples" value="1" checked> Ondoa fremu <?= $samples ?> za mfano baada ya kupakia</label><?php endif; ?>
  <button class="ad-btn primary">Pakia</button>
</form>

<?php if ($photos): ?>
<form method="post" class="ad-card" id="capform">
  <?= csrf_field() ?><input type="hidden" name="act" value="save">
  <div class="ad-head sm"><h2>Picha <?= count($photos) ?></h2><button class="ad-btn primary">Hifadhi maelezo</button></div>
  <p class="muted">Picha ya kwanza ndiyo jalada la albamu. Namba ya mpangilio: ndogo huja kwanza.</p>
  <div class="ph-grid">
  <?php foreach ($photos as $i => $p): $sample = str_starts_with($p['path'], 'ikoni:'); ?>
    <div class="ph-item<?= $i === 0 ? ' cover' : '' ?>">
      <div class="ph-img"><?= $sample ? '<span class="sample">Fremu ya mfano</span>' : '<img src="../' . e($p['path']) . '" alt="" loading="lazy">' ?><?= $i === 0 ? '<span class="badge">Jalada</span>' : '' ?></div>
      <input name="cap_sw[<?= (int)$p['id'] ?>]" value="<?= e($p['caption_sw']) ?>" placeholder="Maelezo (si lazima)">
      <input name="cap_en[<?= (int)$p['id'] ?>]" value="<?= e($p['caption_en']) ?>" placeholder="Caption in English (optional)">
      <div class="ph-row">
        <label class="sm">Mpangilio <input type="number" name="sort[<?= (int)$p['id'] ?>]" value="<?= (int)$p['sort'] ?>"></label>
        <?php if ($i !== 0): ?><button class="ad-btn sm" form="f-cover-<?= (int)$p['id'] ?>">Fanya jalada</button><?php endif; ?>
        <button class="ad-btn sm danger" form="f-del-<?= (int)$p['id'] ?>">Futa</button>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</form>
<?php foreach ($photos as $p): ?>
<form method="post" id="f-del-<?= (int)$p['id'] ?>" data-confirm="Futa picha hii?"><?= csrf_field() ?><input type="hidden" name="act" value="delete"><input type="hidden" name="pid" value="<?= (int)$p['id'] ?>"></form>
<form method="post" id="f-cover-<?= (int)$p['id'] ?>"><?= csrf_field() ?><input type="hidden" name="act" value="cover"><input type="hidden" name="pid" value="<?= (int)$p['id'] ?>"></form>
<?php endforeach; ?>
<?php else: ?><div class="ad-card empty">Albamu hii bado haina picha. Pakia picha juu. Albamu bila picha haionekani kwenye tovuti.</div><?php endif; ?>
<?php admin_end();
