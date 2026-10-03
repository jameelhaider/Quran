   (function() {
       'use strict';

       var cfg = window.QURAN_PAGE;
       if (!cfg) return;

       var KEY = 'quran.reader.prefs';
       var MISSING = 'No translation available for this translator.';
       var page = document.getElementById('surahPage');
       var langSel = document.getElementById('langSelect');
       var trSel = document.getElementById('translatorSelect');
       var jumpInput = document.getElementById('jumpInput');
       var toggleTranslit = document.getElementById('toggleTranslit');
       var toggleTranslation = document.getElementById('toggleTranslation');
       var bismillahTl = document.getElementById('bismillahTranslation');

       // ---------- storage ----------
       function readPrefs() {
           try {
               return JSON.parse(localStorage.getItem(KEY)) || {};
           } catch (e) {
               return {};
           }
       }

       function writePrefs() {
           try {
               localStorage.setItem(KEY, JSON.stringify(prefs));
           } catch (e) {
               /* private mode etc. */
           }
       }
       var prefs = readPrefs();
       if (!prefs.translators || typeof prefs.translators !== 'object') prefs.translators = {};

       // ---------- helpers ----------
       function sameId(a, b) {
           return String(a) === String(b);
       }

       function findLang(id) {
           return cfg.languages.find(function(l) {
               return sameId(l.id, id);
           });
       }

       function findTranslator(lang, id) {
           return lang.translators.find(function(t) {
               return sameId(t.id, id);
           });
       }

       function pickTranslator(lang) {
           return findTranslator(lang, prefs.translators[lang.id]) ||
               findTranslator(lang, lang.default_translator) ||
               lang.translators[0] || null;
       }

       function fillTranslators(lang, selectedId) {
           trSel.innerHTML = '';
           trSel.disabled = lang.translators.length === 0;
           if (!lang.translators.length) {
               var empty = document.createElement('option');
               empty.textContent = 'No translators added yet';
               trSel.appendChild(empty);
               return;
           }
           lang.translators.forEach(function(t) {
               var o = document.createElement('option');
               o.value = t.id;
               o.textContent = t.name + (t.has_data ? '' : ' (no translations yet)');
               o.selected = sameId(t.id, selectedId);
               trSel.appendChild(o);
           });
       }

       function styleTranslations(lang) {
           document.querySelectorAll('[data-translation], #bismillahTranslation').forEach(function(n) {
               Array.prototype.slice.call(n.classList).forEach(function(c) {
                   if (c.indexOf('lang-') === 0) n.classList.remove(c);
               });
               n.classList.add.apply(n.classList, String(lang.class).trim().split(/\s+/));
               n.setAttribute('dir', lang.rtl ? 'rtl' : 'ltr');
           });
       }

       function showMessage(text) {
           document.querySelectorAll('[data-translation]').forEach(function(el) {
               el.textContent = text;
               el.classList.add('is-missing');
           });
       }

       // ---------- loading translations ----------
       var cache = {};
       var requestId = 0;

       function render(lang, data) {
           var map = {};
           (data.items || []).forEach(function(row) {
               map[row.n] = row.t;
           });

           styleTranslations(lang);
           document.querySelectorAll('.ay').forEach(function(card) {
               var el = card.querySelector('[data-translation]');
               var text = map[card.dataset.ayah];
               if (text) {
                   el.innerHTML = text;
               } else {
                   el.textContent = MISSING;
               }
               el.classList.toggle('is-missing', !text);
           });
           if (bismillahTl) {
               bismillahTl.innerHTML = data.bismillah || '';
               bismillahTl.hidden = !data.bismillah;
           }
       }

       function loadTranslations(lang, translator) {
           if (!translator) {
               requestId++;
               page.classList.remove('is-loading');
               styleTranslations(lang);
               showMessage('No translators have been added for this language yet.');
               if (bismillahTl) {
                   bismillahTl.textContent = '';
                   bismillahTl.hidden = true;
               }
               return;
           }
           var current = ++requestId;
           var cacheKey = lang.id + ':' + translator.id;

           if (cache[cacheKey]) {
               render(lang, cache[cacheKey]);
               page.classList.remove('is-loading');
               return;
           }

           page.classList.add('is-loading');
           var url = cfg.translationsUrl + '?language_id=' + encodeURIComponent(lang.id) +
               '&translator_id=' + encodeURIComponent(translator.id);

           fetch(url, {
                   cache: 'no-store',
                   headers: {
                       'Accept': 'application/json',
                       'X-Requested-With': 'XMLHttpRequest'
                   }
               })
               .then(function(r) {
                   return r.text().then(function(txt) {
                       var data;
                       try {
                           data = JSON.parse(txt);
                       } catch (e) {
                           throw new Error('HTTP ' + r.status + ', response was not JSON: ' + txt
                               .slice(0, 160));
                       }
                       if (!r.ok) throw new Error('HTTP ' + r.status + ', ' + (data.message ||
                           'request failed'));
                       return data;
                   });
               })
               .then(function(data) {
                   cache[cacheKey] = data;
                   if (current !== requestId) return;
                   render(lang, data);
               })
               .catch(function(err) {
                   console.error('Translation load failed:', err);
                   if (current === requestId) showMessage('Could not load translation (' + err.message +
                       ')');
               })
               .then(function() {
                   if (current === requestId) page.classList.remove('is-loading');
               });
       }

       // ---------- init language / translator ----------
       var lang = findLang(prefs.languageId) || findLang(cfg.defaultLanguage) || cfg.languages[0];
       var translator = pickTranslator(lang);

       langSel.value = lang.id;
       fillTranslators(lang, translator ? translator.id : null);

       if (!sameId(lang.id, cfg.defaultLanguage) || !translator || !sameId(translator.id, cfg
               .defaultTranslator)) {
           loadTranslations(lang, translator);
       }

       function choose(newLang, newTranslator) {
           lang = newLang;
           translator = newTranslator;
           prefs.languageId = lang.id;
           if (translator) prefs.translators[lang.id] = translator.id;
           writePrefs();
           fillTranslators(lang, translator ? translator.id : null);
           loadTranslations(lang, translator);
       }

       langSel.addEventListener('change', function() {
           var l = findLang(langSel.value);
           if (l) choose(l, pickTranslator(l));
       });

       trSel.addEventListener('change', function() {
           var t = findTranslator(lang, trSel.value);
           if (t) choose(lang, t);
       });

       // ---------- display toggles ----------
       function applyToggles() {
           page.classList.toggle('hide-translit', !toggleTranslit.checked);
           page.classList.toggle('hide-translation', !toggleTranslation.checked);
       }
       toggleTranslit.checked = prefs.translit !== false;
       toggleTranslation.checked = prefs.translation !== false;
       applyToggles();

       toggleTranslit.addEventListener('change', function() {
           prefs.translit = toggleTranslit.checked;
           writePrefs();
           applyToggles();
       });
       toggleTranslation.addEventListener('change', function() {
           prefs.translation = toggleTranslation.checked;
           writePrefs();
           applyToggles();
       });

       // ---------- font sizes (ayah / translation / transliteration) ----------
       var SIZE_SCALE = {
           'x-small': 0.75,
           'small': 0.88,
           'normal': 1,
           'large': 1.2,
           'x-large': 1.45
       };
       var sizeControls = [{
               sel: document.getElementById('arSizeSelect'),
               key: 'arSize',
               prop: '--sr-ar-scale'
           },
           {
               sel: document.getElementById('tlSizeSelect'),
               key: 'tlSize',
               prop: '--sr-tl-scale'
           },
           {
               sel: document.getElementById('tiSizeSelect'),
               key: 'tiSize',
               prop: '--sr-ti-scale'
           }
       ];

       function applySize(ctrl) {
           var scale = SIZE_SCALE[ctrl.sel.value] || 1;
           page.style.setProperty(ctrl.prop, scale);
       }
       sizeControls.forEach(function(ctrl) {
           if (prefs[ctrl.key] && SIZE_SCALE[prefs[ctrl.key]]) ctrl.sel.value = prefs[ctrl.key];
           applySize(ctrl);
           ctrl.sel.addEventListener('change', function() {
               prefs[ctrl.key] = ctrl.sel.value;
               writePrefs();
               applySize(ctrl);
           });
       });

       // ---------- arabic font ----------
       var AR_FONTS = {
           'amiri': "'Amiri Quran'",
           'scheherazade': "'Scheherazade New'",
           'naskh': "'Noto Naskh Arabic'",
           'lateef': "'Lateef'"
       };
       var arFontSel = document.getElementById('arFontSelect');

       // show the real name of the theme's Quranic font on the default option
       (function labelDefaultFont() {
           var sample = document.querySelector('.ay__ar') || document.querySelector('.sr-title__ar');
           if (!sample) return;
           var name = getComputedStyle(sample).fontFamily.split(',')[0].replace(/["']/g, '').trim();
           if (name) arFontSel.options[0].textContent = name + ' (Default)';
       })();

       function applyArFont() {
           var key = arFontSel.value;
           if (AR_FONTS[key]) {
               page.style.setProperty('--sr-ar-font', AR_FONTS[key] + ', var(--font-ar), serif');
           } else {
               page.style.removeProperty('--sr-ar-font'); // theme Quranic font
           }
       }
       if (prefs.arFont && (prefs.arFont === 'default' || AR_FONTS[prefs.arFont])) {
           arFontSel.value = prefs.arFont;
       }
       applyArFont();
       arFontSel.addEventListener('change', function() {
           prefs.arFont = arFontSel.value;
           writePrefs();
           applyArFont();
       });

       // ---------- auto scroll ----------
       var autoToggle = document.getElementById('autoScrollToggle');
       var autoSpeed = document.getElementById('autoScrollSpeed');
       var autoStop = document.getElementById('autoScrollStop');
       var BASE_PX_PER_SEC = 45; // speed at 1x; every multiplier is relative to this
       var PAUSE_AFTER_TOUCH_MS = 1500;
       var autoOn = false,
           autoRaf = null,
           lastTs = 0,
           carry = 0,
           pausedUntil = 0;

       function speedValue() {
           return parseFloat(autoSpeed.value) || 1;
       }

       function atBottom() {
           return window.innerHeight + window.pageYOffset >= document.documentElement.scrollHeight - 2;
       }

       function pauseAuto(ms) {
           pausedUntil = performance.now() + ms;
       }

       function tick(ts) {
           if (!autoOn) return;
           var dt = lastTs ? Math.min(ts - lastTs, 100) : 0;
           lastTs = ts;
           if (ts >= pausedUntil) {
               carry += BASE_PX_PER_SEC * speedValue() * dt / 1000;
               var step = Math.floor(carry);
               if (step >= 1) {
                   carry -= step;
                   window.scrollBy({
                       top: step,
                       left: 0,
                       behavior: 'instant'
                   });
               }
               if (atBottom()) {
                   setAuto(false);
                   return;
               }
           }
           autoRaf = requestAnimationFrame(tick);
       }

       function setAuto(on) {
           if (on && atBottom()) on = false;
           autoOn = on;
           autoToggle.checked = on;
           autoStop.hidden = !on;
           updateAutoLabel();
           if (autoRaf) {
               cancelAnimationFrame(autoRaf);
               autoRaf = null;
           }
           if (on) {
               lastTs = 0;
               carry = 0;
               pausedUntil = 0;
               autoRaf = requestAnimationFrame(tick);
           }
       }

       function updateAutoLabel() {
           autoStop.textContent = 'Stop auto scroll (' + autoSpeed.value + 'x)';
       }

       // remembered speed (auto scroll itself always starts switched off)
       if (prefs.autoSpeed && Array.prototype.some.call(autoSpeed.options, function(o) {
               return o.value === String(prefs.autoSpeed);
           })) {
           autoSpeed.value = String(prefs.autoSpeed);
       }
       updateAutoLabel();

       autoToggle.addEventListener('change', function() {
           setAuto(autoToggle.checked);
       });
       autoStop.addEventListener('click', function() {
           setAuto(false);
       });
       autoSpeed.addEventListener('change', function() {
           prefs.autoSpeed = autoSpeed.value;
           writePrefs();
           updateAutoLabel();
       });
       ['wheel', 'touchstart', 'touchmove', 'keydown', 'mousedown'].forEach(function(ev) {
           window.addEventListener(ev, function() {
               if (autoOn) pauseAuto(PAUSE_AFTER_TOUCH_MS);
           }, {
               passive: true
           });
       });

       // ---------- jump to ayah (no hash, URL stays /surahs/N) ----------
       function jumpTo(n) {
           n = parseInt(n, 10);
           if (!n || n < 1 || n > cfg.totalAyahs) {
               jumpInput.classList.add('is-invalid');
               return;
           }
           jumpInput.classList.remove('is-invalid');
           var el = document.getElementById('ayah-' + n);
           if (!el) return;
           var calm = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
           pauseAuto(2500);
           el.scrollIntoView({
               behavior: calm ? 'auto' : 'smooth',
               block: 'start'
           });
           el.classList.remove('is-target');
           void el.offsetWidth; // restart animation
           el.classList.add('is-target');
       }
       document.getElementById('jumpBtn').addEventListener('click', function() {
           jumpTo(jumpInput.value);
       });
       jumpInput.addEventListener('keydown', function(e) {
           if (e.key === 'Enter') {
               e.preventDefault();
               jumpTo(jumpInput.value);
           }
       });
       document.querySelectorAll('[data-jump]').forEach(function(b) {
           b.addEventListener('click', function() {
               jumpTo(b.dataset.jump);
           });
       });
   })();
