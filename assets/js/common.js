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
    if (window.scrollY > 20) {
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
