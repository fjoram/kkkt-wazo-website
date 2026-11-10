<?php
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/layout.php';
$services = q('SELECT * FROM services ORDER BY sort, id');
$schedule = q('SELECT * FROM schedule ORDER BY sort, id');
page_start('Ibada');
?>
<main class="page inner">
<section class="pg-head">
  <div class="wrap">
    <p class="kicker"><span lang="sw">Ibada na ratiba</span><span lang="en">Worship and schedule</span></p>
    <h1><span lang="sw">Njoo tumwabudu Bwana pamoja</span><span lang="en">Come and worship the Lord with us</span></h1>
    <p class="pg-lede"><span lang="sw">Ibada zote ni kwa Kiswahili. Saa zimeandikwa kwa saa za Kiswahili.</span><span lang="en">All services are in Swahili. Times are shown in standard time.</span></p>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap">
    <div class="sub-head"><div class="ornament" aria-hidden="true"><span></span><svg viewBox="0 0 20 28"><path d="M8 0h4v8h8v4h-8v16H8V12H0V8h8z"/></svg><span></span></div><h2><span lang="sw">Ibada za Jumapili</span><span lang="en">Sunday worship</span></h2></div>
    <div class="svc-row">
      <?php foreach ($services as $sv): ?>
      <article class="svc">
        <div class="svc-time"><span lang="sw"><?= e($sv['time_sw']) ?></span><span lang="en"><?= e($sv['time_en']) ?></span><small><?= L($sv['period_sw'], $sv['period_en']) ?></small></div>
        <h3><?= L($sv['name_sw'], $sv['name_en']) ?></h3>
        <p><?= L($sv['desc_sw'], $sv['desc_en']) ?></p>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap narrow">
    <div class="sub-head"><div class="ornament" aria-hidden="true"><span></span><svg viewBox="0 0 20 28"><path d="M8 0h4v8h8v4h-8v16H8V12H0V8h8z"/></svg><span></span></div><h2><span lang="sw">Wiki nzima</span><span lang="en">Through the week</span></h2><p class="ab-sub"><span lang="sw">Maombi, mafundisho na mazoezi ya kwaya siku za kazi.</span><span lang="en">Prayer, teaching and choir practice on weekdays.</span></p></div>
    <ol class="timeline">
      <?php foreach ($schedule as $w): ?>
      <li>
        <span class="tl-day"><?= L($w['day_sw'], $w['day_en']) ?></span>
        <span class="tl-dot" aria-hidden="true"></span>
        <div class="tl-body"><?= icon($w['icon'], 'ico sm') ?><div><b><?= L($w['activity_sw'], $w['activity_en']) ?></b><span><?= L($w['time_sw'], $w['time_en']) ?></span></div></div>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
</main>
<?php page_end([]); ?>
