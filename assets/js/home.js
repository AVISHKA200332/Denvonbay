/**
 * Denvonbay - Home Page JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // Hero image smooth fade-in
  const heroImg = document.querySelector('.hero-main-img');
  if (heroImg) {
    if (heroImg.complete) {
      heroImg.style.opacity = '1';
    } else {
      heroImg.style.opacity = '0';
      heroImg.style.transition = 'opacity 0.6s ease';
      heroImg.addEventListener('load', function () {
        heroImg.style.opacity = '1';
      });
    }
  }

});
