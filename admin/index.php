<?php
require __DIR__ . '/inc.php';
require_login();
$me = me();
$latest = q1('SELECT MAX(sunday_date) d FROM announcements')['d'] ?? null;
$c = fn($sql, $p = []) => (int)(q1($sql, $p)['c'] ?? 0);
$nextSunday = date('Y-m-d', strtotime('sunday this week'));
admin_start('Mwanzo', 'index.php');
?>
<div class="ad-head"><h1>Habari, <?= e($me['name'] ?: $me['username']) ?></h1></div>
<?php if (!$latest || $latest < $nextSunday): ?>
<div class="ad-card nudge"><b>Matangazo ya Jumapili <?= e(dshort($nextSunday)) ?> bado hayajawekwa.</b> <a class="ad-btn primary" href="edit.php?t=announcements&mode=new">+ Ongeza tangazo</a></div>
<?php endif; ?>
<div class="tiles">
  <a class="tile" href="edit.php?t=announcements"><b><?= $latest ? $c('SELECT COUNT(*) c FROM announcements WHERE sunday_date=?', [$latest]) : 0 ?></b><span>Matangazo ya wiki<?= $latest ? ' (' . e(dshort($latest)) . ')' : '' ?></span></a>
  <a class="tile" href="edit.php?t=notices"><b><?= $c('SELECT COUNT(*) c FROM notices WHERE CURDATE() BETWEEN start_date AND end_date') ?></b><span>Kumbukumbu zinazoonekana sasa</span></a>
  <a class="tile" href="edit.php?t=events"><b><?= $c('SELECT COUNT(*) c FROM events WHERE event_date >= CURDATE()') ?></b><span>Matukio yajayo</span></a>
  <a class="tile" href="edit.php?t=sermons"><b><?= $c('SELECT COUNT(*) c FROM sermons') ?></b><span>Mahubiri (<?= $c("SELECT COUNT(*) c FROM sermons WHERE youtube<>''") ?> na video)</span></a>
  <a class="tile" href="edit.php?t=albums"><b><?= $c('SELECT COUNT(*) c FROM albums') ?></b><span>Albamu · picha <?= $c("SELECT COUNT(*) c FROM photos WHERE path NOT LIKE 'ikoni:%'") ?> halisi</span></a>
  <a class="tile" href="edit.php?t=leaders"><b><?= $c('SELECT COUNT(*) c FROM leaders') ?></b><span>Viongozi</span></a>
</div>
<h2 class="ad-sub">Kazi za kila wiki</h2>
<ol class="ad-steps ad-card">
  <li><a href="edit.php?t=announcements&mode=new">Ongeza matangazo ya Jumapili</a>. Ya wiki iliyopita yanahamia "yaliyopita" yenyewe.</li>
  <li><a href="edit.php?t=sermons&mode=new">Ongeza mahubiri</a> na ubandike kiungo cha YouTube.</li>
  <li><a href="edit.php?t=albums">Pakia picha</a> za matukio kwenye albamu.</li>
  <li>Badilisha <a href="settings.php">Neno la Wiki</a> kama linabadilika.</li>
</ol>
<?php admin_end();
