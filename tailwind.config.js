/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./*.php",
    "./includes/*.php",
    "./**/*.php",
    "./**/*.html",
    "./app.js",
    "./fileProcessor.js",
    "./validators.js"
  ],
  theme: {
    extend: {},
  },
  plugins: [],
}

