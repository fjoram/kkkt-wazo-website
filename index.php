<?php
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/layout.php';
$services = q('SELECT * FROM services ORDER BY sort, id');
$lead     = q1("SELECT * FROM leaders WHERE tier='pastor' ORDER BY sort, id LIMIT 1");
$sermon   = q1('SELECT * FROM sermons ORDER BY sermon_date DESC, id DESC LIMIT 1');
page_start('');
?>
<main>
<section class="hero" id="mwanzo">
  <div class="wrap top-grid">
    <div class="banner">
      <div class="banner-photo" role="img" aria-label="Jengo la kanisa la KKKT Wazo"></div>
      <div class="banner-inner">
    <h1 lang="sw">Karibu nyumbani kwa Bwana, Wazo.</h1>
    <h1 lang="en">Welcome to the house of the Lord in Wazo.</h1>
    <?php if (setting('season_sw') !== ''): [$s1,$s2]=array_pad(explode('|',setting('season_sw'),2),2,''); [$e1,$e2]=array_pad(explode('|',setting('season_en'),2),2,''); ?>
    <a class="season-pill" href="matangazo.php"><svg viewBox="0 0 46 38" aria-hidden="true"><ellipse cx="23" cy="33" rx="21" ry="4.5" fill="#5aa37c"/><rect x="5" y="15" width="6" height="18" rx="1" fill="#c9a6ec"/><rect x="15" y="12" width="6" height="21" rx="1" fill="#c9a6ec"/><rect x="25" y="12" width="6" height="21" rx="1" fill="#f1b6cf"/><rect x="35" y="15" width="6" height="18" rx="1" fill="#c9a6ec"/><path d="M8 13c-2-3 0-5 0-7 2 2 2 4 0 7z" fill="#f5c451"/></svg><span><b><?= L($s1,$e1) ?></b> <?= L($s2,$e2) ?></span></a>
    <?php endif; ?>
        <div class="verse">
        <p><?= L(setting('verse_sw'), setting('verse_en')) ?></p>
        <cite><?= L('Neno la Wiki · ' . setting('verse_ref_sw'), 'Word of the week · ' . setting('verse_ref_en')) ?></cite>
      </div>
        <div class="actions">
        <a class="btn solid" href="ibada.php"><span lang="sw">Ratiba ya ibada</span><span lang="en">Service times</span></a>
        <a class="btn" href="mawasiliano.php"><span lang="sw">Jinsi ya kufika</span><span lang="en">How to find us</span></a>
      </div>
      </div>
    </div>
    <aside class="board" aria-labelledby="boardTitle">
      <svg class="board-cross" viewBox="0 0 78 118" aria-hidden="true"><path d="M31 4h16v28h27v16H47v66H31V48H4V32h27z" fill="none" stroke="currentColor" stroke-width="4" stroke-linejoin="round"/></svg>
      <h2 id="boardTitle"><span lang="sw">Ibada za Jumapili</span><span lang="en">Sunday worship</span></h2>
      <p class="sub"><span lang="sw">Kila Jumapili, kanisani Wazo</span><span lang="en">Every Sunday at the Wazo church</span></p>
      <ul class="services">
        <?php foreach ($services as $sv): ?>
        <li>
          <div class="t"><span lang="sw"><?= e($sv['time_sw']) ?><small><?= e($sv['period_sw']) ?></small></span><span lang="en"><?= e($sv['time_en']) ?><small><?= e($sv['period_en']) ?></small></span></div>
          <div class="n"><?= L($sv['name_sw'], $sv['name_en']) ?></div>
          <div class="d"><?= L($sv['short_sw'], $sv['short_en']) ?></div>
        </li>
        <?php endforeach; ?>
      </ul>
    </aside>
  </div>
</section>

