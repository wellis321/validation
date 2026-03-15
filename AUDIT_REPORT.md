# Simple Data Cleaner — Quality Audit Report

**Date:** March 2025 (updated)  
**Scope:** Full codebase — accessibility, performance, theming, responsive design, anti-patterns  
**Methodology:** Systematic scan + frontend-design skill + DESIGN_SYSTEM.md + WCAG 2.1

---

## Anti-Patterns Verdict

**Result: PARTIAL PASS — core flows improved; gaps remain**

The site has a clear FieldFix-style identity on key pages: dark background (neutral-950), yellow accents, DM Sans. Bespoke page, pricing, example, and index hero are normalized. However:

| Tell | Location | Evidence |
|------|----------|----------|
| **Bounce animation** | input.css, index.php | `animate-bounce-slow` — frontend-design: "DON'T: Use bounce or elastic easing" |
| **Thick colored border on one side** | hiw-step-card, index.php | `border-l-4 border-l-yellow-500/50` — skill flags as lazy accent; hiw uses it intentionally for step hierarchy |
| **Identical card grids** | How it works, What you get | Step cards: icon + heading + text repeated; same structure |
| **Large icons above headings** | 404.php, card grids | 32×32 SVG above "404" — "DON'T: Put large icons with rounded corners above every heading" |
| **Dark mode + glowing accents** | Site-wide | Skill: "DON'T: Default to dark mode with glowing accents" — mitigated by deliberate FieldFix commitment |
| **Blue/indigo on secondary pages** | 15+ files | `bg-blue-600`, `from-blue-50 to-indigo-50` — design system specifies yellow/neutral only |

