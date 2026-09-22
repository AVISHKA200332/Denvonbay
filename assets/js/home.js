/**
 * Denvonbay - Home Page JavaScript
 * ----------------------------------
 * Hero image load animation + subtle parallax effect
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  /* ============================================================
     1. HERO IMAGE LOAD — SLOW ZOOM TRIGGER
     ============================================================ */
  const heroSection = document.querySelector('.hero-section');
  const heroImg = heroSection ? heroSection.querySelector('.hero-bg-img') : null;

  if (heroSection && heroImg) {
    if (heroImg.complete && heroImg.naturalWidth !== 0) {
      heroSection.classList.add('hero-loaded');
    } else {
      heroImg.addEventListener('load', function () {
        heroSection.classList.add('hero-loaded');
      });
    }
  }

  /* ============================================================
     2. HERO PARALLAX — Subtle image depth on scroll
     ============================================================ */
  const heroImgPanel = document.querySelector('.hero-img-panel');

  if (heroImgPanel) {
    let lastY = 0;
    let rafId = null;

    function applyParallax () {
      const scrollY = window.pageYOffset || document.documentElement.scrollTop;
      // Only apply on desktop viewports (>=992px)
      if (window.innerWidth < 992) {
        heroImgPanel.style.transform = '';
        rafId = null;
        return;
      }
      const offset = Math.min(scrollY * 0.25, 120); // cap at 120px
      heroImgPanel.style.transform = 'translateY(' + offset + 'px)';
      rafId = null;
    }

    window.addEventListener('scroll', function () {
      if (!rafId) {
        rafId = window.requestAnimationFrame(applyParallax);
      }
    }, { passive: true });

    window.addEventListener('resize', function () {
      if (window.innerWidth < 992) {
        heroImgPanel.style.transform = '';
      }
    }, { passive: true });
  }

  /* ============================================================
     3. EXPERIENCE CARDS — entrance stagger reinforcement
     ============================================================ */
  // Already handled by common.js IntersectionObserver
  // This just adds a subtle hover tilt for desktop
  const expCards = document.querySelectorAll('.exp-card');
  if (window.matchMedia('(hover: hover) and (pointer: fine)').matches) {
    expCards.forEach(function (card) {
      card.addEventListener('mousemove', function (e) {
        const rect = card.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const cx = rect.width / 2;
        const cy = rect.height / 2;
        const rotateX = ((y - cy) / cy) * -3;
        const rotateY = ((x - cx) / cx) * 3;
        card.style.transform = 'translateY(-6px) rotateX(' + rotateX + 'deg) rotateY(' + rotateY + 'deg)';
        card.style.transition = 'transform 0.1s ease';
      });

      card.addEventListener('mouseleave', function () {
        card.style.transform = '';
        card.style.transition = 'transform 0.45s cubic-bezier(0.25, 0.46, 0.45, 0.94), box-shadow 0.45s cubic-bezier(0.25, 0.46, 0.45, 0.94)';
      });
    });
  }

});
