<?php
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/layout.php';
$albums = [];
foreach (q('SELECT * FROM albums ORDER BY album_date DESC, id DESC') as $a) {
    $ph = q('SELECT path, caption_sw, caption_en FROM photos WHERE album_id=? ORDER BY sort, id', [$a['id']]);
    if (!$ph) continue;
    $albums[] = ['jina' => $a['title_sw'], 'jina_en' => $a['title_en'], 'tarehe' => $a['album_date'], 'kundi' => $a['category'],
        'maelezo' => $a['desc_sw'], 'maelezo_en' => $a['desc_en'],
        'picha' => array_map(fn($p) => ['src' => $p['path'], 'maelezo' => $p['caption_sw'], 'maelezo_en' => $p['caption_en']], $ph)];
}
// The large featured photo: the first real photo of the oldest "ibada" album (the church building), or the bundled photo.
$hero = q1("SELECT a.title_sw, p.path FROM albums a JOIN photos p ON p.album_id=a.id WHERE a.category='ibada' AND p.path NOT LIKE 'ikoni:%' ORDER BY a.album_date, p.sort LIMIT 1");
$heroAlbum = $hero['title_sw'] ?? '';
$heroPhoto = $hero['path'] ?? 'images/kanisa-wazo.jpg';
page_start('Picha');
?>
<main class="page inner">
<section class="pg-head">
  <div class="wrap">
    <p class="kicker"><span lang="sw">Picha za usharika</span><span lang="en">Parish gallery</span></p>
    <h1><span lang="sw">Maisha ya usharika kwa picha</span><span lang="en">Parish life in pictures</span></h1>
    <p class="pg-lede"><span lang="sw">Ibada, kwaya, watoto na matukio ya usharika wa Wazo.</span><span lang="en">Worship, choirs, children and events of the Wazo parish.</span></p>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap g-feature">
    <figure class="g-hero">
      <button type="button" class="gw-frame" data-album="<?= e($heroAlbum) ?>" aria-label="Fungua picha: Jengo la kanisa"><img src="<?= img_url($heroPhoto) ?>" alt="Jengo la kanisa la KKKT Wazo"></button>
    </figure>
    <div class="g-plaque">
      <div class="ornament" aria-hidden="true"><span></span><svg viewBox="0 0 20 28"><path d="M8 0h4v8h8v4h-8v16H8V12H0V8h8z"/></svg><span></span></div>
      <h2><span lang="sw">Nyumba ya Bwana, Wazo</span><span lang="en">The house of the Lord, Wazo</span></h2>
      <blockquote><span lang="sw">“Maskani yako yapendeza kama nini, Ee BWANA wa majeshi!”</span><span lang="en">“How amiable are thy tabernacles, O LORD of hosts!”</span></blockquote>
      <cite><span lang="sw">Zaburi 84:1</span><span lang="en">Psalm 84:1</span></cite>
      <p><span lang="sw">Kila picha ni ushuhuda wa neema ya Mungu katika maisha ya usharika wetu: ibada, nyimbo, sakramenti na furaha ya kuwa pamoja.</span><span lang="en">Every picture is a witness to God's grace in the life of our parish: worship, song, the sacraments and the joy of being together.</span></p>
    </div>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap">
    <div class="chips" role="group" aria-label="Chuja picha / Filter photos"><button type="button" class="chip on" data-cat="zote" aria-pressed="true"><span lang="sw">Zote</span><span lang="en">All</span></button><button type="button" class="chip" data-cat="ibada" aria-pressed="false"><span lang="sw">Ibada</span><span lang="en">Worship</span></button><button type="button" class="chip" data-cat="kwaya" aria-pressed="false"><span lang="sw">Kwaya</span><span lang="en">Choirs</span></button><button type="button" class="chip" data-cat="watoto" aria-pressed="false"><span lang="sw">Watoto</span><span lang="en">Children</span></button><button type="button" class="chip" data-cat="matukio" aria-pressed="false"><span lang="sw">Matukio</span><span lang="en">Events</span></button><button type="button" class="chip" data-cat="uongozi" aria-pressed="false"><span lang="sw">Uongozi</span><span lang="en">Leaders</span></button></div>
    <div class="gwall" id="gwall"></div>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap">
    <div class="g-send">
      <span class="ico lg" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="3" y="6" width="18" height="14" rx="2.5"/><circle cx="12" cy="13" r="3.5"/><path d="M8.5 6l1.5-2.5h4L15.5 6"/></svg></span>
      <div><h3><span lang="sw">Una picha za usharika?</span><span lang="en">Do you have parish photos?</span></h3><p><span lang="sw">Tutumie picha za ibada, kwaya na matukio ili tuziweke hapa.</span><span lang="en">Send us photos of services, choirs and events so we can add them here.</span></p></div>
      <a class="btn solid" href="mailto:<?= e(setting('email')) ?>"><span lang="sw">Tuma picha</span><span lang="en">Send photos</span></a>
    </div>
  </div>
</section>

<div class="lb" id="lb" hidden role="dialog" aria-modal="true" aria-label="Picha">
  <button type="button" class="lb-x" aria-label="Funga / Close">×</button>
  <button type="button" class="lb-nav lb-prev" aria-label="Iliyotangulia / Previous"><svg viewBox="0 0 24 24"><path d="M15 5l-7 7 7 7"/></svg></button>
  <figure class="lb-fig"><div class="lb-media"></div><figcaption class="lb-cap"></figcaption><div class="lb-count"></div></figure>
  <button type="button" class="lb-nav lb-next" aria-label="Inayofuata / Next"><svg viewBox="0 0 24 24"><path d="M9 5l7 7-7 7"/></svg></button>
</div>
</main>
<?php page_end(['PICHA' => $albums]); ?>
