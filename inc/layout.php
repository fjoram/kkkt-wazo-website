<?php
/** Start a public page: <head>, top menu. $title is plain text. */
function page_start(string $title): void {
    $full = $title === '' ? 'KKKT Usharika wa Wazo' : $title . ' · KKKT Usharika wa Wazo';
    ?><!DOCTYPE html>
<html lang="sw">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?= e($full) ?></title>
<meta name="description" content="KKKT Usharika wa Wazo – Kanisa la Kiinjili la Kilutheri Tanzania, Wazo, Dar es Salaam.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,600;0,700;1,500;1,600&family=Source+Sans+3:wght@400;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>

<header>
  <div class="bar" style="margin-inline:auto">
    <a class="brand" href="index.php" aria-label="KKKT Usharika wa Wazo">
      <svg viewBox="0 0 100 100" aria-hidden="true">
        <circle cx="50" cy="50" r="48" fill="#c39a2b"/>
        <circle cx="50" cy="50" r="42" fill="#16305e"/>
        <g fill="#ffffff">
          <circle cx="50" cy="26" r="13"/><circle cx="72.8" cy="42.6" r="13"/><circle cx="64.1" cy="69.4" r="13"/>
          <circle cx="35.9" cy="69.4" r="13"/><circle cx="27.2" cy="42.6" r="13"/><circle cx="50" cy="51" r="20"/>
        </g>
        <path d="M50 66c-9-6-15-11-15-18a8 8 0 0 1 15-4 8 8 0 0 1 15 4c0 7-6 12-15 18z" fill="#a3223a"/>
        <rect x="47.5" y="40" width="5" height="22" fill="#18202e"/><rect x="42" y="45.5" width="16" height="5" fill="#18202e"/>
      </svg>
      <span><b>KKKT Usharika wa Wazo</b><small><span lang="sw">Kanisa la Kiinjili la Kilutheri Tanzania</span><span lang="en">Evangelical Lutheran Church in Tanzania</span></small></span>
    </a>
    <button class="menu-btn" id="menuBtn" aria-expanded="false" aria-controls="nav"><span lang="sw">Menyu</span><span lang="en">Menu</span></button>
    <nav class="main" id="nav" aria-label="Main">
      <a href="kuhusu.php"><span lang="sw">Kuhusu</span><span lang="en">About</span></a>
      <a href="ibada.php"><span lang="sw">Ibada</span><span lang="en">Services</span></a>
      <a href="vikundi.php"><span lang="sw">Vikundi</span><span lang="en">Fellowships</span></a>
      <a href="picha.php"><span lang="sw">Picha</span><span lang="en">Gallery</span></a>
      <a href="matangazo.php"><span lang="sw">Matangazo</span><span lang="en">News</span></a>
      <a href="mahubiri.php"><span lang="sw">Mahubiri</span><span lang="en">Sermons</span></a>
      <a href="matoleo.php"><span lang="sw">Matoleo</span><span lang="en">Giving</span></a>
      <a href="mawasiliano.php"><span lang="sw">Mawasiliano</span><span lang="en">Contact</span></a>
    </nav>
    <div class="lang" role="group" aria-label="Lugha / Language">
      <button type="button" id="btnSw" aria-pressed="true" aria-label="Kiswahili"><span class="long">Kiswahili</span><span class="short">SW</span></button>
      <button type="button" id="btnEn" aria-pressed="false" aria-label="English"><span class="long">English</span><span class="short">EN</span></button>
    </div>
  </div>
</header>

<?php
}

