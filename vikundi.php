<?php
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/layout.php';
$groups = q('SELECT * FROM fellowships ORDER BY sort, id');
page_start('Vikundi');
?>
<main class="page inner">
<section class="pg-head">
  <div class="wrap">
    <p class="kicker"><span lang="sw">Idara na vikundi</span><span lang="en">Ministries and fellowships</span></p>
    <h1><span lang="sw">Kuna nafasi kwa kila mmoja</span><span lang="en">There is a place for everyone</span></h1>
    <p class="pg-lede"><span lang="sw">Jiunge na kikundi, ushiriki na utumie karama ambayo Mungu amekupa.</span><span lang="en">Join a group, take part, and use the gifts God has given you.</span></p>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap">
    <div class="grp-grid">
      <?php foreach ($groups as $g): ?>
      <article class="grp">
        <?= icon($g['icon'], 'ico lg') ?>
        <h3><?= L($g['name_sw'], $g['name_en']) ?></h3>
        <p><?= L($g['desc_sw'], $g['desc_en']) ?></p>
        <?php if ($g['meet_sw']): ?><span class="meet"><?= icon('clock', 'ico xs') ?><?= L($g['meet_sw'], $g['meet_en']) ?></span><?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>
</main>
<?php page_end([]); ?>
