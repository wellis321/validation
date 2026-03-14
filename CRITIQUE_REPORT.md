# Simple Data Cleaner — Design Critique Report

**Date:** March 2025  
**Scope:** Homepage, header, footer, login, example page, design system  
**Methodology:** frontend-design skill DON'Ts + holistic design evaluation

---

## Anti-Patterns Verdict

**Result: PARTIAL PASS (improved after distill, but still recognizable)**

The distill pass removed several AI tells (hero metrics, glassmorphism, gradient CTAs, redundant copy). What remains:

| Tell | Location | Evidence |
|------|----------|----------|
| **Dark mode + accent** | Entire site | Dark theme with yellow accents — "default to dark mode with glowing accents" without a strong conceptual direction |
| **Pure black** | `input.css` | `--color-secondary: #000000` — frontend-design: "always tint; pure black never appears in nature" |
| **Gray on colored background** | Footer | `text-gray-400` on `bg-neutral-950` — "gray looks washed out" on dark |
| **Generic drop shadows** | Pricing cards, ds-card | `shadow-lg hover:shadow-xl` — "rounded rectangles with generic drop shadows — safe, forgettable" |
| **Identical pricing cards** | Homepage, pricing page | Three same-sized cards, same structure; "Most popular" / "Best value" badges |
| **System fonts** | Global | No custom typography; "Inter, Roboto, Arial... system defaults" |
| **Blue-to-indigo gradient** | login, register, forgot-password | `bg-gradient-to-br from-blue-50 to-indigo-100` — classic AI palette; also blue-600 buttons instead of brand yellow |
| **Rounded everything** | Buttons, cards, trust badge | `rounded-full`, `rounded-xl`, `rounded-2xl` — safe, homogeneous |
| **Numbered circles** | How it works | Circles with 1, 2, 3 above steps — similar to "large icons with rounded corners above every heading" |

**What's no longer AI slop (post-distill):** No hero metrics, no glassmorphism, solid CTAs, left-aligned How it works, merged sections, less redundancy. The animated shader adds some distinctiveness.

**The test:** If you said "AI made this," would they believe you? **Yes, but less instantly than before.** The shader, UK focus, and simplified flow help. The auth pages and footer still feel very template.

---

## Overall Impression

**What works:** Clear value prop, privacy-first positioning, interactive mini-demo, and a simpler homepage after distill. The shader hero adds character. Hierarchy is mostly clear.

**What doesn't:** The experience feels split — homepage is dark + yellow; auth is light + blue. No typographic identity. Pricing feels like a standard SaaS template. The design is competent but forgettable.

**Biggest opportunity:** Commit to one cohesive visual language (extend dark + yellow to auth, or define a clear light/dark system) and add one distinctive typographic or compositional choice that makes this feel *designed* rather than assembled.

---

## What's Working

1. **Clear primary action** — "Start Free Trial" in yellow is the obvious hero CTA. "Try Example" is secondary. Users can identify the next step quickly.

2. **Progressive disclosure** — FAQ uses `<details>`; How it works is a scannable list; the mini-demo is optional. Complexity is revealed in order.

3. **Animated shader hero** — The WebGL background differentiates from static gradients. It's purposeful (atmosphere) and respects `prefers-reduced-motion`.

4. **Simplified IA (post-distill)** — Five sections instead of nine. No redundant "privacy-first" repetition. Left-aligned How it works breaks the "center everything" pattern.

---

## Priority Issues

### 1. Auth pages ignore brand palette
- **What:** Login, register, forgot-password, reset-password use `from-blue-50 to-indigo-100` background and `blue-600` buttons. The rest of the site is dark + yellow.
- **Why it matters:** Feels like a different product. Breaks cohesion and trust. Users may wonder if they're still on the same site.
- **Fix:** Use a light-on-dark auth flow that matches the homepage (e.g. `bg-neutral-950`, yellow CTAs) or a light layout that still uses yellow accents instead of blue.
- **Command:** `/normalize` or `/colorize`

### 2. Pure black and gray-on-dark in design tokens
- **What:** `--color-secondary: #000000`; footer uses `text-gray-400` on dark.
- **Why it matters:** Pure black is harsh; gray on dark reads washed out. Reduces polish and can hurt readability.
- **Fix:** Replace `#000` with `#0a0a0a` or `oklch(12% 0.01 60)`. Use `text-neutral-400` or a tinted neutral for footer; verify 4.5:1 contrast.
- **Command:** `/normalize`

### 3. No typographic identity
- **What:** System fonts throughout. No custom typeface.
- **Why it matters:** Typography is the fastest way to signal "this was designed." Without it, the interface feels generic.
- **Fix:** Add one distinctive font — e.g. a display font for headings or a refined body font. Load via `font-display: swap`. Even one choice (e.g. "DM Sans" or "Source Serif" for body) would help.
- **Command:** `/bolder` or manual typography pass

### 4. Pricing cards are interchangeable
- **What:** Three identical cards: price, description, checklist, "View full pricing." Only badges differ.
- **Why it matters:** No clear recommendation. Users may dither. "Most popular" / "Best value" help but the cards themselves don't guide.
- **Fix:** Visually emphasize the recommended plan (e.g. scale, border, or background). Or simplify to two options if three creates parity.
- **Command:** `/distill` or `/bolder`

### 5. Generic shadows on cards
- **What:** `ds-card` and pricing cards use `shadow-lg hover:shadow-xl`.
- **Why it matters:** Contributes to "could be any AI output" feel. Shadows don't add meaning.
- **Fix:** Reduce or remove. Use border or subtle background shift for hierarchy. If shadows stay, make them subtler and more intentional.
- **Command:** `/normalize` or `/distill`

---

## Minor Observations

- **Example page green success state** (`bg-green-50`) — Inconsistent with dark theme. Consider `bg-green-500/10` on dark.
- **Footer "100% Private Processing"** — Repeats trust message. Could be shortened or dropped if hero/trust badge already cover it.
- **Pricing card CTAs** — "View full pricing" on each card sends users to the same page. Consider "Start trial" on the recommended plan as the primary action.
- **Hero subtext** — "7-day free trial · No card required" + "View pricing" is good; the link could be more prominent if pricing is a key path.
- **How it works numbered circles** — Functional but a bit templated. Could be replaced with a simple 1–2–3 or a different visual treatment.

---

## Questions to Consider

- **What if auth pages matched the dark + yellow system?** Would that feel more cohesive or too heavy for a login flow?
- **What's the one thing someone remembers after leaving?** Right now it might be "UK data cleaning" or "privacy" — not the interface. What would make the design memorable?
- **Do we need three pricing cards?** Could two options (e.g. monthly vs annual) reduce choice overload and make the recommendation clearer?
- **What would a confident version look like?** Bolder typography? Stronger contrast? A more opinionated layout?
- **Is the shader doing enough?** It adds atmosphere but doesn't define the brand. Could it be tied more to the product (e.g. subtle data/pattern motif)?

---

*Critique conducted per critique skill and frontend-design skill. Recommendations are actionable; implementation order should follow product priorities.*
