/**
 * Denvonbay - Contact Form JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  const contactForm = document.getElementById('contactForm');
  if (contactForm) {
    contactForm.addEventListener('submit', function (e) {
      const name = document.getElementById('contactName');
      const email = document.getElementById('contactEmail');
      const message = document.getElementById('contactMessage');

      if (!name.value.trim() || !email.value.trim() || !message.value.trim()) {
        e.preventDefault();
        alert('Please fill in all required fields before submitting.');
      }
    });
  }
});
