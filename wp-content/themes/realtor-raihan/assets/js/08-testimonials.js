/* 08-testimonials */
(function(){
  var sec   = document.getElementById('testimonials');
  var track = document.getElementById('tsTrack');
  var cards = [].slice.call(track.querySelectorAll('.tcard'));
  var dots  = [].slice.call(document.querySelectorAll('.ts__dot'));
  var prev  = document.getElementById('tsPrev');
  var next  = document.getElementById('tsNext');
  var reduce= window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var n = cards.length;
  var cur = 0;
  var autoplayId = null;

  function layout(){
    cards.forEach(function(card, i){
      var d = i - cur;
      // wrap to shortest path in a 4-card ring
      if (d >  n/2) d -= n;
      if (d < -n/2) d += n;
      var pos;
      if (d === 0) pos = '0';
      else if (Math.abs(d) === 1) pos = String(d);
      else if (Math.abs(d) === 2) pos = String(d);
      else pos = 'far';
      card.dataset.pos = pos;
      card.setAttribute('aria-hidden', d === 0 ? 'false' : 'true');
      card.setAttribute('aria-label', (i+1) + ' of ' + n);
    });
    dots.forEach(function(d, i){
      d.setAttribute('aria-current', i === cur ? 'true' : 'false');
    });
  }

  function go(k){
    cur = (k + n) % n;
    layout();
    restart();
  }
  function restart(){
    if (reduce) return;
    clearInterval(autoplayId);
    autoplayId = setInterval(function(){ go(cur+1); }, 7000);
  }

  prev.addEventListener('click', function(){ go(cur-1); });
  next.addEventListener('click', function(){ go(cur+1); });
  dots.forEach(function(d,i){ d.addEventListener('click', function(){ go(i); }); });

  cards.forEach(function(card, i){
    card.addEventListener('click', function(){ if (i !== cur) go(i); });
    card.addEventListener('keydown', function(e){
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); go(i); }
    });
  });

  document.addEventListener('keydown', function(e){
    if (!sec.contains(document.activeElement)) return;
    if (e.key === 'ArrowLeft')  go(cur-1);
    if (e.key === 'ArrowRight') go(cur+1);
  });

  // swipe
  var sx = 0, sy = 0, swiping = false;
  track.addEventListener('touchstart', function(e){
    sx = e.touches[0].clientX; sy = e.touches[0].clientY; swiping = true;
  }, {passive:true});
  track.addEventListener('touchend', function(e){
    if (!swiping) return; swiping = false;
    var dx = e.changedTouches[0].clientX - sx;
    var dy = e.changedTouches[0].clientY - sy;
    if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy)) go(dx < 0 ? cur+1 : cur-1);
  }, {passive:true});

  // pause on hover / focus
  sec.addEventListener('pointerenter', function(){ clearInterval(autoplayId); });
  sec.addEventListener('pointerleave', restart);
  sec.addEventListener('focusin', function(){ clearInterval(autoplayId); });

  // reveals
  var lines = [].slice.call(sec.querySelectorAll('.ln'));
  var revs  = [].slice.call(sec.querySelectorAll('.rv'));
  if (reduce || !('IntersectionObserver' in window)) {
    lines.forEach(function(l){ l.classList.add('is-in'); });
    revs.forEach(function(r){ r.classList.add('is-in'); });
    layout(); return;
  }
  new IntersectionObserver(function(es,o){
    es.forEach(function(e){
      if(!e.isIntersecting) return;
      lines.forEach(function(l,n){ setTimeout(function(){ l.classList.add('is-in'); }, 80+n*100); });
      o.disconnect();
    });
  },{threshold:.12}).observe(sec);
  var revIO = new IntersectionObserver(function(es){
    es.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('is-in'); revIO.unobserve(e.target);} });
  },{threshold:.2});
  revs.forEach(function(r){ revIO.observe(r); });

  layout();
  restart();
})();
