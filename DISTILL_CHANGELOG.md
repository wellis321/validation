# Distill Changelog — Homepage Simplification

**Date:** March 2025  
**Scope:** Homepage (non-logged-in view)

## Removed

| Element | Reason |
|---------|--------|
| **Stats section** (100%, 0, 7+, Yes) | Hero metric template; trust badge and hero copy already convey privacy and value. Redundant. |
| **Why Simple Data Cleaner** (✕ vs ✓ comparison) | "Privacy-first — no uploads, no cloud" repeated again. Hero and trust badge cover this. |
| **Built for** (4 audience cards) | Four identical cards; audience implied by product. Inline mention in How it works sufficient. |
| **Final CTA section** | Dedicated section duplicated pricing CTA. Replaced with inline links after FAQ. |
| **Glassmorphism** on trust badge | Decorative blur; replaced with solid `bg-yellow-500/15`. |
| **Gradient on hero CTA** | Decorative; replaced with solid `bg-yellow-500`. |
| **backdrop-blur** on Try Example button | Decorative; removed. |
| **Redundant privacy copy** | "Your data stays in your browser — we never see it" in mini-demo (hero already states this). |

## Consolidated

| Before | After |
|--------|-------|
| How it works (3 cards) + What you get (6 cards) | Single section: 3-step list + inline data types. Left-aligned, no card grid. |
| 9 sections | 5 sections (Hero, How it works, Try it, Pricing, FAQ) |

## Simplified

- **Section intros:** Shorter; removed restating of headings.
- **Spacing:** Varied (`py-12` vs `py-16` vs `py-20`) for rhythm.
- **Try it:** Tighter copy; removed redundant privacy footnote.
- **Pricing:** Shorter heading and intro.
- **FAQ:** "Frequently asked questions" → "FAQ"; added inline CTAs after.

## Preserved

- Hero with shader, trust badge, CTAs
- Interactive mini-demo
- Pricing cards (essential for conversion)
- FAQ (progressive disclosure)
- All navigation and footer