**What works:** DM Sans (not Inter/Roboto), tinted black (#0a0a0a), cohesive dark + yellow on key pages, purposeful scroll reveals, prefers-reduced-motion respected, bespoke form delight and bold inputs.

**The test:** If you said "AI made this," would they believe you? **Partially.** Homepage, bespoke, pricing, example feel intentional. 404, variations coverage, and some secondary pages read as generic.

---

## Executive Summary

- **Total issues:** 24 (3 Critical, 7 High, 9 Medium, 5 Low)
- **Most critical:** Desktop nav dropdowns not keyboard-operable; Skip-link target missing on 10+ pages; 404 theme mismatch
- **Overall quality:** 6.5/10 — core flows improved; nav a11y and page consistency need work
- **Recommended next steps:** Add `id="main-content"` to all main landmarks; fix dropdown keyboard access; run `/normalize` on 404 and blue-using pages

---

## Detailed Findings by Severity

### Critical Issues

#### 1. Desktop nav dropdowns — hover-only, not keyboard operable
- **Location:** `includes/header.php` — Product, Business, User dropdowns
- **Severity:** Critical
- **Category:** Accessibility
- **Description:** Menus open on `group-hover` / `group-focus-within`. No keyboard activation (Enter/Space); `aria-expanded` never toggles to `true`. Keyboard users cannot open dropdowns.
- **Impact:** Keyboard and screen-reader users cannot access Product, Business, or User submenus.
- **WCAG:** 2.1.1 (Keyboard), 4.1.2 (Name, Role, Value)
- **Recommendation:** Add click/focus handlers to toggle menus, update `aria-expanded`, trap focus when open. Or use click-to-open pattern.
- **Suggested command:** `/harden`

#### 2. Skip-link target missing on 10+ pages
- **Location:** bespoke.php, pricing.php, example.php, feedback.php, account.php, 404.php, cancel-subscription.php, beta-offer.php, validation-rules.php, *-variations-coverage.php
- **Severity:** Critical
- **Category:** Accessibility
- **Description:** Skip link points to `#main-content` but these pages' `<main>` or main content div lacks `id="main-content"`.
- **Impact:** Skip-to-main fails; keyboard users land on wrong element or nowhere.
- **WCAG:** 2.4.1 (Bypass Blocks)
- **Recommendation:** Add `id="main-content"` to the main content landmark on every page.
- **Suggested command:** `/harden`

#### 3. 404 page — light theme vs site dark theme
- **Location:** 404.php
- **Severity:** Critical
- **Category:** Theming
- **Description:** Body `bg-gray-50`, headings `text-gray-900`, cards `bg-white`, buttons `bg-amber-50`. Rest of site is `bg-neutral-950`, `text-white`, dark cards.
- **Impact:** Jarring inconsistency; users may think they left the site. Breaks design system.
- **Recommendation:** Apply dark theme (neutral-950, neutral-900 cards, yellow CTAs) to match bespoke, pricing, example.
- **Suggested command:** `/normalize`

---

### High-Severity Issues

#### 4. Blue/indigo palette fragmentation — 15+ files
- **Location:** how-it-works.php, documentation.php, privacy.php, gdpr.php, contact.php, feedback.php, validation-rules.php, why-choose-us.php, api-docs.php, security.php, beta-offer.php, *-variations-coverage.php, index.php (logged-in file upload UI), app.js
- **Severity:** High
- **Category:** Theming
- **Description:** Design system specifies black/white/yellow. Dozens of components use `bg-blue-600`, `bg-blue-50`, `from-blue-50 to-indigo-50`, `bg-indigo-600`.
- **Impact:** Inconsistent brand; secondary pages feel like a different product.
- **Recommendation:** Replace blue/indigo with yellow/neutral variants. Use design tokens.
- **Suggested command:** `/normalize`

#### 5. Bounce animation — anti-pattern
- **Location:** `src/input.css` — `@keyframes bounce-slow`, `.animate-bounce-slow`; `index.php` before-after arrow
- **Severity:** High
- **Category:** Anti-pattern
- **Description:** Frontend-design: "DON'T: Use bounce or elastic easing—they feel dated and tacky."
- **Impact:** Contributes to generic/AI feel.
- **Recommendation:** Replace with subtle translateY or opacity pulse; use ease-out-quart.
- **Suggested command:** `/animate`

#### 6. Images — missing `loading="lazy"` on below-fold
- **Location:** index.php (cleaned-data-report.png, try-with-example-data.png, before-after images), GDPR/privacy/Try example sections
- **Severity:** High
- **Category:** Performance
- **Description:** Below-fold images load eagerly. Footer logo has `loading="lazy"`; others do not.
- **Impact:** Unnecessary initial load; slower LCP on slow connections.
- **Recommendation:** Add `loading="lazy"` to images below the fold.
- **Suggested command:** `/optimize`

#### 7. site.webmanifest — light theme colours
- **Location:** `assets/images/favicon_io/site.webmanifest`
- **Severity:** High
- **Category:** Theming
- **Description:** `theme_color: "#ffffff"`, `background_color: "#ffffff"`. Site is dark-themed.
- **Impact:** Browser chrome and PWA splash show white, jarring against dark UI.
- **Recommendation:** Use `#0a0a0a` or `#171717` to match dark theme.
- **Suggested command:** Manual or `/normalize`

#### 8. Footer — cache busting on every request
- **Location:** `includes/footer.php` — `scroll-reveal.js?v=<?php echo time(); ?>`
- **Severity:** High
- **Category:** Performance
- **Description:** `time()` changes every request; script URL is never cached.
- **Impact:** Unnecessary network requests; degraded performance.
- **Recommendation:** Use build hash or version constant; remove `time()`.
- **Suggested command:** Manual or `/optimize`

#### 9. Pain points heading — thick left border
- **Location:** index.php `pain-points-heading`
- **Severity:** High
- **Category:** Anti-pattern
- **Description:** `border-l-[6px] border-yellow-400` — frontend-design flags "thick colored border on one side" as lazy accent.
- **Impact:** Contributes to templated feel.
- **Recommendation:** Consider alternative emphasis (typography, subtle background) or remove.
- **Suggested command:** `/distill` or `/bolder`

#### 10. Bespoke form — error state lacks `role="alert"`
- **Location:** bespoke.php — error list div
- **Severity:** High
- **Category:** Accessibility
- **Description:** Error message div has no `role="alert"` or `aria-live`. Screen readers may not announce errors.
- **Impact:** Assistive tech users may miss validation feedback.
- **WCAG:** 3.3.1 (Error Identification), 4.1.3 (Status Messages)
- **Recommendation:** Add `role="alert"` and `aria-live="polite"` to error container.
- **Suggested command:** `/harden`

---

### Medium-Severity Issues

#### 11. app.js — inline styles with hard-coded colours
- **Location:** app.js — generated HTML for preview, export, issues report
- **Severity:** Medium
- **Category:** Theming
- **Description:** Inline `background-color: #ffffff`, `#f9fafb`, `#fffbeb` in dynamically built UI.
- **Impact:** Hard to theme; may clash with dark mode if extended.
- **Recommendation:** Use CSS classes and design tokens.
- **Suggested command:** `/normalize` or refactor

#### 12. Touch targets — small links/buttons
- **Location:** Footer links, secondary nav, "Prefer email?" link on bespoke
- **Severity:** Medium
- **Category:** Responsive / Accessibility
- **Description:** Some text links may be < 44×44px. WCAG 2.5.5 (Level AAA) recommends 44×44px.
- **Impact:** Mobile users may mis-tap.
- **Recommendation:** Ensure primary interactive elements meet 44×44px; add padding to small links.
- **Suggested command:** `/adapt`

#### 13. Documentation / legal — dense content, no skip links
- **Location:** documentation.php, privacy.php, terms.php
- **Severity:** Medium
- **Category:** Accessibility
- **Description:** Long pages without in-page nav or skip-to-section. Main skip goes to `#main-content` only.
- **Impact:** Keyboard users need many tabs to reach sections.
- **Recommendation:** Add anchor links and/or table of contents for long pages.
- **Suggested command:** `/harden`

#### 14. Redundant "100% in your browser" copy
- **Location:** Multiple sections (GDPR, How it works, Try demo, key info)
- **Severity:** Medium
- **Category:** UX Writing
- **Description:** Same privacy message repeated. Frontend-design: "DON'T: Repeat information users can already see."
- **Impact:** Slight redundancy.
- **Recommendation:** Keep one strong statement; vary secondary copy.
- **Suggested command:** `/distill` or `/clarify`

#### 15. Card nesting — cards inside cards
- **Location:** How it works vocab card; What you get grid; Try example section
- **Severity:** Medium
- **Category:** Anti-pattern
- **Description:** Frontend-design: "DON'T: Nest cards inside cards—visual noise."
- **Impact:** Can feel busy on smaller screens.
- **Recommendation:** Flatten where possible.
- **Suggested command:** `/distill`

#### 16. ErrorHandler — blue info styling
- **Location:** includes/ErrorHandler.php
- **Severity:** Medium
- **Category:** Theming
- **Description:** `bg-blue-50 border-blue-200 text-blue-700` for info messages.
- **Impact:** Error/info UI inconsistent with design system.
- **Recommendation:** Use yellow/neutral for info states.
- **Suggested command:** `/normalize`

#### 17. Cookie banner — no focus trap
- **Location:** includes/cookie-banner.php
- **Severity:** Medium
- **Category:** Accessibility
- **Description:** `role="dialog"` but no `aria-modal="true"`, no focus trap. Keyboard users can tab out.
- **Impact:** For simple Accept/Decline, acceptable; for stricter dialogs, focus trap preferred.
- **Recommendation:** Add focus trap when banner is shown; or add `aria-modal="true"` if it blocks content.
- **Suggested command:** `/harden`

#### 18. Pricing page — no semantic `<main>`
- **Location:** pricing.php
- **Severity:** Medium
- **Category:** Accessibility
- **Description:** Main content is a `<div>`, not `<main>`. Missing landmark.
- **Impact:** Screen reader users may have less clear structure.
- **Recommendation:** Wrap in `<main id="main-content">`.
- **Suggested command:** `/harden`

#### 19. 404 — large icon above heading
- **Location:** 404.php — 32×32 SVG above "404"
- **Severity:** Medium
- **Category:** Anti-pattern
- **Description:** Frontend-design: "DON'T: Put large icons with rounded corners above every heading."
- **Impact:** Contributes to templated look.
- **Recommendation:** Reduce icon prominence or integrate differently.
- **Suggested command:** `/distill`

---

### Low-Severity Issues

#### 20. og:image URL — space in filename
- **Location:** index.php, meta tags
- **Severity:** Low
- **Category:** SEO / Technical
- **Description:** `Data Cleaning Icon 300.png` — spaces in URLs can cause encoding issues.
- **Impact:** Minor; some crawlers may mishandle.
- **Recommendation:** Rename to `data-cleaning-icon-300.png` and update references.
- **Suggested command:** Manual

#### 21. Scroll reveal — 0.7s duration
- **Location:** src/input.css `.ds-scroll-reveal`
- **Severity:** Low
- **Category:** Motion
- **Description:** Transition 0.7s may feel slightly slow on fast scroll.
- **Impact:** Minor; subjective.
- **Recommendation:** Consider 0.5s for snappier feel.
- **Suggested command:** `/animate`

#### 22. before-after-jitter — 4s loop
- **Location:** src/input.css
- **Severity:** Low
- **Category:** Motion
- **Description:** Subtle jitter runs every 4s. May distract some users.
- **Impact:** Low; verify `prefers-reduced-motion` disables it.
- **Recommendation:** Confirm jitter is disabled in reduced-motion media query.
- **Suggested command:** `/harden`

#### 23. Select elements — native dropdown styling
- **Location:** bespoke.php — data_volume, clean_frequency
- **Severity:** Low
- **Category:** Theming
- **Description:** `appearance-none` with custom chevron; native `<option>` styling in some browsers may not match dark theme.
- **Impact:** Minor visual inconsistency in some browsers.
- **Recommendation:** Test in Safari/Firefox; consider custom select if needed.
- **Suggested command:** Manual

#### 24. bespoke-email-link — arrow placement
- **Location:** bespoke.php — "Prefer email? Drop us your requirements directly. →"
- **Severity:** Low
- **Category:** UX
- **Description:** Arrow at end may read as "go to" rather than decorative. Slight ambiguity.
- **Impact:** Minimal; most users will understand.
- **Recommendation:** Consider envelope icon or "Email us →" pattern.
- **Suggested command:** `/clarify` or leave as-is

---

## Patterns & Systemic Issues

1. **Skip-link coverage** — 10+ pages missing `id="main-content"`; fix in one pass
2. **Blue/indigo usage** — 15+ files; design system should be single source of truth
3. **Dropdown pattern** — Hover-only desktop nav is recurring a11y gap
4. **404 outlier** — Only major page with light theme; normalizes to dark

---

## Positive Findings

- **Skip link** — Present with visible focus state (yellow, high contrast)
- **Cookie banner** — role="dialog", aria-label, 44×44px buttons, yellow palette
- **prefers-reduced-motion** — Respected in hero, scroll reveal, try-demo, bespoke, key-info
- **DM Sans** — Distinctive typography; avoids Inter/Roboto
- **Bespoke form** — Bold inputs, focus states, success animation, label focus-within, submit press feedback
- **Focus indicators** — `focus-visible:ring-2 focus-visible:ring-yellow-500` on CTAs
- **Mobile menu** — 44×44px toggle; Escape handling
- **Bespoke page** — Normalized to dark theme; design system compliant
- **Form labels** — bespoke.php uses proper `label for` / `id` association

---

## Recommendations by Priority

### Immediate
1. Add `id="main-content"` to all pages missing it (`/harden`)
2. Normalize 404 page to dark theme (`/normalize`)
3. Add keyboard support to desktop nav dropdowns (`/harden`)

### Short-term
4. Add `role="alert"` to bespoke error container (`/harden`)
5. Remove `time()` cache busting from footer script (`/optimize`)
6. Replace bounce animation with ease-out motion (`/animate`)
7. Add `loading="lazy"` to below-fold images (`/optimize`)
8. Run `/normalize` on blue-using pages

### Medium-term
9. Update site.webmanifest theme colours
10. Audit touch targets (`/adapt`)
11. Refactor app.js inline styles
12. Add skip links / ToC for long documentation pages

### Long-term
13. Flatten card nesting where it adds noise
14. Consider focus trap for cookie banner if it blocks critical content

---

## Suggested Commands for Fixes

| Command | Use for |
|---------|---------|
| `/harden` | Skip-link targets (#2), dropdown keyboard (#1), error role (#10), focus trap (#17), main landmark (#18) |
| `/normalize` | 404 theme (#3), blue usage (#4), ErrorHandler (#16), webmanifest (#7) |
| `/animate` | Remove bounce (#5), scroll duration (#21) |
| `/optimize` | Image lazy loading (#6), footer cache busting (#8) |
| `/adapt` | Touch targets (#12) |
| `/distill` | Pain points border (#9), card nesting (#15), redundant copy (#14), 404 icon (#19) |
| `/clarify` | Redundant copy (#14), email link (#24) |

---

*Audit conducted per frontend-design skill anti-patterns and WCAG 2.1. Document issues for other commands to address; no fixes applied during audit.*
