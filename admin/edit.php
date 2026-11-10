<?php
require __DIR__ . '/inc.php';
require_login(); check_csrf();
$TABLES = require __DIR__ . '/tables.php';
$t = (string)($_GET['t'] ?? '');
if (!isset($TABLES[$t])) { http_response_code(404); exit('Haipo.'); }
$T = $TABLES[$t];
$id = (int)($_GET['id'] ?? 0);
$mode = $_GET['mode'] ?? ($id ? 'edit' : 'list');
$self = 'edit.php?t=' . $t;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete'])) {
        $row = q1("SELECT * FROM `$t` WHERE id=?", [(int)$_POST['delete']]);
        if ($row) {
            foreach ($T['fields'] as $k => $f) if ($f[1] === 'image' && $row[$k]) delete_upload($row[$k]);
            if ($t === 'albums') foreach (q('SELECT path FROM photos WHERE album_id=?', [$row['id']]) as $p) delete_upload($p['path']);
            run("DELETE FROM `$t` WHERE id=?", [$row['id']]);
            flash('Imefutwa.');
        }
        redirect($self);
    }
    $vals = []; $errors = [];
    $old = $id ? q1("SELECT * FROM `$t` WHERE id=?", [$id]) : null;
    foreach ($T['fields'] as $k => [$label, $type]) {
        $opt = $T['fields'][$k][2] ?? [];
        if ($type === 'image') {
            if (!empty($_POST[$k . '_remove']) && $old && $old[$k]) { delete_upload($old[$k]); $vals[$k] = ''; }
            if (!empty($_FILES[$k]['name'])) {
                try { $vals[$k] = save_upload($_FILES[$k], $opt['dir'] ?? 'misc', $opt['max'] ?? 1600); if ($old && $old[$k]) delete_upload($old[$k]); }
                catch (RuntimeException $ex) { $errors[] = $label . ': ' . $ex->getMessage(); }
            }
            continue;
        }
        $v = trim((string)($_POST[$k] ?? ''));
        if ($type === 'number') $v = (string)(int)$v;
        if ($type === 'date' && $v !== '' && !preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) $errors[] = $label . ': tarehe si sahihi.';
        if (in_array($type, ['select', 'icon'], true) && !isset($opt['options'][$v])) $v = (string)array_key_first($opt['options']);
        if ($type === 'youtube' && $v !== '' && youtube_id($v) === '') $errors[] = 'Kiungo cha YouTube hakitambuliki. Bandika kiungo kamili cha video.';
        if (!empty($opt['required']) && $v === '') $errors[] = $label . ' inahitajika.';
        $vals[$k] = $v;
    }
    if ($t === 'notices' && ($vals['start_date'] ?? '') > ($vals['end_date'] ?? '')) $errors[] = 'Tarehe ya mwisho iwe baada ya tarehe ya mwanzo.';
    if ($errors) { foreach ($errors as $er) flash($er, 'err'); $_SESSION['form'] = $_POST; redirect($self . ($id ? '&id=' . $id : '&mode=new')); }
    $cols = array_keys($vals);
    if ($id) {
        run("UPDATE `$t` SET " . implode(',', array_map(fn($c) => "`$c`=?", $cols)) . ' WHERE id=?', [...array_values($vals), $id]);
        flash('Mabadiliko yamehifadhiwa.');
    } else {
        run("INSERT INTO `$t` (`" . implode('`,`', $cols) . '`) VALUES (' . implode(',', array_fill(0, count($cols), '?')) . ')', array_values($vals));
        $id = (int)db()->lastInsertId();
        flash(ucfirst($T['one']) . ' limeongezwa.');
        if (!empty($T['photos'])) redirect('photos.php?album=' . $id);
    }
    redirect($self);
}

admin_start($T['title'], in_array($t, ['services','schedule','fellowships'], true) ? 'more.php' : $self);