/** End a public page: footer, page data for scripts, scripts. */
function page_end(array $data = []): void {
    $phone = setting('phone'); $email = setting('email');
    $live = [
        'channelId' => setting('live_channel_id'),
        'schedule'  => [['day' => (int)setting('live_day', '0'), 'start' => setting('live_start', '06:45'), 'end' => setting('live_end', '12:30')]],
        'force'     => setting('live_force') === '1',
    ];
    ?>
<footer>
  <div class="wrap foot2">
    <div class="f-brand">
      <svg viewBox="0 0 100 100" aria-hidden="true">
        <circle cx="50" cy="50" r="48" fill="#c39a2b"/>
        <circle cx="50" cy="50" r="42" fill="#16305e"/>
        <g fill="#ffffff">
          <circle cx="50" cy="26" r="13"/><circle cx="72.8" cy="42.6" r="13"/><circle cx="64.1" cy="69.4" r="13"/>
          <circle cx="35.9" cy="69.4" r="13"/><circle cx="27.2" cy="42.6" r="13"/><circle cx="50" cy="51" r="20"/>
        </g>
        <path d="M50 66c-9-6-15-11-15-18a8 8 0 0 1 15-4 8 8 0 0 1 15 4c0 7-6 12-15 18z" fill="#a3223a"/>
        <rect x="47.5" y="40" width="5" height="22" fill="#18202e"/><rect x="42" y="45.5" width="16" height="5" fill="#18202e"/>
      </svg>
      <div><b>KKKT Usharika wa Wazo</b><span><?= Lh('Kanisa la Kiinjili la Kilutheri Tanzania','Evangelical Lutheran Church in Tanzania') ?></span><span><?= L('Dayosisi ya ' . setting('diocese_sw'), setting('diocese_en') . ' Diocese') ?></span></div>
    </div>
    <div class="f-col">
      <h2><?= Lh('Wasiliana nasi','Contact us') ?></h2>
      <?php if ($phone): ?><a href="tel:<?= e(preg_replace('/\s+/', '', $phone)) ?>"><?= e($phone) ?></a><?php endif; ?>
      <?php if ($email): ?><a href="mailto:<?= e($email) ?>"><?= e($email) ?></a><?php endif; ?>
      <span><?= e(setting('address')) ?></span>
    </div>
    <div class="f-col">
      <h2><?= Lh('Viungo','Quick links') ?></h2>
      <a href="ibada.php"><?= Lh('Ratiba ya ibada','Service times') ?></a>
      <a href="matangazo.php"><?= Lh('Matangazo','Announcements') ?></a>
      <a href="matoleo.php"><?= Lh('Matoleo','Giving') ?></a>
      <a href="mawasiliano.php"><?= Lh('Jinsi ya kufika','How to find us') ?></a>
    </div>
  </div>
  <div class="wrap f-bottom"><span>© <?= date('Y') ?> KKKT Usharika wa Wazo</span><span class="f-bless"><?= Lh('Mungu awabariki','God bless you') ?></span></div>
</footer>

<script>window.LIVE_CONFIG = <?= json_encode($live, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG) ?>;<?php
    foreach ($data as $name => $value) echo "\nwindow.$name = " . json_encode($value, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_UNESCAPED_SLASHES) . ';';
?></script>
<script src="site.js"></script>
</body>
</html>
<?php
}

