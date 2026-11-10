<?php
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/layout.php';
$services = q('SELECT * FROM services ORDER BY sort, id');
$schedule = q('SELECT * FROM schedule ORDER BY sort, id');
$board = current_hymn_board();
$hymns = $board ? hymn_lines($board['hymns']) : [];
$isMB = $board && $board['book'] === 'MB';
const MAANDIKO_PLAY = 'https://play.google.com/store/apps/details?id=kkktmaandiko.app';
const MAANDIKO_IOS  = 'https://apps.apple.com/app/id6474724381';
const MB_INDEX      = 'https://hymnary.org/hymnal/MB1988';
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

<section class="pg-sec" id="nyimbo">
  <div class="wrap">
    <div class="sub-head"><?= ORNAMENT ?><h2><span lang="sw">Nyimbo na Liturujia</span><span lang="en">Hymns and liturgy</span></h2></div>
    <div class="hymn-wrap">
      <figure class="hymn-board" aria-labelledby="hb-title">
        <figcaption>
          <b id="hb-title"><?php if ($board && $board['past']): ?><span lang="sw">Nyimbo za Jumapili iliyopita</span><span lang="en">Last Sunday's hymns</span><?php else: ?><span lang="sw">Nyimbo za Jumapili hii</span><span lang="en">This Sunday's hymns</span><?php endif; ?></b>
          <?php if ($board): ?><span><?= e(dshort($board['sunday_date'])) ?> · <?= e(HYMN_BOOKS[$board['book']] ?? $board['book']) ?><?php if ($board['note_sw'] !== ''): ?> · <?= L($board['note_sw'], $board['note_en']) ?><?php endif; ?></span><?php endif; ?>
        </figcaption>
        <?php if ($hymns): ?>
        <ol class="hb-list">
          <?php foreach ($hymns as $h): ?>
          <li>
            <span class="hb-num"><?php if ($isMB): ?><a href="https://hymnary.org/hymn/MB1988/<?= $h['num'] ?>" target="_blank" rel="noopener" title="Fungua kwenye Hymnary.org"><?= $h['num'] ?></a><?php else: ?><?= $h['num'] ?><?php endif; ?></span>
            <span class="hb-txt"><?php if ($h['label'] !== ''): ?><small><?= e($h['label']) ?></small><?php endif; ?><?= $h['first'] !== '' ? e($h['first']) : '<span lang="sw">Wimbo Na. ' . $h['num'] . '</span><span lang="en">Hymn no. ' . $h['num'] . '</span>' ?></span>
          </li>
          <?php endforeach; ?>
        </ol>
        <?php else: ?>
        <p class="hb-empty"><span lang="sw">Nyimbo za Jumapili zitawekwa hapa kabla ya ibada.</span><span lang="en">Sunday's hymn numbers will be posted here before the service.</span></p>
        <?php endif; ?>
      </figure>

      <div class="hymn-aside">
        <div class="ha-item">
          <?= icon('book', 'ico') ?>
          <div>
            <h3>KKKT Maandiko</h3>
            <p><span lang="sw">Programu rasmi ya KKKT yenye kitabu cha Tumwabudu Mungu Wetu: nyimbo, liturujia na masomo ya kila siku.</span><span lang="en">The official ELCT app with Tumwabudu Mungu Wetu: hymns, liturgy and daily readings.</span></p>
            <div class="store-btns">
              <a class="btn solid" href="<?= MAANDIKO_PLAY ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 3.5v17l9-8.5-9-8.5zm10.3 9.7 2.6 2.5-10.7 6 8.1-8.5zm0-2.4L6.2 2.3l10.7 6-2.6 2.5zm3.9-1.6 3 1.7c.8.5.8 1.7 0 2.2l-3 1.7-2.8-2.8 2.8-2.8z"/></svg><span lang="sw">Pakua Android</span><span lang="en">Get it on Android</span></a>
              <a class="btn" href="<?= MAANDIKO_IOS ?>" target="_blank" rel="noopener"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M16.4 12.6c0-2.4 2-3.5 2.1-3.6-1.1-1.7-2.9-1.9-3.5-1.9-1.5-.2-2.9.9-3.7.9s-1.9-.8-3.2-.8c-1.6 0-3.1 1-4 2.4-1.7 3-.4 7.4 1.2 9.8.8 1.2 1.8 2.5 3 2.4 1.2 0 1.7-.8 3.1-.8s1.9.8 3.2.8 2.1-1.2 2.9-2.4c.9-1.4 1.3-2.7 1.3-2.8 0 0-2.4-1-2.4-4zM14 5.6c.7-.8 1.1-1.9 1-3-1 0-2.1.6-2.8 1.4-.6.7-1.2 1.8-1 2.9 1.1.1 2.1-.5 2.8-1.3z"/></svg><span lang="sw">Pakua iPhone</span><span lang="en">Get it on iPhone</span></a>
            </div>
          </div>
        </div>
        <div class="ha-item">
          <?= icon('music', 'ico') ?>
          <div>
            <h3>Mwimbieni Bwana</h3>
            <p><span lang="sw">Orodha ya nyimbo zote za Mwimbieni Bwana kwa namba na mstari wa kwanza. Tafuta wimbo kabla ya ibada.</span><span lang="en">The full index of Mwimbieni Bwana by number and first line. Look a hymn up before the service.</span></p>
            <a class="ha-link" href="<?= MB_INDEX ?>" target="_blank" rel="noopener"><span lang="sw">Fungua orodha kwenye Hymnary.org</span><span lang="en">Open the index on Hymnary.org</span></a>
          </div>
        </div>
      </div>
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
