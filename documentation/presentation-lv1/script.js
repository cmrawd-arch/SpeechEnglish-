/* ==========================================================
   Speech English — logique de la présentation interactive
   ========================================================== */
(function () {
  "use strict";

  /* ---------- Icônes (SVG en ligne) ---------- */
  var ICONS = {
    book: '<path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/>',
    "check-circle": '<circle cx="12" cy="12" r="10"/><path d="m9 12 2 2 4-4"/>',
    check: '<path d="M20 6 9 17l-5-5"/>',
    chart: '<path d="M3 3v18h18"/><path d="M18 17V9"/><path d="M13 17V5"/><path d="M8 17v-3"/>',
    globe: '<circle cx="12" cy="12" r="10"/><path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/><path d="M2 12h20"/>',
    users: '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>',
    trending: '<polyline points="22 7 13.5 15.5 8.5 10.5 2 17"/><polyline points="16 7 22 7 22 13"/>',
    message: '<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/>',
    home: '<path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>',
    "user-plus": '<path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><line x1="19" x2="19" y1="8" y2="14"/><line x1="22" x2="16" y1="11" y2="11"/>',
    layers: '<path d="m12 2 10 5-10 5L2 7z"/><path d="m2 17 10 5 10-5"/><path d="m2 12 10 5 10-5"/>',
    award: '<circle cx="12" cy="8" r="6"/><path d="M15.477 12.89 17 22l-5-3-5 3 1.523-9.11"/>',
    code: '<polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/>',
    database: '<ellipse cx="12" cy="5" rx="9" ry="3"/><path d="M3 5v14a9 3 0 0 0 18 0V5"/><path d="M3 12a9 3 0 0 0 18 0"/>',
    folder: '<path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/>',
    git: '<circle cx="18" cy="18" r="3"/><circle cx="6" cy="6" r="3"/><path d="M6 21V9a9 9 0 0 0 9 9"/>',
    sliders: '<line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="18" y2="18"/><circle cx="8" cy="6" r="2"/><circle cx="16" cy="12" r="2"/><circle cx="10" cy="18" r="2"/>',
    key: '<circle cx="7.5" cy="15.5" r="5.5"/><path d="m21 2-9.6 9.6"/><path d="m15.5 7.5 3 3L22 7l-3-3"/>',
    target: '<circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/>',
    pencil: '<path d="M17 3a2.85 2.83 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5Z"/>',
    help: '<circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><path d="M12 17h.01"/>',
    grid: '<rect width="7" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="14" y="3" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/>',
    notes: '<path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M16 13H8"/><path d="M16 17H8"/>',
    maximize: '<path d="M8 3H5a2 2 0 0 0-2 2v3"/><path d="M21 8V5a2 2 0 0 0-2-2h-3"/><path d="M3 16v3a2 2 0 0 0 2 2h3"/><path d="M16 21h3a2 2 0 0 0 2-2v-3"/>',
    "chevron-left": '<path d="m15 18-6-6 6-6"/>',
    "chevron-right": '<path d="m9 18 6-6-6-6"/>',
    play: '<polygon points="6 3 20 12 6 21 6 3"/>',
    zap: '<path d="M13 2 3 14h9l-1 8 10-12h-9z"/>',
    smartphone: '<rect width="14" height="20" x="5" y="2" rx="2"/><path d="M12 18h.01"/>',
    briefcase: '<rect width="20" height="14" x="2" y="7" rx="2"/><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>',
    graduation: '<path d="M22 10 12 5 2 10l10 5 10-5Z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/>',
    refresh: '<path d="M3 12a9 9 0 0 1 9-9 9.75 9.75 0 0 1 6.74 2.74L21 8"/><path d="M21 3v5h-5"/><path d="M21 12a9 9 0 0 1-9 9 9.75 9.75 0 0 1-6.74-2.74L3 16"/><path d="M8 16H3v5"/>',
    copy: '<rect width="14" height="14" x="8" y="8" rx="2"/><path d="M4 16c-1.1 0-2-.9-2-2V4c0-1.1.9-2 2-2h10c1.1 0 2 .9 2 2"/>'
  };
  document.querySelectorAll("i[data-icon]").forEach(function (el) {
    var p = ICONS[el.getAttribute("data-icon")];
    if (p) el.innerHTML = '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">' + p + "</svg>";
  });

  /* ---------- Éléments ---------- */
  var stage = document.getElementById("stage");
  var deck = document.getElementById("deck");
  var slides = Array.prototype.slice.call(deck.querySelectorAll(".slide"));
  var total = slides.length;
  var counter = document.getElementById("counter");
  var progress = document.getElementById("progress");
  var currentTitle = document.getElementById("current-title");
  var notesPanel = document.getElementById("notes-panel");
  var notesBody = document.getElementById("notes-body");
  var notesTitle = document.getElementById("notes-title");
  var overview = document.getElementById("overview");
  var overviewGrid = document.getElementById("overview-grid");
  var toast = document.getElementById("toast");
  var current = 0;

  /* Numéro de page + pied de page + délais d'animation */
  slides.forEach(function (slide, i) {
    if (i > 0 && i < total - 1 && !slide.querySelector(".slide-footer")) {
      var f = document.createElement("div");
      f.className = "slide-footer";
      f.innerHTML = "<span>Speech English · Exposé Web Design</span><span class=\"page\">" + (i + 1) + " / " + total + "</span>";
      slide.appendChild(f);
    }
    slide.querySelectorAll(".reveal, .pop").forEach(function (el, k) { el.style.setProperty("--i", k); });
  });

  /* ---------- Mise à l'échelle 1920×1080 ---------- */
  function fit() {
    var w = stage.clientWidth, h = stage.clientHeight;
    var pad = document.body.classList.contains("presenting") ? 0 : (w < 700 ? 12 : 40);
    var s = Math.min((w - pad) / 1920, (h - pad) / 1080);
    deck.style.setProperty("--scale", Math.max(s, 0.05));
    fitThumbs();
  }
  window.addEventListener("resize", fit);

  /* ---------- Navigation ---------- */
  function go(n, opts) {
    n = Math.max(0, Math.min(total - 1, n));
    var changed = n !== current || (opts && opts.force);
    slides[current].classList.remove("active");
    current = n;
    var slide = slides[current];
    if (changed) { void slide.offsetWidth; }
    slide.classList.add("active");

    counter.textContent = (current + 1) + " / " + total;
    progress.style.width = ((current + 1) / total * 100) + "%";
    var title = slide.getAttribute("data-title") || "";
    currentTitle.textContent = title;
    document.title = (current + 1) + "/" + total + " — " + title + " · Speech English";
    try { history.replaceState(null, "", "#" + (current + 1)); } catch (e) {}

    var notes = slide.querySelector(".speaker-notes");
    notesTitle.textContent = "NOTES DE L'ORATEUR · " + (current + 1) + " — " + title.toUpperCase();
    notesBody.innerHTML = notes ? notes.innerHTML : "<p>Pas de notes pour cette diapositive.</p>";

    document.querySelectorAll(".thumb").forEach(function (t, i) { t.classList.toggle("current", i === current); });
    onEnter(slide);
  }
  function next() { go(current + 1); }
  function prev() { go(current - 1); }

  document.getElementById("next").addEventListener("click", next);
  document.getElementById("prev").addEventListener("click", prev);
  deck.addEventListener("click", function (e) {
    var t = e.target.closest("[data-goto]");
    if (t) go(parseInt(t.getAttribute("data-goto"), 10) - 1);
  });

  document.addEventListener("keydown", function (e) {
    if (e.target.closest && e.target.closest("input, textarea")) return;
    switch (e.key) {
      case "ArrowRight": case "PageDown": case " ": e.preventDefault(); if (!overview.classList.contains("open")) next(); break;
      case "ArrowLeft": case "PageUp": e.preventDefault(); if (!overview.classList.contains("open")) prev(); break;
      case "Home": go(0); break;
      case "End": go(total - 1); break;
      case "g": case "G": toggleOverview(); break;
      case "n": case "N": toggleNotes(); break;
      case "f": case "F": case "F5": e.preventDefault(); toggleFullscreen(); break;
      case "Escape": if (overview.classList.contains("open")) toggleOverview(false); break;
    }
  });

  /* Glisser au doigt (mobile) */
  var tx = null, ty = null;
  stage.addEventListener("touchstart", function (e) { tx = e.touches[0].clientX; ty = e.touches[0].clientY; }, { passive: true });
  stage.addEventListener("touchend", function (e) {
    if (tx === null || overview.classList.contains("open")) return;
    var dx = e.changedTouches[0].clientX - tx, dy = e.changedTouches[0].clientY - ty;
    if (Math.abs(dx) > 45 && Math.abs(dx) > Math.abs(dy)) { dx < 0 ? next() : prev(); }
    tx = null;
  });

  /* ---------- Notes ---------- */
  var notesBtn = document.getElementById("btn-notes");
  function toggleNotes(force) {
    var open = typeof force === "boolean" ? force : !notesPanel.classList.contains("open");
    notesPanel.classList.toggle("open", open);
    notesBtn.classList.toggle("on", open);
  }
  notesBtn.addEventListener("click", function () { toggleNotes(); });

  /* ---------- Vue d'ensemble ---------- */
  var gridBtn = document.getElementById("btn-grid");
  function buildOverview() {
    if (overviewGrid.children.length) return;
    slides.forEach(function (slide, i) {
      var t = document.createElement("div");
      t.className = "thumb";
      var frame = document.createElement("div");
      frame.className = "thumb-frame";
      var clone = slide.cloneNode(true);
      clone.classList.add("active");
      clone.querySelectorAll("[id]").forEach(function (el) { el.removeAttribute("id"); });
      frame.appendChild(clone);
      var label = document.createElement("div");
      label.className = "thumb-label";
      label.innerHTML = "<b>" + (i + 1) + "</b><span>" + (slide.getAttribute("data-title") || "") + "</span>";
      t.appendChild(frame); t.appendChild(label);
      t.addEventListener("click", function () { toggleOverview(false); go(i); });
      overviewGrid.appendChild(t);
    });
  }
  function fitThumbs() {
    var f = overviewGrid.querySelector(".thumb-frame");
    if (f) overviewGrid.style.setProperty("--ts", f.clientWidth / 1920);
    overviewGrid.querySelectorAll(".thumb-frame .slide").forEach(function (s) { s.style.setProperty("--ts", (f ? f.clientWidth : 240) / 1920); });
  }
  function toggleOverview(force) {
    var open = typeof force === "boolean" ? force : !overview.classList.contains("open");
    if (open) buildOverview();
    overview.classList.toggle("open", open);
    gridBtn.classList.toggle("on", open);
    if (open) {
      fitThumbs();
      document.querySelectorAll(".thumb").forEach(function (t, i) { t.classList.toggle("current", i === current); });
    }
  }
  gridBtn.addEventListener("click", function () { toggleOverview(); });

  /* ---------- Plein écran ---------- */
  function toggleFullscreen() {
    var d = document;
    if (!d.fullscreenElement) {
      var r = d.documentElement.requestFullscreen || d.documentElement.webkitRequestFullscreen;
      if (r) { var p = r.call(d.documentElement); if (p && p.catch) p.catch(function () { showToast("Plein écran indisponible ici"); }); }
      else showToast("Plein écran indisponible ici");
    } else {
      (d.exitFullscreen || d.webkitExitFullscreen).call(d);
    }
  }
  document.getElementById("btn-full").addEventListener("click", toggleFullscreen);
  document.addEventListener("fullscreenchange", function () {
    document.body.classList.toggle("presenting", !!document.fullscreenElement);
    toggleOverview(false);
    setTimeout(fit, 60);
  });
  var idleTimer;
  document.addEventListener("mousemove", function () {
    document.body.classList.remove("idle");
    clearTimeout(idleTimer);
    idleTimer = setTimeout(function () { document.body.classList.add("idle"); }, 2500);
  });

  /* ---------- Toast ---------- */
  var toastTimer;
  function showToast(msg) {
    toast.textContent = msg;
    toast.classList.add("show");
    clearTimeout(toastTimer);
    toastTimer = setTimeout(function () { toast.classList.remove("show"); }, 1800);
  }

  /* ==========================================================
     INTERACTIONS DANS LES DIAPOSITIVES
     ========================================================== */

  /* Cartes à retourner (Easy / Basic) */
  deck.querySelectorAll(".flip").forEach(function (card) {
    card.addEventListener("click", function () { card.classList.toggle("flipped"); });
  });
  deck.querySelectorAll("[data-flip-all]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var cards = btn.closest(".slide").querySelectorAll(".flip");
      var anyClosed = Array.prototype.some.call(cards, function (c) { return !c.classList.contains("flipped"); });
      cards.forEach(function (c, i) { setTimeout(function () { c.classList.toggle("flipped", anyClosed); }, i * 120); });
    });
  });

  /* Phrasal verbs : afficher la traduction */
  deck.querySelectorAll(".verb-chip").forEach(function (chip) {
    chip.addEventListener("click", function () { chip.classList.toggle("on"); });
  });

  /* Voix active / passive */
  var VOICES = {
    active: { html: "« <b>The teacher</b> explained the lesson. »", cap: "Le sujet fait l'action." },
    passive: { html: "« <b>The lesson</b> was explained by the teacher. »", cap: "Le sujet subit l'action : be + participe passé." }
  };
  var voiceSentence = document.getElementById("voice-sentence");
  var voiceCaption = document.getElementById("voice-caption");
  deck.querySelectorAll("[data-voice]").forEach(function (btn) {
    btn.addEventListener("click", function () {
      var v = VOICES[btn.getAttribute("data-voice")];
      deck.querySelectorAll("[data-voice]").forEach(function (b) { b.classList.toggle("on", b === btn); });
      voiceSentence.style.opacity = 0;
      setTimeout(function () { voiceSentence.innerHTML = v.html; voiceCaption.textContent = v.cap; voiceSentence.style.opacity = 1; }, 200);
    });
  });

  /* Parcours d'onboarding */
  var steps = Array.prototype.slice.call(document.querySelectorAll("#steps .step"));
  var stepsFill = document.getElementById("steps-fill");
  var stepTimer;
  function setStep(k) {
    steps.forEach(function (s, i) { s.classList.toggle("done", i <= k); s.classList.toggle("current", i === k); });
    stepsFill.style.width = (k / (steps.length - 1) * 80) + "%";
  }
  steps.forEach(function (s, i) { s.addEventListener("click", function () { clearInterval(stepTimer); setStep(i); }); });

  /* Palette : copier le code couleur */
  deck.querySelectorAll("[data-copy]").forEach(function (sw) {
    sw.addEventListener("click", function () {
      var hex = sw.getAttribute("data-copy");
      var done = function () { showToast("Couleur " + hex + " copiée"); };
      if (navigator.clipboard && navigator.clipboard.writeText) navigator.clipboard.writeText(hex).then(done, done); else done();
    });
  });

  /* Quiz de la maquette mobile */
  var quiz = document.getElementById("quiz");
  var qFeedback = document.getElementById("q-feedback");
  var qNext = document.getElementById("q-next");
  var qBar = document.getElementById("q-bar");
  var qCount = document.getElementById("q-count");
  var answered = false;
  quiz.querySelectorAll(".q-opt").forEach(function (opt) {
    opt.addEventListener("click", function () {
      if (answered) return;
      answered = true;
      var ok = opt.hasAttribute("data-correct");
      opt.classList.add(ok ? "right" : "wrong");
      if (ok) opt.insertAdjacentHTML("beforeend", "<span>✓</span>");
      else quiz.querySelector("[data-correct]").classList.add("right");
      qFeedback.className = "q-feedback " + (ok ? "ok" : "ko");
      qFeedback.textContent = ok ? "✓ Correct ! Past Simple." : "✗ Presque… la réponse est « visited ».";
      qNext.disabled = false;
      qBar.style.width = "40%";
      qCount.textContent = "4 / 10";
    });
  });
  qNext.addEventListener("click", resetQuiz);
  function resetQuiz() {
    answered = false;
    quiz.querySelectorAll(".q-opt").forEach(function (o) { o.classList.remove("right", "wrong"); var s = o.querySelector("span"); if (s) s.remove(); });
    qFeedback.className = "q-feedback";
    qFeedback.textContent = "Touchez une réponse";
    qNext.disabled = true;
    qBar.style.width = "30%";
    qCount.textContent = "3 / 10";
  }

  /* Compteurs animés (conclusion) */
  function animateCounters(slide) {
    slide.querySelectorAll("[data-count]").forEach(function (el, k) {
      var target = parseInt(el.getAttribute("data-count"), 10), start = null;
      el.textContent = "0";
      function tick(ts) {
        if (!start) start = ts + 300 + k * 150;
        var p = Math.min(Math.max((ts - start) / 900, 0), 1);
        el.textContent = Math.round(target * (1 - Math.pow(1 - p, 3)));
        if (p < 1) requestAnimationFrame(tick);
      }
      requestAnimationFrame(tick);
    });
  }

  /* Ce qui se passe à l'arrivée sur une diapositive */
  function onEnter(slide) {
    clearInterval(stepTimer);
    if (slide.querySelector("[data-count]")) animateCounters(slide);
    if (slide.querySelector("#steps")) {
      var k = 0; setStep(0);
      stepTimer = setInterval(function () { k++; if (k >= steps.length) return clearInterval(stepTimer); setStep(k); }, 700);
    }
    if (slide.querySelector("#quiz")) resetQuiz();
  }

  /* ---------- Démarrage ---------- */
  var start = parseInt((location.hash || "").replace("#", ""), 10);
  window.addEventListener("hashchange", function () {
    var n = parseInt(location.hash.replace("#", ""), 10);
    if (!isNaN(n) && n - 1 !== current) go(n - 1);
  });
  fit();
  go(isNaN(start) ? 0 : start - 1, { force: true });
})();
