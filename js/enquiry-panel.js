(function () {
  'use strict';
  if (document.body.classList.contains('enquiry-panel-document')) {
    // The iframe is narrow on desktop too; use the host viewport for spacing.
    function updateDesktopSpacing() {
      document.body.classList.toggle('enquiry-desktop', window.parent.matchMedia('(min-width: 768px)').matches);
    }
    updateDesktopSpacing();
    window.parent.addEventListener('resize', updateDesktopSpacing);
    var panelFormId = Number(document.body.dataset.enquiryForm) || 4;
    var currentStep = 1;
    function setStep(step) {
      currentStep = step;
      document.body.dataset.enquiryStep = String(step);
      document.querySelector('.enquiry-progress').textContent = step === 1 ? '01 / Your details' : '02 / Your event (optional)';
      var title = document.querySelector('.enquiry-flow-heading h1');
      title.textContent = step === 1 ? 'Let’s make it a day to remember.' : 'Tell us what you have in mind.';
      document.querySelector('.enquiry-intro').textContent = step === 1
        ? 'A birthday, a team day out, or something entirely your own. Share your details and we’ll help bring it to life.'
        : 'Choose what sounds good. These details are optional, and our team can help with the rest.';
      window.scrollTo(0, 0);
      title.focus({ preventScroll: true });
    }
    function validateContact() {
      return [9, 10, 11].every(function (id) {
        var input = document.getElementById('input_4_' + id);
        return input && input.reportValidity();
      });
    }
    function enhance() {
      var form = document.getElementById('gform_' + panelFormId);
      if (!form || form.dataset.panelReady) return;
      form.dataset.panelReady = 'true';
      if (panelFormId === 5 || panelFormId === 6) {
        document.body.dataset.enquiryStep = 'single';
        document.querySelector('.enquiry-progress').textContent = panelFormId === 6 ? 'SLEEPOVER / HOTEL ENQUIRY' : 'YOUR PLAY DATE';
        document.querySelector('.enquiry-flow-heading h1').textContent = panelFormId === 6 ? 'Make yourself at home at Sleepover.' : 'Let’s plan your perfect play date.';
        document.querySelector('.enquiry-intro').textContent = panelFormId === 6 ? 'Planning a stay? Share your dates and a few details, and our hotel team will help with rooms, availability, and your questions.' : 'Share a few details and our team will help make it a day to remember.';
        var singleSubmit = document.getElementById('gform_submit_button_' + panelFormId);
        if (singleSubmit) singleSubmit.value = 'Send my enquiry';
        return;
      }
      var intent = document.createElement('input');
      intent.type = 'hidden'; intent.name = 'playarena_enquiry_intent'; intent.value = 'details';
      form.appendChild(intent);
      [9, 10, 11].forEach(function (id) {
        var input = document.getElementById('input_4_' + id);
        if (!input) return;
        input.required = true;
        input.autocomplete = id === 9 ? 'name' : id === 10 ? 'tel' : 'email';
        if (id === 11) input.type = 'email';
        if (id === 10) input.type = 'tel';
      });
      [17, 18].forEach(function (id) {
        var input = document.getElementById('input_4_' + id);
        if (!input) return;
        input.type = 'number'; input.min = '0'; input.step = '1'; input.inputMode = 'numeric';
        var counter = document.createElement('div');
        counter.className = 'enquiry-counter';
        input.before(counter);
        var minus = document.createElement('button');
        var plus = document.createElement('button');
        minus.type = plus.type = 'button';
        minus.textContent = '−'; plus.textContent = '+';
        var label = id === 17 ? 'adults' : 'children';
        minus.setAttribute('aria-label', 'Fewer ' + label);
        plus.setAttribute('aria-label', 'More ' + label);
        counter.append(minus, input, plus);
        input.placeholder = '0';
        function updateCounter() { minus.disabled = !input.value || Number(input.value) <= 0; }
        function changeCount(amount) {
          input.value = String(Math.max(0, Math.floor(Number(input.value) || 0) + amount));
          input.dispatchEvent(new Event('input', { bubbles: true }));
          input.dispatchEvent(new Event('change', { bubbles: true }));
        }
        minus.addEventListener('click', function () { changeCount(-1); });
        plus.addEventListener('click', function () { changeCount(1); });
        input.addEventListener('input', updateCounter);
        updateCounter();
      });
      var footer = form.querySelector('.gform_footer');
      var submit = document.getElementById('gform_submit_button_4');
      if (!footer || !submit) return;
      var actions = document.createElement('div');
      actions.className = 'enquiry-step-actions';
      actions.innerHTML = '<button type="button" class="enquiry-next">Add event details</button><button type="button" class="enquiry-callback">Just call me back</button><p>No plans yet? No problem. We’ll work it out together.</p>';
      footer.before(actions);
      var back = document.createElement('button');
      back.type = 'button'; back.className = 'enquiry-back'; back.textContent = '← Your details';
      var heading = document.querySelector('.enquiry-flow-heading');
      var previousBack = heading.querySelector('.enquiry-back');
      if (previousBack) previousBack.remove();
      heading.querySelector('.enquiry-progress').before(back);
      actions.querySelector('.enquiry-next').addEventListener('click', function () { if (validateContact()) { intent.value = 'details'; setStep(2); } });
      actions.querySelector('.enquiry-callback').addEventListener('click', function () {
        if (validateContact()) { intent.value = 'callback'; submit.click(); }
      });
      back.addEventListener('click', function () { setStep(1); });
      form.addEventListener('submit', function (event) {
        if (!validateContact()) { event.preventDefault(); setStep(1); }
      });
      // A validation response may refer to either step; expose its first error.
      var error = form.querySelector('.gfield_error');
      setStep(error ? (error.classList.contains('enquiry-contact-field') ? 1 : 2) : currentStep);
    }
    function confirmation() {
      if (!document.querySelector('#gform_confirmation_wrapper_' + panelFormId)) return;
      document.body.dataset.enquiryStep = 'complete';
      document.querySelector('.enquiry-progress').textContent = 'ENQUIRY RECEIVED';
      var title = document.querySelector('.enquiry-flow-heading h1');
      title.textContent = panelFormId === 6 ? 'Your Sleepover enquiry is in.' : 'You’re on our list. Let’s make it happen.';
      document.querySelector('.enquiry-intro').textContent = panelFormId === 6 ? 'Our hotel team will be in touch to help plan your stay at Sleepover.' : 'Our team will be in touch to help plan your next great day at Play Arena.';
      var done = document.createElement('button');
      done.className = 'enquiry-done'; done.textContent = 'Back to exploring'; done.type = 'button';
      done.addEventListener('click', function () { parent.postMessage({ type: 'playarena-enquiry-close' }, location.origin); });
      document.querySelector('.enquiry-flow').appendChild(done);
      window.scrollTo(0, 0); title.focus({ preventScroll: true });
    }
    jQuery(document).on('gform_post_render', function (_, id) { if (Number(id) === panelFormId) enhance(); });
    jQuery(document).on('gform_confirmation_loaded', function (_, id) { if (Number(id) === panelFormId) confirmation(); });
    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') parent.postMessage({ type: 'playarena-enquiry-close' }, location.origin);
    });
    enhance();
    return;
  }

  var dialog, iframe, opener;
  function closePanel() {
    if (!dialog || !dialog.open) return;
    dialog.close(); document.documentElement.classList.remove('enquiry-panel-open');
    if (opener && opener.isConnected) opener.focus();
  }
  function openPanel(trigger, formId) {
    formId = [4, 5, 6].includes(formId) ? formId : 4;
    opener = trigger || document.activeElement;
    if (!dialog) {
      dialog = document.createElement('dialog');
      dialog.className = 'enquiry-drawer'; dialog.setAttribute('aria-label', 'Plan your event');
      dialog.innerHTML = '<button type="button" class="enquiry-close" aria-label="Close enquiry panel">×</button><p class="enquiry-loading" role="status">Getting ready for good times…</p><iframe title="Play Arena event enquiry" class="enquiry-frame"></iframe>';
      document.body.appendChild(dialog);
      iframe = dialog.querySelector('iframe');
      iframe.addEventListener('load', function () {
        dialog.querySelector('.enquiry-loading').hidden = true;
      });
      dialog.querySelector('.enquiry-close').addEventListener('click', closePanel);
      dialog.addEventListener('cancel', function (event) { event.preventDefault(); closePanel(); });
      dialog.addEventListener('click', function (event) {
        if (event.target === dialog) {
          var bounds = dialog.getBoundingClientRect();
          if (event.clientX < bounds.left || event.clientX > bounds.right) closePanel();
        }
      });
      dialog.addEventListener('close', function () { document.documentElement.classList.remove('enquiry-panel-open'); });

    }
    if (iframe.dataset.formId !== String(formId)) {
      iframe.dataset.formId = String(formId);
      dialog.querySelector('.enquiry-loading').hidden = false;
      iframe.src = '/event-enquiry/?enquiry_panel=1&enquiry_form=' + formId;
    }
    document.documentElement.classList.add('enquiry-panel-open');
    dialog.showModal();
    dialog.querySelector('.enquiry-close').focus();
  }
  document.addEventListener('click', function (event) {
    var link = event.target.closest('a[href]');
    if (!link || event.defaultPrevented || event.ctrlKey || event.metaKey || event.shiftKey || event.altKey || event.button !== 0) return;
    var url = new URL(link.href, location.href);
    var path = url.pathname.replace(/\/$/, '');
    var playDates = document.body.classList.contains('page-id-1495');
    if (url.host !== location.host || (path !== '/event-enquiry' && !(playDates && path === '/enquiry')) || url.searchParams.has('enquiry_panel')) return;
    event.preventDefault(); event.stopPropagation(); openPanel(link, Number(url.searchParams.get('enquiry_form')) === 6 ? 6 : playDates ? 5 : 4);
  }, true);
  window.addEventListener('message', function (event) {
    if (event.origin === location.origin && iframe && event.source === iframe.contentWindow && event.data && event.data.type === 'playarena-enquiry-close') closePanel();
  });
  if (location.pathname.replace(/\/$/, '') === '/event-enquiry') openPanel(null, Number(new URLSearchParams(location.search).get('enquiry_form')));
})();
