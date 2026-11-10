<?php
require __DIR__ . '/inc.php';
require_login(); check_csrf();
/* Settings shown on the form, grouped. [key, label, type] */
$GROUPS = [
  'Mawasiliano' => [['phone','Simu','text'],['email','Barua pepe','text'],['address','Mahali','text'],['pobox','Sanduku la Posta (acha wazi kama hakuna)','text'],
                    ['office_hours_sw','Saa za ofisi','text'],['office_hours_en','Saa za ofisi (Kiingereza)','text']],
  'Matoleo' => [['lipa_namba','Lipa Namba ya usharika','text'],['bank_name','Jina la benki','text'],['bank_account','Namba ya akaunti','text']],
  'Ukurasa wa mwanzo' => [['verse_sw','Neno la Wiki (mstari wa Biblia)','textarea'],['verse_en','Neno la Wiki (Kiingereza)','textarea'],
                    ['verse_ref_sw','Kitabu (mf. Zaburi 122:1)','text'],['verse_ref_en','Kitabu (Kiingereza, mf. Psalm 122:1)','text'],
                    ['season_sw','Ujumbe wa msimu – kichwa|maelezo (mf. Majilio yanakaribia|Jumapili 29 Novemba). Acha wazi kuuficha.','text'],
                    ['season_en','Ujumbe wa msimu (Kiingereza) – title|details','text'],
                    ['pastor_message_sw','Neno la Mchungaji','textarea'],['pastor_message_en','Neno la Mchungaji (Kiingereza)','textarea']],
  'Kuhusu usharika' => [['diocese_sw','Dayosisi','text'],['diocese_en','Dayosisi (Kiingereza)','text'],['district_sw','Jimbo','text'],['district_en','Jimbo (Kiingereza)','text'],
                    ['preaching_points','Idadi ya mitaa','text'],['history_start_year','Mwaka usharika ulianza','text'],['history_start_place','Mahali waumini walianza kukutana','text'],
                    ['history_parish_year','Mwaka ulipokuwa usharika kamili','text'],['history_members','Idadi ya waumini (mf. 2,000)','text']],
  'YouTube na ibada mubashara' => [['youtube_channel_url','Kiungo cha chaneli ya YouTube','text'],['live_channel_id','Channel ID ya YouTube (huanza na UC...). Inahitajika kwa ibada mubashara.','text'],
                    ['live_day','Siku ya ibada mubashara','day'],['live_start','Kuanzia saa (saa za kawaida, mf. 06:45)','time'],['live_end','Hadi saa (mf. 12:30)','time'],
                    ['live_force','Washa "Mubashara" sasa hivi (kwa ibada maalum)','bool']],
];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($GROUPS as $fields) foreach ($fields as [$k, , $type]) {
        $v = $type === 'bool' ? (empty($_POST[$k]) ? '0' : '1') : trim((string)($_POST[$k] ?? ''));
        if ($type === 'time' && $v !== '' && !preg_match('/^\d{2}:\d{2}$/', $v)) continue;
        if ($type === 'day') $v = (string)max(0, min(6, (int)$v));
        run('INSERT INTO settings (k, v) VALUES (?, ?) ON DUPLICATE KEY UPDATE v = VALUES(v)', [$k, $v]);
    }
    flash('Mipangilio imehifadhiwa.'); redirect('settings.php');
}
admin_start('Mipangilio', 'settings.php');
?>
<div class="ad-head"><h1>Mipangilio ya tovuti</h1></div>
<form method="post" class="ad-form">
  <?= csrf_field() ?>
  <?php foreach ($GROUPS as $title => $fields): ?>
  <section class="ad-card"><h2><?= e($title) ?></h2><div class="ad-grid">
    <?php foreach ($fields as [$k, $label, $type]): $v = setting($k); ?>
    <label class="<?= $type === 'textarea' ? 'wide' : '' ?><?= str_ends_with($k, '_en') ? ' en' : '' ?>"><span><?= e($label) ?></span>
      <?php if ($type === 'textarea'): ?><textarea name="<?= $k ?>" rows="3"><?= e($v) ?></textarea>
      <?php elseif ($type === 'bool'): ?><span class="check"><input type="checkbox" name="<?= $k ?>" value="1"<?= $v === '1' ? ' checked' : '' ?>> Ndiyo</span>
      <?php elseif ($type === 'day'): ?><select name="<?= $k ?>"><?php foreach (DAY_SW as $i => $d): ?><option value="<?= $i ?>"<?= (string)$i === $v ? ' selected' : '' ?>><?= $d ?></option><?php endforeach; ?></select>
      <?php else: ?><input type="<?= $type === 'time' ? 'time' : 'text' ?>" name="<?= $k ?>" value="<?= e($v) ?>">
      <?php endif; ?>
    </label>
    <?php endforeach; ?>
  </div></section>
  <?php endforeach; ?>
  <div class="ad-actions sticky"><button class="ad-btn primary">Hifadhi mipangilio</button></div>
</form>
<?php admin_end();
