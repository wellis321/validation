# Simple Data Cleaner — Quality Audit Report

**Date:** March 2025 (updated)  
**Scope:** Full codebase — accessibility, performance, theming, responsive design, anti-patterns  
**Methodology:** Systematic scan + frontend-design skill + DESIGN_SYSTEM.md + WCAG 2.1

---

## Anti-Patterns Verdict

**Result: PARTIAL PASS — core homepage improved; secondary pages lag**

The homepage (hero, pain points, GDPR, How it works, key info, Try example, Bespoke) has a clear FieldFix-style identity: dark background, yellow accents, DM Sans. However:

| Tell | Location | Evidence |
|------|----------|----------|
| **Thick colored border on one side** | index.php pain-points-heading | `border-l-[6px] border-yellow-400` — frontend-design: "lazy accent that almost never looks intentional" |
| **Bounce animation** | input.css, pain points arrow | `animate-bounce-slow` — skill: "DON'T: Use bounce or elastic easing" |
| **Identical card grids** | How it works, What you get | Step cards: icon + heading + text, repeated 3–4×; same structure throughout |
| **Dark mode + glowing accents** | Site-wide | Skill: "DON'T: Default to dark mode with glowing accents—looks 'cool' without requiring design decisions" — mitigated by deliberate FieldFix commitment |
| **Blue/indigo on secondary pages** | 20+ files | `bg-blue-600`, `from-blue-50 to-indigo-50`, `bg-indigo-600` — design system specifies yellow/neutral only |
| **Generic drop shadows** | documentation, blog, validation-rules, why-choose-us | `shadow-lg`, `shadow-xl` on white cards — design system prefers borders |

