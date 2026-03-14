/** @type {import('tailwindcss').Config} */
/** Design tokens aligned with DESIGN_SYSTEM.md (FieldFix-style look) */
module.exports = {
  content: [
    "./*.php",
    "./includes/*.php",
    "./**/*.php",
    "./**/*.html",
    "./app.js",
    "./fileProcessor.js",
    "./validators.js",
    "./hero-shader.js"
  ],
  theme: {
    extend: {
      fontFamily: {
        sans: ['DM Sans', 'ui-sans-serif', 'system-ui', 'sans-serif'],
      },
      colors: {
        /* FieldFix-style: black, white, yellow */
        primary: {
          DEFAULT: "#eab308",
          hover: "#ca8a04",
          light: "#fde047",
        },
        secondary: {
          DEFAULT: "#0a0a0a",
          dark: "#171717",
        },
        accent: {
          DEFAULT: "#eab308",
          hover: "#ca8a04",
        },
      },
      maxWidth: {
        "page": "80rem",   /* max-w-7xl */
        "content": "64rem", /* max-w-4xl */
        "narrow": "48rem",  /* max-w-3xl */
      },
      spacing: {
        "section": "4rem",   /* py-16 */
        "section-lg": "5rem", /* py-20 */
      },
      borderRadius: {
        "card": "1rem",   /* rounded-2xl */
        "card-sm": "0.75rem", /* rounded-xl */
      },
      boxShadow: {
        "card": "0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)",
        "card-hover": "0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)",
      },
    },
  },
  plugins: [],
}