if ($mode === 'list') {
    $rows = q("SELECT * FROM `$t` ORDER BY {$T['order']}");
    $counts = !empty($T['photos']) ? array_column(q('SELECT album_id, COUNT(*) c FROM photos GROUP BY album_id'), 'c', 'album_id') : [];
    ?>
    <div class="ad-head"><h1><?= e($T['title']) ?></h1><a class="ad-btn primary" href="<?= e($self) ?>&mode=new">+ Ongeza <?= e($T['one']) ?></a></div>
    <?php if (!empty($T['help'])): ?><p class="ad-help"><?= e($T['help']) ?></p><?php endif; ?>
    <?php if (!$rows): ?><div class="ad-card empty">Bado hakuna kitu hapa. Bonyeza "Ongeza" kuanza.</div><?php else: ?>
    <div class="ad-card ad-table-wrap"><table class="ad-table">
      <thead><tr><?php foreach ($T['list'] as $k => $label): ?><th><?= e($label) ?></th><?php endforeach; ?><th></th></tr></thead>
      <tbody>
      <?php $prev = null; foreach ($rows as $r):
        if (!empty($T['group']) && $r[$T['group']] !== $prev): $prev = $r[$T['group']]; ?>
        <tr class="grp-row"><td colspan="<?= count($T['list']) + 1 ?>">Jumapili <?= e(dshort($prev)) ?><?= $prev === ($rows[0][$T['group']] ?? '') ? ' · wiki hii' : '' ?></td></tr>
      <?php endif; ?>
        <tr>
          <?php foreach ($T['list'] as $k => $label): $v = (string)($r[$k] ?? ''); ?>
          <td><?php
            if (($T['fields'][$k][1] ?? '') === 'image') echo $v ? '<img class="thumb" src="../' . e($v) . '" alt="">' : '<span class="thumb none"></span>';
            elseif ($k === 'youtube') echo $v ? '<span class="pill ok">Imeunganishwa</span>' : '<span class="pill">Hakuna</span>';
            elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $v)) echo e(dshort($v));
            elseif (isset($T['fields'][$k][2]['options'][$v])) echo e($T['fields'][$k][2]['options'][$v]);
            else echo e(mb_strimwidth($v, 0, 80, '…'));
          ?></td>
          <?php endforeach; ?>
          <td class="actions">
            <?php if (!empty($T['photos'])): ?><a class="ad-btn" href="photos.php?album=<?= (int)$r['id'] ?>">Picha (<?= (int)($counts[$r['id']] ?? 0) ?>)</a><?php endif; ?>
            <a class="ad-btn" href="<?= e($self) ?>&id=<?= (int)$r['id'] ?>">Hariri</a>
            <form method="post" data-confirm="Una uhakika unataka kufuta hiki? Haiwezi kurudishwa."><?= csrf_field() ?><input type="hidden" name="delete" value="<?= (int)$r['id'] ?>"><button class="ad-btn danger">Futa</button></form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table></div>
    <?php endif;
} else {
    $row = $id ? q1("SELECT * FROM `$t` WHERE id=?", [$id]) : [];
    if ($id && !$row) { echo '<p>Haipo.</p>'; admin_end(); exit; }
    $form = $_SESSION['form'] ?? null; unset($_SESSION['form']);
    ?>
    <div class="ad-head"><h1><?= $id ? 'Hariri ' : 'Ongeza ' ?><?= e($T['one']) ?></h1><a class="ad-btn" href="<?= e($self) ?>">← Rudi</a></div>
    <form method="post" enctype="multipart/form-data" class="ad-card ad-form">
      <?= csrf_field() ?>
      <div class="ad-grid">
      <?php foreach ($T['fields'] as $k => [$label, $type]):
        $opt = $T['fields'][$k][2] ?? [];
        $val = $form[$k] ?? ($row[$k] ?? (isset($opt['default']) ? ($opt['default'])() : ''));
        $isEn = str_ends_with($k, '_en'); $wide = in_array($type, ['textarea'], true); ?>
        <label class="<?= $wide ? 'wide' : '' ?><?= $isEn ? ' en' : '' ?>"><span><?= e($label) ?><?= !empty($opt['required']) ? ' *' : '' ?></span>
        <?php if ($type === 'textarea'): ?><textarea name="<?= $k ?>" rows="4"><?= e((string)$val) ?></textarea>
        <?php elseif ($type === 'select' || $type === 'icon'): ?><select name="<?= $k ?>"><?php foreach ($opt['options'] as $ov => $ol): ?><option value="<?= e((string)$ov) ?>"<?= (string)$ov === (string)$val ? ' selected' : '' ?>><?= e($ol) ?></option><?php endforeach; ?></select>
        <?php elseif ($type === 'image'): ?>
          <?php if (!empty($row[$k])): ?><span class="img-now"><img src="../<?= e($row[$k]) ?>" alt=""><span><input type="checkbox" name="<?= $k ?>_remove" value="1"> Ondoa picha</span></span><?php endif; ?>
          <input type="file" name="<?= $k ?>" accept="image/jpeg,image/png,image/webp">
        <?php elseif ($type === 'youtube'): ?><input name="<?= $k ?>" value="<?= e((string)$val) ?>" placeholder="https://www.youtube.com/watch?v=..."><small>Bandika kiungo cha video kutoka YouTube. Acha wazi kama video bado haijawekwa.</small>
        <?php else: ?><input type="<?= $type === 'date' ? 'date' : ($type === 'number' ? 'number' : 'text') ?>" name="<?= $k ?>" value="<?= e((string)$val) ?>"<?= !empty($opt['required']) ? ' required' : '' ?>>
        <?php endif; ?>
        <?php if ($isEn): ?><small>Si lazima. Ikiachwa wazi, Kiswahili kitaonyeshwa.</small><?php endif; ?>
        </label>
      <?php endforeach; ?>
      </div>
      <div class="ad-actions"><button class="ad-btn primary">Hifadhi</button><a class="ad-btn" href="<?= e($self) ?>">Ghairi</a></div>
    </form>
    <?php
}
admin_end();
