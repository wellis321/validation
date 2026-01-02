# Why These NI Numbers Are Invalid

## The Issue

The NI numbers in your `issues.csv` file are being **correctly flagged as invalid** according to UK HMRC (Her Majesty's Revenue and Customs) standards.

## HMRC Validation Rules

UK National Insurance numbers follow strict rules about which letters can appear in the prefix (first 2 letters):

### Invalid First Letters
The first letter of an NI number **cannot** be:
- **D** - Not used in NI prefixes
- **F** - Not used in NI prefixes
- **I** - Not used in NI prefixes
- **Q** - Not used in NI prefixes
- **U** - Not used in NI prefixes
- **V** - Not used in NI prefixes

### Invalid Second Letters
The second letter of an NI number **cannot** be:
- **D** - Not used in NI prefixes
- **F** - Not used in NI prefixes
- **I** - Not used in NI prefixes
- **O** - Not used in NI prefixes (to avoid confusion with zero)
- **Q** - Not used in NI prefixes
- **U** - Not used in NI prefixes
- **V** - Not used in NI prefixes

### Banned Prefixes
These complete prefixes are banned:
- BG, GB, KN, NK, NT, TN, ZZ

### Administrative Prefixes (Not Valid NI Numbers)
- OO, FY, NC, PZ

## Your Invalid NI Numbers

| NI Number | Prefix | Issue | Reason |
|-----------|--------|-------|--------|
| CD234567D | **CD** | ❌ Invalid | Second letter "D" is not allowed |
| EF345678E | **EF** | ❌ Invalid | Second letter "F" is not allowed |
| IJ567890G | **IJ** | ❌ Invalid | First letter "I" is not allowed |
| QR901234K | **QR** | ❌ Invalid | First letter "Q" is not allowed |
| UV123456M | **UV** | ❌ Invalid | First letter "U" is not allowed |
| CD567890Q | **CD** | ❌ Invalid | Second letter "D" is not allowed |
| EF678901R | **EF** | ❌ Invalid | Second letter "F" is not allowed |
| IJ890123T | **IJ** | ❌ Invalid | First letter "I" is not allowed |

## Why These Rules Exist

These restrictions exist because:
1. **HMRC Standards**: The UK government has specific rules about which letter combinations can be used in NI numbers
2. **Avoid Confusion**: Letters like "O" are excluded to avoid confusion with zero
3. **Administrative Use**: Some prefixes are reserved for administrative purposes (like OO, FY, NC, PZ)
4. **Data Integrity**: These rules help ensure data quality and prevent invalid NI numbers from being used

## Valid NI Number Examples

✅ **Valid prefixes** (examples):
- AB, AC, AD, AE, AG, AH, AJ, AK, AL, AM, AN, AP, AR, AS, AT, AW, AX, AY, AZ
- BA, BB, BC, BD, BE, BG, BH, BJ, BK, BL, BM, BN, BP, BR, BS, BT, BW, BX, BY, BZ
- CA, CB, CC, CE, CG, CH, CJ, CK, CL, CM, CN, CP, CR, CS, CT, CW, CX, CY, CZ
- ... and many more

## What This Means

The application is working **correctly**. These NI numbers are genuinely invalid according to UK government standards and should be flagged. If these are real data, you may need to:

1. **Verify the source** - Check if these NI numbers were entered incorrectly
2. **Contact data providers** - If this is third-party data, report the issue
3. **Manual review** - These may need to be corrected manually or verified with the individuals

## Testing Valid NI Numbers

If you want to test with valid NI numbers, try these examples:
- AB123456C ✅
- AC234567D ✅ (Note: "D" is valid as the **last** letter, just not in the prefix)
- CE345678E ✅
- GH456789F ✅

