/* 04-services */
(function(){
  var sec    = document.getElementById('services');
  var cards  = [].slice.call(sec.querySelectorAll('.bento'));
  var lines  = [].slice.call(sec.querySelectorAll('.ln'));
  var revs   = [].slice.call(sec.querySelectorAll('.rv'));
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (reduce || !('IntersectionObserver' in window)) {
    lines.forEach(function(l){ l.classList.add('is-in'); });
    revs.forEach(function(r){ r.classList.add('is-in'); });
    cards.forEach(function(c){ c.classList.add('is-in'); });
    return;
  }

  new IntersectionObserver(function(es,o){
    es.forEach(function(e){
      if(!e.isIntersecting) return;
      lines.forEach(function(l,n){ setTimeout(function(){ l.classList.add('is-in'); }, 70+n*95); });
      o.disconnect();
    });
  },{threshold:.12}).observe(sec);

  var revIO = new IntersectionObserver(function(es){
    es.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('is-in'); revIO.unobserve(e.target);} });
  },{threshold:.2});
  revs.forEach(function(r){ revIO.observe(r); });

  var cardIO = new IntersectionObserver(function(es){
    es.forEach(function(e){
      if(!e.isIntersecting) return;
      var n = cards.indexOf(e.target);
      setTimeout(function(){ e.target.classList.add('is-in'); }, n*70);
      cardIO.unobserve(e.target);
    });
  },{threshold:.12,rootMargin:'0px 0px -4% 0px'});
  cards.forEach(function(c){ cardIO.observe(c); });

  /* slow drift on the background photo so the band feels alive */
  if (!reduce) {
    var bg = sec.querySelector('.sv__bg img');
    var ticking = false;
    window.addEventListener('scroll', function(){
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function(){
        ticking = false;
        var r = sec.getBoundingClientRect();
        if (r.bottom < -200 || r.top > window.innerHeight + 200) return;
        var p = (window.innerHeight - r.top) / (window.innerHeight + r.height);
        bg.style.transform = 'scale(1.08) translateY(' + ((p - .5) * -3.2).toFixed(2) + '%)';
      });
    }, {passive:true});
  }
})();
