// Parses a *-variations.txt fixture file into { section, value } entries.
//
// File structure (see e.g. phone-variations.txt):
//   Section Heading
//   <blank line>
//   value one
//   value two
//   <blank line>
//   Next Section Heading
//   <blank line>
//   ...
//
// A line is treated as a section heading when it is preceded by a blank
// line (or is the first line of the file) AND followed by a blank line,
// AND it contains no digit or '@' - every real test value in these files
// is a phone/NI/postcode/sort-code fragment (always has a digit) or an
// email address (always has '@'), so this rules out the case where a
// lone data value happens to be blank-padded like a real header.

const fs = require('fs');

function parseVariations(filePath) {
    const lines = fs.readFileSync(filePath, 'utf8').split('\n').map(l => l.replace(/\r$/, ''));
    const entries = [];
    let currentSection = '(untitled)';

    for (let i = 0; i < lines.length; i++) {
        const line = lines[i];
        if (line.trim() === '') continue;

        const prevBlank = i === 0 || lines[i - 1].trim() === '';
        const nextBlank = i === lines.length - 1 || lines[i + 1].trim() === '';
        const looksLikeData = /[0-9@]/.test(line);

        if (prevBlank && nextBlank && !looksLikeData) {
            currentSection = line.trim();
            continue;
        }

        entries.push({ section: currentSection, value: line });
    }

    return entries;
}

module.exports = { parseVariations };
