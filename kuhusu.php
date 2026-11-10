<?php
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/layout.php';
$leaders = [];
foreach (q('SELECT * FROM leaders ORDER BY sort, id') as $r) $leaders[$r['tier']][] = $r;
/** Show a value, or a gold placeholder when it is empty. */
function ph(string $v, string $placeholder): string { return $v !== '' ? e($v) : '<span class="ph">' . e($placeholder) . '</span>'; }
page_start('Kuhusu');
?>
<main class="page about inner">
<section class="pg-head">
  <div class="wrap">
    <p class="kicker"><span lang="sw">Kanisa la Kiinjili la Kilutheri Tanzania</span><span lang="en">Evangelical Lutheran Church in Tanzania</span></p>
    <h1><span lang="sw">Kuhusu usharika wetu</span><span lang="en">About our parish</span></h1>
    <p class="pg-lede"><span lang="sw">Familia ya waumini wa Kilutheri inayokutana Wazo, Dar es Salaam, kumwabudu Mungu, kujifunza Neno lake na kuhudumiana.</span><span lang="en">A Lutheran family of believers gathering in Wazo, Dar es Salaam, to worship God, learn His Word and serve one another.</span></p>
  </div>
</section>

<section class="pg-sec tight">
  <div class="wrap stats">
    <div class="stat"><?= icon('church') ?><div><span><?= Lh('Dayosisi','Diocese') ?></span><b><?= L(setting('diocese_sw'), setting('diocese_en')) ?></b></div></div>
    <div class="stat"><?= icon('map') ?><div><span><?= Lh('Jimbo','District') ?></span><b><?= L(setting('district_sw'), setting('district_en')) ?></b></div></div>
    <div class="stat"><?= icon('pin') ?><div><span><?= Lh('Mitaa','Preaching points') ?></span><b><?= e(setting('preaching_points')) ?></b></div></div>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap hist-grid">
    <figure class="hist-photo">
      <div class="arch"><img src="images/kanisa-wazo.jpg" alt="Jengo la kanisa la KKKT Wazo"></div>
      <figcaption><span lang="sw">Kanisa la KKKT Usharika wa Wazo</span><span lang="en">KKKT Wazo parish church</span></figcaption>
    </figure>
    <div>
      <h2 class="hist-title"><span lang="sw">Historia yetu</span><span lang="en">Our history</span></h2>
      <ol class="hist">
        <li><span class="yr"><?= ph(setting('history_start_year'), '[mwaka]') ?></span><b><?= Lh('Mwanzo mdogo','A small beginning') ?></b><p><span lang="sw">Waumini wachache walianza kukutana <?= ph(setting('history_start_place'), '[mahali]') ?> kama mtaa wa kuhubiria.</span><span lang="en">A few believers began meeting at <?= ph(setting('history_start_place'), '[place]') ?> as a preaching point.</span></p></li>
        <li><span class="yr"><?= ph(setting('history_parish_year'), '[mwaka]') ?></span><b><?= Lh('Usharika kamili','A full parish') ?></b><p><?= Lh('Kwa neema ya Mungu mtaa ulikua na kuzinduliwa rasmi kuwa usharika.','By God&#39;s grace the preaching point grew and was officially inaugurated as a parish.') ?></p></li>
        <li><span class="yr"><?= Lh('Leo','Today') ?></span><b><?= Lh('Usharika unaokua','A growing parish') ?></b><p><span lang="sw">Waumini zaidi ya <?= ph(setting('history_members'), '[idadi]') ?> na mitaa <?= e(setting('preaching_points')) ?>, tukihudumia Wazo na maeneo jirani kupitia ibada, vikundi na huduma kwa jamii.</span><span lang="en">More than <?= ph(setting('history_members'), '[number]') ?> members and <?= e(setting('preaching_points')) ?> preaching points, serving Wazo and nearby areas through worship, fellowships and community service.</span></p></li>
      </ol>
    </div>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap">
    <div class="sub-head"><div class="ornament" aria-hidden="true"><span></span><svg viewBox="0 0 20 28"><path d="M8 0h4v8h8v4h-8v16H8V12H0V8h8z"/></svg><span></span></div><h2><span lang="sw">Tunachoamini</span><span lang="en">What we believe</span></h2><p class="ab-sub"><span lang="sw">Kama Walutheri, imani yetu imesimama juu ya misingi mitatu.</span><span lang="en">As Lutherans, our faith rests on three foundations.</span></p></div>
    <div class="beliefs">
      <article><span class="ico lg" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3.5" y="9" width="17" height="11.5" rx="1.5"/><path d="M3.5 13h17M12 9v11.5M12 9c-1.5-3-5-4-5-1.5S10 9 12 9zM12 9c1.5-3 5-4 5-1.5S14 9 12 9z"/></svg></span><h3><span lang="sw">Neema peke yake</span><span lang="en">Grace alone</span></h3><p><span lang="sw">Tunaokolewa kwa neema ya Mungu, si kwa matendo yetu.</span><span lang="en">We are saved by God's grace, not by our own works.</span></p><cite><span lang="sw">Waefeso 2:8</span><span lang="en">Ephesians 2:8</span></cite></article>
      <article><span class="ico lg" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 20s-7-4.4-7-9.5A3.8 3.8 0 0 1 12 8a3.8 3.8 0 0 1 7 2.5C19 15.6 12 20 12 20z"/></svg></span><h3><span lang="sw">Imani peke yake</span><span lang="en">Faith alone</span></h3><p><span lang="sw">Tunahesabiwa haki kwa imani katika Yesu Kristo.</span><span lang="en">We are made right with God through faith in Jesus Christ.</span></p><cite><span lang="sw">Warumi 3:28</span><span lang="en">Romans 3:28</span></cite></article>
      <article><span class="ico lg" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 6c3-1 6-1 9 1v12c-3-2-6-2-9-1z"/><path d="M21 6c-3-1-6-1-9 1v12c3-2 6-2 9-1z"/></svg></span><h3><span lang="sw">Maandiko peke yake</span><span lang="en">Scripture alone</span></h3><p><span lang="sw">Biblia ni Neno la Mungu na mwongozo wa imani na maisha yetu.</span><span lang="en">The Bible is God's Word and the guide for our faith and life.</span></p><cite><span lang="sw">2 Timotheo 3:16</span><span lang="en">2 Timothy 3:16</span></cite></article>
    </div>
  </div>
