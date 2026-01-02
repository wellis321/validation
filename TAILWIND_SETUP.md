# Tailwind CSS Setup

This project uses Tailwind CSS as a compiled stylesheet instead of the CDN for better performance and reliability.

## Build Process

### Initial Setup
1. Install dependencies:
   ```bash
   npm install
   ```

2. Build the CSS:
   ```bash
   npm run build-css
   ```

### Development

For development with auto-rebuild on file changes:
```bash
npm run watch-css
```

### Production

For production builds (minified):
```bash
npm run build-css
```

## File Structure

- `src/input.css` - Source CSS file with Tailwind directives
- `assets/css/output.css` - Compiled CSS file (served to browsers)
- `tailwind.config.js` - Tailwind configuration
- `package.json` - npm scripts and dependencies

## Important Notes

- The compiled CSS file (`assets/css/output.css`) should be committed to git
- Always rebuild CSS after adding new Tailwind classes to your HTML/PHP files
- The CDN reference has been replaced with: `<link rel="stylesheet" href="/assets/css/output.css">`
- All PHP and HTML files now use the compiled stylesheet instead of the CDN

## Troubleshooting

If styles aren't appearing:
1. Make sure `assets/css/output.css` exists
2. Run `npm run build-css` to rebuild
3. Check that the file path in your HTML is correct: `/assets/css/output.css`
4. Clear browser cache

