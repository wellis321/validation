# Simple Data Cleaner — Design System

Design system for a FieldFix-style, clean SaaS look. Use these tokens and patterns across the site for a consistent, similar look.

---

## 1. Colours (FieldFix-style: black, white, yellow)

| Token | Usage | Tailwind | Hex / value |
|-------|--------|----------|-------------|
| **Primary (yellow)** | CTAs, links, focus, badges | `yellow-400` / `yellow-500` | #eab308 / #ca8a04 |
| **Secondary (black)** | Dark sections, footer, dark buttons | `black` / `neutral-800` | #000000 / #262626 |
| **Surface** | Page background, cards | `white` | #ffffff |
| **Text primary** | Headings, body | `black` / `gray-900` | #000000 / #111827 |
| **Text secondary** | Descriptions, captions | `neutral-600` / `gray-500` | #525252 / #6b7280 |
| **Border** | Cards, dividers | `gray-200` / `neutral-200` | #e5e7eb |

Use **black** for footer and final CTA; **yellow** for primary CTAs and accents; **white** for backgrounds.

---

## 2. Typography

| Element | Tailwind | Notes |
|---------|----------|--------|
| **Page title (H1)** | `text-4xl md:text-5xl lg:text-6xl font-bold text-gray-900` | Hero, key pages |
| **Section title (H2)** | `text-3xl font-bold text-gray-900` | Section headings |
| **Card / block title (H3)** | `text-xl font-bold text-gray-900` | Cards, feature blocks |
| **Body large** | `text-xl text-gray-600` | Hero subtext, intros |
| **Body** | `text-base text-gray-600` or `text-gray-700` | Default copy |
| **Body small** | `text-sm text-gray-500` or `text-gray-600` | Captions, footnotes |
| **Label / badge** | `text-xs font-semibold uppercase tracking-wide` | “Most popular”, “Beta” |

Centre section titles and intros: `text-center` and `max-w-2xl mx-auto` for the intro paragraph.

---

## 3. Spacing & layout

| Token | Tailwind | Usage |
|-------|----------|--------|
| **Page horizontal** | `px-4 sm:px-6 lg:px-8` | Main content padding |
| **Page max width** | `max-w-7xl mx-auto` | Main wrapper |
| **Content max width** | `max-w-4xl` or `max-w-5xl` | Narrow content (pricing, FAQ) |
| **Section vertical** | `py-16 md:py-20` | Major sections |
| **Section vertical (small)** | `py-12` | Stats bar, compact sections |
| **Gap between elements** | `gap-6` / `gap-8` | Grids, flex |
| **Stack in section** | `space-y-6` or `space-y-8` | Vertical rhythm |
| **Card padding** | `p-6` / `p-8` | Cards, feature blocks |

---

## 4. Components

### Buttons

- **Primary**: `.ds-btn-primary` or `bg-yellow-400 hover:bg-yellow-500 text-black px-6 py-3 rounded-lg font-semibold transition-colors`
- **Secondary (outline)**: `.ds-btn-secondary` or `bg-white text-black border-2 border-black ...`
- **Dark**: `.ds-btn-dark` or `bg-black hover:bg-neutral-800 text-white ...`
- **On dark (outline)**: `bg-transparent text-white border-2 border-white hover:bg-white hover:text-black ...` for CTAs on black sections
- **Full-width**: use `block w-full text-center` plus the same colour/rounded classes (ds-btn-* are inline-block).

### Cards

- **Standard**: `bg-white rounded-2xl border border-gray-200 shadow-lg hover:shadow-xl transition-shadow p-6` or `p-8`
- **On gray**: `bg-white rounded-xl shadow-md border border-gray-200 p-6`

### Badges (plan / beta)

- **Most popular**: `text-xs font-semibold text-blue-600 uppercase tracking-wide`
- **Best value**: `text-xs font-semibold text-green-600 uppercase tracking-wide`
- **Lifetime beta**: `text-xs font-semibold text-amber-600 uppercase tracking-wide`