</section>

<section class="ab-lead" id="uongozi">
  <div class="wrap">
    <div class="ornament" aria-hidden="true"><span></span><svg viewBox="0 0 20 28"><path d="M8 0h4v8h8v4h-8v16H8V12H0V8h8z"/></svg><span></span></div>
    <h2><span lang="sw">Uongozi wa usharika</span><span lang="en">Parish leadership</span></h2>
    <p class="ab-sub"><span lang="sw">Wachungaji na watumishi wanaoongoza na kuhudumia usharika wa Wazo.</span><span lang="en">The pastors and servants who lead and serve the Wazo parish.</span></p>
    <?php foreach (['pastor' => 'pastors', 'staff' => 'staff'] as $tier => $cls): ?>
    <div class="ab-row <?= $cls ?>">
      <?php foreach ($leaders[$tier] ?? [] as $p): ?>
      <figure class="ab-person<?= $tier === 'pastor' ? ' big' : '' ?>">
        <div class="arch"><?php if ($p['photo']): ?><img src="<?= img_url($p['photo']) ?>" alt="<?= e($p['name']) ?>"><?php else: ?><svg class="sil" viewBox="0 0 100 120" aria-hidden="true"><circle cx="50" cy="44" r="20"/><path d="M12 120c2-26 18-40 38-40s36 14 38 40z"/></svg><?php endif; ?></div>
        <figcaption><b><?= e($p['name']) ?></b><span><?= L($p['role_sw'], $p['role_en']) ?></span></figcaption>
      </figure>
      <?php endforeach; ?>
    </div>
    <?php endforeach; ?>
  </div>
</section>
</main>
<?php page_end([]); ?>
