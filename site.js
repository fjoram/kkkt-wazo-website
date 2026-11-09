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
  function playIn(box,id){
    box.classList.add('playing');
    var f=document.createElement('iframe');
    f.src='https://www.youtube-nocookie.com/embed/'+id+'?autoplay=1&rel=0';
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
  var here=(location.pathname.split('/').pop()||'index.html');
  document.querySelectorAll('nav.main a').forEach(function(a){if(a.getAttribute('href')===here)a.setAttribute('aria-current','page')});
})();
