<?php
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/layout.php';

page_start('Matangazo');
?>
<main class="page inner">
<section class="pg-head">
  <div class="wrap">
    <p class="kicker"><span lang="sw">Matangazo na matukio</span><span lang="en">News and events</span></p>
    <h1><span lang="sw">Habari za usharika</span><span lang="en">Parish news</span></h1>
    <p class="pg-lede"><span lang="sw">Matangazo ya wiki kutoka ofisi ya usharika, na matukio yanayokuja.</span><span lang="en">This week's notices from the parish office, and upcoming events.</span></p>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap">
    <div class="sub-head"><div class="ornament" aria-hidden="true"><span></span><svg viewBox="0 0 20 28"><path d="M8 0h4v8h8v4h-8v16H8V12H0V8h8z"/></svg><span></span></div><h2><span lang="sw">Kumbukumbu za muda mrefu</span><span lang="en">Ongoing notices</span></h2><p class="ab-sub"><span lang="sw">Mambo yanayoendelea kwa wiki kadhaa. Usisahau!</span><span lang="en">Things running over several weeks. Please remember!</span></p></div>
    <div class="long-grid" id="mt-long"></div>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap news2">
    <div>
      <h2 class="week-title" id="mt-week-title"></h2>
      <p class="en-note">Weekly announcements are published in Kiswahili. Where no English version is given, the Kiswahili text is shown.</p>
      <ol class="ann-list" id="mt-week"></ol>
      <div class="past" id="mt-past"></div>
    </div>
    <aside class="ev-card">
      <h2><span class="ico sm" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3.5" y="5" width="17" height="15" rx="2"/><path d="M3.5 10h17M8 3v4M16 3v4"/></svg></span><span lang="sw">Matukio yajayo</span><span lang="en">Upcoming events</span></h2>
      <ol class="ev-line" id="mt-events"></ol>
    </aside>
  </div>
</section>
</main>
<?php page_end(['MATANGAZO' => matangazo_data()]); ?>
