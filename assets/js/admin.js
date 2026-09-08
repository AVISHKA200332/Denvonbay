/**
 * Denvonbay - Admin JavaScript
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  // Attach confirmation dialog to delete links and forms
  document.querySelectorAll('.btn-confirm-delete').forEach(function (btn) {
    btn.addEventListener('click', function (e) {
      if (!confirm('Are you sure you want to delete this item? This action cannot be undone.')) {
        e.preventDefault();
      }
    });
  });

});