/** Line icons used across the site. */
function icon(string $name, string $cls = 'ico'): string {
    static $I = [
      'music' => '<path d="M9 18V6l11-2v12"/><circle cx="6.5" cy="18" r="2.5"/><circle cx="17.5" cy="16" r="2.5"/>',
      'spark' => '<path d="M12 3c1 4 3 6 7 7-4 1-6 3-7 7-1-4-3-6-7-7 4-1 6-3 7-7z"/>',
      'flower'=> '<circle cx="12" cy="12" r="2.5"/><path d="M12 9.5C12 6 10 4 12 3c2 1 0 3 0 6.5M14.5 12c3.5 0 5.5-2 6.5 0-1 2-3 0-6.5 0M12 14.5c0 3.5 2 5.5 0 6.5-2-1 0-3 0-6.5M9.5 12C6 12 4 14 3 12c1-2 3 0 6.5 0"/>',
      'hands' => '<path d="M7 11V6a1.5 1.5 0 0 1 3 0v4M10 10V4.5a1.5 1.5 0 0 1 3 0V10M13 10V5.5a1.5 1.5 0 0 1 3 0V12M16 9a1.5 1.5 0 0 1 3 0v4c0 4-3 7-7 7-3 0-5-2-6.5-4L4 13a1.5 1.5 0 0 1 2.5-1.5L8 13"/>',
      'child' => '<circle cx="12" cy="5" r="2.2"/><path d="M8 10l4-1 4 1M12 9v6M9 21l3-6 3 6M6 13l2-3M18 13l-2-3"/>',
      'dove'  => '<path d="M3 14c4 0 6-2 8-6 1 3 3 4 6 4l4-2-2 4c-1 3-4 5-8 5H6l-3 2z"/><circle cx="16.5" cy="11" r=".6"/>',
      'clock' => '<circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/>',
      'phone' => '<rect x="6.5" y="2.5" width="11" height="19" rx="2.5"/><path d="M10.5 18.5h3"/>',
      'bank'  => '<path d="M3 9.5L12 4l9 5.5M5 10v8M9.5 10v8M14.5 10v8M19 10v8M3 20.5h18"/>',
      'church'=> '<path d="M12 2v4M10.5 3.5h3M12 6l5 4v11H7V10z"/><path d="M10 21v-4a2 2 0 0 1 4 0v4M3 21h18"/>',
      'pin'   => '<path d="M12 21s-7-6.2-7-11.5a7 7 0 0 1 14 0C19 14.8 12 21 12 21z"/><circle cx="12" cy="9.5" r="2.5"/>',
      'call'  => '<path d="M5 4h4l2 5-2.5 1.5a11 11 0 0 0 5 5L15 13l5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>',
      'mail'  => '<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3.5 6.5L12 13l8.5-6.5"/>',
      'box'   => '<path d="M4 8l8-4 8 4v8l-8 4-8-4z"/><path d="M4 8l8 4 8-4M12 12v8"/>',
      'play'  => '<path d="M8 5v14l11-7z"/>',
      'cal'   => '<rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4"/>',
      'cross' => '<path d="M12 3v18M7 8h10"/>',
      'map'   => '<path d="M3 6l6-2 6 2 6-2v14l-6 2-6-2-6 2z"/><path d="M9 4v14M15 6v14"/>',
      'gift'  => '<rect x="3.5" y="9" width="17" height="11.5" rx="1.5"/><path d="M3.5 13h17M12 9v11.5M12 9c-1.5-3-5-4-5-1.5S10 9 12 9zM12 9c1.5-3 5-4 5-1.5S14 9 12 9z"/>',
      'heart' => '<path d="M12 20s-7-4.4-7-9.5A3.8 3.8 0 0 1 12 8a3.8 3.8 0 0 1 7 2.5C19 15.6 12 20 12 20z"/>',
      'book'  => '<path d="M3 6c3-1 6-1 9 1v12c-3-2-6-2-9-1z"/><path d="M21 6c-3-1-6-1-9 1v12c3-2 6-2 9-1z"/>',
      'bell'  => '<path d="M6 16V11a6 6 0 0 1 12 0v5l1.5 2h-15z"/><path d="M10 20a2 2 0 0 0 4 0"/>',
      'people'=> '<circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.4"/><path d="M3.5 19c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/><path d="M15 14.2c2.6-.4 4.8 1.1 5.4 4.3"/>',
    ];
    return '<span class="' . e($cls) . '" aria-hidden="true"><svg viewBox="0 0 24 24">' . ($I[$name] ?? $I['cross']) . '</svg></span>';
}
function icon_names(): array { return ['music','spark','flower','hands','child','dove','cross','church','book','bell','people','heart','gift','clock','cal']; }

const ORNAMENT = '<div class="ornament" aria-hidden="true"><span></span><svg viewBox="0 0 20 28"><path d="M8 0h4v8h8v4h-8v16H8V12H0V8h8z"/></svg><span></span></div>';

/** Data for the announcement scripts (same shape as the old data/matangazo.js). */
function matangazo_data(): array {
    $latest = q1('SELECT MAX(sunday_date) d FROM announcements')['d'] ?? null;
    $row = fn($a) => ['aina' => $a['label'], 'kichwa' => $a['title_sw'], 'kichwa_en' => $a['title_en'], 'maelezo' => $a['body_sw'], 'maelezo_en' => $a['body_en']];
    $wiki = ['tarehe' => $latest ?: date('Y-m-d'), 'orodha' => $latest ? array_map($row, q('SELECT * FROM announcements WHERE sunday_date=? ORDER BY sort,id', [$latest])) : []];
    $past = [];
    foreach (q('SELECT * FROM announcements WHERE sunday_date < ? ORDER BY sunday_date DESC, sort, id', [$latest ?: '9999-12-31']) as $a) {
        $past[$a['sunday_date']]['tarehe'] = $a['sunday_date'];
        $past[$a['sunday_date']]['orodha'][] = $row($a);
    }
    return [
        'wiki' => $wiki,
        'muda_mrefu' => array_map(fn($n) => ['aina' => $n['label'], 'kichwa' => $n['title_sw'], 'kichwa_en' => $n['title_en'], 'maelezo' => $n['body_sw'], 'maelezo_en' => $n['body_en'], 'kuanzia' => $n['start_date'], 'hadi' => $n['end_date']], q('SELECT * FROM notices ORDER BY end_date')),
        'matukio' => array_map(fn($v) => ['tarehe' => $v['event_date'], 'saa' => $v['time_sw'], 'saa_en' => $v['time_en'], 'kichwa' => $v['title_sw'], 'kichwa_en' => $v['title_en']], q('SELECT * FROM events WHERE event_date >= CURDATE() ORDER BY event_date')),
        'zilizopita' => array_values(array_slice($past, 0, 8)),
    ];
}
