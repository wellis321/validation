/**
 * Scroll-triggered reveal animations
 * Uses Intersection Observer to animate sections as they enter the viewport.
 * Respects prefers-reduced-motion.
 */
(function () {
  'use strict';

  function prefersReducedMotion() {
    return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  }

  function initScrollReveal() {
    if (prefersReducedMotion()) return;

    var sections = document.querySelectorAll('.ds-scroll-reveal');
    if (sections.length === 0) return;

    var observer = new IntersectionObserver(
      function (entries) {
        entries.forEach(function (entry) {
          if (!entry.isIntersecting) return;
          var el = entry.target;
          el.classList.add('ds-revealed');
          // Stagger children for visible cascade (data-stagger-add adds extra slots for emphasis)
          var staggerItems = el.querySelectorAll('.ds-reveal-item');
          staggerItems.forEach(function (item, i) {
            var add = parseInt(item.getAttribute('data-stagger-add'), 10) || 0;
            item.style.animationDelay = ((i + add) * 0.15) + 's';
          });
          observer.unobserve(el);
        });
      },
      {
        rootMargin: '0px 0px -10% 0px',
        threshold: 0.1
      }
    );

    sections.forEach(function (s) {
      observer.observe(s);
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initScrollReveal);
  } else {
    initScrollReveal();
  }
})();
