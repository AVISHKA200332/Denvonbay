/**
 * Denvonbay - Admin JavaScript
 * ----------------------------
 * Handles sidebar toggling, mobile drawer, and confirmation dialogs.
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // Mobile sidebar toggle
  const mobileToggle = document.getElementById('adminMobileToggle');
  const sidebar = document.getElementById('adminSidebar');
  const backdrop = document.getElementById('adminSidebarBackdrop');

  function openSidebar() {
    if (sidebar) sidebar.classList.add('open');
    if (backdrop) backdrop.classList.add('show');
  }

  function closeSidebar() {
    if (sidebar) sidebar.classList.remove('open');
    if (backdrop) backdrop.classList.remove('show');
  }

  if (mobileToggle) {
    mobileToggle.addEventListener('click', function () {
      if (sidebar && sidebar.classList.contains('open')) {
        closeSidebar();
      } else {
        openSidebar();
      }
    });
  }

  if (backdrop) {
    backdrop.addEventListener('click', closeSidebar);
  }

  // Close sidebar on Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && sidebar && sidebar.classList.contains('open')) {
      closeSidebar();
    }
  });

  // Attach confirmation dialog to delete forms and destructive buttons
  document.querySelectorAll('.btn-confirm-delete, .form-confirm-delete').forEach(function (el) {
    el.addEventListener('submit', function (e) {
      const msg = this.dataset.confirmMsg || 'Are you sure you want to delete this item? This action cannot be undone.';
      if (!confirm(msg)) {
        e.preventDefault();
      }
    });
    if (el.tagName === 'BUTTON' || el.tagName === 'A') {
      el.addEventListener('click', function (e) {
        const msg = this.dataset.confirmMsg || 'Are you sure you want to proceed?';
        if (!confirm(msg)) {
          e.preventDefault();
        }
      });
    }
  });

  // Admin Dark / Light Theme Controller
  const themeToggleBtn = document.getElementById('adminThemeToggleBtn');
  const themeIcon = document.getElementById('adminThemeIcon');

  function updateThemeUI(theme) {
    if (!themeIcon) return;
    if (theme === 'dark') {
      themeIcon.className = 'bi bi-sun-fill text-warning';
      if (themeToggleBtn) themeToggleBtn.title = 'Switch to Light Mode';
    } else {
      themeIcon.className = 'bi bi-moon-stars';
      if (themeToggleBtn) themeToggleBtn.title = 'Switch to Dark Mode';
    }
  }

  const currentTheme = document.documentElement.getAttribute('data-theme') || localStorage.getItem('denvonbay_theme') || 'light';
  updateThemeUI(currentTheme);

  if (themeToggleBtn) {
    themeToggleBtn.addEventListener('click', function () {
      const active = document.documentElement.getAttribute('data-theme');
      const next = active === 'dark' ? 'light' : 'dark';
      document.documentElement.setAttribute('data-theme', next);
      localStorage.setItem('denvonbay_theme', next);
      updateThemeUI(next);
    });
  }

});
