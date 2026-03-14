#!/usr/bin/env node
/**
 * Generates sample-data-very-large.csv with many rows for stress/performance testing.
 * Includes all data types including Email (valid, typos, invalid).
 * Run: node generate-large-sample.js
 */

const fs = require('fs');
const path = require('path');

const ROWS = 10000; // target row count (excluding header)

const NAMES = [
  'Mr. John Smith', 'Mrs. Jane Doe', 'Dr. Bob Johnson', 'Alice Brown', 'Prof. Charlie Wilson',
  'David Lee', 'Miss Emma Davis', 'Frank Miller', 'Ms. Grace Taylor', 'Henry White',
  'Sarah Green', 'Michael Brown', 'Lisa Johnson', 'Robert Davis', 'Jennifer Wilson',
  'William Lee', 'Patricia Miller', 'James Taylor', 'Mary White', 'Richard Green'
];

// Email variants: valid, typos (gmial, gmail.con, etc.), invalid
const EMAIL_LOCAL = ['user', 'john', 'jane', 'bob', 'alice', 'contact', 'info', 'support', 'sales'];
const EMAIL_DOMAINS_VALID = ['example.com', 'company.co.uk', 'test.org'];
const EMAIL_DOMAINS_TYPO = ['gmial.com', 'gmail.con', 'gmai.com', 'yaho.com', 'hotmial.com', 'outlok.com', 'icloud.con'];
const EMAIL_INVALID = ['user@example', 'no-at-sign', 'user@', '@example.com', ''];

const PHONES = ['020 7946 0958', '+44 20 7946 0958', '02079460958', '07700 900123', '07700900123'];
const MOBILES = ['07700 900123', '07700900123', '07700 900 123', '07700-900-123'];
const NIS = ['AB123456C', 'CD234567D', 'EF345678E', 'GH456789F', 'IJ567890G', 'KL678901H'];
const POSTCODES = ['SW1A 1AA', 'sw1a1aa', 'M1 1AA', 'EC1A 1BB', 'W1A 1AA', 'CR2 6XH', 'M60 1AA'];
const SORT_CODES = ['12-34-56', '123456', '23 45 67', '34.56.78', '45-67-89'];
const BANK_ACCTS = ['12345678', '23456789', '34567890', '45678901', '56789012'];
const ADDRESSES = ['10 Downing Street', '123 Main Street', '456 High Street', '789 Park Avenue', '321 Oak Road'];

function pick(arr) { return arr[Math.floor(Math.random() * arr.length)]; }
function pickIndex(arr) { return Math.floor(Math.random() * arr.length); }

function emailForRow(i) {
  const k = i % 20;
  if (k < 12) {
    return `${EMAIL_LOCAL[i % EMAIL_LOCAL.length]}${i}@${pick(EMAIL_DOMAINS_VALID)}`;
  }
  if (k < 18) {
    const local = EMAIL_LOCAL[i % EMAIL_LOCAL.length] + i;
    return `${local}@${pick(EMAIL_DOMAINS_TYPO)}`;
  }
  return pick(EMAIL_INVALID);
}

const header = 'ID,Name,Email,Phone Number,Mobile,National Insurance,Postcode,Sort Code,Bank Account,Address,Notes';
const lines = [header];

for (let i = 1; i <= ROWS; i++) {
  const name = NAMES[(i - 1) % NAMES.length];
  const email = emailForRow(i);
  const phone = pick(PHONES);
  const mobile = pick(MOBILES);
  const ni = pick(NIS);
  const postcode = pick(POSTCODES);
  const sortCode = pick(SORT_CODES);
  const bank = pick(BANK_ACCTS);
  const address = pick(ADDRESSES);
  const notes = i % 100 === 0 ? 'Sample row ' + i : '';
  const row = [i, `"${name.replace(/"/g, '""')}"`, `"${String(email).replace(/"/g, '""')}"`, phone, mobile, ni, postcode, sortCode, bank, `"${address}"`, `"${notes}"`].join(',');
  lines.push(row);
}

const outPath = path.join(__dirname, 'sample-data-very-large.csv');
fs.writeFileSync(outPath, lines.join('\n'), 'utf8');
console.log('Wrote', outPath, 'with', ROWS, 'data rows (+ 1 header).');
