// Drives the *-variations-coverage.php pages: reads the embedded corpus
// JSON (the same fixture data tests/variations.test.js checks against),
// runs every value through the real validator client-side, and renders
// the actual result - so these pages show what the tool really does
// rather than a static, unverified claim.
(function () {
    'use strict';

    function escapeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str;
        return div.innerHTML;
    }

    function renderCoverage(containerEl) {
        const dataEl = document.getElementById('corpus-data');
        const validatorType = containerEl.getAttribute('data-validator');
        if (!dataEl || !validatorType || typeof getValidator === 'undefined') {
            containerEl.innerHTML = '<p class="text-red-600">Could not load live validation results.</p>';
            return;
        }

        let grouped;
        try {
            grouped = JSON.parse(dataEl.textContent);
        } catch (e) {
            containerEl.innerHTML = '<p class="text-red-600">Could not parse corpus data.</p>';
            return;
        }

        const validator = getValidator(validatorType);
        let total = 0, passed = 0;
        const sectionsHtml = [];

        Object.keys(grouped).forEach(function (section) {
            const values = grouped[section];
            const cards = values.map(function (value) {
                const result = validator.validate(value);
                total++;
                if (result.isValid) passed++;

                const bg = result.isValid ? 'bg-green-50 border-green-200' : 'bg-red-50 border-red-200';
                const detail = result.isValid
                    ? '<span class="block text-xs text-green-700 mt-1">&rarr; ' + escapeHtml(result.fixed || result.value) + '</span>'
                    : '<span class="block text-xs text-red-700 mt-1">' + escapeHtml(result.error || 'Invalid') + '</span>';

                return '<div class="border rounded p-3 ' + bg + '">' +
                    '<code class="text-sm break-all text-gray-900">' + escapeHtml(value) + '</code>' +
                    detail +
                    '</div>';
            }).join('');

            sectionsHtml.push(
                '<div class="mb-8">' +
                '<h3 class="text-lg font-semibold mb-3 text-gray-800">' + escapeHtml(section) + '</h3>' +
                '<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">' + cards + '</div>' +
                '</div>'
            );
        });

        const summaryEl = document.getElementById('corpus-summary');
        if (summaryEl) {
            const pct = total > 0 ? Math.round((passed / total) * 100) : 0;
            summaryEl.textContent = passed + ' of ' + total + ' example formats handled automatically (' + pct + '%) - computed live in your browser just now.';
        }

        containerEl.innerHTML = sectionsHtml.join('');
    }

    // Single inline "before -> after" examples (e.g. "Special Cases Handled"
    // demos), computed live instead of hardcoded, so a stale example can't
    // silently drift from what the validator actually does.
    // Usage: <span class="js-live-value" data-type="phone_number" data-input="4.47701E+11"></span>
    function renderInlineExample(el) {
        const type = el.getAttribute('data-type');
        const input = el.getAttribute('data-input');
        if (!type || input === null || typeof getValidator === 'undefined') return;
        const validator = getValidator(type);
        const result = validator.validate(input);
        el.textContent = result.isValid ? (result.fixed || result.value) : ('Invalid: ' + (result.error || 'unrecognised format'));
        el.classList.add(result.isValid ? 'text-green-700' : 'text-red-700');
    }

    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-live-coverage]').forEach(renderCoverage);
        document.querySelectorAll('.js-live-value').forEach(renderInlineExample);
    });
})();
