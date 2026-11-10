<?php
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/layout.php';
page_start('Mawasiliano');
?>
<main class="page inner">
<section class="pg-head">
  <div class="wrap">
    <p class="kicker"><span lang="sw">Mawasiliano</span><span lang="en">Contact</span></p>
    <h1><span lang="sw">Karibu utembelee</span><span lang="en">Come and visit us</span></h1>
    <p class="pg-lede"><span lang="sw">Tunapatikana Wazo, Dar es Salaam. Karibu kwenye ibada au ofisini.</span><span lang="en">We are in Wazo, Dar es Salaam. You are welcome at a service or at the office.</span></p>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap contact2">
    <div class="c-card">
      <ul class="c-list">
        <li><?= icon('pin') ?><div><span class="lbl"><?= Lh('Mahali','Location') ?></span><b><?= e(setting('address')) ?></b></div></li>
        <li><?= icon('call') ?><div><span class="lbl"><?= Lh('Simu','Phone') ?></span><b><?php if (setting('phone')): ?><a class="tel" href="tel:<?= e(preg_replace('/\s+/', '', setting('phone'))) ?>"><?= e(setting('phone')) ?></a><?php else: ?><span class="ph">+255 [namba]</span><?php endif; ?></b></div></li>
        <li><?= icon('mail') ?><div><span class="lbl"><?= Lh('Barua pepe','Email') ?></span><b><?php if (setting('email')): ?><a class="tel" href="mailto:<?= e(setting('email')) ?>"><?= e(setting('email')) ?></a><?php else: ?><span class="ph">[barua pepe]</span><?php endif; ?></b></div></li>
        <?php if (setting('pobox')): ?><li><?= icon('box') ?><div><span class="lbl"><?= Lh('Sanduku la Posta','P.O. Box') ?></span><b><?= e(setting('pobox')) ?></b></div></li><?php endif; ?>
      </ul>
      <div class="hours">
        <span class="ico sm" aria-hidden="true"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="8.5"/><path d="M12 7.5V12l3 2"/></svg></span>
        <div><b><?= Lh('Saa za ofisi','Office hours') ?></b><span><?= L(setting('office_hours_sw'), setting('office_hours_en')) ?></span></div>
      </div>
    </div>
    <div class="map map2">
      <canvas id="mapCanvas" aria-label="Wazo map illustration" role="img"></canvas>
      <a class="btn solid" href="https://www.google.com/maps/search/KKKT+Wazo+Dar+es+Salaam"><span lang="sw">Fungua ramani</span><span lang="en">Open in Maps</span></a>
    </div>
  </div>
</section>
</main>
<?php page_end(); ?>
