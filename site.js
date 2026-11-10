/* ================= LIVE STREAM SETTINGS (edit here) =================
   channelId : the church's YouTube channel ID (starts with "UC..."). Needed for live mode.
   schedule  : when the site should show "Mubashara" (live). day: 0 = Sunday ... 6 = Saturday.
               Times are Tanzania time (East Africa Time).
   force     : set to true to switch live mode on right now (e.g. Christmas Eve, a funeral).
   ====================================================================== */
var LIVE_CONFIG = {
  channelId: '',
  schedule: [ { day: 0, start: '06:45', end: '12:30' } ],
  force: false
};
(function(){
  var root=document.documentElement, sw=document.getElementById('btnSw'), en=document.getElementById('btnEn');
  function setLang(l){
    root.setAttribute('lang',l);
    sw.setAttribute('aria-pressed',l==='sw');en.setAttribute('aria-pressed',l==='en');
    try{localStorage.setItem('wazo-lang',l)}catch(e){}
  }
  var saved=null;try{saved=localStorage.getItem('wazo-lang')}catch(e){}
  setLang(saved==='en'?'en':'sw');
  sw.addEventListener('click',function(){setLang('sw')});
  en.addEventListener('click',function(){setLang('en')});

  var btn=document.getElementById('menuBtn'), nav=document.getElementById('nav');
  btn.addEventListener('click',function(){var o=nav.classList.toggle('open');btn.setAttribute('aria-expanded',o)});
  nav.addEventListener('click',function(e){if(e.target.closest('a')){nav.classList.remove('open');btn.setAttribute('aria-expanded','false')}});

  document.querySelectorAll('.copy').forEach(function(b){
    b.addEventListener('click',function(){
      var t=document.getElementById(b.dataset.copy).textContent;
      var done=function(){var o=b.innerHTML;b.textContent=root.lang==='sw'?'Imenakiliwa':'Copied';setTimeout(function(){b.innerHTML=o},1600)};
      if(navigator.clipboard){navigator.clipboard.writeText(t).then(done,function(){})}
    });
  });

  // stylised map of the Wazo coast: sea to the east, Bagamoyo Road, church marker
  var c=document.getElementById('mapCanvas');
  function draw(){
    var r=c.getBoundingClientRect(),d=window.devicePixelRatio||1;c.width=r.width*d;c.height=r.height*d;
    var x=c.getContext('2d');x.scale(d,d);var w=r.width,h=r.height,cs=getComputedStyle(root);
    var sky=cs.getPropertyValue('--sky').trim(),gold=cs.getPropertyValue('--gold').trim(),line=cs.getPropertyValue('--line').trim(),heart=cs.getPropertyValue('--heart').trim(),muted=cs.getPropertyValue('--muted').trim();
    x.strokeStyle=line;x.lineWidth=1;
    for(var i=0;i<w;i+=28){x.beginPath();x.moveTo(i,0);x.lineTo(i,h);x.stroke()}
    for(var j=0;j<h;j+=28){x.beginPath();x.moveTo(0,j);x.lineTo(w,j);x.stroke()}
    x.fillStyle='#2f6a94';x.globalAlpha=.85;x.beginPath();x.moveTo(w*.78,0);
    x.bezierCurveTo(w*.70,h*.3,w*.86,h*.55,w*.76,h);x.lineTo(w,h);x.lineTo(w,0);x.closePath();x.fill();x.globalAlpha=1;
    x.strokeStyle=gold;x.lineWidth=6;x.lineCap='round';x.beginPath();x.moveTo(w*.12,h);x.bezierCurveTo(w*.3,h*.65,w*.45,h*.4,w*.62,0);x.stroke();
    x.strokeStyle=muted;x.globalAlpha=.45;x.lineWidth=2;x.beginPath();x.moveTo(w*.38,h*.52);x.lineTo(w*.58,h*.58);x.lineTo(w*.66,h*.48);x.stroke();x.globalAlpha=1;
    var px=w*.56,py=h*.42;x.fillStyle=heart;x.beginPath();x.arc(px,py,11,0,Math.PI*2);x.fill();
    x.strokeStyle='#fff';x.lineWidth=3;x.beginPath();x.moveTo(px,py-6);x.lineTo(px,py+6);x.moveTo(px-5,py-1);x.lineTo(px+5,py-1);x.stroke();
    x.fillStyle=cs.getPropertyValue('--ink').trim();x.font='600 14px Figtree, sans-serif';x.fillText('KKKT Wazo',px+18,py+5);
    x.fillStyle=muted;x.font='italic 13px "Libre Caslon Text", serif';x.save();x.translate(w*.25,h*.74);x.rotate(-0.9);x.fillText('Bagamoyo Rd',0,0);x.restore();
    x.fillStyle='#fff';x.globalAlpha=.8;x.textAlign='right';x.fillText(root.lang==='sw'?'Bahari ya Hindi':'Indian Ocean',w-10,h*.25);x.textAlign='left';x.globalAlpha=1;
  }

  // ---- illustrated placeholder scenes ----
  function rr(x,a,b,w,h,r){x.beginPath();x.moveTo(a+r,b);x.arcTo(a+w,b,a+w,b+h,r);x.arcTo(a+w,b+h,a,b+h,r);x.arcTo(a,b+h,a,b,r);x.arcTo(a,b,a+w,b,r);x.closePath()}
  function person(x,cx,by,s,robe,skin){x.fillStyle=robe;x.beginPath();x.moveTo(cx-s*.55,by);x.quadraticCurveTo(cx-s*.5,by-s*1.1,cx,by-s*1.15);x.quadraticCurveTo(cx+s*.5,by-s*1.1,cx+s*.55,by);x.fill();x.fillStyle=skin||'#5b3a26';x.beginPath();x.arc(cx,by-s*1.35,s*.32,0,7);x.fill()}
  function sky(x,w,h,c1,c2){var g=x.createLinearGradient(0,0,0,h);g.addColorStop(0,c1);g.addColorStop(1,c2);x.fillStyle=g;x.fillRect(0,0,w,h)}
  function churchBuilding(x,cx,gy,s,wall,roof){
    x.fillStyle=wall;x.fillRect(cx-s*1.1,gy-s*1.1,s*2.2,s*1.1);
    x.fillStyle=roof;x.beginPath();x.moveTo(cx-s*1.25,gy-s*1.1);x.lineTo(cx,gy-s*1.75);x.lineTo(cx+s*1.25,gy-s*1.1);x.fill();
    x.fillStyle=wall;x.fillRect(cx+s*.55,gy-s*2.1,s*.5,s*1.0);
    x.fillStyle=roof;x.beginPath();x.moveTo(cx+s*.5,gy-s*2.1);x.lineTo(cx+s*.8,gy-s*2.55);x.lineTo(cx+s*1.1,gy-s*2.1);x.fill();
    x.strokeStyle='#e8c25a';x.lineWidth=Math.max(2,s*.05);x.beginPath();x.moveTo(cx+s*.8,gy-s*2.55);x.lineTo(cx+s*.8,gy-s*2.9);x.moveTo(cx+s*.68,gy-s*2.78);x.lineTo(cx+s*.92,gy-s*2.78);x.stroke();
    x.fillStyle='#3a2318';rr(x,cx-s*.22,gy-s*.62,s*.44,s*.62,s*.2);x.fill();
    x.fillStyle='#f3d27a';[-.75,.55].forEach(function(o){rr(x,cx+s*o,gy-s*.85,s*.22,s*.4,s*.1);x.fill()});
    x.beginPath();x.arc(cx,gy-s*1.32,s*.14,0,7);x.fill();
  }
  function palm(x,px,gy,s){x.strokeStyle='#4a3a2a';x.lineWidth=s*.08;x.beginPath();x.moveTo(px,gy);x.quadraticCurveTo(px+s*.15,gy-s*.8,px+s*.05,gy-s*1.6);x.stroke();
    x.strokeStyle='#2f6b4c';x.lineWidth=s*.07;x.lineCap='round';for(var i=0;i<6;i++){var a=-Math.PI/2+(i-2.5)*.55;x.beginPath();x.moveTo(px+s*.05,gy-s*1.6);x.quadraticCurveTo(px+Math.cos(a)*s*.5,gy-s*1.6+Math.sin(a)*s*.3-s*.1,px+Math.cos(a)*s*.8,gy-s*1.6+Math.sin(a)*s*.2+s*.25);x.stroke()}}
  var scenes={
    church:function(x,w,h){sky(x,w,h,'#f6c27a','#e9a3a0');x.fillStyle='#fff3c4';x.beginPath();x.arc(w*.2,h*.32,h*.12,0,7);x.fill();
      x.fillStyle='#7a5aa0';x.beginPath();x.moveTo(0,h*.72);x.quadraticCurveTo(w*.3,h*.55,w*.6,h*.7);x.quadraticCurveTo(w*.85,h*.6,w,h*.68);x.lineTo(w,h);x.lineTo(0,h);x.fill();
      x.fillStyle='#3f6b3f';x.fillRect(0,h*.82,w,h*.18);churchBuilding(x,w*.52,h*.84,h*.28,'#fbf6ee','#7a2531');palm(x,w*.12,h*.86,h*.35);palm(x,w*.88,h*.86,h*.3);
      for(var i=0;i<5;i++)person(x,w*(.36+i*.06),h*.95,h*.06,['#4a2370','#c79a2e','#a01c34','#2f6b4c','#fff'][i])},
    church2:function(x,w,h){sky(x,w,h,'#2a1748','#a2507a');x.fillStyle='#fff';for(var i=0;i<20;i++){x.globalAlpha=.6;x.fillRect((i*97)%w,(i*53)%(h*.5),2,2)}x.globalAlpha=1;
      x.fillStyle='#1c1230';x.fillRect(0,h*.8,w,h*.2);churchBuilding(x,w*.5,h*.82,h*.25,'#3b2a55','#20132f');palm(x,w*.15,h*.84,h*.3)},
    congregation:function(x,w,h){sky(x,w,h,'#efe6d8','#d9c8b0');
      x.fillStyle='#f6e7b5';rr(x,w*.42,h*.08,w*.16,h*.38,w*.08);x.fill();x.fillStyle='#4a2370';x.globalAlpha=.25;rr(x,w*.44,h*.1,w*.12,h*.34,w*.06);x.fill();x.globalAlpha=1;
      x.fillStyle='#c79a2e';x.fillRect(w*.495,h*.14,w*.01,h*.24);x.fillRect(w*.47,h*.2,w*.06,h*.015);
      x.fillStyle='#6b4a2e';x.fillRect(w*.3,h*.46,w*.4,h*.06);x.fillStyle='#fff';x.fillRect(w*.3,h*.46,w*.4,h*.02);x.fillStyle='#4a2370';x.fillRect(w*.47,h*.46,w*.06,h*.06);
      var robes=['#4a2370','#a01c34','#2f6b4c','#c79a2e','#2f6a94','#d06a3a','#fff'];
      for(var r=0;r<4;r++){var y=h*(.66+r*.11),n=7+r;x.fillStyle='#7a5434';x.fillRect(0,y+h*.02,w,h*.03);for(var i=0;i<n;i++){var cx=w*(i+.5)/n+(r%2)*w*.03;x.fillStyle=robes[(i+r)%7];x.beginPath();x.ellipse(cx,y+h*.02,w*.035+r*2,h*.05,0,Math.PI,0);x.fill();x.fillStyle='#2b1a12';x.beginPath();x.arc(cx,y-h*.04,h*.03+r*1.5,0,7);x.fill()}}},
    choir:function(x,w,h){sky(x,w,h,'#4a2370','#2e1449');x.fillStyle='rgba(199,154,46,.25)';x.beginPath();x.arc(w*.5,h*.1,w*.5,0,7);x.fill();
      for(var r=0;r<3;r++){var n=6-r%2,y=h*(.36+r*.2);for(var i=0;i<n;i++){var cx=w*(i+.5)/n;person(x,cx,y+h*.12,h*.12,r==0?'#c79a2e':'#f7f3fb');x.fillStyle='#a01c34';x.fillRect(cx-h*.02,y-h*.0,h*.04,h*.1)}}},
    candles:function(x,w,h){sky(x,w,h,'#1d1226','#3a2340');var g=x.createRadialGradient(w*.5,h*.45,5,w*.5,h*.45,w*.6);g.addColorStop(0,'rgba(255,210,120,.5)');g.addColorStop(1,'rgba(255,210,120,0)');x.fillStyle=g;x.fillRect(0,0,w,h);
      x.fillStyle='#fff';x.fillRect(w*.15,h*.68,w*.7,h*.08);x.fillStyle='#4a2370';x.fillRect(w*.42,h*.68,w*.16,h*.32);x.fillStyle='#c79a2e';x.fillRect(w*.485,h*.25,w*.03,h*.4);x.fillRect(w*.43,h*.33,w*.14,h*.03);
      [.25,.35,.65,.75].forEach(function(o){x.fillStyle='#f4eedf';x.fillRect(w*o-4,h*.48,8,h*.2);x.fillStyle='#ffd27a';x.beginPath();x.ellipse(w*o,h*.45,4,9,0,0,7);x.fill()});
      x.fillStyle='#c79a2e';x.beginPath();x.ellipse(w*.5,h*.66,w*.05,h*.02,0,0,7);x.fill();x.fillRect(w*.485,h*.6,w*.03,h*.06)},
    bible:function(x,w,h){sky(x,w,h,'#e8d9c2','#cdb592');x.fillStyle='#5a3a22';rr(x,w*.12,h*.3,w*.76,h*.5,10);x.fill();
      x.fillStyle='#fbf6ea';x.beginPath();x.moveTo(w*.5,h*.36);x.quadraticCurveTo(w*.32,h*.28,w*.16,h*.34);x.lineTo(w*.16,h*.74);x.quadraticCurveTo(w*.32,h*.68,w*.5,h*.76);x.quadraticCurveTo(w*.68,h*.68,w*.84,h*.74);x.lineTo(w*.84,h*.34);x.quadraticCurveTo(w*.68,h*.28,w*.5,h*.36);x.fill();
      x.strokeStyle='#bfae90';x.lineWidth=2;for(var i=0;i<6;i++){var y=h*(.42+i*.05);x.beginPath();x.moveTo(w*.21,y);x.lineTo(w*.45,y+2);x.moveTo(w*.55,y+2);x.lineTo(w*.79,y);x.stroke()}
      x.fillStyle='#a01c34';x.fillRect(w*.495,h*.36,w*.012,h*.5)},
    children:function(x,w,h){sky(x,w,h,'#bfe0ef','#e9f3e3');x.fillStyle='#fff6c8';x.beginPath();x.arc(w*.85,h*.2,h*.1,0,7);x.fill();x.fillStyle='#5c9a5a';x.fillRect(0,h*.75,w,h*.25);
      x.fillStyle='#6b4a2e';x.fillRect(w*.12,h*.4,w*.04,h*.36);x.fillStyle='#2f6b4c';x.beginPath();x.arc(w*.14,h*.38,h*.18,0,7);x.fill();
      var c=['#a01c34','#c79a2e','#4a2370','#2f6a94','#d06a3a','#2f6b4c'];for(var i=0;i<6;i++)person(x,w*(.3+i*.11),h*.86,h*(.13+(i%2)*.03),c[i]);person(x,w*.24,h*.86,h*.22,'#4a2370')}
  };
  function drawScenes(){document.querySelectorAll('canvas[data-scene]').forEach(function(cv){var r=cv.parentNode.getBoundingClientRect(),d=window.devicePixelRatio||1;if(!r.width)return;cv.width=r.width*d;cv.height=r.height*d;cv.style.height=r.height+'px';var x=cv.getContext('2d');x.scale(d,d);x.lineCap='round';(scenes[cv.dataset.scene]||function(){})(x,r.width,r.height)})}
  drawScenes();window.addEventListener('resize',drawScenes);
  if(c){draw();window.addEventListener('resize',draw);
  [sw,en].forEach(function(b){b.addEventListener('click',draw)});
  if(window.matchMedia)matchMedia('(prefers-color-scheme: dark)').addEventListener('change',draw);}


  // ---- YouTube sermons: set data-yt="VIDEO_ID" in mahubiri.html to connect a video ----
  var player=document.querySelector('.yt');
  function ytThumb(el,id){var t=el.querySelector('.yt-thumb');if(t&&id)t.style.backgroundImage='url(https://i.ytimg.com/vi/'+id+'/hqdefault.jpg)'}
  document.querySelectorAll('[data-yt]').forEach(function(el){var id=(el.getAttribute('data-yt')||'').trim();if(id){el.classList.add('has-video');ytThumb(el,id)}});
  function playIn(box,id,src){
    box.classList.add('playing');
    var f=document.createElement('iframe');
    f.src=src||('https://www.youtube-nocookie.com/embed/'+id+'?autoplay=1&rel=0');
    f.title='Mahubiri';f.allow='autoplay; encrypted-media; picture-in-picture';f.allowFullscreen=true;
    box.appendChild(f);
  }
  if(player){
    player.querySelector('.yt-play').addEventListener('click',function(){var id=player.getAttribute('data-yt');if(id)playIn(player,id)});
    var rows=document.querySelectorAll('.s-list .srow');
    if(rows[0])rows[0].classList.add('current');
    rows.forEach(function(r){
      r.addEventListener('click',function(){
        rows.forEach(function(x){x.classList.remove('current')});r.classList.add('current');
        var id=(r.getAttribute('data-yt')||'').trim();
        var f=document.getElementById('sermon-player');
        f.querySelector('[data-f="ref"]').innerHTML='<span lang="sw">'+r.dataset.refSw+'</span><span lang="en">'+r.dataset.refEn+'</span>';
        f.querySelector('[data-f="title"]').innerHTML='<span lang="sw">'+r.dataset.titleSw+'</span><span lang="en">'+r.dataset.titleEn+'</span>';
        f.querySelector('[data-f="by"]').textContent=r.dataset.by;
        var old=player.querySelector('iframe');if(old)old.remove();
        player.classList.remove('playing','has-video');player.querySelector('.yt-thumb').style.backgroundImage='';
        player.setAttribute('data-yt',id);
        if(id){player.classList.add('has-video');ytThumb(player,id);playIn(player,id)}
        f.scrollIntoView({behavior:window.matchMedia&&matchMedia('(prefers-reduced-motion: reduce)').matches?'auto':'smooth',block:'start'});
      });
    });
  }

  // ---- Live service mode ----
  function eatNow(){
    var p={};new Intl.DateTimeFormat('en-GB',{timeZone:'Africa/Dar_es_Salaam',weekday:'short',hour:'2-digit',minute:'2-digit',hour12:false}).formatToParts(new Date()).forEach(function(x){p[x.type]=x.value});
    return {day:['Sun','Mon','Tue','Wed','Thu','Fri','Sat'].indexOf(p.weekday),mins:(+p.hour%24)*60+(+p.minute)};
  }
  function toMins(t){var a=t.split(':');return +a[0]*60+ +a[1]}
  var cfgL=window.LIVE_CONFIG||LIVE_CONFIG, now=eatNow();
  var inSlot=cfgL.schedule.some(function(s){return s.day===now.day&&now.mins>=toMins(s.start)&&now.mins<toMins(s.end)});
  var isLive=!!cfgL.channelId&&(cfgL.force||inSlot);
  if(/[?&]live=1/.test(location.search))isLive=true; // preview: add ?live=1 to the address
  var liveSrc=cfgL.channelId?'https://www.youtube-nocookie.com/embed/live_stream?channel='+cfgL.channelId+'&autoplay=1':'';
  var dot='<span class="live-dot" aria-hidden="true"></span>';
  if(isLive){
    document.documentElement.classList.add('is-live');
    var bar=document.querySelector('header .bar'),lang=bar&&bar.querySelector('.lang');
    if(bar){var b=document.createElement('a');b.className='live-badge';b.href='mahubiri.html#sermon-player';b.innerHTML=dot+'<span lang="sw">Mubashara</span><span lang="en">Live</span>';bar.insertBefore(b,lang)}
    var bi=document.querySelector('.top-grid .banner-inner');
    if(bi){var l=document.createElement('a');l.className='live-pill';l.href='mahubiri.html#sermon-player';l.innerHTML=dot+'<span><b><span lang="sw">Ibada inaendelea mubashara</span><span lang="en">Service is live now</span></b> <span lang="sw">Tazama sasa</span><span lang="en">Watch now</span></span>';bi.insertBefore(l,bi.firstChild)}
    if(player){
      player.classList.add('is-live','has-video');player.classList.remove('playing');
      var lb=document.createElement('span');lb.className='yt-live';lb.innerHTML=dot+'<span lang="sw">Mubashara</span><span lang="en">Live</span>';player.appendChild(lb);
      var fb=document.getElementById('sermon-player');
      fb.querySelector('.tag').innerHTML='<span lang="sw">Ibada mubashara</span><span lang="en">Live service</span>';
      fb.querySelector('[data-f="ref"]').innerHTML='<span lang="sw">Moja kwa moja kutoka Wazo</span><span lang="en">Streaming from Wazo</span>';
      fb.querySelector('[data-f="title"]').innerHTML='<span lang="sw">Ibada ya Jumapili</span><span lang="en">Sunday service</span>';
      fb.querySelector('[data-f="by"]').innerHTML='<span lang="sw">Bonyeza kucheza ili kujiunga nasi</span><span lang="en">Press play to join us</span>';
      var pb=player.querySelector('.yt-play'),np=pb.cloneNode(true);pb.parentNode.replaceChild(np,pb);
      np.addEventListener('click',function(){playIn(player,null,liveSrc)});
    }
  }

  // ---- Matangazo: rendered from data/matangazo.js ----
  var M=window.MATANGAZO;
  if(M){
    var MON=['Januari','Februari','Machi','Aprili','Mei','Juni','Julai','Agosti','Septemba','Oktoba','Novemba','Desemba'],
        MON_EN=['January','February','March','April','May','June','July','August','September','October','November','December'],
        MS=['Jan','Feb','Mac','Apr','Mei','Jun','Jul','Ago','Sep','Okt','Nov','Des'],
        DAY=['Jumapili','Jumatatu','Jumanne','Jumatano','Alhamisi','Ijumaa','Jumamosi'],
        DAY_EN=['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];
    var esc=function(t){return String(t==null?'':t).replace(/[&<>"]/g,function(c){return{'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]})};
    var bi=function(sw,en){return '<span lang="sw">'+esc(sw)+'</span><span lang="en">'+esc(en||sw)+'</span>'};
    var D=function(s){var a=s.split('-');return new Date(Date.UTC(+a[0],+a[1]-1,+a[2]))};
    var todayEAT=(function(){var p={};new Intl.DateTimeFormat('en-GB',{timeZone:'Africa/Dar_es_Salaam',year:'numeric',month:'2-digit',day:'2-digit'}).formatToParts(new Date()).forEach(function(x){p[x.type]=x.value});return D(p.year+'-'+p.month+'-'+p.day)})();
    var longDate=function(s){var d=D(s);return bi(DAY[d.getUTCDay()]+' '+d.getUTCDate()+' '+MON[d.getUTCMonth()]+' '+d.getUTCFullYear(),DAY_EN[d.getUTCDay()]+' '+d.getUTCDate()+' '+MON_EN[d.getUTCMonth()]+' '+d.getUTCFullYear())};
    var cal=function(s){var d=D(s);return '<div class="cal"><b>'+d.getUTCDate()+'</b><span>'+MS[d.getUTCMonth()]+'</span></div>'};
    var mini=function(s){var d=D(s);return '<span class="d"><b>'+d.getUTCDate()+'</b>'+MS[d.getUTCMonth()]+'</span>'};
    var weekItems=(M.wiki&&M.wiki.orodha)||[];
    var events=(M.matukio||[]).filter(function(e){return D(e.tarehe)>=todayEAT}).sort(function(a,b){return D(a.tarehe)-D(b.tarehe)});
    var longs=(M.muda_mrefu||[]).filter(function(x){return D(x.kuanzia)<=todayEAT&&D(x.hadi)>=todayEAT||/[?&]all=1/.test(location.search)});
    var el;
    if((el=document.getElementById('mt-week-title'))&&M.wiki)el.innerHTML=bi('Matangazo ya ','Notices for ')+longDate(M.wiki.tarehe);
    if((el=document.getElementById('mt-week')))el.innerHTML=weekItems.map(function(a){return '<li class="ann2">'+cal(M.wiki.tarehe)+'<div>'+(a.aina?'<span class="tag">'+esc(a.aina)+'</span>':'')+'<h3>'+bi(a.kichwa,a.kichwa_en)+'</h3><p>'+bi(a.maelezo,a.maelezo_en)+'</p></div></li>'}).join('');
    if((el=document.getElementById('mt-long')))el.innerHTML=longs.length?longs.map(function(x){
        var s=D(x.kuanzia),e=D(x.hadi),left=Math.round((e-todayEAT)/864e5),pct=Math.max(4,Math.min(100,Math.round((todayEAT-s)/(e-s+864e5)*100)));
        var leftTxt=left<=0?bi('Siku ya mwisho leo','Last day today'):bi('Siku '+left+' zimebaki',left+' days left');
        return '<article class="ltn"><div class="ltn-top"><span class="tag">'+esc(x.aina||'')+'</span><span class="left">'+leftTxt+'</span></div><h3>'+bi(x.kichwa,x.kichwa_en)+'</h3><p>'+bi(x.maelezo,x.maelezo_en)+'</p><div class="prog" aria-hidden="true"><span style="width:'+pct+'%"></span></div><span class="until">'+bi('Hadi ','Until ')+longDate(x.hadi)+'</span></article>'}).join('')
      :'<p class="empty">'+bi('Hakuna kumbukumbu za muda mrefu kwa sasa.','No ongoing notices at the moment.')+'</p>';
    if((el=document.getElementById('mt-events')))el.innerHTML=events.map(function(e){return '<li><span class="tl-dot" aria-hidden="true"></span><span class="when">'+longDate(e.tarehe)+'</span><b>'+bi(e.kichwa,e.kichwa_en)+'</b><span class="info">'+bi(e.saa,e.saa_en)+'</span></li>'}).join('')||'<li>'+bi('Hakuna matukio kwa sasa.','No upcoming events.')+'</li>';
    if((el=document.getElementById('mt-past'))&&M.zilizopita&&M.zilizopita.length)el.innerHTML='<h3 class="past-title">'+bi('Matangazo yaliyopita','Past notices')+'</h3>'+M.zilizopita.map(function(w){return '<details><summary>'+longDate(w.tarehe)+'</summary><ul>'+w.orodha.map(function(a){return '<li><b>'+bi(a.kichwa,a.kichwa_en)+'</b> '+bi(a.maelezo,a.maelezo_en)+'</li>'}).join('')+'</ul></details>'}).join('');
    if((el=document.getElementById('home-week'))){
      var hl=longs.slice(0,1).map(function(x){return '<li class="mini-long"><span class="d"><b>★</b></span><span>'+bi(x.kichwa,x.kichwa_en)+'<small>'+bi('Hadi ','Until ')+longDate(x.hadi)+'</small></span></li>'});
      el.innerHTML=hl.concat(weekItems.slice(0,3-hl.length).map(function(a){return '<li>'+mini(M.wiki.tarehe)+'<span>'+bi(a.kichwa,a.kichwa_en)+'</span></li>'})).join('');
    }
    if((el=document.getElementById('home-events')))el.innerHTML=events.slice(0,3).map(function(e){return '<li>'+mini(e.tarehe)+'<span>'+bi(e.kichwa,e.kichwa_en)+'<small>'+bi(e.saa,e.saa_en)+'</small></span></li>'}).join('');
  }

  // ---- Picha: filters + lightbox ----
  var wall=document.getElementById('gwall');
  if(wall){
    var tiles=[].slice.call(wall.querySelectorAll('.gw'));
    document.querySelectorAll('.chip').forEach(function(ch){
      ch.addEventListener('click',function(){
        document.querySelectorAll('.chip').forEach(function(x){x.classList.remove('on');x.setAttribute('aria-pressed','false')});
        ch.classList.add('on');ch.setAttribute('aria-pressed','true');
        var c=ch.getAttribute('data-cat');
        tiles.forEach(function(t){t.hidden=!(c==='zote'||t.getAttribute('data-cat')===c)});
      });
    });
    var lb=document.getElementById('lb'),lbMedia=lb.querySelector('.lb-media'),lbCap=lb.querySelector('.lb-cap'),cur=0,lastFocus=null;
    function visible(){return tiles.filter(function(t){return !t.hidden})}
    function show(i){
      var v=visible();if(!v.length)return;cur=(i+v.length)%v.length;var t=v[cur];
      var f=t.querySelector('.gw-frame').cloneNode(true);
      lbMedia.innerHTML='';var img=f.querySelector('img');
      lbMedia.appendChild(img?img:f.querySelector('.gph'));
      var cap=t.querySelector('figcaption');lbCap.innerHTML='<b>'+cap.querySelector('b').innerHTML+'</b><span>'+cap.lastElementChild.innerHTML+'</span>';
    }
    function open(t){var v=visible();lastFocus=document.activeElement;show(Math.max(0,v.indexOf(t)));lb.hidden=false;document.body.style.overflow='hidden';lb.querySelector('.lb-x').focus()}
    function close(){lb.hidden=true;document.body.style.overflow='';if(lastFocus)lastFocus.focus()}
    tiles.forEach(function(t){t.querySelector('.gw-frame').addEventListener('click',function(){open(t)})});
    var hero=document.querySelector('[data-open]');if(hero)hero.addEventListener('click',function(){open(tiles[+hero.getAttribute('data-open')])});
    lb.querySelector('.lb-x').addEventListener('click',close);
    lb.querySelector('.lb-prev').addEventListener('click',function(){show(cur-1)});
    lb.querySelector('.lb-next').addEventListener('click',function(){show(cur+1)});
    lb.addEventListener('click',function(e){if(e.target===lb)close()});
    document.addEventListener('keydown',function(e){if(lb.hidden)return;if(e.key==='Escape')close();if(e.key==='ArrowLeft')show(cur-1);if(e.key==='ArrowRight')show(cur+1)});
    var sx=null;lb.addEventListener('touchstart',function(e){sx=e.touches[0].clientX},{passive:true});
    lb.addEventListener('touchend',function(e){if(sx===null)return;var dx=e.changedTouches[0].clientX-sx;if(Math.abs(dx)>40)show(cur+(dx<0?1:-1));sx=null});
  }
  var here=(location.pathname.split('/').pop()||'index.html');
  document.querySelectorAll('nav.main a').forEach(function(a){if(a.getAttribute('href')===here)a.setAttribute('aria-current','page')});
})();