### Section pattern (FieldFix-style)

1. **Section wrapper**: `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 md:py-20`
2. **Title**: `text-3xl font-bold text-center text-gray-900 mb-4`
3. **Intro**: `text-center text-gray-600 max-w-2xl mx-auto mb-12`
4. **Content**: grid or stacked blocks with consistent gap (`gap-8`, `space-y-16`)

Alternating sections: use `bg-white border-y border-gray-200` for full-bleed bands between content sections.

### Placeholder image

- **Class**: `.placeholder-image` (from `input.css`)
- **Include**: `includes/placeholder-image.php` with `$placeholder_label` and `$placeholder_aspect` (e.g. `aspect-video`, `aspect-[2/1]`)

---

## 5. Section types

| Section | Background | Notes |
|---------|------------|--------|
| **Hero** | Default (gray-50 from body) | Centred title, CTAs, optional hero image |
| **Stats bar** | `bg-white border-y border-gray-200` | 4 stat cards, compact |
| **Content** | Default | Problem/solution, How it works, feature blocks |
| **Alternating band** | `bg-white border-y border-gray-200` | How it works, Built for |
| **Testimonials** | `bg-gray-50 border-y border-gray-200` | 3 cards |
| **Pricing** | Default | 3 cards, max-w-5xl |
| **Final CTA** | `bg-slate-900 text-white` | Centred headline + CTA |
| **FAQ** | Default | `max-w-3xl`, `<details>` or list |

---

## 6. Tailwind usage

- Prefer **design-system tokens** (e.g. `blue-600`, `slate-900`, `gray-50`) over one-off colours.
- Use **spacing scale**: 4, 6, 8, 10, 12, 16, 20 for padding/gap/margin.
- Use **rounded-xl** or **rounded-2xl** for cards and containers; **rounded-lg** for buttons.
- **Shadows**: `shadow-md` for cards, `shadow-lg` / `hover:shadow-xl` for elevated cards.

---

## 7. Files

- **Tokens in code**: `tailwind.config.js` → `theme.extend` (colors, spacing, borderRadius if needed).
- **Component classes**: `src/input.css` → `@layer components` (e.g. `.placeholder-image`, optional `.btn-primary`).
- **Layout**: Use `max-w-7xl mx-auto px-4 sm:px-6 lg:px-8` on main content wrappers; section spacing `py-16 md:py-20`.

---

## 8. Animations & Motion

Purposeful motion that enhances understanding, provides feedback, and creates delight. All animations respect `prefers-reduced-motion: reduce`.

### Hero Shader Background

- **Asset**: `hero-shader.js` — WebGL animated background on hero section
- **Usage**: Hero section only (index.php, unauthenticated). Black canvas with subtle amber/gold particle effect
- **Fallback**: Solid black when `prefers-reduced-motion` is set
- **Include**: `<script src="/hero-shader.js" defer></script>`

### Entrance Animations

| Class | Purpose | Duration |
|-------|---------|----------|
| `hero-animate-fade-in-down` | Hero trust badge, badge text | 0.8s |
| `hero-animate-fade-in-up` | Hero headline, subtext, CTAs | 0.8s |
| `hero-animation-delay-200` … `800` | Stagger delays (ms) | — |
| `hiw-step` | Step cards, feature blocks | 0.5s |
| `hiw-step-delay-1` … `4` | Stagger for steps | 0.1s–0.55s |
| `ds-animate-fade-slide` | Generic section/card entrance | 0.5s |
| `ds-animate-delay-1` … `6` | Stagger utilities for grids | — |
| `key-info-item` | FAQ/info items | 0.5s |
| `try-demo-card` | Interactive demo block | 0.5s |
| `example-cta-zone` | Example page CTA | 0.6s |

### Micro-interactions (Hover)

