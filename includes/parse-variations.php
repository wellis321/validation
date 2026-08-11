<?php
/**
 * Parses a *-variations.txt fixture file into an ordered list of
 * ['section' => ..., 'value' => ...] entries.
 *
 * Mirrors tests/lib/parse-variations.js exactly - the same fixture files
 * back both the automated test suite and these live coverage pages, so the
 * parsing rules must stay identical. See that file for the full rationale.
 */
function parseVariationsFile(string $filePath): array
{
    if (!is_readable($filePath)) {
        return [];
    }

    $lines = preg_split('/\r\n|\r|\n/', file_get_contents($filePath));
    $entries = [];
    $currentSection = '(untitled)';
    $count = count($lines);

    for ($i = 0; $i < $count; $i++) {
        $line = $lines[$i];
        if (trim($line) === '') {
            continue;
        }

        $prevBlank = ($i === 0) || trim($lines[$i - 1]) === '';
        $nextBlank = ($i === $count - 1) || trim($lines[$i + 1]) === '';
        $looksLikeData = preg_match('/[0-9@]/', $line) === 1;

        if ($prevBlank && $nextBlank && !$looksLikeData) {
            $currentSection = trim($line);
            continue;
        }

        $entries[] = ['section' => $currentSection, 'value' => $line];
    }

    return $entries;
}

/**
 * Groups parseVariationsFile() output into [section => [values...]],
 * preserving section order of first appearance.
 */
function groupVariationsBySection(array $entries): array
{
    $grouped = [];
    foreach ($entries as $entry) {
        $grouped[$entry['section']][] = $entry['value'];
    }
    return $grouped;
}