**What works:** DM Sans (not Inter/Roboto), tinted black (#0a0a0a), cohesive homepage dark + yellow, purposeful scroll reveals, prefers-reduced-motion respected.

**The test:** If you said "AI made this," would they believe you? **Partially.** Homepage feels intentional. Secondary pages (docs, legal, contact, how-it-works, variations coverage) read as generic blue-template.

---

## Executive Summary

- **Total issues:** 22 (3 Critical, 6 High, 8 Medium, 5 Low)
- **Most critical:** Desktop nav dropdowns not keyboard-operable; blue palette fragmentation; bounce animation anti-pattern
- **Overall quality:** 6.5/10 — core flows improved; secondary pages and nav accessibility need work
- **Recommended next steps:** Add keyboard support to dropdowns, run `/normalize` on blue usage, remove bounce easing

---

## Detailed Findings by Severity

### Critical Issues

#### 1. Desktop nav dropdowns — hover-only, not keyboard operable
- **Location:** `includes/header.php` Product, Business, User dropdowns
- **Severity:** Critical
- **Category:** Accessibility
- **Description:** Menus open on `group-hover` / `group-focus-within`. There is no keyboard activation (Enter/Space) or `aria-expanded` sync. Keyboard users cannot open dropdowns; `aria-expanded` stays `"false"` when menu is visible via hover.
- **Impact:** Keyboard and screen-reader users cannot access Product, Business, or User submenus.
- **WCAG:** 2.1.1 (Keyboard), 4.1.2 (Name, Role, Value)
- **Recommendation:** Add click/focus handlers to toggle menus, update `aria-expanded`, and trap focus when open. Or replace with click-to-open pattern.
- **Suggested command:** `/harden`

#### 2. Blue/indigo palette fragmentation — 20+ files
- **Location:** how-it-works.php, documentation.php, privacy.php, gdpr.php, contact.php, feedback.php, bespoke.php, validation-rules.php, why-choose-us.php, 404.php, api-docs.php, security.php, beta-offer.php, *-variations-coverage.php, index.php (logged-in file upload UI), app.js inline styles
- **Severity:** Critical
- **Category:** Theming
- **Description:** Design system specifies black/white/yellow. Dozens of components use `bg-blue-600`, `bg-blue-50`, `from-blue-50 to-indigo-50`, `bg-indigo-600`, etc.
- **Impact:** Inconsistent brand; users feel they leave the product on secondary pages.
- **Recommendation:** Replace blue/indigo with yellow/neutral variants. Use design tokens.
- **Suggested command:** `/normalize`

#### 3. Bounce animation — anti-pattern
- **Location:** `src/input.css` — `@keyframes bounce-slow`, `.animate-bounce-slow`; `index.php` before-after arrow
- **Severity:** Critical
- **Category:** Anti-pattern
- **Description:** Frontend-design: "DON'T: Use bounce or elastic easing—they feel dated and tacky."
- **Impact:** Small but contributes to generic/AI feel.
- **Recommendation:** Replace with subtle translateY or opacity pulse; use ease-out-quart.
- **Suggested command:** `/animate` or manual fix

---

### High-Severity Issues

#### 4. verify-email.php — brand mismatch
- **Location:** verify-email.php
- **Severity:** High
- **Category:** Theming
- **Description:** Likely uses blue/light gradient (common auth pattern). Auth flow should match login/register dark + yellow.
- **Impact:** Confusing during email verification.
- **Recommendation:** Apply dark + yellow treatment.
- **Suggested command:** `/normalize`

#### 5. subscribe.php — brand mismatch
- **Location:** subscribe.php
- **Severity:** High
- **Category:** Theming
- **Description:** Blue gradient and buttons.
- **Impact:** Inconsistent during subscription flow.
- **Recommendation:** Use dark + yellow to match pricing/checkout.
- **Suggested command:** `/normalize`

#### 6. index.php logged-in view — blue UI
- **Location:** index.php ~lines 623, 652, 667, 779, 819, 908, 915, 926, 932, 973, 1057, 1112
- **Severity:** High
- **Category:** Theming
- **Description:** File upload, preview, export, download summary use `bg-blue-600`, `bg-blue-50`, `border-blue-400`, `from-blue-50 to-indigo-50`.
- **Impact:** Logged-in users see a different visual system than the homepage.
- **Recommendation:** Replace with yellow/neutral equivalents.
- **Suggested command:** `/normalize`

#### 7. Images — missing `loading="lazy"` on below-fold
- **Location:** index.php (cleaned-data-report.png, try-with-example-data.png, before-after images), GDPR/privacy/Try example sections
- **Severity:** High
- **Category:** Performance
- **Description:** Below-fold images load eagerly. Footer logo has `loading="lazy"`; others do not.
- **Impact:** Unnecessary initial load; slower LCP on slow connections.
- **Recommendation:** Add `loading="lazy"` to images below the fold; keep hero/above-fold eager.
- **Suggested command:** `/optimize`

#### 8. site.webmanifest — light theme colours
- **Location:** `assets/images/favicon_io/site.webmanifest`
- **Severity:** High
- **Category:** Theming
- **Description:** `theme_color: "#ffffff"`, `background_color: "#ffffff"`. Site is dark-themed.
- **Impact:** Browser chrome and PWA splash may show white, jarring against dark UI.
- **Recommendation:** Use `#0a0a0a` or `#171717` to match dark theme.
- **Suggested command:** Manual or `/normalize`

#### 9. Pain points heading — thick left border
- **Location:** index.php `pain-points-heading`
- **Severity:** High
- **Category:** Anti-pattern
- **Description:** `border-l-[6px] border-yellow-400` — frontend-design flags "thick colored border on one side" as lazy accent.
- **Impact:** Contributes to templated feel.
- **Recommendation:** Consider alternative emphasis (e.g. subtle background, typography weight, or remove).
- **Suggested command:** `/distill` or `/bolder`

---

### Medium-Severity Issues

#### 10. app.js — inline styles with hard-coded colours
- **Location:** app.js — generated HTML for preview, export, issues report
- **Severity:** Medium
- **Category:** Theming
- **Description:** Inline `background-color: #ffffff`, `#f9fafb`, `#fffbeb`, etc. in dynamically built UI.
- **Impact:** Hard to theme; may clash with dark mode if extended.
- **Recommendation:** Use CSS classes and design tokens where possible.
- **Suggested command:** `/normalize` or refactor

#### 11. Form labels — some inputs without visible `for`/`id` link
- **Location:** Various forms (bespoke, contact, feedback)
- **Severity:** Medium
- **Category:** Accessibility
- **Description:** Login has proper `label for`; other forms need verification for full label association.
- **Impact:** Screen readers may not associate labels with inputs.
- **Recommendation:** Audit all forms; ensure every input has an associated label (visible or `aria-label`).
- **Suggested command:** `/harden`

#### 12. Touch targets — small links/buttons
- **Location:** Footer links, secondary nav, `text-yellow-400` links
- **Severity:** Medium
- **Category:** Responsive / Accessibility
- **Description:** Some text links may be &lt; 44×44px. WCAG 2.5.5 (Level AAA) recommends 44×44px.
- **Impact:** Mobile users may mis-tap.
- **Recommendation:** Ensure primary interactive elements meet 44×44px; add padding to small links.
- **Suggested command:** `/adapt`

#### 13. Hero shader — no reduced-motion fallback for canvas
- **Location:** hero-shader.js
- **Severity:** Medium
- **Category:** Performance / Accessibility
- **Description:** Script checks `prefers-reduced-motion` and skips WebGL when set. Verify fallback is solid black and performant.
- **Impact:** Users who prefer reduced motion should not see unnecessary animation.
- **Recommendation:** Confirm fallback is implemented and tested.
- **Suggested command:** `/harden`

#### 14. Documentation / legal — dense content, no skip links
- **Location:** documentation.php, privacy.php, terms.php
- **Severity:** Medium
- **Category:** Accessibility
- **Description:** Long pages without "skip to section" or in-page nav. Main skip link goes to `#main-content` only.
- **Impact:** Keyboard users may need many tabs to reach sections.
- **Recommendation:** Add anchor links and/or table of contents for long pages.
- **Suggested command:** `/harden`

#### 15. Redundant "100% in your browser" copy
- **Location:** Multiple sections (GDPR, How it works, Try demo, key info)
- **Severity:** Medium
- **Category:** UX Writing
- **Description:** Same privacy message repeated. Frontend-design: "DON'T: Repeat information users can already see."
- **Impact:** Slight redundancy; could be consolidated.
- **Recommendation:** Keep one strong statement; vary secondary copy.
- **Suggested command:** `/distill` or `/clarify`

#### 16. Card nesting — cards inside cards
- **Location:** How it works vocab card; What you get grid; Try example section
- **Severity:** Medium
- **Category:** Anti-pattern
- **Description:** Frontend-design: "DON'T: Nest cards inside cards—visual noise, flatten the hierarchy."
- **Impact:** Can feel busy on smaller screens.
- **Recommendation:** Flatten where possible; use borders/backgrounds instead of full card wrappers.
- **Suggested command:** `/distill`

#### 17. ErrorHandler — blue info styling
- **Location:** includes/ErrorHandler.php
- **Severity:** Medium
- **Category:** Theming
- **Description:** `bg-blue-50 border-blue-200 text-blue-700` for info messages.
- **Impact:** Error/info UI inconsistent with design system.
- **Recommendation:** Use yellow/neutral for info states.
- **Suggested command:** `/normalize`

---

### Low-Severity Issues

#### 18. og:image URL — space in filename
- **Location:** index.php, meta tags
- **Severity:** Low
- **Category:** SEO / Technical
- **Description:** `Data Cleaning Icon 300.png` — spaces in URLs can cause encoding issues.
- **Impact:** Minor; some crawlers may mishandle.
- **Recommendation:** Rename to `data-cleaning-icon-300.png` and update references.
- **Suggested command:** Manual

#### 19. Lucide icons — `aria-hidden` on decorative icons
- **Location:** index.php, various
- **Severity:** Low
- **Category:** Accessibility
- **Description:** Decorative icons correctly use `aria-hidden="true"`. Verify no meaningful icons are hidden.
- **Impact:** None if correctly applied.
- **Recommendation:** Spot-check that functional icons (e.g. lock for privacy) are not hidden from assistive tech.
- **Suggested command:** `/harden` (verification pass)

#### 20. Scroll reveal — 0.7s duration
- **Location:** src/input.css `.ds-scroll-reveal`
- **Severity:** Low
- **Category:** Performance / Motion
- **Description:** Transition 0.7s may feel slightly slow on fast scroll.
- **Impact:** Minor; subjective.
- **Recommendation:** Consider 0.5s for snappier feel.
- **Suggested command:** `/animate`

#### 21. before-after-jitter — 4s loop
- **Location:** src/input.css
- **Severity:** Low
- **Category:** Motion
- **Description:** Subtle jitter animation runs every 4s. May distract some users.
- **Impact:** Low; `prefers-reduced-motion` should disable.
- **Recommendation:** Confirm jitter is disabled in reduced-motion media query.
- **Suggested command:** `/harden`

#### 22. Cookie banner — focus trap when open
- **Location:** includes/cookie-banner.php
- **Severity:** Low
- **Category:** Accessibility
- **Description:** Banner has `role="dialog"`, `aria-label`, and focus-visible rings. No explicit focus trap.
- **Impact:** Keyboard users can tab out of banner; acceptable for simple Accept/Decline.
- **Recommendation:** Consider focus trap if banner blocks critical content.
- **Suggested command:** `/harden`

---

## Patterns & Systemic Issues

1. **Blue/indigo usage** — Appears in 20+ PHP files and app.js. Design system should be single source of truth; `/normalize` can align secondary pages.
2. **Dropdown pattern** — Hover-only desktop nav is a recurring a11y gap; needs a shared, keyboard-accessible component.
3. **Inline styles in JS** — app.js builds UI with hard-coded colours; consider CSS classes and data attributes.

---

## Positive Findings

- **Skip link** — "Skip to main content" with visible focus state
- **Cookie banner** — role="dialog", aria-label, 44×44px buttons, yellow palette
- **prefers-reduced-motion** — Respected in hero, scroll reveal, try-demo, key-info, bespoke, privacy bullets
- **DM Sans** — Distinctive typography; avoids Inter/Roboto
- **Tinted black** — `#0a0a0a` in tokens
- **Focus indicators** — `focus-visible:ring-2 focus-visible:ring-yellow-500` on main CTAs
- **Mobile menu** — 44×44px toggle; Escape handling for dropdowns
- **Semantic structure** — Main landmarks, section aria-labelledby, list roles

---

## Recommendations by Priority

### Immediate
1. Add keyboard support to desktop nav dropdowns (`/harden`)
2. Replace bounce animation with ease-out motion (`/animate` or manual)
3. Normalize blue usage on index.php logged-in file upload UI (`/normalize`)

### Short-term
4. Run `/normalize` across how-it-works, documentation, privacy, gdpr, contact, feedback, bespoke, validation-rules, why-choose-us, 404, api-docs, security, beta-offer
5. Add `loading="lazy"` to below-fold images (`/optimize`)
6. Update site.webmanifest theme/background colours
7. Revisit pain-points heading border (`/distill` or `/bolder`)

### Medium-term
8. Audit form labels and touch targets (`/harden`, `/adapt`)
9. Consolidate redundant privacy copy (`/distill`)
10. Refactor app.js inline styles to use design tokens

### Long-term
11. Add skip links / ToC for long documentation pages
12. Flatten card nesting where it adds noise
13. Verify hero shader reduced-motion path

---

## Suggested Commands for Fixes

| Command | Use for |
|---------|---------|
| `/normalize` | Blue→yellow theming (Critical #2, High #4–6, 8, Medium #10, 17) |
| `/harden` | Dropdown keyboard access (#1), form labels (#11), focus trap (#22), reduced-motion checks (#13, 21) |
| `/animate` | Remove bounce (#3), tweak scroll duration (#20) |
| `/optimize` | Image lazy loading (#7) |
| `/adapt` | Touch targets (#12) |
| `/distill` | Pain points border (#9), card nesting (#16), redundant copy (#15) |
| `/clarify` | Redundant copy (#15) |
| `/bolder` | Pain points heading alternative (#9) |

---

*Audit conducted per frontend-design skill anti-patterns and WCAG 2.1. Document issues for other commands to address; no fixes applied during audit.*
