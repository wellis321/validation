// Regression tests for fileProcessor.js's UTF-8 BOM handling.
// FileReader is a browser-only API, so we stub just enough of it to drive
// the real readTextFile/readJsonFile methods end-to-end.

const { test, describe } = require('node:test');
const assert = require('node:assert/strict');
const { FileProcessor } = require('../fileProcessor.js');

class FakeFileReader {
    readAsText(file) {
        queueMicrotask(() => {
            if (this.onload) this.onload({ target: { result: file.content } });
        });
    }
}

function fakeFile(content) {
    return { content };
}

describe('FileProcessor BOM handling', () => {
    test('regression: UTF-8 BOM is stripped from CSV text so it does not corrupt the first header', async () => {
        global.FileReader = FakeFileReader;
        const processor = new FileProcessor();
        const bomPrefixed = '﻿Phone,Postcode\n07700900123,SW1A 1AA';

        const result = await new Promise((resolve, reject) => {
            processor.readTextFile(fakeFile(bomPrefixed), resolve, reject);
        });

        assert.equal(result.charCodeAt(0), 'P'.charCodeAt(0));
        assert.equal(result.split('\n')[0], 'Phone,Postcode');
    });

    test('CSV text without a BOM is left untouched', async () => {
        global.FileReader = FakeFileReader;
        const processor = new FileProcessor();
        const plain = 'Phone,Postcode\n07700900123,SW1A 1AA';

        const result = await new Promise((resolve, reject) => {
            processor.readTextFile(fakeFile(plain), resolve, reject);
        });

        assert.equal(result, plain);
    });

    test('regression: UTF-8 BOM in JSON no longer throws a SyntaxError', async () => {
        global.FileReader = FakeFileReader;
        const processor = new FileProcessor();
        const bomPrefixed = '﻿{"rows":[{"phone":"07700900123"}]}';

        const result = await new Promise((resolve, reject) => {
            processor.readJsonFile(fakeFile(bomPrefixed), resolve, reject);
        });

        assert.deepEqual(result.data, { rows: [{ phone: '07700900123' }] });
    });
});
