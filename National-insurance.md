# NIM39110 - National Insurance Numbers (NINOs): Format and Security

## What a NINO looks like

A NINO is made up of **2 letters, 6 numbers and a final letter**, which is always **A, B, C, or D**.

It looks something like this:

```
QQ 12 34 56 A
```

> **Note:** This is an example only and should not be used as an actual number.

## The Prefix

Currently a prefix is chosen and then used until all the possible numbers have been allocated. Then another prefix is used, but not necessarily the next one alphabetically.

All prefixes are valid **except**:

- The characters **D, F, I, Q, U, and V** are not used as either the first or second letter of a NINO prefix.
- The letter **O** is not used as the second letter of a prefix.
- Prefixes **BG, GB, KN, NK, NT, TN and ZZ** are not to be used

## The Suffix

The suffix dates back to when contributions were recorded on cards which were returned annually, staggered throughout the tax year:

- **A** meant the card was to be returned in March
- **B** in June
- **C** in September
- **D** in December

Although contribution cards are no longer used, the suffix has remained an integral part of the NINO.

## Temporary Reference Number (TRN)

It is sometimes necessary to use a TRN for Individuals. The format of a TRN is:

```
11 a1 11 11
```

The TRN is an HMRC reference number which allows the individual to pay tax/NICs - **it is not a NINO**. A TRN will not allow the customer to access benefits and other services which use the NINO. The individual will need to apply to DWP for a NINO.

## Administrative Numbers and Temporary Numbers

> **Important:** Temporary Numbers are no longer used.

For administrative reasons, it has sometimes been necessary for HMRC and DWP to use reference numbers which look like NINOs but which do not use valid prefixes. The administrative prefixes used include:

### OO
This "prefix" is used for temporarily administering Tax Credits where no NINO is held at the start of the tax credit claim. The customer should already have applied for a valid UK NINO.

### FY
Previously used for Attendance Allowance claims.

### NC
Was used for Stakeholder Pensions, a scheme administrator may have allocated an in-year dummy identifier beginning 'NC' followed by six numbers based on the date of birth and ending with 'm' or 'f' for the gender. This has not been used since 2005-2006.

### PP
The `PP999999P` reference was used in past pension scheme reporting. PP is a valid prefix but `PP999999P` should not be used as a NINO.

### PZ
Former Inland Revenue processing used PZ and PY as administrative numbers from the 1970s for tax-only cases, but these have not been used since August 2002.

### TN
These are **Temporary Numbers** which were used by employers and DWP when they did not know an individual's NINO.

> **⚠️ Critical:** Employers are **no longer permitted** to use TN numbers and they will not be accepted by the Quality Standard. If the employer does not know an employee's NINO when they submit their return, they should:
> - Leave the NINO box blank
> - Enter the employee's date of birth and gender in the appropriate boxes
> - Follow the Employers' Guidance, or check the HMRC internet site