| Class | Effect |
|-------|--------|
| `hiw-step-card` | Left accent border, lift (`translateY(-3px)`), shadow, number badge scale on hover; `.hiw-step-num` on step number |
| `ds-hover-lift` | Card lift on hover — use on any card/section |
| `hiw-rules-link` | Arrow slides right on hover |
| `key-cta-link` | Soft periodic yellow glow (6s loop) |
| `key-cta-arrow` | Arrow fades in + slides on hover (spring easing) |
| `key-pricing-link` | Underline grows from left on hover |

### Feedback Animations

| Class | Purpose |
|-------|---------|
| `try-demo-result.is-updated` | Scale pulse when validation result changes |
| `try-demo-result.is-valid` | Green text; `is-valid.is-updated` = pop animation |
| `try-demo-result.is-invalid` | Amber text; `is-invalid.is-updated` = shake animation |

### Complex Animations (Upload / Progress Card Style)

Inspired by upload-monitoring UIs. Use for processing states, progress feedback, and success confirmations.

| Class | Purpose |
|-------|---------|
| `ds-loading-overlay-backdrop` | Backdrop fade-in (0.25s) |
| `ds-loading-overlay-card` | Card scale + slide entrance (0.4s, spring easing) |
| `ds-progress-bar-track` | Wrapper for progress bar with overflow hidden |
| `ds-progress-bar-fill` | Animated fill with shimmer (moving highlight) |
| `ds-loading-success-circle` | Success checkmark scale-in |
| `ds-loading-success-circle .ds-check-path` | Checkmark stroke draw animation |
| `ds-loading-success-glow` | Green pulse ring on success |

**Progress bar shimmer**: A gradient highlight sweeps across the fill every 1.8s. Disabled when `prefers-reduced-motion`.

**Success flow**: Show processing → progress updates → switch to success state (checkmark + "Complete!") → 1.2s delay → hide. When `prefers-reduced-motion`, skip success state and delay.

### Scroll-triggered Section Reveals

Sections animate as they scroll into view. Uses Intersection Observer.

| Class | Purpose |
|-------|---------|
| `ds-scroll-reveal` | Section animates in (opacity + translateY) when it enters viewport |
| `ds-revealed` | Added by JS when section has been revealed |
| `ds-reveal-item` | Child elements stagger in when parent section is revealed (80ms delay each) |

**Script**: `scroll-reveal.js` — loaded via footer on all pages. Respects `prefers-reduced-motion`.

### Vocabulary-style List (Card with Staggered Items)

Card design inspired by app UI lists. Use for data-type lists, feature lists, etc.

| Class | Purpose |
|-------|---------|
| `ds-vocab-card` | Container: rounded-3xl, border white/5, dark bg (#0e0e10) |
| `ds-vocab-list` | List area: flex column, gap, padding, min-height |
| `ds-vocab-item` | Each row: rounded-xl, hover lift, border |
| `ds-vocab-label` | Primary text in item |
| `ds-vocab-meta` | Secondary text in item |

Combine with `ds-reveal-item` on items for staggered scroll-in animation.

### Timing & Easing

- **Entrance**: 0.5–0.8s, ease-out
- **Hover**: 0.2–0.25s, `cubic-bezier(0.25, 1, 0.5, 1)` for smooth deceleration
- **CTA glow**: 6s loop, 4s delay before first pulse

### Reuse Across Pages

- **Step/process flows**: Use `ds-animate-fade-slide` + `ds-animate-delay-*` on cards
- **Feature grids**: Stagger with `ds-animate-delay-1` … `6` (one per item)
- **Pricing cards**: Same pattern; popular card can use `ds-animate-delay-2` to land last for emphasis
- **CTA links**: Use `key-cta-link` and `key-cta-arrow` for primary CTAs on dark sections
- **Cards anywhere**: Add `ds-hover-lift` for subtle hover feedback

### Accessibility

- All animation blocks include `@media (prefers-reduced-motion: reduce)` overrides
- Hero shader skips WebGL and shows static black when reduced motion is preferred
- No auto-playing motion that cannot be paused or disabled

---

Keeping to this system will keep the site's look consistent with the FieldFix-style layout and the current homepage, pricing, and footer.
