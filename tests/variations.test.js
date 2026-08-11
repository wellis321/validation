// Runs every real-world example in the *-variations.txt fixture files
// through the actual validator and compares the result against a checked-in
// snapshot. This is a characterisation/regression test, not a hand-verified
// correctness test (see validators.test.js for that): the point is that if
// ANY of these 780+ real examples starts behaving differently, this fails
// loudly and shows exactly which input and what changed, instead of the
// silent drift that let three real bugs go unnoticed before this suite
// existed.
//
// To intentionally accept a behavior change, delete the relevant file in
// tests/snapshots/ and re-run - it will be regenerated from current
// behavior. Always review the regenerated snapshot diff before committing.

const { test } = require('node:test');
const assert = require('node:assert/strict');
const fs = require('fs');
const path = require('path');
const { parseVariations } = require('./lib/parse-variations');
const {
    PhoneNumberValidator,
    NINumberValidator,
    PostcodeValidator,
    SortCodeValidator,
    EmailValidator
} = require('../validators.js');

const SNAPSHOT_DIR = path.join(__dirname, 'snapshots');

const suites = [
    { name: 'phone', fixture: 'phone-variations.txt', Validator: PhoneNumberValidator },
    { name: 'ni', fixture: 'ni-variations.txt', Validator: NINumberValidator },
    { name: 'postcode', fixture: 'postcode-variations.txt', Validator: PostcodeValidator },
    { name: 'sort-code', fixture: 'sort-code-variations.txt', Validator: SortCodeValidator },
    { name: 'email', fixture: 'email-variations.txt', Validator: EmailValidator }
];

function runCorpus(fixtureFile, Validator) {
    const entries = parseVariations(path.join(__dirname, '..', fixtureFile));
    const validator = new Validator();
    return entries.map(({ section, value }) => {
        const r = validator.validate(value);
        return { section, value, isValid: r.isValid, fixed: r.fixed || null, error: r.error || null };
    });
}

for (const { name, fixture, Validator } of suites) {
    test(`${name} corpus (${fixture}) matches snapshot`, () => {
        const results = runCorpus(fixture, Validator);
        const snapshotPath = path.join(SNAPSHOT_DIR, `${name}.json`);

        if (!fs.existsSync(snapshotPath)) {
            fs.writeFileSync(snapshotPath, JSON.stringify(results, null, 2) + '\n');
            console.log(`  (created new snapshot: tests/snapshots/${name}.json - review it, then re-run)`);
            return;
        }

        const snapshot = JSON.parse(fs.readFileSync(snapshotPath, 'utf8'));

        assert.equal(results.length, snapshot.length,
            `${name}: fixture now has ${results.length} values, snapshot has ${snapshot.length} - ` +
            `delete tests/snapshots/${name}.json to regenerate and review the diff`);

        const diffs = [];
        for (let i = 0; i < results.length; i++) {
            const a = results[i], b = snapshot[i];
            if (a.isValid !== b.isValid || a.fixed !== b.fixed || a.error !== b.error) {
                diffs.push(
                    `  [${a.section}] ${JSON.stringify(a.value)}\n` +
                    `    was:  isValid=${b.isValid} fixed=${JSON.stringify(b.fixed)} error=${JSON.stringify(b.error)}\n` +
                    `    now:  isValid=${a.isValid} fixed=${JSON.stringify(a.fixed)} error=${JSON.stringify(a.error)}`
                );
            }
        }

        assert.equal(diffs.length, 0, `${diffs.length} value(s) changed behavior vs snapshot:\n${diffs.join('\n')}`);
    });
}

test('corpus summary', () => {
    for (const { name, fixture, Validator } of suites) {
        const results = runCorpus(fixture, Validator);
        const valid = results.filter(r => r.isValid).length;
        console.log(`  ${name}: ${valid}/${results.length} valid`);
    }
});
