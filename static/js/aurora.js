/* =========================================================
   AURORA LIBRARY — Interactions & Animations
   Vanilla JavaScript
   ========================================================= */

(function () {
  'use strict';

  // ---------- Toast ----------
  function ensureToastHost() {
    let host = document.querySelector('.toast-host');
    if (!host) {
      host = document.createElement('div');
      host.className = 'toast-host';
      document.body.appendChild(host);
    }
    return host;
  }

  window.Aurora = window.Aurora || {};
  window.Aurora.toast = function (message, type) {
    type = type || 'success';
    const host = ensureToastHost();
    const toast = document.createElement('div');
    toast.className = 'toast toast--' + type;
    const iconPath = type === 'success'
      ? '<path d="M5 12l4 4 10-10" stroke="currentColor" stroke-width="2.4" fill="none" stroke-linecap="round" stroke-linejoin="round"/>'
      : '<path d="M12 8v5m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round"/>';
    toast.innerHTML = '<svg class="toast__icon" viewBox="0 0 24 24">' + iconPath + '</svg><span>' + message + '</span>';
    host.appendChild(toast);
    setTimeout(() => {
      toast.style.transition = 'opacity 0.3s, transform 0.3s';
      toast.style.opacity = '0';
      toast.style.transform = 'translateX(20px)';
      setTimeout(() => toast.remove(), 320);
    }, 3000);
  };

  // ---------- Animated counters ----------
  window.Aurora.animateCount = function (el, target, duration) {
    duration = duration || 1200;
    const start = 0;
    const startTime = performance.now();
    function tick(now) {
      const elapsed = now - startTime;
      const progress = Math.min(elapsed / duration, 1);
      const eased = 1 - Math.pow(1 - progress, 3);
      const value = Math.floor(start + (target - start) * eased);
      el.textContent = value.toLocaleString();
      if (progress < 1) requestAnimationFrame(tick);
      else el.textContent = target.toLocaleString();
    }
    requestAnimationFrame(tick);
  };

  // Initialize counters on load
  document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('[data-count]').forEach(function (el) {
      const target = parseInt(el.getAttribute('data-count'), 10) || 0;
      window.Aurora.animateCount(el, target, 1400);
    });

    // ---------- Sidebar link active state ----------
    const currentPath = window.location.pathname.split('/').pop();
    document.querySelectorAll('.sidebar__link').forEach(function (link) {
      const href = link.getAttribute('href');
      if (href && href.indexOf(currentPath) !== -1 && currentPath !== '') {
        link.classList.add('is-active');
      }
    });

    // ---------- Nav link active ----------
    document.querySelectorAll('.nav__link').forEach(function (link) {
      const href = (link.getAttribute('href') || '').split('/').pop();
      if (href && href === currentPath) {
        link.classList.add('is-active');
      }
    });

    // ---------- Auto-apply toast to PHP-rendered alerts ----------
    // Look for any elements with class alert-success or alert-danger that should be shown as toasts
    document.querySelectorAll('[data-toast]').forEach(function (el) {
      const message = el.textContent.trim();
      const type = el.getAttribute('data-toast') === 'error' ? 'error' : 'success';
      if (message) {
        window.Aurora.toast(message, type);
        el.remove();
      }
    });

    // ---------- Form submit loading state ----------
    document.querySelectorAll('form').forEach(function (form) {
      form.addEventListener('submit', function (e) {
        const btn = form.querySelector('[type="submit"]');
        if (btn && !btn.disabled) {
          setTimeout(() => {
            btn.disabled = true;
            const original = btn.innerHTML;
            btn.setAttribute('data-original', original);
            btn.innerHTML = '<svg width="18" height="18" viewBox="0 0 24 24" style="animation: spin 0.8s linear infinite"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2.4" fill="none" stroke-dasharray="42 14" stroke-linecap="round"/></svg><span>Processing…</span>';
          }, 0);
        }
      });
    });

    // ---------- Search filter for tables ----------
    document.querySelectorAll('[data-table-filter]').forEach(function (input) {
      const targetSel = input.getAttribute('data-table-filter');
      const table = document.querySelector(targetSel);
      if (!table) return;
      input.addEventListener('input', function () {
        const q = input.value.toLowerCase();
        table.querySelectorAll('tbody tr').forEach(function (row) {
          row.style.display = row.textContent.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
        });
      });
    });

    // ---------- Password visibility toggle ----------
    document.querySelectorAll('[data-toggle-password]').forEach(function (btn) {
      const sel = btn.getAttribute('data-toggle-password');
      const input = document.querySelector(sel);
      if (!input) return;
      btn.addEventListener('click', function () {
        const isPwd = input.type === 'password';
        input.type = isPwd ? 'text' : 'password';
        btn.innerHTML = isPwd
          ? '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 3l18 18M10.6 10.6a3 3 0 004.2 4.2M9.9 5.1A10 10 0 0121 12c-.6 1.4-1.5 2.7-2.6 3.8M6.6 6.6A10 10 0 003 12c1.7 3.9 5.6 7 9 7 1.5 0 2.9-.4 4.1-1.1"/></svg>'
          : '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>';
      });
    });

    // ---------- Confirm before destructive actions ----------
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
      el.addEventListener('click', function (e) {
        const msg = el.getAttribute('data-confirm') || 'Are you sure?';
        if (!confirm(msg)) e.preventDefault();
      });
    });
  });

  // ---------- Spinner keyframe injection ----------
  const style = document.createElement('style');
  style.textContent = '@keyframes spin { to { transform: rotate(360deg); } }';
  document.head.appendChild(style);
})();
