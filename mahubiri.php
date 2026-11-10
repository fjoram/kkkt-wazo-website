<?php
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/layout.php';
$sermons = q('SELECT * FROM sermons ORDER BY sermon_date DESC, id DESC LIMIT 30');
$first = $sermons[0] ?? null;
page_start('Mahubiri');
?>
<main class="page inner">
<section class="pg-head">
  <div class="wrap">
    <p class="kicker"><span lang="sw">Mahubiri</span><span lang="en">Sermons</span></p>
    <h1><span lang="sw">Tazama na usikilize Neno la Mungu</span><span lang="en">Watch and hear God's Word</span></h1>
    <p class="pg-lede"><span lang="sw">Tazama mahubiri ya Jumapili kwenye YouTube, popote ulipo.</span><span lang="en">Watch Sunday sermons on YouTube, wherever you are.</span></p>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap">
    <article class="feature2" id="sermon-player">
      <div class="yt" data-yt="<?= e(youtube_id($first['youtube'] ?? '')) ?>">
        <div class="yt-thumb"></div>
        <div class="yt-art"><svg class="yt-cross" viewBox="0 0 20 28" aria-hidden="true"><path d="M8 0h4v8h8v4h-8v16H8V12H0V8h8z"/></svg><span class="yt-soon"><span lang="sw">Video itawekwa hivi karibuni</span><span lang="en">Video coming soon</span></span></div>
        <button type="button" class="yt-play" aria-label="Tazama mahubiri / Watch sermon"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg></button>
      </div>
      <div class="f-body">
        <span class="tag"><span lang="sw">Mahubiri ya karibuni</span><span lang="en">Latest sermon</span></span>
        <p class="ref" data-f="ref"><?= L($first['ref_sw'] ?? '', $first['ref_en'] ?? '') ?></p>
        <h2 data-f="title"><?= L($first['title_sw'] ?? '', $first['title_en'] ?? '') ?></h2>
        <p class="by" data-f="by"><?= $first ? e($first['preacher']) . ' · ' . dshort($first['sermon_date']) : '' ?></p>
        <?php if (setting('youtube_channel_url')): ?><a class="yt-channel" href="<?= e(setting('youtube_channel_url')) ?>" data-channel><svg viewBox="0 0 28 20" aria-hidden="true"><rect width="28" height="20" rx="5" fill="#ff0033"/><path d="M11 5.5v9l7.5-4.5z" fill="#fff"/></svg><span lang="sw">Chaneli yetu ya YouTube</span><span lang="en">Our YouTube channel</span></a><?php endif; ?>
        <p class="next-live"><span class="live-dot off" aria-hidden="true"></span><span lang="sw">Ibada mubashara kila Jumapili kuanzia saa 1:00 asubuhi</span><span lang="en">Live every Sunday from 7:00 AM</span></p>
      </div>
    </article>
  </div>
</section>

<section class="pg-sec" id="mahubiri-orodha">
  <div class="wrap narrow">
    <div class="sub-head"><div class="ornament" aria-hidden="true"><span></span><svg viewBox="0 0 20 28"><path d="M8 0h4v8h8v4h-8v16H8V12H0V8h8z"/></svg><span></span></div><h2><span lang="sw">Mahubiri yote</span><span lang="en">All sermons</span></h2><p class="ab-sub"><span lang="sw">Chagua mahubiri ili uyatazame kwenye kicheza video.</span><span lang="en">Choose a sermon to watch it in the player.</span></p></div>
    <ol class="s-list">
      <?php foreach ($sermons as $s): $by = $s['preacher'] . ' · ' . dshort($s['sermon_date']); ?>
      <li>
        <button type="button" class="srow" data-yt="<?= e(youtube_id($s['youtube'])) ?>" data-ref-sw="<?= e($s['ref_sw']) ?>" data-ref-en="<?= e($s['ref_en'] ?: $s['ref_sw']) ?>" data-title-sw="<?= e($s['title_sw']) ?>" data-title-en="<?= e($s['title_en'] ?: $s['title_sw']) ?>" data-by="<?= e($by) ?>">
          <span class="s-thumb"><span class="yt-thumb"></span><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg></span>
          <span class="s-main"><b><?= L($s['title_sw'], $s['title_en']) ?></b><span><?= L($s['ref_sw'], $s['ref_en']) ?></span></span>
          <span class="s-meta"><?= e($s['preacher']) ?><br><?= dshort($s['sermon_date']) ?></span>
        </button>
      </li>
      <?php endforeach; ?>
    </ol>
  </div>
</section>
</main>
<?php page_end([]); ?>
