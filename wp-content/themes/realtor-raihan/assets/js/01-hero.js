/* 01-hero */
(function(){
  /* fixed bar: swap to the glass plate as soon as the page moves, and keep the
     hero padded by exactly the bar's height so nothing hides underneath it */
  var bar = document.querySelector('.hero__bar');
  if (bar) {
    var syncBar = function(){
      document.documentElement.style.setProperty('--barh', bar.offsetHeight + 'px');
    };
    var onScroll = function(){
      bar.classList.toggle('is-stuck', window.scrollY > 12);
      syncBar();
    };
    window.addEventListener('scroll', onScroll, { passive:true });
    window.addEventListener('resize', syncBar, { passive:true });
    syncBar();
    onScroll();
  }

  var hero = document.getElementById('hero');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var items = [].slice.call(hero.querySelectorAll('.rv, .rv-head'));

  function show(){
    hero.classList.add('is-loaded');
    items.forEach(function(el, i){
      el.style.transitionDelay = (120 + i * 95) + 'ms';
      el.classList.add('is-in');
    });
  }
  if (reduce) {
    hero.classList.add('is-loaded');
    items.forEach(function(el){ el.classList.add('is-in'); });
  } else if (document.readyState === 'complete') {
    requestAnimationFrame(show);
  } else {
    window.addEventListener('load', function(){ requestAnimationFrame(show); });
  }

  /* ---------------- background slideshow ---------------- */
  /* four photos cross-fade on a 6.5s beat; the active tick fills with gold
     while the slide is on screen, so the timing is legible, not guessed. */
  var slides = [].slice.call(hero.querySelectorAll('.hero__slide'));
  var ticks  = [];   /* the tick controls were removed; autoplay only */
  var tickNum= null;   /* no numeric counter in the hero any more */
  var DUR = 6500, sc = 0, sTimer = null, sVisible = true, sPaused = false;

  function pad2(n){ return n < 9 ? '0' + (n+1) : String(n+1); }

  function goSlide(i, byUser){
    sc = (i + slides.length) % slides.length;
    slides.forEach(function(s,n){
      s.classList.toggle('is-on', n === sc);
      if (n === sc) {                       // restart the Ken Burns drift
        var im = s.querySelector('img');
        im.style.animation = 'none';
        void im.offsetWidth;
        im.style.animation = '';
      }
    });
    ticks.forEach(function(b,n){
      b.classList.toggle('is-on', n === sc);
      b.setAttribute('aria-current', n === sc ? 'true' : 'false');
      if (n === sc) {                        // restart the fill animation
        b.style.setProperty('--dur', DUR + 'ms');
        b.style.animation = 'none';
        void b.offsetWidth;
        b.style.animation = '';
        if (b.firstChild && b.firstChild.nodeType === 1) {
          b.firstChild.style.animation = 'none';
          void b.firstChild.offsetWidth;
          b.firstChild.style.animation = '';
        }
      }
    });
    if (tickNum) tickNum.textContent = pad2(sc);
    restart();   // always re-arm, otherwise the autoplay chain dies after one hop
  }

  function restart(){
    clearTimeout(sTimer);
    if (reduce || sPaused || !sVisible) return;
    sTimer = setTimeout(function(){ goSlide(sc + 1); }, DUR);
  }

  ticks.forEach(function(b){
    b.addEventListener('click', function(){ goSlide(+b.dataset.slide, true); });
  });

  /* pause while the tab is hidden or the pointer rests on the copy */
  if (!reduce) {
    document.addEventListener('visibilitychange', function(){
      sVisible = !document.hidden; sVisible ? restart() : clearTimeout(sTimer);
    });
    // pause only over the tick controls — the photo layer covers the whole
    // hero, so pausing on it would stop the show the moment the mouse moved.
    var tickWrap = null;
    if (tickWrap) {
      tickWrap.addEventListener('pointerenter', function(){ sPaused = true; clearTimeout(sTimer); });
      tickWrap.addEventListener('pointerleave', function(){ sPaused = false; restart(); });
    }
    restart();
  } else {
    // reduced motion: show slide 1 only, ticks still switch on demand
    slides.forEach(function(s,n){ s.classList.toggle('is-on', n === 0); });
  }

  /* pointer parallax — desktop only, transform on the *wrapper* so it never
     fights the Ken Burns scale animation on the images themselves */
  if (!reduce && window.matchMedia('(hover:hover) and (min-width:900px)').matches) {
    var bg = hero.querySelector('.hero__bg');
    var raf = null;
    hero.addEventListener('pointermove', function(e){
      if (raf) return;
      raf = requestAnimationFrame(function(){
        raf = null;
        var x = (e.clientX / window.innerWidth - .5);
        var y = (e.clientY / window.innerHeight - .5);
        bg.style.transform = 'translate(' + (x*-14).toFixed(1) + 'px,' + (y*-10).toFixed(1) + 'px)';
      });
    });
    hero.addEventListener('pointerleave', function(){ bg.style.transform = ''; });
  }

  /* mobile menu */
  /* the bar now lives outside #hero, so query the document instead */
  var burger = document.querySelector('.burger');
  var mmenu  = document.getElementById('mmenu');
  var mx     = mmenu ? mmenu.querySelector('.mmenu__x') : null;
  function openMenu(){
    mmenu.classList.add('is-open'); burger.setAttribute('aria-expanded','true');
    document.body.style.overflow = 'hidden'; if (mx) mx.focus();
  }
  function closeMenu(){
    mmenu.classList.remove('is-open'); burger.setAttribute('aria-expanded','false');
    document.body.style.overflow = '';
  }
  if (burger && mmenu) {
    burger.addEventListener('click', openMenu);
    if (mx) mx.addEventListener('click', closeMenu);
    mmenu.addEventListener('click', function(e){ if (e.target.tagName === 'A') closeMenu(); });
    document.addEventListener('keydown', function(e){ if (e.key === 'Escape') closeMenu(); });
  }
})();
