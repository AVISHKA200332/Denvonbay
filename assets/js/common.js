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
     1. SMART STICKY HEADER (HIDE ON SCROLL DOWN, SHOW ON SCROLL UP)
     ============================================================ */
  const siteHeader = document.getElementById('site-header');
  let lastScrollY = window.pageYOffset || document.documentElement.scrollTop || 0;
  let isTicking = false;
  const scrollThreshold = 8;

  function handleSmartHeader() {
    if (!siteHeader) return;

    // Keep header visible if mobile drawer is currently open
    const mobileNavEl = document.getElementById('mobileNav');
    if (mobileNavEl && mobileNavEl.classList.contains('is-open')) {
      siteHeader.classList.remove('header-hidden');
      isTicking = false;
      return;
    }

    const currentScrollY = Math.max(0, window.pageYOffset || document.documentElement.scrollTop || 0);
    const scrollDelta = currentScrollY - lastScrollY;

    if (currentScrollY <= 20) {
      // At the top of page: restore initial un-scrolled appearance
      siteHeader.classList.remove('scrolled', 'header-hidden');
    } else {
      // Below top: apply scrolled shadow & compact height
      siteHeader.classList.add('scrolled');

      // Scrolling DOWN past header height -> hide header
      if (scrollDelta > scrollThreshold && currentScrollY > 80) {
        siteHeader.classList.add('header-hidden');
      }
      // Scrolling UP -> reveal header smoothly
      else if (scrollDelta < -scrollThreshold) {
        siteHeader.classList.remove('header-hidden');
      }
    }

    lastScrollY = currentScrollY;
    isTicking = false;
  }

  window.addEventListener('scroll', function () {
    if (!isTicking) {
      window.requestAnimationFrame(handleSmartHeader);
      isTicking = true;
    }
  }, { passive: true });

  handleSmartHeader();

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
        closeMobileNav();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      }
    });
  });

  /* ============================================================
     4. MOBILE NAVIGATION DRAWER
     ============================================================ */
  const menuToggle = document.getElementById('menuToggle');
  const mobileNav = document.getElementById('mobileNav');
  const mobileNavBackdrop = document.getElementById('mobileNavBackdrop');
  const mobileCloseBtn = document.getElementById('mobileCloseBtn');

  function openMobileNav() {
    if (!mobileNav || !menuToggle) return;
    menuToggle.classList.add('is-active');
    menuToggle.setAttribute('aria-expanded', 'true');
    mobileNav.classList.add('is-open');
    mobileNav.setAttribute('aria-hidden', 'false');
    if (mobileNavBackdrop) {
      mobileNavBackdrop.classList.add('is-open');
      mobileNavBackdrop.setAttribute('aria-hidden', 'false');
    }
    document.body.classList.add('nav-open');
  }

  function closeMobileNav() {
    if (!mobileNav || !menuToggle) return;
    menuToggle.classList.remove('is-active');
    menuToggle.setAttribute('aria-expanded', 'false');
    mobileNav.classList.remove('is-open');
    mobileNav.setAttribute('aria-hidden', 'true');
    if (mobileNavBackdrop) {
      mobileNavBackdrop.classList.remove('is-open');
      mobileNavBackdrop.setAttribute('aria-hidden', 'true');
    }
    document.body.classList.remove('nav-open');
  }

  function toggleMobileNav() {
    if (!mobileNav) return;
    const isOpen = mobileNav.classList.contains('is-open');
    if (isOpen) {
      closeMobileNav();
    } else {
      openMobileNav();
    }
  }

  if (menuToggle) {
    menuToggle.addEventListener('click', function (e) {
      e.stopPropagation();
      toggleMobileNav();
    });
  }

  if (mobileCloseBtn) {
    mobileCloseBtn.addEventListener('click', function () {
      closeMobileNav();
    });
  }

  if (mobileNavBackdrop) {
    mobileNavBackdrop.addEventListener('click', function () {
      closeMobileNav();
    });
  }

  // Close when clicking any nav link inside the drawer
  document.querySelectorAll('.mobile-nav-link, .mobile-book-btn').forEach(function (link) {
    link.addEventListener('click', function () {
      closeMobileNav();
    });
  });

  // Close on Escape key
  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape' && mobileNav && mobileNav.classList.contains('is-open')) {
      closeMobileNav();
    }
  });

  // Auto-close on resize to desktop viewport
  window.addEventListener('resize', function () {
    if (window.innerWidth >= 992 && mobileNav && mobileNav.classList.contains('is-open')) {
      closeMobileNav();
    }
  }, { passive: true });

});
