/* 11-contact */
(function(){
  var sec    = document.getElementById('contact');
  var form   = document.getElementById('ctForm');
  var done   = document.getElementById('ctDone');
  var err    = document.getElementById('ctErr');
  var btn    = document.getElementById('ctSubmit');
  var again  = document.getElementById('ctAgain');
  var reduce = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  var fName  = document.getElementById('ctName');
  var fEmail = document.getElementById('ctEmail');
  var fReas  = document.getElementById('ctReason');
  var fMsg   = document.getElementById('ctMsg');

  function bad(el, on){ el.closest('.fld').classList.toggle('is-bad', on); return !on; }

  function validate(){
    var ok = true;
    ok = bad(fName,  fName.value.trim().length < 2) && ok;
    ok = bad(fEmail, !/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/.test(fEmail.value.trim())) && ok;
    ok = bad(fReas,  !fReas.value) && ok;
    ok = bad(fMsg,   fMsg.value.trim().length < 8) && ok;
    err.classList.toggle('is-on', !ok);
    return ok;
  }

  [fName,fEmail,fReas,fMsg].forEach(function(el){
    el.addEventListener('input', function(){
      if (el.closest('.fld').classList.contains('is-bad')) validate();
    });
    el.addEventListener('change', function(){
      if (el.closest('.fld').classList.contains('is-bad')) validate();
    });
  });

  form.addEventListener('submit', function(e){
    if (!validate()) { e.preventDefault(); fName.focus(); return; }
    /* valid: let the form post to WordPress, which emails the enquiry and sends
       the visitor back with a confirmation. The button is only locked, never
       hidden, so the browser can finish the submission. */
    btn.disabled = true;
    var label = btn.firstChild;
    if (label && label.textContent) label.textContent = 'Sending… ';
  });

  again.addEventListener('click', function(){
    form.reset();
    form.style.display = '';
    done.classList.remove('is-on');
    btn.disabled = false;
    btn.firstChild.textContent = 'Send Enquiry ';
    [].slice.call(form.querySelectorAll('.fld')).forEach(function(f){ f.classList.remove('is-bad'); });
    err.classList.remove('is-on');
    fName.focus();
  });

  /* ---------------- reveals ---------------- */
  var lines = [].slice.call(sec.querySelectorAll('.ln'));
  var revs  = [].slice.call(sec.querySelectorAll('.rv'));

  if (reduce || !('IntersectionObserver' in window)) {
    lines.forEach(function(l){ l.classList.add('is-in'); });
    revs.forEach(function(r){ r.classList.add('is-in'); });
    return;
  }
  new IntersectionObserver(function(es,o){
    es.forEach(function(e){
      if(!e.isIntersecting) return;
      lines.forEach(function(l,n){ setTimeout(function(){ l.classList.add('is-in'); }, 70+n*100); });
      o.disconnect();
    });
  },{threshold:.12}).observe(sec);

  var revIO = new IntersectionObserver(function(es){
    es.forEach(function(e){ if(e.isIntersecting){ e.target.classList.add('is-in'); revIO.unobserve(e.target);} });
  },{threshold:.15});
  revs.forEach(function(r){ revIO.observe(r); });
})();
