/**
 * auth.js — 3-Step Login Logic (User -> Shift -> PIN)
 * Aurora Cafe
 */

"use strict";

(function () {
  // ── State ──────────────────────────────────────────────
  let pin = "";
  let selectedUsername = "";
  let selectedShift = "";
  let selectedRole = "";

  // ── DOM refs ────────────────────────────────────────────
  const pinDots = document.querySelectorAll(".pin-dot");
  const pinField = document.getElementById("pinField");
  const usernameField = document.getElementById("usernameField");
  const shiftField = document.getElementById("shiftField");
  const submitBtn = document.getElementById("submitBtn");
  const loginForm = document.getElementById("loginForm");

  const waiterSection = document.getElementById("waiterSection");
  const shiftSection = document.getElementById("shiftSection");
  const pinSection = document.getElementById("pinSection");

  // ── PIN helpers ─────────────────────────────────────────
  function syncDots() {
    pinDots.forEach((dot, i) => {
      dot.classList.toggle("is-filled", i < pin.length);
    });
  }

  function pressKey(value) {
    if (pin.length >= 4) return;
    pin += value;
    syncDots();
    
    if (pin.length === 4) {
      pinField.value = pin;
      // Auto submit when PIN is complete
      setTimeout(() => {
        if (!submitBtn.disabled) {
          submitForm();
        }
      }, 150);
    }
    
    checkReady();
  }

  function deleteKey() {
    if (pin.length === 0) return;
    pin = pin.slice(0, -1);
    pinField.value = pin;
    syncDots();
    checkReady();
  }

  function checkReady() {
    const isSpecialRole = (selectedRole === 'admin' || selectedRole === 'it');
    const hasShift = isSpecialRole || selectedShift.trim().length > 0;
    
    const ready = pin.length === 4 &&
                  selectedUsername.trim().length > 0 &&
                  hasShift;
    submitBtn.disabled = !ready;
  }

  function submitForm() {
    submitBtn.classList.add('loading');
    loginForm.submit();
  }

  // ── Step 1: User selection ──────────────────────────────
  function selectUser(el) {
    document.querySelectorAll(".user-chip").forEach((c) => c.classList.remove("is-selected"));
    el.classList.add("is-selected");
    selectedUsername = el.dataset.username;
    selectedRole = el.dataset.role || "waiter";
    usernameField.value = selectedUsername;

    // Reset following steps
    pin = "";
    pinField.value = "";
    syncDots();

    if (selectedRole === 'admin' || selectedRole === 'it') {
      selectedShift = "-1";
      shiftField.value = "-1";
      document.querySelectorAll(".shift-chip").forEach((c) => c.classList.remove("is-selected"));
      shiftSection.classList.add("u-hidden");
      pinSection.classList.remove("u-hidden");
    } else {
      selectedShift = "";
      shiftField.value = "";
      document.querySelectorAll(".shift-chip").forEach((c) => c.classList.remove("is-selected"));
      shiftSection.classList.remove("u-hidden");
      pinSection.classList.add("u-hidden");
    }

    checkReady();
    
    // Scroll smoothly to next visible section
    setTimeout(() => {
      const nextSection = (selectedRole === 'admin' || selectedRole === 'it') ? pinSection : shiftSection;
      nextSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }, 100);
  }

  // ── Step 2: Shift selection ─────────────────────────────
  function selectShift(el) {
    document.querySelectorAll(".shift-chip").forEach((c) => c.classList.remove("is-selected"));
    el.classList.add("is-selected");
    selectedShift = el.dataset.id;
    shiftField.value = selectedShift;

    // Reset following steps
    pin = "";
    pinField.value = "";
    syncDots();

    pinSection.classList.remove("u-hidden");
    checkReady();
    
    // Scroll to PIN section smoothly
    setTimeout(() => {
      pinSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }, 100);
  }

  // ── Bind Events ─────────────────────────────────────────
  document.querySelectorAll(".user-chip").forEach((chip) => {
    chip.addEventListener("click", () => selectUser(chip));
  });

  document.querySelectorAll(".shift-chip").forEach((chip) => {
    chip.addEventListener("click", () => selectShift(chip));
  });

  document.querySelectorAll(".pin-key[data-key]").forEach((btn) => {
    btn.addEventListener("click", () => {
      const val = btn.dataset.key;
      if (val === "del") {
        deleteKey();
      } else {
        pressKey(val);
      }
    });
  });

  // ── Keyboard support (desktop) ──────────────────────────
  document.addEventListener("keydown", (e) => {
    if (pinSection.classList.contains("u-hidden")) return;
    if (e.key >= "0" && e.key <= "9") pressKey(e.key);
    if (e.key === "Backspace") deleteKey();
    if (e.key === "Enter" && !submitBtn.disabled) {
      submitForm();
    }
  });

  // Init
  checkReady();
})();
