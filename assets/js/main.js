/**
 * Denvonbay - Main JavaScript
 * Handles: navbar scroll, scroll reveal animations, smooth interactions
 */

(function () {
  'use strict';

  /* ============================================================
     NAVBAR: SCROLL SHADOW
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
  handleNavbarScroll(); // run on load

  /* ============================================================
     SCROLL REVEAL ANIMATIONS
     Uses IntersectionObserver for performance
     ============================================================ */
  const revealElements = document.querySelectorAll('[data-reveal]');

  if ('IntersectionObserver' in window && revealElements.length > 0) {
    const revealObserver = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (entry.isIntersecting) {
            const el = entry.target;
            const delay = el.dataset.revealDelay ? parseInt(el.dataset.revealDelay) : 0;

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
    // Fallback: show all elements immediately if no IntersectionObserver
    revealElements.forEach(function (el) {
      el.classList.add('is-visible');
    });
  }

  /* ============================================================
     SMOOTH SCROLLING for anchor links
     ============================================================ */
  document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
    anchor.addEventListener('click', function (e) {
      const target = document.querySelector(this.getAttribute('href'));
      if (target) {
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });

        // Close mobile navbar if open
        const navbarCollapse = document.getElementById('navbarMain');
        if (navbarCollapse && navbarCollapse.classList.contains('show')) {
          const bsCollapse = bootstrap.Collapse.getInstance(navbarCollapse);
          if (bsCollapse) bsCollapse.hide();
        }
      }
    });
  });

  /* ============================================================
     MOBILE NAVBAR: Close on outside click
     ============================================================ */
  document.addEventListener('click', function (e) {
    const navbar = document.getElementById('navbarMain');
    const toggler = document.querySelector('.navbar-toggler');

    if (
      navbar &&
      navbar.classList.contains('show') &&
      !navbar.contains(e.target) &&
      !toggler.contains(e.target)
    ) {
      const bsCollapse = bootstrap.Collapse.getInstance(navbar);
      if (bsCollapse) bsCollapse.hide();
    }
  });

  /* ============================================================
     HERO IMAGE: Subtle parallax-free entry animation
     Just ensure the hero image loads cleanly
     ============================================================ */
  const heroImg = document.querySelector('.hero-main-img');
  if (heroImg) {
    if (heroImg.complete) {
      heroImg.style.opacity = '1';
    } else {
      heroImg.style.opacity = '0';
      heroImg.style.transition = 'opacity 0.5s ease';
      heroImg.addEventListener('load', function () {
        heroImg.style.opacity = '1';
      });
    }
  }

})();