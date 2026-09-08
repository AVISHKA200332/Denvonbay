/**
 * Denvonbay - Common JavaScript
 * -----------------------------
 * Shared interactive behavior across all pages:
 *   - Navbar scroll shadow
 *   - Scroll reveal animations (IntersectionObserver)
 *   - Smooth anchor scrolling
 *   - Mobile menu click-outside to close
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  /* ============================================================
     1. NAVBAR: SCROLL SHADOW
     ============================================================ */
  const siteHeader = document.getElementById('site-header');

  function handleNavbarScroll() {
    if (!siteHeader) return;
    if (window.scrollY > 40) {
      siteHeader.classList.add('scrolled');
    } else {
      siteHeader.classList.remove('scrolled');
    }
  }

  window.addEventListener('scroll', handleNavbarScroll, { passive: true });
  handleNavbarScroll();

  /* ============================================================
     2. SCROLL REVEAL ANIMATIONS
     ============================================================ */
  const revealElements = document.querySelectorAll('[data-reveal]');

  if ('IntersectionObserver' in window && revealElements.length > 0) {
    const revealObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const el = entry.target;
            const delay = el.dataset.revealDelay ? parseInt(el.dataset.revealDelay, 10) : 0;

            setTimeout(function () {
              el.classList.add('is-visible');
            }, delay);

            revealObserver.unobserve(el);
          }
        });
      },
      {
        threshold: 0.12,
        rootMargin: '0px 0px -40px 0px'
      }
    );

    revealElements.forEach(function (el) {
      revealObserver.observe(el);
    });
  } else {
    revealElements.forEach(function (el) {
      el.classList.add('is-visible');
    });
  }

  /* ============================================================
     3. SMOOTH SCROLLING FOR ANCHORS
     ============================================================ */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const targetId = this.getAttribute('href');
      if (targetId === '#' || targetId === '') return;

      const target = document.querySelector(targetId);
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Close mobile navbar if open
        const navbarCollapse = document.getElementById('navbarMain');
        if (navbarCollapse && navbarCollapse.classList.contains('show')) {
          if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
            const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
            if (bsCollapse) bsCollapse.hide();
          }
        }
      }
    });
  });

  /* ============================================================
     4. MOBILE NAVBAR: CLOSE ON OUTSIDE CLICK
     ============================================================ */
  document.addEventListener('click', function (e) {
    const navbar = document.getElementById('navbarMain');
    const toggler = document.querySelector('.navbar-toggler');

    if (
      navbar &&
      navbar.classList.contains('show') &&
      !navbar.contains(e.target) &&
      toggler &&
      !toggler.contains(e.target)
    ) {
      if (typeof bootstrap !== 'undefined' && bootstrap.Collapse) {
        const bsCollapse = bootstrap.Collapse.getInstance(navbar);
        if (bsCollapse) bsCollapse.hide();
      }
    }
  });

});
