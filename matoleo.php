<?php
require __DIR__ . '/inc/bootstrap.php';
require __DIR__ . '/inc/layout.php';

page_start('Matoleo');
?>
<main class="page inner">
<section class="pg-head">
  <div class="wrap">
    <p class="kicker"><span lang="sw">Sadaka na matoleo</span><span lang="en">Offerings and giving</span></p>
    <h1><span lang="sw">Toa kwa moyo wa shukrani</span><span lang="en">Give with a thankful heart</span></h1>
    <p class="pg-lede"><span lang="sw">Matoleo yako yanasaidia ibada, huduma kwa jamii na ujenzi wa usharika.</span><span lang="en">Your giving supports worship, community service and the growth of the parish.</span></p>
  </div>
</section>

<section class="pg-sec">
  <div class="wrap">
    <figure class="verse-big">
      <div class="ornament" aria-hidden="true"><span></span><svg viewBox="0 0 20 28"><path d="M8 0h4v8h8v4h-8v16H8V12H0V8h8z"/></svg><span></span></div>
      <blockquote><span lang="sw">“Kila mtu na atoe kama alivyokusudia moyoni mwake, si kwa huzuni wala si kwa lazima; maana Mungu humpenda yeye atoaye kwa moyo wa ukunjufu.”</span><span lang="en">“Every man according as he purposeth in his heart, so let him give; not grudgingly, or of necessity: for God loveth a cheerful giver.”</span></blockquote>
      <figcaption><span lang="sw">2 Wakorintho 9:7</span><span lang="en">2 Corinthians 9:7</span></figcaption>
    </figure>
    <div class="give2">
      <article class="way2 main">
        <span class="ico lg" aria-hidden="true"><svg viewBox="0 0 24 24"><rect x="6.5" y="2.5" width="11" height="19" rx="2.5"/><path d="M10.5 18.5h3"/></svg></span>
        <h3><span lang="sw">Kwa simu</span><span lang="en">By mobile money</span></h3>
        <p><span lang="sw">M-Pesa, Mixx by Yas au Airtel Money kupitia Lipa Namba ya usharika.</span><span lang="en">M-Pesa, Mixx by Yas or Airtel Money via the parish pay number.</span></p>
        <div class="num"><?= setting('lipa_namba') !== '' ? '<span id="lipa">' . e(setting('lipa_namba')) . '</span>' : '<span class="ph" id="lipa">[Lipa Namba]</span>' ?><button class="copy" type="button" data-copy="lipa"><span lang="sw">Nakili</span><span lang="en">Copy</span></button></div>
      </article>
      <article class="way2">
        <span class="ico lg" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M3 9.5L12 4l9 5.5M5 10v8M9.5 10v8M14.5 10v8M19 10v8M3 20.5h18"/></svg></span>
        <h3><span lang="sw">Kwa benki</span><span lang="en">By bank transfer</span></h3>
        <p><span lang="sw">Jina la akaunti: KKKT Usharika wa Wazo</span><span lang="en">Account name: KKKT Usharika wa Wazo</span></p>
        <div class="num"><?= setting('bank_account') !== '' ? '<span id="bank">' . e(trim(setting('bank_name') . ' · ' . setting('bank_account'), ' ·')) . '</span>' : '<span class="ph" id="bank">[Benki · Namba ya akaunti]</span>' ?><button class="copy" type="button" data-copy="bank"><span lang="sw">Nakili</span><span lang="en">Copy</span></button></div>
      </article>
      <article class="way2">
        <span class="ico lg" aria-hidden="true"><svg viewBox="0 0 24 24"><path d="M12 2v4M10.5 3.5h3M12 6l5 4v11H7V10z"/><path d="M10 21v-4a2 2 0 0 1 4 0v4M3 21h18"/></svg></span>
        <h3><span lang="sw">Kanisani</span><span lang="en">In church</span></h3>
        <p><span lang="sw">Toa sadaka wakati wa ibada, au ofisini ambapo utapewa risiti.</span><span lang="en">Give during the service, or at the parish office where you will receive a receipt.</span></p>
      </article>
    </div>
  </div>
</section>
</main>
<?php page_end([]); ?>