<section>
  <div class="wrap quick">
    <a class="c-purple" href="matangazo.php"><span class="qi" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M6 16V11a6 6 0 0 1 12 0v5l1.5 2h-15z"/><path d="M10 20a2 2 0 0 0 4 0"/></svg></span><span class="qt"><b><span lang="sw">Matangazo</span><span lang="en">Announcements</span></b><span><span lang="sw">Habari za wiki</span><span lang="en">This week's news</span></span></span><svg class="qc" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg><svg class="qw" aria-hidden="true" viewBox="0 0 24 24"><path d="M6 16V11a6 6 0 0 1 12 0v5l1.5 2h-15z"/><path d="M10 20a2 2 0 0 0 4 0"/></svg></a>
    <a class="c-gold" href="mahubiri.php"><span class="qi" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 6c3-1 6-1 9 1v12c-3-2-6-2-9-1z"/><path d="M21 6c-3-1-6-1-9 1v12c3-2 6-2 9-1z"/></svg></span><span class="qt"><b><span lang="sw">Mahubiri</span><span lang="en">Sermons</span></b><span><span lang="sw">Tazama kwenye YouTube</span><span lang="en">Watch on YouTube</span></span></span><svg class="qc" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg><svg class="qw" aria-hidden="true" viewBox="0 0 24 24"><path d="M3 6c3-1 6-1 9 1v12c-3-2-6-2-9-1z"/><path d="M21 6c-3-1-6-1-9 1v12c3-2 6-2 9-1z"/></svg></a>
    <a class="c-green" href="vikundi.php"><span class="qi" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.4"/><path d="M3.5 19c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/><path d="M15 14.2c2.6-.4 4.8 1.1 5.4 4.3"/></svg></span><span class="qt"><b><span lang="sw">Vikundi</span><span lang="en">Fellowships</span></b><span><span lang="sw">Kwaya, vijana na zaidi</span><span lang="en">Choirs, youth and more</span></span></span><svg class="qc" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg><svg class="qw" aria-hidden="true" viewBox="0 0 24 24"><circle cx="9" cy="8" r="3"/><circle cx="17" cy="9" r="2.4"/><path d="M3.5 19c.6-3.2 2.8-5 5.5-5s4.9 1.8 5.5 5"/><path d="M15 14.2c2.6-.4 4.8 1.1 5.4 4.3"/></svg></a>
    <a class="c-red" href="matoleo.php"><span class="qi" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 20s-7-4.4-7-9.5A3.8 3.8 0 0 1 12 8a3.8 3.8 0 0 1 7 2.5C19 15.6 12 20 12 20z"/></svg></span><span class="qt"><b><span lang="sw">Matoleo</span><span lang="en">Giving</span></b><span><span lang="sw">Simu au benki</span><span lang="en">Mobile money or bank</span></span></span><svg class="qc" viewBox="0 0 24 24" aria-hidden="true"><path d="M9 6l6 6-6 6"/></svg><svg class="qw" aria-hidden="true" viewBox="0 0 24 24"><path d="M12 20s-7-4.4-7-9.5A3.8 3.8 0 0 1 12 8a3.8 3.8 0 0 1 7 2.5C19 15.6 12 20 12 20z"/></svg></a>
  </div>
</section>

<?php if ($lead): ?>
<section class="pastor-strip" aria-label="Neno la Mchungaji">
  <div class="wrap">
    <div class="pw">
      <?php if ($lead['photo']): ?><div class="pw-photo"><div class="arch"><img src="<?= img_url($lead['photo']) ?>" alt="<?= e($lead['name']) ?>"></div></div><?php endif; ?>
      <div class="pw-text">
        <span class="tag"><?= Lh('Neno la Mchungaji','A word from our pastor') ?></span>
        <blockquote><?= L(setting('pastor_message_sw'), setting('pastor_message_en')) ?></blockquote>
        <p class="pw-name"><b><?= e($lead['name']) ?></b><span><?= L($lead['role_sw'], $lead['role_en']) ?></span></p>
      </div>
      <a class="pw-link" href="kuhusu.php#uongozi"><?= Lh('Kutana na uongozi','Meet our leaders') ?></a>
    </div>
  </div>
</section>
<?php endif; ?>

<section class="home-more" aria-label="Habari za usharika">
  <div class="wrap more-grid">
    <article class="panel">
      <div class="panel-head"><h2><span lang="sw">Matangazo ya wiki</span><span lang="en">This week's notices</span></h2><a href="matangazo.php"><span lang="sw">Ona yote</span><span lang="en">See all</span></a></div>
      <ul class="mini" id="home-week"></ul>
    </article>
    <article class="panel">
      <div class="panel-head"><h2><span lang="sw">Matukio yajayo</span><span lang="en">Upcoming events</span></h2><a href="matangazo.php"><span lang="sw">Ona yote</span><span lang="en">See all</span></a></div>
      <ul class="mini" id="home-events"></ul>
    </article>
    <article class="panel sermon-panel">
      <div class="panel-head"><h2><span lang="sw">Mahubiri ya karibuni</span><span lang="en">Latest sermon</span></h2><a href="mahubiri.php"><span lang="sw">Ona yote</span><span lang="en">See all</span></a></div>
      <?php if ($sermon): ?>
      <p class="ref"><?= L($sermon['ref_sw'], $sermon['ref_en']) ?></p>
      <h3><?= L($sermon['title_sw'], $sermon['title_en']) ?></h3>
      <p class="by"><?= e($sermon['preacher']) ?> · <?= dshort($sermon['sermon_date']) ?></p>
      <?php endif; ?>
      <a class="listen" href="mahubiri.php"><svg viewBox="0 0 24 24" aria-hidden="true"><path d="M8 5v14l11-7z"/></svg><span lang="sw">Tazama</span><span lang="en">Watch</span></a>
    </article>
  </div>
</section>
</main>
<?php page_end(['MATANGAZO' => matangazo_data()]); ?>
