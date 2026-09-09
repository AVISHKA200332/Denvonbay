/**
 * Denvonbay - Booking Form JavaScript
 * Calculates estimated nights and total price dynamically.
 */

document.addEventListener('DOMContentLoaded', function () {
  'use strict';

  const roomSelect    = document.getElementById('bookingRoom');
  const checkInInput  = document.getElementById('checkIn');
  const checkOutInput = document.getElementById('checkOut');
  const summaryRoom   = document.getElementById('summaryRoom');
  const summaryNights = document.getElementById('summaryNights');
  const summaryRate   = document.getElementById('summaryRate');
  const summaryTotal  = document.getElementById('summaryTotal');

  // Set minimum check-in date to today
  const today = new Date().toISOString().split('T')[0];
  if (checkInInput) {
    checkInInput.min = today;
  }

  function updateBookingCalculations() {
    if (!checkInInput || !checkOutInput || !summaryTotal) return;

    const checkInVal = checkInInput.value;
    const checkOutVal = checkOutInput.value;

    if (checkInVal && checkOutInput) {
      // Ensure check-out must be at least next day
      checkOutInput.min = checkInVal;
    }

    let nights = 0;
    if (checkInVal && checkOutVal) {
      const d1 = new Date(checkInVal);
      const d2 = new Date(checkOutVal);
      const diffTime = d2 - d1;
      nights = Math.ceil(diffTime / (1000 * 60 * 60 * 24));
    }

    if (nights <= 0) {
      nights = 1;
    }

    let rate = 0;
    let roomName = 'Select a room';

    if (roomSelect && roomSelect.selectedIndex >= 0) {
      const selectedOption = roomSelect.options[roomSelect.selectedIndex];
      rate = parseFloat(selectedOption.getAttribute('data-price')) || 0;
      roomName = selectedOption.text.split(' - ')[0] || 'Select a room';
    }

    const total = nights * rate;

    if (summaryRoom) summaryRoom.textContent = roomName;
    if (summaryNights) summaryNights.textContent = nights + (nights === 1 ? ' night' : ' nights');
    if (summaryRate) summaryRate.textContent = '$' + rate + ' / night';
    if (summaryTotal) summaryTotal.textContent = '$' + total.toFixed(0);
  }

  if (roomSelect) roomSelect.addEventListener('change', updateBookingCalculations);
  if (checkInInput) checkInInput.addEventListener('change', updateBookingCalculations);
  if (checkOutInput) checkOutInput.addEventListener('change', updateBookingCalculations);

  updateBookingCalculations();
});
